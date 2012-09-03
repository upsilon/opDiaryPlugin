<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$mailAddress = 'sns1@example.com';

$t->login($mailAddress, 'password');
$t->setCulture('en');
$diary = Doctrine::getTable('Diary')->findOneById('1');
$images = $diary->getDiaryImages();
$comments = $diary->getDiaryComments();
$prev = $diary->getPrevious($diary->getMemberId());
$next = $diary->getNext($diary->getMemberId());
$json = $t->get('/diary/show.json',
    array(
      'apiKey'=>'dummyApiKey',
      'id'    => 1
    )
  )
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data']['id'], 1, 'should return id 1');
$t->test()->is(count($data['data']['images']), count($images), 'should have '.count($images).' images');
$t->test()->is(count($data['data']['comments']), count($comments), 'should have '.count($comments).' comments field');
$t->test()->is($data['data']['next']['id'], $next->getId(), 'should have next field');
$t->test()->is($data['data']['prev'], false, 'should not have prev field');
