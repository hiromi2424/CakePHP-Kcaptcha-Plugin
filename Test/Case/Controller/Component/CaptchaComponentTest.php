<?php

App::uses('Controller', 'Controller');

class KcaptchaTestController extends Controller {
	 public $components = array(
	 	'Kcaptcha.Captcha' => array(),
	 	'Session',
	 );
	 public $uses = array('KcaptchaTestModel');

	public function header() {
	}

	protected function _stop() {
	}

}

class KcaptchaTestModel extends CakeTestModel {
	public $useTable = false;
}

class KcaptchaTestModel2 extends KcaptchaTestModel {
	public $useTable = false;
}


class CaptchaComponentTestCase extends CakeTestCase {

	public $Controller;
	public $Component;
	public $Model;

	public $sessionKey = 'KcaptchaTest.answer';

	public function startTest($method = null) {
		$this->_loadController();
		parent::startTest($method);
	}

	public function endTest() {
		$this->_loadController();
		$this->Controller->Session->delete($this->sessionKey);
		$this->_reset();
	}

	protected function _reset() {
		unset($this->Controller);
		unset($this->Component);
		unset($this->Model);
		ClassRegistry::flush();
	}

	protected function _loadController($componentSettings = array(), $initialize = true) {
		$this->_reset();

		$this->Controller = new KcaptchaTestController;

		$default = array(
			'sessionKey' => $this->sessionKey,
		);
		$this->Controller->components['Kcaptcha.Captcha'] = $componentSettings + $default;

		if ($initialize) {
			$this->_initializeController();
		}
	}

	protected function _render() {
		ob_start();
		$this->Component->render();
		$result = ob_get_contents();
		ob_end_clean();
		header("Content-Type:");
		return $result;
	}

	protected function _initializeController() {
		$this->Controller->constructClasses();
		$this->Controller->Components->trigger('initialize', array(&$this->Controller));
		$this->Component = $this->Controller->Captcha;
		if ($this->Component->model !== null) {
			$this->Model = ClassRegistry::init($this->Component->model);
		}
	}

	public function testStartup() {
		$this->Component->startup($this->Controller);
		$this->assertTrue($this->Model->Behaviors->attached('Captchable'));
		$this->assertNull($this->Model->captchaAnswer);
		$this->assertTrue(in_array('Kcaptcha.Captcha', $this->Controller->helpers));

		$this->_loadController(array('autoSetAnswer' => false));
		$this->Component->startup($this->Controller);
		$this->assertFalse($this->Model->Behaviors->attached('Captchable'));
		$this->assertFalse(isset($this->Model->captchaAnswer));

		$this->_loadController(array('model' => 'KcaptchaTestModel2'));
		$this->Component->startup($this->Controller);
		$this->assertIsA($this->Model, 'KcaptchaTestModel2');
		$this->assertTrue($this->Model->Behaviors->attached('Captchable'));
		$this->assertNull($this->Model->captchaAnswer);

		$this->_loadController();
		$this->Controller->Session->write($this->sessionKey, 'hogehoge');
		$this->Component->startup($this->Controller);
		$this->assertTrue($this->Model->Behaviors->attached('Captchable'));
		$this->assertEqual('hogehoge', $this->Model->captchaAnswer);

		$this->_loadController(array('autoSetAnswer' => false));
		$this->Controller->Session->write($this->sessionKey, 'hogehoge');
		$this->Component->startup($this->Controller);
		$this->assertFalse(isset($this->Model->captchaAnswer));
	}

	public function testRender() {
		$this->Component->startup($this->Controller);
		$result = $this->_render();
		$this->assertFalse(empty($result));
		$sessionData = $this->Controller->Session->read($this->sessionKey);
		$this->assertTrue(is_string($sessionData));
		$this->assertPattern('/^[0-9a-zA-Z]+$/', $sessionData);

		$this->_loadController();
		$this->Component->startup($this->Controller);
		$this->assertEqual($sessionData, $this->Model->captchaAnswer);
	}

	public function testClearSession() {
		$this->_loadController();
		$this->Component->startup($this->Controller);
		$result = $this->_render();
		$this->assertNotNull($this->Controller->Session->read($this->sessionKey));
		$this->Component->clearSession();
		$this->assertNull($this->Controller->Session->read($this->sessionKey));
	}

}