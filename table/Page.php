<?php //>

use dungeons\db\column\DisableTime;
use dungeons\db\column\EnableTime;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_page');

$tbl->add('path', Text::class)
    ->required(true)
    ->unique(true);

$tbl->add('title', Text::class)
    ->multilingual(true)
    ->required(true);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

$tbl->id->composite('block', 'Block', 'page_id');

return $tbl;
