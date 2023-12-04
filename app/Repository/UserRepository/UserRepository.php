<?php
namespace App\Repository\UserRepository;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function  CompanyUsers(string $company_id): LengthAwarePaginator
    {
        return User::where('company_id',$company_id)->where('type','!=',1)->paginate(10);
    }

    public function confirmAccount(string $token): bool
    {
        return User::where('email_verified_token', $token)->update(['is_first_login' => 0,'email_verified_at' => now(),'email_verified_token' => null]);
    }
}
