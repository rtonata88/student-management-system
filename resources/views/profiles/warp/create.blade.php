@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">WARP SUMMIT ATTENDEES</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        </div>
        <!-- /.col-lg-12 -->
    </div>
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="white-box">
                <a href="{{route('warp-attendees.index')}}"> <span class="fa fa-arrow-circle-left"></span> Back</a>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    @endif
                <hr>
                {!! Form::open(array('route'=>array('warp-attendees.store'), 'class'=>'form-vertical form-material', 'method'=>'post')) !!}
                <div class="row">
                        <div class="database-profile">
                            <div class="form-group">
                                {{Form::label('profile_id', 'SELECT PROFILE')}}
                                {{Form::select('profile_id', $profiles, null, ['class' => 'form-control select2'])}}
                                
                            </div>
                           
                        </div>

                <div class="col-md-5">
                       <div class="form-group">
                            {{Form::label('current_or_former', 'CURRENT OR FORMER')}}
                            {{Form::select('current_or_former', ['current' => 'Current Position', 'former' => 'Former Position'], null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5">
                            {{Form::label('financing', 'Financing')}}
                            {{Form::select('financing', ['Sponsored' => 'Sponsored', 'Self funded' => 'Self funded'], null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {{Form::label('date_attended', 'Date Attended')}}
                            {{Form::text('date_attended', null, ['class' => 'form-control mydatepicker', 'required'])}}
                            {{Form::hidden('user', Auth::user()->id, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                {!! Form::close() !!}
            </div>
        </div>
</div>
@endsection
