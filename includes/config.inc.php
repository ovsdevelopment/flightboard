<?php
/**
 * Configuration.
 *
 * Edit settings to your own, the rest of the system uses these variables.
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

/** Database credentials */
$config['DB']['host']       =   'localhost';
$config['DB']['user']       =   ‘username’;
$config['DB']['password']   =   ‘password’;
$config['DB']['database']   =   ‘database’;

/** A list of all trackers, which the cronjob loops threw and looks for xxx.inc.php in the includes/connectors folder */
$config['tracker']['list']      =   array('ivao', 'vatsim');

/** Tracker timeout, after xx minutes the flight will be removed from the database */
$config['tracker']['timeout']   =   15;

/** If true, showing aircraft that are onground */
$config['onground']             =   FALSE;