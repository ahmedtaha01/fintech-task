<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Enums\TransactionStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\AccountRepositoryInterface;
use App\Contracts\Repositories\TransactionRepositoryInterface;

class TransactionService
{
    /**
     * The transaction repository instance.
     *
     * @var TransactionRepositoryInterface
     */
    protected TransactionRepositoryInterface $transactionRepository;

    /**
     * The account repository instance.
     *
     * @var AccountRepositoryInterface
     */
    protected AccountRepositoryInterface $accountRepository;

    /**
     * The user repository instance.
     *
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * Create a new service instance.
     *
     * @param TransactionRepositoryInterface $transactionRepository
     * @param AccountRepositoryInterface $accountRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        AccountRepositoryInterface $accountRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Transfer money from one account to another.
     *
     * @param array $data
     * @param int $userId
     * @return Transaction
     * @throws \Exception
     */
    public function transferMoney(array $data, int $userId): Transaction
    {
        // Verify user exists
        $user = $this->userRepository->find($userId);

        // Use database transaction to ensure atomicity
        $transaction = DB::transaction(function () use ($data, $userId) {
            // Get sender account with lock and verify ownership
            $senderAccount = $this->accountRepository->findForUpdate($data['account_sender_id']);

            $this->verifyAccountOwnership($senderAccount, $userId);

            // Validate sender has sufficient balance
            $this->verifyAccountBalance($senderAccount, $data['amount']);

            // Get receiver account with lock
            $receiverAccount = $this->accountRepository->findForUpdate($data['account_receiver_id']);

            // Debit sender account balance
            $this->accountRepository->update($senderAccount->id, [
                'balance' => $senderAccount->balance - $data['amount']
            ]);

            // Credit receiver account balance
            $this->accountRepository->update($receiverAccount->id, [
                'balance' => $receiverAccount->balance + $data['amount']
            ]);

            return $this->transactionRepository->create([
                'transaction_id' => $data['transaction_id'],
                'user_id' => $userId,
                'account_sender_id' => $data['account_sender_id'],
                'account_receiver_id' => $data['account_receiver_id'],
                'amount' => $data['amount'],
                'currency' => $data['currency'],
                'status' => TransactionStatus::success->value,
                'payload' => $data['payload'] ?? null,
            ]);
        });

        return $transaction->refresh();
    }

    /**
     * Get all transactions for a user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserTransactions(int $userId): Collection
    {
        $user = $this->userRepository->find($userId);
        return $this->transactionRepository->getByUserId($user->id);
    }

    /**
     * Get all transactions where account was sender.
     *
     * @param int $accountId
     * @return Collection
     */
    public function getAccountTransactionsAsSender(int $accountId): Collection
    {
        $account = $this->accountRepository->find($accountId);
        return $this->transactionRepository->getByAccountIdAsSender($account->id);
    }

    /**
     * Get all transactions where account was receiver.
     *
     * @param int $accountId
     * @return Collection
     */
    public function getAccountTransactionsAsReceiver(int $accountId): Collection
    {
        $account = $this->accountRepository->find($accountId);
        return $this->transactionRepository->getByAccountIdAsReceiver($account->id);
    }

    /**
     * Verify that the account belongs to the specified user.
     *
     * @param Account $account
     * @param int $userId
     * @return void
     * @throws \Exception
     */
    private function verifyAccountOwnership(Account $account, int $userId): void
    {
        if ($account->user_id != $userId) {
            throw new \Exception('الحساب لا ينتمي إلى هذا المستخدم');
        }
    }

    /**
     * Verify that the account has sufficient balance.
     *
     * @param Account $account
     * @param float $amount
     * @return void
     * @throws \Exception
     */
    private function verifyAccountBalance(Account $account, float $amount): void
    {
        if ($account->balance < $amount) {
            throw new \Exception('رصيد الحساب غير كاف');
        }
    }
}

