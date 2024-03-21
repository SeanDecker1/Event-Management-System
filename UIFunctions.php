<?php

require_once "PDO.DB.class.php";

function headerUI() {

    session_name('loginSession');
    session_start();

    if (!isset($_SESSION['loggedIn'])) {
        header("Location: user-login.php");
        exit;
    } elseif ($_SESSION['loggedIn']) {
        
        // Echos cookies
        // foreach($_COOKIE as $k => $v) {
        //     echo $k." ".$v;
        // }

        echo('
            <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
                    <meta http-equiv="x-ua-compatible" content="ie=edge" />
                    <title>Event Management System</title>
                    <!-- Font Awesome -->
                    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
                    <!-- Google Fonts Roboto -->
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
                    <!-- MDB -->
                    <link rel="stylesheet" href="css/mdb.min.css" />
                    <!-- Custom styles -->
                    <link rel="stylesheet" href="css/admin.css" />
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
                    crossorigin="anonymous"></script>
                </head>
                <body>
                    <!--Main layout-->
                    <main style="margin-top: 58px">
                        <div class="container pt-4">
        ');

    }// Ends if

} // Ends headerUI

function navigationUI() {

    echo ('
      <!--Main Navigation-->
      <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
          <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
    ');
    
    // Hides admin option if user is not an admin or manager
    if ($_COOKIE["loggedInRole"] != "3") {
        echo ('
                <a href="Admin.php" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Admin</span>
                </a>
        ');
    }

    echo ('
                <a href="Events.php" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-calendar fa-fw me-3"></i><span>Events</span>
                </a>
                <a href="Registrations.php" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-users fa-fw me-3"></i><span>Registrations</span>
                </a>
            </div>
          </div>
        </nav>
        <!-- Sidebar -->
    
        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
          <!-- Container wrapper -->
          <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
              aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fas fa-bars"></i>
            </button>
    
            <!-- Right links -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
    
              <!-- Avatar -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
                  id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user-alt"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                  <li><a class="dropdown-item" href="user-login.php?logout">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
      </header>
      <!--Main Navigation-->
    ');
} // Ends navigationUI

function footerUI() {
  echo('
            </div>
        </main>
        <!--Main layout-->
        <!-- MDB -->
        <script type="text/javascript" src="js/mdb.min.js"></script>
        <!-- Custom scripts -->
        <script type="text/javascript" src="js/admin.js"></script>
    
    </body>
    
    </html>
  ');
} // Ends footerUI

function loginFormUI() {
  echo('
    <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
          <meta http-equiv="x-ua-compatible" content="ie=edge" />
          <title>Event Management System</title>
          <!-- Font Awesome -->
          <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
          <!-- Google Fonts Roboto -->
          <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
          <!-- MDB -->
          <link rel="stylesheet" href="css/mdb.min.css" />
          <!-- Custom styles -->
          <link rel="stylesheet" href="css/admin.css" />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
          crossorigin="anonymous"></script>
        </head>
        <body>
            <div class="container pt-4 d-flex justify-content-center">
                <div class="col-md-6">
                    <h1 class="mb-3 text-center">Login</h1>
                    <form action="Validate.php?type=login" method="post">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="name" id="loginFormName" name="loginFormName" class="form-control" />
                            <label class="form-label" for="loginFormName">Name</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="loginFormPassword" name="loginFormPassword" class="form-control" />
                            <label class="form-label" for="loginFormPassword">Password</label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    </form>
                </div>
            </div>
            <!-- MDB -->
            <script type="text/javascript" src="js/mdb.min.js"></script>
            <!-- Custom scripts -->
            <script type="text/javascript" src="js/admin.js"></script>
        </body>
    </html>
  ');

} // Ends loginFormUI

function adminPageUI() {

    $db = new DB();

    // If the user is not an admin or manager, they get sent back to the Events page
    if ($_COOKIE["loggedInRole"] == "3") {
        header("Location: Events.php");
        exit;
    } // Ends if


    if ($_COOKIE["loggedInRole"] == "1") {
        echo ('
        <!--Section: User/Attendee Table-->
        <section class="mb-4">
          <div class="card">
            <div class="card-header text-center py-3">
              <h5 class="mb-0 text-center">
                <strong>Users</strong>
              </h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                  '.$db->getAllAttendeeObjectsAsTable().'
                </table>
                <div class="text-center">
                  <a href="ModifyItem.php?type=user&action=add">
                    <button type="submit" class="btn btn-primary w-75">Add User</button>
                  </a>
                </div
              </div>
            </div>
          </div>
        </section>
        <!--Section: User/Attendee Table-->

        <!--Section: Venues Table-->
        <section class="mb-4">
          <div class="card">
            <div class="card-header text-center py-3">
              <h5 class="mb-0 text-center">
                <strong>Venues</strong>
              </h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                  '.$db->getAllVenueObjectsAsTable().'
                </table>
                <div class="text-center">
                  <a href="ModifyItem.php?type=venue&action=add">
                    <button type="submit" class="btn btn-primary w-75">Add Venue</button>
                  </a>
                </div
              </div>
            </div>
          </div>
        </section>
        <!--Section: Venues Table-->
        ');
    } // Ends if logged in user is an admin

    //'.$db->getAllEventObjectsAsTable().'

    echo ('
        <!--Section: Events Table-->
        <section class="mb-4">
          <div class="card">
            <div class="card-header text-center py-3">
              <h5 class="mb-0 text-center">
                <strong>Events</strong>
              </h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover text-nowrap">
    ');

    if ($_COOKIE["loggedInRole"] == "1") {
        echo $db->getAllEventObjectsAsTable();
    } elseif ($_COOKIE["loggedInRole"] == "2") {
        echo $db->getAllManagerEventObjectsByManagerAsTable($_COOKIE["loggedInID"]);
    }

    echo ('
                </table>
                <div class="text-center">
                  <a href="ModifyItem.php?type=event&action=add">
                    <button type="submit" class="btn btn-primary w-75">Add Event</button>
                  </a>
                </div
              </div>
            </div>
          </div>
        </section>
        <!--Section: Event Table-->

        <!--Section: Session Table-->
        <section class="mb-4">
          <div class="card">
            <div class="card-header text-center py-3">
              <h5 class="mb-0 text-center">
                <strong>Sessions</strong>
              </h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover text-nowrap">
    ');

    if ($_COOKIE["loggedInRole"] == "1") {
        echo $db->getAllSessionObjectsAsTable();
    } elseif ($_COOKIE["loggedInRole"] == "2") {
        echo $db->getAllManagerSessionObjectsByManagerAsTable($_COOKIE["loggedInID"]);
    }

    echo ('
                </table>
                <div class="text-center">
                  <a href="ModifyItem.php?type=session&action=add">
                    <button type="submit" class="btn btn-primary w-75">Add Session</button>
                  </a>
                </div
              </div>
            </div>
          </div>
        </section>
        <!--Section: Session Table-->
    ');

} // Ends adminPageUI

function eventsPageUI() {
    
    $db = new DB();

    echo '
        <!--Section: Events Table-->
        <section class="mb-4">
        <div class="card">
            <div class="card-header text-center py-3">
            <h5 class="mb-0 text-center">
                <strong>Events</strong>
            </h5>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                '.$db->getAllEventObjectsAsTableView().'
                </table>
                
            </div>
            </div>
        </div>
        </section>
        <!--Section: Event Table-->
    ';

} // Ends eventsPageUI

function registrationsPageUI() {
    
    $db = new DB();

    echo '
        <!--Section: Events Table-->
        <section class="mb-4">
            <div class="card">
                <div class="card-header text-center py-3">
                <h5 class="mb-0 text-center">
                    <strong>Your Events</strong>
                </h5>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                    '.$db->getAllAttendeeEventObjectsByAttendeeID($_COOKIE["loggedInID"]).'
                    </table>
                    <div class="text-center">
                        <a href="ModifyItem.php?type=eventAttendeesRegister&action=add&id='.$_COOKIE["loggedInID"].'">
                            <button type="submit" class="btn btn-primary w-75">Attend Another Event</button>
                        </a>
                    </div
                </div>
                </div>
            </div>
        </section>
        <!--Section: Event Table-->

        <!--Section: Sessions Table-->
        <section class="mb-4">
            <div class="card">
                <div class="card-header text-center py-3">
                <h5 class="mb-0 text-center">
                    <strong>Your Sessions</strong>
                </h5>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                    '.$db->getAllAttendeeSessionObjectsByAttendeeID($_COOKIE["loggedInID"]).'
                    </table>
                    <div class="text-center">
                        <a href="ModifyItem.php?type=sessionAttendeesRegister&action=add&id='.$_COOKIE["loggedInID"].'">
                            <button type="submit" class="btn btn-primary w-75">Attend Another Session</button>
                        </a>
                    </div
                </div>
                </div>
            </div>
        </section>
        <!--Section: Sessions Table-->
    ';

} // Ends registrationsPageUI

function addFormUI($type) {

    if ($type == "user") {

        echo('
            <section class="mb-4">
                <div class="card">
                <div class="text-center py-3">
                    <h3 class="mb-0 text-center">
                    <strong>Add User</strong>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="Validate.php?type=user&action=insert" method="post">

                    <!--Attendee Name-->
                    <div class="form-outline mb-4">
                        <input type="name" id="attendeeName" name="attendeeName" class="form-control" />
                        <label class="form-label" for="attendeeName">Name</label>
                    </div>

                    <!--Attendee Password-->
                    <div class="form-outline mb-4">
                        <input type="password" id="attendeePassword" name="attendeePassword" class="form-control" />
                        <label class="form-label" for="attendeePassword">Password</label>
                    </div>

                    <!--Attendee Role-->
                    <div class="form-outline mb-4">
                        <input type="number" id="attendeeRole" name="attendeeRole" class="form-control" />
                        <label class="form-label" for="attendeeRole">Role</label>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Add User</button>
                    </form>
                </div>
                </div>
            </section>
        ');

    } elseif ($type == "venue") {

        echo('
            <section class="mb-4">
                <div class="card">
                <div class="text-center py-3">
                    <h3 class="mb-0 text-center">
                    <strong>Add Venue</strong>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="Validate.php?type=venue&action=insert" method="post">

                    <!--Venue Name-->
                    <div class="form-outline mb-4">
                        <input type="name" id="venueName" name="venueName" class="form-control" />
                        <label class="form-label" for="venueName">Venue Name</label>
                    </div>

                    <!--Venue Capacity-->
                    <div class="form-outline mb-4">
                        <input type="number" id="venueCapacity" name="venueCapacity" class="form-control" />
                        <label class="form-label" for="venueCapacity">Capacity</label>
                    </div>

                    <!-- Venue button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Add Venue</button>
                    </form>
                </div>
                </div>
            </section>
        ');

    } elseif ($type == "event") {

        echo('
            <section class="mb-4">
                <div class="card">
                <div class="text-center py-3">
                    <h3 class="mb-0 text-center">
                    <strong>Add Event</strong>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="Validate.php?type=event&action=insert" method="post">

                    <!--Event Name-->
                    <div class="form-outline mb-4">
                        <input type="name" id="eventName" name="eventName" class="form-control" />
                        <label class="form-label" for="eventName">Event Name</label>
                    </div>

                    <!--Event Number Allowed-->
                    <div class="form-outline mb-4">
                        <input type="number" id="eventNumberAllowed" name="eventNumberAllowed" class="form-control" />
                        <label class="form-label" for="eventNumberAllowed">Max Attendees</label>
                    </div>

                    <!--Event Venue-->
                    <div class="form-outline mb-4">
                        <input type="number" id="eventVenue" name="eventVenue" class="form-control" />
                        <label class="form-label" for="eventVenue">Venue</label>
                    </div>

                    <!--Event Start Date-->
                    <div class="form-outline mb-4">
                        <input type="text" id="eventStartDate" name="eventStartDate" class="form-control" />
                        <label class="form-label" for="eventStartDate">Start Date</label>
                        <div class="form-helper">MM/DD/YYYY</div>
                    </div>

                    <!--Event End Date-->
                    <div class="form-outline mb-4">
                        <input type="text" id="eventEndDate" name="eventEndDate" class="form-control" />
                        <label class="form-label" for="eventStartDate">End Date</label>
                        <div class="form-helper">MM/DD/YYYY</div>
                    </div>

                    <!--Add Button-->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Add Event</button>
                    </form>
                </div>
                </div>
            </section>
        ');

    } elseif ($type == "session") {

        echo('
            <section class="mb-4">
                <div class="card">
                <div class="text-center py-3">
                    <h3 class="mb-0 text-center">
                    <strong>Add Session</strong>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="Validate.php?type=session&action=insert" method="post">

                    <!--Session Name-->
                    <div class="form-outline mb-4">
                        <input type="name" id="sessisonName" name="sessionName" class="form-control" />
                        <label class="form-label" for="sessisonName">Session Name</label>
                    </div>

                    <!--Session Number Allowed-->
                    <div class="form-outline mb-4">
                        <input type="number" id="sessionNumberAllowed" name="sessionNumberAllowed" class="form-control" />
                        <label class="form-label" for="sessionNumberAllowed">Max Attendees</label>
                    </div>

                    <!--Session Event-->
                    <div class="form-outline mb-4">
                        <input type="number" id="sessionEvent" name="sessionEvent" class="form-control" />
                        <label class="form-label" for="sessionEvent">Event</label>
                    </div>

                    <!--Session Start Date-->
                    <div class="form-outline mb-4">
                        <input type="text" id="sessionStartDate" name="sessionStartDate" class="form-control" />
                        <label class="form-label" for="sessionStartDate">Start Date</label>
                        <div class="form-helper">MM/DD/YYYY</div>
                    </div>

                    <!--Session End Date-->
                    <div class="form-outline mb-4">
                        <input type="text" id="sessionEndDate" name="sessionEndDate" class="form-control" />
                        <label class="form-label" for="sessionEndDate">End Date</label>
                        <div class="form-helper">MM/DD/YYYY</div>
                    </div>

                    <!--Add Button-->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Add Session</button>
                    </form>
                </div>
                </div>
            </section>
        ');

    } elseif ($type == "eventAttendees") {
        echo('
            <section class="mb-4">
                <div class="card">
                <div class="text-center py-3">
                    <h3 class="mb-0 text-center">
                    <strong>Attend Event</strong>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="Validate.php?type=eventAttendeesRegister&action=add" method="post">

                    <!--Attendee ID-->
                    <input type="hidden" id="attendeeID" name="attendeeID" value="'.$_COOKIE["loggedInID"].'" />

                    <!--Event ID-->
                    <div class="form-outline mb-4">
                        <input type="number" id="eventID" name="eventID" class="form-control" />
                        <label class="form-label" for="eventID">Event ID</label>
                    </div>

                    <!--Paid-->
                    <div class="form-outline mb-4">
                        <input type="number" id="paid" name="paid" class="form-control" />
                        <label class="form-label" for="paid">Paid</label>
                    </div>

                    <!-- Attend button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Attend Event</button>
                    </form>
                </div>
                </div>
            </section>
        ');
    } elseif ($type == "sessionAttendees") {
        echo('
            <section class="mb-4">
                <div class="card">
                <div class="text-center py-3">
                    <h3 class="mb-0 text-center">
                    <strong>Attend Session</strong>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="Validate.php?type=sessionAttendeesRegister&action=add" method="post">
                    <!--Attendee ID-->
                    <input type="hidden" id="attendeeID" name="attendeeID" value="'.$_COOKIE["loggedInID"].'" />

                    <!--Session ID-->
                    <div class="form-outline mb-4">
                        <input type="number" id="sessionID" name="sessionID" class="form-control" />
                        <label class="form-label" for="sessionID">Session ID</label>
                    </div>

                    <!-- Attend button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Attend Session</button>
                    </form>
                </div>
                </div>
            </section>
        ');
    } // Ends type if

} // Ends addFormUI

function editFormUI($type, $id) {

  $db = new DB();

  if ($type == "user") {

    $attendeeObject = $db->getAttendeeObject($id);

    echo('
          <section class="mb-4">
            <div class="card">
              <div class="text-center py-3">
                <h3 class="mb-0 text-center">
                  <strong>Edit User</strong>
                </h3>
              </div>
              <div class="card-body">
                <form action="Validate.php?type=user&action=edit" method="post">
                  <!--Attendee ID-->
                  <input type="hidden" id="attendeeID" name="attendeeID" value="'.$id.'" />

                  <!--Attendee Name-->
                  <div class="form-outline mb-4">
                    <input type="name" id="attendeeName" name="attendeeName" class="form-control" value="'.$attendeeObject->getName().'" />
                    <label class="form-label" for="attendeeName">Name</label>
                  </div>

                  <!--Attendee Password-->
                  <div class="form-outline mb-4">
                    <input type="text" id="attendeePassword" name="attendeePassword" class="form-control" value="'.$attendeeObject->getPassword().'" />
                    <label class="form-label" for="attendeePassword">Password</label>
                  </div>

                  <!--Attendee Role-->
                  <div class="form-outline mb-4">
                    <input type="number" id="attendeeRole" name="attendeeRole" class="form-control" value="'.$attendeeObject->getRole().'" />
                    <label class="form-label" for="attendeeRole">Role</label>
                  </div>

                  <!-- Submit button -->
                  <button type="submit" class="btn btn-primary btn-block mb-4">Update User</button>
                </form>
              </div>
            </div>
          </section>
    ');

  } elseif ($type == "venue") {

    $venueObject = $db->getVenueObject($id);

    echo('
          <section class="mb-4">
            <div class="card">
              <div class="text-center py-3">
                <h3 class="mb-0 text-center">
                  <strong>Edit Venue</strong>
                </h3>
              </div>
              <div class="card-body">
                <form action="Validate.php?type=venue&action=edit" method="post">
                  <!--Venue ID-->
                  <input type="hidden" id="venueID" name="venueID" value="'.$id.'" />

                  <!--Venue Name-->
                  <div class="form-outline mb-4">
                    <input type="name" id="venueName" name="venueName" class="form-control" value="'.$venueObject->getVenueName().'" />
                    <label class="form-label" for="venueName">Venue Name</label>
                  </div>

                  <!--Venue Capacity-->
                  <div class="form-outline mb-4">
                    <input type="number" id="venueCapacity" name="venueCapacity" class="form-control" value="'.$venueObject->getVenueCapacity().'" />
                    <label class="form-label" for="venueCapacity">Capacity</label>
                  </div>

                  <!-- Venue button -->
                  <button type="submit" class="btn btn-primary btn-block mb-4">Update Venue</button>
                </form>
              </div>
            </div>
          </section>
    ');

  } elseif ($type == "event") {

    $eventObject = $db->getEventObject($id);

    echo('
          <section class="mb-4">
            <div class="card">
              <div class="text-center py-3">
                <h3 class="mb-0 text-center">
                  <strong>Edit Event</strong>
                </h3>
              </div>
              <div class="card-body">
                <form action="Validate.php?type=event&action=edit" method="post">
                  <!--Event ID-->
                  <input type="hidden" id="eventID" name="eventID" value="'.$id.'" />

                  <!--Event Name-->
                  <div class="form-outline mb-4">
                    <input type="name" id="eventName" name="eventName" class="form-control" value="'.$eventObject->getEventName().'" />
                    <label class="form-label" for="eventName">Event Name</label>
                  </div>

                  <!--Event Number Allowed-->
                  <div class="form-outline mb-4">
                    <input type="number" id="eventNumberAllowed" name="eventNumberAllowed" class="form-control" value="'.$eventObject->getEventAllowed().'" />
                    <label class="form-label" for="eventNumberAllowed">Max Attendees</label>
                  </div>

                  <!--Event Venue-->
                  <div class="form-outline mb-4">
                    <input type="number" id="eventVenue" name="eventVenue" class="form-control" value="'.$eventObject->getEventVenue().'" />
                    <label class="form-label" for="eventVenue">Venue</label>
                  </div>

                  <!--Event Start Date-->
                  <div class="form-outline mb-4">
                    <input type="text" id="eventStartDate" name="eventStartDate" class="form-control" value="'.date('m/d/Y', strtotime($eventObject->getEventStart())).'" />
                    <label class="form-label" for="eventStartDate">Start Date</label>
                    <div class="form-helper">MM/DD/YYYY</div>
                  </div>

                  <!--Event End Date-->
                  <div class="form-outline mb-4">
                    <input type="text" id="eventEndDate" name="eventEndDate" class="form-control" value="'.date('m/d/Y', strtotime($eventObject->getEventEnd())).'" />
                    <label class="form-label" for="eventStartDate">End Date</label>
                    <div class="form-helper">MM/DD/YYYY</div>
                  </div>

                  <!--Add Button-->
                  <button type="submit" class="btn btn-primary btn-block mb-4">Update Event</button>
                </form>
              </div>
            </div>
          </section>
    ');

  } elseif ($type == "session") {

    $sessionObject = $db->getSessionObject($id);

    echo('
          <section class="mb-4">
            <div class="card">
              <div class="text-center py-3">
                <h3 class="mb-0 text-center">
                  <strong>Edit Session</strong>
                </h3>
              </div>
              <div class="card-body">
                <form action="Validate.php?type=session&action=edit" method="post">
                  <!--Session ID-->
                  <input type="hidden" id="sessionID" name="sessionID" value="'.$id.'" />

                  <!--Session Name-->
                  <div class="form-outline mb-4">
                    <input type="name" id="sessionName" name="sessionName" class="form-control" value="'.$sessionObject->getSessionName().'" />
                    <label class="form-label" for="sessisonName">Session Name</label>
                  </div>

                  <!--Session Number Allowed-->
                  <div class="form-outline mb-4">
                    <input type="number" id="sessionNumberAllowed" name="sessionNumberAllowed" class="form-control" value="'.$sessionObject->getSessionNumberAllowed().'" />
                    <label class="form-label" for="sessionNumberAllowed">Max Attendees</label>
                  </div>

                  <!--Session Event-->
                  <div class="form-outline mb-4">
                    <input type="number" id="sessionEvent" name="sessionEvent" class="form-control" value="'.$sessionObject->getSessionEvent().'" />
                    <label class="form-label" for="sessionEvent">Event</label>
                  </div>

                  <!--Session Start Date-->
                  <div class="form-outline mb-4">
                    <input type="text" id="sessionStartDate" name="sessionStartDate" class="form-control" value="'.date('m/d/Y', strtotime($sessionObject->getSessionStartDate())).'" />
                    <label class="form-label" for="sessionStartDate">Start Date</label>
                    <div class="form-helper">MM/DD/YYYY</div>
                  </div>

                  <!--Session End Date-->
                  <div class="form-outline mb-4">
                    <input type="text" id="sessionEndDate" name="sessionEndDate" class="form-control" value="'.date('m/d/Y', strtotime($sessionObject->getSessionEndDate())).'" />
                    <label class="form-label" for="sessionEndDate">End Date</label>
                    <div class="form-helper">MM/DD/YYYY</div>
                  </div>

                  <!--Add Button-->
                  <button type="submit" class="btn btn-primary btn-block mb-4">Update Session</button>
                </form>
              </div>
            </div>
          </section>
    ');

  } // Ends type if

} // Ends editFormUI

function sessionAttendeesPageUI() {
    
    $db = new DB();

    if ($_GET["action"] == "get") {

        echo ('
        <section class="mb-4">
            <div class="card">
                <div class="card-header text-center py-3">
                <h5 class="mb-0 text-center">
                    <strong>Session Attendees</strong>
                </h5>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                    '.$db->getAllAttendeeSessionObjectsBySessionID($_GET["id"]).'
                    </table>
                    <div class="text-center">
                        <a href="ModifyItem.php?type=sessionAttendees&action=add&id='.$_GET["id"].'">
                            <button type="submit" class="btn btn-primary w-75">Add Attendee to Session</button>
                        </a>
                    </div
                </div>
                </div>
            </div>
        </section>
        ');
    
    } elseif ($_GET["action"] == "add") {
    
        echo('
          <section class="mb-4">
            <div class="card">
              <div class="text-center py-3">
                <h3 class="mb-0 text-center">
                  <strong>Add Session Attendee</strong>
                </h3>
              </div>
              <div class="card-body">
                <form action="Validate.php?type=sessionAttendees&action=add&id='.$_GET["id"].'" method="post">

                    <!--Session ID-->
                    <input type="hidden" id="sessionID" name="sessionID" value="'.$_GET["id"].'" />

                    <!--Attendee ID-->
                    <div class="form-outline mb-4">
                        <input type="number" id="attendeeID" name="attendeeID" class="form-control" />
                        <label class="form-label" for="attendeeID">Attendee ID</label>
                    </div>

                  <!-- Submit button -->
                  <button type="submit" class="btn btn-primary btn-block mb-4">Add Attendee</button>
                </form>
              </div>
            </div>
          </section>
        ');
      } // Ends type if
    

} // Ends sessionAttendeesPageUI

function eventAttendeesPageUI() {
    
    $db = new DB();

    if ($_GET["action"] == "get") {

        echo ('
        <section class="mb-4">
            <div class="card">
                <div class="card-header text-center py-3">
                <h5 class="mb-0 text-center">
                    <strong>Event Attendees</strong>
                </h5>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap">
                    '.$db->getAllAttendeeEventObjectsByEventID($_GET["id"]).'
                    </table>
                    <div class="text-center">
                        <a href="ModifyItem.php?type=eventAttendees&action=add&id='.$_GET["id"].'">
                            <button type="submit" class="btn btn-primary w-75">Add Attendee to Event</button>
                        </a>
                    </div
                </div>
                </div>
            </div>
        </section>
        ');
    
    } elseif ($_GET["action"] == "add") {
    
        echo('
          <section class="mb-4">
            <div class="card">
              <div class="text-center py-3">
                <h3 class="mb-0 text-center">
                  <strong>Add Event Attendee</strong>
                </h3>
              </div>
              <div class="card-body">
                <form action="Validate.php?type=eventAttendees&action=add&id='.$_GET["id"].'" method="post">

                    <!--Event ID-->
                    <input type="hidden" id="eventID" name="eventID" value="'.$_GET["id"].'" />

                    <!--Attendee ID-->
                    <div class="form-outline mb-4">
                        <input type="number" id="attendeeID" name="attendeeID" class="form-control" />
                        <label class="form-label" for="attendeeID">Attendee ID</label>
                    </div>

                    <!--Paid-->
                    <div class="form-outline mb-4">
                        <input type="number" id="paid" name="paid" class="form-control" />
                        <label class="form-label" for="paid">Paid</label>
                    </div>

                  <!-- Submit button -->
                  <button type="submit" class="btn btn-primary btn-block mb-4">Add Attendee</button>
                </form>
              </div>
            </div>
          </section>
        ');
      } // Ends type if
    

} // Ends eventAttendeesPageUI

?>