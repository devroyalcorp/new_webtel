@extends('master')
@section('title')
    <title>Webtel</title>
@endsection

@section('content')
        <div class="row" style="margin-top:15px;">
          <div class="col-12 text-center my-4">
            <p class="m-0" style="font-size: 40px; font-weight: bolder; color: #001f3f; font-family: 'Roboto', serif;">
                {{ Session::get('name_company') ?? "" }}
            </p>
          </div>
          <div class="col-12 d-flex justify-content-center">  
            <div class="table-responsive" style="width: 90%;">  
                <table class="table table-striped table-bordered border-light table-hover mx-auto" id="datatable_webtel">
                    <thead class="custom-header">
                        <tr>
                            <th scope="col">Company</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Extension</th>
                            <th scope="col">Email</th>
                            @if(Session::get('login_status'))
                                <th scope="col">Action</th>
                            @endif
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
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

        <!-- Modal Emails -->
        <div class="modal fade" id="modal_emails" tabindex="-1" aria-labelledby="modal_emails" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" style="" id="modal_emails_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body-email">
                    
                </div>
            </div>
            </div>
        </div>

        <!-- Modal Spinner -->
        <div class="modal fade" id="modal_spinner" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_spinner" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center" id="modal-body-email">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                      <br>
                      <h5>Please Wait
                        <div class="spinner-grow" style="width: 0.3rem; height: 0.3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-grow" style="width: 0.3rem; height: 0.3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-grow" style="width: 0.3rem; height: 0.3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-grow" style="width: 0.3rem; height: 0.3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </h5>
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
            pagingType: "simple_numbers",
            dom: "<'row w100'<'col-sm-6 end'B>> <'row w100'<'col-sm-12'tr>><'row mt-2 w100'<'col-sm-4 'l><'col-sm-5'p><'col-sm-3'i>>",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            columns: [
                { 
                    data: 'acronym',
                },
                { 
                    data: 'full_name',
                },
                { 
                    data: 'name',
                },
                { 
                    data: 'full_extention_number',
                },
                { 
                    data: 'employee_id',
                    render: function ( data, type, row ) {
                        return `<div class="btn-group" role="group" aria-label="action">
                                    <a class="text-secondary me-2" style="margin-top: 0.4rem !important;" role="button" onclick="ShowEmails(${data})" data-bs-toggle="tooltip" data-bs-placement="top" title="Emails">
                                        See All Emails...
                                    </a>
                                </div>`;
                    }
                },
                @if(Session::get('login_status'))
                {
                    data: 'employee_id',
                    render: function (data, type, row) {
                        return `<div class="btn-group" role="group" aria-label="action">
                                    <span class="text-secondary me-2" style="margin-top: 0.4rem !important;" role="button" onclick="UpdateEmployee(${data})" data-bs-toggle="tooltip" data-bs-placement="top" title="Update">
                                        <i class="fas fa-pen icon_plus"></i>
                                    </span>
                                    <span class="text-secondary" style="margin-top: 0.4rem !important;" role="button" onclick="ReadLogHistory(${row.id})" data-bs-toggle="tooltip" data-bs-placement="top" title="History">
                                        <i class="fas fa-history icon_plus"></i>
                                    </span>
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

    function ShowEmails(id){

        $.ajax({
            url: `/webtel/showEmails/`+id,
            type: "GET",
            cache: true,
            beforeSend:function(response){
                $('#modal_spinner').modal('show')
            },
            success:function(response){
                var data = response.data;
                let html = '';
                $('#modal_spinner').hide()
                if (response.status == 202) {
                    $('#modal_spinner').hide()
                    html += `<ul class="list-group">`;
                    data.emails.forEach((value,index)=>{
                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">`
                        html += `<input style="width:350px;border: none;border-color: transparent;" class="inputercopy" id="inputer_${data.employee_id}_${index}" value="${value}" disabled/ >`
                        if(index == 0){
                            html += `<i class="fas fa-star icon_plus"></i>`
                            html += `<div class="btn-group" role="group" aria-label="action">`
                        }else{
                            html += `<div class="btn-group" role="group" aria-label="action">
                            <button type="button" class="btn ms-3 text-primary" style="border:1px solid blue;" title="Set Primary Email" id="button_set" data-email="${value}" data-id="${data.employee_id}" ">
                                    Set Primary
                            </button>`
                        }
                        html += `
                                <div class="tltp">
                                    <span class="tltptext" id="mytltp_${data.employee_id}_${index}">Copy email to clipboard</span>
                                    <button type="button" class="btn ms-3 text-dark" style="border:1px solid gray" data-bs-toggle="tooltip" data-bs-placement="top" id="button_copy" data-email="${value}" data-id="${data.employee_id}_${index}" ">
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </li>`;
                    })
                    html +=`</ul>`;
                    $('#modal-body-email').html(html);
                    $('#modal_emails_title').text('Employee Emails')
                    $('#modal_emails').modal('show')
                    toastr.success("", response.title)
                }else{
                    $('#modal_spinner').hide()
                    $('#modal_emails').modal('hide')
                    toastr.info("Employee dont have emails !", "Warning!")
                }
            },
            error:function(response){
                // console.log(response.data)
                $('#modal_spinner').hide()
                toastr.error(response.msg, response.title)
                table.draw();
            },
            complete: function () {
                $('#modal_spinner').hide();
            }
        });
    }

    $(document).ready(function(){
        $('body').on('click', '#button_copy', function() {
            const id = $(this).attr('data-id');
            const email = $(this).attr('data-email');
            copyToClipboard(email, id);
        });

        $('body').on('click', '#button_set', function() {
            const employee_id = $(this).attr('data-id');
            const email = $(this).attr('data-email');
            setEmails(email, employee_id);
        });
    });

    function setEmails(email, employee_id){
        console.log(email, employee_id)
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            url: "{{ route('webtel.set_primary_emails') }}",
            method: 'POST',
            data: {
                'employee_id' : employee_id,
                'email' : email,
            },
            success:function(response){
                var data = response.data
                if (response.status == 202) {
                    ShowEmails(data.employee_id)
                }else{
                    toastr.info(response.msg, response.title)
                }
            },
            error:function(response){
                // console.log(response.data)
                toastr.error(response.msg, response.title)
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

    function copyToClipboard(textToCopy, id){

        var input = document.getElementById("inputer_"+id);
        input.value;
        console.log(input.value);
        input.disabled = false;
        input.select();
        document.execCommand("Copy");
        input.disabled = true;
        var tltp = document.getElementById("mytltp_"+id);
        tltp.innerHTML = "Copied!";

        setTimeout(() => {
            var tltp = document.getElementById("mytltp_"+id);
            tltp.innerHTML = "Copy email to clipboard";
        }, 5000);
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