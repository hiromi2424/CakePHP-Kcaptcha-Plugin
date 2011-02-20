<?php

class KcaptchaTestController extends Controller {
	 var $components = array(
	 	'Kcaptcha.Captcha' => array(),
	 	'Session',
	 );
	 var $uses = array('KcaptchaTestModel');

	function header() {
	}

	function _stop() {
	}

}

class KcaptchaTestModel extends CakeTestModel {
	var $useTable = false;
}

class KcaptchaTestModel2 extends KcaptchaTestModel {
	var $useTable = false;
}


class CaptchaComponentTestCase extends CakeTestCase {

	var $Controller;
	var $Component;
	var $Model;

	var $sessionKey = 'KcaptchaTest.answer';

	function startTest($method = null) {
		$this->_loadController();
		parent::startTest($method);
	}

	function endTest() {
		$this->_loadController();
		$this->Controller->Session->delete($this->sessionKey);
		$this->_reset();
	}

	function _reset() {
		unset($this->Controller);
		unset($this->Component);
		unset($this->Model);
		ClassRegistry::flush();
	}

	function _loadController($componentSettings = array(), $initialize = true) {
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

	function _render() {
		ob_start();
		$this->Component->render();
		$result = ob_get_contents();
		ob_end_clean();
		header("Content-Type:");
		return $result;
	}

	function _initializeController() {
		$this->Controller->constructClasses();
		$this->Controller->Component->initialize($this->Controller);
		$this->Component =& $this->Controller->Captcha;
		if ($this->Component->model !== null) {
			$this->Model =& ClassRegistry::init($this->Component->model);
		}
	}

	function testStartup() {
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

	function testRender() {
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