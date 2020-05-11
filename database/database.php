<?php

use Medoo\Medoo;

class DB
{
    public static function connect()
    {
        return new Medoo([
            'database_type' => 'mysql',
            'server'        => config('database.host'),
            'port'          => config('database.port'),
            'database_name' => config('database.database'),
            'username'      => config('database.username'),
            'password'      => config('database.password')
        ]);
    }

    /**
     * Select data from database
     *
     * @param string $table
     * @param array $columns
     * @param array $where
     * 
     * @return array|null
     */
    public static function select($table, $columns, $where)
    {
        $db = self::connect();

        return $db->select($table, $columns, $where);
    }

    /**
     * Select data from database
     *
     * @param string $table
     * @param array $columns
     * @param array $where
     * @param array $join
     * 
     * @return array|null
     */
    public static function join($table, $columns, $where, $join)
    {
        $db = self::connect();

        return $db->select($table, $join, $columns, $where);
    }

    /**
     * Get only one record from table
     *
     * @param string $table
     * @param array $columns
     * @param array|int $where
     * 
     * @return array|null
     */
    public static function get($table, $columns, $where)
    {
        $db = self::connect();

        return $db->get($table, $columns, $where);
    }

    /**
     * Insert new records in table
     *
     * @param string $table
     * @param array $data
     * 
     * @return array
     */
    public static function create($table, $data)
    {
        $db = self::connect();

        return $db->insert($table, $data);
    }

    /**
     * Modify data in table
     *
     * @param string $table
     * @param array $data
     * @param array|int $where
     * 
     * @return array|null
     */
    public static function update($table, $data, $where)
    {
        $db = self::connect();

        return $db->update($table, $data, $where);
    }

    /**
     * Delete data from table
     *
     * @param string $table
     * @param array $where
     * 
     * @return array|null
     */
    public static function delete($table, $where)
    {
        $db = self::connect();

        return $db->delete($table, ["AND" => $where]);
    }

    /**
     * Determine whether the target data existed
     *
     * @param string $table
     * @param array $where
     * 
     * @return array|null
     */
    public static function has($table, $where)
    {
        $db = self::connect();

        return $db->has($table, $where);
    }
}
