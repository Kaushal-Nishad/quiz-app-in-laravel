<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SubjectController extends Controller
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
            $data = Subject::latest()->orderBy('subject_id','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->subject_id.'" class="edit_subject btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-subject btn btn-danger btn-sm" data-id="'.$row->subject_id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.subject.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //return view('subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
                'sub_name'=>'required|unique:subjects,subject_name'
        ];
        $messages = [
            'sub_name.required' => 'Subject Name is Required',
            'sub_name.unique' => 'This Subject Name is already Exists',
        ];

        $this->validate($request,$rules,$messages);
      
        $Subjects = new Subject;
        $Subjects->subject_name = $request->input("sub_name");
        $result = $Subjects->save();
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
        $Subjects = Subject::where('subject_id',$id)->get();
        return $Subjects;
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
        $rules = [
            'sub_name'=>['required',Rule::unique('subjects','subject_name')->where(function ($query) use ($id) {
                return $query->where('subject_id','!=',$id);
            })]
        ];
        $messages = [
            'sub_name.required' => 'Subject Name is Required',
            'sub_name.unique' => 'This Subject Name is already Exists',
        ];

        $this->validate($request,$rules,$messages);

        // $request->validate([
        //     'sub_name'=>'required'
        // ]);

        $Subjects = Subject::where(['subject_id'=>$id])->update([
            "subject_name"=>$request->input('sub_name'),
        ]);
        return $Subjects;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher = Teacher::where('designation',$id)->first();
        $student = Student::whereRaw('FIND_IN_SET(?,subjects)', [$id])->first();
        if($student === null && $teacher === null){
            $destroy = Subject::where('subject_id',$id)->delete();
        return  $destroy;
        }else{
            return "You won't delete this.";
        }
    }
}
