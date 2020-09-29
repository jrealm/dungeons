<?php //>

use dungeons\db\column\Integer;
use dungeons\db\column\Text;
use dungeons\db\column\Timestamp;
use dungeons\db\Table;

$tbl = new Table('base_manipulation_log', false);

$tbl->add('type', Integer::class);

$tbl->add('log_time', Timestamp::class);

$tbl->add('controller', Text::class);

$tbl->add('user_id', Integer::class);

$tbl->add('member_id', Integer::class);

$tbl->add('ip', Text::class);

$tbl->add('data_type', Text::class);

$tbl->add('data_id', Integer::class);

$tbl->add('previous', Text::class);

$tbl->add('current', Text::class);

return $tbl;
