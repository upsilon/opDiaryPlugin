<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$mailAddress = 'sns1@example.com';

$t->login($mailAddress, 'password');
$t->setCulture('en');

$apiKey = '?apiKey=dummyApiKey';

$json = $t->get('/diary/list.json'.$apiKey)
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 15, 'should return 15 articles');
var_dump($data['data']);
