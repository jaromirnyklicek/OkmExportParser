<?php

require_once __DIR__ . '/bootstrap.php';

use Tester\Assert;

$parser = new \C3poCz\OkmExportParser($content1);

$footer = [
	'type' => 'TO',
	'date' => '160201',
	'transactionCount' => 3,
	'checkSum' => 1000.00,
];

Assert::equal($footer, $parser->getFooter());