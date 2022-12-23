<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class StudentController extends Controller
{
    public function create(){
		return view('student.student-form');
	}
	
	public function studentSave(Request $request){
		$validate=$request->validate([
			"name"     => 'required',
			"email"    => 'required',
			"password" => 'required',
			"mobile"   => 'required',
		]);
		
		
		$basic_detail=[
			"name"      => $request->name,
			"email"     => $request->email,
			"password"  => $request->password,
			"mobile"    => $request->mobile,
		];
		
		
		DB::beginTransaction();
		try{
			$sql1=DB::table('students')->insertGetId($basic_detail);
			$student_id=$sql1;
			foreach($request->subject as $key => $value){
				$sql2=DB::table('cources')->insert([
					"student_id"   => $student_id,
					"subject"      => $value,
				]);
			}
		    DB::commit();
			return back()->with('msg','Student create successfully');
		}
		catch(\Exception $e){
			DB::rollback();
			return back()->with('msg','Some Error');
		}
		
	}
}
