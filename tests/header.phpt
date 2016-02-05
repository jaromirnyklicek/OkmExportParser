<?php

require_once __DIR__ . '/bootstrap.php';

use Tester\Assert;

$parser = new \C3poCz\OkmExportParser($content1);

$header = [
	'type' => 'HO',
	'formatType' => 'BEST',
	'date' => '160201',
	'channel' => 'ProfiBanka-export trans. hist.',
	'transactions' => 'Pouze ucetni transakce',
];

Assert::equal($header, $parser->getHeader());