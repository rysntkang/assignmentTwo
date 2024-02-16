<?php

class GetParkingSlotController extends ParkingSlotsEntity
{
    public function getParkingSlot($slotId)
    {
        $parkingSlot = new ParkingSlotsEntity();
        $parkingSlot->set_slotId($slotId);
        $array = $parkingSlot->get();

        return $array;
    }
}
?>