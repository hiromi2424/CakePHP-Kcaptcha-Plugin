<?php

require_once dirname(__FILE__) . DS . 'KcaptchaGroupTestCase.php';

/**
 * View Group Test for Kcaptcha
 *
 * PHP versions 5
 *
 **/
/**
 * AllDebugKitTest class
 *
 */

class AllKcaptchaTest extends KcaptchaGroupTestCase {
/**
 *
 *
 * @return PHPUnit_Framework_TestSuite the instance of PHPUnit_Framework_TestSuite
 */
	public static function suite() {
		$suite = new self;
		$files = $suite->getTestFiles();
		$suite->addTestFiles($files);

		return $suite;
	}
}