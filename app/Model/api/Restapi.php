<?php


namespace App\Model\api;

use App\Model\City;
use App\Model\Country;
use App\Model\Department;
use App\Model\Employee;
use App\Model\State;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Restapi extends Model
{
    /**
     * @param $input
     * @return mixed
     * Login Process
     */
    public function login($input){

        /**
         * Error Status Explain
         * 0 => Login Success
         * 1 => Email or Password Invalid
         */

        if(User::where(["email"=>$input['email'],"password"=>$input['password']])->exists()) {
            $user_data = User::where("email", $input['email'])->first(["id","username","last_name","first_name","email"])->toArray();
            if (!empty($user_data)) {
                $update['fail_login_date_time'] = null;
                $update['is_fail_login'] = "no";
                $update['total_fail_attempt'] = 0;
                User::where("id", $user_data['id'])->update($update);
                $response['status'] = true;
                $response['message'] = "Login Successfully";
                $response['error_status'] = 0;
                $response['data'] = $user_data;
                return $response;
            } else {
                $response['status'] = false;
                $response['error_status'] = 1;
                $response['message'] = "Email or Password Invalid";
                return $response;
            }
        }else{
            $response['status'] = false;
            $response['error_status'] = 1;
            $response['message'] = "Email or Password Invalid";
            return $response;
        }
    }

    /**
     * @param $input
     * @return mixed
     * Register Process
     */
    public function register($input){

        /**
         * Error Status Explain
         * 0 => Register Success
         * 1 => Email exist
         */

        if(User::where(["email"=>$input['email']])->exists()){
            $email = $input['email'];
            $response['status'] = false;
            $response['error_status'] = 1;
            $response['message'] = "$email is already registered.";
            return $response;
        }else{
            $data = User::create($input);
            $user_id = $data->id;
            $user_data = User::where("id",$user_id)->first(["id","username","last_name","first_name","email"])->toArray();
            $response['status'] = true;
            $response['message'] = "Registration Successfully.";
            $response['error_status'] = 0;
            $response['data'] = $user_data;
            return $response;
        }
    }

    /**
     * @return mixed
     * Get Employee List
     * Order By Last name alphabetically
     */
    public function employee_list(){
        $result = Employee::select("id","last_name","first_name","middle_name","address","zip","birth_date","date_hired","department_id","city_id","state_id","country_id")->orderBy("last_name","asc")->get();

        if(!empty($result)){
            foreach ($result as $item) {
                $item->department_name = Department::where("id",$item->department_id)->value("name");
                $item->city_name = City::where("id",$item->city_id)->value("name");
                $item->state_name = State::where("id",$item->state_id)->value("name");
                $item->country_name = Country::where("id",$item->country_id)->value("name");
            }
        }
        $response['status'] = true;
        $response['message'] = "Employee Data";
        $response['data'] = $result;
        return $response;
    }
}