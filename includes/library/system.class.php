<?php
/**
 * SYSTEM.
 *
 * The System class takes care of requests from the PHP controllers towards the Models and database.
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

class SYSTEM {
    private $_flight;
    private $_flightList;

    /** Request a specific flight from the database */
    public function getFlight($CONN, $VID) {
        if(!$this->_flight[$CONN][$VID])
            $this->_flight[$CONN][$VID]     =   FlightDB::getFlight($CONN, $VID);

        return $this->_flight[$CONN][$VID];
    }

    /** Get all flights in an array */
    public function getFlightList() {
        if(!$this->_flightList)
            $this->_flightList              =   FlightDB::getFlightList();

        return $this->_flightList;
    }

    /** Insert a flight into the database */
    public function insertFlight($args) {
        FlightDB::insertFlight($args);
    }

    /** Insert flight history into the database */
    public function insertFlightHistory($args) {
        FlightHistoryDB::insertFlightHistory($args);
    }
}