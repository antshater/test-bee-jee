<?php


namespace App\Widgets;

use Core\App;
use Core\Database\DB;
use Core\Request\Request;

class ListView
{
    private $modelClass;
    private $request;
    private $columns;
    private $currentOrder;
    private $currentDirection;
    private $items;
    private $page;
    private $itemsCount;

    public function __construct(string $modelClass, array $columns, Request $request)
    {
        $this->modelClass = $modelClass;
        $this->request = $request;
        $this->columns = $columns;
        $this->currentOrder = $request->get('order');
        $this->currentDirection = $request->get('direction');
        $this->page = $request->get('page', 1);
        $order = $request->get('order', 'id');
        $direction = $request->get('direction', DB::ORDER_DESC);

        $this->items = $modelClass::getList($this->itemsOnPage(), $this->offset(), $order, $direction);
        $this->itemsCount = $modelClass::count();
    }

    public function items(): array
    {
        return $this->items;
    }

    public function columns(): array
    {
        return array_map(function ($item) {
            list($attribute, $title, $sortable) = $item;
            if ($sortable === null) {
                $sortable = true;
            }
            return new ListViewColumn($attribute, $title, $this->currentDirection, $this->currentOrder, $sortable);
        }, $this->columns);
    }

    public function pagination(): array
    {
        return array_map(function ($page_num) {
            return [
                'number' => $page_num,
                'active' => $page_num == $this->page,
            ];
        }, range(1, $this->pageCount()));
    }

    private function itemsOnPage(): int
    {
        return App::config('items-on-page');
    }

    private function pageCount(): int
    {
        return ceil($this->itemsCount / $this->itemsOnPage());
    }

    private function offset(): int
    {
        return ($this->page - 1) * $this->itemsOnPage();
    }
}
