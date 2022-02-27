<?php

namespace Models;

use helpers\DB;

/**
 * Class Student
 */
class Student extends AbstractModel {

    protected static $dbKey = 'students';

    public function getFullName() {
        return $this->getParameter('firstName') . ' ' . $this->getParameter('lastName');
    }

}