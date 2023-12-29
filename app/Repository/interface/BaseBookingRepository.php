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
    public function checkTime(string $from_time,string $to_time,string $meeting_room_id): bool;
    public function meetingNotes(string $id): LengthAwarePaginator;

}
