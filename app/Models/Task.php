<?php


namespace App\Models;

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
}
