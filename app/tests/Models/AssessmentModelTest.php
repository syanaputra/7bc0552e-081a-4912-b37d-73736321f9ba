<?php

namespace Tests\DB;

use Models\Assessment;
use PHPUnit\Framework\TestCase;

require_once 'autoload.php';

class AssessmentModelTest extends TestCase
{

    public function testGenerateDataFromJSON()
    {
        $jsonString = '[
          {
            "id": "assessment1",
            "name": "Numeracy",
            "questions": [
              {
                "questionId": "numeracy1",
                "position": 1
              }
            ]
          }
        ]';

        Assessment::generateDataFromJSON($jsonString);
        $assessment = Assessment::findById('assessment1');

        $this->assertSame($assessment->getId(), 'assessment1');
    }

    public function testGetId()
    {
        $assessment = new Assessment(
            [
                'id' => 'assessment1',
            ]
        );

        $this->assertSame($assessment->getId(), 'assessment1');
    }

    public function testGetName()
    {
        $assessment = new Assessment(
            [
                'id'     => 'assessment1',
                'name'   => 'Numeracy',
            ]
        );

        $this->assertSame($assessment->getName(), 'Numeracy');
    }

}
