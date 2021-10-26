
<?php
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

        if(strtotime($eventTime) < strtotime('+9mins', time())) {
          return array('eventMsg' => 'Please set event time to be atleast 10 mins from now', 'eventCode' => 'error', 'eventTitle' => $eventTitle, 'eventDate' => $eventDate, 'eventTime' => $eventTime, 'eventNote' => $eventNote, 'eventPersonEmail' => $eventPersonEmail, 'eventPersonName' => $eventPersonName);
        }

        $eventInfo = array('eventTitle' => $eventTitle, 'eventDate' => $eventDate, 'eventTime' => $eventTime, 'sendTime' => strtotime('-5mins', strtotime("$eventTime $eventDate")), 'eventNote' => $eventNote, 'eventPersonEmail' => $eventPersonEmail, 'eventPersonName' => $eventPersonName);
        
        return $this->sendMail($eventInfo);
      }
    }

    private function sendMail(array $eventInfo) {
      $mailTemplate = $this->prepareMailTemplate($eventInfo);
      $mailContent = addslashes(preg_replace('/\s+/', ' ', trim($mailTemplate)));

      $mailerRequestBody = json_decode('{
        "content": [{
          "type": "text/html",
          "value": "'. $mailContent .'"
        }],
        "from": {
          "email": "noreply@reminderapp.com",
          "name": "Event Reminder App"
        }, 
        "personalizations": [{
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

      $sendGrid = new \SendGrid(getenv('SENDGRID_KEY'));
      
      try {
        $sendGridResponse = $sendGrid->client->mail()->send()->post($mailerRequestBody);
        if ($sendGridResponse->statusCode() == 202) {
          return array('eventMsg' => 'Event reminder set successfully. Wait for your mail reminder', 'eventCode' => 'success');
        }
        
        $eventInfo['eventCode'] = 'error';
        $eventInfo['eventMsg'] = $sendGridResponse->body();

        return $eventInfo;
      } catch (Exception $sg) {
        $eventInfo['eventCode'] = 'error';
        $eventInfo['eventMsg'] = 'Caught exception: '. $sg->getMessage();

        return $eventInfo;
      }
    }


    protected function prepareMailTemplate(array $eventInfo) {
      $mailTemplate = '
        <section style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #e7e7e7;">
          <div style="width:100%; height:100%; color: #222;">
            <div style="margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word;">
              <div style="background: #fff; margin: 3.5rem 0.5rem; padding: 2rem 1rem 0.5rem 1rem; box-shadow: 0 4px 10px 1px rgba(0,0,0,0.1)">
                <span style="font-weight: 600; font-size: 1.3rem; line-height: 3.5rem; color: #0F3661">Event Reminder Notification</span>
                
                <div style="padding-top: 2rem">
                  Dear '. $eventInfo['eventPersonName'] . ',
                </div>
                <div style="padding-top: 1.5rem;">
                  This is to remind you of the upcoming event you scheduled a reminder for in the next 5 minutes. Details of the schedule are found below.
                </div>

                <div style="padding-top: 1rem;">
                  <table style="width:100%; border-collapse: collapse;">
                    <tr>
                      <td style="font-weight: bold; padding: 0.7rem 0.7rem 0.7rem 0;">Event Title</td>
                      <td style="width:75%;">
                        '. $eventInfo['eventTitle'] .'
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold; padding: 0.7rem 0.7rem 0.7rem 0;">Date & Time</td>
                      <td style="width:75%;">
                        '. $eventInfo['eventDate'] .' | '. $eventInfo['eventTime'] .'
                      </td>
                    </tr>
                    <tr>
                      <td style="font-weight: bold; padding: 0.7rem 0.7rem 0.7rem 0;">Event Description</td>
                      <td style="width:75%;">
                        '. str_replace(["'",'"'], '', $eventInfo['eventNote']) .'
                      </td>
                    </tr>
                  </table>
                </div>

                <div style="color: #0F3661;">
                  <div style="font-size: 1.17rem; font-style: italic; font-weight: 600; padding: 0.75rem; text-align: right;">
                    Best Regards
                  </div>
                </div>

                <div style="font-size: smaller; text-align: center; margin-top: 2.5rem;">
                  &copy; '. date('Y', time()) .' - John 
                </div>
              </div>
            </div>
          </div>
        </section>
      ';

      return $mailTemplate;
    }


  }
  

?>