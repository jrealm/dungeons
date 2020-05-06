<?php //>

namespace dungeons\web\backend;

use dungeons\Config;
use dungeons\db\Criteria;
use dungeons\web\BackendController;

class ListController extends BackendController {

    public function __construct($tableName = null) {
        parent::__construct();

        if ($tableName) {
            $this->table(table($tableName));
        }

        $this->exportFormat('xlsx');
        $this->view('backend/list.php');
    }

    public function remix($styles, $list) {
        return $styles;
    }

    protected function preprocess($form) {
        $relation = $this->table()->getMasterRelation();

        if ($relation) {
            $form[$relation['column']->name()] = $this->args()[0];
        }

        return $form;
    }

    protected function process($form) {
        $criteria = Criteria::createAnd();

        foreach ($this->filters() ?? [] as $name => $column) {
            $from = @$form[$name];
            $to = @$form["-{$name}"];

            if ($from === null) {
                if ($to === null) {
                    continue;
                } else {
                    $from = $to;
                    $to = null;
                }
            }

            switch ($column->searchStyle()) {
            case 'like':
                $criteria->add($column->like("%{$from}%", true));
                break;
            case 'between':
                if ($to !== null) {
                    $criteria->add($column->between($from, $to));
                    break;
                }
            default:
                $criteria->add($column->equal($from));
            }

            unset($form[$name], $form["-{$name}"]);
        }

        $export = @$form['t'];

        if ($export) {
            $page = 1;
            $size = 0;
        } else {
            $page = $this->positive_integer(@$form['p'], 1);
            $size = $this->positive_integer(@$form['s'], 10);
        }

        $orders = preg_split('/[, ]/', @$form['o'], 0, PREG_SPLIT_NO_EMPTY);

        if (!$criteria->size() && !$export && $this->passive() === true) {
            $count = 0;
            $data = null;
        } else {
            $form[] = $criteria;
            $form[] = $this->groupFilter(@$form['g']);

            if ($export) {
                $args = @$form['args'];

                if ($args && is_array($args)) {
                    $form[] = $this->table()->id->in($args);
                }
            }

            $model = $this->table()->model();

            $count = $model->count($form);
            $data = $count ? $model->query($form, $orders ?: true, $size, $page) : [];
        }

        return [
            'success' => true,
            'export' => $export,
            'count' => $count,
            'data' => $data,
            'page' => $page,
            'size' => $size,
            'orders' => $orders,
        ];
    }

    protected function wrap() {
        $form = $this->wrapGet();
        $search = @$form['q'];

        if ($search) {
            $search = json_decode(base64_urldecode($search), true);

            foreach ($this->filters() ?? [] as $name => $column) {
                foreach ([$name, "-{$name}"] as $token) {
                    $value = @$search[$token];

                    if ($value !== null) {
                        $value = urldecode($value);

                        if ($column->searchStyle() === 'like' || !validate($value, $column)) {
                            $form[$token] = $value;
                        }
                    }
                }
            }
        }

        return array_merge($this->wrapJson(), $form);
    }

    private function groupFilter($group) {
        $criteria = Criteria::createAnd();
        $enable = $this->table()->enableTime();
        $enable = $enable ? $this->table()->$enable : null;
        $disable = $this->table()->disableTime();
        $disable = $disable ? $this->table()->$disable : null;
        $now = date(Config::get('system.timestamp'));

        switch ($group) {
        case 1:
            if ($enable) {
                $criteria->add($enable->notNull());
                $criteria->add($enable->lessThanOrEqual($now));
            }
            if ($disable) {
                $criteria->add(Criteria::createOr($disable->isNull(), $disable->greaterThan($now)));
            }
            break;
        case 2:
            if ($disable) {
                $criteria->add($disable->notNull());
                $criteria->add($disable->lessThanOrEqual($now));
            }
            if ($enable) {
                $criteria = Criteria::createOr($enable->isNull(), $enable->greaterThan($now), $criteria);
            }
            break;
        case 3:
            if ($enable) {
                $criteria->add($enable->notNull());
                $criteria->add($enable->greaterThan($now));
            }
            break;
        case 4:
            if ($disable) {
                if ($enable) {
                    $criteria->add($enable->notNull());
                    $criteria->add($enable->lessThanOrEqual($now));
                }
                $criteria->add($disable->notNull());
                $criteria->add($disable->greaterThan($now));
            }
            break;
        }

        return $criteria;
    }

    private function positive_integer($value, $default) {
        if (is_scalar($value)) {
            $value = intval($value);

            if ($value > 0) {
                return $value;
            }
        }

        return $default;
    }

}
