@extends('master')
@section('title')
    <title>Webmail</title>
@endsection
@section('style')
    <style>
    </style>
@endsection

@section('content')
    <div class="container-fluid" style="margin-top:15px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page" style="font-size:30px;"><b>{{$data_companies['name'] ?? "-"}}</b></li>
            </ol>
        </nav>
        <table class="table table-responsive table-striped table-bordered" id="datatable_webmail">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Department</th>
                <th scope="col">Email</th>
                @if(Session::get('login_status'))
                    <th scope="col">Action</th>
                @endif
              </tr>
            </thead>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="modal_update" tabindex="-1" aria-labelledby="modal_update" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modal_update">Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_update">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                            <label>Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="email">
                                            </div>
                                        </div>
                                        <input type="hidden" name="employee_id" id="employee_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-simpan">Save Changes</button>
                        </div>
                    </form>        
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    let id_company = {{$id_company}};
    let table;

    $(document).ready(function () {
        $('#datatable_webmail').DataTable().destroy();
        $('#datatable_webmail thead tr').clone(true).appendTo('#datatable_webmail thead');
        $('#datatable_webmail thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="filter_table" placeholder="Cari ' + title + '" class="form-control"/>');

            if (title == 'Action') {
                $(this).empty();
            }
            $('input', this).on('keyup change', $.debounce(1000, function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            }));
        });


        table = $('#datatable_webmail').DataTable({
            searching: true,
            paging: true,
            lengthChange: true,
            ordering: true,
            info: true,
            order: [[0, 'asc']],
            orderCellsTop: true,
            autoWidth: false,
            responsive: true,
            processing: true,
            serverSide: true,
            @if(Session::get('login_status'))
                "columnDefs": [ {
                    "targets": 3,
                    "orderable": false,
                } ],
            @endif
            ajax: '/webmail/datatables/'+id_company,
            pagingType: "full_numbers",
            dom: "<'row w100'<'col-sm-6'l><'col-sm-6 end'B>> <'row w100'<'col-sm-12'tr>><'row w100'<'col-sm-5'i><'col-sm-7'p>>",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            columns: [
                { 
                    data: 'first_name',
                },
                { 
                    data: 'name',
                },
                { 
                    data: 'work_email',
                    render: function ( data, type, row ) {
                        if(data == null || data == ""){
                            return "-";
                        }else{
                            return data;
                        }
                    }
                },
                @if(Session::get('login_status'))
                    { 
                        data: 'employee_id',
                        render: function ( data, type, row ) {
                            return `<div class="btn-group" role="group" aria-label="action">
                                    <a type="button" class="btn btn-primary btn-sm" onclick="UpdateEmployee(${data})"><i class="fas fa-edit icon_plus"></i>Edit</a>
                                    </div>`;
                        }
                    },
                @endif
            ]
        });
        
    });

    var done = function(response) {
        $('#modal_update').modal('hide')
        table.draw()
    }

    var loading = function() {
        $('.btn-simpan').attr('disabled', 'disabled')
        $('.btn-simpan').val('Menyimpan data...')
    }

    var loadingDone = function(response) {
        $('.btn-simpan').removeAttr('disabled')
        $('.btn-simpan').val('Simpan')
    }

    function UpdateEmployee(id){
        $.ajax({
            url: `/webmail/get_employee_webmail/`+id,
            type: "GET",
            cache: false,
            success:function(response){
                var data = response.data
                if (response.status == 202) {
                    $('#employee_id').val(data.employee_id)
                    $('#email').val(data.work_email)
                    $('#modal_update').modal('show')
                }else{
                    toastr.error(response.msg, response.title)
                }
            },
            error:function(response){
                // console.log(response.data)
                toastr.error(response.msg, response.title)
                table.draw();
            }
        });
    }

    $("#form_update").submit(function(e) {
        e.preventDefault();
        var sendData = new FormData(this);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            url: "{{ route('webmail.update') }}",
            method: 'POST',
            data: sendData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                loading()
            },
            success: function(response) {
                loadingDone()

                if (response.status == 202) {
                    toastr.success(response.msg, response.title)
                }else{
                    toastr.error(response.msg, response.title)
                }
              done();
            },
            error: function(response) {
              loadingDone()
              done();
              toastr.error(response.msg, response.title)
            },
            complete: function(response) {}
        });
    });

</script>
@endsection