<?php

App::import('Controller', 'Kcaptcha.Captcha');

class TestCaptchaController extends CaptchaController {

	public function header() {
	}

	protected function _stop() {
	}

}


class CaptchaControllerTestCase extends CakeTestCase {

	public function startTest() {
		$this->Controller = new TestCaptchaController;
		$this->Controller->request->params['action'] = 'render_captcha';
	}

	public function endTest() {
		$this->Controller->Captcha->Session->delete('Kcaptcha.answer');
		unset($this->Controller);
		ClassRegistry::flush();
	}

	protected function _render() {
		ob_start();
		$this->Controller->render_captcha();
		$result = ob_get_contents();
		ob_end_clean();
		header("Content-Type:");
		return $result;
	}

	public function testRenderCaptcha() {
		$this->Controller->constructClasses();
		$this->Controller->startupProcess();
		$result = $this->_render();
		$this->assertFalse(empty($result));
		$sessionData = $this->Controller->Captcha->Session->read('Kcaptcha.answer');
		$this->assertFalse(empty($sessionData));
	}

	public function testRenderCaptchaWithAuth() {
		$this->Controller->components[] = 'Auth';
		$this->Controller->constructClasses();
		$this->Controller->startupProcess();
		$result = $this->_render();
		$this->assertFalse(empty($result));
		$sessionData = $this->Controller->Captcha->Session->read('Kcaptcha.answer');
		$this->assertFalse(empty($sessionData));
	}

}