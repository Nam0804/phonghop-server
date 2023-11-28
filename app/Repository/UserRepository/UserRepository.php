<?php
namespace App\Repository;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repository\BaseUserRepository;

class UserRepository implements BaseUserRepository
{
    protected $user;
    public function list(): LengthAwarePaginator
    {
        return User::paginate(10);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(array $data, string $id): bool
    {
        return User::findOrFail($id)->update($data);
    }

    public function delete(string $id): bool
    {
        return User::findOrFail($id)->delete();
    }

    public function show(string $id): User
    {
        return User::findOrFail($id);
    }
}
