<?php //>

use dungeons\db\column\Double;
use dungeons\db\column\Integer;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_wallet');

$tbl->add('member_id', Integer::class)
    ->associate('member', 'Member')
    ->readonly(true)
    ->required(true);

$tbl->add('account', Text::class)
    ->readonly(true)
    ->required(true);

$tbl->add('currency_id', Integer::class)
    ->associate('currency', 'Currency')
    ->readonly(true)
    ->required(true);

$tbl->add('balance', Double::class)
    ->default(0)
    ->required(true);

$tbl->add('frozen', Double::class)
    ->default(0)
    ->required(true);

$tbl->title('account');

$tbl->id->composite('log', 'WalletLog', 'wallet_id');

return $tbl;
