<?php

namespace App\Http\Controllers\api\Guest;

use App\Models\Guest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guests = Guest::paginate(10);
        return response()->json($guests);
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
            'student_id' => 'required',
            'name' => 'required',
            'phone_number' => 'required|regex:/(01)[0-9]{9}/',
            'relation' => 'required',
            'check_in_date' => 'required',
            'check_out_date' => 'required',
            'daily_amount' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'student_id' => $request->student_id,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'relation' => $request->relation,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'daily_amount' => $request->daily_amount,
            );

            Guest::create($form_data);
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
        $guest = Guest::join('students', 'students.id', '=', 'guests.student_id')
                    ->where('guests.id', '=', $id)->first();
        return response()->json($guest);
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
            'student_id' => 'required',
            'name' => 'required',
            'phone_number' => 'required|regex:/(01)[0-9]{9}/',
            'relation' => 'required',
            'check_in_date' => 'required',
            'check_out_date' => 'required',
            'daily_amount' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'student_id' => $request->student_id,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'relation' => $request->relation,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'daily_amount' => $request->daily_amount,
            );

            $record = Guest::find($id);
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

        Guest::where('id', '=', $id)->delete();
        $valid = true;
            
        if($valid == true) {
            return response()->json(['message' => 'success' ], 200);
        } else {
            return response()->json(['message' => 'failed'], 204);
        }
    }
}
