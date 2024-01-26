<?php

namespace App\Http\Controllers;

use App\Models\Mailbox;
use App\Models\Questions;
use App\Models\Quizzes;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuizzesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = session()->get('teacher_id');
        if ($request->ajax()) {
            $data = Quizzes::select(['quizzes.*',DB::raw("count(questions.question_id) as questions")])
                ->where('quizzes.teacher_id',$id)
                ->leftJoin('questions','questions.quizz_id','=','quizzes.quizz_id')
                ->groupBy('quizzes.quizz_id','quizzes.quizz_title','quizzes.quizz_slug','quizzes.quizz_des','quizzes.instruction','quizzes.duration','quizzes.teacher_id','quizzes.status','quizzes.created_at','quizzes.updated_at')
                ->orderBy('quizzes.quizz_id','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status =  '<h4><span class="badge badge-success">Yes</span></h4>';
                    }else{
                        $status =  '<h4><span class="badge badge-danger">No</span></h4>';
                    }
                    return $status;
                })
                ->editColumn('duration', function($row){
                    return $row->duration = $row->duration.' Mins.';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="quizzes/'.$row->quizz_id.'/edit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>';
                    return $btn;
                })
                ->addColumn('leaderboard', function($row){
                    $btn = '<a href="quizzes/leaderboard/'.$row->quizz_id.'" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','status','leaderboard'])
                ->make(true);
        }
        return view('teacher.quizz.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('teacher.quizz.create');
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
        $request->validate([
            'qui_title'=>'required', 
            'description'=>'required',
            'instruction'=>'required',
            'duration'=>'required', 
            'status'=>'required', 
        ]);

        $Quizzes = new Quizzes();
        $Quizzes->teacher_id = session()->get("teacher_id");
        $Quizzes->quizz_title = $request->input("qui_title");
        $Quizzes->quizz_slug = str_replace(" " ,"-",strtolower($request->input("qui_title")));
        $Quizzes->quizz_des = $request->input("description");
        $Quizzes->instruction = $request->input("instruction");
        $Quizzes->duration = $request->input("duration");
        $Quizzes->status = $request->input("status");
        $result = $Quizzes->save();
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
        $Teachers = Teacher::all();
        $Quizzes = Quizzes::where(['quizz_id'=>$id])->get();
        return view('teacher.quizz.edit',['quizzes'=>$Quizzes,'teacher'=>$Teachers]);
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
            'qui_title'=>'required',
            'description'=>'required',
            'instruction'=>'required',
            'duration'=>'required',
            'status'=>'required',
        ]);
        

        $Quizzes = Quizzes::where(['quizz_id'=>$id])->update([
            "quizz_title" => $request->input("qui_title"),
            "quizz_des" => $request->input("description"),
            "instruction" => $request->input("instruction"),
            "duration" => $request->input("duration"),
            "status" => $request->input("status"),
        ]);
        return $Quizzes;

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
        // $destroy = Quizzes::where('quizz_id',$id)->delete();
        // return  $destroy;
    }

    public function instruction($text){
        $data['quiz'] = Quizzes::where(['quizz_slug'=>$text])->first();
        $data['notification'] = $this->stuNotification(session()->get('student_id'));
        if(!empty($data['quiz'])){
            return view('student/instruction',$data);
        }else{
            return abort(404);
        }
    }

    public function create_quiz_session($text = NULL){
        $quiz = Quizzes::where(['quizz_slug'=>$text])->first();
        if(empty($quiz)){
            return abort(404);
        }

        $duration = $quiz->duration;

        $questions = Questions::where(["quizz_id" => $quiz->quizz_id])->get();
        if(empty($questions)){
            return redirect('student/my-quizzes');
        }
        $question_count = count($questions);

        if(session()->has('test_session')){
            $test_id = session()->get('test_session')["quiz_data"]["quizz_slug"];
            return redirect('student/quiz/'.$test_id.'/1');
        }else{
            $start_time = date('Y-m-d H:i:s');
            $end_time = date('Y-m-d H:i:s', strtotime("+$duration minutes"));
            $student_id = session()->get('student_id');

            $participant = array();
            $participant['student_id'] = $student_id;
            $participant['test_id'] = $quiz->quizz_id;
            $participant['questions'] = $question_count;
            $participant['correct'] = 0;
            $participant['started'] = $start_time;
            $participant['total_attempt'] = 0;
            $participant['completed'] = NULL;

            $p_id = DB::table('participants')->insertGetId($participant);
            // return $p_id;
            $participant['end_time'] = $end_time;
            $participant['p_id'] = $p_id;

            $test_session = array(
                'quiz_data' => $quiz,
                'quiz_questions' => $questions,
                'participant' => $participant
            );

            session()->put('test_session',$test_session);

        }
        // return '1';
        return redirect('student/quiz/'.$text.'/1');

    }


    public function quiz_test(Request $request,$text = NULL,$id = NULL){
        // return $id.$text;
        // session()->forget('test_session');
        $quiz = Quizzes::where(['quizz_slug'=>$text])->first();
        if(empty($quiz)){
            echo '1';
            return abort(404);
        }
        // return session()->get('test_session')["quiz_data"]["quizz_slug"];
        $test_id = (session()->has('test_session')) ? session()->get('test_session')["quiz_data"]["quizz_slug"] : NULL;
        
        if(empty(session()->get('test_session')) || empty($test_id)){
        // return $test_id;
            return redirect('student/q/instruction/'.$text);
        }

        if($test_id != $quiz->quizz_slug){
            return redirect('student/quiz/'.$text.'/'.$id);
        }

        $total_question = count(session()->get('test_session')["quiz_questions"]);

        if(empty($id) && empty($request->input())){
            
            return redirect('student/q/result/'.$text);
        }

        if(empty($id) || $total_question < 1){
            return abort(404);
        }

        if($total_question < $id){
            return abort(404);
        }

        $end_time = session()->get('test_session')["participant"]["end_time"];
        //echo '1';
        if($end_time < date('Y-m-d H:i:s')){
            //return $end_time;
            return redirect('student/q/result/'.$text);
        }
        //return '2';
        $expire_time = strtotime(session()->get('test_session')["participant"]["end_time"]);
        $current_time = strtotime(date('Y-m-d H:i:s'));
        $left_time = $expire_time - $current_time;

            // return var_dump($request->input('answer'));
        if($request->input('answer') && !empty($request->input('answer'))){
            $answer = $request->input('answer');
        }else{
            $answer = '';
            
        }
        // return $request->input();
        $q_num = $id-1;
        $ques_id = ($id > 1) ? $id-1 : $id;

        $next_q = $id < $total_question ? $id+1 : $id;
        //return $next_q;
        if($request->input('save_next')){
            
            $this->create_question_status($q_num,'save_next',$answer);
            return redirect('student/quiz/'.$text.'/'.$next_q);

        }elseif($request->input('submit')){
            // return $answer;
            $this->create_question_status($q_num,'save_next',$answer);
            if($answer){
                return redirect('student/q/result/'.$text);
            }else{
                return redirect('student/quiz/'.$text.'/'.$id);
            }

        }elseif($request->input('previous')){

            $this->create_question_status($q_num,'previous');
            return redirect('student/quiz/'.$text.'/'.$ques_id);

        }elseif($request->input('next')){
            // return $next_q;
            // return $q_num;
            $this->create_question_status($q_num,'next');
            return redirect('student/quiz/'.$text.'/'.$next_q);

        }else{
            $this->create_question_status($q_num,'visited');
        }

        $running_quiz_question = session()->get('test_session')["quiz_questions"];

        $attempt = 0;
        $visited = 0;
        $answered = 0;

        foreach($running_quiz_question as $running){
            if(isset($running['answer'])){
                $attempt++;
            }

            if(isset($running['status']) && $running['status'] == 'answer'){
                $answered++;
            }

            if(isset($running['status']) && $running == 'visited'){
                $visited++;
            }
        }

        $not_visited = $total_question - $attempt - $visited;

        $get_test_session = session()->get('test_session');
        // echo '<pre>';
        // print_r($get_test_session);
        // return $get_test_session;
        $quiz_data = $get_test_session['quiz_data'];
        $question_data = $get_test_session['quiz_questions'][$q_num];

        $data['question_data'] = $question_data;
        $data['quiz_title'] = $quiz->quizz_title;
        $data['text'] = $text;
        $data['left_time'] = $left_time;
        $data['id'] = $id;
        $data['ques_id'] = $ques_id;
        $data['total_question'] = $total_question;
        $data['notification'] = $this->stuNotification(session()->get('student_id'));

        // echo '<pre>';
        // print_r(session()->get('test_session'));
        // return session()->get('test_session');

        return view('student/start-quizzes',$data);

        
        
    }

    public function create_question_status($q_number = NULL, $action = NULL, $answer = NULL)
    {
        $get_test_session = session()->get('test_session');

        if(empty($get_test_session['quiz_questions'][$q_number]['status']) && $action == 'visited')
        {
            $get_test_session['quiz_questions'][$q_number]['status'] = 'visited';
            $test_session = $get_test_session;
            session()->put('test_session',$test_session);
        }

        if(empty($get_test_session['quiz_questions'][$q_number]['status']) && $action == 'preview_quiz')
        {
            if($answer != ''){
                $get_test_session['quiz_questions'][$q_number]['status'] = 'answer';
                $get_test_session['quiz_questions'][$q_number]['answer'] = $answer;
                $test_session = $get_test_session;
                session()->put('test_session',$test_session);
            }else{
                $get_test_session['quiz_questions'][$q_number]['status'] = 'preview_quiz';
                $test_session = $get_test_session;
                session()->put('test_session',$test_session);
            }
                        
        }

        if(empty($get_test_session['quiz_questions'][$q_number]['status']) && $action == 'next_quiz')
        {
            $get_test_session['quiz_questions'][$q_number]['status'] = 'visited';
            $test_session = $get_test_session;
            session()->put('test_session',$test_session);
        }

        if($action == 'save_next')
        {
            if($answer != ''){
                $get_test_session['quiz_questions'][$q_number]['status'] = 'answer';
                $get_test_session['quiz_questions'][$q_number]['answer'] = $answer;
                $test_session = $get_test_session;
                session()->put('test_session',$test_session);
            }else{
                $get_test_session['quiz_questions'][$q_number]['status'] = 'visited';
                $test_session = $get_test_session;
                session()->put('test_session',$test_session);
            }
            
        }
        return TRUE;
    }


    public function test_result($text = NULL){
        $student_id = session()->get('student_id');
        $right_ans = 0;
        $toatal_question = 0;
        $correct = 0;
        $correct_ans = 0;
        $total_attempt = 0;

        $quiz_id = session()->get('test_session')['quiz_data']['quizz_id'];
        // return $quiz_id;
        $quiz_questions = session()->get('test_session')['quiz_questions'];
        $total_question = count($quiz_questions);
        $participant_id = session()->get('test_session')['participant']['p_id'];
        // return $quiz_questions;
        foreach($quiz_questions as $question_array){
            $answer = isset($question_array->answer) ? $question_array->answer : '';
            $question_id = isset($question_array->question_id) ? $question_array->question_id : '';
            $correct_choice = isset($question_array->correct_answer) ? $question_array->correct_answer : '';

            if($answer != ''){
                $total_attempt++;
            }
            
            $is_correct = 0;
            $correct_ans = $answer == $correct_choice ? 1 : 0;

            if($correct_ans == 1){
                $is_correct = 1;
                $right_ans++;
            }

            $participant_questions = array();
            $participant_questions['student_id'] = $student_id;
            $participant_questions['participant_id'] = $participant_id;
            $participant_questions['question_id'] = $question_id;
            $participant_questions['correct_choice'] = $correct_choice;
            $participant_questions['student_answer'] = $answer;
            $participant_questions['is_correct'] = $is_correct;
            $participant_questions['timestamp'] = date('Y-m-d H:i:s');
            // return $participant_questions;
            $p_questions = DB::table('participant_questions')->insert($participant_questions);


        }

        $participant = array();
        $participant['correct'] = $right_ans;
        $participant['total_attempt'] = $total_attempt;
        $participant['completed'] = date('Y-m-d H:i:s');


        session()->forget('test_session');

        $update = DB::table('participants')
                        ->where('test_id',$quiz_id)
                        ->where('p_id',$participant_id)
                        ->update($participant);
        return redirect('student/q/summary/'.$participant_id);
       
    }


    public function test_summary($id){
        $participant = DB::table('participants')->where(['p_id'=>$id])->first();
        if(empty($participant)){
            return abort(404);
        }

        $participant_questions = DB::table('participant_questions')->select('participant_questions.*','questions.*')
                                    ->leftJoin('questions','questions.question_id','=','participant_questions.question_id')
                                    ->where(['participant_id'=>$id])->get();

        if(empty($participant_questions)){
            return redirect('student/my-quizzes');
        }

        $quiz_id = $participant->test_id;
        $quiz_data = Quizzes::select('quizzes.*',DB::raw("count(questions.question_id) as questions"))
                            ->where(['quizzes.quizz_id'=>$quiz_id])
                            ->leftJoin('questions','questions.quizz_id','=','quizzes.quizz_id')
                            ->groupBy('quizzes.quizz_id','quizzes.quizz_title','quizzes.quizz_slug','quizzes.quizz_des','quizzes.instruction','quizzes.duration','quizzes.teacher_id','quizzes.status','quizzes.created_at','quizzes.updated_at')->first();

        // $correct = 
        $data['quiz_data'] = $quiz_data;
        $data['participant'] = $participant;
        $data['participant_questions'] = $participant_questions;
        // echo '<pre>';
        // print_r($data);
        // return $data;
        $data['notification'] = $this->stuNotification(session()->get('student_id'));
        return view('student/quiz-result',$data);
    }

    public function stuNotification($value){
        $notification = Mailbox::select(['mailboxes.*','students.student_name'])
        ->where(['mailboxes.status'=>'0'])
        ->where(['mailboxes.receiver_id'=>$value])
        ->leftJoin('students','mailboxes.receiver_id','=','students.student_id')
        ->get();
        return $notification;
    }


    // show all quizzes to admin
    public function admin_quizzes(Request $request){
        if ($request->ajax()) {
            $data = Quizzes::select('quizzes.*','teachers.teacher_name',DB::raw("count(questions.question_id) as questions"))
                        ->leftJoin('teachers','teachers.teacher_id','=','quizzes.teacher_id')
                        ->leftJoin('questions','questions.quizz_id','=','quizzes.quizz_id')
                        ->groupBy('quizzes.quizz_id','quizzes.quizz_title','quizzes.quizz_slug','quizzes.quizz_des','quizzes.instruction','quizzes.duration','quizzes.teacher_id','teachers.teacher_name','quizzes.status','quizzes.created_at','quizzes.updated_at')
                        ->orderBy('quizzes.quizz_id','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status =  '<h4><span class="badge badge-success">Yes</span></h4>';
                    }else{
                        $status =  '<h4><span class="badge badge-danger">No</span></h4>';
                    }
                    return $status;
                })
                ->editColumn('duration', function($row){
                    return $row->duration = $row->duration.' Mins.';
                })
                ->editColumn('created_at', function($row){
                    return $row->created_at = date('d M,Y',strtotime($row->created_at));
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        return view('admin.quiz');
    }


    // show all questions to admin
    public function admin_questions(Request $request){
        if ($request->ajax()) {
            $data = Questions::select(['questions.*','quizzes.quizz_title','teachers.teacher_name'])
                ->leftJoin('quizzes','questions.quizz_id', '=','quizzes.quizz_id')
                ->leftJoin('teachers','teachers.teacher_id','=','quizzes.teacher_id')
                ->orderBy('question_id','desc')->get();
            return Datatables::of($data)
                ->addColumn('image',function($row){
                    if($row->image != ''){
                        $img = '<img src="'.asset("question/".$row->image).'" width="70px">';
                    }else{
                        $img = '<img src="'.asset("question/no-image.png").'" width="70px">';
                    }
                    return $img;
                })
                ->addIndexColumn()
                ->addColumn('choice_list', function($row){
                    $output = '';
                    $choices = json_decode(json_decode($row->choices));
                    $output .= '<ul>';
                    for($i=0;$i<count($choices);$i++){
                        $output .= '<li>'.$choices[$i].'</li>';
                    }
                    $output .= '</ul>';
                    return $output;
                })
                ->editColumn('created_at', function($row){
                    return $row->created_at = date('d M,Y',strtotime($row->created_at));
                })
                ->rawColumns(['image','choice_list'])
                ->make(true);
        }
        return view('admin.questions');
    }


    public function leaderboard(Request $request, $id){
        if ($request->ajax()) {
            $data = DB::table('participants')->select('participants.*','quizzes.quizz_title','students.student_name')->where('test_id','=',$id)
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
                        ->where('quizzes.quizz_id',$id)
                        ->leftJoin('questions','questions.quizz_id','=','quizzes.quizz_id')
                        ->groupBy('quizzes.quizz_id','quizzes.quizz_title','quizzes.quizz_slug','quizzes.quizz_des','quizzes.instruction','quizzes.duration','quizzes.teacher_id','quizzes.status','quizzes.created_at','quizzes.updated_at')
                        ->first();
        return view('teacher.quizz.leaderboard',$data);
    }
}
