<?php


class receipt
{
	public $receiptId;
	public $txnCode;
	public $amount;
	public $is_valid;

	public function __construct($receiptId, $txnCode,$amount,$is_valid)
	{
		$this->receiptId = $receiptId;
		$this->txnCode = $txnCode;
		$this->amount = $amount;
		$this->is_valid = $is_valid;
	}

}