<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $base_url = "";

    public function index(){
        if(!Session::has('admin_session')) {
            return view('login');
        }else{
            return redirect(url('dashboard'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * Check Login Process
     */
    public function login_process(Request $request){
        $validator = Validator::make($request->all(),[
            "email"=>"required|email",
            "password"=>"required"
        ]);

        if($validator->fails()){
            return redirect($this->base_url)
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->input();
        if(User::where(["email"=>$input['email'],"password"=>$input['password']])->exists()){
            $user_data = User::where(["email"=>$input['email'],"password"=>$input['password']])->first();
            if(!empty($user_data)){

                /**
                 * Set Default value of Fail attempt field
                 */
                $update['fail_login_date_time'] = null;
                $update['is_fail_login'] = "no";
                $update['total_fail_attempt'] = 0;
                User::where("id",$user_data->id)->update($update);

                session(["admin_session"=>array("id" => $user_data->id,
                    "name" => $user_data->username)
                ]);
                $request->session()->flash("response","success");
                $request->session()->flash("msg","Login Successfully");
                return redirect(url('dashboard'));
            }else{
                $request->session()->flash('login_error', 'Email or Password invalid');
                return redirect($this->base_url);
            }
        }else{
            $request->session()->flash('login_error', 'Email or Password invalid');
            return redirect($this->base_url);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * User Logout
     */
    public function logout(){
        Session::forget('admin_session');
        return redirect($this->base_url);
    }
}
