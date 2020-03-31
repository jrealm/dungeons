<?php //>

use dungeons\db\Table;
use dungeons\db\column\{DisableTime,EnableTime,Text};

$tbl = new Table('base_page');

$tbl->add('path', Text::class)
    ->required(true)
    ->unique(true);

$tbl->add('title', Text::class)
    ->required(true);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

return $tbl;
