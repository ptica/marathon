<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

class AppController extends Controller {
	public $components = array(
		'Session',
		'Auth'
	);

	public $helpers = array(
		'Form' => array('className' => 'Bs3Helpers.Bs3Form'),
		'Html' => array('className' => 'Bs3Helpers.Bs3Html'),
	);

	public function beforeFilter() {
		/**
		 * AUTHORIZATION
		 */
		$this->Auth->authenticate = array(
			'Form' => array(
				'passwordHasher' => 'Blowfish'
			)
		);
		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action' => 'login',
			'plugin' => false,
			'admin' => false
		);
		$this->Auth->loginRedirect = array(
			'controller' => 'rooms',
			'action' => 'index',
			'admin' => true
		);
		$this->Auth->logoutRedirect = array(
			'controller' => 'users',
			'action' => 'login',
			'admin' => false
		);

		/**
		 * LAYOUT
		 */
		if (
			$this->request->url == 'users/login' ||
			in_array($this->params['prefix'], array('admin'))
		) {
			Configure::write('Routing.admin', true);
		}
		$this->layout = 'marathon';
	}

	protected function set_request_scheme() {
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
			$_SERVER['REQUEST_SCHEME'] = 'https';
		} else {
			$_SERVER['REQUEST_SCHEME'] = 'http';
		}
	}
}
