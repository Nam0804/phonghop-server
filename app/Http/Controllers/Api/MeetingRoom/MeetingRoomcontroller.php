<?php

namespace App\Http\Controllers\Api\MeetingRoom;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingRoomRequest;
use App\Http\Resources\MeetingRoomResource;
use App\Repository\interface\BaseMeetingRoomRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if(auth()->user()->can('show-all-meeting-rooms')){
            $company_id = Auth::user()->company_id;
            $meetingRooms = $this->meetingRoom->list($company_id);
            return $meetingRooms;
        }else{
            abort(403, 'You need permission to do this action.');
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeetingRoomRequest $request)
    {
        if(auth()->user()->can('add-meeting-rooms')){
            $request->validated($request->all());
            if ($request->hasFile('image')) {
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
            }
            else{
                $meetingRoom = $this->meetingRoom->create([
                    'name' => $request->name,
                    'location' => $request->location,
                    'floor' => $request->floor,
                    'capacity' => $request->capacity,
                    'equipment' => $request->equipment,
                    'availability' => $request->availability,
                    'company_id' => $request->company_id,
                ]);
            }

            if ($meetingRoom) {
                return $this->success([
                    'data' => new MeetingRoomResource($meetingRoom),
                    'message' => 'Meeting Room created successfully',
                ], 200);
            }else{
                return $this->error(null,'Meeting Room not created', 400);
            }
        }else{
            abort(403, 'You need permission to do this action.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(auth()->user()->can('show-meeting-rooms')){
            $meetingRoom = $this->meetingRoom->show($id);
            if ($meetingRoom) {
                return $this->success([
                    'data' => new MeetingRoomResource($meetingRoom),
                    'message' => 'Meeting Room found successfully',
                ], 200);
            } else {
                return $this->error(null, 'Meeting Room not found', 400);
            }
        }else{
            abort(403, 'You need permission to do this action.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(auth()->user()->can('update-meeting-rooms')){
            $meetingRoom = $this->meetingRoom->update($request->all(), $id);
            if ($meetingRoom) {
                return $this->success([
                    'data' => new MeetingRoomResource($meetingRoom),
                    'message' => 'Meeting Room updated successfully',
                ], 200);
            } else {
                return $this->error(null, 'Meeting Room not updated', 400);
            }
        }else{
            abort(403, 'You need permission to do this action.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->user()->can('delete-meeting-rooms')){
            //logic for this function
        }else{
            abort(403, 'You need permission to do this action.');
        }
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
