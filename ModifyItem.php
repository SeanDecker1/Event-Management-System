<?php

require_once "PDO.DB.class.php";
//include_once "Validate.php";
include_once("UIFunctions.php");

$db = new DB();

headerUI();

navigationUI();

if ($_GET["type"] == "user") {

        // Show the correct form
        if ($_GET["action"] == "edit") {
            // Edit Form
            editFormUI("user", $_GET["id"]);
        } elseif ($_GET["action"] == "add") {
            // Add Form
            addFormUI("user");
        } elseif ($_GET["action"] == "delete") {
            $db->deleteAttendee($_GET["id"]);
            header("Location: Admin.php");
        }

} elseif ($_GET["type"] == "venue") {

    // Show the correct form
    if ($_GET["action"] == "edit") {
        // Edit Form
        editFormUI("venue", $_GET["id"]);
    } elseif ($_GET["action"] == "add") {
        // Add Form
        addFormUI("venue");
    } elseif ($_GET["action"] == "delete") {
        $db->deleteVenue(sanitizeString($_GET["id"]));
        header("Location: Admin.php");
    }

} elseif ($_GET["type"] == "event") {

    // Show the correct form
    if ($_GET["action"] == "edit") {
        // Edit Form
        editFormUI("event", $_GET["id"]);
    } elseif ($_GET["action"] == "add") {
        // Add Form
        addFormUI("event");
    } elseif ($_GET["action"] == "delete") {
        $db->deleteEvent(sanitizeString($_GET["id"]));
        header("Location: Admin.php");
    }

} elseif ($_GET["type"] == "session") {
    
    // Show the correct form
    if ($_GET["action"] == "edit") {
        // Edit Form
        editFormUI("session", $_GET["id"]);
    } elseif ($_GET["action"] == "add") {
        // Add Form
        addFormUI("session");
    } elseif ($_GET["action"] == "delete") {
        $db->deleteSession(sanitizeString($_GET["id"]));
        header("Location: Admin.php");
    }

} elseif ($_GET["type"] == "eventAttendees") {
    
    eventAttendeesPageUI();

} elseif ($_GET["type"] == "sessionAttendees") {
    
    sessionAttendeesPageUI();

} elseif ($_GET["type"] == "eventAttendeesRegister") {
    
    addFormUI("eventAttendees");

} elseif ($_GET["type"] == "sessionAttendeesRegister") {
    
    addFormUI("sessionAttendees");

}// Ends if// Ends if
//adminPageUI();

footerUI();

?>