<?php

require_once "PDO.DB.class.php";
include("UIFunctions.php");

$db = new DB();

if ($_GET["type"] == "user") {

    if ($_GET["action"] != "delete") {
        headerUI();
        navigationUI();
        $errorArray = validateUserInfo();
    }

    // If errorArray holds no items, then the input is valid
    if (count($errorArray) == 0) {
        
        // Updates/Inserts item
        if ($_GET["action"] == "edit") {
            // Update
            $db->updateAttendee(
                sanitizeString($_POST["attendeeID"]),
                sanitizeString($_POST["attendeeName"]),
                sanitizeString($_POST["attendeePassword"]),
                sanitizeString($_POST["attendeeRole"])
            );
        } elseif ($_GET["action"] == "add") {
            // Insert
            $db->insertAttendee(
                sanitizeString($_POST["attendeeName"]),
                sanitizeString($_POST["attendeePassword"]),
                sanitizeString($_POST["attendeeRole"])
            );
        } elseif ($_GET["action"] == "delete") {
            // Delete
            $db->deleteAttendee(sanitizeString($_GET["id"]));
        }

        // Redirects back to admin view
        header("Location: Admin.php");
        exit;

    } else {

        // Displays error message
        validateUI($errorArray);

        // Displays appropriate form UI
        if ($_GET["action"] == "insert"){
            addFormUI("user");
        } elseif ($_GET["action"] == "edit") {
            editFormUI("user", $_POST["attendeeID"]);
        } // Ends inner if
    
    } // Ends outer if

} elseif ($_GET["type"] == "venue") {

    if ($_GET["action"] != "delete") {
        headerUI();
        navigationUI();
        $errorArray = validateVenueInfo();
    }

    // If errorArray holds no items, then the input is valid
    if (count($errorArray) == 0) {
        
        // Updates/Inserts item
        if ($_GET["action"] == "edit") {
            // Update
            $db->updateVenue(
                sanitizeString($_POST["venueID"]),
                sanitizeString($_POST["venueName"]),
                sanitizeString($_POST["venueCapacity"])
            );
        } elseif ($_GET["action"] == "add") {
            // Insert
            $db->insertVenue(
                sanitizeString($_POST["venueName"]),
                sanitizeString($_POST["venueCapacity"])
            );
        } elseif ($_GET["action"] == "delete") {
            // Delete
            $db->deleteVenue(sanitizeString($_GET["id"]));
        } // Ends if

        // Redirects back to admin view
        header("Location: Admin.php");
        exit;

    } else {

        // Displays error message
        validateUI($errorArray);

        // Displays appropriate form UI
        if ($_GET["action"] == "insert"){
            addFormUI("venue");
        } elseif ($_GET["action"] == "edit") {
            editFormUI("venue", $_POST["venueID"]);
        } // Ends inner if
    
    } // Ends outer if

} elseif ($_GET["type"] == "event") {
    
    if ($_GET["action"] != "delete") {
        headerUI();
        navigationUI();
        $errorArray = validateEventInfo();
    }

    // If errorArray holds no items, then the input is valid
    if (count($errorArray) == 0) {
        
        $formattedStartDate = strtotime(sanitizeString($_POST["eventStartDate"]));
        $formattedStartDate = date('y-m-d h:i:s', $formattedStartDate);

        $formattedEndDate = strtotime(sanitizeString($_POST["eventEndDate"]));
        $formattedEndDate = date('y-m-d h:i:s', $formattedEndDate);

        // Updates/Inserts item
        if ($_GET["action"] == "edit") {
            // Update
            $db->updateEvent(
                sanitizeString($_POST["eventID"]),
                sanitizeString($_POST["eventName"]),
                $formattedStartDate,
                $formattedEndDate,
                sanitizeString($_POST["eventNumberAllowed"]),
                sanitizeString($_POST["eventVenue"])
            );
        } elseif ($_GET["action"] == "add") {
            // Insert
            $db->insertEvent(
                sanitizeString($_POST["eventName"]),
                $formattedStartDate,
                $formattedEndDate,
                sanitizeString($_POST["eventNumberAllowed"]),
                sanitizeString($_POST["eventVenue"])
            );
            // Gets ID of inserted event
            $insertedID = $db->getEventByName(sanitizeString($_POST["eventName"]));
            // Makes the user who added the event the manager
            $db->insertManagerEvent($insertedID, $_COOKIE["loggedInID"]);
        } elseif ($_GET["action"] == "delete") {
            // Delete
            $db->deleteEvent(sanitizeString($_GET["id"]));
        } // Ends if

        // Redirects back to admin view
        header("Location: Admin.php");
        exit;

    } else {

        // Displays error message
        validateUI($errorArray);

        // Displays appropriate form UI
        if ($_GET["action"] == "insert"){
            addFormUI("event");
        } elseif ($_GET["action"] == "edit") {
            editFormUI("event", $_POST["eventID"]);
        } // Ends inner if
    
    } // Ends outer if

} elseif ($_GET["type"] == "session") {
    
    if ($_GET["action"] != "delete") {
        headerUI();
        navigationUI();
        $errorArray = validateSessionInfo();
    }

    // If errorArray holds no items, then the input is valid
    if (count($errorArray) == 0) {
        
        $formattedStartDate = strtotime(sanitizeString($_POST["sessionStartDate"]));
        $formattedStartDate = date('y-m-d h:i:s', $formattedStartDate);

        $formattedEndDate = strtotime(sanitizeString($_POST["sessionEndDate"]));
        $formattedEndDate = date('y-m-d h:i:s', $formattedEndDate);

        // Updates/Inserts item
        if ($_GET["action"] == "edit") {
            // Update
            $db->updateSession(
                sanitizeString($_POST["sessionID"]),
                sanitizeString($_POST["sessionName"]),
                sanitizeString($_POST["sessionNumberAllowed"]),
                sanitizeString($_POST["sessionEvent"]),
                $formattedStartDate,
                $formattedEndDate
            );
        } elseif ($_GET["action"] == "add") {
            // Insert
            $db->insertSession(
                sanitizeString($_POST["sessionName"]),
                sanitizeString($_POST["sessionNumberAllowed"]),
                sanitizeString($_POST["sessionEvent"]),
                $formattedStartDate,
                $formattedEndDate
            );
        } elseif ($_GET["action"] == "delete") {
            // Delete
            $db->deleteSession(sanitizeString($_GET["id"]));
        }// Ends if

        // Redirects back to admin view
        header("Location: Admin.php");
        exit;

    } else {

        // Displays error message
        validateUI($errorArray);

        // Displays appropriate form UI
        if ($_GET["action"] == "insert"){
            addFormUI("session");
        } elseif ($_GET["action"] == "edit") {
            editFormUI("session", $_POST["sessionID"]);
        } // Ends inner if
    
    } // Ends outer if

} elseif ($_GET["type"] == "sessionAttendees") {

    if ($_GET["action"] != "delete") {
        headerUI();
        navigationUI();
        $errorArray = validateAttendeeInfo();
    }
    
    // If errorArray holds no items, then the input is valid
    if (count($errorArray) == 0) {
        
        // Inserts/Deletes item
        if ($_GET["action"] == "add") {
            // Insert
            $db->insertAttendeeSession(
                sanitizeString($_POST["sessionID"]),
                sanitizeString($_POST["attendeeID"])
            );
        } elseif ($_GET["action"] == "delete") {
            // Delete
            $db->deleteAttendeeSession(intval(sanitizeString($_GET["session"])), intval(sanitizeString($_GET["id"])));
        }

        // Redirects back to admin view
        header("Location: Admin.php");
        exit;

    } else {

        // Displays error message
        validateUI($errorArray);

        // Displays appropriate form UI
        sessionAttendeesPageUI();
    
    } // Ends outer if

} elseif ($_GET["type"] == "sessionAttendeesRegister") {
    if ($_GET["action"] != "delete") {
        headerUI();
        navigationUI();
        $errorArray = validateAttendeeInfo();
    }
    
    // If errorArray holds no items, then the input is valid
    if (count($errorArray) == 0) {
        
        // Inserts/Deletes item
        if ($_GET["action"] == "add") {
            // Insert
            $db->insertAttendeeSession(
                sanitizeString($_POST["sessionID"]),
                sanitizeString($_POST["attendeeID"])
            );
        } elseif ($_GET["action"] == "delete") {
            // Delete
            $db->deleteAttendeeSession(intval(sanitizeString($_GET["session"])), intval(sanitizeString($_GET["id"])));
        }

        // Redirects back to admin view
        header("Location: Registrations.php");
        exit;

    } else {

        // Displays error message
        validateUI($errorArray);

        // Displays appropriate form UI
        addFormUI("sessionAttendees");
    
    } // Ends outer if
} elseif ($_GET["type"] == "eventAttendees") {
    
    if ($_GET["action"] != "delete") {
        headerUI();
        navigationUI();
        $errorArray = validateAttendeeEventInfo();
    }
    
    // If errorArray holds no items, then the input is valid
    if (count($errorArray) == 0) {
        
        // Inserts/Deletes item
        if ($_GET["action"] == "add") {
            // Insert
            $db->insertAttendeeEvent(
                sanitizeString($_POST["eventID"]),
                sanitizeString($_POST["attendeeID"]),
                sanitizeString($_POST["paid"])
            );
        } elseif ($_GET["action"] == "delete") {
            // Delete
            $db->deleteAttendeeEvent(intval(sanitizeString($_GET["event"])), intval(sanitizeString($_GET["id"])));
        }

        // Redirects back to admin view
        header("Location: Admin.php");
        exit;

    } else {

        // Displays error message
        validateUI($errorArray);

        // Displays appropriate form UI
        eventAttendeesPageUI();
    
    } // Ends outer if

} elseif ($_GET["type"] == "eventAttendeesRegister") {
    
    if ($_GET["action"] != "delete") {
        headerUI();
        navigationUI();
        $errorArray = validateAttendeeEventInfo();
    }
    
    // If errorArray holds no items, then the input is valid
    if (count($errorArray) == 0) {
        
        // Inserts/Deletes item
        if ($_GET["action"] == "add") {
            // Insert
            $db->insertAttendeeEvent(
                sanitizeString($_POST["eventID"]),
                sanitizeString($_POST["attendeeID"]),
                sanitizeString($_POST["paid"])
            );
        } elseif ($_GET["action"] == "delete") {
            // Delete
            $db->deleteAttendeeEvent(intval(sanitizeString($_GET["event"])), intval(sanitizeString($_GET["id"])));
        }

        // Redirects back to admin view
        header("Location: Registrations.php");
        exit;

    } else {

        // Displays error message
        validateUI($errorArray);

        // Displays appropriate form UI
        addFormUI("eventAttendees");
    
    } // Ends outer if

} elseif ($_GET["type"] == "login") {

    $errorArray = validateLoginInfo();

    // If errorArray holds no items, then the input is valid
    if (count($errorArray) == 0) {
        
            echo "<h2>".$_POST["loginFormName"]."</h2>";
            echo "<h2>".$_POST["loginFormPassword"]."</h2>";

        createLoginSession(sanitizeString($_POST["loginFormName"]), sanitizeString($_POST["loginFormPassword"]));
        // Redirects back to admin view
        echo "Session Created";
        header("Location: Events.php");
        exit;

    } else {

        // Displays error message
        validateUI($errorArray);
        // Displays appropriate form UI
        loginFormUI();
    
    } // Ends outer if

} // Ends if

