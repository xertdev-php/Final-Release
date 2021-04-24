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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Country</h3>

                            <div class="float-right">
                                <a href="{{url('country/create')}}" class="btn btn-primary">Add New</a>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="data_table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Country Code</th>
                                            <th>Name</th>
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
                    url:"{{ url('country/datatable') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error:function (e) {
                        hide_loader();
                    }
                },
                columns: [
                    { data: 'country_code'},
                    { data: 'name'},
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
                                url: "{{ url('country/destroy') }}",
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