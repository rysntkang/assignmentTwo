<?php

class GetParkingLocationController extends ParkingLocationEntity
{
    public function getParkingLocation($locationId)
    {
        $parkingLocation = new ParkingLocationEntity();
        $parkingLocation->set_locationId($locationId);
        $array = $parkingLocation->get();

        return $array;
    }
}
?>