# K-C-EventMaster

K-C-EventMaster is a Calendar System using HTML/CSS, JS, AJAX, PHP, MySQL.

## Homepage
[Homepage Link] (http://ec2-18-117-107-39.us-east-2.compute.amazonaws.com/~Gokuf/M5/Group/home.php)

## Login Details

When you navigate to the home page, use the following login credentials (choose one of three users).

* Username(s): "abc" ; "red" ; "kanan"

* Password(s): \"3tc!\" ; \"red\" ; \"kanan,2001\"

Or you can create your own user by simply typing the username and password, then clicking on Register.

## Creative Portion
For the creative portion of this project, we implemented the following feautures:

(1) Tag feauture: Users can tag an event with a particular category and enable/disable those tags in the calendar view.

(2) Search feauture: Users can search for events and filter them by category, date, or tag.

(3) Share feauture: Users can share their calendar with additional users.

## Detailed Project-File Analysis

<strong>database.php</strong>: establishes a connection to the MySQL database using the provided credentials.

<strong>home.php</strong>:
 - HTML portion: sets up the document type, language, character encoding, viewport settings, and links to the CSS stylesheet. The body contains sections for user login/logout, the login form, event management, and the calendar display.
 - JavaScript portion: adds event listeners for DOM content load and user actions, handles login status checks, and manages the dynamic display of the calendar and event forms. It also includes methods to manipulate dates and handle user interactions for adding events.

<strong>stylesheets/home.css</strong>: styling for home.php

<strong>ajax.js</strong>: uses the Fetch API to handle asynchronous requests to the server and updating the user interface based on the responses.

### User Management

<strong>login_ajax.php</strong>: handles user login requests by validating the provided username and password against the database and establishing a session with CSRF token set.

<strong>register_ajax.php</strong>: handles user registration requests by creating a new user in the database if the provided username does not already exist.

<strong>logout_ajax.php</strong>: handles user logout requests by destroying the current session and returning a confirmation response.

<strong>is_logged_in.php</strong>: checks if a user is currently logged in and returns the login status as a JSON response.

### Event Management

<strong>dbadd.php</strong>: handles AJAX requests to add a new event to the database. It ensures session security, validates input, prevents XSS and SQL injection attacks, CSRF Token authentication, and provides a JSON response indicating the success or failure of the operation.

<strong>dbview.php</strong>: handles AJAX requests to view events from the database. It ensures session security, validates input, prevents XSS and SQL injection attacks, CSRF Token authentication, and provides a JSON response containing the requested events.

<strong>dbedit.php</strong>: handles AJAX requests to edit an existing event in the database. It ensures session security, validates input, prevents XSS and SQL injection attacks, CSRF Token authentication, and provides a JSON response indicating the success or failure of the operation.

<strong>dbdelete.php</strong>: handles AJAX requests to delete an event from the database. It ensures session security, validates input, prevents SQL injection attacks, CSRF Token authentication, and provides a JSON response indicating the success or failure of the operation.

<strong>share_calendar.php</strong>: handles AJAX requests to share a user's calendar with another user. It ensures session security, validates input, prevents SQL injection attacks, CSRF Token authentication, and provides a JSON response indicating the success or failure of the sharing operation.

<strong>dbgetusers.php</strong>: handles AJAX requests to retrieve a list of users from the database, excluding the logged-in user. It ensures session security, validates input, prevents SQL injection attacks, CSRF Token authentication, and provides a JSON response indicating the success or failure of the operation.


