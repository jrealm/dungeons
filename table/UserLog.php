<?php //>

use dungeons\db\column\CreateTime;
use dungeons\db\column\Integer;
use dungeons\db\column\RemoteAddress;
use dungeons\db\Table;

$tbl = new Table('base_user_log', false);

$tbl->add('user_id', Integer::class)
    ->associate('user', 'User')
    ->readonly(true)
    ->required(true);

$tbl->add('type', Integer::class)
    ->options('user-log-type')
    ->readonly(true)
    ->required(true);

$tbl->add('ip', RemoteAddress::class)
    ->readonly(true)
    ->required(true);

$tbl->add('create_time', CreateTime::class)
    ->readonly(true)
    ->required(true);

$tbl->ranking('-id');

return $tbl;
