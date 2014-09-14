CREATE TABLE `flight` (
  `CONN` varchar(16) NOT NULL,
  `VID` int(8) unsigned NOT NULL,
  `PIC` varchar(128) NOT NULL,
  `category` enum('X','L','M','H','S') NOT NULL DEFAULT 'X',
  `callsign` varchar(10) NOT NULL,
  `departure` varchar(4) NOT NULL,
  `destination` varchar(4) NOT NULL,
  `altitude` int(6) NOT NULL,
  `groundspeed` int(5) NOT NULL,
  `heading` int(3) NOT NULL,
  `latitude` varchar(8) NOT NULL,
  `longitude` varchar(8) NOT NULL,
  `route` text NOT NULL,
  `onground` int(1) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`CONN`,`VID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `flightHistory` (
  `CONN` varchar(16) NOT NULL,
  `VID` int(8) NOT NULL,
  `altitude` int(6) NOT NULL,
  `latitude` varchar(8) NOT NULL,
  `longitude` varchar(8) NOT NULL,
  `datetime` datetime NOT NULL,
  KEY `CONN` (`CONN`,`VID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;