@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item "><a href="/organizations">Organisation </a></li>
    <li class="breadcrumb-item active">Add New</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
 <div class="col-md-2 col-xs-12"></div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Organisations</strong>
            </div>
            <div class="card-body">
              @if ($errors->any())
                  @foreach ($errors->all() as $error)
                      <p class="text-danger">{{ $error }}</p>
                  @endforeach
              @endif

                {!! Form::open(array('url' => '/organizations', 'method' => 'post', 'class'=> 'form-horizontal')) !!}
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Language</th>
                    <td>{{Form::select('language_id', $languages, null, ['class' => 'form-control select'])}}</td>
                  </tr>
                   <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Organisation name<span class="text-danger">*</span></th>
                    <td>{{Form::text('name', null, ['class' => 'form-control', 'required'])}}</td>
                  </tr>
                   <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">{{Form::label('acronym', 'Acronym (short name)')}}</th>
                    <td>{{Form::text('acronym', null, ['class' => 'form-control'])}}</td>
                  </tr>
                   <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">{{Form::label('website', 'Website')}}</th>
                    <td> {{Form::text('website', 'www.', ['class' => 'form-control'])}}</td>
                  </tr>
                   <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Platform</th>
                    <td>{{Form::select('platform', ['Online' => 'Online', 'Print'=>'Print', 'Broadcast'=>'Broadcast', 'Radio'=>'Radio'], null, ['class' => 'form-control', 'placeholder'=>'Not Applicable'])}}</td>
                  </tr>
                   <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Industry</th>
                    <td>{{Form::select('industry_id', $industries, null, ['class' => 'form-control select', 'placeholder'=>'Select'])}}</td>
                  </tr>
                   <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Sector</th>
                    <td>{{Form::select('sector_id', $sectors, null, ['class' => 'form-control select', 'placeholder'=>'Select'])}}</td>
                  </tr>
                   <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Country</th>
                    <td>{{Form::select('country_id', $countries, null, ['class' => 'form-control select2', 'placeholder'=>'Select'])}}</td>
                  </tr>
                </table>
                  <button type="submit" class="btn btn-success"> Save</button>
                  <button type="reset" class="btn"> Reset</button>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>

@endsection