footerUI();

function validateUI($errorArray) {
    
    echo '<main style="margin-top: 56px">';
    // Some UI to show error
    foreach ($errorArray as $error) {

        echo '
            <div class="container pt-2">
                <section class="mb-6">
                    <p class="note note-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>'.$error.'</strong>
                    </p>
                </section>
            </div>
        ';
    
    } // Ends foreach

    echo '</main>';

} // Ends validateUI

function validateUserInfo() {

    $errorArray = array();

    $attendeeName = checkName($_POST["attendeeName"]);
    $attendeePassword = checkPassword($_POST["attendeePassword"]);
    $attendeeRole = checkNumber($_POST["attendeeRole"]);

    //echo $_POST["attendeeName"];
    switch ($attendeeName) {
        case 1:
            $errorArray[] = "ERROR: Invalid Name Input";
            break;
        case 2:
            $errorArray[] = "ERROR: Name Cannot Be Empty";
            break;
        case 3:
            $errorArray[] = "ERROR: Name Cannot Include Special Characters";
            break;
        case 4:
            $errorArray[] = "ERROR: Name Cannot Exceed 30 Characters";
            break;
        default:
            break;
    } // Ends name switch

    //echo $_POST["attendeePassword"];
    switch ($attendeePassword) {
        case 1:
            $errorArray[] = "ERROR: Invalid Password Input";
            break;
        case 2:
            $errorArray[] = "ERROR: Password Cannot Be Empty";
            break;
        case 3:
            $errorArray[] = "ERROR: Password Contains Invalid Characters";
            break;
        case 4:
            $errorArray[] = "ERROR: Password Cannot Exceed 30 Characters";
            break;
        default:
            break;
    } // Ends password switch

    //echo $_POST["attendeeRole"];
    switch ($attendeeRole) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Role Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Role Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Role Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Role Cannot Exceed 6 Digits";
            break;
        case "E5":
            $errorArray[] = "ERROR: Provided Role Does Not Exist";
            break;
        case "E6":
            $errorArray[] = "ERROR: Role Must Be Greater Than Zero";
            break;
        default:
            break;
    } // Ends role switch

    return $errorArray;

} // Ends validateUserInfo

