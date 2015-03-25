<?php
/*
	Name:		TransactionController
	Purpose:	Controllers for Transactions

	History:	Created 12/03/2015 by buddhi ashan	 
*/

class TransactionController extends BaseController {

	public function __construct(){
		$this->beforeFilter('csrf',array('on'=>'post'));
		$this->beforeFilter('user_group');
	}
	
	//Inserts a record for transaction table
	public function postCreate(){
		$booking_id = Input::get('booking_id');
		$payment_id = Input::get('paymant_id');
		$type = Input::get('type');
		$payment_gateway = "";
		$amount = Input::get('amount');
		$customer_id = DB::table('bookings')->where('id', '=', $booking_id)->pluck('identification_no');

		$transaction = new Transaction;

		$transaction->type = $type;
		$transaction->payment_id = $payment_id;
		$transaction->payment_gateway = $payment_gateway;
		$transaction->booking_id = $booking_id;
		$transaction->customer_id = $customer_id;
		$transaction->amount = $amount;

		$transaction->save();
	}
}