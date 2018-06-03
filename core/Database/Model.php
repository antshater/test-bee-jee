<?php


namespace Core\Database;

use Core\Helpers\ArrayHelper;

abstract class Model
{
    protected $primaryKey = 'id';
    private $attributes = [];

    public function __construct($attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            if (!in_array($attribute, $this->attributes())) {
                return;
            }

            $this->attributes[$attribute] = $value;
        }
    }

    public function exists(): bool
    {
        return $this->attributes[$this->primaryKey] !== null;
    }

    public function save(): Model
    {
        return $this->exists() ? $this->update() : $this->create();
    }

    public static function getList($limit, $offset, $order, $orderDirection): array
    {
        $data = DB::instance()->select(
            (new static())->table(),
            null,
            null,
            $limit,
            $offset,
            $order,
            $orderDirection
        );

        return array_map(function ($item) {
            return new static($item);
        }, $data);
    }

    public static function find($id): ?Model
    {
        $data = DB::instance()->select((new static())->table(), null, compact('id'));
        return isset($data[0]) ? new static($data[0]) : null;
    }

    public static function count(): int
    {
        $data = DB::instance()->select((new static())->table(), ['COUNT(*) as count']);
        return (int)$data[0]['count'];
    }

    private function getAttributes(): array
    {
        $attributes = [];
        foreach ($this->attributes() as $attribute) {
            $attributes[$attribute] = $this->attributes[$attribute];
        }

        return $attributes;
    }

    private function update(): Model
    {
        DB::instance()->update($this->table(), $this->getAttributes(), [$this->primaryKey => $this->{$this->primaryKey}]);
        return $this;
    }

    private function create(): Model
    {
        $primary = DB::instance()->insert($this->table(), $this->getAttributes());
        $this->attributes[$this->primaryKey] = $primary;
        return $this;
    }

    public function __get($name)
    {
        return ArrayHelper::extract($this->attributes, $name);
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    abstract protected function attributes(): array;

    abstract protected function table(): string;
}
