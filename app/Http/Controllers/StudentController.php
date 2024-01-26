<?php

namespace App\Http\Controllers;

use App\Models\Mailbox;
use App\Models\Quizzes;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         if ($request->ajax()) { 
            $data = Student::latest()->orderBy('student_id','desc')->get();
            return DataTables::of($data)
                ->addColumn('image',function($row){
                    if($row->stu_image != ''){
                        $img = '<img src="'.asset("student/".$row->stu_image).'" width="70px">';
                    }else{
                        $img = '<img src="'.asset("student/default.png").'" width="70px">';
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
                    $btn = '<a href="students/'.$row->student_id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-student btn btn-danger btn-sm" data-id="'.$row->student_id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['status','action','image'])
                ->make(true);
        } 
        return view('admin.students.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $Subjects = Subject::all();
        return view('admin.students.create',['subject'=>$Subjects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return $request->input();
        $request->validate([
            'student_name'=>'required',
            'father_name'=>'required',
            'dob'=>'required',
            'gender'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'register_no'=>'required||unique:students,register_no',
            'subjects'=>'required',
            'email'=>'required|email|unique:students,email',
            'password'=>'required',
        ]);
        if($request->img){
            $image = $request->img->getClientOriginalName();
            $request->img->move(public_path('student'),$image);
        }else{
            $image = '';
        }

        $Students = new Student;
        $Students->student_name = $request->input("student_name");
        $Students->father_name = $request->input("father_name");
        $Students->date_of_birth = $request->input("dob");
        $Students->gender = $request->input("gender");
        $Students->phone = $request->input("phone");
        $Students->address = $request->input("address");
        $Students->register_no = $request->input("register_no");
        $Students->subjects = implode(',',$request->input("subjects"));
        $Students->stu_image = $image;
        $Students->email = $request->input("email");    
        $Students->password = Hash::make($request->input("password"));
        $result = $Students->save();
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
        $students = Student::where(['student_id'=>$id])->first();
        $subjects = Subject::all();
        return view('admin.students.edit',['students'=> $students,'subject'=>$subjects]);
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
        $request->validate([
            'student_name'=>'required',
            'father_name'=>'required',
            'dob'=>'required',
            'gender'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'subjects'=>'required',
            'email'=>'required|email|unique:students,email,'.$id.',student_id',
            'status'=>'required',
        ]);
          // update Teacher image
        if($request->img != ''){        
            $path = public_path().'/student/';
            //code for remove old file
            if($request->old_img != ''  && $request->old_img != null){
                $file_old = $path.$request->old_img;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->img;
            $image = $request->img->getClientOriginalName();
            $file->move($path, $image);
        }else{
            $image = $request->old_img;
        }

        if($request->password != ''){
            $password = Hash::make($request->password);
        }else{
            $password = $request->old_password;
        }

        $Students = Student::where(['student_id'=>$id])->update([
            "student_name"=>$request->input('student_name'),
            "father_name" => $request->input("father_name"),
            "date_of_birth" => $request->input("dob"),
            "gender" => $request->input("gender"),
            "phone" => $request->input("phone"),
            "address" => $request->input("address"),
            "subjects" => implode(',',$request->input("subjects")),
            "stu_image" =>$image,
            "email" => $request->input("email"),
            "password" => $password,
            "status" => $request->input("status"),
        ]);
        return $Students;    

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
        $destroy = Student::where('student_id',$id)->delete();
        return  $destroy;
    }

     public function loginStudent(Request $request){
        //
        if($request->input()){
            $request->validate([
                'email'=>'required',
                'password'=>'required',
            ]); 
            $email = $request->input('email');
            $password = $request->input('password');
            $Students= Student::select("student_id","email","student_name","password")->where(['email'=> $email])->first();
            if(empty( $Students)){
                return response()->json(['email'=>'Email Does not Exists']);
            }else{
                if(Hash::check($password,$Students->password)){
                    $request->session()->put('student_id',$Students->student_id);
                    $request->session()->put('student_name',$Students->student_name); 
                    return "1";
                }else{
                    return response()->json(['password'=>'Username and Password does not matched']);
                    }
            }
        }else{
			return view('student.student-login');
		}    
    }

    public function logout(Request $req) {
        Auth::logout();
        session()->forget('student_id');
        session()->forget('student_name');
        return redirect('student/student-login');
    }

    public function myQuizzes(){
        $Quizzes =  Quizzes::select('quizzes.*',DB::raw("COUNT(questions.quizz_id) as q_count"))
                            ->leftJoin('questions','questions.quizz_id','=', 'quizzes.quizz_id')
                            ->where('quizzes.status','1')
                            ->groupBy('quizzes.quizz_id','quizzes.quizz_title','quizzes.quizz_slug','quizzes.quizz_des','quizzes.instruction','quizzes.duration','quizzes.teacher_id','quizzes.status','quizzes.created_at','quizzes.updated_at')
                            ->get();
        $notification = $this->stuNotification(session()->get('student_id'));
        return view('student/quizzes',['quizzes'=> $Quizzes,'notification'=>$notification ]);
    }

    

    public function profile(){
        $id = session()->get('student_id');
        $data['student'] = Student::select('students.*')
                            ->where(['student_id'=>$id])
                            ->first();
        $data['notification'] = $this->stuNotification(session()->get('student_id'));
        return view('student/profile',$data);
    }


    public function quiz_history(){
        $id = session()->get('student_id');
        $data['history'] = DB::table('participants')
                        ->select('participants.*','quizzes.quizz_title')
                        ->leftJoin('quizzes','quizzes.quizz_id','=','participants.test_id')
                        ->where(['student_id'=>$id])
                        ->orderBy('p_id','DESC')->get();
        $data['notification'] = $this->stuNotification(session()->get('student_id'));
        return view('student.history',$data);
    }

    public function stuNotification($value){
        $notification = Mailbox::select(['mailboxes.*','students.student_name'])
        ->where(['mailboxes.status'=>'0'])
        ->where(['mailboxes.receiver_id'=>$value])
        ->leftJoin('students','mailboxes.receiver_id','=','students.student_id')
        ->get();
        return $notification;
    }


    public function leaderboard(Request $request, $text){
        if ($request->ajax()) {
            $data = DB::table('participants')->select('participants.*','quizzes.quizz_title','students.student_name')->where('quizzes.quizz_slug','=',$text)
                    ->leftJoin('quizzes','quizzes.quizz_id','=','participants.test_id')
                    ->leftJoin('students','students.student_id','=','participants.student_id')
                    ->orderBy('participants.correct','desc')
                    ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('started',function($row){
                    return $row->started = date('d M,Y',strtotime($row->started));
                })
                ->addColumn('duration',function($row){
                    $start = date_create($row->started);
                    $end = date_create($row->completed);
                    $diff = date_diff($start,$end);
                    $duration = $diff->s.' sec.';
                    if($diff->i != '0'){
                        $duration = $diff->i.' mins. '.$duration;
                    }

                    return $duration;
                })
                ->rawColumns(['duration'])
                ->make(true);
        }
        $data['quiz'] = Quizzes::select('quizzes.*',DB::raw("count(questions.question_id) as questions"))
                        ->where('quizz_slug',$text)
                        ->leftJoin('questions','questions.quizz_id','=','quizzes.quizz_id')
                        ->groupBy('quizzes.quizz_id')
                        ->first();
        $data['notification'] = $this->stuNotification(session()->get('student_id'));
        return view('student.leaderboard',$data);
    }

}
