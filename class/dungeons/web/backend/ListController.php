<?php //>

namespace dungeons\web\backend;

use dungeons\db\Criteria;
use dungeons\web\BackendController;

class ListController extends BackendController {

    public function __construct($tableName = null) {
        parent::__construct();

        if ($tableName) {
            $this->table(table($tableName));
        }

        $this->exportFormat('xlsx');
        $this->defaultRanking(true);
        $this->view('backend/list.php');
    }

    public function remix($styles, $list) {
        return $styles;
    }

    protected function process($form) {
        $criteria = $this->criteria();
        $export = @$form['t'];

        if ($export) {
            $page = 1;
            $size = 0;
        } else {
            $setting = $this->loadSetting();

            $page = $this->positive_integer(@$form['p'], $this->defaultPage() ?? 1);
            $size = $this->positive_integer(@$form['s'], $setting['pageSize'] ?? 10);
        }

        $orders = preg_split('/[, ]/', @$form['o'], 0, PREG_SPLIT_NO_EMPTY);

        if (!$criteria && !$export && $this->passive() === true) {
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

            if ($count <= ($page - 1) * $size) {
                $page = intval(ceil($count / $size));
            }

            $data = $count ? $model->query($form, $orders ?: $this->defaultRanking(), $size, $page) : [];
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
        $form = parent::wrap();
        $search = @$form['q'];

        if ($search) {
            $columns = $this->table()->getColumns();
            $conditions = [];
            $search = json_decode(base64_urldecode($search), true);

            foreach ($columns as $name => $column) {
                foreach ([$name, "-{$name}"] as $token) {
                    $value = @$search[$token];

                    if ($value !== null) {
                        $value = urldecode($value);

                        if ($column->searchStyle() === 'like' || !validate($value, $column)) {
                            $conditions[$token] = $value;
                        }
                    }
                }
            }

            if ($conditions) {
                $criteria = Criteria::createAnd();

                foreach ($columns as $name => $column) {
                    $from = @$conditions[$name];
                    $to = @$conditions["-{$name}"];

                    if ($from === null && $to === null) {
                        continue;
                    }

                    switch ($column->searchStyle()) {
                    case 'like':
                        $criteria->add($column->like("%{$from}%", true));
                        break;
                    case 'between':
                        if ($from !== $to && !$column->association() && !$column->options()) {
                            if ($from === null) {
                                $criteria->add($column->lessThanOrEqual($to));
                            } else if ($to === null) {
                                $criteria->add($column->greaterThanOrEqual($from));
                            } else {
                                $criteria->add($column->between($from, $to));
                            }
                            break;
                        }
                    default:
                        $criteria->add($column->equal($from));
                    }

                    $column->inSearch(true);
                }

                $this->conditions($conditions);
                $this->criteria($criteria);
            }
        }

        return $form;
    }

    private function groupFilter($group) {
        $criteria = Criteria::createAnd();
        $enable = $this->table()->enableTime();
        $enable = $enable ? $this->table()->{$enable} : null;
        $disable = $this->table()->disableTime();
        $disable = $disable ? $this->table()->{$disable} : null;
        $now = date(cfg('system.timestamp'));

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
