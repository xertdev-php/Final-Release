<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Model\api\Restapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RestapiController extends Controller{

    protected $secretKey = 'EP5UVmGbB34btNFEXKWHSckxZ5yVMmd9XQZkuSjohvGm5b7EV16HrJMu7Q0oRq0a';
    protected $restapi;
    public function __construct(Request $request){
        $this->check_api_key($request);
        $this->restapi = new Restapi();
    }

    private function check_api_key(Request $request){
        if(!$request->hasHeader("Api-Key") || $request->header("Api-Key") != $this->secretKey){
            exit(response()->json(array("success"=>true,"message"=>"Unauthorized access!")));
        } else{
            return true;
        }
    }

    public function login(Request $request){
        $response = $this->restapi->login($request->all());
        return response()->json($response);
    }

    public function register(Request $request){
        $response = $this->restapi->register($request->all());
        return response()->json($response);
    }
    public function employee_list(Request $request){
        $response = $this->restapi->employee_list();
        return response()->json($response);
    }
}