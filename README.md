# CakePHP Kcaptcha Plugin #

This is a CakePHP plugin to use kcaptcha easily.

## Requirements

- PHP >= 4
- CakePHP >= 1.3

## Installation

In your plugins directory,

	git clone git://github.com/hiromi2424/CakePHP-Kcaptcha-Plugin.git kcaptcha

Or in current directory of your repository,

	git submodule add git://github.com/hiromi2424/CakePHP-Kcaptcha-Plugin.git plugins/kcaptcha

If you want to use your kcaptcha library(maybe for your config file), put the files into `vendors/kcaptcha`.

## Usage

Setup Captcha component to your controller:


	<?php
	
	class PostsController extends AppController {
	
		public $components = array(
			'Kcaptcha.Captcha',
		);
	}


Use Captcha helper(automatically set by the component) in your form. For example:

	<?php
		echo $this->Form->create('Post');
		echo $this->Form->input('body');
		echo $this->Captcha->render();
		echo $this->Form->input('captcha');
		echo $this->Form->end('Submit');
	?>

Simply it's done! Your Post model will validate user's input for the captcha.

See following API reference for more options or any custom features.

### API reference

#### Captcha component

Component's settings are:

- `$sessionKey` - `string` session key for captcha. you should create the action for render if this was changed. default is `'Kcaptcha.answer'`.
- `$model` - `string` name of a model to validate. default is controller's `$modelClass`.
- `$setupHelper` - `boolean` whether the helper automatically added. default is `true`.
- `$autoSetAnswer` - `boolean` whether the answer automatically set to the model. default is `true`.

Component's methods:

- `render()` - to render the captcha. this will output header and body for captcha image.
- `clearSession()` - to clear the session data for answer of captcha. you don't need to call this but can use if you want to banish.

#### Captchable behavior

Behavior's settings are:

- `$answerProperty` - `string` the model property that the answer is automatically set on. default is `'captchaAnswer'`.
- `$field` - `string` the field to vlidate. default is `'captcha'`.
- `$rule` - `string` the rule set name to validate. default is `'captcha'`.
- `$convertKana` - `boolean` if `true`, multi-byte of user input will be converted to single-byte. default is `true`.
- `$trim` - `mixed` whether user input will be trimmed, otherwise regexp of spaces. default is regexp that multi-byte spaces(PCRE).
- `$required` - `boolean` whether the answer is required. you can also turn on or off with `requireCaptcha()`. default is `true`.
- `$setupValidation` - `boolean` whether basic validation set for captcha is automatically set to your model. default is `true`.

Behavior's methods:

- `setupCaptchaValidation()` - to set basic validation set. see `$setupValidation` property.
- `setCaptchaAnswer()` - to set the answer for captcha. used by Captcha component's `startup()`.
- `requireCaptcha($yes = boolean)` - determine whether answer is required.
- `validCaptcha($input)` - to validate the answer for captcha.

#### Captcha helper

There is only `render($url[optional])` method.

This will show this plugin's `Captcha` controller's `render_captcha` action with `<img>` tag by default.

You should specify the `$url` to your controller's action if you had to use `CaptchaComponent::render()` in the action.

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
