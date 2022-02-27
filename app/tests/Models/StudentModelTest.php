<?php

namespace Tests\DB;

use Models\Student;
use PHPUnit\Framework\TestCase;

require_once 'autoload.php';

class StudentModelTest extends TestCase
{

    public function testGenerateDataFromJSON()
    {
        $jsonString = '[{
            "id": "student1",
            "firstName": "Tony",
            "lastName": "Stark",
            "yearLevel": 6
        }]';

        Student::generateDataFromJSON($jsonString);
        $student = Student::findById('student1');

        $this->assertSame($student->getId(), 'student1');
    }

    public function testGetId()
    {
        $student = new Student(
            [
                'id' => 'student1',
            ]
        );

        $this->assertSame($student->getId(), 'student1');
    }

    public function testGetFullName()
    {
        $student = new Student(
            [
                'id' => 'student1',
                'firstName' => 'John',
                'lastName' => 'Doe',
            ]
        );

        $this->assertSame($student->getFullName(), 'John Doe');
    }

}
