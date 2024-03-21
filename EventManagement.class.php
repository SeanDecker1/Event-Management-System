<?php

class Events {

    private $idevent;
    private $name;
    private $datestart;
    private $dateend;
    private $numberallowed;
    private $venue;

    public function getTableData($withButtons) {

        $formattedStart = strtotime($this->datestart);
        $formattedStart = date('m/d/Y', $formattedStart);
        $formattedEnd = strtotime($this->dateend);
        $formattedEnd = date('m/d/Y', $formattedEnd);

        $returnString =
        "<tr>
            <td>{$this->idevent}</td>
            <td>{$this->name}</td>
            <td>{$formattedStart}</td>
            <td>{$formattedEnd}</td>
            <td>{$this->numberallowed}</td>
            <td>{$this->venue}</td>
        ";

        if ($withButtons) {
            $returnString .= "
            <td>
                <a href='ModifyItem.php?type=event&action=edit&id={$this->idevent}'>
                    <button class='btn btn-primary btn-block'>Edit</button>
                </a>
            </td>
            <td>
                <a href='Validate.php?type=event&action=delete&id={$this->idevent}'>
                    <button class='btn btn-danger btn-block'>Delete</button>
                </a>
            </td>
            <td>
                <a href='ModifyItem.php?type=eventAttendees&action=get&id={$this->idevent}'>
                    <button class='btn btn-dark btn-block'>View Attendees</button>
                </a>
            </td>";
        } // Ends if

        $returnString .= "
        </tr>\n";

        return $returnString;

    } // Ends getTableData function

    // Getters
    public function getEventID() { return $this->idevent; }
    public function getEventName() { return $this->name; }
    public function getEventStart() { return $this->datestart; }
    public function getEventEnd() { return $this->dateend; }
    public function getEventAllowed() { return $this->numberallowed; }
    public function getEventVenue() { return $this->venue; }

    // Setters
    public function setEventID($idevent) { $this->idevent = $idevent; }
    public function setEventName($name) { $this->name = $name; }
    public function setEventStart($datestart) { $this->datestart = $datestart; }
    public function setEventEnd($dateend) { $this->dateend = $dateend; }
    public function setEventAllowed($numberallowed) { $this->numberallowed = $numberallowed; }
    public function setEventVenue($venue) { $this->venue = $venue; }

} // Ends Events class

class Venues {

    private $idvenue;
    private $name;
    private $capacity;

    public function getTableData() {

        return "<tr>
            <td>{$this->idvenue}</td>
            <td>{$this->name}</td>
            <td>{$this->capacity}</td>
            <td>
                <a href='ModifyItem.php?type=venue&action=edit&id={$this->idvenue}'>
                    <button class='btn btn-primary btn-block'>Edit</button>
                </a>
            </td>
            <td>
                <a href='Validate.php?type=venue&action=delete&id={$this->idvenue}'>
                    <button class='btn btn-danger btn-block'>Delete</button>
                </a>
            </td>
        </tr>\n";

    } // Ends getTableData function

    // Getters
    public function getVenueID() { return $this->idvenue; }
    public function getVenueName() { return $this->name; }
    public function getVenueCapacity() { return $this->capacity; }

    // Setters
    public function setVenueID($idvenue) { $this->idvenue = $idvenue; }
    public function setVenueName($name) { $this->name = $name; }
    public function setVenueCapacity($capacity) { $this->capacity = $capacity; }

} // Ends Venues class

class Sessions {

    private $idsession;
    private $name;
    private $numberallowed;
    private $event;
    private $startdate;
    private $enddate;

    public function getTableData() {

        $formattedStart = strtotime($this->startdate);
        $formattedStart = date('m/d/Y', $formattedStart);
        $formattedEnd = strtotime($this->enddate);
        $formattedEnd = date('m/d/Y', $formattedEnd);

        return "<tr>
            <td>{$this->idsession}</td>
            <td>{$this->name}</td>
            <td>{$this->numberallowed}</td>
            <td>{$this->event}</td>
            <td>{$formattedStart}</td>
            <td>{$formattedEnd}</td>
            <td>
                <a href='ModifyItem.php?type=session&action=edit&id={$this->idsession}'>
                    <button class='btn btn-primary btn-block'>Edit</button>
                </a>
            </td>
            <td>
                <a href='Validate.php?type=session&action=delete&id={$this->idsession}'>
                    <button class='btn btn-danger btn-block'>Delete</button>
                </a>
            </td>
            <td>
                <a href='ModifyItem.php?type=sessionAttendees&action=get&id={$this->idsession}'>
                    <button class='btn btn-dark btn-block'>View Attendees</button>
                </a>
            </td>
        </tr>\n";

    } // Ends getTableData function

