<?php

namespace App\Http\Controllers\api\Building;

use App\Models\Floor;
use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = Floor::paginate(10);
        return response()->json($floors);
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
            'name' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'building_id' => $request->building_id,
                'name' => $request->name
            );

            Floor::create($form_data);
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
        $floor = Floor::find($id);
        return response()->json($floor);
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
            'name' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'building_id' => $request->building_id,
                'name' => $request->name
            );

            $record = Floor::find($id);
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

        Floor::where('id', '=', $id)->delete();
        Room::where('floor_id', '=', $id)->delete();
        $valid = true;
            
        if($valid == true) {
            return response()->json(['message' => 'success' ], 200);
        } else {
            return response()->json(['message' => 'failed'], 204);
        }
    }
}
