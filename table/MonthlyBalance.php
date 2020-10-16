<?php //>

use dungeons\db\column\Double;
use dungeons\db\Table;

$tbl = new Table('base_monthly_balance');

$tbl->add('debit', Double::class);

$tbl->add('credit', Double::class);

return $tbl;
