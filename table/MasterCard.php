<?php //>

use dungeons\db\column\Integer;
use dungeons\db\column\ModifiedTime;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_master_card');

$tbl->add('member_id', Integer::class)
    ->associate('member', 'Member');

$tbl->add('card_number', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('valid_from', Text::class)
    ->invisible(true);

$tbl->add('good_thru', Text::class)
    ->invisible(true);

$tbl->add('security_code', Text::class)
    ->invisible(true);

$tbl->add('modify_time', ModifiedTime::class)
    ->required(true);

$tbl->add('status', Integer::class)
    ->default(0)
    ->options('mastercard-status')
    ->required(true);

return $tbl;
