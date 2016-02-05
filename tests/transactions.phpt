<?php

require_once __DIR__ . '/bootstrap.php';

use Tester\Assert;

$parser = new \C3poCz\OkmExportParser($content1);

$transactions = [
	[
		'type' => '52',
		'sequence' => 1,
		'account' => '0001079379100217',
		'contraAccount' => '0000000183402482',
		'contraAccountBankCode' => '0300',
		'accountingCode' => 1,
		'currencyCode' => 'CZK',
		'amount' => 500.00,
		'contraAccountCurrencyCode' => 'CZK',
		'originalAmount' => 500.00,
		'paymentTitle' => '0',
		'KBI_ID' => '120-20150206 PR00 000278909',
		'variableSymbol' => 330,
		'partnerVariableSymbol' => 330,
		'constantSymbol' => 0,
		'specificSymbol' => 1792,
		'partnerSpecificSymbol' => 1792,
		'creationDate' => '20150206',
		'accountingDate' => '20150209',
		'deductionDate' => '20150206',
		'dueDate' => '20150209',
		'KBI_transactionCode' => 14,
		'Sekv_No' => '',
		'operationCode' => 0,
		'description1' => 'DOE JANE',
		'description2' => '',
		'AVmessage' => '',
		'systemDescription' => 'Uhrada z jine banky',
		'shortTitle' => 'DOE JANE',
		'Sekv_No2' => '',
	],
	[
		'type' => '52',
		'sequence' => 2,
		'account' => '0001079379100217',
		'contraAccount' => '0000191909930247',
		'contraAccountBankCode' => '0100',
		'accountingCode' => 1,
		'currencyCode' => 'CZK',
		'amount' => 500.00,
		'contraAccountCurrencyCode' => 'CZK',
		'originalAmount' => 500.00,
		'paymentTitle' => '0',
		'KBI_ID' => '312-09022015 1601 901636 039997',
		'variableSymbol' => 368,
		'partnerVariableSymbol' => 368,
		'constantSymbol' => 558,
		'specificSymbol' => 1792,
		'partnerSpecificSymbol' => 1792,
		'creationDate' => '20150209',
		'accountingDate' => '20150209',
		'deductionDate' => '20150209',
		'dueDate' => '20150209',
		'KBI_transactionCode' => 15,
		'Sekv_No' => '',
		'operationCode' => 0,
		'description1' => 'DOE JOHN',
		'description2' => '',
		'AVmessage' => '',
		'systemDescription' => 'Platba ve prospech vaseho uctu',
		'shortTitle' => 'DOE JOHN',
		'Sekv_No2' => '',
	]
];

Assert::equal($transactions, $parser->getTransactions());