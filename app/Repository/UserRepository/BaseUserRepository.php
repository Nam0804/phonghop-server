<?php
namespace App\Repository\UserRepository;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseUserRepository
{
    public function list(): LengthAwarePaginator;
    public function create(array $data): User;
    public function update(array $data, string $id): bool;
    public function delete(string $id): bool;
    public function show(string $id): User;
    public function confirmAccount(string $id): bool;

}
