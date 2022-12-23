<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use App\Models\Student;
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
		
		if ($request->hasFile('pic'))
		{
			$file = $request->file('pic');
			$pic = time() . '-' . $file->getClientOriginalName();
			$file->move('image/', $pic);
		}
		
		$basic_detail=[
			"name"      => $request->name,
			"email"     => $request->email,
			"password"  => $request->password,
			"mobile"    => $request->mobile,
			"pic"       => $pic,
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
	
	
	
	public function studentDisplay(Request $request){
		if ($request->ajax()) {
			$i=1;
            $data = DB::table('students')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="javascript:void(0)" data-eid="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>
							<a href="javascript:void(0)" data-did="'.$row->id.'" class="edit btn btn-danger btn-sm">Delete</a>';
                            return $btn;
                    })
					->addColumn('pic', function($row){
							$path = public_path() . '/image/'.$row->pic;
                            return "<img src='".$path."'>";
							//return $row->pic;
                            
                    }) 
					/*->addColumn('pic', function ($image) { 
						   $url=asset("student_image/$image->image"); 
						   return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />'; 
					}) */
                    ->rawColumns(['action','pic'])
                    ->make(true);
        }
          
        return view('student-form');
	}
}
