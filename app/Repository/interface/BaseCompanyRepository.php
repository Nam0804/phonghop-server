<?php
namespace App\Repository\interface;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseCompanyRepository
{
    public function list(): LengthAwarePaginator;
    public function create(array $data): Company;
    public function update(array $data, string $id): bool;
    public function delete(string $id): bool;
    public function show(string $id): Company;

}
