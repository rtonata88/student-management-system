$(function () {
  $(".summernote").summernote({
    height: 350, // set editor height
    minHeight: null, // set minimum height of editor
    maxHeight: null, // set maximum height of editor
    focus: true, // set focus to editable area after initializing summernote
  });
  $(".inline-editor").summernote({
    airMode: true,
  });
});
(window.edit = function () {
  $(".click2edit").summernote();
}),
  (window.save = function () {
    $(".click2edit").summernote("destroy");
  });
$(document).ready(function ($) {
  $("body").on("DOMNodeInserted", "select", function () {
    $(".select2").select2({
      theme: "bootstrap-5",
      containerCssClass: "select2--small", // For Select2 v4.0
      selectionCssClass: "select2--small", // For Select2 v4.1
      dropdownCssClass: "select2--small",
    });
  });

  $(".select2").select2({
    theme: "bootstrap-5",
    containerCssClass: "select2--small", // For Select2 v4.0
    selectionCssClass: "select2--small", // For Select2 v4.1
    dropdownCssClass: "select2--small",
  });

  $(".data-table").DataTable();

  //Discussion Points
  $("#btn-add-discussion-point").on("click", function () {
    var index = $(".event_discussion").length;

    $(".discussion-points").append(
      '<div class="point' +
        index +
        '"><br><label for="event_discussion[]">Point ' +
        (index + 1) +
        ":</label>" +
        '<textarea class="form-control event_discussion" placeholder="Type here..." required="" rows="2" name="event_discussion[]" cols="50" id="event_discussion' +
        (index + 1) +
        '"></textarea></div>'
    );
  });

  $("#btn-remove-discussion-point").on("click", function () {
    var index = $(".event_discussion").length;
    var rm = index - 1;

    $(".point" + rm).remove();
  });

  //Participant Roles
  $("#btn-add-participant-role").on("click", function () {
    var index = $(".participant-role").length;

    $(".event-participant-roles").append(
      '<div id="participant-role' +
        index +
        '"><br>' +
        '<input type="text" name="participant_roles[]" class="form-control participant-role" placeholder="Ex. Panelists, Media, Guest Speaker"></div>'
    );
  });

  $("#btn-remove-participant-role").on("click", function () {
    var index = $(".participant-role").length;
    var rm = index - 1;

    $("#participant-role" + rm).remove();
  });

  //Staff Roles
  $("#btn-add-staff-role").on("click", function () {
    var index = $(".staff-role").length;

    $(".event-staff-roles").append(
      '<div id="staff-role' +
        index +
        '"><br>' +
        '<input type="text" name="staff_roles[]" class="form-control staff-role" placeholder="Ex. Logistics, IPYG Representative, Media, Manager"></div>'
    );
  });

  $("#btn-remove-staff-role").on("click", function () {
    var index = $(".staff-role").length;
    var rm = index - 1;

    $("#staff-role" + rm).remove();
  });

  //Event Co-hosts
  $("#btn-add-co-host-contact").on("click", function (e) {
    e.preventDefault();
    var index = $(".co-host-contact").length;

    let html = "<tr>";
    html +=
      '<td><input type="text" name="contact_person[]" class="form-control co-host-contact" placeholder="First and lastname"></td>';
    html +=
      '<td><input type="text" name="contact_number[]" class="form-control" placeholder="Contact Number"></td>';
    html +=
      '<td><input type="text" name="contact_email[]" class="form-control" placeholder="Email"></td>';
    html +=
      "<td> <a class='btn btn-danger remove-cohost-contact text-white'>" +
      "X" +
      "</a>" +
      "</td>";
    html += "</tr>";
    $("#co-host-table > tbody").append(html);
  });
  $("#co-host-table").on("click", ".remove-cohost-contact", function () {
    $(this).closest("tr").remove();
  });

  $(document).on("click", ".delete-qualification", function (e) {
    e.preventDefault();
    $(this).closest("table").remove();
  });

  $(document).on("click", ".delete-publication", function (e) {
    e.preventDefault();
    $(this).closest("table").remove();
  });

  $(document).on(
    "change",
    'input:radio[class^="feedback-type"]',
    function (event) {
      if ($(this).val() == "summary") {
        $(".summary-feedback").show();
        $(".detailed-feedback").hide();
      } else if ($(this).val() == "detailed") {
        $(".summary-feedback").hide();
        $(".detailed-feedback").show();
      } else {
        $(".summary-feedback").show();
        $(".specific-feedback").show();
      }
    }
  );

  if ($('input:radio[class^="feedback-type"]').val() == "summary") {
    $(".summary-feedback").show();
    $(".detailed-feedback").hide();
  } else if ($('input:radio[class^="feedback-type"]').val() == "detailed") {
    $(".summary-feedback").hide();
    $(".detailed-feedback").show();
  } else {
    $(".summary-feedback").show();
    $(".specific-feedback").show();
  }

  $("#guest_id").change(function () {
    $.ajax({
      type: "POST",
      url: "/get-guest",
      data: { _token: $("[name=_token]").val(), guest: $(this).val() },
      success: function (results) {
        $("#profile_id").val(results[0].profile_id);
        $("#fullname").val(results[0].fullname);
        $("#lastname").val(results[0].lastname);
        $("#email").val(results[0].email);
        $("#mobile_no").val(results[0].mobile_no);
        $("#work_number").val(results[0].work_number);
        $("#organization").val(results[0].name);
      },
    });
  });

  var course_row = 2;
  $("#btn-external-events-participants").click(function (event) {
    jQuery(function () {
      event.preventDefault();
      var newRow = jQuery(
        "<tr>" +
          "<td>" +
          '<input type="text" name="fullname[]" class="form-control" placeholder="Type here.." required>' +
          "</td>" +
          "<td>" +
          '<input type="text" name="role[]" class="form-control" placeholder="Type here.." required>' +
          "</td>" +
          '<td class="text-center">' +
          '<button class="btn btn-danger btn-rounded btn-remove">' +
          "X" +
          "</button>" +
          "</td>" +
          "</tr>"
      );
      jQuery("#tbl-external-events-participants").append(newRow);
      course_row++;
    });
  });
  $("#tbl-external-events-participants").on(
    "click",
    ".btn-remove",
    function () {
      $(this).closest("tr").remove();
    }
  );

  $("#myInput").on("keyup", function () {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("liaising-list-table");
    tr = table.getElementsByTagName("tr");

    let token = $('meta[name="csrf-token"]').attr("content");

    let searchTerm = $(this).val();

    if (searchTerm.length >= 3) {
      getProfiles(token, $(this).val());
    }

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  });

  $("#add-qualification-btn").on("click", function (e) {
    e.preventDefault();
    let html = qualificationsTable();
    $("#qualifications-section").append(html);
  });

  $("#add-publication-btn").on("click", function (e) {
    e.preventDefault();
    let html = publicationsTable();
    $("#publications-section").append(html);
  });

  $("#add-assistant-btn").on("click", function (e) {
    e.preventDefault();
    $.ajax({
      type: "GET",
      url: "/add-profile-assistant",
      data: { _token: $("[name=_token]").val() },
      success: function (response) {
        $("#assistant-section").append(response.html);
      },
    });
  });

  $("body").on("click", ".remove-organisation-btn", function (e) {
    e.preventDefault();
    //console.log('here')
    if (confirm("Are you sure you want to remove this organisation?")) {
      let deletedId = $(this).attr("data");

      $.ajax({
        type: "POST",
        url: "/delete-profile-organisation",
        data: { _token: $("[name=_token]").val(), id: deletedId },
      });

      $(this).closest("table").remove();
    }
  });

  $("body").on("click", ".remove-assistant-btn", function (e) {
    e.preventDefault();
    //console.log('here')
    if (confirm("Are you sure you want to remove this assistant?")) {
      let deletedId = $(this).attr("data");

      $.ajax({
        type: "POST",
        url: "/delete-profile-assistant",
        data: { _token: $("[name=_token]").val(), id: deletedId },
      });

      $(this).closest("table").remove();
    }
  });
});

