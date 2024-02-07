<?php

class SearchParkingLocationController extends ParkingLocationEntity
{
    public function searchParkingLocation($locationName) {
        $parkingLocation = new ParkingLocationEntity();
        $parkingLocation->set_locationName($locationName);

        $array = $parkingLocation->search();
        return $array;
    }
}
?>