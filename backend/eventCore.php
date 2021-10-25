
<?php

  include '../vendor/autoload.php';
  date_default_timezone_set("Africa/Lagos");

  class EventCore {

    public function setEventValues() {
      if ($_POST) {
        $eventTitle = $_POST['eventTitle'];
        $eventDate = $_POST['eventDate'];
        $eventTime = $_POST['eventTime'];
        $eventNote = $_POST['eventNote'];
        $eventPersonEmail = $_POST['eventPersonEmail'];
        $eventPersonName = $_POST['eventPersonName'];

        echo date('d-m-Y H:i', strtotime('-5mins', strtotime("$eventTime $eventDate")));
        if(strtotime($eventTime) < strtotime('+9mins', time())) {
          return array('eventMsg' => 'Please set event time to be atleat 10 mins from now', 'eventTitle' => $eventTitle, 'eventDate' => $eventDate, 'eventTime' => $eventTime, 'eventNote' => $eventNote, 'eventPersonEmail' => $eventPersonEmail, 'eventPersonName' => $eventPersonName);
        }

        $eventInfo = array('eventTitle' => $eventTitle, 'eventDate' => $eventDate, 'eventTime' => $eventTime, 'sendTime' => strtotime('-5mins', strtotime("$eventTime $eventDate")), 'eventNote' => addslashes(preg_replace('/\s+/', ' ', trim($eventNote))), 'eventPersonEmail' => $eventPersonEmail, 'eventPersonName' => $eventPersonName);
        return $this->sendMail($eventInfo);
      }
    }

    private function sendMail(array $eventInfo) {
      $mailerRequestBody = json_decode('{
        "content": [{
          "type": "text/html",
          "value": "'. $eventInfo['eventNote'] .'"
        }],
        "from": {
          "email": "'. $eventInfo['senderEmail'] .'",
          "name": "'. $eventInfo['senderName'] .'"
        }, 
        "personalizations": [{
          "bcc": [{
            "email": "jonyx747@gmail.com",
            "name": "John"
          }],
          "send_at": '. $eventInfo['sendTime'] .',
          "subject": "'. $eventInfo['eventTitle'] .'",
          "to": [
            {
              "email": "'. $eventInfo['eventPersonEmail'] .'",
              "name": "'. $eventInfo['eventPersonName'] .'"
            }
          ]
        }]
      }');
      return array('eventMsg' => 'Event set successfully. Wait for your mail reminder');
    }

  }
  

?>