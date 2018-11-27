<?php 

return [

	//阿里支付宝
	'alipay'=>[
		'app_id'=>'2016082100306675',	//appid
		'notify_url'=>'http://www.bb.cc/notify_url',
		'return_url'=>'http://www.bb.cc/return_url',
		'ali_public_key'=>'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtupSzTt+qFZ95MSYl1PRHwiYzBKggOI6UxaRQ+L4znuulPHcf2TXJf3PNGefUMrVdhUQI+Y4GmHjwc39vzqg5I3Rlip7R0+Zi/YpPlPt1sPt5aRgfX+HUSVvckXV0fFvFVfkv9iF9Cn+yJh88u0BgtNpRKVamtV6UgUVpwRDaF6hEvdXfbiHsj9Q6oTVBs7DAe3mFj4GGjtP2pZLc/Tf91dm95BJLIrSOwJ1qk7nGqxvo4i+EOXS9m9YUHF6pRStsL6Vr7Y6q0NqzevUfcQkhEplgQuQSvfUkK6tQPPAAZh66E+JLlaeufD5yIusHGYLdiTx0Oh9wG5ICUToB05ctwIDAQAB',
		'private_key'=>'MIIEpAIBAAKCAQEAlev4e7EsWgjYviZuWqHkXCI37ks90O+HBOrt0dvlRup9evx5MQoNBs0wu30M4yuD8Oz6Qb8mBvbL953Mxh5fXayi+l0rxV2I/oshmA2EJBZnc2xQY1hoOXs1NW7Fdk/FJfIwUpmCKekUwGco3hEYfau7ZqWDVPFOWYiInTtVrFnA+SYdZcgND9NASQLzXDcEs1mACqAxj+FJz9a8Bbo4sbn0nTpd5OFgj/F87e/Oh29weKjXrH5WzRWsYIRbXKCciddkjHGX4ZQC2/qpbhcfV+uJxwWUKkhPRKLZrnmsxtcOLCot2AQDh16O+GYBwAYh13iZw8sUh74mwAMHfaCjJwIDAQABAoIBAExMSCxjEahMgknbcyQK6hX9kCtk/XO8wyE8koXP/FJn+i5CGUdczx5cBOYWER33wnE1mXMmXasDpPBCzbkyMeSRfGwgSKtsG9E3a4RftJVNFZ8HS64Tiw9d5clos3OvyyyxoegXmcfMiDQXDBRf7O/gG0J1D26GVBJ6ytQCI2rPh15NJWgTycqyq4pb08T6682QeUWZxXugTrt0QQh51gdtPptwpaMyi38IBn+myU8aXEj92TjKBnH/klnio2Sn5sG+rx1nzOGTZqYoBZXuy4QGprIKK2BoSr2mU4Yk8B3oF+WPbB0/+BMGo2EqOSkOHyTvq7AX+qpMHRFjt8rPZLECgYEAxRHY0JmooCzB96cUmGUkiV+5GpVbNN4ldnR7kizxiP3UDvEuj9F+LW8CYhEcLeP9pxQBhYIaH23rxKwm8so2sgLGUkVLp2g/cllFKcCphkXVtlXvotQxPBONlsUwLSnT+doYwRKEFOHgTZNguhPIab3ruUzWO2Yp38XInguPVU8CgYEAwsDWEksO5quCR7oDjdMD5HBC+MPhnqqsgqLA4fvDFkiL+o83EDdqLdfvrye6uoNo222GgbXSevY1i814r1pVoG5q2EQaCFGZlKK9wnBlw/hg+ocRvbTmbTuur16oKHebm5xw4SozhzBWRVNyZFijP63LuAJSkUlg02V2vV15DqkCgYEAvExdOpRXxxR9EcEXsLWTv58zIu9rAozwhsqt9/Hxp8/A+7X/o3OseIUFZearYj3ic+5ttb+mbjl9eaJ0ZLBKqrR0AtArhX3agcxCha6NTLsVhO9/1bmigaC9PT6U1dKNtMJrvK+QfNOGmxki5ylX6ZGK1rdQS9lGUYaONlUdU4kCgYEAoQES+SScOQ7pMasSbRlaSmyUsVwfFjE7VPSASVL9wVpQfuAPQZTObv/p4wARW0hwU5eEb4+FZqpNMjq33x/rUip2ojwK2X28Xij8f9a0CwM4CWXIwPDg3sVMcSbsFihruIXou/1LhCPt7npCQ7sTmv1vQbyJzhq/tYRYWc0A26ECgYA2L3CoXAfNZ8C6fKCn2T9fZUeFlcLhGlI630v0xdsBqOXflQiwQevi5n3Wqlsi3toSApT4a/YDAPaVBrnQcA60L73pG0dz/rBLqdIb61tRkmIQfqXJsDwQL2v4SBzOlNIZs+IsHAkv0fk1+X8wAb48KvCs39PECfkCSG46Yy3i5Q==',
		'log'=>[
			'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
		],
		'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式  normal => '生产'

	]

];