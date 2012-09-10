<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$mailAddress = 'sns1@example.com';

$t->login($mailAddress, 'password');
$t->setCulture('en');
