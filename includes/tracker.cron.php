<?php
/**
 * Tracker.
 *
 * The tracker loads up the connectors and saves all flight movements into the database.
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

require_once('init.inc.php');

/** Loop threw the trackers, set dataList on NULL to prevent cache getting in the way */
foreach($config['tracker']['list'] AS $conn) {
    $dataList       =   NULL;

    /** Require the connector, if the file is not existing the script holds */
    require_once('connectors/'.$conn.'.inc.php');

    /** Load the data from the connector into the dataList */
    $dataList       =   $returnArray;
    if(isset($dataList)) {
        foreach($dataList AS $data) {
            /** Get the CONN and datetime fixed for each flight */
            $data['CONN']       =   $conn;
            $data['datetime']   =   date('Y-m-d H:i:s');

            /** If the flight exists, else insert it */
            if($SYSTEM->getFlight($conn, $data['VID'])) {
                /** If the Callsign, Departure or Destination ICAO changed, consider it a new flight, else update the current flight */
                if($SYSTEM->getFlight($conn, $data['VID'])->callsign != $data['callsign'] || $SYSTEM->getFlight($conn, $data['VID'])->departure != $data['departure'] || $SYSTEM->getFlight($conn, $data['VID'])->destination != $data['destination']) {
                    $SYSTEM->getFlight($conn, $data['VID'])->delete();
                    $SYSTEM->insertFlight($data);
                } else {
                    $SYSTEM->getFlight($conn, $data['VID'])->PIC            =   $data['PIC'];
                    $SYSTEM->getFlight($conn, $data['VID'])->category       =   $data['category'];
                    $SYSTEM->getFlight($conn, $data['VID'])->altitude       =   $data['altitude'];
                    $SYSTEM->getFlight($conn, $data['VID'])->groundspeed    =   $data['groundspeed'];
                    $SYSTEM->getFlight($conn, $data['VID'])->heading        =   $data['heading'];
                    $SYSTEM->getFlight($conn, $data['VID'])->latitude       =   $data['latitude'];
                    $SYSTEM->getFlight($conn, $data['VID'])->longitude      =   $data['longitude'];
                    $SYSTEM->getFlight($conn, $data['VID'])->route          =   $data['route'];
                    $SYSTEM->getFlight($conn, $data['VID'])->onground       =   $data['onground'];
                    $SYSTEM->getFlight($conn, $data['VID'])->datetime       =   $data['datetime'];

                    $SYSTEM->getFlight($conn, $data['VID'])->update();
                }
            } else {
                $SYSTEM->insertFlight($data);
            }

            /** Insert history data */
            $SYSTEM->insertFlightHistory($data);
        }
    }
}

/** Loop threw all existing flights in the system and remove flights that are not active anymore. Uses the timeout config to decide at what point to remove the flight. */
if($SYSTEM->getFlightList()) {
    foreach($SYSTEM->getFlightList() AS $flight) {
        if(strtotime($flight->datetime) + ($config['tracker']['timeout'] * 60) < time()) {
            $flight->delete();
        }
    }
}