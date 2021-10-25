<?php 

$ycBearer = 'db422y4ahpubbnjuy4ya'; //Bearer код для API YCLIENTS
$ycUser = '29a9ec5bbf774c4923d126e04cf57897'; //User код для API YCLIENTS

$accData = array(
	'ablaser' => array(
		'tableName' => 'laser', //постфикс таблицы в БД
		'amoHost' => 'ablaser', //субдомен в AMOCRM
		'authCode' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijg3ODhkMWQ3OTliOTNjMWRmZDFlZDY4Mjg1Yjk5NDU5ZGVjZDk5ZWIwYTdiNWU0MGVlNmYwOWRkYzI0ODIyOGVlZmVlY2RkYTUxODY4ZmE5In0.eyJhdWQiOiI2MTRkMzA1Yi00MmNjLTRhZTEtOWI4Ni1jMzUyNDI2ODZjYmYiLCJqdGkiOiI4Nzg4ZDFkNzk5YjkzYzFkZmQxZWQ2ODI4NWI5OTQ1OWRlY2Q5OWViMGE3YjVlNDBlZTZmMDlkZGMyNDgyMjhlZWZlZWNkZGE1MTg2OGZhOSIsImlhdCI6MTYzNTA1OTc2NCwibmJmIjoxNjM1MDU5NzY0LCJleHAiOjE2MzUxNDYxNjQsInN1YiI6IjM0OTMwNTciLCJhY2NvdW50X2lkIjoyOTcxNTQ0Miwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.FRTFZxyc46Pqzia46rB5ijeZa8xjyjUubvLLoGddmW2P0cNOigThsME6Et0TLsC-CQK1mn78qR2qDD3L_mrkDB8RFDaWdNo3qZN6z_NzBWIzQ5NOrurn81ax309kxkeMlCqe6togw1EaUSFVl3YqS37b8fSFWDlNvUWJkwIsBjo7UnabVSEWr3LzilLyYzMXM30X789Ac6Ykkgr_LYYg4rany02RbagYnJRTzYm4zjoKINVMAQS260WBYunkFZ4eEm2H5JfUbDBHH2ILQiLIrIdbZXq1LQc3ngKaoHXpXfepmOz-detNQ_5Vri0dbfSlZCfbxxS-CPrYUvaNMXDebA', //oauth код авторизации интеграции в AMOCRM
		'refreshCode' => 'def502008ca51aafa625430c464c97e9df58fa79b6421fd3edeaa299430c646cfc7f5049c78157df84186d6fdfe2c06444a6505125030e66eef36203d4ec620cf2d85be1e3a2b8be0a248f8635c68573923ad7db4731429a799093e872ac6ccd1732d7b0fef7e1e65572f28e6816584ff7203f2a6e8f41a7461e0ce2da48ab3e7e475fea7bc1c57b6f75ffc4e6973869cce8c0a540f3260e8eb05f04dece76c317b2b2e184797582cb4a392e029b457299b6dcea0289695cc3be261fb007082e2318f462fc090f00e70809b195bed69c4223df26bbaea00476be1aae1b42e2d251abe4fb66f6e808e1b8ac91ecd21c219b87051eb2e4ccf0d7b27074d656363e7b56a2d021cdfb7656cd4af6f44c33a220f9b3b3f6183a5898bca4970bf180255749058e0639609b3883719fa71d265e94b401c12124563549bdf09a734903072940a864bc4734813d40f8f002238bacadcc7e0bc705cecdb295ec3af37bc21dbd0f1556cd8093b463003ffcb30bbf2e8617cba690bd2d5fcb197337a44f97a63a1daa2b96c913489f6295c82fc91d40f8fe1004317d06438e26efc6d017891bcd8776687da16da25e060d2845ee5b26863e3997f1a2662e408140580d75f4d73112713feabe1294307e', //oauth код обновления интеграции в AMOCRM
		'ycFilialId' => '543499',
		"customFields" => array(
				"yc_id" => 629913,
				"phone" => 159945,
				"visits" => 629911,
				"spent" => 629909,
				"deal_yc_id" => 629165
				),
		"statuses" => array(
				"client_signed" 	=> 43315789,
				"client_confirm" 	=> 43315792,
				"client_declined" => 43315798,
				"client_visited" 	=> 43315795,
				"record_deleted" => 43315801
			)
	),
	'autobeauty' => array(
		'tableName' => 'autobeauty', //постфикс таблицы в БД
		'amoHost' => 'autobeauty', //субдомен в AMOCRM
		'authCode' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQ4OWVjZWYxMDBjODJlOTNjMmEzMDgyNWYwZDhiY2U0ZGRjYjc5NGI0MDVkZmYwOTgxOTBmNzllNTI0Y2Q4ZjBlOGVhZmExNzk1MzA2MTU3In0.eyJhdWQiOiJmNWMxOWRmMi0wNWU4LTQ0YmQtYWZiOC1hMGIyMDI3ODg4MWQiLCJqdGkiOiI0ODllY2VmMTAwYzgyZTkzYzJhMzA4MjVmMGQ4YmNlNGRkY2I3OTRiNDA1ZGZmMDk4MTkwZjc5ZTUyNGNkOGYwZThlYWZhMTc5NTMwNjE1NyIsImlhdCI6MTYzNDgxNTY5NywibmJmIjoxNjM0ODE1Njk3LCJleHAiOjE2MzQ5MDIwOTcsInN1YiI6IjM0OTMwNTciLCJhY2NvdW50X2lkIjoyODg1OTk3MSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.IqSfMWMkPvq_gq9E-jlKJbj5sDxeFX3-zXSEABlAp255DHgSWKYDkymGc94UyiafQAqYCjIO64aPWJ-5XdrOmFaSl11m51EHePlseqDvzxMc3bQ6xKQ1hxJSPAc8SELTwBR2XirSRG0kmurWM2P7Ni-6gzc1kEoHN9GGshEzzV_IyLOvSgNmQXwP261xc2c_W2X0em_RGo7pwwKBCUs8nm35iWIWaZj1ffW1NMqVGUWWYC4i2UVhNwfeiSBOK9Bmxg7mQQE2XhZj0c21jXzAMzFVVje9lZ2OvvGCG3OOIzv7HkcUZvEDBvgIBx-Hl1UbSjmcVqMJCBs8wLbx9vsAAQ', //oauth код авторизации интеграции в AMOCRM
		'refreshCode' => 'def5020033a00bbfb376e61c0585ec7c2ad4545e1c6f41047070decb0fde8e16eab503cd82007f1160021f8a1f2e44c404c86ab94526555e809e46382c8ab11254fa37370219a33f62366e7e212ca670ceb597514782b84faef746b47a7ed6c8c7d9e834d882f53e096d2db3250d33b32e5e65615c91b29a042dcd29a4ebbf609c42d962e1ed4b48a3310c4d02f6ace5b7591b8770dc20f9d55a0dff3ebdd94cf417134c29bf540ac0f6e2f342b72ae2790a0adfa8c09541c7059fb6ffb551120d7b8ac80f3e6d5ce18827104eae9e3944fabde94f290e2671861d9b1de5ae6dd9975940d8e4fa47c83a9fb463d87c819ff245f00adb42edee65d42f6947f794885453f1ba876614613fb41baee91c639d2f08ecde1624820dfd36bf942878449d4c8cffabc64acf8e198b75393f41f62543929eb2217784249e65dbf7a3236b0a561ccaadb10acabf95ce812b15908277c7083d14cec2d364d41aeb67083502ec3479a1e8bc642fcc96b3715cfae1bc62206adba4ce1b554b58f833c0c052b97a0ec6bfb16f96dacf08b1f61fb559250ecb32eb95479d4a864bfd3e131e16f47ca8446d0eb8722b49238cf4a9c3248c93c83be519cde204b8d03dc77e3526c5fd587568d66d180f3435', //oauth код обновления интеграции в AMOCRM
		'ycFilialId' => '142632'

	),
	'data' => array(
		'tableName' => 'data', //постфикс таблицы в БД
	)
);













?>