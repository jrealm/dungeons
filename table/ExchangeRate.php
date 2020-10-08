<?php //>

use dungeons\db\column\Boolean;
use dungeons\db\column\Double;
use dungeons\db\column\Integer;
use dungeons\db\column\ModifiedTime;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_exchange_rate');

$tbl->add('base_id', Integer::class)
    ->associate('currency', 'Currency', 'id', true)
    ->readonly(true)
    ->required(true);

$tbl->add('currency', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('buy', Double::class)
    ->required(true);

$tbl->add('buy_profit', Double::class)
    ->default(0)
    ->required(true);

$tbl->add('sell', Double::class)
    ->required(true);

$tbl->add('sell_profit', Double::class)
    ->default(0)
    ->required(true);

$tbl->add('modify_time', ModifiedTime::class)
    ->required(true);

$tbl->add('auto_modify', Boolean::class)
    ->default(true)
    ->required(true);

return $tbl;
