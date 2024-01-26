<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Quizzes;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuestionsController extends Controller
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
            $data = Questions::select(['questions.*','quizzes.quizz_title'])
                ->leftJoin('quizzes','questions.quizz_id', '=','quizzes.quizz_id')
                ->orderBy('question_id','desc')->get();
            return DataTables::of($data)
                ->addColumn('image',function($row){
                    if($row->image != ''){
                        $img = '<img src="'.asset("question/".$row->image).'" width="70px">';
                    }else{
                        $img = '<img src="'.asset("question/no-image.png").'" width="70px">';
                    }
                    return $img;
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="questions/'.$row->question_id.'/edit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete-question btn btn-danger btn-sm" data-id="'.$row->question_id.'"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','image'])
                ->make(true);
        }
        return view('teacher.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $Quizzes = Quizzes::all();
        return view('teacher.questions.create',['quiz'=>$Quizzes]);
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
            'question'=>'required',
            'quizz'=>'required',
            'choices'=>'required',
            'correct'=>'required',
        ]);
        
        // return var_dump($request->input('choices'));

        $Questions = new Questions();
        $Questions->question = $request->input("question");
        $Questions->quizz_id = $request->input("quizz");
        $Questions->choices = json_encode($request->input("choices"));
        $Questions->correct_answer = $request->input("correct");
        if($request->img){
            $image = $request->img->getClientOriginalName();
            $request->img->move(public_path('question'),$image);
            $Questions->image = $image;
        }
        $result = $Questions->save();
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
        $Quizzes = Quizzes::all();
        $Questions = Questions::where(['question_id'=>$id])->get();
        return view('teacher.questions.edit',['question'=>$Questions,'quizz'=>$Quizzes]);
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
            'question'=>'required',
            'quizz'=>'required',
            'choices'=>'required',
            'correct'=>'required',
        ]);
        
           // update Teacher image
        if($request->img != ''){        
            $path = public_path().'/question/';
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

        $Questions = Questions::where(['question_id'=>$id])->update([
            "question" => $request->input("question"),
            "quizz_id" => $request->input("quizz"),
            "choices" => json_encode($request->input("choices")),
            "correct_answer" => $request->input("correct"),
            "image" =>$image,
        ]);
        return $Questions;
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
        $destroy = Questions::where('question_id',$id)->delete();
        return  $destroy;
    }
}
