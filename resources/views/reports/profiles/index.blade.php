@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">FRUIT PROFILES REPORT</h4> 
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
         <div class="panel panel-default" style=" border: 1px solid #ddd">
                                <div class="panel-heading" style="background-color: #f5f5f5;">
                                    REPORT FILTER
                                </div>

                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">

                                        {!! Form::open(array('route' => array('export-profiles'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}

                                        <div class="row">
                                            <div class="col-md-6">
                                               <div class="form-group">
                                                {{Form::label('team_id', 'Team')}}
                                                {{Form::select('team_id', $teams, null, ['class' => 'form-control select','placeholder'=>'All teams'])}}
                                            </div>
                                        </div>
                                    </div>
                            <button type="submit" class="btn btn-success"><span class="fa fa-file-excel-o"></span> EXPORT TO EXCEL</button>
                            <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <hr>
        <div class="col-md-12 col-lg-12 col-sm-12">
          <table id="dataTable2" class="table table-striped table-bordered dataTable" style="width:100%"> 
            <thead>
             <tr>
                 <th>Firstnames</th>
                 <th>Lastname</th>
                 <th>Sector</th>
                 <th>Team</th>
                 <th>Gender</th>
                 <th>Country</th>
             </tr>
             </thead>
             <tbody>
                @foreach($profiles as $profile)
                 <tr>
                     <td>{{$profile->fullname}} </td>
                     <td>{{$profile->lastname}}</td>
                     <td>{{$profile->sector->name}}</td>
                     <td>{{$profile->team->name}}</td>
                     <td>{{$profile->gender->gender}}</td>
                     <td>{{$profile->country->name}}</td>
                 </tr>
                 @endforeach
             </tbody>
         </table>
         
     </div>
 </div>
</div>
</div>
@endsection
