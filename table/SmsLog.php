<?php //>

use dungeons\db\column\CreateTime;
use dungeons\db\column\Creator;
use dungeons\db\column\RemoteAddress;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_sms_log', false);

$tbl->add('sender', Creator::class)
    ->readonly(true)
    ->required(true);

$tbl->add('receiver', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('content', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('ip', RemoteAddress::class)
    ->readonly(true)
    ->required(true);

$tbl->add('create_time', CreateTime::class)
    ->readonly(true)
    ->required(true);

return $tbl;
