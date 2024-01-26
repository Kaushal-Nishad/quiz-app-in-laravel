<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Questions;
use App\Models\Quizzes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request){
        //
        if($request->input()){
            $request->validate([
                'admin'=>'required',
                'password'=>'required',
            ]); 
            $login = Admin::where(['username'=>$request->admin])->pluck('password')->first();
            
            if(empty($login)){
                    return response()->json(['username'=>'Username Does not Exists']);
                }else{
                    
                    if(Hash::check($request->password,$login)){
                        $admin = Admin::first();
                        $request->session()->put('admin','1');
                        $request->session()->put('admin_name',$admin->admin_name);
                        $request->session()->put('admin_image',$admin->image);
                        return '1';
                    }else{
                        return response()->json(['password'=>'Username and Password does not matched']);
                    }
                }
	    }else{
			return view('admin.admin');
		}
  
    }
	
	
	public function dashboard(){
        //
        $data['subjects'] = Subject::count();
        $data['teachers'] = Teacher::count();
        $data['students'] = Student::count();
        $data['quizzes'] = Quizzes::count();
        $data['latest_quizzes'] = Quizzes::select(['quizzes.quizz_title','quizzes.status','teachers.teacher_name'])
                                        ->join('teachers','teachers.teacher_id','=','quizzes.teacher_id')
                                        ->limit(5)
                                        ->get();
        $data['latest_questions'] = Questions::select(['questions.question','quizzes.quizz_title','teachers.teacher_name'])
                                        ->leftJoin('quizzes','quizzes.quizz_id','=','questions.quizz_id')
                                        ->leftJoin('teachers','teachers.teacher_id','=','quizzes.teacher_id')
                                        ->limit(5)
                                        ->get();

        return view('admin.dashboard',$data);
    }

    public function logout(Request $req){
		Auth::logout();
		session()->forget('admin');
		session()->forget('username');
		return '1';
	}
}
