$(document).ready(function($) {
	//Discussion Points
	$('#btn-add-discussion-point').on('click', function (){
		var index = $('.event_discussion').length
		
		$(".discussion-points")
		.append('<div class="point'+index+'"><br><label for="event_discussion[]">Point '+(index + 1)+':</label>'+
			'<textarea class="form-control event_discussion" placeholder="Type here..." required="" rows="2" name="event_discussion[]" cols="50" id="event_discussion'+(index+1)+'"></textarea></div>');
	})

	$('#btn-remove-discussion-point').on('click', function (){
		var index = $('.event_discussion').length
		var rm = (index-1);

		$(".point"+rm).remove()
	})

	//Participant Roles
	$('#btn-add-participant-role').on('click', function (){
		var index = $('.participant-role').length
		
		$(".event-participant-roles")
		.append('<div id="participant-role'+index+'"><br>'+
			'<input type="text" name="participant_roles[]" class="form-control participant-role" placeholder="Ex. Panelists, Media, Guest Speaker"></div>');
	})

	$('#btn-remove-participant-role').on('click', function (){
		var index = $('.participant-role').length
		var rm = (index-1);

		$("#participant-role"+rm).remove()
	})

	//Staff Roles
	$('#btn-add-staff-role').on('click', function (){
		var index = $('.staff-role').length
		
		$(".event-staff-roles")
		.append('<div id="staff-role'+index+'"><br>'+
			'<input type="text" name="staff_roles[]" class="form-control staff-role" placeholder="Ex. Logistics, IPYG Representative, Media, Manager"></div>');
	})

	$('#btn-remove-staff-role').on('click', function (){
		var index = $('.staff-role').length
		var rm = (index-1);

		$("#staff-role"+rm).remove()
	})

	$(".other-attendee").hide();
	$( "#profile_y_n" ).change(function() {
		var y_n = $(this).val();
		if(y_n == 'y')
		{
			$(".other-attendee").hide();
			$(".database-profile").show();
		} else {
			$(".other-attendee").show();
			$(".database-profile").hide();
		}
	});


	//Event Co-hosts
	$('#btn-add-co-host-contact').on('click', function (){
		var index = $('.co-host-contact').length
		
		$(".event-co-hosts-contacts")
		.append('<div id="co-host-contact'+index+'"><br>'+
			' <div class="col-md-4">'+
                '<div class="form-group">'+
			'<input type="text" name="contact_person[]" class="form-control co-host-contact" placeholder="First and lastname"></div>'+
			'</div>'+

			' <div class="col-md-4">'+
                '<div class="form-group">'+
			'<input type="text" name="contact_number[]" class="form-control" placeholder="Contact Number"></div>'+
			'</div>'+

			' <div class="col-md-4">'+
                '<div class="form-group">'+
			'<input type="text" name="contact_email[]" class="form-control" placeholder="Email"></div>'+
			'</div>'+
			'</div>');
	})

	$('#btn-remove-co-host-contact').on('click', function (){
		var index = $('.co-host-contact').length
		var rm = (index-1);

		$("#co-host-contact"+rm).remove()
	})
	
	$(document).on('change', 'input:radio[class^="feedback-type"]', function (event) {
    	if($(this).val() == 'summary'){
    		$(".summary-feedback").show();
    		$(".detailed-feedback").hide();
    	} else if ($(this).val() == 'detailed'){
    		$(".summary-feedback").hide();
    		$(".detailed-feedback").show();
    	} else {
    		$(".summary-feedback").show();
    		$(".specific-feedback").show();
    	}
	});

	if($('input:radio[class^="feedback-type"]').val() == 'summary'){
    		$(".summary-feedback").show();
    		$(".detailed-feedback").hide();
    	} else if ($('input:radio[class^="feedback-type"]').val() == 'detailed'){
    		$(".summary-feedback").hide();
    		$(".detailed-feedback").show();
    	} else {
    		$(".summary-feedback").show();
    		$(".specific-feedback").show();
    }


	$("#guest_id").change(function() {
		$.ajax({
           type:'POST',
           url:'/get-guest',
           data:{ _token: $("[name=_token]").val(), guest: $(this).val() },
           success:function(results){
             $('#profile_id').val(results[0].profile_id)
             $('#fullname').val(results[0].fullname)
             $('#lastname').val(results[0].lastname)
             $('#email').val(results[0].email)
             $('#mobile_no').val(results[0].mobile_no)
             $('#work_number').val(results[0].work_number)
             $('#organization').val(results[0].name)
           }
        });
	});


	var course_row = 2;
	$("#btn-external-events-participants").click(function (event) {
		jQuery(function () {
			event.preventDefault();
			var newRow = jQuery(
				'<tr>' +
				'<td>' +
				'<input type="text" name="fullname[]" class="form-control" placeholder="Type here.." required>' +
				'</td>' +
				'<td>' +
				'<input type="text" name="role[]" class="form-control" placeholder="Type here.." required>' +
				'</td>' +
				'<td class="text-center">' +
				'<button class="btn btn-danger btn-rounded btn-remove">'+
                    '<span class="fa fa-times"></span>'+
                '</button>'+
				'</td>' +
				'</tr>'
				);
			jQuery('#tbl-external-events-participants').append(newRow);
			course_row++;
		});
	});
	$("#tbl-external-events-participants").on('click', '.btn-remove', function () {
		$(this).closest('tr').remove();
	});



});

