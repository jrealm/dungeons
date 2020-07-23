<?php //>

use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_group');

$tbl->add('title', Text::class)
    ->multilingual(true)
    ->required(true)
    ->unique(true);

return $tbl;
