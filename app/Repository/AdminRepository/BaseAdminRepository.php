<?php
namespace App\Repository\AdminRepository;

use App\Models\Admin;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseUserRepository
{
    public function list(): LengthAwarePaginator;
    public function create(array $data): Admin;
    public function update(array $data, string $id): bool;
    public function delete(string $id): bool;
    public function show(string $id): Admin;
    public function confirmAccount(string $id): bool;

}
