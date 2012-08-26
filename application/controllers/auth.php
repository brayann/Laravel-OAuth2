<?php

class Auth_Controller extends Base_Controller {
	
	function action_index() {

		if (Auth::check()) {

			return 'Hello, ' . Auth::user()->name . '. ' . HTML::link('auth/logout', 'Logout');;

		} else {

			return HTML::link('connect/session/facebook', 'Login with Facebook');;

		}

	}

	function action_logout() {

		Auth::logout();

	}

}