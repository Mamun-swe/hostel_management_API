<?php

namespace App\Http\Controllers\api\Payment;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::join('students', 'students.id', '=', 'payments.student_id')
                    ->paginate(20);
        return response()->json($payments);
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
            'admin_id' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'reference' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'student_id' => $request->student_id,
                'admin_id' => $request->admin_id,
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'reference' => $request->reference,
            );

            Payment::create($form_data);
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
        $payment = Payment::join('students', 'students.id', '=', 'payments.student_id')
                    ->where('payments.id', '=', $id)->first();
        return response()->json($payment);
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
            'admin_id' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'reference' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'student_id' => $request->student_id,
                'admin_id' => $request->admin_id,
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'reference' => $request->reference,
            );

            $record = Payment::find($id);
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

        Payment::where('id', '=', $id)->delete();
        $valid = true;
            
        if($valid == true) {
            return response()->json(['message' => 'success' ], 200);
        } else {
            return response()->json(['message' => 'failed'], 204);
        }
    }
}
