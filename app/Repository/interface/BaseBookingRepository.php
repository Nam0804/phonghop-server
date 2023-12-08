<?php
namespace App\Repository\interface;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseBookingRepository
{
    public function list(): LengthAwarePaginator;
    public function create(array $data): Booking;
    public function update(array $data, string $id): bool;
    public function delete(string $id): bool;
    public function show(string $id): Booking;
    public function addGuest(array $data): bool;
}
