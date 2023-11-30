<?php
namespace App\Repository\AdminRepository;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseAdminRepository
{
    public function list(): LengthAwarePaginator;
    public function create(array $data): User;
    public function update(array $data, string $id): bool;
    public function delete(string $id): bool;
    public function show(string $id): User;

}
