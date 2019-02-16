@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">FRUIT PROFILES</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="/profiles/create" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD PROFILE</a>
            <ol class="breadcrumb">
                <li class="active">Fruit Profiles</li>
           </ol>
        </div>
       <!-- /.col-lg-12 -->
    </div>
    <div class="white-box">
    <div class="row">
        
        <div class="col-md-12 col-lg-12 col-sm-12">
          <table id="tbl-profiles" class="table table-hover" style="width:100%"> 
            <thead>
             <tr>
                 <th>Fullname</th>
                 <th>Lastname</th>
                 <th>Mobile</th>
                 <th>Email</th>
                 <th>Team</th>
                 <th>Country</th>
                 <th>Action</th>
             </tr>
             </thead>
         </table>
     </div>
 </div>
</div>

 @push('dataTableScript')
 <script>
    $(document).ready(function() {
        var popOverSettings = {
            placement: 'top',
            container: 'body',
            html: true,
            selector: '[data-toggle="popover"]', //Sepcify the selector here
            content: function () {
                return $('#popover-content').html();
            }
        }

    $('body').popover(popOverSettings);

        $('#tbl-profiles').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            drawCallback: function () {
                $('.dataTables_paginate > .pagination').addClass('pagination-sm');
            },
            ajax: "{{ route('tbl-profiles') }}",
            columns: [
            { name: 'fullname' },
            { name: 'lastname' },
            { name: 'mobile_no' },
            { name: 'email' },
            { name: 'team.name' },
            { name: 'country.name' },
            { name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
</div>
@endsection
