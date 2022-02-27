<?php

namespace Helpers;

use Models\Assessment;
use Models\Question;
use Models\Student;
use Models\StudentResponse;

/**
 * Class DataLoader
 */
class DataLoader {
    /**
     * @var string
     */
    private static $DATA_DIR = '/data/';

    /**
     *
     */
    public static function run() {
        self::loadData('assessments.json', Assessment::class);
        self::loadData('questions.json', Question::class);
        self::loadData('students.json', Student::class);
        self::loadData('student-responses.json', StudentResponse::class);
    }

    /**
     * @param $filename
     * @param $class
     */
    private static function loadData($filename, $class) {
        $class::generateDataFromJSON(self::readFile($filename));
    }

    /**
     * @param $filename
     * @return false|string
     */
    private static function readFile($filename) {
        $folder = getcwd() . self::$DATA_DIR;
        $fullFilename = $folder . $filename;
        return file_get_contents($fullFilename);
    }

}