function validateVenueInfo() {

    $errorArray = array();
    
    $venueName = checkName($_POST["venueName"]);
    $venueCapacity = checkNumber($_POST["venueCapacity"]);

    //echo $_POST["venueName"];
    switch ($venueName) {
        case 1:
            $errorArray[] = "ERROR: Invalid Name Input";
            break;
        case 2:
            $errorArray[] = "ERROR: Name Cannot Be Empty";
            break;
        case 3:
            $errorArray[] = "ERROR: Name Cannot Include Special Characters";
            break;
        case 4:
            $errorArray[] = "ERROR: Name Cannot Exceed 30 Characters";
            break;
        default:
            break;
    } // Ends name switch

    //echo $_POST["venueCapacity"];
    switch ($venueCapacity) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Capacity Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Capacity Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Capacity Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Capacity Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Capacity Must Be Greater Than Zero";
            break;
        default:
            break;
    } // Ends capacity switch

    return $errorArray;

} // Ends validateVenueInfo

function validateEventInfo() {

    $db = new DB();
    $errorArray = array();
    
    $eventName = checkName($_POST["eventName"]);
    $eventNumberAllowed = checkNumber($_POST["eventNumberAllowed"]);
    $eventVenue = checkNumber($_POST["eventVenue"]);
    $eventStartDate = checkDateString($_POST["eventStartDate"]);
    $eventEndDate = checkDateString($_POST["eventEndDate"], $_POST["eventStartDate"]);


    //echo $_POST["eventName"];
    switch ($eventName) {
        case 1:
            $errorArray[] = "ERROR: Invalid Name Input";
            break;
        case 2:
            $errorArray[] = "ERROR: Name Cannot Be Empty";
            break;
        case 3:
            $errorArray[] = "ERROR: Name Cannot Include Special Characters";
            break;
        case 4:
            $errorArray[] = "ERROR: Name Cannot Exceed 30 Characters";
            break;
        default:
            break;
    } // Ends name switch

    //echo $_POST["eventNumberAllowed"];
    switch ($eventNumberAllowed) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Max Attendees Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Max Attendees Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Max Attendees Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Max Attendees Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Max Attendees Must Be Greater Than Zero";
            break;
        default:
            break;
    } // Ends number allowed switch

    //echo $_POST["eventVenue"];
    switch ($eventVenue) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Venue Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Venue Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Venue Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Venue Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Venue Must Be Greater Than Zero";
            break;
        default:
            if ($db->getVenueObject(intval($_POST["eventVenue"])) == "ERROR1") {
                $errorArray[] = "ERROR: Venue Provided Does Not Exist";
            }
            break;
    } // Ends number allowed switch

    //echo $_POST["eventStartDate"];
    switch ($eventStartDate) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Start Date Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Start Date Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Start Date Is Not A Valid Date";
            break;
        case "E4":
            $errorArray[] = "ERROR: Start Date Is Not A Valid Date Format";
            break;
        case "E5":
            $errorArray[] = "ERROR: Start Date Cannot Be More Than 10 Characters";
            break;
        default:
            break;
    } // Ends start date switch

    //echo $_POST["eventEndDate"];
    switch ($eventEndDate) {
        case "E1":
            $errorArray[] = "ERROR: Invalid End Date Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: End Date Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: End Date Is Not A Valid Date";
            break;
        case "E4":
            $errorArray[] = "ERROR: End Date Is Not A Valid Date Format";
            break;
        case "E5":
            $errorArray[] = "ERROR: End Date Cannot Be More Than 10 Characters";
            break;
        case "E6":
            $errorArray[] = "ERROR: End Date Cannot Be After The Start Date";
            break;
        default:
            break;
    } // Ends end date switch

    return $errorArray;

} // Ends validateEventInfo

