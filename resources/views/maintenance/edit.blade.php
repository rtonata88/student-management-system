@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item"><a href="{{route('maintenance.index')}}">Maintenance</a></li>
        <li class="breadcrumb-item"><a href="{{route('maintenance.show', $request)}}">{{$request->request_number}}</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Maintenance Request</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{route('maintenance.update', $request)}}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{old('category_id', $request->category_id) == $category->id ? 'selected' : ''}}>
                                            {{$category->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority">Priority <span class="text-danger">*</span></label>
                                    <select name="priority" id="priority" class="form-control" required>
                                        <option value="low" {{old('priority', $request->priority) == 'low' ? 'selected' : ''}}>Low</option>
                                        <option value="medium" {{old('priority', $request->priority) == 'medium' ? 'selected' : ''}}>Medium</option>
                                        <option value="high" {{old('priority', $request->priority) == 'high' ? 'selected' : ''}}>High</option>
                                        <option value="critical" {{old('priority', $request->priority) == 'critical' ? 'selected' : ''}}>Critical</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="{{old('title', $request->title)}}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control" rows="4" required>{{old('description', $request->description)}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="location">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="location" class="form-control" value="{{old('location', $request->location)}}" placeholder="Building, Room, Area" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="required_completion_date">Required Completion Date</label>
                                    <input type="date" name="required_completion_date" id="required_completion_date" class="form-control" value="{{old('required_completion_date', $request->required_completion_date ? $request->required_completion_date->format('Y-m-d') : '')}}" min="{{date('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estimated_cost">Estimated Cost</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" name="estimated_cost" id="estimated_cost" class="form-control" value="{{old('estimated_cost', $request->estimated_cost)}}" step="0.01" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Additional Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{old('notes', $request->notes)}}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Request
                            </button>
                            <a href="{{route('maintenance.show', $request)}}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
