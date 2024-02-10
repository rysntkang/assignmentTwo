<?php

class CreateParkingLocationController extends ParkingLocationEntity
{
    public function createParkingLocation($locationName, $description ,$address, $rates, $ratesLate ,$capacity) {
        $parkingLocation = new ParkingLocationEntity();
        $parkingLocation->set_locationName($locationName);
        $parkingLocation->set_description($description);
        $parkingLocation->set_address($address);
        $parkingLocation->set_rates($rates);
        $parkingLocation->set_ratesLate($ratesLate);
        $parkingLocation->set_capacity($capacity);

        $error = $parkingLocation->create();
        return $error;
    }
}
?>