<?php //>

use dungeons\db\column\DisableTime;
use dungeons\db\column\EnableTime;
use dungeons\db\column\Ranking;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_currency');

$tbl->add('title', Text::class)
    ->required(true);

$tbl->add('code', Text::class)
    ->required(true)
    ->unique(true);

$tbl->add('symbol', Text::class);

$tbl->add('icon', Text::class);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

$tbl->add('ranking', Ranking::class);

$tbl->id->composite('rate', 'ExchangeRate', 'base_id');

return $tbl;
