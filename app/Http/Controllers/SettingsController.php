<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function general_settings(Request $request){


        if($request->input()){
            // return $request;
            $request->validate([
                'site_name'=> 'required',
                'site_title'=> 'required',
                'email'=> 'required',
                'phone'=> 'required',
                'logo'=> 'image|mimes:jpg,jpeg,png,svg'
            ]);

            if($request->logo != ''){        
                $path = public_path().'/site-img/';

                //code for remove old file
                if($request->old_logo != ''  && $request->old_logo != null){
                    $file_old = $path.$request->old_logo;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                //upload new file
                $file = $request->logo;
                $filename = rand().$file->getClientOriginalName();
                $file->move($path, $filename);
            }else{
                $filename = $request->old_logo;
            }

            $update = DB::table('settings')->update([
                'site_name'=>$request->site_name,
                'site_title'=>$request->site_title,
                'site_email'=>$request->email,
                'site_phone'=>$request->phone,
                'site_logo'=>$filename,
            ]);
            return $update;

        }else{
            $settings = DB::table('settings')->get();
            return view('admin.settings.general-settings',['data'=>$settings]);
        }
    }


    public function profile_settings(Request $request){

        if($request->input()){
            $request->validate([
                'admin_name'=> 'required',
                'email'=> 'required|email:rfc',
                'username'=> 'required',
                'image'=> 'image|mimes:jpg,jpeg,png,svg'
            ]);

            if($request->image != ''){        
                $path = public_path().'/site-img/';

                //code for remove old file
                if($request->old_image != ''  && $request->old_image != null){
                    $file_old = $path.$request->old_image;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                //upload new file
                $file = $request->image;
                $filename = rand().$file->getClientOriginalName();
                $file->move($path, $filename);
            }else{
                $filename = $request->old_image;
            }

            $update = DB::table('admins')->update([
                'admin_name'=>$request->admin_name,
                'email'=>$request->email,
                'username'=>$request->username,
                'image'=>$filename
            ]);
            $request->session()->put('admin_name',$request->admin_name);
            return $update;

        }else{
            $settings = DB::table('admins')->select('admin_name','username','email','image')->get();
            return view('admin.settings.profile-settings',['data'=>$settings]);
        }
    }

    public function change_password(Request $request){

        if($request->input()){

            
            $request->validate([
                'old_password'=> 'required',
                'new_password'=> 'required',
                'con_password'=> 'required'
            ]);
            //return $request->input();
            $select = DB::table('admins')->pluck('password');
            //return $select[0];
            //print_r($select);
            
            if(Hash::check($request->old_password,$select[0])){
                $update = DB::table('admins')->update([
                    'password'=>Hash::make($request->new_password)
                ]);
                session()->forget('admin');
		        session()->forget('username');
                return '1';
            }else{
                return response()->json(['old_password'=>'Please Enter Correct Old Password']);
            }
        }else{
            return view('admin.settings.change-password');
        }
    }
}
