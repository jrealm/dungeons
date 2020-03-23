<?php //>

use dungeons\db\Table;
use dungeons\db\column\{Boolean,Password,Text};

$tbl = new Table('base_member');

$tbl->add('username', Text::class)
    ->required(true)
    ->unique(true);

$tbl->add('nickname', Text::class)
    ->required(true)
    ->unique(true);

$tbl->add('password', Password::class)
    ->required(true);

$tbl->add('disabled', Boolean::class)
    ->default(false)
    ->required(true);

$tbl->title('username');

return $tbl;
