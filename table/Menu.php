<?php //>

use dungeons\db\column\DisableTime;
use dungeons\db\column\EnableTime;
use dungeons\db\column\Integer;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_menu');

$tbl->add('title', Text::class)
    ->required(true);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

$tbl->add('ranking', Integer::class)
    ->required(true);

$tbl->ranking('ranking');

$tbl->id->composite('item', 'SubMenu', 'parent_id');

return $tbl;
