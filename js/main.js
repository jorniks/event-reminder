
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
  var dateObj = new Date(),
      date = dateObj.toLocaleDateString(navigator.language, {year: 'numeric', month: 'short', day: '2-digit'}),
      laterDater = dateObj.toLocaleTimeString(navigator.language, { hour: '2-digit', minute: '2-digit', second: '2-digit' })

  //Insert current date at the heading
  document.getElementById("topDate").innerHTML = date;

  //Insert current time at the heading
  document.getElementById("topTime").innerHTML = laterDater;
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


/*==================================================================
  UNCOMMENT THE CODE BELOW IF YOU PREFER TO USE A JQUERY APPROACH
==================================================================*/

//HANDLE CREATE EVENT FORM SUBMISSION
/* 
$("#createEventForm").submit(function (event) {
  event.preventDefault();
  createEvent();
});


function createEvent() {
  let formData = $('#createEventForm').serialize()

  $.ajax({
    url: "./backend/event.php",
    type: "POST",
    data: formData,
    // CAPTURE PHP RESPONSE FROM DATABASE EXECUTION AND POST APPROPRIATELY
    success: function (response) {
      let responseData = JSON.parse(response)
      toastr[responseData["eventCode"]](responseData["eventMsg"]);
      if (responseData["eventCode"] === 'success') {
        $('#createEventForm').trigger('reset')
      }
    }
  });
}
 */