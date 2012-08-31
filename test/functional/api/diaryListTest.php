<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$b = new opTestFunctional(new sfBrowser());
$t = new lime_test(null, new lime_output_color());

include dirname(__FILE__).'/../../bootstrap/database.php';

$mailAddress = 'sns1@example.com';

$b->login($mailAddress, 'password');
$b->setCulture('en');

$memberId = Doctrine::getTable('MemberConfig')
  ->createQuery('c')
  ->where('c.name = ?', 'pc_address')
  ->where('c.value = ?', $mailAddress)
  ->fetchOne()
  ->getMemberId();

$apiKey = Doctrine::getTable('MemberConfig')
  ->createQuery('c')
  ->where('c.member_id = ?', $memberId)
  ->where('c.name = ?', 'api_key')
  ->fetchOne()
  ->getValue();

$apiKey = '?apiKey='.$apiKey;

$json = $b->get('/diary/list.json'.$apiKey)
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->is($data['status'], 'success', 'should return status code "success"');
$t->is($data['data'], 'here comes diary list', 'return diary list');
