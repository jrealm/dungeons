<?php //>

namespace dungeons\model;

use dungeons\db\Criteria;
use dungeons\db\Model;

class Member extends Model {

    public function queryById($id) {
        return $this->queryValidMember(['id' => $id]);
    }

    public function queryByUsername($username) {
        $criteria = Criteria::createOr();
        $criteria->add($this->table->username->equal($username));
        $criteria->add($this->table->mobile->equal($username));

        return $this->queryValidMember([$criteria]);
    }

    protected function before($type, $prev, $curr) {
        foreach (['password', 'payment_password'] as $name) {
            if ($this->table->{$name}->encrypt() === false) {
                continue;
            }

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
