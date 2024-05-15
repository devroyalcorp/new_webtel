@extends('master')
@section('title')
    <title>Webmail</title>
@endsection
@section('style')
    <style>
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <table class="table table-responsive table-striped table-bordered" id="datatable_webmail">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Department</th>
                <th scope="col">Email</th>
              </tr>
              <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                @foreach($data_companies as $key=>$val)
              <tr>
                <td>{{$val['first_name'] ?? "-"}}</td>
                <td>{{$val['name'] ?? "-"}}</td>
                <td>{{$val['work_email'] ?? "-"}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable_webmail').DataTable({
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;
                        var title = column.header().textContent;
        
                        // Create input element and add event listener
                        $('<input type="text" placeholder="Search ' + title + '" />')
                            .appendTo($(column.header()).empty())
                            .on('keyup change clear', function () {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                    });
            }
        });
    });
</script>
@endsection