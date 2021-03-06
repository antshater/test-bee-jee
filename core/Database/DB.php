<?php


namespace Core\Database;

use Core\App;
use Core\Exceptions\SqlException;
use PDO;
use PDOStatement;

class DB
{
    const ORDER_DESC = 'DESC';
    const ORDER_ASC = 'ASC';

    private static $instance;

    private $pdo;

    private function __construct(array $config)
    {
        $this->pdo = new PDO($config['dsn'], $config['user'], $config['password']);
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self(App::config('database'));
        }

        return self::$instance;
    }

    public function queryRaw(string $sql, array $params = []): PDOStatement
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        if ((int)$statement->errorCode()) {
            throw new SqlException($statement->errorInfo()[2]);
        }

        return $statement;
    }

    public function update(string $table, array $update_attributes, array $condition_attributes): PDOStatement
    {
        $updates = [];
        foreach ($update_attributes as $attribute => $value) {
            $updates[] = "$attribute = ?";
            $params[] = $value;
        }

        foreach ($condition_attributes as $attribute => $value) {
            $conditions[] = "$attribute = ?";
            $params[] = $value;
        }

        if (!$conditions) {
            throw new SqlException("Не переданы условия в апдейт таблицы $table");
        }

        $sql = "UPDATE $table SET " . implode(',', $updates) . " WHERE " . implode(' AND ', $conditions);

        return $this->queryRaw($sql, $params);
    }

    public function insert(string $table, array $attributes): int
    {
        $attribute_names = array_keys($attributes);
        $values = array_values($attributes);
        $params = $values;
        $values_placements = array_fill(0, count($values), '?');
        $sql = "INSERT INTO $table (" . implode(',', $attribute_names) . ") VALUES (" . implode(",", $values_placements) . ")";
        $this->queryRaw($sql, $params);
        return $this->pdo->lastInsertId();
    }

    public function select(
        $table,
        $fields = null,
        $conditions = null,
        $limit = null,
        $offset = null,
        $order = null,
        $orderDirection = null
    ): array {
        $fields = $fields ? implode(',', $fields) : '*';

        $sql = "SELECT $fields FROM $table ";

        if ($order !== null) {
            $sql .= "ORDER BY $order ";
            if ($orderDirection !== null) {
                $sql .= "$orderDirection ";
            }
        }

        if ($limit !== null) {
            $limit = (int)$limit;
            $sql .= "LIMIT $limit ";
        }

        if ($offset !== null) {
            $offset = (int)$offset;
            $sql .= "OFFSET $offset ";
        }

        $params = [];
        if ($conditions) {
            $sqlParts = [];
            foreach ($conditions as $attribute => $value) {
                $sqlParts[] = "$attribute = ?";
                $params[] = $value;
            }

            $sql .= 'WHERE ' . implode(' AND ', $sqlParts);
        }

        $statement = $this->queryRaw($sql, $params);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
