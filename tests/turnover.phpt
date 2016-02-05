<?php

require_once __DIR__ . '/bootstrap.php';

use Tester\Assert;

$parser = new \C3poCz\OkmExportParser($content1);

$turnover = [
	'type' => '51',
	'account' => '0001079379100217',
	'date' => '20150209',
	'statementNumber' => 8,
	'lastStatementDate' => '20150205',
	'transactionsCount' => 2,
	'lastBalance' => 17641.70,
	'lastBalanceSign' => '+',
	'balance' => 18641.70,
	'balanceSign' => '+',
	'debetTurnover' => 0.00,
	'debetTurnoverSign' => '+',
	'creditTurnover' => 1000.00,
	'creditTurnoverSign' => '+',
	'accountName' => 'TEST ACCOUNT',
	'iban' => 'CZ6401000001079379100217'
];

Assert::equal($turnover, $parser->getTurnover());