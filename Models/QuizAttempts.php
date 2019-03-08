<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuizAttempts
 *
 * @author misty
 */
class QuizAttempts {
    
    private $quizAttempts = [];
    private $quizTaker;
    private $db;
    
    // constructor
    
    public function __construct($user, $database) {
        $this->quizTaker = $user;
        $this->db = $database;
    }
    
    // function to get completed test attempts
    
    public function getQuizAttempts() {
        
        // reset quizAttempts array

        $this->quizAttempts = [];

        // open database connection

        $this->db->getDBConnection();

        // check for errors

        if (!$this->db->con->connect_error ) {

            // get quizAttempts

            $query = "CALL usp_getQuizAttemptsByUser('$this->quizTaker');";
            $result = mysqli_query($this->db->con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $this->quizAttempts[] = $row;
            }

            // close result and database connection

            if ($result && isset($this->quizAttempts)) {
                $result->close();
            }
            $this->db->closeDBConnection();

            // return quizzes

            if (isset($this->quizAttempts)) {
                $_SESSION['quizzes'] = $this->quizAttempts;
                return $this->quizAttempts;
            } else {
                $_SESSION['displayMessage'] = InfoMessage::dbNoRecords();
                return false;
            }
        } else {

            // close database connection and display error

            $this->db->closeDBConnection();
            $_SESSION['displayMessage'] = InfoMessage::dbConnectError();
        } 
    }
    
    // function to get quiz attempt counts
    
    public function getQuizAttemptsCount() {
        return count($this->quizAttempts);
    }
    
    // function to get average quiz score
    
    public function getAverageScore() {
        
        if (!isset($this->quizAttempts) || $this->getQuizAttemptsCount() == 0) {
            return -1;
        } else {
            $score = 0;
        
            foreach ($this->quizAttempts as $testAttempt) {
                $score += $testAttempt['score'];
            }

            return round($score/$this->getQuizAttemptsCount(),0);
        }
    }
}
