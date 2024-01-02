<?php
namespace App\Repository\interface;

use App\Models\Material;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseMaterialRepository
{
    public function list(): LengthAwarePaginator;
    public function create(array $data): Material;
}
