<?php

namespace App\Http\Controllers\api\Building;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buildings = Building::paginate(10);
        return response()->json($buildings);
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
            'name' => 'required',
            'address' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'name' => $request->name,
                'address' => $request->address
            );

            Building::create($form_data);
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
        $building = Building::find($id);
        return response()->json($building);
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
            'name' => 'required',
            'address' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'name' => $request->name,
                'address' => $request->address
            );

            $record = Building::find($id);
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

        Building::where('id',$id)->delete();
        Floor::where('building_id', '=', $id)->delete();
        Room::where('building_id', '=', $id)->delete();
        $valid = true;
            
        if($valid == true) {
            return response()->json(['message' => 'success' ], 200);
        } else {
            return response()->json(['message' => 'failed'], 204);
        }
    }
}
