<?php

namespace App\Http\Controllers;

use App\Model\api\Restapi;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    protected $base_url = "users/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($request->all(),[
            "email"=>"required|email|unique:users,email,NULL,id,deleted_at,NULL",
            "username"=>"required",
            "last_name"=>"required",
            "first_name"=>"required",
            "password"=>"required",
        ]);

        if($validator->fails()){
            return redirect($this->base_url.'create')
                ->withErrors($validator)
                ->withInput();
        }

        unset($input['_token']);
        User::create($input);
        $request->session()->flash("response","success");
        $request->session()->flash("msg","User Added Successfully.");
        return redirect($this->base_url);
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
        $data['row'] = User::find($id);
        return view('users.edit')->with($data);
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
        $input = $request->input();
        $validator = Validator::make($request->all(),[
            "email"=>["required",function ($attribute, $value, $fail) use ($input,$id) {
                if(User::where(["email"=>$input['email']])->whereNotIn("id",[$id])->exists()){
                    $fail('The email has already been taken.');
                }
            }],
            "username"=>"required",
            "last_name"=>"required",
            "first_name"=>"required",
            "password"=>"required",
        ]);

        if($validator->fails()){
            return redirect($this->base_url.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        unset($input['_token']);
        unset($input['_method']);
        User::where("id",$id)->update($input);
        $request->session()->flash("response","success");
        $request->session()->flash("msg","User Updated Successfully.");
        return redirect($this->base_url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::where("id",$request['id'])->delete();
        return response()->json(array("status"=>"success","message"=>"Record Deleted Successfully"));
    }

    /**
     * @return mixed
     * Datatable Method
     */
    public function datatable(){
        $results = User::query();

        return DataTables::of($results)
            ->addColumn('action',function ($results){
                $action = '<div class="text-center">';
                $action .= '<a href="' . route("users.edit", $results->id) . '" data-toggle="tooltip" data-placement="top" title="Edit" class=""><i class="fa fa-edit font-medium-5 pl-2"></i></a>';
                $action .= '<a href="' . url("users/change-password", $results->id) . '" data-toggle="tooltip" data-placement="top" title="Change Password" class=""><i class="fa fa-key text-info font-medium-5 pl-2"></i></a>';
                $action .= '<a href="javascript:void(0)" data-id="' . $results->id . '" class="delete_btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-alt font-medium-5 pl-2 text-danger"></i></a>';
                $action .= '</div>';
                return $action;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Load Change Password View File
     */
    public function change_password($id){
        $data['row'] = User::find($id);
        return view('users.change_password')->with($data);
    }

    /**
     * @param Request $request
     * Update Password Process
     */
    public function update_password(Request $request){
        $input = $request->input();
        $validator = Validator::make($request->all(),[
            "new_password"=>"required",
            "confirm_new_password"=>"required|same:new_password",
        ]);

        if($validator->fails()){
            return redirect($this->base_url.'change-password/'.$input['id'])
                ->withErrors($validator)
                ->withInput();
        }

        User::where("id",$input['id'])->update(array("password"=>$input['new_password']));
        $request->session()->flash("response","success");
        $request->session()->flash("msg","Password Change Successfully.");
        return redirect($this->base_url);
    }
}
