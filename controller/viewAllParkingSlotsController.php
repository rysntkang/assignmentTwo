<?php

class ViewAllParkingSlotsController extends ParkingSlotsEntity
{
    public function viewAllParkingSlots($locationId)
    {
        $parkingLocation = new ParkingSlotsEntity($locationId);
        $parkingLocation->set_locationId($locationId);
        $array = $parkingLocation->viewAll();

        return $array;
    }
}
?>