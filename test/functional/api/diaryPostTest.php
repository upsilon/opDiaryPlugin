<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$mailAddress = 'sns1@example.com';

$t->login($mailAddress, 'password');
$t->setCulture('en');

$t->info('should be able to post a new diary entry');
$title = 'テストタイトル';
$body = 'テスト本文';
$publicFlag = 1;//全員に公開
$json = $t->get('/diary/post.json',
    array(
      'apiKey'      => 'dummyApiKey',
      'title'       => $title,
      'body'        => $body,
      'public_flag' => $publicFlag,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->ok($data['data']['id'], 'should have id');
$t->test()->ok($data['data']['member'], 'should have member info');
$t->test()->is($data['data']['title'], $title, 'should have the same title posted');
$t->test()->is($data['data']['body'], $body, 'should have the same body posted');
$t->test()->is($data['data']['public_flag'], $publicFlag, 'should have the same publid flag posted');
$t->test()->ok($data['data']['created_at'], 'should have the date posted');

$t->info('should return error when the title is empty');
$json = $t->get('/diary/post.json',
    array(
      'apiKey'      => 'dummyApiKey',
      'title'       => '',
      'body'        => $body,
      'public_flag' => $publicFlag,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$json = $t->get('/diary/post.json',
    array(
      'apiKey'      => 'dummyApiKey',
      'body'        => $body,
      'public_flag' => $publicFlag,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$t->info('should return error when the body is empty');
$json = $t->get('/diary/post.json',
    array(
      'apiKey'      => 'dummyApiKey',
      'title'       => $title,
      'body'        => '',
      'public_flag' => $publicFlag,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$json = $t->get('/diary/post.json',
    array(
      'apiKey'      => 'dummyApiKey',
      'title'       => $title,
      'public_flag' => $publicFlag,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$t->info('should return error when the public flag is empty');
$json = $t->get('/diary/post.json',
    array(
      'apiKey'      => 'dummyApiKey',
      'title'       => $title,
      'body'        => $body,
      'public_flag' => '',
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$json = $t->get('/diary/post.json',
    array(
      'apiKey'      => 'dummyApiKey',
      'title'       => $title,
      'body'        => $body,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$t->info('should be able to edit a existing diary entry');
$id = 1;
$title = '編集後のテストタイトル'.time();
$body = '編集後のテスト本文'.time();
$publicFlag = 3;//全員に公開
$json = $t->get('/diary/post.json',
    array(
      'id'          => $id,
      'apiKey'      => 'dummyApiKey',
      'title'       => $title,
      'body'        => $body,
      'public_flag' => $publicFlag,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data']['id'], $id, 'should have the same id');
$t->test()->ok($data['data']['member'], 'should have member info');
$t->test()->is($data['data']['title'], $title, 'should have the same title posted');
$t->test()->is($data['data']['body'], $body, 'should have the same body posted');
$t->test()->is($data['data']['public_flag'], $publicFlag, 'should have the same publid flag posted');
$t->test()->ok($data['data']['created_at'], 'should have the date posted');

