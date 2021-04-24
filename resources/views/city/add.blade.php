@extends("layout.app")
@section('title',"City")
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>City</h1>
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
                            <h3 class="card-title">Add New City</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form autocomplete="off" method="post" action="{{url("city")}}">
                            {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <select class="form-control" name="state" id="state">
                                        <option value="">Select</option>
                                        @if(!$state->isEmpty())
                                            @foreach($state as $state_row)
                                                <option value="{{$state_row->id}}" @if(old("state") == $state_row->id) {{"selected"}} @endif>{{$state_row->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->first("state"))
                                        <label class="text-danger text-bold">{{$errors->first('state')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{old("name")}}" class="form-control" id="name" placeholder="Name">
                                    @if($errors->first("name"))
                                        <label class="text-danger text-bold">{{$errors->first('name')}}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{url('city')}}" class="btn btn-outline-danger">Cancel</a>
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
        $("#state").select2({
            "width":"100%"
        });
    </script>
@endsection