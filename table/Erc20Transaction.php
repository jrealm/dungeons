<?php //>

use dungeons\db\column\Double;
use dungeons\db\column\Integer;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_erc20_transaction');

$tbl->add('hash', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('sender', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('receiver', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('currency', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('amount', Double::class)
    ->readonly(true)
    ->required(true);

$tbl->add('status', Integer::class)
    ->default(0)
    ->required(true);

return $tbl;
