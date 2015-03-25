<?php
/*
	Name:		CalendarController
	Purpose:	Controllers for Room_price_Calendar

	History:	Created 26/02/2015 by buddhi ashan	 
*/

class CalendarController extends BaseController {

	public function __construct(){
		$this->beforeFilter('csrf',array('on'=>'post'));
		$this->beforeFilter('user_group');
	}

	//Views the create Room_price_Calendar form
	
	public function getCreate(){
		return View::make('calendar.create')
			->with('roomTypes', RoomType::lists('name', 'id'))
			->with('services', Service::lists('name', 'id'));
	}

	//Posts the create form details to database

	public function postCreate(){

		//read from date
		$date = Input::get('from');	

		$room_type_id = Input::get('roomType');
		$service_id = Input::get('service');

		//check for availability of date range for selected room type and service type
		$fdate = DB::table('room_price_calenders')
			->where('start_date','=',$date)
			->where('room_type_id','=',$room_type_id)
			->where('service_id','=',$service_id)
			->get();

		//if such date range does not exist for the selected room type and service type
		if(!$fdate){
			//convert from date to dateTime format
			$from = new DateTime($date );
			//convert to date to dateTime format
			$to = new DateTime(Input::get('to'));

			//finds the days between from and to dates
			$days = $to->diff($from)->format("%a");		
			
			//loop inserts new rows for all days between from and to dates
			for ($i=0; $i <= $days; $i++) { 
				$calendar = new Calendar;
				$calendar->room_type_id = $room_type_id;
				$calendar->service_id = $service_id;
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime(Input::get('to'));
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}	
				
				return Redirect::to('admin/calendar/create')
					->with('message', 'Calendar record has been added successfully');		
			
			}
			//if the given date range existing for the selected room type and service type
			else{
					return Redirect::to('admin/calendar/create')
					->with('message', 'Calendar records overlapping for given date range. Please refer to edit time line');
				}		

		
	}

	//Views the user Room_price_Calendar page

	public function getIndex(){
		return View::make('calendar.index')
			->with('start_date', DB::table('room_price_calenders')->orderBy('start_date')->pluck('start_date'))
			->with('end_date', DB::table('room_price_calenders')->orderBy('start_date', 'desc')->pluck('start_date'))
			->with('rooms', DB::table('room_price_calenders')->select('id','room_type_id','service_id')->groupBy('service_id','room_type_id')->get())
			->with('calendar', DB::table('room_price_calenders')->select(DB::raw('count(*) as days'),'id','room_type_id','end_date','price','discount_rate',
				'service_id','start_date')->groupBy('end_date','room_type_id','service_id')->get());
	}

	//Views edit page for selected record
	public function postEdit(){
		return View::make('calendar.edit')
			->with('record', Calendar::find(Input::get('id')));
	}

	//Views edit time line page for selected record
	public function postEdittimeline(){

		$room_type_id = Input::get('room_id');
		$service_id = Input::get('service_id');

		$start = DB::table('room_price_calenders')
					->where('room_type_id','=',$room_type_id)
					->where('service_id','=',$service_id)
					->orderBy('start_date')
					->first();
		$end = DB::table('room_price_calenders')
					->where('room_type_id','=',$room_type_id)
					->where('service_id','=',$service_id)
					->orderBy('start_date', 'DESC')
					->first();
		return View::make('calendar.edittimeline')
			->with('room_type_id', $room_type_id)
			->with('service_id', $service_id )
			->with('start', $start)
			->with('end', $end);
	}

	//edit function for selected record
	public function postUpdate(){

			DB::table('room_price_calenders')
				->where('room_type_id','=',Input::get('room_id'))
				->where('service_id','=',Input::get('service'))
				->where('end_date','=', Input::get('to'))
				->update(['price'=>Input::get('price'),
							'discount_rate'=>Input::get('discount')]);

			return Redirect::to('admin/calendar/index')
				->with('message', 'Calendar record has been update successfully');			
		
	}	

