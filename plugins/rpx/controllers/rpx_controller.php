<?php

class RpxController extends RpxAppController {

/**
 *
 */

    public function index() {
		if(isset($_GET['token'])) { 
			$auth_info = $this->Rpx->getAuthInfo($_GET['token']);
			if ($auth_info['stat'] == 'ok') {
				$this->data = $auth_info['profile'];
				$this->testUser($auth_info['profile']['verifiedEmail']);
			} else {
				echo '<b>Error:</b> ' . $auth_info['err']['msg'];
			}
		}
		$siteName = $this->Rpx->getSiteName();
		$this->set(compact('siteName'));
    }

/**
 * check if account exists
 */

    private function testUser($email) {
		$verifiedEmails = Configure::read('Shop.email');
		if(in_array($email, $verifiedEmails)) {
			$this->Session->write('admin', 1);
			$this->BsRedirect('Logged in');
		} else {
			die('Not a valid email address');
		}
    }

}
?>