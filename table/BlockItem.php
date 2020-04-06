<?php //>

use dungeons\db\Table;
use dungeons\db\column\{DisableTime,EnableTime,Image,Integer,Text,Url};

$tbl = new Table('base_block_item');

$tbl->add('block_id', Integer::class)
    ->associate('block', 'Block', 'id', true)
    ->required(true);

$tbl->add('title', Text::class);

$tbl->add('content', Text::class);

$tbl->add('image', Image::class);

$tbl->add('url', Url::class);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

$tbl->add('ranking', Integer::class)
    ->required(true);

$tbl->ranking('ranking');

return $tbl;
