# OkmExportParser
Simple PHP parser of KB OKM export files (BEST KB client file format).

This library only parses content of OKM export file. It DOES NOT have any
ambitions to understand its semantics etc.

Install via composer:

    $ composer require jaromirnyklicek/okmexportparser

## Usage

```php
<?php

use C3poCz\OkmExportParser;

$okmFileContent = file_get_contents('/path/to/my/file.okm');
$parser = new OkmExportParser($okmFileContent);

$parser->getHeader(); // returns header of OKM file as array
$parser->getFooter(); // returns footer of OKM file as array
$parser->getTurnover(); // returns turnover sentence of OKM file as array
$parser->getTransaction(); // returns list of transactions as nested array

```