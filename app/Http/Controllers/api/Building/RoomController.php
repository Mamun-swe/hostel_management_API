<?php

namespace App\Http\Controllers\api\Building;

use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::paginate(10);
        return response()->json($rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = false;
        $rules = [
            'building_id' => 'required',
            'floor_id' => 'required',
            'room_number' => 'required|unique:rooms',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'building_id' => $request->building_id,
                'floor_id' => $request->floor_id,
                'room_number' => $request->room_number,
                'status' => $request->status,
            );

            Room::create($form_data);
            $valid = true;
            
            if($valid == true) {
                return response()->json(['message' => 'success' ], 200);
            } else {
                return response()->json(['message' => 'failed'], 204);
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);
        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valid = false;
        $rules = [
            'building_id' => 'required',
            'floor_id' => 'required',
            'room_number' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'building_id' => $request->building_id,
                'floor_id' => $request->floor_id,
                'room_number' => $request->room_number,
                'status' => $request->status,
            );

            $record = Room::find($id);
            $record->update($request->all());
            $valid = true;
            
            if($valid == true) {
                return response()->json(['message' => 'success' ], 200);
            } else {
                return response()->json(['message' => 'failed'], 204);
            }
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $valid = false;

        Room::where('id', '=', $id)->delete();
        $valid = true;
            
        if($valid == true) {
            return response()->json(['message' => 'success' ], 200);
        } else {
            return response()->json(['message' => 'failed'], 204);
        }
    }
}
