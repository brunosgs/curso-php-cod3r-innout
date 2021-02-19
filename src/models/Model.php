<?php

class Model
{
    protected static $tableName = '';
    protected static $columns = [];
    protected $values = [];

    // Construtor
    function __construct($arr)
    {
        $this->loadFromArray($arr);
    }

    // Métodos mágicos get/set
    public function __get($key)
    {
        return $this->values[$key];
    }

    public function __set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function loadFromArray($arr)
    {
        if ($arr) {
            foreach ($arr as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public static function get($filters = [], $columns = '*')
    {
        $objects = [];
        $result = static::getResultSetFromSelect($filters, $columns);

        if ($result) {
            $class = get_called_class(); // Obtém o nome da classe em que o método estático é chamado.

            while ($row = $result->fetch_assoc()) {
                array_push($objects, new $class($row));
            }
        }

        return $objects;
    }

    // Gera o select conforme os parametros passados
    public static function getResultSetFromSelect($filters = [], $columns = '*')
    {
        $sql = "select $columns from " . static::$tableName . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql);

        if ($result->num_rows === 0) {
            return null;
        } else {
            return $result;
        }
    }

    // Filtro para o SQL
    private static function getFilters($filters)
    {
        $sql = '';

        if (count($filters) > 0) {
            $sql .= " where 1 = 1";

            foreach ($filters as $column => $value) {
                $sql .= " and $column = " . static::getFormatedValue($value);
            }
        }

        return $sql;
    }

    private static function getFormatedValue($value)
    {
        if (is_null($value)) {
            return 'null';
        } elseif (gettype($value) === 'string') {
            return "'$value'";
        } else {
            return $value;
        }
    }
}
