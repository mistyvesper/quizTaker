<?php

require_once 'header.php';

// get update quiz attempts

$quizAttempts->getQuizAttempts();

// check if quizID session variable set

if (!isset($_SESSION['quizID'])) {
    echo InfoMessage::dbNoRecords;
} else {
    
    // get quizID and quiz questions
    
    $quizID = $_SESSION['quizID'];
    $quiz->getQuestionsByQuizID($quizID);
    
    // display quiz options
    
    echo "<span class='quizzes' id='spnQuiz'>
            <h2 class='quizzes' id='hdrQuizName'>" . $quiz->getQuizNameByQuizID($quizID) . "</h2>
            <form class='quizzes' id='frmQuizOptions' method='post' action='quiz.php' enctype='multipart/form-data'>
                <table class='quizzes' id='tblQuizOptions'>
                    <tr class='quizzes' id='trQuizOptions'>
                        <td class='quizzes' id='tdQuizOptions'>
                            <input class='quizzes' id='subQuizCancel' type='submit' name='cancelQuiz' value='Return to Home Page'>
                        </td>
                    </tr>
                    <tr class='hidden' id='trAverageScore'>
                        <td class='hidden' id='tdAverageScore'>
                            <label class='quizzes' id='lblAverageScore'>" . $quizAttempts->getAverageScore() . "%</label>
                        </td>
                    </tr>
                </table>
            </form>";
    
    // display questions and answers
    
    echo "<br>
            <form class='quizzes' id='frmQuestions' method='post' action='quiz.php' enctype='multipart/form-data'>";
    
    $quiz->showQuestionAndAnswers();
    
    // display quiz buttons
    
    echo "<table class='tblQuestionsButtons' id='tblQuestionsButtons'>
                <tr class='trQuestionButtons' id='trQuestionButtons'>
                    <td class='tdQuestionButtons' id ='tdQuestionPrevious'>
                        <input class='inQuestionButtons' id='subQuestionPrevious' type='button' name='previous' value='Previous Page'>
                    </td>
                    <td class='tdQuestionButtons' id='tdQuestionNext'>
                        <input class='inQuestionButtons' id='subQuestionNext' type='button' name='next' value='Next Page'>
                    </td>
                </tr>
                <tr class='trReviewAnswers' id='trReviewAnswers'>
                    <td class='tdReviewAnswers' id='tdReviewAnswers'>
                        <input class='reviewAnswers' id='subReviewAnswersButton' type='button' name='reviewAnswers' value='Review Answers'>
                    </td>
                </tr>
                <tr class='trQuestionSubmit' id='trQuestionSubmit'>
                    <td class='tdQuestionSubmit' id='tdQuestionSubmit' colspan=2>
                        <input class='quizSubmit' id='subQuizSubmit' type='submit' name='submitQuiz[$quizID]' value='Submit Answers'>
                    </td>
                <tr>
            </table>
        </form>";
}

// end of html doc

echo "</span>
        </body>
        <script src='/QuizTaker/JavaScript/quizNavigation.js'></script>
        </html>";