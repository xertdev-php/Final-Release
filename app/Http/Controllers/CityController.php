<?php

namespace App\Http\Controllers;

use App\Model\City;
use App\Model\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{
    protected $base_url = "city/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('city.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['state'] = State::orderBy("name","asc")->get();
        return view('city.add')->with($data);
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
            "name"=>"required|unique:cities,name,NULL,id,deleted_at,NULL",
            "state"=>"required",
        ]);

        if($validator->fails()){
            return redirect($this->base_url.'create')
                ->withErrors($validator)
                ->withInput();
        }

        unset($input['_token']);
        City::create($input);
        $request->session()->flash("response","success");
        $request->session()->flash("msg","City Added Successfully.");
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
        $data['state'] = State::orderBy("name","asc")->get();
        $data['row'] = City::find($id);
        return view('city.edit')->with($data);
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
                if(City::where(["name"=>$input['name']])->whereNotIn("id",[$id])->exists()){
                    $fail('The name has already been taken.');
                }
            }],
            "state"=>"required",
        ]);

        if($validator->fails()){
            return redirect($this->base_url.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        unset($input['_token']);
        unset($input['_method']);
        City::where("id",$id)->update($input);
        $request->session()->flash("response","success");
        $request->session()->flash("msg","City Updated Successfully.");
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
        City::where("id",$request['id'])->delete();
        return response()->json(array("status"=>"success","message"=>"Record Deleted Successfully"));
    }

    /**
     * @return mixed
     * Datatable Method
     */
    public function datatable(){
        $results = City::with("state");

        return DataTables::of($results)
            ->addColumn('action',function ($results){
                $action = '<div class="text-center">';
                $action .= '<a href="' . route("city.edit", $results->id) . '" data-toggle="tooltip" data-placement="top" title="Edit" class=""><i class="fa fa-edit font-medium-5 pl-2"></i></a>';
                $action .= '<a href="javascript:void(0)" data-id="' . $results->id . '" class="delete_btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-alt font-medium-5 pl-2 text-danger"></i></a>';
                $action .= '</div>';
                return $action;
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
