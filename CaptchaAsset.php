<?php
/**
 * CoinHive captcha asset manager.
 *
 * @author MaximAL
 * @since 2017-09-20
 * @date 2017-09-20
 * @time 10:44
 * @copyright © MaximAL, Sijeko 2017
 */

namespace maximal\coinhive;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the javascript files needed for the [[Captcha]] widget.
 *
 * @see \maximal\coinhive\Captcha - CoinHive Captcha widget
 * @see https://coinhive.com/documentation/captcha
 *
 * @package maximal\coinhive
 * @author MaximAL
 * @date 2017-09-20
 * @see https://maximals.ru
 */
class CaptchaAsset extends AssetBundle
{
	public $js = [
		['https://coinhive.com/lib/captcha.min.js', 'async' => true],
	];
}
