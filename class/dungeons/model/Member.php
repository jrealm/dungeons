<?php //>

namespace dungeons\model;

use dungeons\db\Model;

class Member extends Model {

    public function queryById($id) {
        return $this->queryValidMember(['id' => $id]);
    }

    public function queryByUsername($username) {
        return $this->queryValidMember(['username' => $username]);
    }

    protected function before($type, $prev, $curr) {
        foreach (['password', 'payment_password'] as $name) {
            $encrypt = false;

            switch ($type) {
            case self::INSERT:
                $encrypt = isset($curr[$name]);
                break;
            case self::UPDATE:
                if (isset($curr[$name])) {
                    $encrypt = ($curr[$name] !== $prev[$name]);
                } else {
                    $curr[$name] = $prev[$name];
                }
                break;
            }

            if (!empty($encrypt)) {
                $curr[$name] = md5("{$curr['id']}::{$curr[$name]}");
            }
        }

        return $curr;
    }

    private function queryValidMember($conditions) {
        $conditions['disabled'] = false;

        return $this->find($conditions);
    }

}
