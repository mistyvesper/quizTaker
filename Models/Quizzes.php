<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Quizzes
 *
 * @author misty
 */
class Quizzes {
    
    private $quizzes = [];
    private $quizTaker;
    private $db;
    
    // constructor
    
    public function __construct($user, $database) {
        $this->quizTaker = $user;
        $this->db = $database;
    }
    
    // function to get quizzes array

    public function getQuizzes() { 
            
        // reset quizzes array

        $this->quizzes = [];

        // open database connection

        $this->db->getDBConnection();

        // check for errors

        if (!$this->db->con->connect_error ) {

            // get quizzes

            $query = "CALL usp_getQuizzes;";
            $result = mysqli_query($this->db->con, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $this->quizzes[] = $row;
            }

            // close result and database connection

            if ($result && isset($this->quizzes)) {
                $result->close();
            }
            $this->db->closeDBConnection();

            // return quizzes

            if (isset($this->quizzes)) {
                $_SESSION['quizzes'] = $this->quizzes;
                return $this->quizzes;
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
    
    // function to show quizzes
    
    public function showQuizzes() {
        
        // check for existing quizzes

        if (count($this->quizzes) == 0) {
            
            // create new error message
  
            echo infoMessage::dbNoRecords();
            
        } else {
            
            echo "<form class='quizzes' id='frmQuizzes' method='post' action='index.php' enctype='multipart/form-data'>
                    <table class='quizzes' id='tblQuizzes'>
                        <tr class='quizzes' id='trQuizzesHeaders'>
                            <th class='quizzes' id='thQuizName' colspan=2>Quiz Name</th>
                        </tr>
                        <tr class='quizzes' id='trQuizzes'>";
            
            foreach ($this->quizzes as $quiz) {
                $quizID = $quiz['quizID'];
                $quizName = $quiz['quizName'];
                
                echo "<td class='quizzes' id='tdQuizName'>$quizName</td>
                        <td class='quizzes' id='tdQuizOption'>
                            <input type='submit' class='quizzes' id='btnTakeQuiz' name='quizID[$quizID]' value='Take Quiz'>
                        </td>";
            }
            
            echo "</tr></table></form>";
        }
    } 
}
