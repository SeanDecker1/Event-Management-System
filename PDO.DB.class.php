<?php 

class DB {

    // require_once "EventManagement.class.php";

    private $dbh;

    /********************************GENERAL FUNCTIONS*************************************/
    function __construct() {
        
        try {

            $this->dbh = new PDO("mysql:host={$_SERVER['DB_HOST']};dbname={$_SERVER['DB']}",
                    $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD']);

            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $pe) {
            
            echo $pe->getMessage();
            die("Bad Database");
        
        } // Ends try catch

    } // Ends __construct

    function getAllObjects($stmtInput, $classInput) {

        $data = array();

        try {

            require_once "EventManagement.class.php";

            $stmt = $this->dbh->prepare($stmtInput);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,$classInput);

            while ($row=$stmt->fetch()) {
                $data[] = $row;
            } // Ends while

            return $data;

        } catch(PDOException $pe) {
            echo $pe->getMessage();
            return array();
        } // Ends try catch

    } // Ends getAllObjects

    /********************************EVENT FUNCTIONS*************************************/
    public function getAllEventObjectsAsTable() {

        $data = $this->getAllObjects("SELECT * FROM event", "Events");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Max Attendees</th>
                            <th>Venue</th>
                            <th />
                            <th />
                            <th />
            </tr>\n";
    
            foreach ($data as $event) {

                $eventVenueID = $event->getEventVenue();
                $venueObject = $this->getAllObjects("SELECT * FROM venue WHERE idvenue = $eventVenueID", "Venues");
             
                foreach ($venueObject as $venue) {

                    $eventVenueName = $venue->getVenueName();
                    $event->setEventVenue($eventVenueName);

                } // Ends venue foreach

                $outputTable .= $event->getTableData(true);

            } // Ends event foreach
    
        } else {
            $outputTable = "<h2>No events exist.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllEventObjectsAsTable

    public function getAllEventObjectsAsTableView() {

        $data = $this->getAllObjects("SELECT * FROM event", "Events");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Max Attendees</th>
                            <th>Venue</th>
            </tr>\n";
    
            foreach ($data as $event) {

                $eventVenueID = $event->getEventVenue();
                $venueObject = $this->getAllObjects("SELECT * FROM venue WHERE idvenue = $eventVenueID", "Venues");
             
                foreach ($venueObject as $venue) {

                    $eventVenueName = $venue->getVenueName();
                    $event->setEventVenue($eventVenueName);

                } // Ends venue foreach

                $outputTable .= $event->getTableData(false);

            } // Ends event foreach
    
        } else {
            $outputTable = "<h2>No events exist.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllEventObjectsAsTableView

    public function getAllEventObjectsAsTableByID($eventID) {

        $data = $this->getAllObjects("SELECT * FROM event WHERE idevent = '$eventID'", "Events");

        if (count($data) > 0) {
            
            $outputTable = "";

            foreach ($data as $event) {

                $eventVenueID = $event->getEventVenue();
                $venueObject = $this->getAllObjects("SELECT * FROM venue WHERE idvenue = $eventVenueID", "Venues");
             
                foreach ($venueObject as $venue) {

                    $eventVenueName = $venue->getVenueName();
                    $event->setEventVenue($eventVenueName);

                } // Ends venue foreach

                $outputTable .= $event->getTableData(true);

            } // Ends event foreach
    
        } else {
            $outputTable = "<h2>No events exist.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllEventObjectsAsTable

    public function getEventObject($idevent) {

        $data = $this->getAllObjects("SELECT * FROM event WHERE idevent = $idevent", "Events");

        if (count($data) > 0) {
            $outputEvent = $data[0];
        } else {
            $outputEvent = "ERROR1";
        }// Ends if

        return $outputEvent;

    } // Ends getEventObject

    public function getEventName($idevent) {

        $data = $this->getAllObjects("SELECT name FROM event WHERE idevent = $idevent", "Events");

        if (count($data) > 0) {

            $outputAttendee = $data[0]->getEventName();
    
        } else {
            $outputAttendee = "<h2>No event exists with this ID.</h2>";
        }// Ends if

        return $outputAttendee;

    } // Ends getEventName

    public function getEventByName($eventName) {

        $data = $this->getAllObjects("SELECT * FROM event WHERE name = '$eventName'", "Events");

        if (count($data) > 0) {
            $outputEvent = $data[0]->getEventID();
        } else {
            $outputEvent = "ERROR1";
        }// Ends if

        return $outputEvent;

    } // Ends getEventByName

    public function insertEvent($name, $datestart, $dateend, $numberallowed, $venue) {

        require_once("EventManagement.class.php");

        $Event = new Events;
        $Event->setEventName($name);
        $Event->setEventStart($datestart);
        $Event->setEventEnd($dateend);
        $Event->setEventAllowed($numberallowed);
        $Event->setEventVenue($venue);

        try {

            $stmt = $this->dbh->prepare("
                INSERT INTO event (name, datestart, dateend, numberallowed, venue)
                VALUES (:name, :datestart, :dateend, :numberallowed, :venue)
            ");

            $stmt->execute(array(
                "name"=>$Event->getEventName(),
                "datestart"=>$Event->getEventStart(),
                "dateend"=>$Event->getEventEnd(),
                "numberallowed"=>$Event->getEventAllowed(),
                "venue"=>$Event->getEventVenue()
            ));

        } catch (PDOException $pe) {
            echo $pe->getMessage();
            return -1;
        } // Ends try catch

    } // Ends insertEvent function

    public function updateEvent($idevent, $name, $datestart, $dateend, $numberallowed, $venue) {

        require_once("EventManagement.class.php");

        $Event = new Events;
        $Event->setEventID($idevent);
        $Event->setEventName($name);
        $Event->setEventStart($datestart);
        $Event->setEventEnd($dateend);
        $Event->setEventAllowed($numberallowed);
        $Event->setEventVenue($venue);

        try {

            $stmt = $this->dbh->prepare("
                UPDATE event
                SET name = :name, datestart = :datestart, dateend = :dateend,
                numberallowed = :numberallowed, venue = :venue
                WHERE idevent = :idevent
            ");

            $stmt->execute(array(
                "name"=>$Event->getEventName(),
                "datestart"=>$Event->getEventStart(),
                "dateend"=>$Event->getEventEnd(),
                "numberallowed"=>$Event->getEventAllowed(),
                "venue"=>$Event->getEventVenue(),
                "idevent"=>$Event->getEventID()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends updateEvent function

    public function deleteEvent($idevent) {

        require_once("EventManagement.class.php");

        $Event = new Events;
        $Event->setEventID($idevent);

        try {

            $stmt = $this->dbh->prepare("
                DELETE FROM event
                WHERE idevent = :idevent
            ");

            $stmt->execute(array(
                "idevent"=>$Event->getEventID()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends deleteEvent function
    
    /********************************VENUE FUNCTIONS*************************************/
    public function getAllVenueObjectsAsTable() {

        $data = $this->getAllObjects("SELECT * FROM venue", "Venues");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th> Venue ID</th>
                            <th>Venue Name</th>
                            <th>Venue Capacity</th>
                            <th />
                            <th />
            </tr>\n";
    
            foreach ($data as $venue) {
                $outputTable .= $venue->getTableData();
            } // End foreach
    
        } else {
            $outputTable = "<h2>No venues exist.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllVenueObjectsAsTable

    public function getVenueObject($idvenue) {

        $data = $this->getAllObjects("SELECT * FROM venue WHERE idvenue = $idvenue", "Venues");

        if (count($data) > 0) {
            $outputVenue = $data[0];
        } else {
            $outputVenue = "ERROR1";
        }// Ends if

        return $outputVenue;

    } // Ends getVenueObject

    public function insertVenue($name, $capacity) {

        require_once("EventManagement.class.php");

        $Venue = new Venues;
        $Venue->setVenueName($name);
        $Venue->setVenueCapacity($capacity);

        try {

            $stmt = $this->dbh->prepare("
                INSERT INTO venue (name, capacity)
                VALUES (:name, :capacity)
            ");

            $stmt->execute(array(
                "name"=>$Venue->getVenueName(),
                "capacity"=>$Venue->getVenueCapacity()
            ));

        } catch (PDOException $pe) {
            echo $pe->getMessage();
            return -1;
        } // Ends try catch

    } // Ends insertVenue function

    public function updateVenue($idvenue, $name, $capacity) {

        require_once("EventManagement.class.php");

        $Venue = new Venues;
        $Venue->setVenueID($idvenue);
        $Venue->setVenueName($name);
        $Venue->setVenueCapacity($capacity);

        try {

            $stmt = $this->dbh->prepare("
                UPDATE venue
                SET name = :name, capacity = :capacity
                WHERE idvenue = :idvenue
            ");

            $stmt->execute(array(
                "name"=>$Venue->getVenueName(),
                "capacity"=>$Venue->getVenueCapacity(),
                "idvenue"=>$Venue->getVenueID()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends updateVenue function

    public function deleteVenue($idvenue) {

        require_once("EventManagement.class.php");

        $Venue = new Venues;
        $Venue->setVenueID($idvenue);

        try {

            $stmt = $this->dbh->prepare("
                DELETE FROM venue
                WHERE idvenue = :idvenue
            ");

            $stmt->execute(array(
                "idvenue"=>$Venue->getVenueID()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends deleteVenue function

    /********************************SESSION FUNCTIONS*************************************/
    public function getAllSessionObjectsAsTable() {

        $data = $this->getAllObjects("SELECT * FROM session", "Sessions");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Session ID</th>
                            <th>Session Name</th>
                            <th>Max Attendees</th>
                            <th>Event</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th />
                            <th />
                            <th />
            </tr>\n";
    
            foreach($data as $session) {
                $outputTable .= $session->getTableData();
            } // End foreach
    
        } else {
            $outputTable = "<h2>No events exist.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllSessionObjectsAsTable

    public function getAllSessionObjectsAsTableByEvent($sessionEvent) {

        $data = $this->getAllObjects("SELECT * FROM session WHERE event = '$sessionEvent'", "Sessions");

        if (count($data) > 0) {

            $outputTable = "";
    
            foreach($data as $session) {
                $outputTable .= $session->getTableData();
            } // End foreach
    
        } else {
            $outputTable = "<h2>No sessions exist.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllSessionObjectsAsTableByEvent

    public function getSessionName($idsession) {

        $data = $this->getAllObjects("SELECT name FROM session WHERE idsession = $idsession", "Sessions");

        if (count($data) > 0) {

            $outputAttendee = $data[0]->getSessionName();
    
        } else {
            $outputAttendee = "<h2>No sessions exists with this ID.</h2>";
        }// Ends if

        return $outputAttendee;

    } // Ends getEventName

    public function getSessionObject($idsession) {

        $data = $this->getAllObjects("SELECT * FROM session WHERE idsession = $idsession", "Sessions");

        if (count($data) > 0) {

            $outputSession = $data[0];
    
        } else {
            $outputSession = "ERROR1";
        }// Ends if

        return $outputSession;

    } // Ends getSessionObject

    public function insertSession($name, $numberallowed, $event, $startdate, $enddate) {

        require_once("EventManagement.class.php");

        $Session = new Sessions;
        $Session->setSessionName($name);
        $Session->setSessionNumberAllowed($numberallowed);
        $Session->setSessionEvent($event);
        $Session->setSessionStartDate($startdate);
        $Session->setSessionEndDate($enddate);

        try {

            $stmt = $this->dbh->prepare("
                INSERT INTO session (name, numberallowed, event, startdate, enddate)
                VALUES (:name, :numberallowed, :event, :startdate, :enddate)
            ");

            $stmt->execute(array(
                "name"=>$Session->getSessionName(),
                "numberallowed"=>$Session->getSessionNumberAllowed(),
                "event"=>$Session->getSessionEvent(),
                "startdate"=>$Session->getSessionStartDate(),
                "enddate"=>$Session->getSessionEndDate()
            ));

        } catch (PDOException $pe) {
            echo $pe->getMessage();
            return -1;
        } // Ends try catch

    } // Ends insertSession function

    public function updateSession($idsession, $name, $numberallowed, $event, $startdate, $enddate) {

        require_once("EventManagement.class.php");

        $Session = new Sessions;
        $Session->setSessionID($idsession);
        $Session->setSessionName($name);
        $Session->setSessionNumberAllowed($numberallowed);
        $Session->setSessionEvent($event);
        $Session->setSessionStartDate($startdate);
        $Session->setSessionEndDate($enddate);

        try {

            $stmt = $this->dbh->prepare("
                UPDATE session
                SET name = :name, numberallowed = :numberallowed, event = :event,
                startdate = :startdate, enddate = :enddate
                WHERE idsession = :idsession
            ");

            $stmt->execute(array(
                "name"=>$Session->getSessionName(),
                "numberallowed"=>$Session->getSessionNumberAllowed(),
                "event"=>$Session->getSessionEvent(),
                "startdate"=>$Session->getSessionStartDate(),
                "enddate"=>$Session->getSessionEndDate(),
                "idsession"=>$Session->getSessionID()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends updateSession function

    public function deleteSession($idsession) {

        require_once("EventManagement.class.php");

        $Session = new Sessions;
        $Session->setSessionID($idsession);

        try {

            $stmt = $this->dbh->prepare("
                DELETE FROM session
                WHERE idsession = :idsession
            ");

            $stmt->execute(array(
                "idsession"=>$Session->getSessionID()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends deleteSession function


    /********************************ATTENDEE FUNCTIONS*************************************/
    public function getAllAttendeeObjectsAsTable() {

        $data = $this->getAllObjects("SELECT * FROM attendee", "Attendees");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Attendee ID</th>
                            <th>Attendee Name</th>
                            <th>Attendee Password</th>
                            <th>Attendee Role</th>
                            <th />
                            <th />
            </tr>\n";
    
            foreach($data as $attendee) {
                $outputTable .= $attendee->getTableData();
            } // End foreach
    
        } else {
            $outputTable = "<h2>No attendees exist.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllAttendeeObjectsAsTable

    public function getAttendeeObject($idattendee) {

        $data = $this->getAllObjects("SELECT * FROM attendee WHERE idattendee = $idattendee", "Attendees");

        if (count($data) > 0) {

            $outputAttendee = $data[0];
    
        } else {
            $outputAttendee = "ERROR1";
        }// Ends if

        return $outputAttendee;

    } // Ends getAttendeeObject

    public function getAttendeeName($idattendee) {

        $data = $this->getAllObjects("SELECT name FROM attendee WHERE idattendee = $idattendee", "Attendees");

        if (count($data) > 0) {

            $outputAttendee = $data[0]->getName();
    
        } else {
            $outputAttendee = "<h2>No attendee exists with this ID.</h2>";
        }// Ends if

        return $outputAttendee;

    } // Ends getAttendeeName
    
    public function getAttendeeObjectByName($attendeeName) {

        $data = $this->getAllObjects("SELECT * FROM attendee WHERE name = '$attendeeName'", "Attendees");

        if (count($data) > 0) {

            $outputAttendee = $data[0]->getPassword();
    
        } else {
            $outputAttendee = "ERROR1";
        }// Ends if

        return $outputAttendee;

    } // Ends getAttendeeObjectByName

    public function getAttendeeObjectByLogin($attendeeName, $attendeePassword) {

        $data = $this->getAllObjects("SELECT * FROM attendee WHERE name = '$attendeeName' AND password = '$attendeePassword'", "Attendees");

        if (count($data) > 0) {

            $outputAttendee[] = $data[0]->getID();
            $outputAttendee[] = $data[0]->getRole();
    
        } else {
            $outputAttendee = "ERROR1";
        }// Ends if

        return $outputAttendee;

    } // Ends getAttendeeObjectByName

    public function insertAttendee($name, $password, $role) {

        require_once("EventManagement.class.php");

        $Attendee = new Attendees;
        $Attendee->setName($name);
        $Attendee->setPassword($password);
        $Attendee->setRole($role);

        try {

            $stmt = $this->dbh->prepare("
                INSERT INTO attendee (name, password, role)
                VALUES (:name, :password, :role)
            ");

            $stmt->execute(array(
                "name"=>$Attendee->getName(),
                "password"=>$Attendee->getPassword(),
                "role"=>$Attendee->getRole()
            ));

        } catch (PDOException $pe) {
            echo $pe->getMessage();
            return -1;
        } // Ends try catch

    } // Ends insertAttendee function

    public function updateAttendee($idattendee, $name, $password, $role) {

        require_once("EventManagement.class.php");

        $Attendee = new Attendees;
        $Attendee->setID($idattendee);
        $Attendee->setName($name);
        $Attendee->setPassword($password);
        $Attendee->setRole($role);

        try {

            $stmt = $this->dbh->prepare("
                UPDATE attendee
                SET name = :name, password = :password, role = :role
                WHERE idattendee = :idattendee
            ");

            $stmt->execute(array(
                "name"=>$Attendee->getName(),
                "password"=>$Attendee->getPassword(),
                "role"=>$Attendee->getRole(),
                "idattendee"=>$Attendee->getID()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends updateAttendee function

    public function deleteAttendee($idattendee) {

        require_once("EventManagement.class.php");

        $Attendee = new Attendees;
        $Attendee->setID($idattendee);

        try {

            $stmt = $this->dbh->prepare("
                DELETE FROM attendee
                WHERE idattendee = :idattendee
            ");

            $stmt->execute(array(
                "idattendee"=>$Attendee->getID()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends deleteAttendee function

    /********************************ATTENDEE EVENT FUNCTIONS*************************************/
    public function getAllAttendeeEventObjectsAsTable() {

        $data = $this->getAllObjects("SELECT * FROM attendee_event", "AttendeeEvent");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Event ID</th>
                            <th>Attendee ID</th>
                            <th>Paid</th>
            </tr>\n";
    
            foreach($data as $attendeeevent) {
                $outputTable .= $attendeeevent->getTableData();
            } // End foreach
    
        } else {
            $outputTable = "<h2>No events have attendees yet.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllAttendeeEventObjectsAsTable

    public function getAllAttendeeEventObjectsByEventID($eventID) {

        $data = $this->getAllObjects("SELECT * FROM attendee_event WHERE event = $eventID", "AttendeeEvent");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Attendee ID</th>
                            <th>Attendee Name</th>
                            <th>Paid</th>
                            <th />
            </tr>\n";
    
            foreach ($data as $attendeeevent) {
                $outputTable .= $attendeeevent->getTableData($this->getAttendeeName($attendeeevent->getAttendee()));
            } // End foreach
    
        } else {
            $outputTable = "<h2>No attendees in this event yet</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllAttendeeEventObjectsByEventID

    public function getAllAttendeeEventObjectsByAttendeeID($attendeeID) {

        $data = $this->getAllObjects("SELECT * FROM attendee_event WHERE attendee = $attendeeID", "AttendeeEvent");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Paid</th>
                            <th />
                            <th />
            </tr>\n";
    
            foreach ($data as $attendeeevent) {
                $outputTable .= $attendeeevent->getTableDataEvents($this->getEventName($attendeeevent->getEvent()));
            } // End foreach
    
        } else {
            $outputTable = "<h2>You are not an attendee on any events</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllAttendeeEventObjectsByEventID

    public function getAttendeeEvent($eventID, $attendeeID) {

        $data = $this->getAllObjects("SELECT * FROM attendee_event WHERE event = $eventID AND attendee = $attendeeID", "AttendeeEvent");

        if (count($data) > 0) {
            $outputTable = "RECORD EXISTS";
        } else {
            $outputTable = "ERROR1";
        }// Ends if

        return $outputTable;

    } // Ends getAttendeeEvent

    public function insertAttendeeEvent($event, $attendee, $paid) {

        require_once("EventManagement.class.php");

        $AttendeeEvent = new AttendeeEvent;
        $AttendeeEvent->setEvent($event);
        $AttendeeEvent->setAttendee($attendee);
        $AttendeeEvent->setPaid($paid);

        try {

            $stmt = $this->dbh->prepare("
                INSERT INTO attendee_event (event, attendee, paid)
                VALUES (:event, :attendee, :paid)
            ");

            $stmt->execute(array(
                "event"=>$AttendeeEvent->getEvent(),
                "attendee"=>$AttendeeEvent->getAttendee(),
                "paid"=>$AttendeeEvent->getPaid()
            ));

        } catch (PDOException $pe) {
            echo $pe->getMessage();
            return -1;
        } // Ends try catch

    } // Ends insertAttendeeEvent function

    public function updateAttendeeEvent($event, $attendee, $paid) {

        require_once("EventManagement.class.php");

        $AttendeeEvent = new AttendeeEvent;
        $AttendeeEvent->setEvent($event);
        $AttendeeEvent->setAttendee($attendee);
        $AttendeeEvent->setPaid($paid);

        try {

            $stmt = $this->dbh->prepare("
                UPDATE attendee_event
                SET event = :event, attendee = :attendee, paid = :paid
                WHERE event = :event AND attendee = :attendee AND paid = :paid
            ");

            $stmt->execute(array(
                "event"=>$AttendeeEvent->getEvent(),
                "attendee"=>$AttendeeEvent->getAttendee(),
                "paid"=>$AttendeeEvent->getPaid()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends updateAttendeeEvent function

    public function deleteAttendeeEvent($event, $attendee) {

        require_once("EventManagement.class.php");

        $AttendeeEvent = new AttendeeEvent;
        $AttendeeEvent->setEvent($event);
        $AttendeeEvent->setAttendee($attendee);

        try {

            $stmt = $this->dbh->prepare("
                DELETE FROM attendee_event
                WHERE event = :event AND attendee = :attendee
            ");

            $stmt->execute(array(
                "event"=>$AttendeeEvent->getEvent(),
                "attendee"=>$AttendeeEvent->getAttendee()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends deleteAttendeeEvent function

    /********************************ATTENDEE SESSION FUNCTIONS*************************************/
    public function getAllAttendeeSessionObjectsAsTable() {

        $data = $this->getAllObjects("SELECT * FROM attendee_session", "AttendeeSession");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Session ID</th>
                            <th>Attendee ID</th>
            </tr>\n";
    
            foreach ($data as $attendeesession) {
                $outputTable .= $attendeesession->getTableData();
            } // End foreach
    
        } else {
            $outputTable = "<h2>No attendees in this session yet</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllAttendeeSessionObjectsAsTable

    public function getAllAttendeeSessionObjectsBySessionID($sessionID) {

        $data = $this->getAllObjects("SELECT * FROM attendee_session WHERE session = $sessionID", "AttendeeSession");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Attendee ID</th>
                            <th>Attendee Name</th>
                            <th />
            </tr>\n";
    
            foreach ($data as $attendeesession) {
                $outputTable .= $attendeesession->getTableData($this->getAttendeeName($attendeesession->getAttendee()));
            } // End foreach
    
        } else {
            $outputTable = "<h2>No attendees in this session yet</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllAttendeeSessionObjectsAsTable

    public function getAllAttendeeSessionObjectsByAttendeeID($attendeeID) {

        $data = $this->getAllObjects("SELECT * FROM attendee_session WHERE attendee = $attendeeID", "AttendeeSession");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Session ID</th>
                            <th>Session Name</th>
                            <th />
                            <th />
            </tr>\n";
    
            foreach ($data as $attendeesession) {
                $outputTable .= $attendeesession->getTableDataSessions($this->getSessionName($attendeesession->getSession()));
            } // End foreach
    
        } else {
            $outputTable = "<h2>You are not an attendee on any sessions</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllAttendeeSessionObjectsAsTable

    public function getAttendeeSession($sessionID, $attendeeID) {

        $data = $this->getAllObjects("SELECT * FROM attendee_session WHERE session = $sessionID AND attendee = $attendeeID", "AttendeeSession");

        if (count($data) > 0) {
            $outputTable = "RECORD EXISTS";
        } else {
            $outputTable = "ERROR1";
        }// Ends if

        return $outputTable;

    } // Ends getAttendeeSession

    public function insertAttendeeSession($session, $attendee) {

        require_once("EventManagement.class.php");

        $AttendeeSession = new AttendeeSession;
        $AttendeeSession->setSession($session);
        $AttendeeSession->setAttendee($attendee);

        try {

            $stmt = $this->dbh->prepare("
                INSERT INTO attendee_session (session, attendee)
                VALUES (:session, :attendee)
            ");

            $stmt->execute(array(
                "session"=>$AttendeeSession->getSession(),
                "attendee"=>$AttendeeSession->getAttendee()
            ));

        } catch (PDOException $pe) {
            echo $pe->getMessage();
            return -1;
        } // Ends try catch

    } // Ends insertAttendeeSession function

    public function updateAttendeeSession($session, $attendee) {

        require_once("EventManagement.class.php");

        $AttendeeSession = new AttendeeSession;
        $AttendeeSession->setSession($session);
        $AttendeeSession->setAttendee($attendee);

        try {

            $stmt = $this->dbh->prepare("
                UPDATE attendee_session
                SET session = :session, attendee = :attendee
                WHERE session = :session AND attendee = :attendee
            ");

            $stmt->execute(array(
                "session"=>$AttendeeSession->getSession(),
                "attendee"=>$AttendeeSession->getAttendee()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends updateAttendeeSession function

    public function deleteAttendeeSession($session, $attendee) {

        require_once("EventManagement.class.php");

        $AttendeeSession = new AttendeeSession;
        $AttendeeSession->setSession($session);
        $AttendeeSession->setAttendee($attendee);

        try {

            $stmt = $this->dbh->prepare("
                DELETE FROM attendee_session
                WHERE session = :session AND attendee = :attendee
            ");

            $stmt->execute(array(
                "session"=>$AttendeeSession->getSession(),
                "attendee"=>$AttendeeSession->getAttendee()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends deleteAttendeeSession function

    /********************************MANAGER EVENT FUNCTIONS*************************************/
    public function getAllManagerEventObjectsAsTable() {

        $data = $this->getAllObjects("SELECT * FROM manager_event", "ManagerEvent");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Session ID</th>
                            <th>Attendee ID</th>
            </tr>\n";
    
            foreach ($data as $managerevent) {
                $outputTable .= $managerevent->getTableData();
            } // End foreach
    
        } else {
            $outputTable = "<h2>No events have managers yet.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllManagerEventObjectsAsTable

    public function getAllManagerEventObjectsByManagerAsTable($managerID) {

        $data = $this->getAllObjects("SELECT * FROM manager_event WHERE manager = '$managerID'", "ManagerEvent");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Max Attendees</th>
                            <th>Venue</th>
                            <th>
                            <th>
            </tr>\n";

            foreach ($data as $managerevent) {
                $outputTable .= $this->getAllEventObjectsAsTableByID($managerevent->getEvent());
            }
    
        } else {
            $outputTable = "<h2>You do not currently have any events.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllManagerEventObjectsAsTable

    public function getAllManagerSessionObjectsByManagerAsTable($managerID) {

        $data = $this->getAllObjects("SELECT * FROM manager_event WHERE manager = '$managerID'", "ManagerEvent");

        if (count($data) > 0) {

            $outputTable = "<tr>
                            <th>Session ID</th>
                            <th>Session Name</th>
                            <th>Max Attendees</th>
                            <th>Event</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>
                            <th>
            </tr>\n";

            foreach ($data as $managerevent) {
                $outputTable .= $this->getAllSessionObjectsAsTableByEvent($managerevent->getEvent());
            }
    
        } else {
            $outputTable = "<h2>There are no session for any of your events.</h2>";
        }// Ends if

        return $outputTable;

    } // Ends getAllManagerEventObjectsAsTable

    public function insertManagerEvent($event, $manager) {

        require_once("EventManagement.class.php");

        $ManagerEvent = new ManagerEvent;
        $ManagerEvent->setEvent($event);
        $ManagerEvent->setManager($manager);

        try {

            $stmt = $this->dbh->prepare("
                INSERT INTO manager_event (event, manager)
                VALUES (:event, :manager)
            ");

            $stmt->execute(array(
                "event"=>$ManagerEvent->getEvent(),
                "manager"=>$ManagerEvent->getManager()
            ));

        } catch (PDOException $pe) {
            echo $pe->getMessage();
            return -1;
        } // Ends try catch

    } // Ends insertManagerEvent function

    public function updateManagerEvent($event, $manager) {

        require_once("EventManagement.class.php");

        $ManagerEvent = new ManagerEvent;
        $ManagerEvent->setEvent($event);
        $ManagerEvent->setManager($manager);

        try {

            $stmt = $this->dbh->prepare("
                UPDATE manager_event
                SET event = :event, manager = :manager
                WHERE event = :event AND manager = :manager
            ");

            $stmt->execute(array(
                "event"=>$ManagerEvent->getEvent(),
                "manager"=>$ManagerEvent->getManager()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends updateManagerEvent function

    public function deleteManagerEvent($event, $manager) {

        require_once("EventManagement.class.php");

        $ManagerEvent = new ManagerEvent;
        $ManagerEvent->setEvent($event);
        $ManagerEvent->setManager($manager);

        try {

            $stmt = $this->dbh->prepare("
                DELETE FROM manager_event
                WHERE event = :event AND manager = :manager
            ");

            $stmt->execute(array(
                "event"=>$ManagerEvent->getEvent(),
                "manager"=>$ManagerEvent->getManager()
            ));

        } catch (PDOException $pe) {
            
            echo $pe->getMessage();
            return -1;
        
        } // Ends try catch

    } // Ends deleteManagerEvent function

} // Ends DB class