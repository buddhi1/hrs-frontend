<?php

class PolicyController extends BaseController {
	
	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	public function getIndex() {
		// show all the policies available

		return View::make('policy.view')
			->with('policies', Policy::all());
	}

	public function postCreate() {
		// create a new policy

		$policy = new Policy();

		$policy->description = Input::get('description');
		$policy->variables = Input::get('variables');

		if($policy) {
			$policy->save();
			return Redirect::To('admin/policy')
				->with('policy_message_add', 'Policy has been successfully added');
		}
	}

	public function postEdit() {
		//Show the edit page for the policy

		return View::make('policy.edit')
			->with('policies', Policy::find(Input::get('id')));
	}

	public function postUpdate() {
		// Edit a new policy

		$policy = Policy::find(Input::get('id'));

		$policy->description = Input::get('description');
		$policy->variables = Input::get('variables');



		if($policy) {
			$policy->save();
			return Redirect::To('admin/policy')
				->with('policy_message', 'Policy has been successfully Updated');
		}
	}
}