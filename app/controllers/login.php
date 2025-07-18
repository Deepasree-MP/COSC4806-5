<?php

class Login extends Controller {

		public function index() {		
				session_start(); 
				$this->view('login/index');
		}

		/*public function verify(){
				$username = $_REQUEST['username'];
				$password = $_REQUEST['password'];

				$user = $this->model('User');
				$user->authenticate($username, $password); 
		}*/

	public function verify() {
		session_start();

		$username = $_POST['username'];
		$password = $_POST['password'];

		$user = $this->model('User');
		$authUser = $user->authenticate($username, $password);

		if ($authUser) {
			$_SESSION['auth'] = 1;
			$_SESSION['username'] = ucwords($username);
			$_SESSION['role'] = $authUser['role'] ?? 'user';
			$_SESSION['just_logged_in'] = true;

			$user->increment_login_count($username);
			$user->record_successful_login($authUser['id'], $username);

			unset($_SESSION['failedAuth']);
			header('Location: /home');
			die;
		} else {
			if (!isset($_SESSION['failedAuth'])) {
				$_SESSION['failedAuth'] = 1;
			} else {
				$_SESSION['failedAuth']++;
			}

		
			$user->record_failed_login($username);

			$_SESSION['error_message'] = "This is unsuccessful attempt number " . $_SESSION['failedAuth'];
			header('Location: /login');
			die;
		}
	}
}
