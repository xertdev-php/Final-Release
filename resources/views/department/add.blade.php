@extends("layout.app")
@section('title',"Departments")
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Departments</h1>
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
                            <h3 class="card-title">Add New Department</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form autocomplete="off" method="post" action="{{url("department")}}">
                            {{csrf_field()}}
                            <div class="card-body">
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
                                <a href="{{url('department')}}" class="btn btn-outline-danger">Cancel</a>
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
