<?php //>

use dungeons\db\Table;
use dungeons\db\column\Text;

$tbl = new Table('base_group');

$tbl->add('title', Text::class)
    ->required(true)
    ->unique(true);

return $tbl;
