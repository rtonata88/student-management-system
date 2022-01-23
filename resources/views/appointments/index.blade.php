@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/profiles">Appointments </a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <a href="{{route('appointments.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light" target="_blank"> MANAGE APPOINTMENTS</a>
                </div>
            </div>
            <div class="card-body">
                <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Africa%2FWindhoek&src=bG90dXNjb3Vuc2VsaW5nbmFtQGdtYWlsLmNvbQ&src=aDk3NXNqOXBsOGYzYXJiM3Q3YnZ1MmFudjhAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=ZHFjZjlnMmFtbHN2NzlmZjczb290bmw3anNAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&src=aTJhYW85YTZnbDkzNW82YWh1OGl0dGdrMXNAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&color=%23039BE5&color=%238E24AA&color=%239E69AF&color=%23E67C73" style="border:solid 1px #777" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection