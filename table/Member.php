<?php //>

use dungeons\db\column\Boolean;
use dungeons\db\column\Password;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_member');

$tbl->add('username', Text::class)
    ->required(true)
    ->unique(true);

$tbl->add('nickname', Text::class)
    ->unique(true);

$tbl->add('mobile', Text::class)
    ->unique(true);

$tbl->add('password', Password::class)
    ->required(true);

$tbl->add('disabled', Boolean::class)
    ->default(false)
    ->required(true);

$tbl->title('username');

return $tbl;