	//edit function for selected time line
	public function postUpdatetimeline(){

		$top_date = Input::get('sdate');
		$bottom_date = Input::get('edate');
		$from_date = Input::get('from');
		$to_date = Input::get('to');

		//reads the end date of editing time line block
		$end_date = DB::table('room_price_calenders')
			->where('start_date','=',$from_date)
			->where('room_type_id','=',Input::get('room_id'))
			->where('service_id','=',Input::get('service_id'))
			->get();

		//replacing existing time line with a single price and discount

		if($top_date >= $from_date && $bottom_date <= $to_date){

			//deletes ovelapping records
			DB::table('room_price_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('service_id','=',Input::get('service_id'))
			->delete();

			//read from date
			$date = Input::get('from');	

			//convert from date to dateTime format
			$from = new DateTime($date );
			//convert to date to dateTime format
			$to = new DateTime(Input::get('to'));

			//finds the days between from and to dates
			$days = $to->diff($from)->format("%a");		
			
			//loop inserts new rows for all days between from and to dates
			for ($i=0; $i <= $days; $i++) { 
				$calendar = new Calendar;
				$calendar->room_type_id = Input::get('room_id');
				$calendar->service_id = Input::get('service_id');
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime($to_date);
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}

			return Redirect::to('admin/calendar/index')
				->with('message', 'Calendar record has been update successfully');	
		}

		//replacing existing block(s) in time line
		elseif($top_date < $from_date || $bottom_date > $to_date){

			

			//deletes ovelapping records
			DB::table('room_price_calenders')
				->where('room_type_id','=',Input::get('room_id'))
				->where('service_id','=',Input::get('service_id'))
				->where('start_date','>=',$from_date)
				->where('start_date','<=',$to_date)
				->delete();
			//read from date
			$date = Input::get('from');	

			//convert from date to dateTime format
			$from = new DateTime($date );
			//convert to date to dateTime format
			$to = new DateTime(Input::get('to'));

			//finds the days between from and to dates
			$days = $to->diff($from)->format("%a");		
			
			//loop inserts new rows for all days between from and to dates
			for ($i=0; $i <= $days; $i++) { 
				$calendar = new Calendar;
				$calendar->room_type_id = Input::get('room_id');
				$calendar->service_id = Input::get('service_id');
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime($to_date);
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}


			//change end_dates of existing block 
			DB::table('room_price_calenders')
				->where('room_type_id','=',Input::get('room_id'))
				->where('service_id','=',Input::get('service_id'))
				->where('start_date','<',$from_date)
				->where('end_date','=', $end_date[0]->end_date)
				->update(['end_date'=>date('Y-m-d', strtotime($from_date.' -1 day'))]);

			return Redirect::to('admin/calendar/index')
				->with('message', 'Calendar record has been update successfully!!!');
		}else{
			if($top_date = $from_date){
				//deletes ovelapping records
				DB::table('room_price_calenders')
					->where('room_type_id','=',Input::get('room_id'))
					->where('service_id','=',Input::get('service_id'))
					->where('start_date','=',$top_date)
					->delete();
			}
			if ($bottom_date = $to_date) {
				//deletes ovelapping records
				DB::table('room_price_calenders')
					->where('room_type_id','=',Input::get('room_id'))
					->where('service_id','=',Input::get('service_id'))
					->where('start_date','=',$bottom_date)
					->delete();

				//change end_dates of existing block 
				DB::table('room_price_calenders')
					->where('room_type_id','=',Input::get('room_id'))
					->where('service_id','=',Input::get('service_id'))
					->where('end_date','=', $to_date)
					->update(['end_date'=>date('Y-m-d', strtotime($to_date.' -1 day'))]);
			}

			//read from date
			$date = Input::get('from');	

			//convert from date to dateTime format
			$from = new DateTime($date );
			//convert to date to dateTime format
			$to = new DateTime(Input::get('to'));

			//finds the days between from and to dates
			$days = $to->diff($from)->format("%a");		
			
			//loop inserts new rows for all days between from and to dates
			for ($i=0; $i <= $days; $i++) { 
				$calendar = new Calendar;
				$calendar->room_type_id = Input::get('room_id');
				$calendar->service_id = Input::get('service_id');
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime($to_date);
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}

			return Redirect::to('admin/calendar/index')
				->with('message', 'Calendar record has been update successfully!!!');

		}

	
		return Redirect::to('admin/calendar/index')
				->with('message', 'Something went wrong');	
	}

	//deletes selected calendar record
	public function postDestroy(){
		
		DB::table('room_price_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('service_id','=',Input::get('service_id'))
			->where('end_date','=',Input::get('date'))
			->delete();

		return Redirect::to('admin/calendar/index')
			->with('message','Record removed successfully');
	}


	//deletes selected time line
	public function postDestroytimeline(){

		DB::table('room_price_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('service_id','=',Input::get('service_id'))
			->delete();

		return Redirect::to('admin/calendar/index')
			->with('message','Time line removed successfully');
	}
}
