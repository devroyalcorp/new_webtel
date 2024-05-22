@extends('master')
@section('title')
    <title>Webtel</title>
@endsection
@section('style')
    <style>
        .dt-scroll-headInner{
            width:100% !important;
        }
        table.dataTable{
            width:100% !important;
        }
        .input_copied{
            border: none !important;
            box-shadow: none !important;
            background-color: white !important;
            cursor: default !important;
            color:#000;
        }
        /* .table_history.dataTable {
            width: 100% !important;
        } */

    .tltp {
        position: relative !important;
        display: inline-block !important;
      }

      .tltp .tltptext {
        visibility: hidden !important;
        width: 140px !important;
        background-color: #555 !important;
        color: #fff !important;
        text-align: center !important;
        border-radius: 6px !important;
        padding: 5px !important;
        position: absolute !important;
        z-index: 1 !important !important;
        bottom: 100% !important;
        left: 50% !important !important;
        margin-left: -30px !important;
        opacity: 0 !important;
        transition: opacity 0.3s !important;
      }

      .tltp .tltptext::after {
        content: "" !important;
        position: absolute !important;
        top: 100% !important;
        left: 50% !important;
        margin-left: -5px !important;
        border-width: 5px !important;
        border-style: solid !important;
        border-color: #555 transparent transparent transparent !important;
      }

      .tltp:hover .tltptext {
        visibility: visible !important;
        opacity: 1 !important;
      }

    </style>
@endsection

