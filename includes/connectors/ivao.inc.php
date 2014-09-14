<?php
/**
 * IVAO Connector.
 *
 * Example connector for the IVAO network.
 *
 * @author Pim Oude Veldhuis
 * @copyright 2014 OVS Development <OVSdev.com>
 * @license GNU General Public License, version 3
 */

$returnArray    =   array();
$data           =   @file_get_contents("http://api.ivao.aero/getdata/whazzup");

if(isset($data)) {
    $dataEntryList  =   explode("\n", $data);

    foreach($dataEntryList AS $dataEntry) {
        $dataEntryExplode   =   explode(":", $dataEntry);

        if(isset($dataEntryExplode[3]) && $dataEntryExplode[3] == 'PILOT' && $dataEntryExplode[5] != '' && $dataEntryExplode[6] != '') {
            $category               =   explode("/", $dataEntryExplode[9]);
            $category               =   substr($category[2], 0, 1);

            $returnArray[$dataEntryExplode[1]]   =   array('VID' => $dataEntryExplode[1], 'PIC' => $dataEntryExplode[2], 'category' => $category, 'callsign' => $dataEntryExplode[0], 'departure' => $dataEntryExplode[11], 'destination' => $dataEntryExplode[13], 'altitude' => $dataEntryExplode[7], 'groundspeed' => $dataEntryExplode[8], 'heading' => $dataEntryExplode[45], 'latitude' => $dataEntryExplode[5], 'longitude' => $dataEntryExplode[6], 'route' => '(FPL-'.$dataEntryExplode[0]."-".$dataEntryExplode[21].$dataEntryExplode[43]."\n-".substr($dataEntryExplode[9], 2)."\n-".$dataEntryExplode[11]."\n-".$dataEntryExplode[30]."\n-".$dataEntryExplode[13]." ".$dataEntryExplode[28]."\n-".$dataEntryExplode[29].")", 'onground' => $dataEntryExplode[46]);
        }
    }
}