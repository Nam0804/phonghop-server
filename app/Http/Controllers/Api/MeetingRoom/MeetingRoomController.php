<?php

namespace App\Http\Controllers\Api\MeetingRoom;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingRoomRequest;
use App\Http\Resources\MeetingRoomResource;
use App\Repository\interface\BaseMeetingRoomRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MeetingRoomController extends Controller
{
    use HttpResponses;
    protected $meetingRoom;
    public function __construct(BaseMeetingRoomRepository $meetingRoom)
    {
        $this->meetingRoom = $meetingRoom;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $meetingRooms = $this->meetingRoom->list($company_id);
        if ($meetingRooms) {
            return $this->success(MeetingRoomResource::collection($meetingRooms), 'Meeting Room list retrive successfully', 200);
        } else {
            return $this->error(null, 'Meeting Room not retrive', 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeetingRoomRequest $request)
    {
        $request->validated($request->all());
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = uniqid().'.'.$extension; 
            $image_path = Storage::disk('local')->putFileAs('/public/meeting-room-images', $request->file('image'), $filename);
        } else {
            // Handle case when no image is provided
            $image_path = null;
        }

        $meetingRoom = $this->meetingRoom->create([
            'name' => $request->name,
            'location' => $request->location,
            'floor' => $request->floor,
            'capacity' => $request->capacity,
            'equipment' => $request->equipment,
            'image' => $image_path,
            'availability' => $request->availability,
            'company_id' => $request->company_id,
        ]);

        if ($meetingRoom) {
            return $this->success(new MeetingRoomResource($meetingRoom), 'Meeting Room created successfully', 200);
        } else {
            return $this->error(null, 'Meeting Room not created', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meetingRoom = $this->meetingRoom->show($id);
        if ($meetingRoom) {
            return $this->success(new MeetingRoomResource($meetingRoom), 'Meeting Room found successfully', 200);
        } else {
            return $this->error(null, 'Meeting Room not found', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updated_room = $this->meetingRoom->update($request->all(), $id);
        if ($updated_room) {
            $room = $this->meetingRoom->show($id);
            return $this->success(new MeetingRoomResource($room), 'Meeting Room updated successfully', 200);
        } else {
            return $this->error(null, 'Meeting Room not updated', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //logic for this function
    }
    public function CompanyMeetingRooms()
    {
        $company_id = Auth::user()->company_id;
        $meetingRooms = $this->meetingRoom->CompanyMeetingRooms($company_id);
        if ($meetingRooms) {
            return $this->success(MeetingRoomResource::collection($meetingRooms), null, 200);
        } else {
            return $this->error(null, 'Meeting Rooms not found', 400);
        }
    }
}
