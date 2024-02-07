<?php

class UpdateParkingLocationController extends ParkingLocationEntity
{
    public function updateParkingLocation($locationId, $locationName, $address) 
    {
        $parkingLocation = new ParkingLocationEntity();
        $parkingLocation->set_locationId($locationId);
        $parkingLocation->set_locationName($locationName);
        $parkingLocation->set_address($address);

        $error = $parkingLocation->update();
        return $error;
    }
}
?>