<?php

class CreateParkingLocationController extends ParkingLocationEntity
{
    public function createParkingLocation($locationName, $address) {
        $parkingLocation = new ParkingLocationEntity();
        $parkingLocation->set_locationName($locationName);
        $parkingLocation->set_address($address);

        $error = $parkingLocation->create();
        return $error;
    }
}
?>