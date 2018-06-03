<?php


namespace App\Models;

use Core\Database\DB;
use Core\Database\Model;

/**
 * Class Task
 * @property integer $id
 * @property string $description
 * @property string $user_name
 * @property string $email
 * @property string $image
 * @property bool $completed
 */
class Task extends Model
{
    protected function table(): string
    {
        return 'tasks';
    }

    protected function attributes(): array
    {
        return [
            'description',
            'user_name',
            'email',
            'image',
            'id',
            'completed',
        ];
    }

    public static function listColumns($currentOrder, $currentDirection)
    {
        return array_map(function ($item) use ($currentOrder, $currentDirection) {
            list($attribute, $title) = $item;
            if ($currentOrder !== $attribute) {
                $dir = DB::ORDER_ASC;
                $icon = 'fa-sort';
            } else {
                $dir = $currentDirection === DB::ORDER_ASC ? DB::ORDER_DESC : DB::ORDER_ASC;
                $icon = $currentDirection === DB::ORDER_DESC ? 'fa-sort-down' : 'fa-sort-up';
            }

            return [
                'attribute' => $attribute,
                'title' => $title,
                'direction' => $dir,
                'icon' => $icon
            ];

        }, [['user_name', 'Имя пользователя'], ['email', 'Email'], ['completed', 'Статус']]);
    }
}
