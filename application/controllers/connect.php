<?php
	
class Connect_Controller extends Base_Controller {

	public function action_session($provider) {

	    Bundle::start('laravel-oauth2');

	    $provider = OAuth2::provider($provider, array(
	        'id' => '234422449911218',
	        'secret' => '8d29175a3e29c3e354c4fa4d514d7a08',
	    ));

	    if ( ! isset($_GET['code'])) {
	        
	        return $provider->authorize();

	    }
	        
        try {

            $params = $provider->access($_GET['code']);

            $token = new OAuth2_Token_Access(array('access_token' => $params->access_token));
            $user_oauth = $provider->get_user_info($token);

            $user = User::where('email', '=', $user_oauth['email'])->first();

            if (!$user) {

            	$user = new User();
                $user->name     = $user_oauth['name'];
                $user->username = $user_oauth['nickname'];
                $user->email    = $user_oauth['email'];
                $user->save();

            }

            \Auth::login($user->id);
            return Redirect::to('dashboard');

        }

        catch (OAuth2_Exception $e) {
            show_error('That didnt work: '.$e);
        }
	    
	}

}