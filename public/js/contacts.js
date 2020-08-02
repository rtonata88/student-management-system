$(document).ready(function() {
  $('body').on('click', '.edit-btn', function(){
      var section = $(this).attr('section');
      var profile = $(this).val();

      switch (section) {
        case 'about':
              $(".other-information-secion").hide();
              $.ajax({
                url: "/load/about/"+profile+"/"+section,
              }).done(function( data ) {
                  $(".about-section").html(data.html)
              });
          break;
        case 'contact':

          break;
        case 'relationship':

          break;
        default:
      }
    });

  $('body').on('click', '.save-btn', function(e){
      e.preventDefault();
      var section = $(this).attr('section');
      var profile = $(this).val();

      switch (section) {
        case 'about':

            $("#profile-edit-form").ajaxForm(function(response) {

                          });

          break;
        case 'contact':

          break;
        case 'relationship':

          break;
        default:
      }
  });

  $('body').on('click', '.cancel-btn', function(e){
      e.preventDefault();
      var section = $(this).attr('section');
      var profile = $('#profile-slug').val();

      switch (section) {
        case 'about':
          $.ajax({
            url: "/load/about/"+profile+"/"+section,
          }).done(function( data ) {
              $(".about-section").html(data.html)
          });
              $(".other-information-secion").show();
          break;
        case 'contact':

          break;
        case 'relationship':

          break;
        default:
      }
  });

});
