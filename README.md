# CoinHive captcha for Yii2

This widget implements CoinHive proof-of-work captcha for your Yii2 web application.
From a website owner’s perspective the CoinHive captcha works exactly like a conventional captcha,
such as Google’s reCaptcha.

The captcha is embeded as a usual Yii2 widget for ActiveForm with any of your model.
User client side generates a token. The token is submitted together with the other form data.
Then bundled captcha validator confirms this token on your server through CoinHive HTTP API.

Unlike with a conventional captcha however, the user does not have to “proof they’re human”.
Instead, the captcha is a “proof of work” — making it uneconomic for spammers to game your system.

![GIF demo](https://user-images.githubusercontent.com/980679/30642361-37e2b8d8-9e13-11e7-8e3c-0580028435cb.gif)


## Links

* https://coinhive.com/documentation/captcha — CoinHive captcha documentation;
* http://www.yiiframework.com — Yii framework;
* https://maximals.ru — widget author’s website (Russian).