function getProfiles(token, query) {
  $.ajax({
    type: "POST",
    url: "/ajax/get-profile-info",
    data: { _token: token, term: query },
    success: function (results) {
      let html = "";
      for (let result of results) {
        if ($("#profiles-" + result.id).length == 0) {
          html +=
            '<tr data="' + result.id + '" id="profiles-' + result.id + '">';
          html += "<td>" + result.fullname + "</td>";
          html += "<td>" + result.lastname + "</td>";
          html += "<td>" + result.team + "</td>";
          html += "<td>" + result.country + "</td>";
          html +=
            '<td> <input type="text" name="role[' +
            result.id +
            '][]" id="" class="form-controls" placeholder="Example; Panelist, Guest Speaker, General"></td>';
          html +=
            '<td class="text-center"><input type="checkbox" data="' +
            result.id +
            '" id="check_"' +
            result.id +
            '" name="invite[' +
            result.id +
            '][]"></td>';
          html += "</tr>";
        }
      }
      console.log(html);
      $("#liaising-list-table > tbody").append(html);
    },
  });
}

function qualificationsTable() {
  return (
    '<div class="qualifications-container">' +
    '<table class="table table-responsive-sm table-bordered table-sm" style="width:100%">' +
    "<tr>" +
    '<th style="background-color: rgba(227, 227, 227, 0.5)">Qualification title</th>' +
    "<td>" +
    '<input type="hidden" name="model" value="Therapist">' +
    '<input type="text" name="qualification_name[]" value="" class="form-control" placeholder="Qualification name" required></input>' +
    "</td>" +
    "</tr>" +
    "<tr>" +
    '<th style="background-color: rgba(227, 227, 227, 0.5)">Institution</th>' +
    "<td>" +
    '<input type="text" name="institution[]" value="" class="form-control" placeholder="Institution" required></input>' +
    "</td>" +
    "</tr>" +
    "<tr>" +
    '<th style="background-color: rgba(227, 227, 227, 0.5)">Start year</th>' +
    "<td>" +
    '<input type="text" name="start_year[]" value="" class="form-control" placeholder="Start year" required></input>' +
    "</td>" +
    "</tr>" +
    "<tr>" +
    '<th style="background-color: rgba(227, 227, 227, 0.5)">End year</th>' +
    "<td>" +
    '<input type="text" name="end_year[]" value="" class="form-control" placeholder="End year" required></input>' +
    "</td>" +
    "</tr>" +
    "<tr>" +
    '<th style="background-color: rgba(227, 227, 227, 0.5)"></th>' +
    "<td>" +
    '<button typ="button" class="btn btn-sm btn-danger delete-qualification">Delete qualification</button>' +
    "</td>" +
    "</tr>" +
    "</table>" +
    "</div>"
  );
}

