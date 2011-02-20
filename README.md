# CakePHP Kcaptcha Plugin #

This is a CakePHP plugin to use kcaptcha easily.

## Requirements

PHP >= 4
CakePHP >= 1.3

## Installation

in your plugins directory,

	git clone git://github.com/hiromi2424/CakePHP-Kcaptcha-Plugin.git kcaptcha

or in current directory of your repository,

	git submodule add git://github.com/hiromi2424/CakePHP-Kcaptcha-Plugin.git plugins/kcaptcha

## Usage

Setup Captcha component to your controller:


	<?php
	
	class PostController extends AppController {
	
		public $components = array(
			'Kcaptcha.Captcha',
		);
	}


Use Captcha helper(automatically set by the component) in your view:

	<?php
		echo $this->Captcha->render();
		echo $this->Form->input('captcha');
	?>

Simply that is all! Your Model will validate user's input for the captcha.

for more options, you would see the test case.

## License

Licensed under The MIT License.
Redistributions of files must retain the above copyright notice.


Copyright 2011 hiromi, https://github.com/hiromi2424

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.