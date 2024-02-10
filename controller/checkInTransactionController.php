<?php
    
class CheckInTransactionController extends TransactionEntity
{

    public function checkInTransaction($userId, $locationId, $slotId, $startTime, $duration) {
        $transaction = new TransactionEntity();
        $transaction->set_userId($userId);
        $transaction->set_locationId($locationId);
        $transaction->set_slotId($slotId);
        $transaction->set_startTime($startTime);
        $transaction->set_duration($duration);

        $error = $transaction->checkIn();
        return $error;
    }
}
?>