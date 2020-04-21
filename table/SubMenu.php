<?php //>

use dungeons\db\Table;
use dungeons\db\column\{DisableTime,EnableTime,Integer,Text};

$tbl = new Table('base_menu');

$tbl->add('parent_id', Integer::class)
    ->associate('parent', 'Menu', 'id', true)
    ->readonly(true);

$tbl->add('title', Text::class)
    ->required(true);

$tbl->add('url', Text::class);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

$tbl->add('ranking', Integer::class)
    ->required(true);

$tbl->ranking('ranking');

return $tbl;
