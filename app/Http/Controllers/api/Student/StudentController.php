<?php

namespace App\Http\Controllers\api\Student;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::paginate(10);
        return response()->json($students);
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
            'room_id' => 'required',
            'admin_id' => 'required',
            'name' => 'required',
            'own_mobile_number' => 'required|unique:students|regex:/(01)[0-9]{9}/',
            'parents_mobile_number' => 'required|regex:/(01)[0-9]{9}/',
            'advance_amount' => 'required',
            'due_amount' => 'required',
            'admission_date' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'room_id' => $request->room_id,
                'admin_id' => $request->admin_id,
                'name' => $request->name,
                'own_mobile_number' => $request->own_mobile_number,
                'parents_mobile_number' => $request->parents_mobile_number,
                'advance_amount' => $request->advance_amount,
                'due_amount' => $request->due_amount,
                'admission_date' => $request->admission_date,
                'status' => $request->status,
            );

            Student::create($form_data);
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
        $student = Student::find($id);
        return response()->json($student);
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
            'room_id' => 'required',
            'admin_id' => 'required',
            'name' => 'required',
            'own_mobile_number' => 'required|unique:students|regex:/(01)[0-9]{9}/',
            'parents_mobile_number' => 'required|regex:/(01)[0-9]{9}/',
            'advance_amount' => 'required',
            'due_amount' => 'required',
            'admission_date' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'room_id' => $request->room_id,
                'admin_id' => $request->admin_id,
                'name' => $request->name,
                'own_mobile_number' => $request->own_mobile_number,
                'parents_mobile_number' => $request->parents_mobile_number,
                'advance_amount' => $request->advance_amount,
                'due_amount' => $request->due_amount,
                'admission_date' => $request->admission_date,
                'status' => $request->status,
            );

            $record = Student::find($id);
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

        Student::where('id', '=', $id)->delete();
        $valid = true;
            
        if($valid == true) {
            return response()->json(['message' => 'success' ], 200);
        } else {
            return response()->json(['message' => 'failed'], 204);
        }
    }
}
