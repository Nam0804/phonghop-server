<?php
namespace App\Repository\interface;

use App\Models\Guest;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseGuestRepository
{
    public function list(): LengthAwarePaginator;
    public function create(array $data): Guest;
}
