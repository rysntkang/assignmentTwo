<?php
    
class CheckOutTransactionController extends TransactionEntity
{

    public function checkOutTransaction($transactionId, $locationId, $slotId, $endTime, $totalCost) {
        $transaction = new TransactionEntity();
        $transaction->set_transactionId($transactionId);
        $transaction->set_locationId($locationId);
        $transaction->set_slotId($slotId);
        $transaction->set_endTime($endTime);
        $transaction->set_totalCost($totalCost);
        $error = $transaction->checkOut();
        return $error;
    }
}
?>