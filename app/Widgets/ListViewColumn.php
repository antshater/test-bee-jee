<?php


namespace App\Widgets;

use Core\Database\DB;
use Core\Helpers\Html;

class ListViewColumn
{
    private $attribute;
    private $title;
    private $currentDirection;
    private $isOrderColumn;
    private $sortable;

    public function __construct($attribute, $title, $currentDirection, $currentOrder, $sortable)
    {
        $this->attribute = $attribute;
        $this->title = $title;
        $this->currentDirection = $currentDirection;
        $this->isOrderColumn = $this->attribute === $currentOrder;
        $this->sortable = $sortable;
    }

    private function byState($defaultValue, $ascValue, $descValue)
    {
        if (! $this->isOrderColumn) {
            return $defaultValue;
        }

        return $this->currentDirection === DB::ORDER_ASC ? $ascValue : $descValue;
    }

    private function direction()
    {
        return $this->byState(DB::ORDER_ASC, DB::ORDER_DESC, DB::ORDER_ASC);
    }

    private function icon()
    {
        return $this->byState('fa-sort','fa-sort-up', 'fa-sort-down');
    }

    public function render()
    {
        if (! $this->sortable) {
            return $this->title;
        }

        return Html::a(
                '/',
                $this->title,
                ['order' => $this->attribute, 'direction' => $this->direction()],
                [],
                true
            ) . " <i class='fas {$this->icon()}'></i>";
    }
}
