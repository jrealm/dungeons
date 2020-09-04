<?php //>

use dungeons\db\column\DisableTime;
use dungeons\db\column\EnableTime;
use dungeons\db\column\Ranking;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_menu');

$tbl->add('title', Text::class)
    ->multilingual(true)
    ->required(true);

$tbl->add('url', Text::class);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

$tbl->add('ranking', Ranking::class);

$tbl->id->composite('item', 'SubMenu', 'parent_id');

return $tbl;
