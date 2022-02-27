<?php

namespace Reports;

use Models\Student;
use Traits\ParameterBagTrait;

/**
 * Class AbstractReport
 */
abstract class AbstractReport {

    private $student;

    /**
     * AbstractReport constructor.
     *
     * @param $student
     */
    public function __construct(Student $student)
    {
        $this->setStudent($student);
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    abstract function getData();

    /**
     * @return mixed
     */
    abstract function output();

}