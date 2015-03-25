<?php

class BookingController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('login');
	}

	public function getBooking1() {
		return View::make('booking.add1');
	}

	public function postBooking2() {

			$validator = Validator::make(Input::all(), Booking::$rules1);
			
			//validating the input fields
			if(!$validator->passes()) {
				return Redirect::to('booking/booking1')
					->withErrors($validator)
					->withInput();
				
			}

			//getting all the values into sessions
			Session::put('id_no', Input::get('id_no'));
			Session::put('start_date', Input::get('start_date'));
			Session::put('end_date', Input::get('end_date'));
			Session::put('no_of_adults', Input::get('no_of_adults'));
			Session::put('no_of_kids', Input::get('no_of_kids'));
			Session::put('no_of_rooms', Input::get('no_of_rooms'));
			Session::put('promo_code', Input::get('promo_code'));

			$room = RoomType::find(Input::get('room_type_id'));

			//array to load the comobo box
			$no_rooms = array();

			// get all the room types that have prices withing the booked date
			$calendar = DB::table('room_price_calenders')
								->select('room_type_id')
								->where('start_date', '>=', Session::get('start_date'))
								->where('start_date', '<=', Session::get('end_date'))
								->where('end_date', '>=', Session::get('end_date'))
								->distinct()
								->get();

			foreach ($calendar as $roomss) {

				
				$room_type = RoomType::find($roomss->room_type_id);
				$booked_rooms = DB::table('bookings')
										->select('room_type_id')
										->distinct()
										->get();

				$arr_booked_rooms = array();

				foreach ($booked_rooms as $book) {
					$arr_booked_rooms[] = $book->room_type_id;
				}

				$start_date = Session::get('start_date');
				$end_date = Session::get('end_date');
				
				// get the total of booked room types from the above selected room types
				$room_no = DB::select(DB::raw("SELECT SUM(no_of_rooms) as room_sum
											FROM bookings
											WHERE ((start_date >= '$start_date' AND start_date <= '$end_date') OR (end_date >= '$start_date' AND end_date <= '$end_date') OR ((start_date <= '$start_date' AND end_date >= '$end_date'))) AND room_type_id = $roomss->room_type_id AND check_out is null"));


				// adding the cart rooms to the room checking
				$cart_rooms = 0;

				foreach (Cart::contents() as $carts) {
					if($carts->id == $roomss->room_type_id) {
						$cart_rooms = $cart_rooms + $carts->quantity;
					}
				}

				//adding the room type to the combo box array if the rooms are available
				if((Session::get('no_of_rooms')+intval($room_no[0]->room_sum) + $cart_rooms)<=$room_type['no_of_rooms']) {
					$no_rooms[$room_type['id']] = $room_type['name'];
				}
			}
			//getting the rooms that has not been booked before
			$not_booked_rooms = DB::table('room_price_calenders')
									->select('room_types.name', 'room_types.id')
									->distinct()
									->join('room_types', 'room_types.id', '=', 'room_price_calenders.room_type_id')
									->where('start_date', '>=', Session::get('start_date'))
									->where('start_date', '<=', Session::get('end_date'))
									->where('room_types.no_of_rooms', '>=', Session::get('no_of_rooms'))
									->where('room_price_calenders.end_date', '>=', Session::get('end_date'))
				                    ->whereNotIn('room_price_calenders.room_type_id', $arr_booked_rooms)
				                    ->get();

			//adding the rooms that are not booked before to the combo box array
			foreach ($not_booked_rooms as $book) {
				$no_rooms[$book->id] = $book->name;
			}
			
			//sending the combo box array to the next page
			return View::make('booking.add2')
				->with('rooms', $no_rooms);
	}


	public function postPrice() {
		// get all the prices withing the given date range and within give services and room type

		$prices = DB::table('room_price_calenders')
						->where('start_date', '>=', Session::get('start_date'))
						->where('start_date', '<=', Session::get('end_date'))
						->where('service_id', '=', Input::get('service_id'))
						->where('room_type_id', '=', Input::get('room_type_id'))
						->get();


		$price_list = array();
		$total = 0;
		foreach ($prices as $price) {
			$price_list[] = $price->price;
			$total = $total+$price->price;
		}
		
		return $total;
	}

	public function postCreate() {
	// create a new booking

		$room_details = RoomType::find(Input::get('room_type'));

		// checking the payment amount
		$payment = Input::get('paid_amount');
		
		if($payment === 'full') {
			$payment_amount = floatval(Input::get('total_charges'));
		} else {
			$room_price = DB::table('room_price_calenders')
						->select('price')
						->where('start_date', '=', Session::get('start_date'))
						->where('service_id', '=', Input::get('service'))
						->where('room_type_id', '=', Input::get('room_type'))
						->get();

			$payment_amount = floatval($room_price[0]->price);
		}

		//adding the booking to the cart
		$data = array(
			'id' => Input::get('room_type'),
			'name' => $room_details->name,
			'quantity' => Session::get('no_of_rooms'),
			'price' => Input::get('total_charges'),
			'options' => array(
						'identification_no' => Session::get('id_no'),
						'no_of_adults' => Session::get('no_of_adults'),
						'no_of_kids' => Session::get('no_of_kids'),
						'services' => Input::get('service'),
						'paid_amount' => $payment_amount,
						'promo_code' => Session::get('promo_code')
						)
			);
		
		Cart::insert($data);

		return Redirect::to('booking/cart');
	}

	public function getCart() {
	// Show the summary of bookings

		return View::make('booking.cart')
						->with('rooms', Cart::contents());
	}

	public function loaditem() {
	// load services to the combobox when room types are selected

		$room_id = Input::get('room_type_id');
		$service_id = DB::table('room_price_calenders')
							->join('services', 'room_price_calenders.service_id', '=', 'services.id')
							->select('room_price_calenders.service_id', 'services.name')
							->where('room_type_id', $room_id)
							->where('start_date', '>=', Session::get('start_date'))
							->where('start_date', '<=', Session::get('end_date'))
							->distinct()
							->get();

		return Response::json($service_id);
	}

	public function postPlacebooking() {
	//Saving the booking details to the database

		foreach (Cart::contents() as $bookings) {
			$booking = new Booking();

			$booking->identification_no = $bookings->options['identification_no'];
			$booking->room_type_id = $bookings->id;
			$booking->no_of_rooms = $bookings->quantity;
			$booking->no_of_adults = $bookings->options['no_of_adults'];
			$booking->no_of_kids = $bookings->options['no_of_kids'];
			$booking->services = $bookings->options['services'];
			$booking->total_charges = $bookings->price;
			$booking->paid_amount = $bookings->options['paid_amount'];
			$booking->promo_code = $bookings->options['promo_code'];
			$booking->start_date = Session::get('start_date');
			$booking->end_date = Session::get('end_date');

			$booking->save();
			Cart::destroy();
		}

		return Redirect::to('booking/booking1')
							->with('message', 'booking has been sucessful');
		
	}

	public function getRemoveitem($identifier) {
	//Remove a booking from the cart
		
		$item = Cart::item($identifier);
		$item->remove();

		return Redirect::to('booking/cart');
	}

	//Search for bookings
	public function postSearch(){

		$uid = Input::get('id');
		$booking_id = Input::get('booking_id');

		if($uid != null){
			$booking = DB::table('bookings')
				->where('identification_no', '=', $uid)
				->first();
			if ($booking == null){
				return Redirect::to('admin/booking/search')
					->with('message', 'No such ID exists in bookings');
			}
			
		}elseif($booking_id != null){
			$booking = DB::table('bookings')
				->where('id', '=', $booking_id)
				->first();
			if ($booking == null){
				return Redirect::to('admin/booking/search')
					->with('message', 'No such ID exists in bookings');
			}
			
		}
	
		return Redirect::to('admin/booking/search')
			->with('booking_id', $booking->id)
			->with('identification_no', $booking->identification_no)
			->with('room_type_id', $booking->room_type_id)
			->with('no_of_rooms', $booking->no_of_rooms)
			->with('no_of_adults', $booking->no_of_adults)
			->with('no_of_kids', $booking->no_of_kids)
			->with('services', $booking->services)
			->with('total_charges', $booking->total_charges)
			->with('paid_amount', $booking->paid_amount)
			->with('check_in', $booking->check_in)
			->with('check_out', $booking->check_out);
		
	}

	//views the search page
	public function getSearch() {
		return View::make('booking.search');
	}


	public function getDestroy() {
		// display the booking delete page
		return View::make('booking.delete');
	}

	public function postDestroy() {
		// delete a booking

		$booking = Booking::find(Input::get('booking_id'));


		$transaction = DB::table('transactions')
					->where('booking_id',Input::get('booking_id'))
					->get();

		$policy = DB::table('policies')
					->where('description', "Cancellation")
					->get();

		$charge = floatval($booking->paid_amount);

		//calculating the date difference between today and the upcoming booking date
		$date_difference = strtotime($booking->start_date) - strtotime(date("Y-m-d h:i:s"));
		$no_of_days = $date_difference/(3600*24);

		

		$cancellation_details = json_decode($policy[0]->variables);
		$cancellation_days = $cancellation_details->days;
		$cancellation_rate = $cancellation_details->policy;


		if($no_of_days < $cancellation_days) {

			$cancellation_charge = $charge*$cancellation_rate;

			$booking->paid_amount = $cancellation_charge;
			$booking->cancellation = 1;

			$booking->save();

			return Redirect::to('booking/destroy')
				->with('message', '50% of your paid amount has been charged due to late cancellation');
		} else {

			$cancellation_charge = 0;

			$booking->paid_amount = $cancellation_charge;
			$booking->cancellation = 1;

			$booking->save();

			return Redirect::to('booking/destroy')
				->with('message', 'Booking has been cancelled without a fee');
		}	
	}
}