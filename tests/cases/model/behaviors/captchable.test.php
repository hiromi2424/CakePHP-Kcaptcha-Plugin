<?php
/* Captchable Test cases generated on: 2010-11-24 13:11:13 : 1290571993*/

class CaptchableBehaviorMockModel extends CakeTestModel {
	
}

class CaptchableBehaviorTestCase extends CakeTestCase {
	function startTest() {
		$this->Model =& ClassRegistry::init('CaptchableBehaviorMockModel');
		$this->Model->attach('Kcaptcha.Captchable');
	}

	function endTest() {
		unset($this->Model);
		ClassRegistry::flush();
	}

}

