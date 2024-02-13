<?php

class ViewAllPrevCheckInTransactionController extends TransactionEntity
{
    public function viewAllPrevCheckInTransaction($userId)
    {
        $transaction = new TransactionEntity();
        $transaction->set_userId($userId);
        $array = $transaction->viewAllPrevCheckIn();

        return $array;
    }
}
?>