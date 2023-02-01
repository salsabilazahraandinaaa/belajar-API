<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\resourcess\studentsresource;
use App\Models\students;
use Illuminate\Http\Request;

class studentscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = students:: all();
        
        return new studentsresource (true, 'data students !', $students);
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idnumber' => 'required|unique:students,idnumber',
            'fullname' => 'required',
            'gender' => 'required|numeric|unique:students,phone',
            'address' => 'required',
            'emailaddress' => 'required|email|unique:students,emailaddress'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $students = students::create([
                'idnumber' => $request->idnumber,
                'fullname' => $request->fullname,
                'gender' => $request->gender,
                'address' => $request->address,
                'emailaddress' => $request->emailaddress,
                'phone' => $request->phone,
                'photo' => ''
            ]);

            return new studentsresource (true, 'data berhasil tersimpan !', $students);
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
        $students = $students::find($id);

        if($students){
            return new studentsersource(true, 'data ditemukan !', $students);
        }else{
            return response()->json([
                'message' => 'data not found !'
            ], 422);
        }
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
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'gender' => 'required|numeric|unique:students,phone',
            'address' => 'required',
            'emailaddress' => 'required|email|unique:students,emailaddress'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $students = students::find($id);

            if($students){
                $students -> fullname = $request -> fullname;
                $students -> gender = $request -> gender;
                $students -> phone = $request -> phone;
                $students -> address = $request -> address;
                $students -> emailaddress = $request -> emailaddress;
                $students -> save();

                return new studentsresource (true, 'data berhasil di-update !', $students);
            } else {
                return response()->json([
                    'message' => 'data not found !'
                ]);
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
        $students = students::find($id);

        if($students){
            $students->delete();
            return new studentsresource (true, 'data berhasil di-hapus', '');
        } else {
            return response()->json([
                'message' => 'data not found !'
            ]);
        }
    }
}
