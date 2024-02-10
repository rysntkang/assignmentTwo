<?php

class ViewTransactionController extends TransactionEntity
{
    public function viewTransaction($slotId)
    {
        $transaction = new TransactionEntity();
        $transaction->set_slotId($slotId);
        $array = $transaction->view();

        return $array;
    }
}
?>