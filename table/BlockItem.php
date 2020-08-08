<?php //>

use dungeons\db\column\DisableTime;
use dungeons\db\column\EnableTime;
use dungeons\db\column\Image;
use dungeons\db\column\Integer;
use dungeons\db\column\Text;
use dungeons\db\column\Url;
use dungeons\db\Table;

$tbl = new Table('base_block_item');

$tbl->add('block_id', Integer::class)
    ->associate('block', 'Block', 'id', true)
    ->readonly(true)
    ->required(true);

$tbl->add('title', Text::class)
    ->multilingual(true);

$tbl->add('content', Text::class)
    ->multilingual(true);

$tbl->add('image', Image::class);

$tbl->add('url', Url::class);

$tbl->add('extra', Text::class);

$tbl->add('enable_time', EnableTime::class);

$tbl->add('disable_time', DisableTime::class);

$tbl->add('ranking', Integer::class)
    ->required(true);

$tbl->ranking('ranking');

return $tbl;
