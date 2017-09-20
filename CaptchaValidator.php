<?php
/**
 * CoinHive captcha validator.
 *
 * @author MaximAL
 * @since 2017-09-20
 * @date 2017-09-20
 * @time 10:45
 * @copyright © MaximAL, Sijeko 2017
 */

namespace maximal\coinhive;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\validators\Validator;

/**
 * CoinHive captcha validator class.
 *
 * @see \maximal\coinhive\Captcha - CoinHive Captcha widget
 * @see https://coin-hive.com/documentation/captcha
 *
 * @package maximal\coinhive
 * @author MaximAL
 * @date 2017-09-20
 * @see https://maximals.ru
 */
class CaptchaValidator extends Validator
{
	/**
	 * Your private Secret-Key.
	 * @see https://coin-hive.com/settings/sites
	 * @var string
	 */
	public $secretKey = '';

	/**
	 * @var bool Whether to skip this validator if the input is empty.
	 */
	public $skipOnEmpty = false;

	/**
	 * @var string CoinHive API URL
	 */
	protected $url = 'https://api.coin-hive.com/token/verify';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		if ($this->message === null) {
			$this->message = Yii::t('yii', 'The verification code is incorrect.');
		}

		if ($this->secretKey === '') {
			throw new InvalidConfigException(
				'Secret key `' . $this->secretKey . '` is invalid. ' .
				'Go to https://coin-hive.com/settings/sites and get your secret key.'
			);
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function validateValue($value)
	{
		$data = [
			'secret' => $this->secretKey,
			'token' => Yii::$app->request->post('coinhive-captcha-token', null),
			'hashes' => $value,
		];

		$postContext = stream_context_create([
			'http' => [
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			]
		]);

		$response = Json::decode(file_get_contents($this->url, false, $postContext));

		if ($response && $response['success']) {
			return null;
		}

		// invalid_secret
		// missing_input
		// invalid_token
		// ...
		if ($response['error'] !== 'invalid_token') {
			$this->message = 'CoinHive captcha error: ' . $response['error'];
		}

		return [$this->message, []];
	}
}
