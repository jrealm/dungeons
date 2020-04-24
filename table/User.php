<?php //>

use dungeons\db\column\Boolean;
use dungeons\db\column\Date;
use dungeons\db\column\Integer;
use dungeons\db\column\Password;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_user');

$tbl->add('username', Text::class)
    ->required(true)
    ->unique(true);

$tbl->add('password', Password::class)
    ->required(true);

$tbl->add('group_id', Integer::class)
    ->associate('group', 'Group');

$tbl->add('begin_date', Date::class);

$tbl->add('expire_date', Date::class);

$tbl->add('disabled', Boolean::class)
    ->default(false)
    ->required(true);

$tbl->title('username');

return $tbl;
