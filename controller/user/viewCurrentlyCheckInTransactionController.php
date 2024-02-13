<?php

class ViewCurrentlyCheckInTransactionController extends TransactionEntity
{
    public function viewCurrentlyCheckInTransaction($userId)
    {
        $transaction = new TransactionEntity();
        $transaction->set_userId($userId);
        $array = $transaction->viewCurrentlyCheckIn();

        return $array;
    }
}
?>