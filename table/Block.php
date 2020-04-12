<?php //>

use dungeons\db\Table;
use dungeons\db\column\{DisableTime,EnableTime,Image,Integer,Text,Url};

$tbl = new Table('base_block');

$tbl->add('page_id', Integer::class)
    ->associate('page', 'Page', 'id', true)
    ->readonly(true)
    ->required(true);

$tbl->add('module', Text::class)
    ->options('block-module')
    ->readonly(true)
    ->required(true);

$tbl->add('name', Text::class)
    ->required(true);

$tbl->add('title', Text::class);

$tbl->add('content', Text::class);

$tbl->add('image', Image::class);

$tbl->add('url', Url::class);

$tbl->add('extra', Text::class);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

$tbl->add('ranking', Integer::class)
    ->required(true);

$tbl->ranking('ranking');
$tbl->title('name');

$tbl->id->composite('item', 'BlockItem', 'block_id');

return $tbl;
