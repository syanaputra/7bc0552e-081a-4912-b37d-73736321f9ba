<?php

namespace Reports;

use Models\StudentResponse;

/**
 * Class DiagnosticReport
 */
class DiagnosticReport extends AbstractReport
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

        return [
            'student'         => $student,
            'studentResponse' => $studentResponses[0] ?? null,
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

        return sprintf(
            "%s recently completed %s assessment on %s
He got %d questions right out of %d. Details by strand given below: \n
%s",
            $data['student']->getFullName(),
            $data['studentResponse']->getAssessment()->getName(),
            $data['studentResponse']->getFormattedCompletedDate(),
            $data['studentResponse']->getRawScore(),
            $data['studentResponse']->getTotalQuestions(),
            $data['studentResponse']->getFormattedDiagnosticReport()
        );
    }

}