<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$mailAddress = 'sns1@example.com';

$t->login($mailAddress, 'password');
$t->setCulture('en');

$t->info('should return entries');
$json = $t->get('/diary/list.json',
    array(
      'apiKey'=>'dummyApiKey'
    )
  )
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 15, 'should return 15 articles');
$t->test()->is($data['next'], 2, 'should return next page number 2 ');

$t->info('should return next page entries');
$json = $t->get('/diary/list.json',
    array(
      'apiKey'=>'dummyApiKey',
      'page'=>2
    )
  )
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 15, 'should return 15 articles');
$t->test()->is($data['next'], 3, 'should return next page number 3 ');