    // Getters
    public function getSessionID() { return $this->idsession; }
    public function getSessionName() { return $this->name; }
    public function getSessionNumberAllowed() { return $this->numberallowed; }
    public function getSessionEvent() { return $this->event; }
    public function getSessionStartDate() { return $this->startdate; }
    public function getSessionEndDate() { return $this->enddate; }

    // Setters
    public function setSessionID($idsession) { $this->idsession = $idsession; }
    public function setSessionName($name) { $this->name = $name; }
    public function setSessionNumberAllowed($numberallowed) { $this->numberallowed = $numberallowed; }
    public function setSessionEvent($event) { $this->event = $event; }
    public function setSessionStartDate($startdate) { $this->startdate = $startdate; }
    public function setSessionEndDate($enddate) { $this->enddate = $enddate; }

} // Ends Sessions class

class Attendees {

    private $idattendee;
    private $name;
    private $password;
    private $role;

    public function getTableData() {

        return "<tr>
            <td>{$this->idattendee}</td>
            <td>{$this->name}</td>
            <td>{$this->password}</td>
            <td>{$this->role}</td>
            <td>
                <a href='ModifyItem.php?type=user&action=edit&id={$this->idattendee}'>
                    <button class='btn btn-primary btn-block'>Edit</button>
                </a>
            </td>
            <td>
                <a href='Validate.php?type=user&action=delete&id={$this->idattendee}'>
                    <button class='btn btn-danger btn-block'>Delete</button>
                </a>
            </td>
        </tr>\n";

    } // Ends getTableData function

    // Getters
    public function getID() { return $this->idattendee; }
    public function getName() { return $this->name; }
    public function getPassword() { return $this->password; }
    public function getRole() { return $this->role; }

    // Setters
    public function setID($id) { $this->idattendee = $id; }
    public function setName($name) { $this->name = $name; }
    public function setPassword($password) { $this->password = $password; }
    public function setRole($role) { $this->role = $role; }

} // Ends Attendees class

class AttendeeEvent {

    private $event;
    private $attendee;
    private $paid;

    public function getTableData($attendeeName) {

        return "<tr>
                <td>{$this->attendee}</td>
                <td>{$attendeeName}</td>
                <td>{$this->paid}</td>
                <td>
                    <a href='Validate.php?type=eventAttendees&action=delete&id={$this->attendee}&event={$this->event}'>
                        <button class='btn btn-danger btn-block'>Delete</button>
                    </a>
                </td>
            </tr>\n";

    } // Ends getTableData function

    public function getTableDataEvents($eventName) {

        return "<tr>
                <td>{$this->event}</td>
                <td>{$eventName}</td>
                <td>{$this->paid}</td>
                <td>
                    <a href='Validate.php?type=eventAttendees&action=delete&id={$this->attendee}&event={$this->event}'>
                        <button class='btn btn-danger btn-block'>Delete</button>
                    </a>
                </td>
            </tr>\n";

    } // Ends getTableData function

    // Getters
    public function getEvent() { return $this->event; }
    public function getAttendee() { return $this->attendee; }
    public function getPaid() { return $this->paid; }

    // Setters
    public function setEvent($event) { $this->event = $event; }
    public function setAttendee($attendee) { $this->attendee = $attendee; }
    public function setPaid($paid) { $this->paid = $paid; }

} // Ends AttendeeEvent class

class AttendeeSession {

    private $session;
    private $attendee;

    public function getTableData($attendeeName) {

        return "<tr>
            <td>{$this->attendee}</td>
            <td>{$attendeeName}</td>
            <td>
                <a href='Validate.php?type=sessionAttendees&action=delete&id={$this->attendee}&session={$this->session}'>
                    <button class='btn btn-danger btn-block'>Delete</button>
                </a>
            </td>
        </tr>\n";

    } // Ends getTableData function

    public function getTableDataSessions($sessionName) {

        return "<tr>
            <td>{$this->session}</td>
            <td>{$sessionName}</td>
            <td>
                <a href='Validate.php?type=sessionAttendees&action=delete&id={$this->attendee}&session={$this->session}'>
                    <button class='btn btn-danger btn-block'>Delete</button>
                </a>
            </td>
        </tr>\n";

    } // Ends getTableData function

    // Getters
    public function getSession() { return $this->session; }
    public function getAttendee() { return $this->attendee; }

    // Setters
    public function setSession($session) { $this->session = $session; }
    public function setAttendee($attendee) { $this->attendee = $attendee; }

} // Ends AttendeeSession class

class ManagerEvent {

    private $event;
    private $manager;

    public function getTableData() {

        return "<tr>
            <td>{$this->event}</td>
            <td>{$this->manager}</td>
        </tr>\n";

    } // Ends getTableData function

    // Getters
    public function getEvent() { return $this->event; }
    public function getManager() { return $this->manager; }

    // Setters
    public function setEvent($event) { $this->event = $event; }
    public function setManager($manager) { $this->manager = $manager; }

} // Ends ManagerEvent class