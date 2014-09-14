<?php
/**
 * DB.
 *
 * The database class is the main connector between the database and the website. All DB classes use this class to connect to the database
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

class DB {
    private static $instance 	= 	NULL;	//Instance of class database
    public static $conn			=	NULL;	//Connection with the database

    /** Create the private instance */
    private function __construct($host, $username, $password, $database) {
        try {
            self::$conn = new PDO("mysql:host=".$host.";dbname=".$database, $username, $password);
            return self::$conn;
        } catch (PDOException $e) {
            print("Error connection to database: ".$e->getMessage());
        }
    }

    /** Retrieve the instance */
    public static function getInstance($host, $username, $password, $database) {
        if(self::$instance == NULL) {
            self::$instance = new DB($host, $username, $password, $database);
        }
    }

    /** Get the connection */
    public static function getConn() {
        return self::$conn;
    }
}