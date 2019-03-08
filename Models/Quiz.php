<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Quiz
 *
 * @author misty
 */
class Quiz {
    
    private $questions;
    private $answers;
    private $quizTaker;
    private $db;
    
    // constructor
    
    public function __construct($user, $database) {
        $this->quizTaker = $user;
        $this->db = $database;
    }
    
    // function to get quiz questions
    
    public function getQuestionsByQuizID($quizID) {
        
        // reset questions array

        $this->questions = [];

        // open database connection

        $this->db->getDBConnection();

        // check for errors

        if (!$this->db->con->connect_error ) {

            // get questions

            $query = "CALL usp_getQuestionsByQuizID($quizID);";
            $result = mysqli_query($this->db->con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $this->questions[] = $row;
            }

            // close result and database connection

            if ($result && isset($this->questions)) {
                $result->close();
            }
            $this->db->closeDBConnection();

            // return questions

            if (isset($this->questions)) {
                $_SESSION['questions'] = $this->questions;
                return $this->questions;
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
    
    // function to get question answers
    
    public function getAnswersByQuestionID($questionID) {
        
        // reset answers array

        $this->answers = [];

        // open database connection

        $this->db->getDBConnection();

        // check for errors

        if (!$this->db->con->connect_error ) {

            // get answers

            $query = "CALL usp_getAnswersByQuestionID($questionID);";
            $result = mysqli_query($this->db->con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $this->answers[] = $row;
            }

            // close result and database connection

            if ($result && isset($this->answers)) {
                $result->close();
            }
            $this->db->closeDBConnection();

            // return answers

            if (isset($this->answers)) {
                $_SESSION['questions'] = $this->answers;
                return $this->answers;
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
    
    // function to add final score to database
    
    public function recordScore($quizID, $score, $questions) {
        
        // open database connection
        
        $this->db->getDBConnection();
        
        // check for errors
        
        if (!$this->db->con->connect_error ) {
            
            // prepare insert statement
            
            $statement = $this->db->con->prepare("CALL usp_addQuizAttempt(?, ?, ?, ?);");
            $statement->bind_param('ssss', $user, $quiz, $quizScore, $quizQuestions);
            
            // get test properties
        
            $user = $this->quizTaker;
            $quiz = $quizID;
            $quizScore = $score;
            $quizQuestions = $questions;
        
            // add document
        
            $statement->execute();
            
            // check for errors
            
            if ($statement->error != '') {
                $_SESSION['displayMessage'] = InfoMessage::dbDocumentsNotAdded();
                $this->db->closeDBConnection();
                return false;
            }
        } else {
            $_SESSION['displayMessage'] = InfoMessage::dbConnectError();
            $this->db->closeDBConnection();
            return false;
        }
        
        // close database connection
        
        $this->db->closeDBConnection();
        
    }
    
    // function to get quiz name 
    
    public function getQuizNameByQuizID($quizID) {
        
        // open database connection
        
        $this->db->getDBConnection();
        
        // check for errors
        
        if (!$this->db->con->connect_error ) {
            
            // get quiz name
        
            $query = "CALL usp_getQuizNameByQuizID('$quizID');";
            $result = mysqli_query($this->db->con, $query);
            $quizName = mysqli_fetch_array($result, MYSQLI_NUM)[0];
            
            // close result and close database connection
        
            if ($result && isset($quizName)) {
                $result->close();
            }
            $this->db->closeDBConnection();
            
            // return document ID
            
            if ($quizName) {
                return $quizName;
            } else {
                $_SESSION['displayMessage'] = InfoMessage::dbNoRecords();
                return 0;
            }
        } else {
            $this->db->closeDBConnection();
            $_SESSION['displayMessage'] = InfoMessage::dbConnectError();
            return false;
        }    
    }
    
    // function to show question and answers by question id
    
    public function showQuestionAndAnswers() {
        
        // initialize question counter
        
        $i = 1;
        
        // iterate through questions 
        
        foreach ($this->questions as $question) {
            
            $questionID = $question['questionID'];
            $questionText = $question['question'];
            $this->answers = $this->getAnswersByQuestionID($questionID);

            echo "<table class='tblQuestions' id='tblQuestion$i'>
                    <tr class='trQuestionHeader' id='trQuestion$i" . "Header'>
                        <th class='thQuestionHeader' id='thQuestion$i" . "Header' colspan=2>Question $i</th>
                    <tr class='trQuestion' id='trQuestion$i'>
                        <td class='tdQuestion' id='tdQuestion$i' colspan=2>$questionText</td>
                    <tr>";
            
            // initialize answer counter
            
            $j = 1;
            
            // iterate through answers

            foreach ($this->answers as $key => $answer) {
                
                $answerText = $answer['answer'];
                $correct = $answer['correctFlag'];
                
                echo "<tr class='trAnswers' id='trQuestion$i" . "Answer$j'>
                        <td class='tdAnswerBtn' id='tdQuestion$i" . "Answer$j'>
                            <input class='inAnswers' id='radQuestion$i" . "Answer$j' type='radio' name='question$i' value='$correct'>
                        </td>
                        <td class='tdAnswerText' id='tdQuestion$i" . "AnswerText$j'>$answerText</td>
                    </tr>";
                
                // increment answer acounter
                
                $j++;
            }

            echo "</table>";
            
            // increment question #
            
            $i++;
         }
    }
    
    // function to get question count
    
    public function getQuestionCount() {
        return count($this->questions);
    }
}