function validateSessionInfo() {

    $db = new DB();
    $errorArray = array();
    
    $sessionName = checkName($_POST["sessionName"]);
    $sessionNumberAllowed = checkNumber($_POST["sessionNumberAllowed"]);
    $sessionEvent = checkNumber($_POST["sessionEvent"]);
    $sessionStartDate = checkDateString($_POST["sessionStartDate"]);
    $sessionEndDate = checkDateString($_POST["sessionEndDate"], $_POST["sessionStartDate"]);

    //echo $_POST["sessionName"];
    switch ($sessionName) {
        case 1:
            $errorArray[] = "ERROR: Invalid Name Input";
            break;
        case 2:
            $errorArray[] = "ERROR: Name Cannot Be Empty";
            break;
        case 3:
            $errorArray[] = "ERROR: Name Cannot Include Special Characters";
            break;
        case 4:
            $errorArray[] = "ERROR: Name Cannot Exceed 30 Characters";
            break;
        default:
            break;
    } // Ends name switch

    //echo $_POST["sessionNumberAllowed"];
    switch ($sessionNumberAllowed) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Max Attendees Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Max Attendees Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Max Attendees Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Max Attendees Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Max Attendees Must Be Greater Than Zero";
            break;
        default:
            break;
    } // Ends number allowed switch

    //echo $_POST["sessionEvent"];
    switch ($sessionEvent) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Event Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Event Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Event Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Event Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Event Must Be Greater Than Zero";
            break;
        default:
            if ($db->getEventObject(intval($_POST["sessionEvent"])) == "ERROR1") {
                $errorArray[] = "ERROR: Event Provided Does Not Exist";
            } // Ends event ID if
            break;
    } // Ends event switch

    //echo $_POST["sessionStartDate"];
    switch ($sessionStartDate) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Start Date Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Start Date Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Start Date Is Not A Valid Date";
            break;
        case "E4":
            $errorArray[] = "ERROR: Start Date Is Not A Valid Date Format";
            break;
        case "E5":
            $errorArray[] = "ERROR: Start Date Cannot Be More Than 10 Characters";
            break;
        default:
            break;
    } // Ends start date switch

    //echo $_POST["sessionEndDate"];
    switch ($sessionEndDate) {
        case "E1":
            $errorArray[] = "ERROR: Invalid End Date Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: End Date Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: End Date Is Not A Valid Date";
            break;
        case "E4":
            $errorArray[] = "ERROR: End Date Is Not A Valid Date Format";
            break;
        case "E5":
            $errorArray[] = "ERROR: End Date Cannot Be More Than 10 Characters";
            break;
        case "E6":
            $errorArray[] = "ERROR: End Date Cannot Be After The Start Date";
            break;
        default:
            break;
    } // Ends end date switch

    return $errorArray;

} // Ends validateSessionInfo

