<?php

namespace App\Http\Controllers\Api\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingLoggedRequest;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingNoteResource;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookingWithRegisterResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\MeetingNoteResource;
use App\Repository\GuestRepository;
use App\Repository\interface\BaseBookingRepository;
use App\Repository\interface\BaseMaterialRepository;
use App\Repository\interface\BaseMeetingRoomRepository;
use App\Repository\interface\BaseUserRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookingController extends Controller
{
    use HttpResponses;
    protected $booking, $guest, $user, $meeting_room, $materials;
    public function __construct(BaseBookingRepository $booking, GuestRepository $guest, BaseUserRepository $user, BaseMeetingRoomRepository $meeting_room, BaseMaterialRepository $materials)
    {
        $this->booking = $booking;
        $this->guest = $guest;
        $this->user = $user;
        $this->meeting_room = $meeting_room;
        $this->materials = $materials;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking_list = $this->booking->list();
        if ($booking_list) {
            return $this->success(BookingResource::collection($booking_list), 'Booking list retrieved successfully'
            , 200);
        } else {
            return $this->error(null, 'Booking list not found', 404);
        }
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
            $valid_time = $this->booking->checkTime($request->from_time, $request->to_time, $request->meeting_room_id);
            if (!$valid_time) {
                return $this->error(null, 'Booking time not available', 404);
            }
            $material_paths = [];

            $booking = $this->booking->create([
                'meeting_room_id' => $request->meeting_room_id,
                'from_time' => $request->from_time,
                'to_time' => $request->to_time,
                'topic' => $request->topic,
                'type_of_booking' => $request->type_of_booking,
                'agenda' => $request->agenda,
                'objective' => $request->objective,
                'register_status' => $request->register_status,
                'repeat_type' => $request->repeat_type,
                'sharing_confirmation' => $request->sharing_confirmation,
                'booking_name' => $request->booking_name,
                'booking_email' => $request->booking_email,
                'booking_title' => $request->booking_title,
                'booking_company' => $request->booking_company,
                'sharing_confirmation' => $request->sharing_confirmation,
            ]);
            if (Auth::user()) {
                $booking->users()->attach(Auth::user());
            }

            // Create guests associated with the meeting
            $guestEmails = $request->guests;
            if ($request->material) {
                foreach ($request->material as $item) {
                    $material = [
                        'booking_id' => $booking->id,
                        'material_path' => $item->store('public/material'),
                    ];
                    $this->materials->create($material);
                }
            }
            if ($guestEmails) {
                foreach ($guestEmails as $email) {
                    $guestData = [
                        'email' => $email,
                        'booking_id' => $booking->id,
                    ];
                    $this->guest->create($guestData);
                }
            }

            if ($request->register_status == 1) {
                $user = $this->user->create([
                    'name' => $request->booking_name,
                    'email' => $request->booking_email,
                    'password' => Hash::make($request->password),
                    'type' => 2,
                    'phone' => $request->phone,
                    'title' => $request->booking_title,
                    'company_id' => $this->meeting_room->show($request->meeting_room_id)->company_id,
                    'is_first_login' => 1,
                ]);
                if ($user) {
                    $booking->users()->attach($user);
                    DB::commit();
                    return $this->success(['booking'=>new BookingResource($booking),'user'=> new UserResource($user)],'Booking created successfully', 200);
                }
            }
            // If everything is successful, commit the transaction
            DB::commit();

            return $this->success( new BookingResource($booking), 'Booking created successfully', 200);
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            DB::rollBack();
            return $this->error(null, 'Booking not created', 404);
        }
    }

    // Logged in user
    public function loggedStore(BookingLoggedRequest $request)
    {
        $request->validated($request->all());
        $loggedIn = Auth::user();
        if (!$loggedIn) {
            return $this->error(null, 'User does not logged in', 404);
        }
        DB::beginTransaction();
        try {
            $valid_time = $this->booking->checkTime($request->from_time, $request->to_time, $request->meeting_room_id);
            if (!$valid_time) {
                return $this->error(null, 'Booking time not available', 404);
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
                'register_status' => 0,
                'repeat_type' => $request->repeat_type,
                'booking_name' => $loggedIn->name,
                'booking_email' => $loggedIn->email,
                'booking_title' => $loggedIn->title,
                'booking_company' => $loggedIn->company_id,
                'sharing_confirmation' => 1,
            ]);
            if (Auth::user()) {
                $booking->users()->attach(Auth::user());
            }
            if ($request->material) {
                foreach ($request->material as $item) {
                    $material = [
                        'booking_id' => $booking->id,
                        'material_path' => $item->store('public/material'),
                    ];
                    $this->materials->create($material);
                }
            }
            // Create guests associated with the meeting
            $guestEmails = $request->guests;
            if ($guestEmails) {
                foreach ($guestEmails as $email) {
                    $guestData = [
                        'email' => $email,
                        'booking_id' => $booking->id,
                    ];
                    $this->guest->create($guestData);
                }
            }

            // If everything is successful, commit the transaction
            DB::commit();

            return $this->success( new BookingResource($booking), 'Booking created successfully', 200);
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            DB::rollBack();
            return $this->error(null, 'Booking not created', 404);
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
            return $this->success( new BookingResource($booking),'Booking retrieved successfully', 200);
        } else {
            return $this->error(null, 'Booking not found', 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = $this->booking->update($request->all(), $id);
        if ($booking) {
            return $this->success( new BookingResource($booking),'Booking updated successfully', 200);
        } else {
            return $this->error(null, 'Booking not updated', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = $this->booking->delete($id);
        if ($booking) {
            return $this->success( new BookingResource($booking),'Booking deleted successfully',200);
        } else {
            return $this->error(null, 'Booking not deleted', 404);
        }
    }

    public function bookingHistory()
    {
        $user_id = Auth::user()->id;
        $booking_list = $this->user->bookingHistory($user_id);
        if ($booking_list) {
            return $this->success( BookingResource::collection($booking_list),'Booking history retrieved successfully', 200);
        } else {
            return $this->error(null, 'Booking history not found', 404);
        }
    }
    public function meetingNotes($booking_id){
        $meeting_notes = $this->booking->meetingNotes($booking_id);
        return BookingNoteResource::collection($meeting_notes);
    }

    public function createMeetingNotes(Request $request,$booking_id){
        $booking = $this->booking->show($booking_id);
        if ($booking) {
            $meeting_note = $booking->meeting_notes()->create([
                'user_id' => Auth::user()->id,
                'note' => $request->note,
            ]);
            if ($meeting_note) {
                return $this->success( new MeetingNoteResource($meeting_note), 'Meeting note created successfully', 200);
            }else{
                return $this->error(null,'Meeting note not created', 404);
            }
        }else{
            return $this->error(null,'Booking not found', 404);
        }
    }
}
