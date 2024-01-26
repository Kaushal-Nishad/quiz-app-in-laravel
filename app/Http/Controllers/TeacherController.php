<?php

namespace App\Http\Controllers;

use App\Models\Mailbox;
use App\Models\Quizzes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;


class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Teacher::select('teachers.*','subjects.subject_name')
            ->leftJoin('subjects','subjects.subject_id','=','teachers.designation')
            ->orderBy('teacher_id','desc')->get();
            return DataTables::of($data)
                ->addColumn('image',function($row){
                    if($row->image != ''){
                        $img = '<img src="'.asset("teacher/".$row->image).'" width="70px">';
                    }else{
                        $img = '<img src="'.asset("teacher/default.png").'" width="70px">';
                    }
                    return $img;
                })
                ->addIndexColumn()
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status =  '<span class="badge badge-success">Active</span>';
                    }else{
                        $status =  '<span class="badge badge-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="teachers/'.$row->teacher_id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-teacher btn btn-danger btn-sm" data-id="'.$row->teacher_id.'">Delete</a>';
                    return $btn;
                })
                
                ->rawColumns(['action','image','status'])
                ->make(true);
        }
        return view('admin.teachers.index');
    }
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['subjects'] = Subject::all();
        return view('admin.teachers.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       // return $request->input();
        $request->validate([
            'teacher_name'=>'required',
            'registration'=>'required|unique:teachers,register_no',
            'designation'=>'required',
            'dob'=>'required',
            'gender'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'joining_date'=>'required',
            'email'=>'required|email|unique:teachers,email',
            'password'=>'required',
        ]);
        
        $Teachers = new Teacher;
        $Teachers->teacher_name = $request->input("teacher_name");
        $Teachers->register_no = $request->input("registration");
        $Teachers->designation = $request->input("designation");
        $Teachers->date_of_birth = $request->input("dob");
        $Teachers->gender = $request->input("gender");
        $Teachers->phone = $request->input("phone");
        $Teachers->address = $request->input("address");
        $Teachers->join_date = $request->input("joining_date");

        if($request->img && $request->img != ''){
            $image = time().$request->img->getClientOriginalName();
            $request->img->move(public_path('teacher'),$image);
            $Teachers->image = $image;
        }
        
        $Teachers->email = $request->input("email");    
        $Teachers->password = Hash::make($request->input("password"));
        $result = $Teachers->save();
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['teachers'] =  Teacher::where(['teacher_id'=>$id])->first();
        $data['subjects'] = Subject::all();
        return view('admin.teachers.edit',$data);
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
        //
        $request->validate([
            'teacher_name'=>'required',
            'designation'=>'required',
            'dob'=>'required',
            'gender'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'joining_date'=>'required',
            'email'=>'required|email|unique:teachers,email,'.$id.',teacher_id',
            'status'=>'required',
        ]);
         
        // update Teacher image
        if($request->img != ''){        
            $path = public_path().'/teacher/';
            //code for remove old file
            if($request->old_img != ''  && $request->old_img != null){
                $file_old = $path.$request->old_img;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->img;
            $image = time().$request->img->getClientOriginalName();
            $file->move($path, $image);
        }else{
            $image = $request->old_img;
        }

        if($request->password != ''){
            $password = Hash::make($request->password);
        }else{
            $password = $request->old_password;
        }

        $Teachers = Teacher::where(['teacher_id'=>$id])->update([
            "teacher_name"=>$request->input('teacher_name'),
            "designation" => $request->input("designation"),
            "date_of_birth" => $request->input("dob"),
            "gender" => $request->input("gender"),
            "phone" => $request->input("phone"),
            "address" => $request->input("address"),
            "join_date" => $request->input("joining_date"),
            "image" =>$image,
            "email" => $request->input("email"),
            "password" => $password,
            "status" => $request->input("status"),
        ]);
        return $Teachers;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $destroy = Teacher::where('teacher_id',$id)->delete();
        return  $destroy;
    }
    

    public function loginTeacher(Request $request){
        //
        if($request->input()){
            $request->validate([
                'email'=>'required',
                'password'=>'required',
            ]); 
            $email = $request->input('email');
            $password = $request->input('password');
            $Teachers= Teacher::select("teacher_id","email","teacher_name","image","password")->where(['email'=> $email])->first();
            //return  $Teachers;
            if(empty($Teachers)){
                return response()->json(['email'=>'Email / Username Does not Exists']);
            }else{
                if(Hash::check($password,$Teachers->password)){
                    $request->session()->put('teacher_id',$Teachers->teacher_id);
                    $request->session()->put('teacher_name',$Teachers->teacher_name); 
                    $request->session()->put('teacher_image',$Teachers->image); 
                    return "1";
                }else{
                    return response()->json(['password'=>'Username and Password does not matched']);
                    }
            }
        }else{
			return view('teacher.teacher-login');
		}    
    }

    function homePage(){
        $value = session()->get('teacher_id');
        $Teachers = Teacher::WHERE(['teacher_id'=> $value])
                    ->select('teachers.*','subjects.subject_name')
                    ->leftJoin('subjects','subjects.subject_id','=','teachers.designation')
                    ->first();
        $quizzes = Quizzes::where('teacher_id',$value)->count();
        $mailbox = Mailbox::select('mailboxes.*','students.student_name')->where('receiver_id',$value)
                            ->leftJoin('students','students.student_id','=','mailboxes.sender_id')
                            ->orderBy('mail_id','DESC')->limit(5)->get();
        // $students = Quizzes::where('teacher_id',$value)->count();
        $notification = $this->teacherNotification(session()->get('teacher_id'));
        return view('teacher/home',['teacher'=> $Teachers,'quiz'=>$quizzes,'notification'=>$notification,'mailbox'=>$mailbox]);
    }

    public function Teacher_logout(Request $req) {
        Auth::logout();
        session()->forget('teacher_id');
        session()->forget('teacher_name');
        return redirect('teacher/login');
    }

    public function teacherNotification($value){
        $notification = Mailbox::select(['mailboxes.*','teachers.teacher_name'])
        ->where(['mailboxes.status'=>'0'])
        ->where(['mailboxes.receiver_id'=>$value])
        ->leftJoin('teachers','mailboxes.receiver_id','=','teachers.teacher_id')
        ->get();
        return $notification;
    }

    public function Teacher_profile(Request $request){
        if($request->input()){
            $id = session()->get('teacher_id');
            $request->validate([
                'teacher_name'=>'required',
                'teacher_phone'=>'required',
                'teacher_dob'=>'required',
                'teacher_address'=>'required',
            ]);

            $teacher = Teacher::where(['teacher_id'=>$id])->update([
                "teacher_name"=>$request->input('teacher_name'),
                "phone" => $request->input("teacher_phone"),
                "date_of_birth" => $request->input("teacher_dob"),
                "address" => $request->input("teacher_address")
            ]);
            return '1';

        }else{
            $id = session()->get('teacher_id');
            $data['notification'] = $this->teacherNotification(session()->get('teacher_id'));
            $data['teacher'] = Teacher::where(['teacher_id'=>$id])->first();
            return view('teacher.profile',$data);
        }
    }

    public function myStudents(Request $request){
        if ($request->ajax()) {
            $id = session()->get('teacher_id');
            $data = Student::select('students.*')
                    ->join('teachers',DB::raw("FIND_IN_SET(teachers.designation, students.subjects)"), ">", DB::raw("'0'"))
                    ->where('teachers.teacher_id',$id)
                    ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status =  '<span class="badge badge-success">Active</span>';
                    }else{
                        $status =  '<span class="badge badge-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('report', function($row){
                    $btn = '<a href="'.url('/teacher/student-report/'.$row->student_id).'" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status','report'])
                ->make(true);
        }
        return view('teacher.students');
    }
    public function studentReport(Request $request,$id){
        $teacher = session()->get('teacher_id');
          //$id = session()->get('student_id');
        if ($request->ajax()) {
            $data = DB::table('participants')->select('participants.*','quizzes.quizz_title')->where('student_id','=',$id)
                    ->leftJoin('quizzes','quizzes.quizz_id','=','participants.test_id')
                    ->whereIn('test_id',function($query) use ($teacher){
                        $query->select('quizz_id')->where('teacher_id','=',$teacher)->from('quizzes')->get();
                    })->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('started',function($row){
                    return $row->started = date('d M,Y',strtotime($row->started));
                })
                ->addColumn('duration',function($row){
                    return $row->started;
                    // return $duration;
                })
                ->rawColumns(['started','duration'])
                ->make(true);
        }else{

        $data['student'] = Student::select('register_no','student_name')
                            ->where('student_id',$id)->first();
        return view('teacher.student-report',$data);
        }
    }
}
