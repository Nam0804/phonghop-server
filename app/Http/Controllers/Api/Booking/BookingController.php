<?php

namespace App\Http\Controllers\Api\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Repository\interface\BaseBookingRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use HttpResponses;
    protected $booking;
    public function __construct(BaseBookingRepository $booking)
    {
        $this->booking = $booking;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking_list = $this->booking->list();
        return BookingResource::collection($booking_list);
    }


    /**
     * Store a newly created resource in storage.
     * Create booking
     */
    public function store(BookingRequest $request)
    {
        $request->validated($request->all());

        $booking = $this->booking->create([
            'meeting_room_id' => $request->meeting_room_id,
            'from_time' => $request->from_time,
            'to_time' => $request->to_time,
            'topic' => $request->topic,
            'type_of_booking' => $request->type_of_booking,
            'guests' => $request->guests,
            'agenda' => $request->agenda,
            'objective' => $request->objective,
            'material' => $request->material,
            'sharing_confirmation' => $request->sharing_confirmation,
            'booking_name' => $request->booking_name,
            'booking_email' => $request->booking_email,
            'booking_title' => $request->booking_title,
            'booking_company' => $request->booking_company,
        ]);
        if ($booking) {
            return $this->success([
                'data' => new BookingResource($booking),
                'message' => 'Booking created successfully',
            ], 200);
        }else{
            return $this->error(null,'Booking not created', 404);
        }
    }

    /**
     * Display the specified resource.
     * Use for show booking detail
     */
    public function show(string $id)
    {
        $booking = $this->booking->show($id);
        if ($booking) {
            return $this->success([
                'data' => new BookingResource($booking),
                'message' => 'Booking retrieved successfully',
            ], 200);
        }else{
            return $this->error(null,'Booking not found', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
