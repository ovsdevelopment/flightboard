<?php
/**
 * Initiator.
 *
 * The initiator starts everything needed for web usage and database connections.
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

/** Require the configuration and library */
require_once('config.inc.php');
require_once('library.inc.php');

/** Boot session and buffer */
session_start();
ob_start();

/** Set timezone */
date_default_timezone_set('UTC');

/** Connect to the database, and unset the database from the configuration array */
DB::getInstance($config['DB']['host'], $config['DB']['user'], $config['DB']['password'], $config['DB']['database']);
unset($config['DB']);

/** If no config can be found at this point, exit the page */
if(!isset($config))
    exit('Major error, we can not serve you this page currently. Please try again later.');

/** Starts the system class regulating database requests in the controllers */
$SYSTEM     =   new SYSTEM();
if(!isset($SYSTEM))
    exit('Major error, we can not serve you this page currently. Please try again later.');