// Function for event/session attendees, not users
function validateAttendeeInfo() {

    $db = new DB();
    $errorArray = array();

    $attendeeID = checkNumber($_POST["attendeeID"]);
    $sessionID = checkNumber($_POST["sessionID"]);

    //echo $_POST["attendeeID"];
    switch ($attendeeID) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Attendee ID Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Attendee ID Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Attendee ID Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Attendee ID Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Attendee ID Must Be Greater Than Zero";
            break;
        default:
        // Check if attendee ID exists
        if ($db->getAttendeeObject(intval($_POST["attendeeID"])) == "ERROR1") {
            $errorArray[] = "ERROR: Attendee ID Provided Does Not Exist";
        } elseif ($db->getAttendeeSession(intval($_POST["sessionID"]), intval($_POST["attendeeID"])) == "RECORD EXISTS") {
            $errorArray[] = "ERROR: Attendee ID Provided Is Already An Attendee";
        } // Ends attendee ID if
            break;
    } // Ends attendee ID switch

    //echo $_POST["sessionID"];
    switch ($sessionID) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Attendee ID Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Session ID Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Session ID Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Session ID Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Session ID Must Be Greater Than Zero";
            break;
        default:
        // Check if attendee ID exists
        if ($db->getSessionObject(intval($_POST["sessionID"])) == "ERROR1") {
            $errorArray[] = "ERROR: Session ID Provided Doesn't Exist";
        } // Ends attendee ID if
            break;
    } // Ends attendee ID switch

    return $errorArray;

} // Ends validateUserInfo

