<?php
/**
 * VATSIM Connector.
 *
 * Example connector for the VATSIM network
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

$returnArray    =   array();
$data           =   @file_get_contents("http://www.pcflyer.net/DataFeed/vatsim-data.txt");

if(isset($data)) {
    $dataEntryList  =   explode("\n", $data);

    foreach($dataEntryList AS $dataEntry) {
        $dataEntryExplode   =   explode(":", $dataEntry);

        if(isset($dataEntryExplode[3]) && $dataEntryExplode[3] == 'PILOT' && $dataEntryExplode[5] != '' && $dataEntryExplode[6] != '') {
            if($dataEntryExplode[8] > 0)
                $onground   =   0;
            else
                $onground   =   1;

            $returnArray[$dataEntryExplode[1]]   =   array('VID' => $dataEntryExplode[1], 'PIC' => $dataEntryExplode[2], 'category' => 'X', 'callsign' => $dataEntryExplode[0], 'departure' => $dataEntryExplode[11], 'destination' => $dataEntryExplode[13], 'altitude' => $dataEntryExplode[7], 'groundspeed' => $dataEntryExplode[8], 'heading' => $dataEntryExplode[38], 'latitude' => $dataEntryExplode[5], 'longitude' => $dataEntryExplode[6], 'route' => '(FPL-'.$dataEntryExplode[0]."\n-".$dataEntryExplode[30].")", 'onground' => $onground);
        }
    }
}