<?php
/**
 * CoinHive captcha widget.
 *
 * @author MaximAL
 * @since 2017-09-20
 * @date 2017-09-20
 * @time 10:40
 * @copyright © MaximAL, Sijeko 2017
 */

namespace maximal\coinhive;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * CoinHive captcha class.
 *
 * @see https://coin-hive.com/documentation/captcha
 *
 * @package maximal\coinhive
 * @author MaximAL
 * @date 2017-09-20
 * @see https://maximals.ru
 */
class Captcha extends InputWidget
{
	/**
	 * Your public Site-Key.
	 * @see https://coin-hive.com/settings/sites
	 * @var string
	 */
	public $siteKey = '';

	/**
	 * @var int The number of hashes that have to be accepted by the mining pool.
	 * CoinHive pool uses a difficulty of 256, so your hashes goal should be a multiple of 256.
	 */
	public $hashes = 1024;

	/**
	 * @var bool Whether to automatically start solving the captcha. The default is `false`.
	 */
	public $autoStart = false;

	/**
	 * @var false|string A CSS selector for elements that should be disabled until the goal is reached.
	 * Usually this will be your form submit button.
	 */
	public $disableElements = '[type=submit]';

	/**
	 * @var null|string The name of a global JavaScript function that should be called when the goal is reached.
	 */
	public $callback = null;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();
		if ($this->siteKey === '') {
			throw new InvalidConfigException(
				'Website key `' . $this->siteKey . '` is invalid. ' .
				'Go to https://coin-hive.com/settings/sites and get your website key.'
			);
		}

		if ($this->hashes % 256 !== 0) {
			throw new InvalidConfigException(
				'The number of hashes `' . $this->hashes . '` is invalid. ' .
				'Your hashes count shoud be a multiple of 256 (256, 512, 768, 1024, 1280, etc).'
			);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		CaptchaAsset::register($this->getView());
		$input = str_replace('>', ' value="' . $this->hashes . '">', $this->renderInputHtml('hidden'));
		echo strtr(
			$input . PHP_EOL .
			'<div class="coinhive-captcha" data-key="{key}" data-hashes="{hashes}" data-autostart="{start}" data-disable-elements="{disable}" data-callback="{callback}"></div>',
			[
				'{key}' => Html::encode($this->siteKey),
				'{hashes}' => $this->hashes,
				'{start}' => $this->autoStart ? 'true' : 'false',
				'{disable}' => $this->disableElements ? Html::encode($this->disableElements) : '',
				'{callback}' => $this->callback ? Html::encode($this->callback) : '',
			]
		);
	}
}