function validateAttendeeEventInfo() {

    $db = new DB();
    $errorArray = array();

    $attendeeID = checkNumber($_POST["attendeeID"]);
    $eventID = checkNumber($_POST["eventID"]);
    $paid = checkNumber($_POST["paid"]);

    //echo $_POST["attendeeID"];
    switch ($attendeeID) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Attendee ID Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Attendee ID Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Attendee ID Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Attendee ID Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Attendee ID Must Be Greater Than Zero";
            break;
        default:
        // Check if attendee ID exists
        if ($db->getAttendeeObject(intval($_POST["attendeeID"])) == "ERROR1") {
            $errorArray[] = "ERROR: Attendee ID Provided Does Not Exist";
        } elseif ($db->getAttendeeEvent(intval($_POST["eventID"]), intval($_POST["attendeeID"])) == "RECORD EXISTS") {
            $errorArray[] = "ERROR: Attendee ID Provided Is Already An Attendee";
        } // Ends attendee ID if
            break;
    } // Ends attendee ID switch

    //echo $_POST["eventID"];
    switch ($eventID) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Event Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Event Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Event Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Event Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Event Must Be Greater Than Zero";
            break;
        default:
            if ($db->getEventObject(intval($_POST["eventID"])) == "ERROR1") {
                $errorArray[] = "ERROR: Event Provided Does Not Exist";
            } // Ends event ID if
            break;
    } // Ends event switch

    //echo $_POST["paid"];
    switch ($paid) {
        case "E1":
            $errorArray[] = "ERROR: Invalid Paid Input";
            break;
        case "E2":
            $errorArray[] = "ERROR: Paid Cannot Be Empty";
            break;
        case "E3":
            $errorArray[] = "ERROR: Paid Must Be Numeric";
            break;
        case "E4":
            $errorArray[] = "ERROR: Paid Cannot Exceed 6 Digits";
            break;
        case "E6":
            $errorArray[] = "ERROR: Paid Must Be Greater Than Zero";
            break;
        default:
            break;
    } // Ends paid switch

    return $errorArray;

} // Ends validateUserInfo

function validateLoginInfo() {

    $db = new DB();
    $errorArray = array();
    
    $loginFormName = checkName($_POST["loginFormName"]);
    $loginFormPassword = checkPassword($_POST["loginFormPassword"]);

    //echo $_POST["loginFormName"];
    switch ($loginFormName) {
        case 1:
            $errorArray[] = "ERROR: Invalid Name Input";
            break;
        case 2:
            $errorArray[] = "ERROR: Name Cannot Be Empty";
            break;
        case 3:
            $errorArray[] = "ERROR: Name Cannot Include Special Characters";
            break;
        case 4:
            $errorArray[] = "ERROR: Name Cannot Exceed 30 Characters";
            break;
        default:
            break;
    } // Ends name switch

    //echo $_POST["loginFormPassword"];
    switch ($loginFormPassword) {
        case 1:
            $errorArray[] = "ERROR: Invalid Password Input";
            break;
        case 2:
            $errorArray[] = "ERROR: Password Cannot Be Empty";
            break;
        case 3:
            $errorArray[] = "ERROR: Password Contains Invalid Characters";
            break;
        case 4:
            $errorArray[] = "ERROR: Password Cannot Exceed 30 Characters";
            break;
        default:
            break;
    } // Ends password switch

    // Check to see if the provided credentials match an existing user
    if ($db->getAttendeeObjectByLogin($loginFormName, $loginFormPassword) == "ERROR1") {
        $errorArray[] = "ERROR: Invalid Login Credentials";
    } // Ends if

    return $errorArray;

} // Ends validateLoginInfo

function checkName($stringInput) {

    $sanitized = sanitizeString($stringInput);

    if ($stringInput != $sanitized) {
        $stringInput = 1;
    } elseif (!validateNotEmpty($sanitized)) {
        $stringInput = 2;
    } elseif (!validateIsAlphabetical($sanitized)) {
        $stringInput = 3;
    } elseif (!validateLength($sanitized, 30)) {
        $stringInput = 4;
    } else {
        $stringInput = sanitizeString($stringInput);
    }

    return $stringInput;

} // Ends checkName

