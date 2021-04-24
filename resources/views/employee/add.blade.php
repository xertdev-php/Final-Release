@extends("layout.app")
@section('title',"Employee")
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Employee</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- /.card -->

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Employee</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form autocomplete="off" method="post" action="{{url("employee")}}">
                            {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="first_name">First Name<span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" value="{{old("first_name")}}" class="form-control" id="first_name" placeholder="First Name">
                                    @if($errors->first("first_name"))
                                        <label class="text-danger text-bold">{{$errors->first('first_name')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" value="{{old("last_name")}}" class="form-control" id="last_name" placeholder="Last Name">
                                    @if($errors->first("last_name"))
                                        <label class="text-danger text-bold">{{$errors->first('last_name')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="middle_name">Middle Name<span class="text-danger">*</span></label>
                                    <input type="text" name="middle_name" value="{{old("middle_name")}}" class="form-control" id="middle_name" placeholder="Middle Name">
                                    @if($errors->first("middle_name"))
                                        <label class="text-danger text-bold">{{$errors->first('middle_name')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="address">Address<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address" id="address" placeholder="Address">{{old("address")}}</textarea>
                                    @if($errors->first("address"))
                                        <label class="text-danger text-bold">{{$errors->first('address')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="department_id">Department<span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="department_id" name="department_id">
                                        <option value="">Select</option>
                                        @if(!$department->isEmpty())
                                            @foreach($department as $department_row)
                                                <option value="{{$department_row->id}}" @if(old("department_id") == $department_row->id) {{"selected"}} @endif>{{$department_row->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->first("department_id"))
                                        <label class="text-danger text-bold">{{$errors->first('department_id')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="country_id">Country<span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="country_id" name="country_id">
                                        <option value="">Select</option>
                                        @if(!$country->isEmpty())
                                            @foreach($country as $country_row)
                                                <option value="{{$country_row->id}}" @if(old("country_id") == $country_row->id) {{"selected"}} @endif>{{$country_row->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->first("country_id"))
                                        <label class="text-danger text-bold">{{$errors->first('country_id')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="state_id">State<span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="state_id" name="state_id">
                                        <option value="">Select</option>
                                    </select>
                                    @if($errors->first("state_id"))
                                        <label class="text-danger text-bold">{{$errors->first('state_id')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="city_id">City<span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="city_id" name="city_id">
                                        <option value="">Select</option>
                                    </select>
                                    @if($errors->first("city_id"))
                                        <label class="text-danger text-bold">{{$errors->first('city_id')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="zip">Zip<span class="text-danger">*</span></label>
                                    <input type="text" name="zip" value="{{old("zip")}}" class="form-control" id="zip" placeholder="Zip">
                                    @if($errors->first("zip"))
                                        <label class="text-danger text-bold">{{$errors->first('zip')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="birth_date">Birth Date</label>
                                    <input type="text" name="birth_date" value="{{old("birth_date")}}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" class="form-control" id="birth_date" placeholder="Birth Date">
                                    @if($errors->first("birth_date"))
                                        <label class="text-danger text-bold">{{$errors->first('birth_date')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="date_hired">Hired Date</label>
                                    <input type="text" name="date_hired" value="{{old("date_hired")}}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" class="form-control" id="date_hired" placeholder="Hired Date">
                                    @if($errors->first("date_hired"))
                                        <label class="text-danger text-bold">{{$errors->first('date_hired')}}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{url('employee')}}" class="btn btn-outline-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section("footer_script")
    <script type="text/javascript">
        var state_id = '{{old("state_id")}}';
        var city_id = '{{old("city_id")}}';
        $(document).ready(function () {
            $(".select2").select2({
                "width":"100%"
            });
            $('#birth_date').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });
            $('#date_hired').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });
            get_state();
            get_city();
            $(document).on("change","#country_id",function () {
                $("#city_id").html("");
                get_state();
            });

            $(document).on("change","#state_id",function () {
                get_city();
            });

        });


        function get_state() {
            var country_id = $("#country_id").val();
            show_loader();
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('employee/get_state') }}",
                async:false,
                data: {
                    "country_id": country_id,
                    "state_id": state_id,
                },
                dataType:"json",
                success: function (response) {
                    hide_loader();
                    $("#state_id").html(response.html);
                },
                error:function (e) {
                    hide_loader();
                    $("#state_id").html("");
                }
            })
        }

        function get_city() {
            var selected_state_id = $("#state_id").val();
            show_loader();
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('employee/get_city') }}",
                data: {
                    "state_id": selected_state_id,
                    "city_id": city_id,
                },
                dataType:"json",
                async:false,
                success: function (response) {
                    hide_loader();
                    $("#city_id").html(response.html);
                },
                error:function (e) {
                    hide_loader();
                    $("#city_id").html("");
                }
            })
        }
        
    </script>
@endsection