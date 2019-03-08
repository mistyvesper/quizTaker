<?php

require_once 'header.php';

// get quizzes and test attempts

$quizzes->getQuizzes();
$quizAttempts->getQuizAttempts();

// display test attempts header

echo "<span class='quizzes' id='spnMainPage'>
        <h1 class='quizzes' id='hdrSummary'>Summary of Quiz Attempts</h1>";

// display test attempts summary

echo "<table class='quizzes' id='tblSummary'>
        <tr class='quizzes' id='trSummaryHeaders'>
            <th class='quizzes' id='tdQuizAttemptsCountHeader'>Quiz Attempts</th>
            <th class='quizzes' id='tdAverageScoreHeader'>Average Score</th>
        </tr>
        <tr class='quizzes' id='trSummary'>
            <td class='quizzes' id='tdQuizAttemptsCount'>
                <label class='quizzes' id='lblQuizAttemptsCount'>" . $quizAttempts->getQuizAttemptsCount() . "</label>
            </td>
            <td class='quizzes' id='tdAverageScore'>
                <label class='quizzes' id='lblAverageScore'>" . $quizAttempts->getAverageScore() . "%</label>
                <canvas class='hidden' id='cnvAverageScore' width='250' height='120'></canvas>    
            </td>
        </tr>
    </table>";

// display quizzes header

echo "<h1 class='quizzes' id='hdrQuizzes'>Available Quizzes</h1>";

$quizzes->showQuizzes();

// end of html doc

echo "<script type='text/javascript' src='/QuizTaker/JavaScript/gauge.js'></script></span></body></html>";
