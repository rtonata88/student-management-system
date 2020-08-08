$(document).ready(function() {
  var $loading = $('.spinner').hide();

  $('body').on('click', '.edit-btn', function(){
    $loading.show();
    setTimeout( "jQuery('.spinner').hide();", 800 );
      var section = $(this).attr('section');
      var profile = $(this).attr('slug');

      switch (section) {
        case 'about':
              $(".other-information-secion").hide();
              $.ajax({
                url: "/load/"+profile+"/"+section,
              }).done(function( data ) {
                  $(".about-section").html(data.html).fadeOut(400).delay(200).slideDown(400);
              });
          break;
        case 'contact':
              $.ajax({
                url: "/load/"+profile+"/"+section,
              }).done(function( data ) {
                  $(".contacts-section").html(data.html).fadeOut(400).delay(200).slideDown(400);
              });
          break;
          case 'organisation':
                  $.ajax({
                    url: "/load/"+profile+"/"+section+"?id="+$(this).attr('id'),
                  }).done(function( data ) {
                      $(".contacts-section").html(data.html).fadeOut(400).delay(200).slideDown(400);
                  });
            break;
          case 'assistant':
                  $.ajax({
                    url: "/load/"+profile+"/"+section+"?id="+$(this).attr('id'),
                  }).done(function( data ) {
                      $(".contacts-section").html(data.html).fadeOut(400).delay(200).slideDown(400);
                  });
            break;
        case 'relationship':
                $.ajax({
                  url: "/load/"+profile+"/"+section,
                }).done(function( data ) {
                    $(".relationship-section").html(data.html).fadeOut(400).delay(200).slideDown(400);
                });
          break;
        default:
      }
    });

  $('body').on('click', '.save-btn', function(e){
      e.preventDefault();
      $loading.show();
      setTimeout( "jQuery('.spinner').hide();", 800 );
      var section = $(this).attr('section');
      var profile = $(this).val();

      switch (section) {
        case 'about':
              var data = new FormData();
              var files = $('[name=photo]')[0].files[0];

              data.append('photo',files);
              data.append('_token',$("[name=_token]").val());
              data.append('_method',"PUT");
              data.append('section', section);
              data.append('titles', $("#titles").val());
              data.append('lastname', $("[name=lastname]").val());
              data.append('fullname', $("[name=fullname]").val());
              data.append('gender_id', $("[name=gender_id]").val());
              data.append('dob', $("[name=dob]").val());
              data.append('bio', $("[name=bio]").val());
              data.append('city_id', $("[name=city_id]").val());
              data.append('languages', $("#languages").val());
              data.append('maintainer_id' , $("[name=maintainer_id]").val());
              data.append('platform' , $("[name=platform]").val());
              data.append('history' , $("[name=history]").val());

              $.ajax({
                  url: "/profiles/"+$("[name=profile-slug]").val(),
                  type:"POST",
                  data:data,
                  processData: false,
                  contentType: false,
                  success:function(response){
                    $('.edit-about-section').html(response.html).fadeOut(400).delay(200).slideDown(400);
                  },
                 });
          break;
        case 'contact':
              var data = new FormData();
              data.append('_token',$("[name=_token]").val());
              data.append('_method',"PUT");
              data.append('section', section);
              data.append('mobile_no', $("[name=mobile_no]").val());
              data.append('mobile_no2', $("[name=mobile_no2]").val());
              data.append('mobile_no_other', $("[name=mobile_no_other]").val());
              data.append('email', $("[name=email]").val());
              data.append('email2', $("[name=email2]").val());

              $.ajax({
                  url: "/profiles/"+$("[name=profile-slug]").val(),
                  type:"POST",
                  data:data,
                  processData: false,
                  contentType: false,
                  success:function(response){
                    $('.edit-contacts-section').html(response.html).fadeOut(400).delay(200).slideDown(400);
                  },
                 });
          break;
        case 'relationship':
                var data = new FormData();
                data.append('_token',$("[name=_token]").val());
                data.append('_method',"PUT");
                data.append('section', section);
                data.append('sector_id', $("[name=sector_id]").val());
                data.append('team_id', $("[name=team_id]").val());
                data.append('fruit_role_id', $("[name=fruit_role_id]").val());
                data.append('fruit_stage_id', $("[name=fruit_stage_id]").val());
                data.append('fruit_level_id', $("[name=fruit_level_id]").val());
                data.append('cult_awareness', $("[name=cult_awareness]").val());
                data.append('pre_poisoned', $("[name=pre_poisoned]").val());
                data.append('warp_attendee', $("[name=warp_attendee]").val());
                data.append('religion_id', $("[name=religion_id]").val());

                $.ajax({
                    url: "/profiles/"+$("[name=profile-slug]").val(),
                    type:"POST",
                    data:data,
                    processData: false,
                    contentType: false,
                    success:function(response){
                      $('.edit-relationship-section').html(response.html).fadeOut(400).delay(200).slideDown(400);
                    },
                   });
            break;
        case 'organisation':
              var data = new FormData();
              data.append('_token',$("[name=_token]").val());
              data.append('_method',"PUT");
              data.append('section', section);
              data.append('organization_id', $("#organization_id").val());
              data.append('position', $("#position").val());
              data.append('department', $("#department").val());
              data.append('work_number', $("#work_number").val());
              data.append('work_number2', $("#work_number2").val());
              data.append('work_number_other', $("#work_number_other").val());
              data.append('email', $("#email").val());
              data.append('email2', $("#email2").val());
              data.append('email_other', $("#email_other").val());

              $.ajax({
                  url: "/profiles/"+$("[name=profile-slug]").val(),
                  type:"POST",
                  data:data,
                  processData: false,
                  contentType: false,
                  success:function(response){
                    $('.edit-organisations-section').html(response.html).fadeOut(400).delay(200).slideDown(400);
                  },
                 });
          break;
          case 'new-organisation':
                var data = new FormData();
                data.append('_token',$("[name=_token]").val());
                data.append('_method',"PUT");
                data.append('section', section);
                data.append('organisation_id', $("#organisation_id").val());
                data.append('position', $("#position").val());
                data.append('department', $("#department").val());
                data.append('work_number', $("#work_number").val());
                data.append('work_number2', $("#work_number2").val());
                data.append('work_number_other', $("#work_number_other").val());
                data.append('email', $("#email").val());
                data.append('email2', $("#email2").val());
                data.append('email_other', $("#email_other").val());

                $.ajax({
                    url: "/profiles/"+$("[name=profile-slug]").val(),
                    type:"POST",
                    data:data,
                    processData: false,
                    contentType: false,
                    success:function(response){
                      $('.new-organisation-section').append(response.html).fadeOut(400).delay(200).slideDown(400);
                    },
                   });
            break;
            case 'new-assistant':
                  var data = new FormData();
                  data.append('_token',$("[name=_token]").val());
                  data.append('_method',"PUT");
                  data.append('section', section);
                  data.append('assistant_name', $("#assistant_name").val());
                  data.append('assistant_email1', $("#assistant_email1").val());
                  data.append('assistant_email2', $("#assistant_email2").val());
                  data.append('assistant_email3', $("#assistant_email3").val());
                  data.append('assistant_number1', $("#assistant_number1").val());
                  data.append('assistant_number2', $("#assistant_number2").val());
                  data.append('assistant_number3', $("#assistant_number3").val());

                  $.ajax({
                      url: "/profiles/"+$("[name=profile-slug]").val(),
                      type:"POST",
                      data:data,
                      processData: false,
                      contentType: false,
                      success:function(response){
                        $('.new-assistant-section').append(response.html).fadeOut(400).delay(200).slideDown(400);
                      },
                     });
              break;
        default:
      }
  });

  $('body').on('click', '.delete-btn', function(e){
    e.preventDefault();
    $loading.show();
    setTimeout( "jQuery('.spinner').hide();", 800 );
      var section = $(this).attr('section');
      var profile = $(this).attr('slug');
      var id = $(this).attr('id');

      switch (section) {
        case 'organisation':
            var c = confirm("This operation cannot be undone. Are you sure?");
            if (c == true) {
              $.ajax({
                url: "/detach/"+profile+"/"+section+"?id="+id,
              }).done(function( data ) {
                  $(".organisation-"+id).remove().fadeOut(400).delay(200).slideDown(400);
              });
            }
          break;
        case 'assistant':
            var c = confirm("This operation cannot be undone. Are you sure?");
            if (c == true) {
              $.ajax({
                url: "/detach/"+profile+"/"+section+"?id="+id,
              }).done(function( data ) {
                  $(".assistant-"+id).remove().fadeOut(400).delay(200).slideDown(400);
              });
            }
        break;

      }
    });

  $('body').on('click', '.cancel-btn', function(e){
      e.preventDefault();
      $loading.show();
      setTimeout( "jQuery('.spinner').hide();", 800 );
      var section = $(this).attr('section');
      var profile = $('#profile-slug').val();

      switch (section) {
        case 'about':
            $.ajax({
                url: "/profile/cancel/"+section+"/"+$("[name=profile-slug]").val(),
                type:"GET",
                success:function(response){
                  $('.edit-about-section').html(response.html).fadeOut(400).delay(200).slideDown(400);
              },
             });
        break;
        case 'contact':
            $.ajax({
                url: "/profile/cancel/"+section+"/"+$("[name=profile-slug]").val(),
                type:"GET",
                success:function(response){
                  $('.edit-contacts-section').html(response.html).fadeOut(400).delay(200).slideDown(400);
              },
             });
          break;
          case 'relationship':
              $.ajax({
                  url: "/profile/cancel/"+section+"/"+$("[name=profile-slug]").val(),
                  type:"GET",
                  success:function(response){
                    $('.edit-relationship-section').html(response.html).fadeOut(400).delay(200).slideDown(400);
                },
               });
          break;
        case 'organisation':
            $.ajax({
                url: "/profile/cancel/"+section+"/"+$("[name=profile-slug]").val(),
                type:"GET",
                success:function(response){
                  $('.edit-organisations-section').html(response.html).fadeOut(400).delay(200).slideDown(400);
              },
             });
          break;
          case 'assistant':
              $.ajax({
                  url: "/profile/cancel/"+section+"/"+$("[name=profile-slug]").val(),
                  type:"GET",
                  success:function(response){
                    $('.edit-assistant-section').html(response.html).fadeOut(400).delay(200).slideDown(400);
                },
               });
            break;
        default:
      }
  });

  $('body').on('click', '.add-organisation-btn', function(e){
      e.preventDefault();
      var entity = $(this).attr('entity');

      switch (entity) {
        case 'organisation':
              $('#organisationsModal').modal('show').append(response.html).fadeOut(400).delay(200).slideDown(400);
          break;
        default:

      }

  })

});