function publicationsTable() {
  return (
    '<div class="publications-container">' +
    '<table class="table table-responsive-sm table-bordered table-sm" style="width:100%">' +
    "<tr>" +
    '<th style="background-color: rgba(227, 227, 227, 0.5)">Title</th>' +
    "<td>" +
    '<input type="text" name="title[]" value="" class="form-control" placeholder="Publication title" required></input>' +
    "</td>" +
    "</tr>" +
    "<tr>" +
    '<th style="background-color: rgba(227, 227, 227, 0.5)">Abstract</th>' +
    "<td>" +
    '<textarea name="abstract[]" class="form-control" cols="30" rows="10" required></textarea>' +
    "</td>" +
    "</tr>" +
    "<tr>" +
    '<th style="background-color: rgba(227, 227, 227, 0.5)">Other information (i.e. URL) </th>' +
    "<td>" +
    '<input type="text" name="other_information[]" class="form-control" placeholder="i.e. Url, how to access, year published" required></input>' +
    "</td>" +
    "</tr>" +
    '<th style="background-color: rgba(227, 227, 227, 0.5)"></th>' +
    "<td>" +
    '<button typ="button" class="btn btn-sm btn-danger delete-publication">Delete publication</button>' +
    "</td>" +
    "</tr>" +
    "</table>"
  );
}
