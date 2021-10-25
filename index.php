<!DOCTYPE html>
<html lang="en" class="full-height">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Event Reminder</title>
    <link href="images/icon.png" rel="icon">

    <!-- Local Icon sets -->
    <link rel="stylesheet" href="font/font-awesome/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <style>
      .default-bg-color{
        background-color: #0F3661 !important;
      }
    </style>
  </head>

  <body class="rgba-grey-light">

    <!-- Mini Navigation bar -->
    <nav class="navbar navbar-expand navbar-dark default-bg-color py-3 text-center text-white">
      <!-- <ul class="container-fluid default-bg-color"> -->
      <ul class="navbar-nav w-100 flex-center wow zoomIn">
        <li class="col-6">
          <i class="far fa-calendar-alt pink-text"></i>
          <span class="ml-1 small d-inline-block" id="topDate"></span>
        </li>
        
        <li class="col-6">
          <i class="far fa-clock pink-text"></i>
          <span class="ml-1 small d-inline-block" id="topTime"></span>
        </li>
      </ul>
      <!-- </div> -->
    </nav>
    <!-- Mini Navigation bar -->

    <main class="col-md-6 mx-auto my-5">

    <?php
      include 'backend/eventCore.php';

      $event = new EventCore();
      $eventValue = $event->setEventValues();

      $eventPersonName = $eventValue['eventPersonName'] ?? '';
      $eventPersonEmail = $eventValue['eventPersonEmail'] ?? '';
      $eventTitle = $eventValue['eventTitle'] ?? '';
      $eventDate = $eventValue['eventDate'] ?? '';
      $eventTime = $eventValue['eventTime'] ?? '';
      $eventNote = $eventValue['eventNote'] ?? '';
      $eventMsg = $eventValue['eventMsg'] ?? '';
    ?>


      <div class="mx-1 mx-sm-0 shadow-lg bg-white p-3 p-sm-5">
        <label class="lead">Create New Event</label>
        <div class="font-weight-bold small mdb-color-text darken-3">
          All reminders are sent 5 minutes before set time.
        </div>

        <form id="createEventForm" method="POST" autocomplete="false">
          <div class="md-form">
            <input type="text" value="<?=$eventPersonName?>" name="eventPersonName" id="createEventFormName" class="form-control font-weight-bold"
              required>
            <label class="mdb-color-text darken-3" for="createEventFormName">Your Name</label>
          </div>

          <div class="md-form">
            <input type="email" value="<?=$eventPersonEmail?>" name="eventPersonEmail" id="createEventFormEmail" class="form-control font-weight-bold"
              required>
            <label class="mdb-color-text darken-3" for="createEventFormEmail">Your Email</label>
          </div>
          
          <div class="md-form">
            <input type="text" value="<?=$eventTitle?>" name="eventTitle" id="createEventFormTitle" class="form-control font-weight-bold"
              required>
            <label class="mdb-color-text darken-3" for="createEventFormTitle">Event Title</label>
          </div>

          <!-- Date of Event -->
          <div class="md-form mt-0">
            <input type="text" value="<?=$eventDate?>" name="eventDate" id="createEventFormDate" class="form-control font-weight-bold datepicker">
            <label class="mdb-color-text darken-3" for="createEventFormDate">Event Date</label>
          </div>

          <div class="md-form mt-0">
            <input type="text" value="<?=$eventTime?>" name="eventTime" id="createEventFormTime" class="form-control font-weight-bold timepicker">
            <label class="mdb-color-text darken-3" for="createEventFormTime">Event Time</label>
          </div>

          <!-- Note-->
          <div class="md-form mt-0">
            <textarea name="eventNote" id="createEventFormNote" class="md-textarea form-control font-weight-bold" rows="3"><?=$eventNote?></textarea>
            <label class="mdb-color-text darken-3" for="createEventFormNote">Event Description</label>
          </div>
          <!-- Note-->
    
          <!--Footer-->
          <?=$eventMsg?>
          <div class="text-right mt-5">
            <!-- button should be disabled untill all fields are correctly filled -->
            <button class="btn btn-success disabled" id="createEventButtonAdd">
              Set Reminder <i class="far fa-alarm-clock ml-1 text-white"></i>
            </button>
          </div>
        </form>
      
      </div>
    </main>


    <!-- Bootstrap core JavaScript -->
    <!-- ==================================================  -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mdb.js"></script>
    <script src="js/main.js"></script>
    <!-- Date and Time Initialization and limit to current date -->
    
    <script>
      // A $( document ).ready() block.
      $(document).ready(function () {
        //call function to display date and time on page load
        displayDateAndTime();

        //REFRESH DATE AND TIME TO AUTOUPDATE TO THE CURRENT DATE AND TIME
        setInterval(function () {
          displayDateAndTime();
          enableCreateEventButton();
        }, 1000);
        // toastr["success"]("Login Succesful!");
      });
    </script>

  </body>
</html>