<?php //>

use dungeons\db\column\Double;

return new class() extends dungeons\web\backend\BlankController {

    use dungeons\web\backend\SubCreation;

    protected function init() {
        $table = table('WalletLog');
        $table->remark->required(true);
        $table->add('amount', Double::class)->pseudo(true)->required(true);

        $names = [
            'type',
            'amount',
            'remark',
        ];

        $this->table($table);
        $this->columns($table->getColumns($names));
    }

};
