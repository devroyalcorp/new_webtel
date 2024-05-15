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
        <table class="table table-responsive table-striped table-bordered" id="datatable_webtel">
            <thead>
              <tr>
                <th scope="col">Company</th>
                <th scope="col">Name</th>
                <th scope="col">Department</th>
                <th scope="col">Extention</th>
              </tr>
              <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                @foreach($data_companies as $key=>$val)
              <tr>
                <td>{{$val['acronym'] ?? "-"}}</td>
                <td>{{$val['first_name'] ?? "-"}}</td>
                <td>{{$val['name'] ?? "-"}}</td>
                <td>({{$val['line_number'] ?? "-"}}) {{$val['extention_number'] ?? "-"}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable_webtel').DataTable({
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