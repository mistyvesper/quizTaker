<?php

// get cookie values

$imgSrc = $_COOKIE['imgSrc'];
$width = $_COOKIE['width'];
$height = $_COOKIE['height'];
$finalScore = $_COOKIE['finalScore'];

// display results

echo "<!DOCTYPE html>
    <html>
        <head>
            <meta charset='UTF-8'>
            <title>Quiz Results</title>
            <style>
                
                body {
                    text-align: center;
                    font-family: 'Times';
                    position: absolute;
                    top: 20%;
                    left: 35%;
                }
                
                img {
                    width: " . $width . "px;
                    height: " . $height . "px;
                }
                
                th {
                    font-weight: bold;
                }
            </style>
        </head>
        <body class='quizResults' id='bdyQuizResults'>
            <table class='quizResults' id='tblQuizResults'>
                <tr class='quizResults' id='trQuizResultsImg'>
                    <td class='quizResults' id='tdQuizResultsImg'>
                        <img src='" . $imgSrc . "'>
                    </td>
                </tr>
                <tr class='quizResults' id='trQuizResultsScoreHeader'>
                    <th class='quizResults' id='tdQuizResultsScoreHeader'>Your Score is:</th>
                <tr class='quizResults' id='trQuizResultsScore'>
                    <td class='quizResults' id='tdQuizResultsScore'>" . $finalScore . "%</td>
                </tr>
                <tr class='quizResults' id='trReturnToHome'>
                    <td class='quizResults' id='tdReturnToHome'>
                        <a class='link' id='lnkReturnToHome' href='/index.php'>
                            <button class='quizResults' id='btnReturnToHome'>Return To Home</button>
                        </a>
                    </td>
                </tr>
            </table>
        </body>
    </html>";