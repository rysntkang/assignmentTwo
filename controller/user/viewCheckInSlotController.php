<?php

class ViewCheckInSlotController extends TransactionEntity
{
    public function viewCheckInSlot($slotId)
    {
        $transaction = new TransactionEntity();
        $transaction->set_slotId($slotId);
        $array = $transaction->viewCheckIn();

        return $array;
    }
}
?>