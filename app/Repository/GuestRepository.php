<?php
namespace App\Repository;

use App\Models\Guest;
use App\Repository\interface\BaseGuestRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class GuestRepository implements BaseGuestRepository
{
    public function list(): LengthAwarePaginator
    {
        return Guest::paginate(10);
    }

    public function create(array $data): Guest
    {
        return Guest::create($data);
    }
}
