<?php

namespace App\Http\Controllers;

use App\Model\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    protected $base_url = "department/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('department.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('department.add');
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
            "name"=>"required|unique:departments,name,NULL,id,deleted_at,NULL",
        ]);

        if($validator->fails()){
            return redirect($this->base_url.'create')
                ->withErrors($validator)
                ->withInput();
        }

        unset($input['_token']);
        Department::create($input);
        $request->session()->flash("response","success");
        $request->session()->flash("msg","Department Added Successfully.");
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
        $data['row'] = Department::find($id);
        return view('department.edit')->with($data);
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
            "name"=>["required",function ($attribute, $value, $fail) use ($input,$id) {
                if(Department::where(["name"=>$input['name']])->whereNotIn("id",[$id])->exists()){
                    $fail('The name has already been taken.');
                }
            }],
        ]);

        if($validator->fails()){
            return redirect($this->base_url.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        unset($input['_token']);
        unset($input['_method']);
        Department::where("id",$id)->update($input);
        $request->session()->flash("response","success");
        $request->session()->flash("msg","Department Updated Successfully.");
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
        Department::where("id",$request['id'])->delete();
        return response()->json(array("status"=>"success","message"=>"Record Deleted Successfully"));
    }

    /**
     * @return mixed
     * Datatable Method
     */
    public function datatable(){
        $results = Department::query();

        return DataTables::of($results)
            ->addColumn('action',function ($results){
                $action = '<div class="text-center">';
                $action .= '<a href="' . route("department.edit", $results->id) . '" data-toggle="tooltip" data-placement="top" title="Edit" class=""><i class="fa fa-edit font-medium-5 pl-2"></i></a>';
                $action .= '<a href="javascript:void(0)" data-id="' . $results->id . '" class="delete_btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-alt font-medium-5 pl-2 text-danger"></i></a>';
                $action .= '</div>';
                return $action;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
