<?php //>

use dungeons\db\column\DisableTime;
use dungeons\db\column\EnableTime;
use dungeons\db\column\Integer;
use dungeons\db\column\Ranking;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_menu');

$tbl->add('parent_id', Integer::class)
    ->associate('parent', 'Menu', 'id', true)
    ->readonly(true);

$tbl->add('title', Text::class)
    ->multilingual(true)
    ->required(true);

$tbl->add('url', Text::class);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

$tbl->add('ranking', Ranking::class);

return $tbl;
