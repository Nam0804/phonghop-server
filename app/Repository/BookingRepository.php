<?php
namespace App\Repository;

use App\Models\Booking;
use App\Repository\interface\BaseBookingRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository implements BaseBookingRepository
{
    public function list(): LengthAwarePaginator
    {
        return Booking::paginate(10);
    }

    public function create(array $data): Booking
    {
        return Booking::create($data);
    }

    public function update(array $data, string $id): bool
    {
        return Booking::findOrFail($id)->update($data);
    }

    public function delete(string $id): bool
    {
        return Booking::findOrFail($id)->delete();
    }

    public function show(string $id): Booking
    {
        return Booking::findOrFail($id);
    }

    public function CompanyBookings(string $id): LengthAwarePaginator
    {
        return Booking::where('company_id', $id)->paginate(10);
    }

    public function checkTime(string $from_time, string $to_time, string $meeting_room_id): bool
    {
        $booking_inrange = Booking::where('meeting_room_id', $meeting_room_id)
            ->where('from_time', '<=', $from_time)
            ->where('to_time', '>=', $to_time)
            ->first();
        $booking_overrange = Booking::where('meeting_room_id', $meeting_room_id)
            ->where('from_time', '>=', $from_time)
            ->where('to_time', '<=', $to_time)
            ->first();
        $booking_start = Booking::where('meeting_room_id', $meeting_room_id)
            ->where('from_time', '<=', $from_time)
            ->where('to_time', '>=', $from_time)
            ->first();
        $booking_end= Booking::where('meeting_room_id', $meeting_room_id)
            ->where('from_time', '<=', $to_time)
            ->where('to_time', '>=', $to_time)
            ->first();
        if ($booking_inrange || $booking_overrange ||$booking_start ||$booking_end) {
            return false;
        }
        return true;
    }


}
