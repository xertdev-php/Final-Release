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
                            <h3 class="card-title">Edit User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form autocomplete="off" method="post" action="{{route("users.update",$row->id)}}">
                            {{csrf_field()}}
                            {{method_field("PATCH")}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input type="text" name="username" value="{{$row->username}}" class="form-control" id="username" placeholder="User Name">
                                    @if($errors->first("username"))
                                        <label class="text-danger text-bold">{{$errors->first('username')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" value="{{$row->first_name}}" class="form-control" id="first_name" placeholder="First Name">
                                    @if($errors->first("first_name"))
                                        <label class="text-danger text-bold">{{$errors->first('first_name')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" value="{{$row->last_name}}" class="form-control" id="last_name" placeholder="Last Name">
                                    @if($errors->first("last_name"))
                                        <label class="text-danger text-bold">{{$errors->first('last_name')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{$row->email}}" id="email" placeholder="Email">
                                    @if($errors->first("email"))
                                        <label class="text-danger text-bold">{{$errors->first('email')}}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" value="{{$row->password}}" id="password" placeholder="Password">
                                    @if($errors->first("password"))
                                        <label class="text-danger text-bold">{{$errors->first('password')}}</label>
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
