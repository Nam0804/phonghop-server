<?php
namespace App\Repository;

use App\Models\Company;
use App\Repository\interface\BaseCompanyRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository implements BaseCompanyRepository
{
    public function list(): LengthAwarePaginator
    {
        return Company::paginate(10);
    }

    public function create(array $data): Company
    {
        return Company::create($data);
    }

    public function update(array $data, string $id): bool
    {
        return Company::findOrFail($id)->update($data);
    }

    public function delete(string $id): bool
    {
        return Company::findOrFail($id)->delete();
    }

    public function show(string $id): Company
    {
        return Company::findOrFail($id);
    }

}
