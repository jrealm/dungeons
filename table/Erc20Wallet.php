<?php //>

use dungeons\db\column\CreateTime;
use dungeons\db\column\Integer;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_erc20_wallet', false);

$tbl->add('member_id', Integer::class)
    ->associate('member', 'Member')
    ->readonly(true)
    ->required(true);

$tbl->add('address', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('public_key', Text::class)
    ->invisible(true)
    ->readonly(true)
    ->required(true);

$tbl->add('private_key', Text::class)
    ->invisible(true)
    ->readonly(true)
    ->required(true);

$tbl->add('create_time', CreateTime::class)
    ->readonly(true)
    ->required(true);

$tbl->title('address');

return $tbl;
