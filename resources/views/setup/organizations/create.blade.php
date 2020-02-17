@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">ORGANISATIONS</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/setup">Setup</a></li>
                    <li class="active">Organisations</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <a href="/organizations"> <span class="fa fa-arrow-circle-left"></span> Cancel</a>
                    <h3 class="box-title">ORGANIZATION [NEW]</h3>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    @endif

                     {!! Form::open(array('url' => '/organizations', 'method' => 'post', 'class'=> 'form-horizontal')) !!}
                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('language_id', 'Language')}}
                            {{Form::select('language_id', $languages, null, ['class' => 'form-control select'])}}
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('name', 'Organization Name')}}
                            {{Form::text('name', null, ['class' => 'form-control', 'required'])}}
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('acronym', 'Acronym (short name)')}}
                            {{Form::text('acronym', null, ['class' => 'form-control', 'required'])}}
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('website', 'Website')}}
                            {{Form::text('website', 'www.', ['class' => 'form-control'])}}
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('platform', 'Platform')}}
                            {{Form::select('platform', ['Online' => 'Online', 'Print'=>'Print', 'Broadcast'=>'Broadcast', 'Radio'=>'Radio'], null, ['class' => 'form-control', 'placeholder'=>'Not Applicable'])}}
                          </div>
                        </div>

                         <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('industry_id', 'Industry')}}
                            {{Form::select('industry_id', $industries, null, ['class' => 'form-control select', 'placeholder'=>'Select'])}}
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('sector_id', 'Sector')}}
                            {{Form::select('sector_id', $sectors, null, ['class' => 'form-control select', 'placeholder'=>'Select'])}}
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('country_id', 'Country')}}
                            {{Form::select('country_id', $countries, null, ['class' => 'form-control select', 'placeholder'=>'Select'])}}
                          </div>
                        </div>

                        <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                        <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                    {!! Form::close() !!}
                </div>
            </div>
    </div>
</div>
</div>
</div>
@endsection
