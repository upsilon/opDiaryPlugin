<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$mailAddress = 'sns1@example.com';

$t->login($mailAddress, 'password');
$t->setCulture('en');

$apiKey = '?apiKey=dummyApiKey';

$json = $t->get('/diary/post.json',
    array(
      'apiKey'=>'dummyApiKey',
      'title'=>'テストタイトル',
      'body'=>'テスト本文',
      'public_flag'=>'1', //全員に公開
    )
  )->getResponse()->getContent()
;
$data =json_decode($json, true);
var_dump($json, $data);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
