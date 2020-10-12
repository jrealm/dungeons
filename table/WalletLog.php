<?php //>

use dungeons\db\column\CreateTime;
use dungeons\db\column\Date;
use dungeons\db\column\Double;
use dungeons\db\column\Integer;
use dungeons\db\column\Textarea;
use dungeons\db\Table;

$tbl = new Table('base_wallet_log', false);

$tbl->add('wallet_id', Integer::class)
    ->associate('wallet', 'Wallet', 'id', true)
    ->readonly(true)
    ->required(true);

$tbl->add('transaction_id', Integer::class)
    ->associate('transaction', 'Transaction')
    ->readonly(true)
    ->required(true);

$tbl->add('the_date', Date::class)
    ->readonly(true)
    ->required(true);

$tbl->add('type', Integer::class)
    ->options('wallet-log-type')
    ->readonly(true)
    ->required(true);

$tbl->add('debit', Double::class)
    ->default(0)
    ->readonly(true)
    ->required(true);

$tbl->add('credit', Double::class)
    ->default(0)
    ->readonly(true)
    ->required(true);

$tbl->add('balance', Double::class)
    ->readonly(true)
    ->required(true);

$tbl->add('remark', Textarea::class)
    ->readonly(true);

$tbl->add('create_time', CreateTime::class)
    ->readonly(true)
    ->required(true);

$tbl->ranking('-id');

return $tbl;
