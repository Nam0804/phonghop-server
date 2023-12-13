<?php

namespace App\Http\Controllers\Api\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookingWithRegisterResource;
use App\Models\MeetingRoom;
use App\Repository\GuestRepository;
use App\Repository\interface\BaseBookingRepository;
use App\Repository\interface\BaseMeetingRoomRepository;
use App\Repository\interface\BaseUserRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookingController extends Controller
{
    use HttpResponses;
    protected $booking,$guest,$user,$meeting_room;
    public function __construct(BaseBookingRepository $booking,GuestRepository $guest,BaseUserRepository $user,BaseMeetingRoomRepository $meeting_room)
    {
        $this->booking = $booking;
        $this->guest = $guest;
        $this->user = $user;
        $this->meeting_room = $meeting_room;
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
        DB::beginTransaction();
        try {
            $valid_time = $this->booking->checkTime($request->from_time,$request->to_time,$request->meeting_room_id);
            if (!$valid_time) {
                return $this->error(null,'Booking time not available', 404);
            }
            $booking = $this->booking->create([
                    'meeting_room_id' => $request->meeting_room_id,
                    'from_time' => $request->from_time,
                    'to_time' => $request->to_time,
                    'topic' => $request->topic,
                    'type_of_booking' => $request->type_of_booking,
                    'agenda' => $request->agenda,
                    'objective' => $request->objective,
                    'material' => $request->material,
                    'register_status'=>$request->register_status,
                    'sharing_confirmation' => $request->sharing_confirmation,
                    'booking_name' => $request->booking_name,
                    'booking_email' => $request->booking_email,
                    'booking_title' => $request->booking_title,
                    'booking_company' => $request->booking_company,
                    'sharing_confirmation' => $request->sharing_confirmation,
                ]);

            // Create guests associated with the meeting
            $guestEmails = $request->guests;

            foreach ($guestEmails as $email) {
                $guestData = [
                    'email' => $email,
                    'booking_id' => $booking->id,
                ];
                $this->guest->create($guestData);
            }

            if($request->register_status ==1){
                $user = $this->user->create([
                    'name' => $request->booking_name,
                    'email' => $request->booking_email,
                    'password' => Hash::make($request->password),
                    'type' => 2,
                    'phone' => $request->phone,
                    'title' => $request->booking_title,
                    'company_id' =>$this->meeting_room->companyFromMeetingRoom($request->meeting_room_id),
                    'is_first_login' => 1,
                ]);
                if ($user) {
                    return $this->success([
                        'data' => new BookingWithRegisterResource($booking),
                        'message' => 'Booking created successfully',
                    ], 200);
                }
            }
            // If everything is successful, commit the transaction
            DB::commit();

            return $this->success([
                        'data' => new BookingResource($booking),
                        'message' => 'Booking created successfully',
                    ], 200);
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            DB::rollBack();
            dd($e);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = $this->booking->update($request->all(), $id);
        if ($booking) {
            return $this->success([
                'data' => new BookingResource($booking),
                'message' => 'Booking updated successfully',
            ], 200);
        }else{
            return $this->error(null,'Booking not updated', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
