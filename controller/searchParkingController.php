<?php

class SearchParkingController extends ParkingLocationEntity
{
    public function searchParking($locationName, $description, $address) {
        $parkingLocation = new ParkingLocationEntity();
        $parkingLocation->set_locationName($locationName);
        $parkingLocation->set_description($description);
        $parkingLocation->set_address($address);

        $array = $parkingLocation->search();
        return $array;
    }
}
?>