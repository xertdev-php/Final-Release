<?php

namespace App\Http\Controllers;

use App\Model\City;
use App\Model\Country;
use App\Model\Department;
use App\Model\Employee;
use App\Model\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    protected $base_url = "employee/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['department'] = Department::orderBy("name","asc")->get();
        return view('employee.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['department'] = Department::orderBy("name","asc")->get();
        $data['country'] = Country::orderBy("name","asc")->get();
        return view('employee.add')->with($data);
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
            "last_name"=>"required",
            "first_name"=>"required",
            "middle_name"=>"required",
            "address"=>"required",
            "department_id"=>"required",
            "city_id"=>"required",
            "state_id"=>"required",
            "country_id"=>"required",
            "zip"=>"required|numeric|digits:6",
        ]);

        if($validator->fails()){
            return redirect($this->base_url.'create')
                ->withErrors($validator)
                ->withInput();
        }

        unset($input['_token']);
        if(!empty($input['birth_date'])){
            $input['birth_date'] = date('Y-m-d',strtotime($input['birth_date']));
        }
        if(!empty($input['date_hired'])){
            $input['date_hired'] = date('Y-m-d',strtotime($input['date_hired']));
        }
        Employee::create($input);
        $request->session()->flash("response","success");
        $request->session()->flash("msg","Employee Added Successfully.");
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
        $data['department'] = Department::orderBy("name","asc")->get();
        $data['country'] = Country::orderBy("name","asc")->get();
        $data['row'] = Employee::find($id);
        return view('employee.edit')->with($data);
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
            "last_name"=>"required",
            "first_name"=>"required",
            "middle_name"=>"required",
            "address"=>"required",
            "department_id"=>"required",
            "city_id"=>"required",
            "state_id"=>"required",
            "country_id"=>"required",
            "zip"=>"required|numeric|digits:6",
        ]);

        if($validator->fails()){
            return redirect($this->base_url.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        unset($input['_method']);
        unset($input['_token']);
        if(!empty($input['birth_date'])){
            $input['birth_date'] = date('Y-m-d',strtotime($input['birth_date']));
        }
        if(!empty($input['date_hired'])){
            $input['date_hired'] = date('Y-m-d',strtotime($input['date_hired']));
        }
        Employee::where("id",$id)->update($input);
        $request->session()->flash("response","success");
        $request->session()->flash("msg","Employee Updated Successfully.");
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
        Employee::where("id",$request['id'])->delete();
        return response()->json(array("status"=>"success","message"=>"Record Deleted Successfully"));
    }

    /**
     * @return mixed
     * Datatable Method
     */
    public function datatable(Request $request){
        $input = $request->input();
        $results = Employee::with(["department","country","state","city"]);
        return DataTables::of($results)
            ->filter(function($query) use ($input) {
                if(isset($input['department_id']) && !empty($input['department_id'])){
                    $query->where('department_id', $input['department_id']);
                }
            },true)
            ->addColumn('action',function ($results){
                $action = '<div class="text-center">';
                $action .= '<a href="' . route("employee.edit", $results->id) . '" data-toggle="tooltip" data-placement="top" title="Edit" class=""><i class="fa fa-edit font-medium-5 pl-2"></i></a>';
                $action .= '<a href="javascript:void(0)" data-id="' . $results->id . '" class="delete_btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-alt font-medium-5 pl-2 text-danger"></i></a>';
                $action .= '</div>';
                return $action;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }

    /**
     * @param Request $request
     * Get State From Country ID
     */
    public function get_state(Request $request){
        $input = $request->input();
        $country_id = $input['country_id'];
        $state_id = $input['state_id'];
        $option  = '<option value="">Select</option>';
        if(!empty($country_id)){
            $result = State::where("country",$country_id)->orderBy("name","asc")->get();
            if(!empty($result)){
                foreach ($result as $item) {
                    $selected = '';
                    if($state_id == $item->id){
                        $selected = "selected";
                    }
                    $option .= '<option value="'.$item->id.'" '.$selected.'>'.$item->name.'</option>';
                }
            }
        }
        return response()->json(["status"=>"success","html"=>$option]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Get City From State
     */
    public function get_city(Request $request){
        $input = $request->input();
        $city_id = $input['city_id'];
        $state_id = $input['state_id'];
        $option  = '<option value="">Select</option>';
        if(!empty($state_id)){
            $result = City::where("state",$state_id)->orderBy("name","asc")->get();
            if(!empty($result)){
                foreach ($result as $item) {
                    $selected = '';
                    if($city_id == $item->id){
                        $selected = "selected";
                    }
                    $option .= '<option value="'.$item->id.'" '.$selected.'>'.$item->name.'</option>';
                }
            }
        }
        return response()->json(["status"=>"success","html"=>$option]);
    }
}
