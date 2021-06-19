<div id="myModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Invite people to attend</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <svg class="c-icon mr-2">
                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                </svg>
                </button>
            </div>
            <form method="post" action="/events/{{$event->slug}}" class="typeahead" role="search">
            <div class="modal-body">
                
                    <input name="_method" type="hidden" value="PATCH">  
                    <input name="_token" type="hidden" value="">
                    <input name="update" type="hidden" value="InviteAttendee">
                    {{ csrf_field() }}
                   
                    <div class="other-attendee">
                            <div class="form-group">
                            {{Form::label('name', 'Full name or name of organisation')}}
                            {{Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter person full name or name of organization', 'autocomplete' => 'off'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('email', 'Email address')}}
                            {{Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email address', 'autocomplete' => 'off'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('participant_role', 'What are they coming as')}}
                        {{Form::text('participant_role', null, ['class' => 'form-control', 'style'=> 'width:100%', 'placeholder'=>'Ex. Panelist, General, Guest speaker'])}}
                        
                    </div>
                        <!-- <div class="form-group">
                        {{Form::label('send_email', 'Would you like the system to send an email to the person right away?')}}
                        {{Form::select('send_email', ['n'=>'No', 'y'=>'Yes'], null, ['class' => 'form-control'])}}
                        </div>
                 -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                    <span class="fa fa-save"></span> Save
                </button>
            </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>  

<div id="profileData" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Tick to invite people to attend this event</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                    </svg>
                </button>
            </div>
            <form method="post" action="/events/{{$event->slug}}" class="typeahead" role="search">
            <div class="modal-body">
                
                <input name="_method" type="hidden" value="PATCH">  
                <input name="_token" type="hidden" value="">
                <input name="update" type="hidden" value="InviteAttendee">
                {{ csrf_field() }}
                <input type="text" id="myInput" class="form-control" placeholder="Search...">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%" id="liaising-list-table"> 
                    <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Lastname</th>
                                <th>Team</th>
                                <th>Country</th>
                                <th>Role</th>
                                <th>Tick</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($profiles as $profile)
                        <tr data="{{$profile->id}}" id="profiles-{{$profile->id}}">
                            <td>{{$profile->fullname}}</td>
                            <td>{{$profile->lastname}}</td>
                            <td>{{$profile->team->name}}</td>
                            <td>{{$profile->country->name}}</td>
                            <td>
                                <input type="text" data="{{$profile->id}}" name="role[]" id="role_{{$profile->id}}" class="form-controls" placeholder="Example; Panelist, Guest Speaker, General">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" data="{{$profile->id}}" id="check_{{$profile->id}}" name="invite[{{$profile->id}}][]">    
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                </table>
                
                @push('dataTableScript')
                    <script>
                        
                        var profile_id = 0;
                        $(document).ready(function() {
                            $('#liaising-list-table').on('click', 'tr input', function () {
                                var isChecked = $('#check_'+$(this).attr('data')+':checkbox:checked').length > 0;
                                var profile_id = $(this).attr('data');

                                if(isChecked) {                                                        
                                    $.ajax({
                                        url: "{!! route('save-invite', ['slug' => $event->slug]) !!}",
                                        type: 'POST',
                                        data: {'_token':"<?php echo csrf_token() ?>", 'profile_id':profile_id, 'participant_role':$('#role_'+profile_id).val()}
                                    });
                                }
                            });
                            

                            $('#liaising-list-table').on('change', 'tr select', function () {

                                var profile_id = $(this).attr('data');
                                
                                $.ajax({
                                    url: "{!! route('update-invite', ['slug' => $event->slug]) !!}",
                                    type: 'POST',
                                    data: {'_token':"<?php echo csrf_token() ?>", 'profile_id':profile_id, 'participant_role':$('#role_'+profile_id).val()},
                                });
                            });
                        });
                        
                    </script>
                @endpush
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">Done</button>
            </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> 