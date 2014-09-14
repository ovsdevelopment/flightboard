<?php
/**
 * FlightHistory.
 *
 * The FlightHistory class saves the latlng points the flight came across to draw the history line.
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

class FlightHistory {
    private $CONN;
    private $VID;
    private $altitude;
    private $latitude;
    private $longitude;
    private $datetime;

    public function __construct($args) {
        $this->CONN         =   $args['CONN'];
        $this->VID          =   $args['VID'];
        $this->altitude     =   $args['altitude'];
        $this->latitude     =   $args['latitude'];
        $this->longitude    =   $args['longitude'];
        $this->datetime     =   $args['datetime'];
    }

    /** Returns an array of all the data */
    public function toArray() {
        return array('altitude' => $this->altitude, 'latitude' => $this->latitude, 'longitude' => $this->longitude);
    }
}

class FlightHistoryDB extends DB {
    /** Inserts flight history into the database */
    public static function insertFlightHistory($args) {
        $prepare    =   parent::getConn()->prepare("INSERT INTO `flightHistory` (`CONN`, `VID`, `altitude`, `latitude`, `longitude`, `datetime`) VALUES (:CONN, :VID, :altitude, :latitude, :longitude, :datetime)");
        $prepare->bindParam(':CONN', $args['CONN']);
        $prepare->bindParam(':VID', $args['VID'], PDO::PARAM_INT);
        $prepare->bindParam(':altitude', $args['altitude']);
        $prepare->bindParam(':latitude', $args['latitude']);
        $prepare->bindParam(':longitude', $args['longitude']);
        $prepare->bindParam(':datetime', $args['datetime']);
        $prepare->execute();
    }

    /** Get the full flight history from the database for a specific VID */
    public static function getFlightHistory($CONN, $VID) {
        $prepare    =   parent::getConn()->prepare("SELECT * FROM `flightHistory` WHERE `CONN` = :CONN AND `VID` = :VID ORDER BY `datetime` DESC");
        $prepare->bindParam(':CONN', $CONN);
        $prepare->bindParam(':VID', $VID, PDO::PARAM_INT);
        $prepare->execute();

        foreach($prepare->fetchAll() AS $row)
            $list[]     =   new FlightHistory($row);

        if(isset($list))
            return $list;
    }

    /** Get the recent history (last 30 datapoints) from the database for a specific VID */
    public static function getFlightHistoryRecent($CONN, $VID) {
        $prepare    =   parent::getConn()->prepare("SELECT * FROM `flightHistory` WHERE `CONN` = :CONN AND `VID` = :VID ORDER BY `datetime` DESC LIMIT 30");
        $prepare->bindParam(':CONN', $CONN);
        $prepare->bindParam(':VID', $VID, PDO::PARAM_INT);
        $prepare->execute();

        foreach($prepare->fetchAll() AS $row)
            $list[]     =   new FlightHistory($row);

        if(isset($list))
            return $list;
    }

    /** Delete the flighthistory for a specific VID, this removes all datapoints for the flight */
    public static function deleteFlightHistory($CONN, $VID) {
        $prepare    =   parent::getConn()->prepare("DELETE FROM `flightHistory` WHERE `CONN` = :CONN `VID` = :VID");
        $prepare->bindParam(':CONN', $CONN);
        $prepare->bindParam(':VID', $VID, PDO::PARAM_INT);
        $prepare->execute();
    }
}