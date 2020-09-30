<?php //>

return function ($text) {
    if (preg_match('/^[\d]{8}$/', $text)) {
        $sum1 = 0;
        $sum2 = 0;

        $codes = array_map('intval', str_split($text));
        $numbers = [1, 2, 1, 2, 1, 2, 4, 1];

        for ($i = 0; $i < 8; $i++) {
            $num = $codes[$i] * $numbers[$i]; // 兩數上下對應相乘
            $num = intval($num / 10) + ($num % 10); // 乘積直寫並上下相加 = 十位數與個位數相加

            if ($i === 6 && $codes[$i] === 7) {
                // 倒數第二位為 7 時, 分別取十位數與個位數再相加
                $sum1 += intval($num / 10); // 十位數
                $sum2 += $num % 10; // 個位數
            } else {
                // 將相加之和再相加
                $sum1 += $num;
                $sum2 += $num;
            }
        }

        return ($sum1 % 10 === 0) || ($sum2 % 10 === 0);
    }

    return false;
};
