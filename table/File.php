<?php //>

use dungeons\db\column\Boolean;
use dungeons\db\column\Creator;
use dungeons\db\column\Integer;
use dungeons\db\column\ModifiedTime;
use dungeons\db\column\Text;
use dungeons\db\Table;

$tbl = new Table('base_file');

$tbl->add('parent_id', Integer::class);

$tbl->add('type', Integer::class)
    ->required(true);

$tbl->add('name', Text::class)
    ->required(true);

$tbl->add('path', Text::class)
    ->unique(true);

$tbl->add('size', Integer::class);

$tbl->add('hash', Text::class);

$tbl->add('description', Text::class);

$tbl->add('mime_type', Text::class);

$tbl->add('width', Integer::class);

$tbl->add('height', Integer::class);

$tbl->add('seconds', Integer::class);

$tbl->add('privilege', Integer::class)
    ->required(true);

$tbl->add('owner_id', Creator::class)
    ->required(true);

$tbl->add('group_id', Integer::class);

$tbl->add('modified_time', ModifiedTime::class)
    ->required(true);

$tbl->add('deleted', Boolean::class)
    ->default(false)
    ->required(true);

$tbl->title('name');

return $tbl;
