<?php
namespace App\Repository;

use App\Models\MeetingRoom;
use App\Repository\interface\BaseMeetingRoomRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class MeetingRoomRepository implements BaseMeetingRoomRepository
{
    public function list(): LengthAwarePaginator
    {
        return MeetingRoom::paginate(10);
    }

    public function create(array $data): MeetingRoom
    {
        return MeetingRoom::create($data);
    }

    public function update(array $data, string $id): bool
    {
        return MeetingRoom::findOrFail($id)->update($data);
    }

    public function delete(string $id): bool
    {
        return MeetingRoom::findOrFail($id)->delete();
    }

    public function show(string $id): MeetingRoom
    {
        return MeetingRoom::findOrFail($id);
    }

    public function CompanyMeetingRooms(string $id): LengthAwarePaginator
    {
        return MeetingRoom::where('company_id', $id)->paginate(10);
    }

}
