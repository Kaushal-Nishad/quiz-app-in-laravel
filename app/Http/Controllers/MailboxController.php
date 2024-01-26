<?php

namespace App\Http\Controllers;

use App\Models\Mailbox;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MailboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */             
    public function index(Request $request)   // teacher inbox
    { 
        if ($request->ajax()) {
           
            $data =  Mailbox::select(['mailboxes.*','students.student_name'])
                    ->WHERE('sender','student')
                    ->leftJoin('students', 'mailboxes.sender_id', '=' ,'students.student_id')
                    ->orderBy('mail_id','DESC')
                    ->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('mail_title', function($row){
                if($row->status != '1'){
                    $title = '<b>'.$row->mail_title.'</b>';
                }else{
                    $title = $row->mail_title;
                }
                return $title;
            })
            ->editColumn('status', function($row){
                if($row->status == '1'){
                    $status =  '<span class="text-secondary"><i class="fa fa-circle"></i></span>';
                }else{
                    $status =  '<span class="text-success"><i class="fa fa-circle"></i></span>';
                }
                return $status;
            })
            ->editColumn('sender', function($row){
                $sender ='<a href="'.url("teacher/mailbox/singlepage/".$row->mail_id).'">'.$row->student_name.'</a>';
                return  $sender;
            })
            ->editColumn('created_at', function($row){
                if(date('d',strtotime($row->created_at)) == date('d')){
                    $date =date('H:i a',strtotime($row->created_at));
                }else{
                    $date =date('d M, Y',strtotime($row->created_at));
                }
                return  $date;
            })
            ->rawColumns(['mail_title','sender','status'])
            ->make(true);
        }
            return view('teacher.mailbox.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() // show add new mail page to teacher
    {
        $Students = Student::all();
        return view('teacher.mailbox.create',['student'=>$Students]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(Request $request) //insert mail from teacher
    {
        //
        // return $request->input();
        $request->validate([
            'receiver'=>'required',
            'title'=>'required',
            'description'=>'required',
        ]);
        
        if($request->img){
            $image = $request->img->getClientOriginalName();
            $request->img->move(public_path('mailbox'),$image);
        }else{
            $image = "";
        }

        $Mailbox = new Mailbox();
        $Mailbox->sender = 'teacher';
        $Mailbox->sender_id = session()->get('teacher_id');
        $Mailbox->receiver = 'student';
        $Mailbox->receiver_id = $request->input("receiver");
        $Mailbox->mail_title = $request->input("title");
        $Mailbox->mail_des = htmlspecialchars($request->input("description"));
        $Mailbox->mail_img = $image;
        $result = $Mailbox->save();
        return $result;

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
    }
   
    public function teacherSentMail(Request $request){   // teacher show all sent mail
        if ($request->ajax()) {
            $data =  Mailbox::select(['mailboxes.*','students.student_name'])
                    ->WHERE('sender','teacher')
                    ->leftJoin('students', 'mailboxes.receiver_id', '=' ,'students.student_id')
                    ->orderBy('mailboxes.mail_id','desc')
                    ->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function($row){
                $status =  '<span class="text-secondary"><i class="fa fa-circle"></i></span>';
                return $status;
            })
            ->editColumn('sender', function($row){
                $sender ='<a href="'.url("teacher/mailbox/sent/".$row->mail_id).'">'.$row->student_name.'</a>';
                return  $sender;
            })
            ->editColumn('created_at', function($row){
                if(date('d',strtotime($row->created_at)) == date('d')){
                    $date =date('H:i a',strtotime($row->created_at));
                }else{
                    $date =date('d M, Y',strtotime($row->created_at));
                }
                return  $date;
            })
            ->rawColumns(['sender','status'])
            ->make(true);
        }
        return view('teacher.mailbox.sent-mail');
    }


    public function singlePage($id){  // teacher inbox single page
        $data =  Mailbox::WHERE(['mail_id'=>$id])
        ->update(array('status' => '1'));
        $Mailbox = Mailbox::where(['mail_id'=>$id])
                        ->select('mailboxes.*','students.student_name')
                        ->leftJoin('students','students.student_id','=','mailboxes.sender_id')
                        ->first();
        $notification = $this->stuNotification(session()->get('student_id'));
        return view('teacher.mailbox.singlepage',['mailbox'=> $Mailbox,'notification'=>$notification]);
    }

    public function singleSentPage($id){  // teacher sent mail single page
        $data =  Mailbox::WHERE(['mail_id'=>$id])
        ->update(array('status' => '1'));
        $Mailbox = Mailbox::where(['mail_id'=>$id])
                        ->select('mailboxes.*','students.student_name','teachers.teacher_name')
                        ->leftJoin('students','students.student_id','=','mailboxes.receiver_id')
                        ->leftJoin('teachers','teachers.teacher_id','=','mailboxes.sender_id')
                        ->first();
        $notification = $this->stuNotification(session()->get('student_id'));
        return view('teacher.mailbox.sent-single',['mailbox'=> $Mailbox,'notification'=>$notification]);
    }


    public function studentMailbox(Request $request){ // student inbox
        if ($request->ajax()) {
        $data =  Mailbox::select(['mailboxes.*','teachers.teacher_name'])
        ->where('receiver','student')
        ->leftJoin('teachers', 'mailboxes.sender_id', '=' ,'teachers.teacher_id')
        ->orderBy('mail_id','desc')
        ->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('mail_title', function($row){
                if($row->status != '1'){
                    $title = '<b>'.$row->mail_title.'</b>';
                }else{
                    $title = $row->mail_title;
                }
               
                return $title;
            })
            ->editColumn('status', function($row){
                if($row->status == '1'){
                    $status =  '<span class="text-secondary"><i class="fa fa-circle"></i></span>';
                }else{
                    $status =  '<span class="text-success"><i class="fa fa-circle"></i></span>';
                }
                return $status;
            })
            ->editColumn('sender', function($row){
                $sender ='<a href="'.url("student/mailbox/singlepage/".$row->mail_id).'">'.$row->teacher_name.'</a>';
                return  $sender;
            }) 
            ->editColumn('created_at', function($row){
                if(date('d',strtotime($row->created_at)) == date('d')){
                    $date =date('H:i a',strtotime($row->created_at));
                }else{
                    $date =date('d M, Y',strtotime($row->created_at));
                }
                
                return  $date;
            })
            ->rawColumns(['mail_title','sender','status'])
            ->make(true);
        } 
        $notification = $this->stuNotification(session()->get('student_id'));
        return view('student.mailbox.index',['notification'=>$notification]);
    }


    public function studentcreate(){  // student mail compose page
        $Teachers =  Teacher::all();
        $notification = $this->stuNotification(session()->get('student_id'));
        return view('student.mailbox.create',['teacher'=>$Teachers,'notification'=>$notification]);
    }

    public function studentAddmail(Request $request){  // insert mail from student
            $request->validate([
            'receiver'=>'required',
            'title'=>'required',
            'description'=>'required',
        ]);
        
        if($request->img){
            $image = $request->img->getClientOriginalName();
            $request->img->move(public_path('mailbox'),$image);
        }else{
            $image = "";
        }

        $Mailbox = new Mailbox();
        $Mailbox->sender = 'student';
        $Mailbox->sender_id = session()->get('student_id');
        $Mailbox->receiver = 'teacher';
        $Mailbox->receiver_id = $request->input("receiver");
        $Mailbox->mail_title = $request->input("title");
        $Mailbox->mail_des = htmlspecialchars($request->input("description"));
        $Mailbox->mail_img = $image;
        $result = $Mailbox->save();
        return $result;
    }

    
    public function studentSentMail(Request $request){ // student sent mail
        if($request->ajax()){
        $data =  Mailbox::select(['mailboxes.*','teachers.teacher_name'])
        ->WHERE('sender','student')
        ->leftJoin('teachers', 'mailboxes.receiver_id', '=' ,'teachers.teacher_id')
        ->orderBy('mail_id','desc')
        ->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('mail_title', function($row){
                if($row->status != '1'){
                    $title = $row->mail_title;
                }else{
                    $title = $row->mail_title;
                }
               
                return $title;
            })
            ->editColumn('status', function($row){
                $status =  '<span class="text-secondary"><i class="fa fa-circle"></i></span>';
                return $status;
            })
            ->editColumn('sender', function($row){
                $sender ='<a href="'.url("student/mailbox/sent/".$row->mail_id).'">'.$row->teacher_name.'</a>';
                return  $sender;
            }) 
            ->editColumn('created_at', function($row){
                if(date('d',strtotime($row->created_at)) == date('d')){
                    $date =date('H:i a',strtotime($row->created_at));
                }else{
                    $date =date('d M, Y',strtotime($row->created_at));
                }
                
                return  $date;
            })
            ->rawColumns(['mail_title','sender','status'])
            ->make(true);
        } 
        $notification = $this->stuNotification(session()->get('student_id'));
        return view('student.mailbox.sent-mail',['notification'=>$notification]);
    }


    

    public function studentSinglePage($id){ // student mail single page
        $data =  Mailbox::WHERE(['mail_id'=>$id])
        ->update(array('status' => '1'));

        $Mailbox = Mailbox::WHERE(['mail_id'=>$id])
                        ->select('mailboxes.*','teachers.teacher_name')
                        ->leftJoin('teachers','teachers.teacher_id','=','mailboxes.sender_id')
                        ->first();

        $notification = $this->stuNotification(session()->get('student_id'));
        return view('student.mailbox.singlepage',['mailbox'=> $Mailbox,'notification'=>$notification]);
    }


    public function student_singleSentPage($id){ // student mail single page
        $data =  Mailbox::WHERE(['mail_id'=>$id])
        ->update(array('status' => '1'));

        $Mailbox = Mailbox::WHERE(['mail_id'=>$id])
                        ->select('mailboxes.*','teachers.teacher_name','students.student_name')
                        ->leftJoin('students','students.student_id','=','mailboxes.sender_id')
                        ->leftJoin('teachers','teachers.teacher_id','=','mailboxes.receiver_id')
                        ->first();

        $notification = $this->stuNotification(session()->get('student_id'));
        return view('student.mailbox.sent-single',['mailbox'=> $Mailbox,'notification'=>$notification]);
    }


    public function stuNotification($value){ // show notification in header for unread mails
        $notification = Mailbox::select(['mailboxes.*','students.student_name'])
        ->where(['mailboxes.status'=>'0'])
        ->where(['mailboxes.receiver_id'=>$value])
        ->where(['mailboxes.receiver'=>'student'])
        ->leftJoin('students','mailboxes.receiver_id','=','students.student_id')
        ->get();
        return $notification;
    }
}
