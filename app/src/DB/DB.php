<?php
namespace DB;

/**
 * Class DB
 */
class DB {

    /**
     * @var
     */
    private static $dataList;

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value) {
        self::$dataList[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        return self::$dataList[$key];
    }

    /**
     * @param $key
     * @param $id
     * @return mixed
     */
    public static function findById($key, $id) {
        $data = self::get($key);
        if (!$data) {
            return null;
        }

        return $data[$id] ?? null;
    }


}