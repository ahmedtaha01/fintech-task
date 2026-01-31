<?php

namespace App\Contracts\Repositories;

use App\Models\Account;

interface AccountRepositoryInterface
{
    /**
     * Get all accounts for a user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(int $userId);

    /**
     * Find an account by ID.
     *
     * @param int $id
     * @return Account|null
     */
    public function find(int $id): ?Account;

    /**
     * Find an account by ID and lock it for update.
     *
     * @param int $id
     * @return Account|null
     */
    public function findForUpdate(int $id): ?Account;

    /**
     * Create a new account.
     *
     * @param array $data
     * @return Account
     */
    public function create(array $data): Account;

    /**
     * Update an account.
     *
     * @param int $id
     * @param array $data
     * @return Account
     */
    public function update(int $id, array $data): Account;

    /**
     * Delete an account (soft delete).
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}

