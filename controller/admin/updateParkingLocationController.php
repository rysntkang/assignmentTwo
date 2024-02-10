<?php

class UpdateParkingLocationController extends ParkingLocationEntity
{
    public function updateParkingLocation($locationId, $locationName, $description, $address, $rates, $ratesLate) 
    {
        $parkingLocation = new ParkingLocationEntity();
        $parkingLocation->set_locationId($locationId);
        $parkingLocation->set_locationName($locationName);
        $parkingLocation->set_description($description);
        $parkingLocation->set_address($address);
        $parkingLocation->set_rates($rates);
        $parkingLocation->set_ratesLate($ratesLate);

        $error = $parkingLocation->update();
        return $error;
    }
}
?>