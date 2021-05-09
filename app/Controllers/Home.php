<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Home extends BaseController
{
	private $facebook=NULL;
	private $fb_helper=NULL;
	function __construct(){
		require_once APPPATH. 'Libraries/vendor/autoload.php';
		$this->facebook =  new \Facebook\Facebook([
			'app_id'  => 'APP ID',
			'app_secret'  => 'APP SECRET KEY',
			'default_graph_version' => 'v2.3'
		]);
		$this->fb_helper = $this->facebook->getRedirectLoginHelper();
	}
	public function index()
	{
		if(session()->has('LoggedUser')){
			session()->setFlashData('error', 'You have already Logged in');
			return redirect()->to(base_url()."/profile");
		}
		$fb_permission = ['email'];
		$data['fb_btn'] = $this->fb_helper->getLoginUrl('http://localhost/login_with_fb/authWithFB?', $fb_permission);
		return view('login', $data);
	}
	public function profile()
	{
		if(!session()->has('LoggedUser')){
			session()->setFlashData('error', 'Session is Expired, Please Login Again');
			return redirect()->to(base_url());
		}
		return view('profile');
	}
	public function authWithFB()
	{
		if($this->request->getVar('state')){
			$this->fb_helper->getPersistentDataHandler()->set('state', $this->request->getVar('state'));
		}

		if($this->request->getVar('code')){
			if(session()->get("access_token")){
				$access_token = session()->get('access_token');
			}else{
				$access_token = $this->fb_helper->getAccessToken();
				session()->set("access_token", $access_token);
				$this->facebook->setDefaultAccessToken(session()->get('access_token'));
			}
			$graph_response = $this->facebook->get('/me?field=name,email', $access_token);
			$fb_user_info = $graph_response->getGraphUser();
			//print_r($fb_user_info);die;
			if(!empty($fb_user_info)){
				$fbdata = array(
					'authid'=>$fb_user_info['id'],
					'profile_pic' => 'http://graph.facebook.com/'.$fb_user_info['id'].'/picture',
					'user_name' => $fb_user_info['name']
				);

				//here you can insert user data in database
				
				session()->set('LoggedUser', $fbdata);
			}
		}else{
			session()->setFlashData('error', 'Something Wrong');
			return redirect()->to(base_url());
		}
		return redirect()->to(base_url().'/profile');
	}
	public function logout()
	{
		if(session()->has('LoggedUser')){
			session()->remove('LoggedUser');
			session()->setFlashData('success', 'Logout Successful');
			return redirect()->to(base_url());
		}else{
			session()->setFlashData('error', 'Failed to Logout, Please Try again...');
			return redirect()->to(base_url().'/profile');
		}
	}
}
