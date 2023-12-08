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

    public function addGuest(array $data): bool
    {
        return Booking::findOrFail($data['booking_id'])->guests()->create($data);
    }

}
