<?php
/**
 * Flight.
 *
 * The Flight class takes care of all flights in the system.
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

class Flight {
    private $CONN;
    private $VID;
    private $PIC;
    private $category;
    private $callsign;
    private $departure;
    private $destination;
    private $altitude;
    private $groundspeed;
    private $heading;
    private $latitude;
    private $longitude;
    private $route;
    private $onground;
    private $datetime;

    private $_flightHistoryRecentList;
    private $_flightHistoryArray;

    public function __construct($args) {
        $this->CONN         =   $args['CONN'];
        $this->VID          =   $args['VID'];
        $this->PIC          =   $args['PIC'];
        $this->category     =   $args['category'];
        $this->callsign     =   $args['callsign'];
        $this->departure    =   $args['departure'];
        $this->destination  =   $args['destination'];
        $this->altitude     =   $args['altitude'];
        $this->groundspeed  =   $args['groundspeed'];
        $this->heading      =   $args['heading'];
        $this->latitude     =   $args['latitude'];
        $this->longitude    =   $args['longitude'];
        $this->route        =   $args['route'];
        $this->onground     =   $args['onground'];
        $this->datetime     =   $args['datetime'];
    }

    public function __get($property) {
        if(property_exists($this, $property))
            return $this->$property;
        else
            exit('Property '.$property.' does not exists to get!');
    }

    public function __set($property, $value) {
        if(property_exists($this, $property))
            $this->$property    =   $value;
        else
            exit('Property '.$property.' does not exists to set!');
    }

    public function update() {
        FlightDB::updateFlight($this);
    }

    public function delete() {
        FlightDB::deleteFlight($this);
    }

    /** Returns an array of the class data, including recent flight history data */
    public function toArray() {
        return array('CONN' => $this->CONN, 'VID' => $this->VID, 'PIC' => $this->PIC, 'category' => $this->category, 'callsign' => $this->callsign, 'departure' => $this->departure, 'destination' => $this->destination, 'altitude' => $this->altitude, 'groundspeed' => $this->groundspeed, 'heading' => $this->heading, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'route' => nl2br($this->route), 'onground' => $this->onground, 'datetime' => $this->datetime, 'history' => self::getFlightHistoryArray());
    }

    /** Returns a list of recent flights in FlightHistory objects */
    public function getFlightHistoryRecentList() {
        if(!$this->_flightHistoryRecentList)
            $this->_flightHistoryRecentList     =   FlightHistoryDB::getFlightHistoryRecent($this->CONN, $this->VID);

        return $this->_flightHistoryRecentList;
    }

    /** Returns an array of the recent flights instead of the FlightHistory objects */
    public function getFlightHistoryArray() {
        self::getFlightHistoryRecentList();

        if($this->_flightHistoryRecentList) {
            foreach($this->_flightHistoryRecentList AS $flight) {
                $this->_flightHistoryArray[]    =   $flight->toArray();
            }
        }

        return $this->_flightHistoryArray;
    }
}

class FlightDB extends DB {
    /** Get a specific flight from the database */
    public static function getFlight($CONN, $VID) {
        $prepare    =   parent::getConn()->prepare("SELECT * FROM `flight` WHERE `CONN` = :CONN AND `VID` = :VID LIMIT 1");
        $prepare->bindParam(':CONN', $CONN);
        $prepare->bindParam(':VID', $VID);
        $prepare->execute();

        $row        =   $prepare->fetch();
        if($row['VID'])
            return new Flight($row);
    }

    /** Get a list of all flights from the database */
    public static function getFlightList() {
        $prepare    =   parent::getConn()->prepare("SELECT * FROM `flight`");
        $prepare->execute();

        foreach($prepare->fetchAll() AS $row)
            $list[] =   new Flight($row);

        if(isset($list))
            return $list;
    }

    /** Insert a flight into the database */
    public static function insertFlight($args) {
        $prepare    =   parent::getConn()->prepare("INSERT INTO `flight` (`CONN`, `VID`, `PIC`, `category`, `callsign`, `departure`, `destination`, `altitude`, `groundspeed`, `heading`, `latitude`, `longitude`, `route`, `onground`, `datetime`) VALUES (:CONN, :VID, :PIC, :category, :callsign, :departure, :destination, :altitude, :groundspeed, :heading, :latitude, :longitude, :route, :onground, :datetime)");
        $prepare->bindParam(':CONN', $args['CONN']);
        $prepare->bindParam(':VID', $args['VID'], PDO::PARAM_INT);
        $prepare->bindParam(':PIC', $args['PIC']);
        $prepare->BindParam(':category', $args['category']);
        $prepare->bindParam(':callsign', $args['callsign']);
        $prepare->bindParam(':departure', $args['departure']);
        $prepare->bindParam(':destination', $args['destination']);
        $prepare->bindParam(':altitude', $args['altitude']);
        $prepare->bindParam(':groundspeed', $args['groundspeed']);
        $prepare->bindParam(':heading', $args['heading']);
        $prepare->bindParam(':latitude', $args['latitude']);
        $prepare->bindParam(':longitude', $args['longitude']);
        $prepare->bindParam(':route', $args['route']);
        $prepare->bindParam(':onground', $args['onground']);
        $prepare->bindParam(':datetime', $args['datetime']);
        $prepare->execute();
    }

    /** Update a flight in the database */
    public static function updateFlight($flight) {
        $prepare    =   parent::getConn()->prepare("UPDATE `flight` SET `PIC` = :PIC, `category` = :category, `altitude` = :altitude, `groundspeed` = :groundspeed, `heading` = :heading, `latitude` = :latitude, `longitude` = :longitude, `route` = :route, `onground` = :onground, `datetime` = :datetime WHERE `CONN` = :CONN AND `VID` = :VID");
        $prepare->bindParam(':PIC', $flight->PIC);
        $prepare->bindParam(':category', $flight->category);
        $prepare->bindParam(':altitude', $flight->altitude);
        $prepare->bindParam(':groundspeed', $flight->groundspeed);
        $prepare->bindParam(':heading', $flight->heading);
        $prepare->bindParam(':latitude', $flight->latitude);
        $prepare->bindParam(':longitude', $flight->longitude);
        $prepare->bindParam(':route', $flight->route);
        $prepare->bindParam(':onground', $flight->onground);
        $prepare->bindParam(':datetime', $flight->datetime);
        $prepare->bindParam(':CONN', $flight->CONN);
        $prepare->bindParam(':VID', $flight->VID);
        $prepare->execute();
    }

    /** Delete a specific flight from the database */
    public static function deleteFlight($flight) {
        FlightHistoryDB::deleteFlightHistory($flight->CONN, $flight->VID);

        $prepare    =   parent::getConn()->prepare("DELETE FROM `flight` WHERE `CONN` = :CONN AND `VID` = :VID LIMIT 1");
        $prepare->bindParam(':CONN', $flight->CONN);
        $prepare->bindParam(':VID', $flight->VID);
        $prepare->execute();
    }
}