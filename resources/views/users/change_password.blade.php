@extends("layout.app")
@section('title',"Users")
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Users</h1>
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
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form autocomplete="off" method="post" action="{{url("users/update-password")}}">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$row->id}}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" class="form-control" name="new_password" value="" id="new_password" placeholder="New Password">
                                    @if($errors->first("new_password"))
                                        <label class="text-danger text-bold">{{$errors->first('new_password')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="confirm_new_password">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirm_new_password" value="" id="confirm_new_password" placeholder="Confirm New Password">
                                    @if($errors->first("confirm_new_password"))
                                        <label class="text-danger text-bold">{{$errors->first('confirm_new_password')}}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{url('users')}}" class="btn btn-outline-danger">Cancel</a>
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
