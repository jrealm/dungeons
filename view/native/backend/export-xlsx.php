<?php //>

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function setValue($sheet, $x, $y, $value) {
    if (is_string($value)) {
        $sheet->setCellValueExplicitByColumnAndRow($x, $y, $value, DataType::TYPE_STRING);
    } else {
        $sheet->setCellValueByColumnAndRow($x, $y, $value);
    }
}

$sheets = new Spreadsheet();
$sheet = $sheets->getActiveSheet();

$x = 1;
$y = 1;

foreach ($result['styles'] as $style) {
    setValue($sheet, $x++, $y, $style['label']);
}

foreach ($result['data'] as $data) {
    $x = 1;
    $y++;

    foreach ($result['styles'] as $style) {
        $value = $data[$style['name']];

        if (is_bool($value)) {
            $value = var_export($value, true);
        }

        if (key_exists('options', $style) && key_exists($value, $style['options'])) {
            $value = $style['options'][$value];
        }

        setValue($sheet, $x++, $y, $value);
    }
}

$file = tempnam(sys_get_temp_dir(), '');
$timestamp = date('YmdHis');
$title = $controller->table()->name();

$sheet->setTitle($title);

(new Xlsx($sheets))->save($file);

$result = [
    'type' => 'download',
    'filename' => "{$title}-{$timestamp}.xlsx",
    'content' => base64_encode(file_get_contents($file)),
    'contentType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
];

unlink($file);

require __DIR__ . '/../raw.php';
