<?php

namespace App\Http\Controllers\Api\MeetingRoom;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingRoomRequest;
use App\Http\Resources\MeetingRoomResource;
use App\Repository\interface\BaseMeetingRoomRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class MeetingRoomcontroller extends Controller
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
        $meetingRooms = $this->meetingRoom->list();
        return $meetingRooms;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeetingRoomRequest $request)
    {
        $request->validated($request->all());
        $image_path = $request->file('image')->store('image', 'public');
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
            return $this->success([
                'data' => new MeetingRoomResource($meetingRoom),
                'message' => 'Meeting Room created successfully',
            ], 200);
        }else{
            return $this->error(null,'Meeting Room not created', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meetingRoom = $this->meetingRoom->show($id);
        if ($meetingRoom) {
            return $this->success([
                'data' => new MeetingRoomResource($meetingRoom),
                'message' => 'Meeting Room found successfully',
            ], 200);
        } else {
            return $this->error(null, 'Meeting Room not found', 400);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $meetingRoom = $this->meetingRoom->update($request->all(), $id);
        if ($meetingRoom) {
            return $this->success([
                'data' => new MeetingRoomResource($meetingRoom),
                'message' => 'Meeting Room updated successfully',
            ], 200);
        } else {
            return $this->error(null, 'Meeting Room not updated', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function CompanyMeetingRooms(string $company_id)
    {
        $meetingRooms = $this->meetingRoom->CompanyMeetingRooms($company_id);
        if ($meetingRooms) {
            return $this->success([
                'data' => MeetingRoomResource::collection($meetingRooms),
                'message' => null,
            ], 200);
        } else {
            return $this->error(null, 'Meeting Rooms not found', 400);
        }
    }
}
