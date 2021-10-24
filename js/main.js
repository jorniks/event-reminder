
$(document).ready(function () {
  $('.datepicker').pickadate({
    // An integer (positive/negative) sets it relative to today.
    min: true,
    // `true` sets it to today. `false` removes any limits.
    max: false,
    format: 'dd mmmm, yyyy'
  })

  // Time Picker Initialization
  $('.timepicker').pickatime({
    // Light or Dark theme
    darktheme: true,
    fromnow: 600000, // 10 MIN FROM CURRENT TIME
    donetext: 'set',
    'default': 'now',
    twelvehour: true
  });


  // Toastr Notification
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "showDuration": 2000,
    "hideDuration": 1000,
    "timeOut": 2500,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

  // Animations initialization
  new WOW().init();

})


//FUNCTION TO GET AND DISPLAY CURRENT DATE AND TIME AT TOP OF THE PAGE
function displayDateAndTime() {
  //Insert current date at the heading
  var dateObj = new Date(),
      // month = dateObj.getUTCMonth() + 1, //months from 1-12
      // day = dateObj.getUTCDate(),
      // year = dateObj.getUTCFullYear(),
      // newdate = year + "-" + month + "-" + day,
      date = dateObj.toLocaleDateString(navigator.language, {year: 'numeric', month: 'short', day: '2-digit'}),
      laterDater = dateObj.toLocaleTimeString(navigator.language, { hour: '2-digit', minute: '2-digit', second: '2-digit' })

  document.getElementById("topDate").innerHTML = date;

  //Insert current time at the heading
  document.getElementById("topTime").innerHTML = laterDater;
}

//HANDLE CREATE EVENT FORM SUBMISSION
$("#createEventForm").submit(function (event) {
  event.preventDefault();
  createEvent();
});


function createEvent() {
  var title = $("#createEventFormTitle").val().trim();
  var date = $("#createEventFormDate").val().trim();
  var time = $("#createEventFormTime").val().trim();
  var note = $("#createEventFormNote").val().trim();
  var recurring = "false";

  if ($('.createEventFormRecurring').is(":checked")) {
    recurring = "true";
  }

  $.ajax({
    url: "../backend/event.php",
    type: "POST",
    async: false,
    data: {
      "newTitle": title,
      "newDate": date,
      "newTime": time,
      "newNote": note,
      "newCheck": recurring,
    },
    // CAPTURE PHP RESPONSE FROM DATABASE EXECUTION AND POST APPROPRIATELY
    success: function (response) {
      if (response == 1) {
        toastr["warning"]("You have an event set for this time on the same day! Change the time slot and try again.");
      } else if (response == 2) {
        //Clear all text fields
        $("#createEventForm").reset();
        //Display success message
        toastr["success"]("Succesfuly created new event!");
        setTimeout(() => {
          window.location = "../dashboard";
        }, 2000);
      } else if (response == 3) {
        toastr["warning"]("Failed to create new event!");
      } else {
        toastr["warning"](response);
      }

    }
  });
}

function enableCreateEventButton() {
  var create_title = $("#createEventFormTitle").val().trim();
  var create_date = $("#createEventFormDate").val().trim();
  var create_time = $("#createEventFormTime").val().trim();
  var create_note = $("#createEventFormNote").val().trim();


  if (create_title && create_date && create_time && create_note) {
    $("#createEventButtonAdd").removeClass("disabled");
  } else {
    $("#createEventButtonAdd").addClass("disabled");
  }
}