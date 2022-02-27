<?php

namespace Reports;

use Models\Assessment;
use Models\StudentResponse;

/**
 * Class ProgressReport
 */
class ProgressReport extends AbstractReport
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

        // Group by assessment
        $responseGroupedByAssessment = [];
        foreach ($studentResponses as $studentResponse) {
            $assessment = $studentResponse->getAssessment();
            $assessmentId = $assessment->getId();

            if (!isset($responseGroupedByAssessment[$assessmentId])) {
                $responseGroupedByAssessment[$assessmentId] = [
                    'assessment'       => $assessment,
                    'total'            => 0,
                    'studentResponses' => [],
                ];
            }

            $responseGroupedByAssessment[$assessmentId]['total']++;
            $responseGroupedByAssessment[$assessmentId]['studentResponses'][] = $studentResponse;
        }

        return [
            'student'                     => $student,
            'responseGroupedByAssessment' => $responseGroupedByAssessment,
        ];
    }

    /**
     * @return mixed|string|null
     */
    public function output()
    {
        $data = $this->getData();

        if (!$data['responseGroupedByAssessment'] || sizeof($data['responseGroupedByAssessment']) <= 0) {
            return null;
        }

        $output = '';

        foreach ($data['responseGroupedByAssessment'] as $response) {
            $output .= sprintf(
                "%s has completed %s assessment %d times in total. Date and raw score given below:\n",
                $data['student']->getFullName(),
                $response['assessment']->getName(),
                $response['total']
            );

            // Breakdown for the responses
            $breakdown = [];
            foreach ($response['studentResponses'] as $studentResponse) {
                $breakdown[] = sprintf("Date: %s, Raw Score: %d out of %d", $studentResponse->getFormattedCompletedDate(false), $studentResponse->getRawScore(), $studentResponse->getTotalQuestions());
            }

            $output .= "\n" . implode("\n", $breakdown);

            // Summary
            $oldestResponse = $response['studentResponses'][$response['total'] - 1];
            $newestResponses = $response['studentResponses'][0];
            if ($oldestResponse && $newestResponses && $oldestResponse->getId() != $newestResponses->getId()) {
                $difference = $newestResponses->getRawScore() - $oldestResponse->getRawScore();
                $output .= "\n\n" . sprintf(
                        "%s got %d %s correct in the recent completed assessment than the oldest",
                        $data['student']->getFullName(),
                        $difference,
                        $difference > 0 ? 'more' : 'less'
                    );
            }

            $output .= "\n";
        }

        return $output;
    }

}