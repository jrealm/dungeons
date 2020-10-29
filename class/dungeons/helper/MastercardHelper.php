<?php //>

namespace dungeons\helper;

trait MastercardHelper {

    private function getPassportAuth($latest = false) {
        $member = $this->member();

        if ($member) {
            $model = model('MemberPassportAuth');

            if ($latest) {
                $list = $model->query(['member_id' => $member['id']], ['-id'], 1); //最新的一筆

                return array_pop($list);
            } else {
                return $model->find(['member_id' => $member['id'], 'status' => 3]); //通過
            }
        }

        return null;
    }

}
