<?php

class ViewParkingLocationController extends ParkingLocationEntity
{
    public function viewParkingLocation()
    {
        $parkingLocation = new parkingLocationEntity();
        $array = $parkingLocation->view();

        return $array;
    }
}
?>