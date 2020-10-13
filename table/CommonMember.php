<?php //>

use dungeons\db\column\Boolean;
use dungeons\db\column\CreateTime;
use dungeons\db\column\Email;
use dungeons\db\column\Integer;
use dungeons\db\column\Password;
use dungeons\db\column\Text;
use dungeons\db\column\Timestamp;
use dungeons\db\Table;

$tbl = new Table('base_member');

$tbl->add('username', Text::class)
    ->required(true)
    ->unique(true);

$tbl->add('nickname', Text::class)
    ->unique(true);

$tbl->add('country_id', Integer::class)
    ->associate('country', 'Country');

$tbl->add('mobile', Text::class)
    ->unique(true);

$tbl->add('mail', Email::class)
    ->unique(true);

$tbl->add('password', Password::class)
    ->required(true);

$tbl->add('password_time', Timestamp::class)
    ->invisible(true)
    ->required(true);

$tbl->add('payment_password', Password::class);

$tbl->add('payment_password_time', Timestamp::class)
    ->invisible(true);

$tbl->add('create_time', CreateTime::class)
    ->readonly(true)
    ->required(true);

$tbl->add('disabled', Boolean::class)
    ->default(false)
    ->required(true);

$tbl->ranking('username');
$tbl->title('username');

return $tbl;
