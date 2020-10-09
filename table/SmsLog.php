<?php //>

use dungeons\db\column\CreateTime;
use dungeons\db\column\Creator;
use dungeons\db\column\Integer;
use dungeons\db\column\RemoteAddress;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_sms_log', false);

$tbl->add('sender', Creator::class)
    ->readonly(true);

$tbl->add('receiver', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('content', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('response', Text::class)
    ->invisible(true)
    ->readonly(true);

$tbl->add('ip', RemoteAddress::class)
    ->readonly(true)
    ->required(true);

$tbl->add('create_time', CreateTime::class)
    ->readonly(true)
    ->required(true);

$tbl->add('status', Integer::class)
    ->default(0)
    ->options('sms-status')
    ->required(true);

$tbl->ranking('-id');

return $tbl;
