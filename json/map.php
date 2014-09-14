<?php
/**
 * JSON Map.
 *
 * The JSON Map takes care of the output needed by the Javascript AJAX for filling the map with flights
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

/** Checks whether the request is done by Ajax, not bulletproof, but better then nothing */
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    require_once('../includes/init.inc.php');

    $flightList     =   array();

    /** Loop threw the list of active flights and push them into an array */
    if($SYSTEM->getFlightList()) {
        foreach($SYSTEM->getFlightList() AS $flight) {

            /** Only push into the array if either the configuration says to show onground aircraft or the aircraft is not onground */
            if($config['onground'] == TRUE || $flight->onground != 1)
                $flightList[]       =   $flight->toArray();
        }
    }

    /** Echo the output as a JSON string for Javascript */
    echo json_encode($flightList);
}