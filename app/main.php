<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/autoload.php';

// Load Data
\Helpers\DataLoader::run();

// Run
\Helpers\CLI::write('Please enter the following');
$studentId = \Helpers\CLI::read('Student ID: ');
$student = \Models\Student::findById($studentId);
if (!$student) {
    \Helpers\CLI::write('ERROR: Student not found');
    exit;
}

$reportType = \Helpers\CLI::read('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback): ');

$report = null;
switch($reportType) {
    case 1:
        $report = new \Reports\DiagnosticReport($student);
        break;
    case 2:
        $report = new \Reports\ProgressReport($student);
        break;
    case 3:
        $report = new \Reports\FeedbackReport($student);
        break;
    default:
        break;
}

if ($report) {
    \Helpers\CLI::write($report->output());
}
