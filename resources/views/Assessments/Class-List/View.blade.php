@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessment Management</li>
        <li class="breadcrumb-item active"><a href="/class-lists">Class List</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="offset-1 col-md-10">
        <div class="card">
            
            <div class="card-body">
                <table id="" class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Student number</th>
                            <th>Student names</th>
                            <th>Surname</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>Contact Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registered_students as $registered_student)
                        <tr>
                            <td>{{$registered_student->student->student_number2}}</td>
                            <td>{{$registered_student->student->student_names}}</td>
                            <td>{{$registered_student->student->surname}}</td>
                            <td>{{$registered_student->student->gender}}</td>
                            <td>{{$registered_student->student->date_of_birth}}</td>
                            <td>{{$registered_student->student->contact_number}}</td>
                            <td>
                                @permission('show-student')
                                <a href="{{route('students.show', $registered_student->student->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                    </svg>
                                </a>
                                @endpermission
                                @permission('edit-student')
                                <a href="{{route('students.edit', $registered_student->student->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                    </svg>
                                </a>
                                @endpermission
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.11.6/js/dataTables.bootstrap5.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#myTable').DataTable();
                    });
                </script>

            </div>
        </div>
    </div>
</div>
@endsection