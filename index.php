<?php
/**
 * Frontpage.
 *
 * The frontpage is the landing page of the website and takes care of starting all Javascript needed to load the map. All look and feel as in divs or webpage elements should be done here, or included here.
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */
echo '<!DOCTYPE html>';
echo '<html lang="en">';
    echo '<head>';
        echo '<title>FlightBoard</title>';

        echo '<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<meta name="keywords" content="flightboard, flight, board, ivao, vatsim, open, source, gpl, ovsdev, ovsdevelopment" />';
        echo '<meta name="description" content="Open Source FlightBoard live flight tracker.">';

        echo '<meta name="robots" content="index, follow, noarchive" />';

        echo '<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />';
        echo '<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />';
        echo '<link rel="stylesheet" href="css/style.css" />';

        echo '<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>';
        echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>';
        echo '<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>';
        echo '<script src="js/rotatedmarker.leaflet.js"></script>';
    echo '</head>';

    echo '<body>';
        echo '<div id="map"></div>';
        echo '<div id="popup"></div>';
    echo '</body>';

    echo '<script src="js/map.js"></script>';
echo '</html>';