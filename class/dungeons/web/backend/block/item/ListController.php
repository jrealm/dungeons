<?php //>

namespace dungeons\web\backend\block\item;

use dungeons\Config;
use dungeons\Message;
use dungeons\web\backend\ListController as Controller;
use dungeons\web\backend\SubList;

class ListController extends Controller {

    use SubList;

    public function remix($styles, $list) {
        $data = array_pop($list);
        $sub = Config::load("module/{$data['module']}")['sub-module'];

        $fields = [];
        $module = Config::load("sub-module/{$sub}");
        $table = $this->table();

        foreach ($module['fields'] as $field) {
            $name = $field['name'];

            if (!isset($table->{$name})) {
                continue;
            }

            $field['i18n'] = Message::defined("module/{$sub}.{$name}", "block.{$name}");
            $field['label'] = $field['i18n'] === null ? $name : null;
            $field['readonly'] = true;

            switch ($name) {
            case 'title':
            case 'content':
            case 'url':
                $field['column'] = $table->{$name};
                break;
            default:
                $field['unordered'] = true;
            }

            $fields[] = $field;
        }

        array_splice($styles, 0, 0, $fields);

        return $styles;
    }

    protected function init() {
        $this->columns($this->table()->getColumns([
            'enable_time',
            'disable_time',
            'ranking',
        ]));
    }

}
