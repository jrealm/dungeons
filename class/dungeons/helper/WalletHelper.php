<?php //>

namespace dungeons\helper;

trait WalletHelper {

    private function getWallet($member = null, $currency = null) {
        if (!$member) {
            $member = $this->member();
        }

        if (!$currency) {
            $currency = model('Currency')->find(['code' => cfg('app.default.currency')]);
        }

        if (!$member || !$currency) {
            return null;
        }

        $model = model('Wallet');
        $wallet = $model->find(['member_id' => $member['id'], 'currency_id' => $currency['id']]);

        while (!$wallet) {
            $account = preg_replace('/^0\.(\d+)\d{2} \d{4}(\d+)$/', '$1$2', microtime());

            if (!$model->count(['account' => $account])) {
                $wallet = $model->insert([
                    'member_id' => $member['id'],
                    'account' => $account,
                    'currency_id' => $currency['id'],
                ]);
            }
        }

        $wallet['member'] = $member;
        $wallet['currency'] = $currency;

        return $wallet;
    }

}
