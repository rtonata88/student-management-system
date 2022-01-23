@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item"><a href="/therapists">Therapist </a></li>
        <li class="breadcrumb-item active">Show</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <img src="{{asset('storage/therapists/photos/')}}/{{$therapist->photo}}" alt="Profile Photo" class="rounded img-thumbnail">
    </div>
    <div class="col-md-9 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>{{$therapist->name}} {{$therapist->surname}} </strong> | <a href="/therapists/{{$therapist->id}}/edit">Update Info</a>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs tabcontent-border" role="tablist" id="profiles-tab">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#biographical" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Biographical</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#qualifications" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Qualifications</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#publications" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Publications</span></a> </li>
                </ul>
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active p-2" id="biographical" role="tabpanel">
                        <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5); width: 300px;">Firstname</th>
                                <td>{{$therapist->name}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Surname</th>
                                <td>{{$therapist->surname}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Email</th>
                                <td>{{$therapist->email}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number</th>
                                <td>{{$therapist->contact_number}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Sex</th>
                                <td>{{$therapist->sex}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Spoken languages</th>
                                <td>
                                    @foreach($therapist->languages as $langauge)
                                    {{$langauge->name}}.
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Country</th>
                                <td>{{$therapist->country->name}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Practice number</th>
                                <td>{{$therapist->practice_number}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Board </th>
                                <td>{{$therapist->board->name}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">License Type</th>
                                <td>{{$therapist->licence_type->type}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Area of specialities</th>
                                <td>
                                    @foreach($therapist->specialties as $specialty)
                                    {{$specialty->specialty}}.
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Do you have a work permit?</th>
                                <td>{{$therapist->work_permit_yn}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane p-2" id="qualifications" role="tabpanel">
                        @foreach($therapist->qualification->where('model', 'Therapist') as $qualification)
                        <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5); width: 200px;">Qualification</th>
                                <td>{{$qualification->qualification_name}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Institution</th>
                                <td>{{$qualification->institution}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Start Year</th>
                                <td>{{$qualification->start_year}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">End year</th>
                                <td>{{$qualification->end_year}}</td>
                            </tr>
                        </table>
                        @endforeach
                    </div>
                    <div class="tab-pane p-2" id="publications" role="tabpanel">
                        @foreach($therapist->publication as $publication)
                        <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5); width: 200px;">Title</th>
                                <td>{{$publication->title}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Abstract</th>
                                <td>{{$publication->abstract}}</td>
                            </tr>
                            <tr>
                                <th style="background-color: rgba(227, 227, 227, 0.5)">Other information</th>
                                <td>{{$publication->other_information}}</td>
                            </tr>
                        </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @push('contactsJS')
        <script src="{{asset('js/contacts.js')}}"></script>
        @endpush
        @endsection