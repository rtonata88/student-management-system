                  <div id="staff" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <strong>Add staff to this event</strong>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <svg class="c-icon mr-2">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                                        </svg>
                                        </button>
                                </div>
                                <form method="post" action="/event-staff/add/{{$event->slug}}" class="typeahead" role="search">
                                <div class="modal-body">
                                        <input name="_token" type="hidden" value="">
                                        <input name="update" type="hidden" value="InviteAttendee">
                                        {{ csrf_field() }}
                                        <div class="database-profile">
                                            <div class="form-group">
                                                {{Form::label('staff_id', 'Select staff')}}
                                                {{Form::select('staff_id', $users, null, ['class' => 'form-control select2', 'style'=> 'width:100%'])}}
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            {{Form::label('responsibility', 'Will be responsible for')}}
                                            {{Form::text('responsibility', null, ['class' => 'form-control', 'placeholder'=> 'Logistics, Event manager'])}}
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn waves-effect" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">
                                             <span class="fa fa-plus"></span> Save
                                         </button>
                                </div>
                                </form>
                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div> 