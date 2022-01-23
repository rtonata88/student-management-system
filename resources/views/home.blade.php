@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item active">Dashboard</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-3">
                <div class="c-callout c-callout-info"><small class="text-muted">Payments</small>
                    <div class="text-value-lg">
                   0         
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-3">
                <div class="c-callout c-callout-primary"><small class="text-muted">Students</small>
                    <div class="text-value-lg">
                        0
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="c-callout c-callout-warning"><small class="text-muted">Total Invoice</small>
                    <div class="text-value-lg">
                        0
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
@endsection