function checkPassword($stringInput) {

    $sanitized = sanitizeString($stringInput);

    if ($stringInput != $sanitized) {
        $stringInput = 1;
    } elseif (!validateNotEmpty($sanitized)) {
        $stringInput = 2;
    } elseif (!validateIsAlphaNumericPunct($sanitized)) {
        $stringInput = 3;
    } elseif (!validateLength($sanitized, 30)) {
        $stringInput = 4;
    } else {
        $stringInput = sanitizeString($stringInput);
    }

    return $stringInput;

} // Ends checkPassword

function checkNumber($numberInput) {

    if ($numberInput != sanitizeString($numberInput)) {
        $errorCode = "E1";
    } elseif (!validateNotEmpty(sanitizeString($numberInput))) {
        $errorCode = "E2";
    } elseif (!validateIsNumeric(sanitizeString($numberInput))) {
        $errorCode = "E3";
    } elseif (!validateLength(sanitizeString($numberInput), 6)) {
        $errorCode = "E4";
    } elseif ( ($_GET["type"] == "user") && (sanitizeString($numberInput) > 3) ) {
        // This case is specific to the user role, as the role cannot be greater than 3
        $errorCode = "E5";
    } elseif (sanitizeString($numberInput) < 1) {
        $errorCode = "E6";
    } else {
        $errorCode = sanitizeString($numberInput);
    }

    return $errorCode;

} // Ends checkNumber

function checkDateString($dateInput, $dateAfter = "1/1/1900") {

    $sanitized = sanitizeString($dateInput);

    if ($dateInput != $sanitized) {
        $dateInput = "E1";
    } elseif (!validateNotEmpty($sanitized)) {
        $dateInput = "E2";
    } elseif (!validateIsDate($sanitized)) {
        $dateInput = "E3";
    } elseif (!validateIsDateFormat($sanitized)) {
        $dateInput = "E4";
    } elseif (!validateLength($sanitized, 10)) {
        $dateInput = "E5";
    } elseif (strtotime($sanitized) < strtotime($dateAfter)) {
        $dateInput = "E6";
    } else {
        $dateInput = sanitizeString($dateInput);
    }

    return $dateInput;

} // Ends checkDateString

function sanitizeString($input) {
    
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlentities($input);
    $input = strip_tags($input);
    return $input;

} // Ends santizeString

function validateNotEmpty($input) {

    if (empty($input)) {
        return false;
    } else {
        return true;
    }

} // Ends validateNotEmpty

function validateIsAlphabetical($input) {

    $reg = "/^[A-Za-z ]+$/";
	return preg_match($reg, $input);

} // Ends validateIsAlphabetical

function validateIsAlphaNumericPunct($input) {

	$reg = "/^[A-Za-z0-9 _.,!?\"']+$/";
	return(preg_match($reg, $input));

} // Ends validateIsAlphaNumericPunct

function validateIsNumeric($input) {

    $reg = "/(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/";
	return preg_match($reg, $input);

} // Ends validateIsNumeric

function validateLength($input, $maxLength) {

    if(strlen($input) > $maxLength) {
        return false;
    } else {
        return true;
    }

} // Ends validateLength

function validateIsDate($input) {

	$reg = "/^(((0?[1-9]|1[012])\/(0?[1-9]|1\d|2[0-8])|(0?[13456789]|1[012])\/(29|30)|(0?[13578]|1[02])\/31)\/(19|[2-9]\d)\d{2}|0?2\/29\/((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$/";
	return preg_match($reg, $input);

} // Ends validateIsDate

function validateIsDateFormat($input) {

	$reg = "/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/";
	return preg_match($reg, $input);

} // Ends validateIsDateFormat

function createLoginSession($attendeeName, $attendeePassword) {

    $db = new DB();
    date_default_timezone_set('EST');

    session_name('loginSession');
    session_start();

    $expire = time() + (60*60);
    $path = "/~sxd7342";
    $domain = "solace.ist.rit.edu";
    $secure = false;
    $attendeeArray = $db->getAttendeeObjectByLogin($attendeeName, $attendeePassword);
    $attendeeID = $attendeeArray[0];
    $attendeeRole = $attendeeArray[1];

    $_SESSION['loggedIn'] = true;
    setcookie("loggedInName", $attendeeName, $expire, $path, $domain, $secure);
    setcookie("loggedInPassword", $attendeePassword, $expire, $path, $domain, $secure);
    setcookie("loggedInID", $attendeeID, $expire, $path, $domain, $secure);
    setcookie("loggedInRole", $attendeeRole, $expire, $path, $domain, $secure);

} // Ends createLoginSession
?>