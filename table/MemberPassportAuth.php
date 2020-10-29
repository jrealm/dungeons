<?php //>

use dungeons\db\column\CreateTime;
use dungeons\db\column\Date;
use dungeons\db\column\Email;
use dungeons\db\column\Image;
use dungeons\db\column\Integer;
use dungeons\db\column\Text;
use dungeons\db\column\Textarea;
use dungeons\db\column\Timestamp;
use dungeons\db\Table;

$tbl = new Table('base_member_passport_auth');

$tbl->add('member_id', Integer::class)
    ->associate('member', 'Member')
    ->readonly(true)
    ->required(true);

$tbl->add('mail', Email::class)
    ->readonly(true)
    ->required(true);

$tbl->add('last_name', Text::class)
    ->required(true);

$tbl->add('first_name', Text::class)
    ->required(true);

$tbl->add('id_number', Text::class)
    ->required(true);

$tbl->add('photocopy1', Image::class)
    ->readonly(true)
    ->required(true);

$tbl->add('photocopy2', Image::class)
    ->readonly(true)
    ->required(true);

$tbl->add('birthday', Date::class)
    ->required(true);

$tbl->add('nationality_id', Integer::class)
    ->associate('nationality', 'Country')
    ->required(true);

$tbl->add('sex', Text::class)
    ->options('sex')
    ->required(true);

$tbl->add('country_code', Text::class)
    ->invisible(true);

$tbl->add('town', Text::class)
    ->invisible(true);

$tbl->add('address', Text::class)
    ->invisible(true);

$tbl->add('post_code', Text::class)
    ->invisible(true);

$tbl->add('create_time', CreateTime::class)
    ->readonly(true)
    ->required(true);

$tbl->add('language', Text::class)
    ->readonly(true);

$tbl->add('approver', Text::class);

$tbl->add('approve_time', Timestamp::class);

$tbl->add('rejection', Textarea::class);

$tbl->add('status', Integer::class)
    ->default(1)
    ->options('member-auth-status')
    ->required(true);

return $tbl;
