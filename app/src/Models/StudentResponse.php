<?php

namespace Models;

use Helpers\DateTimeHelper;

/**
 * Class StudentResponse
 */
class StudentResponse extends AbstractModel
{

    protected static $dbKey = 'studentResponses';

    /**
     * @return Assessment|null
     */
    public function getAssessment()
    {
        return Assessment::findById($this->getParameter('assessmentId'));
    }

    /**
     * @return \DateTime|false|null
     */
    public function getCompletedDate()
    {
        $dateTime = $this->getParameter('completed');

        if (!$dateTime) {
            return null;
        }

        return DateTimeHelper::createDateTime($dateTime);
    }

    /**
     * @param bool $withTime
     * @return string|null
     */
    public function getFormattedCompletedDate($withTime = true)
    {
        $dateTime = $this->getParameter('completed');

        if (!$dateTime) {
            return null;
        }

        return DateTimeHelper::formatNicely($dateTime, $withTime);
    }

    /**
     * @return mixed
     */
    public function getRawScore()
    {
        return $this->getParameter('results')['rawScore'];
    }

    /**
     * @return mixed
     */
    public function getTotalQuestions()
    {
        return sizeof($this->getParameter('responses'));
    }

    /**
     * @return mixed
     */
    public function getStudentId()
    {
        return $this->getParameter('student')['id'];
    }

    /**
     * @return string
     */
    public function getFormattedDiagnosticReport()
    {
        $list = $this->getDiagnosticReport();

        $output = [];
        foreach ($list as $item) {
            $output[] = sprintf(
                "%s: %d out of %d correct",
                $item['strand'],
                $item['correct'],
                $item['total']
            );
        }

        return implode("\n", $output);
    }

    /**
     * @return array
     */
    public function getDiagnosticReport()
    {
        $responses = $this->getParameter('responses');

        $report = [];
        foreach ($responses as $response) {
            // Get strand
            $question = Question::findById($response['questionId']);
            $strand = $question->getStrand();
            $isCorrect = $question->isAnswerCorrect($response['response']);

            if (!isset($report[$strand])) {
                $report[$strand] = [
                    'strand'  => $strand,
                    'correct' => 0,
                    'total'   => $this->getTotalQuestions(),
                ];
            }

            if ($isCorrect) {
                $report[$strand]['correct']++;
            }
        }

        return $report;
    }

    /**
     * @return string
     */
    public function getFormattedFeedbackReport()
    {
        $list = $this->getFeedbackReport();

        $output = [];
        foreach ($list as $item) {
            $output[] = sprintf(
                "
Question: %s
Your answer: %s with value %s
Right answer: %s with value %s
Hint: %s",
                $item['question'],
                $item['currentAnswer']['label'],
                $item['currentAnswer']['value'],
                $item['correctAnswer']['label'],
                $item['correctAnswer']['value'],
                $item['hint']
            );
        }

        return implode("\n", $output);
    }

    /**
     * @return array
     */
    public function getFeedbackReport()
    {
        $responses = $this->getParameter('responses');

        $report = [];
        foreach ($responses as $response) {
            // Get strand
            $question = Question::findById($response['questionId']);
            $isCorrect = $question->isAnswerCorrect($response['response']);

            if (!$isCorrect) {
                $report[] = [
                    'question'      => $question->getQuestion(),
                    'currentAnswer' => $question->getOptionAnswerById($response['response']),
                    'correctAnswer' => $question->getCorrectAnswer(),
                    'hint'          => $question->getHint(),
                ];
            }
        }

        return $report;
    }

    /**
     * @param $studentId
     * @return AbstractModel
     */
    public static function getDataByStudentID($studentId)
    {
        return array_filter(
            self::get(),
            function ($item) use ($studentId) {
                return $item->getStudentId() === $studentId;
            }
        );
    }

    /**
     * @param $studentId
     * @return AbstractModel
     */
    public static function getCompletedDataByStudentID($studentId)
    {
        return array_filter(
            self::get(),
            function ($item) use ($studentId) {
                return $item->getStudentId() === $studentId && $item->getCompletedDate() !== null;
            }
        );
    }

}