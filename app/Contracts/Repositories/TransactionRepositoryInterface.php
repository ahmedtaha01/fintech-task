<?php

namespace App\Contracts\Repositories;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    /**
     * Create a new transaction.
     *
     * @param array $data
     * @return Transaction
     */
    public function create(array $data): Transaction;

    /**
     * Get all transactions for a user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserId(int $userId);

    /**
     * Get all transactions where account was sender.
     *
     * @param int $accountId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByAccountIdAsSender(int $accountId);

    /**
     * Get all transactions where account was receiver.
     *
     * @param int $accountId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByAccountIdAsReceiver(int $accountId);

    /**
     * Find a transaction by ID.
     *
     * @param int $id
     * @return Transaction|null
     */
    public function find(int $id): ?Transaction;
}

