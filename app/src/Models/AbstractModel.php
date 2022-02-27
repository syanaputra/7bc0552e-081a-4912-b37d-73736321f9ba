<?php

namespace Models;

use DB\DB;
use Traits\ParameterBagTrait;

/**
 * Class AbstractModel
 */
abstract class AbstractModel {

    use ParameterBagTrait;

    protected static $dbKey;

    /**
     * AbstractModel constructor.
     *
     * @param null $parameters
     */
    public function __construct($parameters = null)
    {
        $this->initialize($parameters);
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->getParameter('id');
    }

    /**
     * @param $id
     */
    public function setId($id) {
        $this->setParameter('id', $id);
    }

    /**
     * @param string $jsonString
     */
    public static function generateDataFromJSON($jsonString = '') {
        $jsonDataList = json_decode($jsonString, true);

        $list = [];
        foreach($jsonDataList as $jsonData) {
            $obj = new static($jsonData);
            $list[$obj->getId()] = $obj;
        }

        DB::set(self::getDbKey(), $list);
    }

    /**
     * @return string
     */
    public static function getDbKey() : string {
        return static::$dbKey ?? strtolower(__CLASS__);
    }

    /**
     * @return array
     */
    public static function get() : array {
        return DB::get(self::getDbKey());
    }

    /**
     * @param $id
     * @return self
     */
    public static function findById($id) : ?self {
        return DB::findById(self::getDbKey(), $id);
    }

}