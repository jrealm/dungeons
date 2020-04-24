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
        switch ($type) {
        case self::INSERT:
            $encrypt = isset($curr['password']);
            break;
        case self::UPDATE:
            if (isset($curr['password'])) {
                $encrypt = ($curr['password'] !== $prev['password']);
            } else {
                $curr['password'] = $prev['password'];
            }
            break;
        }

        if (!empty($encrypt)) {
            $curr['password'] = md5("{$curr['id']}::{$curr['password']}");
        }

        return $curr;
    }

    private function queryValidMember($conditions) {
        $conditions['disabled'] = false;

        return $this->find($conditions);
    }

}
