@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">FRUIT PROFILES</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
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
                 <th>Sector</th>
                 <th>Team</th>
                 <th>Gender</th>
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
            { name: 'sector.name' },
            { name: 'team.name' },
            { name: 'gender.gender' },
            { name: 'country.name' },
            { name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
</div>
@endsection
