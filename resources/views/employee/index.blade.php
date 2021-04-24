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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Filter</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" id="filter_frm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control select2" name="department_id" id="department_id">
                                                <option value="">All</option>
                                                @if(!empty($department))
                                                    @foreach($department as $department_row)
                                                        <option value="{{$department_row->id}}">{{$department_row->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <br/>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <button type="button" class="btn btn-outline-danger clear_filter">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Employee</h3>

                            <div class="float-right">
                                <a href="{{url('employee/create')}}" class="btn btn-primary">Add New</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data_table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Middle Name</th>
                                            <th>Department</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
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
        var table;
        $(document).ready(function () {

            var $example = $(".select2").select2({
                "width":"100%"
            });

            show_loader();
            /**
             * Datatable server side call
             * @type {*|jQuery}
             */
            table = $('#data_table').dataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    type : 'post',
                    url:"{{ url('employee/datatable') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        d.department_id = $("#department_id").val();
                    },
                    error:function (e) {
                        hide_loader();
                    }
                },
                columns: [
                    { data: 'first_name'},
                    { data: 'last_name'},
                    { data: 'middle_name'},
                    { data: 'department.name'},
                    { data: 'city.name'},
                    { data: 'state.name'},
                    { data: 'country.name'},
                    { data: 'action'}
                ],
                columnDefs: [
                    { "orderable": false,className: "hidden", "targets": 0 }
                ],
                order:[[0,'desc']],
                "initComplete": function(settings, json) {
                    hide_loader();
                    $('[data-toggle="tooltip"]').tooltip();
                },
                "drawCallback": function( settings ) {
                    hide_loader();
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $(document).on("submit","#filter_frm",function(e){
                e.preventDefault();
                show_loader();
                table.fnDraw();
            });
            $(document).on("click",".clear_filter",function(){
                $('#filter_frm')[0].reset();
                $example.select2();
                show_loader();
                table.fnDraw();
            });

            /**
             * Delete Record Call
             */
            $(document).on("click",".delete_btn",function () {

                var id = $(this).data("id");
                Swal.fire( {
                        title: "Are you sure?",
                        text: "You want to delete this record?",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!",
                        confirmButtonClass: "btn btn-primary",
                        cancelButtonClass: "btn btn-danger ml-1",
                        buttonsStyling: !1
                    }
                ).then(function(t) {
                        if(t.value){
                            show_loader();
                            $.ajax({
                                type: "post",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: "{{ url('employee/destroy') }}",
                                data: {
                                    "id": id
                                },
                                dataType:"json",
                                success: function (response) {
                                    hide_loader();
                                    if(response.status == "success") {
                                        table.fnDraw();
                                        show_message('success', 'Record deleted successfully.');
                                    }else{
                                        show_message("fail",response.message);
                                    }
                                },
                                error:function (e) {
                                    hide_loader();
                                    show_message('fail','Something goes to wrong. please try again');
                                }
                            })
                        }

                    }
                )
            });
        });
    </script>
@endsection