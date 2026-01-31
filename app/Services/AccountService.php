<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Contracts\Repositories\AccountRepositoryInterface;

class AccountService
{
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
     * @param AccountRepositoryInterface $accountRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(AccountRepositoryInterface $accountRepository, UserRepositoryInterface $userRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get all accounts for a user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getAllAccounts(int $userId): Collection
    {
        $user = $this->userRepository->find($userId);

        return $this->accountRepository->all($user->id);
    }

    /**
     * Get an account by ID.
     *
     * @param int $id
     * @return Account|null
     */
    public function getAccountById(int $id): ?Account
    {
        $account = $this->accountRepository->find($id);
        return $account;
    }

    /**
     * Create a new account.
     *
     * @param array $data
     * @return Account
     */
    public function createAccount(array $data, int $userId): Account
    {
        $user = $this->userRepository->find($userId);
        return $this->accountRepository->create($data + ['user_id' => $user->id]);
    }

    /**
     * Update an account.
     *
     * @param int $id
     * @param array $data
     * @return Account
     * @throws ModelNotFoundException
     */
    public function updateAccount(int $id, array $data): Account
    {
        return $this->accountRepository->update($id, $data);
    }

    /**
     * Delete an account (soft delete).
     *
     * @param int $id
     * @return bool
     * @throws ModelNotFoundException
     */
    public function deleteAccount(int $id): bool
    {
        return $this->accountRepository->delete($id);
    }

    /**
     * Verify that the account belongs to the specified user.
     *
     * @param Account $account
     * @param int $userId
     * @return void
     * @throws \Exception
     */
    public function verifyAccountOwnership(Account $account, int $userId): void
    {
        if ($account->user_id != $userId) {
            throw new \Exception('الحساب لا ينتمي إلى هذا المستخدم');
        }
    }
}

