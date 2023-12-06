<?php
namespace App\Repository\interface;

use App\Models\MeetingRoom;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseMeetingRoomRepository
{
    public function list(): LengthAwarePaginator;
    public function create(array $data): MeetingRoom;
    public function update(array $data, string $id): bool;
    public function delete(string $id): bool;
    public function show(string $id): MeetingRoom;
    public function CompanyMeetingRooms(string $id): LengthAwarePaginator;
}
