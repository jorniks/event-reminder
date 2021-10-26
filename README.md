
# EVENT-REMINDER

This app uses the sendGrid mailing API to dispatch email reminders ahead of time for any event you set for it. The reminders are sent 5 minutes ahead of time so that you won't miss it.

### INSTALLATION GUIDE

  1. After cloning the repo, install sendGrid from the composer.json by running below code from your terminal
    ``` composer install ```

  2. Create a [sendGrid account](https://signup.sendgrid.com/) to get an API key if you don't already have one.

  3. Replace `getenv('SENDGRID_KEY')` with you API KEY and run the app.


### ALTERNATIVE

At run, the app will run fully on PHP for form submission and email dispatch but if you prefer the jQuery ajax approach, uncomment the code at the bottom of the main.js file in `js/main.js` and the jQuery ajax will take over form submission.


:+1: