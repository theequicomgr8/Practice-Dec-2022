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
            $data = DB::table('students');
			
			
			
			$data=$data->get();
			
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="javascript:void(0)" data-eid="'.$row->id.'" class="edit btn btn-primary btn-sm"><i class="fa fa-edit" style="font-size:16px"></i></a>
							<a href="javascript:void(0)" data-did="'.$row->id.'" class="edit btn btn-danger btn-sm"><i class="fa fa-trash-o" style="font-size:16px"></i></a>';
                            return $btn;
                    })
					
					
					->addColumn('pic', function($row){
							$path = "/../image/".$row->pic;
                            return "<img src='".$path."'>";
							//return $path;
                            
                    }) 
                    ->rawColumns(['action','pic'])
                    ->make(true);
        }
          
        return view('student-form');
	}
	
	
	
	
	
	public function studentList(){
		return view('student.student-list');
	}
	
	public function allstudent(Request $request){
		$columns = array( 
                            0 =>'id', 
                            1 =>'name',
                            2=> 'email',
                            3=> 'mobile',
                        );
  
        $totalData = Student::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = Student::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $posts =  Student::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Student::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                // $show =  route('posts.show',$post->id);
                // $edit =  route('posts.edit',$post->id);
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['email'] = $post->email;
                $nestedData['mobile'] = $post->mobile;
                $nestedData['options'] = "&emsp;<a href='edit/{$post->id}' title='SHOW' >Edit</a>
                                          &emsp;<a href='delete/{$post->id}' title='EDIT' >Delete</a>";
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
	        "draw"            => intval($request->input('draw')),  
	        "recordsTotal"    => intval($totalData),  
	        "recordsFiltered" => intval($totalFiltered), 
	        "data"            => $data   
        );
            
        echo json_encode($json_data); 
	}
}
