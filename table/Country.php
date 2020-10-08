<?php //>

use dungeons\db\column\Ranking;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_country');

$tbl->add('title', Text::class)
    ->required(true);

$tbl->add('code', Text::class)
    ->required(true)
    ->unique(true);

$tbl->add('prefix', Text::class)
    ->required(true);

$tbl->add('ranking', Ranking::class);

return $tbl;
