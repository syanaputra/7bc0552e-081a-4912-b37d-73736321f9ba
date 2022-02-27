<?php

namespace Models;

/**
 * Class Question
 */
class Question extends AbstractModel {

    protected static $dbKey = 'questions';

    /**
     * @return mixed
     */
    public function getQuestion() {
        return $this->getParameter('stem');
    }

    /**
     * @return mixed
     */
    public function getStrand() {
        return $this->getParameter('strand');
    }

    /**
     * @return mixed
     */
    public function getHint() {
        return $this->getParameter('config')['hint'];
    }

    /**
     * @return mixed
     */
    public function getCorrectOptionId() {
        return $this->getParameter('config')['key'];
    }

    /**
     * @return mixed|null
     */
    public function getCorrectAnswer() {
        return $this->getOptionAnswerById($this->getCorrectOptionId());
    }

    /**
     * @return mixed|null
     */
    public function getOptionAnswerById($optionId) {
        $options = $this->getOptions();

        foreach($options as $option) {
            if ($option['id'] == $optionId) {
                return $option;
            }
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getOptions() {
        return $this->getParameter('config')['options'];
    }

    /**
     * @param $optionId
     * @return bool
     */
    public function isAnswerCorrect($optionId) {
        return $this->getCorrectOptionId() == $optionId;
    }

}