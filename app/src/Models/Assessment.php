<?php

namespace Models;

/**
 * Class Assessment
 */
class Assessment extends AbstractModel {

    protected static $dbKey = 'assessments';

    /**
     * @return mixed
     */
    public function getName() {
        return $this->getParameter('name');
    }

}