<?php

namespace Tests\DB;

use Models\AbstractModel;
use Models\Question;
use PHPUnit\Framework\TestCase;

require_once 'autoload.php';

class QuestionModelTest extends TestCase
{

    public function testGenerateDataFromJSON()
    {
        $jsonString = '[{
            "id": "numeracy1",
            "stem": "What is the value of 2 + 3 x 5?",
            "type": "multiple-choice",
            "strand": "Number and Algebra",
            "config": {
                "options": [
                    { "id": "option1", "label": "A", "value": "10" },
                    { "id": "option2", "label": "B", "value": "15" },
                    { "id": "option3", "label": "C", "value": "17" },
                    { "id": "option4", "label": "D", "value": "25" }
                ],
                "key": "option3",
                "hint": "Work out the multiplication sign BEFORE the addition sign"
            }
        }]';

        Question::generateDataFromJSON($jsonString);
        $question = Question::findById('numeracy1');

        $this->assertSame($question->getId(), 'numeracy1');
    }

    public function testGetId()
    {
        $question = new Question(
            [
                'id' => 'numeracy1',
            ]
        );

        $this->assertSame($question->getId(), 'numeracy1');
    }

    public function testGetQuestion()
    {
        $question = new Question(
            [
                'id'     => 'numeracy1',
                'stem'   => 'What is the value of 2 + 3 x 5?',
                'type'   => 'multiple-choice',
                'strand' => 'Number and Algebra',
            ]
        );

        $this->assertSame($question->getQuestion(), 'What is the value of 2 + 3 x 5?');
    }

    public function testGetStrand()
    {
        $question = new Question(
            [
                'id'     => 'numeracy1',
                'stem'   => 'What is the value of 2 + 3 x 5?',
                'type'   => 'multiple-choice',
                'strand' => 'Number and Algebra',
            ]
        );

        $this->assertSame($question->getStrand(), 'Number and Algebra');
    }

    public function testGetHint()
    {
        $question = new Question(
            [
                'id'     => 'numeracy1',
                'config' => [
                    'hint' => 'Work out the multiplication sign BEFORE the addition sign'
                ]
            ]
        );

        $this->assertSame($question->getHint(), 'Work out the multiplication sign BEFORE the addition sign');
    }

    public function testGetCorrectOptionId()
    {
        $question = new Question(
            [
                'id'     => 'numeracy1',
                'config' => [
                    'key' => 'option3'
                ]
            ]
        );

        $this->assertSame($question->getCorrectOptionId(), 'option3');
    }

    public function testGetCorrectAnswer()
    {
        $question = new Question(
            [
                'id'     => 'numeracy1',
                'config' => [
                    'key' => 'option1',
                    "options" => [
                        ["id" => "option1", "label" => "A", "value" => "10"],
                        ["id" => "option2", "label" => "B", "value" => "15"],
                    ],
                ]
            ]
        );

        $this->assertSame($question->getCorrectAnswer()['value'], '10');
    }

    public function testGetOptionAnswerById()
    {
        $question = new Question(
            [
                'id'     => 'numeracy1',
                'config' => [
                    'key' => 'option1',
                    "options" => [
                        ["id" => "option1", "label" => "A", "value" => "10"],
                        ["id" => "option2", "label" => "B", "value" => "15"],
                    ],
                ]
            ]
        );

        $this->assertSame($question->getOptionAnswerById('option1')['value'], '10');
    }

    public function testGetOptions()
    {
        $question = new Question(
            [
                'id'     => 'numeracy1',
                'config' => [
                    'key' => 'option1',
                    "options" => [
                        ["id" => "option1", "label" => "A", "value" => "10"],
                        ["id" => "option2", "label" => "B", "value" => "15"],
                    ],
                ]
            ]
        );

        $this->assertSame($question->getOptions()[0]['id'], 'option1');
        $this->assertSame($question->getOptions()[1]['id'], 'option2');
    }

    public function testIsAnswerCorrect()
    {
        $question = new Question(
            [
                'id'     => 'numeracy1',
                'config' => [
                    'key' => 'option3'
                ]
            ]
        );

        $this->assertTrue($question->isAnswerCorrect('option3'));
    }


}
