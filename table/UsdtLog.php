<?php //>

use dungeons\db\column\Double;
use dungeons\db\column\Text;
use dungeons\db\column\Timestamp;
use dungeons\db\Table;

$tbl = new Table('base_usdt_log', false);

$tbl->add('hash', Text::class);

$tbl->add('sender', Text::class);

$tbl->add('receiver', Text::class);

$tbl->add('amount', Double::class);

$tbl->add('create_time', Timestamp::class);

return $tbl;
