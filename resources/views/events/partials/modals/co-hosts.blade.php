<div id="co-hosts" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add co-hosts of this event</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                    </svg>
                    </button>
            </div>
            {!! Form::open(array('route' => array('co-hosts.create', $event->slug), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
               <br>
                <div class="col-md-12">
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'autocomplete'=>'off', 'required'])}}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {{Form::label('address_line1', 'Address')}}
                        {{Form::text('address_line1', null, ['class' => 'form-control', 'placeholder' => 'Address Line 1', 'autocomplete'=>'off', 'required'])}}<br>
                        {{Form::text('address_line2', null, ['class' => 'form-control', 'placeholder' => 'Address Line 2', 'autocomplete'=>'off', 'required'])}}<br>
                        {{Form::text('address_line3', null, ['class' => 'form-control', 'placeholder' => 'Address Line 3', 'autocomplete'=>'off'])}}<br>
                        {{Form::text('address_line4', null, ['class' => 'form-control', 'placeholder' => 'Address Line 4', 'autocomplete'=>'off'])}}
                    </div>
                </div>

                <div class="row">
                    <h4 class="box-title m-t-5">Contact Persons</h4>
                    <div class="event-co-hosts-contacts">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('contact_person[]', 'Name')}}
                                {{Form::text('contact_person[]', null, ['class' => 'form-control co-host-contact', 'placeholder' => 'First and lastname', 'autocomplete'=>'off', 'required'])}}
                            </div>
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('contact_number[]', 'Number')}}
                                {{Form::text('contact_number[]', null, ['class' => 'form-control', 'placeholder' => 'Contact person First and lastname', 'autocomplete'=>'off', 'required'])}}
                            </div>
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">

                                {{Form::label('contact_email[]', 'Email')}}
                                {{Form::text('contact_email[]', null, ['class' => 'form-control', 'placeholder' => 'Contact Person Email', 'autocomplete'=>'off', 'required'])}}
                            </div>
                        </div>
                    </div> 

                    <span class="help-text">
                        <a class="btn btn-default" id="btn-add-co-host-contact">
                            <span class="fa fa-plus"></span> Add 
                        </a>
                        <a class="btn btn-danger" id="btn-remove-co-host-contact">
                            <span class="fa fa-times"></span> Remove 
                        </a>
                    </span>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('logo', 'Logo')}}
                            {{Form::file('logo', null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                {!! Form::close() !!}
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> 