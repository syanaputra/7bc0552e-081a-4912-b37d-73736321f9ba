<?php

namespace Reports;

use Models\Assessment;
use Models\StudentResponse;

/**
 * Class FeedbackReport
 */
class FeedbackReport extends AbstractReport
{

    /**
     * @return array
     */
    public function getData()
    {
        $student = $this->getStudent();
        $studentResponses = StudentResponse::getCompletedDataByStudentID($student->getId());

        // Sort by descending
        usort(
            $studentResponses,
            function ($a, $b) {
                return $a->getCompletedDate() < $b->getCompletedDate();
            }
        );

        $studentResponse = $studentResponses[0];

        return [
            'student'         => $student,
            'studentResponse' => $studentResponse,
        ];
    }

    /**
     * @return mixed|string|null
     */
    public function output()
    {
        $data = $this->getData();

        if (!$data['studentResponse']) {
            return null;
        }

        $outputText = sprintf(
            "%s recently completed %s assessment on %s
He got %d questions right out of %d.",
            $data['student']->getFullName(),
            $data['studentResponse']->getAssessment()->getName() ?? '',
            $data['studentResponse']->getFormattedCompletedDate(),
            $data['studentResponse']->getRawScore(),
            $data['studentResponse']->getTotalQuestions()
        );

        if ($data['studentResponse']->getRawScore() != $data['studentResponse']->getTotalQuestions()) {
            $outputText .= sprintf(
                "Feedback for wrong answers given below
%s",
                $data['studentResponse']->getFormattedFeedbackReport()
            );
        }

        return $outputText;
    }

}