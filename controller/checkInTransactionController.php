<?php
    
class CheckInTransactionController extends TransactionEntity
{

    public function checkInTransaction($userId, $locationId, $slotId, $startTime, $actualDuration, $intendedDuration) {
        $transaction = new TransactionEntity();
        $transaction->set_userId($userId);
        $transaction->set_locationId($locationId);
        $transaction->set_slotId($slotId);
        $transaction->set_startTime($startTime);
        $transaction->set_actualDuration($actualDuration);
        $transaction->set_intendedDuration($intendedDuration);

        $error = $transaction->checkIn();
        return $error;
    }
}
?>