<?php //>

use dungeons\db\column\CreateTime;
use dungeons\db\column\Date;
use dungeons\db\column\Double;
use dungeons\db\column\FormNumber;
use dungeons\db\column\Integer;
use dungeons\db\column\Text;
use dungeons\db\column\Textarea;
use dungeons\db\column\Timestamp;
use dungeons\db\Table;

$tbl = new Table('base_transaction');

$tbl->add('bill_number', FormNumber::class)
    ->length(5)
    ->prefix('T')
    ->readonly(true)
    ->required(true)
    ->sequence('base_transaction_bill_number');

$tbl->add('the_date', Date::class)
    ->readonly(true)
    ->required(true);

$tbl->add('type', Integer::class)
    ->options('transaction-type')
    ->readonly(true)
    ->required(true);

$tbl->add('wallet_id', Integer::class)
    ->associate('wallet', 'Wallet')
    ->readonly(true)
    ->required(true);

$tbl->add('amount', Double::class)
    ->required(true);

$tbl->add('fee', Double::class)
    ->required(true);

$tbl->add('target', Text::class)
    ->readonly(true);

$tbl->add('target_currency', Text::class)
    ->readonly(true);

$tbl->add('target_amount', Double::class)
    ->readonly(true);

$tbl->add('target_fee', Double::class)
    ->readonly(true);

$tbl->add('payment', Text::class);

$tbl->add('request', Text::class)
    ->invisible(true)
    ->readonly(true);

$tbl->add('response', Text::class)
    ->invisible(true)
    ->readonly(true);

$tbl->add('notice', Text::class)
    ->invisible(true);

$tbl->add('remark', Textarea::class)
    ->readonly(true);

$tbl->add('creator', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('create_time', CreateTime::class)
    ->readonly(true)
    ->required(true);

$tbl->add('processor', Text::class);

$tbl->add('process_time', Timestamp::class);

$tbl->add('rejection', Textarea::class);

$tbl->add('status', Integer::class)
    ->default(0)
    ->required(true);

return $tbl;
