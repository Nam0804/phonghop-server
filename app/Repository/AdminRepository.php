<?php
namespace App\Repository;

use App\Models\Admin;
use App\Repository\interface\BaseAdminRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminRepository implements BaseAdminRepository
{
    protected $user;
    public function list(): LengthAwarePaginator
    {
        return Admin::paginate(10);
    }

    public function create(array $data): Admin
    {
        return Admin::create($data);
    }

    public function update(array $data, string $id): bool
    {
        return Admin::findOrFail($id)->update($data);
    }

    public function delete(string $id): bool
    {
        return Admin::findOrFail($id)->delete();
    }

    public function show(string $id): Admin
    {
        return Admin::findOrFail($id);
    }

}