@section('content')
    <div class="container-fluid" style="margin-top:15px;">
        <div class="row">
            <div class="col-md-12 text-center" style="margin-top:4rem;margin-bottom:4rem;">
                <p style="margin: 1px 1px 1px 0px !important;font-size:40px;font-weight: bolder;color: #6c757d;">{{Session::get('name_company') ?? ""}}</p>
            </div>
        </div>
        <div class="table-responsive">  
            <table class="table table-striped table-bordered border-light table-hover" id="datatable_webtel">
                <thead style="background-color:#b0d12a !important;font-size:18px;">
                <tr>
                    <th scope="col">Company</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Extention</th>
                    <th scope="col">Email</th>
                    @if(Session::get('login_status'))
                        <th scope="col">Action</th>
                    @endif
                </tr>
                </thead>
            </table>
        </div>

        <!-- Modal Update -->
        <div class="modal fade" id="modal_update" tabindex="-1" aria-labelledby="modal_update" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" style="" id="modal_update_title"></h5>
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
                                            <label>Line Number</label>
                                            <input type="number" class="form-control" id="line_number" name="line_number" placeholder="Line Number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                            <label>Extention Number</label>
                                            <input type="number" class="form-control" id="extention_number" name="extention_number" placeholder="Extention Number" required>
                                            </div>
                                        </div>
                                        <input type="hidden" name="employee_id" id="employee_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-simpan">Save Changes</button>
                        </div>
                    </form>        
                </div>
            </div>
            </div>
        </div>

        <!-- Modal Histories -->
        <div class="modal fade" id="modal_histories" tabindex="-1" aria-labelledby="modal_histories" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" style="" id="modal_histories_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive" style="overflow:auto;">
                    <table class="table table-striped table-bordered border-light table_history" style="" id="datatable_history">
                        <thead style="background-color:#b0d12a !important;font-size:16px;">
                          <tr>
                            <th scope="col">Web Name</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Type</th>
                            <th scope="col">Modified By</th>
                            <th scope="col">Modified At</th>
                          </tr>
                        </thead>
                    </table>       
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    let id_company = {{$id_company ?? null}};
    let table;
    let table_histories;
      
    function copyToClipboard(textToCopy, id){

        var input = document.createElement("input");
        document.body.appendChild(input);
        input.value = textToCopy;
        input.select();
        document.execCommand("Copy");
        input.remove();

        const button_copied = document.getElementById('button_'+id);

        var tltp = document.getElementById("mytltp_"+id);
        tltp.innerHTML = "Copied";

        // button_copied.setAttribute('title', 'Copied!');
        button_copied.setAttribute("style","color:red");
        setTimeout(() => {
            // button_copied.removeAttribute('title');
            // button_copied.setAttribute('title', 'Copy to clipboard!');
            var tltp = document.getElementById("mytltp_"+id);
            tltp.innerHTML = "Copy to Clipboard";
            button_copied.removeAttribute('style');
        }, 2000);
    }

    $(document).ready(function () {
        $('#datatable_webtel').DataTable().destroy();
        $('#datatable_webtel thead tr').clone(true).appendTo('#datatable_webtel thead');
        $('#datatable_webtel thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="filter_table form-control" placeholder="Search ' + title + '" class="form-control"/>');

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


        table = $('#datatable_webtel').DataTable({
            searching: true,
            paging: true,
            lengthChange: true,
            ordering: true,
            info: true,
            // scrollX: true,
            order: [[1, 'asc']],
            orderCellsTop: true,
            responsive: true,
            processing: true,
            serverSide: true,
            @if(Session::get('login_status'))
                "columnDefs": [ {
                    "targets": 5,
                    "orderable": false,
                } ],
            @endif
            ajax: '/webtel/datatables/'+id_company,
            pagingType: "full_numbers",
            dom: "<'row w100'<'col-sm-6 end'B>> <'row w100'<'col-sm-12'tr>><'row mt-2 w100'<'col-sm-4 'l><'col-sm-5'p><'col-sm-3'i>>",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            columns: [
                { 
                    data: 'acronym',
                },
                { 
                    data: 'first_name',
                    render: function ( data, type, row ) { 
                        if(data == null){
                            data = "";
                        }

                        if(row.last_name == null){
                            row.last_name = "";
                        }
                        return data +" "+row.last_name;
                    }
                },
                { 
                    data: 'name',
                },
                { 
                    data: 'line_number',
                    render: function ( data, type, row ) {
                        if(data == null || data == ""){
                            if(row.extention_number == null || row.extention_number == ""){
                                return "(-) "+ " - ";
                            }else{
                                return "(-) "+row.extention_number;
                            }
                        }else{
                            if(row.extention_number == null || row.extention_number == ""){
                                return "("+data+") "+ " - ";
                            }else{
                                return "("+data+") "+row.extention_number;
                            }
                        }
                    }
                },
                { 
                    data: 'work_email',
                    render: function ( data, type, row ) {
                        if(data == null || data == ""){
                            return "-";
                        }else{
                            return data + `<br><div class="tltp"><span class="tltptext" id="mytltp_${row.employee_id}">Copy to clipboard</span><button type="button" class="btn ms-3" data-bs-toggle="tooltip" data-bs-placement="top" id="button_${row.employee_id}" onclick="copyToClipboard('${data}', ${row.employee_id})"><i class="fa fa-copy" aria-hidden="true"></i></button></div>`;
                        }
                    }
                },
                @if(Session::get('login_status'))
                    { 
                        data: 'employee_id',
                        render: function ( data, type, row ) {
                            return `<div class="btn-group" role="group" aria-label="action">
                                    <a type="button" class="btn btn-primary btn-sm" onclick="UpdateEmployee(${data})"><i class="fas fa-edit icon_plus"></i>Edit</a>
                                    <a type="button" class="btn btn-info btn-sm ms-1" onclick="ReadLogHistory(${row.id})"><i class="fas fa-history icon_plus"></i>History</a>
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
            url: `/webtel/get_employee_webtel/`+id,
            type: "GET",
            cache: false,
            success:function(response){
                var data = response.data
                if (response.status == 202) {
                    $('#employee_id').val(data.employee_id)
                    $('#line_number').val(data.line_number)
                    $('#extention_number').val(data.extention_number)
                    if(data.first_name == null){
                        data.first_name = "";
                    }
                    if(data.last_name == null){
                        data.last_name = "";
                    }
                    $('#modal_update_title').text("Update | "+data.first_name+" "+data.last_name)
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

    function ReadLogHistory(id){

        $.ajax({
            url: `/webtel/check_history/`+id,
            type: "GET",
            cache: false,
            success:function(response){
                var data = response.data
                if (response.status == 202) {
                    var name = data.first_name + " " + data.last_name;
                    $('#datatable_history').DataTable().destroy();
                    datatableHistory(data.history_id, name);
                }else{
                    toastr.info("Employee dont have log history !", "Warning!")
                }
            },
            error:function(response){
                // console.log(response.data)
                toastr.error(response.msg, response.title)
                table.draw();
            }
        });
    }

    function datatableHistory(id, name){

        table_histories = $('#datatable_history').DataTable({
            searching: true,
            paging: true,
            lengthChange: true,
            ordering: true,
            info: true,
            // scrollX: true,
            order: [[4, 'desc']],
            orderCellsTop: true,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '/webtel/datatables_loghistory/'+id,
            pagingType: "full_numbers",
            dom: "<'row w100'<'col-sm-6 end'B>> <'row w100'<'col-sm-12'tr>><'row mt-2 w100'<'col-sm-9'p><'col-sm-3'i>>",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            columns: [
                { 
                    data: 'web_name',
                },
                { 
                    data: 'menus',
                },
                { 
                    data: 'type',
                },
                { 
                    data: 'name_user',
                },
                { 
                    data: 'created_at',
                },
            ]
        });

        $('#modal_histories_title').text("Log History | "+name)

        $('#modal_histories').modal('show')

        table_histories.columns.adjust();
        $('#modal_histories').trigger('resize')
    }

    $("#form_update").submit(function(e) {
        e.preventDefault();
        var sendData = new FormData(this);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            url: "{{ route('webtel.update') }}",
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