<?php

namespace App\Repositories;

use Exception;
use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    /**
     * Get all accounts for a user.
     *
     * @param int $userId
     * @return Collection
     */
    public function all(int $userId): Collection
    {
        return Account::where('user_id', $userId)->get(['id', 'bank_name', 'bank_account_name', 'bank_account_number', 'bank_iban_number', 'balance', 'created_at']);
    }

    /**
     * Find an account by ID.
     *
     * @param int $id
     * @return Account|null
     */
    public function find(int $id): ?Account
    {
        $account = Account::find($id, ['id', 'bank_name', 'user_id','bank_account_name', 'bank_account_number', 'bank_iban_number', 'balance', 'created_at']);
        
        if (!$account) {
            throw new Exception("Account not found with ID: {$id}");
        }
        
        return $account;
    }

    /**
     * Find an account by ID and lock it for update.
     *
     * @param int $id
     * @return Account|null
     */
    public function findForUpdate(int $id): ?Account
    {
        $account = Account::where('id', $id)
            ->lockForUpdate()
            ->first(['id', 'user_id', 'bank_name', 'bank_account_name', 'bank_account_number', 'bank_iban_number', 'balance', 'created_at']);
        
        if (!$account) {
            throw new Exception("Account not found with ID: {$id}");
        }
        
        return $account;
    }

    /**
     * Create a new account.
     *
     * @param array $data
     * @return Account
     */
    public function create(array $data): Account
    {
        return Account::create($data);
    }

    /**
     * Update an account.
     *
     * @param int $id
     * @param array $data
     * @return Account
     */
    public function update(int $id, array $data): Account
    {
        $account = $this->find($id);
        
        $account->update($data);
        
        return $account->fresh();
    }

    /**
     * Delete an account (soft delete).
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $account = $this->find($id);

        return $account->delete();
    }
}

