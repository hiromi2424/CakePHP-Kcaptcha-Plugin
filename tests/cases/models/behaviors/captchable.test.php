<?php
/* Captchable Test cases generated on: 2010-11-24 13:11:13 : 1290571993*/

class CaptchableBehaviorMockModel extends CakeTestModel {
	var $useTable = false;
}

class CaptchableBehaviorTestCase extends CakeTestCase {
	function startTest() {
		$this->Model =& ClassRegistry::init('CaptchableBehaviorMockModel');
		$this->Model->Behaviors->attach('Kcaptcha.Captchable');
	}

	function endTest() {
		unset($this->Model);
		ClassRegistry::flush();
	}

	function _reset($config = array()) {
		$this->endTest();
		$this->Model =& ClassRegistry::init('CaptchableBehaviorMockModel');
		$this->Model->Behaviors->attach('Kcaptcha.Captchable', $config);
	}

	function testSetupCaptchaValidation() {
		$expected = array(
			'captcha' => array(
				'captcha' => array(
					'rule' => array('validCaptcha'),
					'message' => __d('kcaptcha', 'Not same as shown captcha', true),
					'required' => true,
					'allowEmpty' => false,
				),
			),
		);
		$this->assertEqual($expected, $this->Model->validate);

		$this->_reset(array('setupValidation' => false));
		$this->Model->validate = array(
			'captcha' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'required' => true,
					'allowEmpty' => false,
					'last' => true,
				),
				'captcha' => array(
					'on' => 'update',
				),
			),
		);
		$this->Model->setupCaptchaValidation();
		$expected = array(
			'captcha' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'required' => true,
					'allowEmpty' => false,
					'last' => true,
				),
				'captcha' => array(
					'on' => 'update',
					'rule' => array('validCaptcha'),
					'message' => __d('kcaptcha', 'Not same as shown captcha', true),
					'required' => true,
					'allowEmpty' => false,
				),
			),
		);
		$this->assertEqual($expected, $this->Model->validate);

		$this->_reset(array('setupValidation' => false));
		$this->Model->validate = array(
			'captcha' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'required' => true,
					'allowEmpty' => false,
					'last' => true,
				),
			),
		);
		$this->Model->setupCaptchaValidation();
		$expected = array(
			'captcha' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'required' => true,
					'allowEmpty' => false,
					'last' => true,
				),
				'captcha' => array(
					'rule' => array('validCaptcha'),
					'message' => __d('kcaptcha', 'Not same as shown captcha', true),
					'required' => true,
					'allowEmpty' => false,
				),
			),
		);
		$this->assertEqual($expected, $this->Model->validate);
	}

	function testSetCaptchaAnswer() {
		$this->Model->setCaptchaAnswer('hogehoge');
		$this->assertTrue(isset($this->Model->captchaAnswer));
		$this->assertEqual('hogehoge', $this->Model->captchaAnswer);
	}

	function testRequireCaptcha() {
		$this->Model->validate = array();
		$this->Model->requireCaptcha();
		$expected = array(
			'captcha' => array(
				'captcha' => array(
					'required' => true,
					'allowEmpty' => false,
				),
			),
		);
		$this->assertEqual($expected, $this->Model->validate);

		$this->Model->requireCaptcha(false);
		$expected = array(
			'captcha' => array(
				'captcha' => array(
					'required' => false,
					'allowEmpty' => true,
				),
			),
		);
		$this->assertEqual($expected, $this->Model->validate);
	}

	function testValidCaptcha() {
		$this->assertFalse($this->Model->validCaptcha('was not set'));

		$this->Model->setCaptchaAnswer('hogehoge');
		$this->assertFalse($this->Model->validCaptcha('invalid'));
		$this->assertTrue($this->Model->validCaptcha('hogehoge'));

		$this->assertTrue($this->Model->validCaptcha('ｈｏｇｅｈｏｇｅ'));
		$this->assertTrue($this->Model->validCaptcha('　ｈｏｇｅｈｏｇｅ '));
		$this->Model->setCaptchaAnswer('1h2o3g4e');
		$this->assertTrue($this->Model->validCaptcha('　1ｈ2o３ｇ４e'));
	}

}

