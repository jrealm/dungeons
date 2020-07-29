<?php //>

$city = '/^((基隆|新北|桃園|高雄)市|(臺|台)(北|中|南)市|(新竹|嘉義)(縣|市)|(苗栗|彰化|南投|雲林|(屏|臺|台)東|宜蘭|花蓮|澎湖|金門|連江)縣)/';
$island = '/^(屏東縣琉球|(臺|台)東縣(蘭嶼|綠島)|(澎湖|金門|連江))/';

return function ($address) use ($city, $island) {
    return preg_match($city, $address) ? (preg_match($island, $address) ? 2 : 1) : 0;
};
