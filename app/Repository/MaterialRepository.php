<?php
namespace App\Repository;

use App\Models\Material;
use App\Repository\interface\BaseMaterialRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class MaterialRepository implements BaseMaterialRepository
{
    public function list(): LengthAwarePaginator
    {
        return Material::paginate(10);
    }

    public function create(array $data): Material
    {
        return Material::create($data);
    }
}
