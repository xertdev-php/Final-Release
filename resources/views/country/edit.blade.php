@extends("layout.app")
@section('title',"Country")
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Country</h1>
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
                            <h3 class="card-title">Edit Country</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form autocomplete="off" method="post" action="{{route("country.update",$row->id)}}">
                            {{csrf_field()}}
                            {{method_field("PATCH")}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="country_code">Country Code</label>
                                    <input type="text" name="country_code" value="{{$row->country_code}}" class="form-control" id="country_code" placeholder="Country Code">
                                    @if($errors->first("country_code"))
                                        <label class="text-danger text-bold">{{$errors->first('country_code')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{$row->name}}" class="form-control" id="name" placeholder="Name">
                                    @if($errors->first("name"))
                                        <label class="text-danger text-bold">{{$errors->first('name')}}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{url('country')}}" class="btn btn-outline-danger">Cancel</a>
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
