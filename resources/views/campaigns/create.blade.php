@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/campaigns">Campaigns </a></li>
    <li class="breadcrumb-item">Create</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                New Campaign | <a href="/campaigns">  
                                <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                                </svg> Back</a>
            </div>
            <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    @endif
                     {!! Form::open(array('url' => '/campaigns', 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                         <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('name', 'Campaign Name')}}
                            {{Form::text('name', null, ['class' => 'form-control'])}}
                          </div>
                        </div>
                        </div>

                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('status', 'Status')}}
                            {{Form::select('status', [1=>'Active', 0=>'Not Active'], null, ['class' => 'form-control select'])}}
                          </div>
                        </div>
                        </div>
                        <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                        <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                    {!! Form::close() !!}
                </div>
        </div>
    </div>
</div>
@endsection
