<?php

namespace App\Repositories;

use Exception;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * Create a new transaction.
     *
     * @param array $data
     * @return Transaction
     */
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    /**
     * Get all transactions for a user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return Transaction::where('user_id', $userId)
            ->latest()
            ->get();
    }

    /**
     * Get all transactions where account was sender.
     *
     * @param int $accountId
     * @return Collection
     */
    public function getByAccountIdAsSender(int $accountId): Collection
    {
        return Transaction::where('account_sender_id', $accountId)
            ->latest()
            ->get();
    }

    /**
     * Get all transactions where account was receiver.
     *
     * @param int $accountId
     * @return Collection
     */
    public function getByAccountIdAsReceiver(int $accountId): Collection
    {
        return Transaction::where('account_receiver_id', $accountId)
            ->latest()
            ->get();
    }

    /**
     * Find a transaction by ID.
     *
     * @param int $id
     * @return Transaction|null
     */
    public function find(int $id): ?Transaction
    {
        $transaction = Transaction::find($id);
        
        if (!$transaction) {
            throw new Exception("Transaction not found with ID: {$id}");
        }
        
        return $transaction;
    }
}

