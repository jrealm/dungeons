<?php //>

use dungeons\db\column\CreateTime;
use dungeons\db\column\Integer;
use dungeons\db\column\RemoteAddress;
use dungeons\db\Table;

$tbl = new Table('base_member_log', false);

$tbl->add('member_id', Integer::class)
    ->associate('member', 'Member')
    ->readonly(true)
    ->required(true);

$tbl->add('type', Integer::class)
    ->options('member-log-type')
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
