<?php

namespace C3poCz;

class OkmExportParser
{
	protected $content;
	protected $parsed = FALSE;

	protected $header = [];
	protected $footer = [];
	protected $turnover = [];
	protected $transactions = [];


	public function __construct($okmContent)
	{
		$this->content = $okmContent;
	}


	public function getFooter()
	{
		$this->checkParsed();
		return $this->footer;
	}


	public function getHeader()
	{
		$this->checkParsed();
		return $this->header;
	}


	public function getTransactions()
	{
		$this->checkParsed();
		return $this->transactions;
	}


	public function getTurnover()
	{
		$this->checkParsed();
		return $this->turnover;
	}


	protected function parse()
	{
		foreach (preg_split("/((\r?\n)|(\r\n?))/", $this->content) as $line) {
			$id = $this->readAtom($line, 0, 2);
			switch ($id) {
				case 'HO':
					$this->parseHeader($line);
					break;
				case 'TO':
					$this->parseFooter($line);
					break;
				case '51':
					$this->parseTurnover($line);
					break;
				case '52':
				case '53':
					$this->parseTransaction($line);
					break;
			}
		}
	}


	protected function checkParsed()
	{
		if (!$this->parsed) {
			$this->parse();
		}
	}


	protected function parseHeader($line)
	{
		$atoms = [];
		$atoms['type'] = $this->readAtom($line, 0, 2);
		$atoms['formatType'] = $this->readAtom($line, 2, 9);
		$atoms['date'] = $this->readAtom($line, 11, 6);
		$atoms['channel'] = $this->readAtom($line, 17, 30);
		$atoms['transactions'] = $this->readAtom($line, 47, 30);
		$this->header = $atoms;
	}


	protected function parseFooter($line)
	{
		$atoms = [];
		$atoms['type'] = $this->readAtom($line, 0, 2);
		$atoms['date'] = $this->readAtom($line, 11, 6);
		$atoms['transactionCount'] = $this->readNumericAtom($line, 17, 6);
		$atoms['checkSum'] = $this->readAmountAtom($line, 23, 18);
		$this->footer = $atoms;
	}


	protected function parseTurnover($line)
	{
		$atoms = [];
		$atoms['type'] = $this->readAtom($line, 0, 2);
		$atoms['account'] = $this->readAtom($line, 2, 16);
		$atoms['date'] = $this->readAtom($line, 18, 8);
		$atoms['statementNumber'] = $this->readNumericAtom($line, 26, 3);
		$atoms['lastStatementDate'] = $this->readAtom($line, 29, 8);
		$atoms['transactionsCount'] = $this->readNumericAtom($line, 37, 5);
		$atoms['lastBalance'] = $this->readAmountAtom($line, 42, 15);
		$atoms['lastBalanceSign'] = $this->readAtom($line, 57, 1);
		$atoms['balance'] = $this->readAmountAtom($line, 58, 15);
		$atoms['balanceSign'] = $this->readAtom($line, 73, 1);
		$atoms['debetTurnover'] = $this->readAmountAtom($line, 74, 15);
		$atoms['debetTurnoverSign'] = $this->readAtom($line, 89, 1);
		$atoms['creditTurnover'] = $this->readAmountAtom($line, 90, 15);
		$atoms['creditTurnoverSign'] = $this->readAtom($line, 105, 1);
		$atoms['accountName'] = $this->readAtom($line, 106, 30);
		$atoms['iban'] = $this->readAtom($line, 136, 24);

		$this->turnover = $atoms;
	}


	protected function parseTransaction($line)
	{
		$atoms = [];
		$atoms['type'] = $this->readAtom($line, 0, 2);
		$atoms['sequence'] = $this->readNumericAtom($line, 2, 5);
		$atoms['account'] = $this->readAtom($line, 7, 16);
		$atoms['contraAccount'] = $this->readAtom($line, 23, 16);
		$atoms['contraAccountBankCode'] = substr($this->readAtom($line, 39, 7), -4);
		$atoms['accountingCode'] = $this->readNumericAtom($line, 46, 1);
		$atoms['currencyCode'] = $this->readAtom($line, 47, 3);
		$atoms['amount'] = $this->readAmountAtom($line, 50, 15);
		$atoms['contraAccountCurrencyCode'] = $this->readAtom($line, 65, 3);
		$atoms['originalAmount'] = $this->readAmountAtom($line, 68, 15);
		$atoms['paymentTitle'] = $this->readAtom($line, 83, 3);
		$atoms['KBI_ID'] = $this->readAtom($line, 86, 31);
		$atoms['variableSymbol'] = $this->readNumericAtom($line, 117, 10);
		$atoms['partnerVariableSymbol'] = $this->readNumericAtom($line, 127, 10);
		$atoms['constantSymbol'] = $this->readNumericAtom($line, 137, 10);
		$atoms['specificSymbol'] = $this->readNumericAtom($line, 147, 10);
		$atoms['partnerSpecificSymbol'] = $this->readNumericAtom($line, 157, 10);
		$atoms['creationDate'] = $this->readAtom($line, 167, 8);
		$atoms['accountingDate'] = $this->readAtom($line, 175, 8);
		$atoms['deductionDate'] = $this->readAtom($line, 183, 8);
		$atoms['dueDate'] = $this->readAtom($line, 191, 8);
		$atoms['KBI_transactionCode'] = $this->readNumericAtom($line, 199, 2);
		$atoms['Sekv_No'] = $this->readAtom($line, 201, 3);
		$atoms['operationCode'] = $this->readNumericAtom($line, 204, 1);
		$atoms['description1'] = $this->readAtom($line, 209, 30);
		$atoms['description2'] = $this->readAtom($line, 239, 30);
		$atoms['AVmessage'] = $this->readAtom($line, 269, 140);
		$atoms['systemDescription'] = $this->readAtom($line, 409, 30);
		$atoms['shortTitle'] = $this->readAtom($line, 439, 30);
		$atoms['Sekv_No2'] = $this->readAtom($line, 469, 2);


		$this->transactions[] = $atoms;
	}


	protected function readAtom($line, $offset, $length)
	{
		return trim(substr($line, $offset, $length));
	}


	protected function readAmountAtom($line, $offset, $length)
	{
		$atom = $this->readNumericAtom($line, $offset, $length);
		return floatval($atom / 100);
	}


	protected function readNumericAtom($line, $offset, $length)
	{
		$atom = $this->readAtom($line, $offset, $length);
		return intval($atom);
	}
}

