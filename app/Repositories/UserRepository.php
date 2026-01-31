<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get all users.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return User::all(['id', 'name', 'email', 'phone']);
    }

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        $user = User::find($id, ['id', 'name', 'email', 'phone']);

        if (!$user) {
            throw new Exception("User not found with ID: {$id}");
        }

        return $user;
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update a user.
     *
     * @param int $id
     * @param array $data
     * @return User
     */
    public function update(int $id, array $data): User
    {
        $user = $this->find($id);
        
        $user->update($data);
        
        return $user->fresh();
    }

    /**
     * Delete a user (soft delete).
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $user = $this->find($id);

        return $user->delete();
    }

    /**
     * Check if a user exists.
     *
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool
    {
        $exists = User::where('id', $id)->whereNull('deleted_at')->exists();

        if (!$exists) {
            throw new Exception("User not found with ID: {$id}");
        }

        return $exists;
    }
}

