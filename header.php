<?php

/**
 * Description
 * 
 * Provides functionality common to all web app pages.
 * 
 * @author misty
 */

    // start session

    session_start();
    
    // get root directory 
    
    $rootDirectory = dirname(__FILE__);
    
    // get dependencies for all pages
    
    require_once($rootDirectory . '/App/login.php');
    require_once($rootDirectory . '/Models/Database.php');
    require_once($rootDirectory . '/Models/InfoMessage.php');
    require_once($rootDirectory . '/Models/Quizzes.php');
    require_once($rootDirectory . '/Models/Quiz.php');
    require_once($rootDirectory . '/Models/QuizAttempts.php');
    require_once($rootDirectory . '/Resources/accountMaintenance.php');
    require_once($rootDirectory . '/Resources/authentication.php');
    require_once($rootDirectory . '/Resources/sanitize.php');
    
    // check if get request received
    
    if (isset($_GET)) {
        foreach ($_GET as $get) {
          if ($get == "netbeans-xdebug") {
              continue;
          } else {
              $getRequest = true;
          }
        }  
    }

    // check if user is logged in
    
     if (isset($_SESSION['user'])) {
        $appUser = $_SESSION['user'];
        $loggedIn = TRUE;
    } else if (strpos($_SERVER['SCRIPT_NAME'], "loginPage.php") > 0) {
        $loggedIn = FALSE;
    } else if (strpos($_SERVER['SCRIPT_NAME'], "registerForAccount.php") > 0 
                || strpos($_SERVER['SCRIPT_NAME'], "accountCreated.php") > 0
                || strpos($_SERVER['SCRIPT_NAME'], "logoutPage.php") > 0) {
        $loggedIn = FALSE;
    } else if (!$getRequest) {
        header("Location: loginPage.php");
        $loggedIn = FALSE;
    }
    
    // instantiate objects common to all pages

    $database = new Database($dbHost, $dbUser, $dbPassword, $dbDBName);
    $quizzes = new Quizzes($appUser, $database);
    $quiz = new Quiz($appUser, $database);
    $quizAttempts = new QuizAttempts($appUser, $database);
    unset($_SESSION['displayMessage']);
    
    // check for submitted values to redirect pages as needed
    
/**********************************************************************************************************
 * LOGIN PAGE
 **********************************************************************************************************/
    
    if (isset($_POST['login'])) {       
        if (validateUser($_POST['userName'], $_POST['password'], $database)) {
            header("Location: index.php");
        }
    }

/**********************************************************************************************************
 * ACCOUNT REGISTRATION
 **********************************************************************************************************/
    
    if (isset($_POST['registerForAccount'])) {
        
        if (validateAccountRegistration($_POST['email'], $_POST['userName'], $_POST['password'], $database)) {
            if (createAccount($_POST['email'], $_POST['userName'], $_POST['password'], $database)) {
                header("Location: accountCreated.php");
            }
        }
    }
    
/**********************************************************************************************************
 * TAKE QUIZ
 **********************************************************************************************************/
    
    if (isset($_POST['quizID'])) {
        $_SESSION['quizID'] = key($_POST['quizID']);
        header("Location: quiz.php");
    }
    
/**********************************************************************************************************
 * SUBMIT QUIZ
 **********************************************************************************************************/
    
    if (isset($_POST['submitQuiz']) && $_SESSION['quizID']) {
        
        $quiz->getQuestionsByQuizID($_SESSION['quizID']);
        $questionCount = $quiz->getQuestionCount();
        $score = 0;
        
        // calculate score
        
        for ($i = 1; $i < $questionCount+1; $i++) {
            $questionNum = 'question' . $i;
            $score += $_POST[$questionNum];
        }
        
        // calculate final score
        
        $finalScore = $score / $questionCount;
        
        // add score to database
        
        $quiz->recordScore($_SESSION['quizID'], $score, $questionCount);
        
        // redirect to main page
        
        header("Location: quizResults.php");
    }
    
/**********************************************************************************************************
 * CANCEL QUIZ
 **********************************************************************************************************/
    
    if (isset($_POST['cancelQuiz'])) {
        header("Location: index.php");
    }
    
/**********************************************************************************************************
 * PAGE HEADER
 **********************************************************************************************************/   
    
    // display page header
    
    if ((!strpos($_SERVER['SCRIPT_NAME'], "loginPage.php") 
            && !strpos($_SERVER['SCRIPT_NAME'], "logoutPage.php")
            && !strpos($_SERVER['SCRIPT_NAME'], "registerForAccount.php")
            && !strpos($_SERVER['SCRIPT_NAME'], "accountCreated.php")
            && !strpos($_SERVER['SCRIPT_NAME'], "getFunctions.php")) 
            && $loggedIn) {
        
        // capitalize appUser
    
        $upperAppUser = strtoupper($appUser);
        
        echo "<!DOCTYPE html>
                <html>
                    <head>
                        <meta charset='UTF-8'>
                        <title>Quiz Taker</title>
                        <style>
                            @import url('/QuizTaker/Stylesheets/main.css');
                        </style>
                        <style>
                            #spnQuiz {
                                top: 10%;
                            }
                            table { 
                                border-collapse: collapse;
                            }
                            #trQuizzes:hover {
                                background-color: whitesmoke;
                            }
                            .trAnswers:hover {
                                background-color: whitesmoke;
                            }
                            tr.trQuestionHeader {
                                height: 30px;
                            }
                            tr.trQuestion {
                                height: 30px;
                            }
                            tr.trAnswers {
                                height: 30px;
                            }
                            tr.trQuestionButtons {
                                height: 30px;
                            }
                            tr.trReviewAnswers {
                                height: 30px;
                            }
                            tr.trQuestionSubmit {
                                height: 30px;
                            }
                        </style>
                        <script src='http://code.jquery.com/jquery-latest.min.js'></script>
                        <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'
                            integrity='sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30='crossorigin='anonymous'>
                        </script>
                        <script src='/QuizTaker/JavaScript/centerContent.js'></script>
                    </head>
                    <body class='body-loggedin' id='bdyLoggedIn'>
                        <span class='loggedIn' id='spnLoggedIn'>
                            <h1 class='loggedInHeader' id='hdrLoggedInHeader'>Quiz Taker</h1>
                            <table class='loggedIn' id='tblLoggedIn'>
                                <tr class='loggedInTop' id='trLoginInfo'>
                                    <td class='loggedInTop' id='tdPersonIcon'><img class='img' id='imgPersonIcon' src='Media/person_icon.png' style='width:35px;height:35px;'></td>
                                    <td class='loggedInTop' id='tdSignedInAs' style='width:23%'>Signed in as: <lbl class='lbl' id='lblSignedInAs'>$upperAppUser</lbl></td>
                                    <td class='loggedInTop' id='tdLogOutLink' style='width:75%' align='right'><a class='link' id='lnkLogOutLink' href='/QuizTaker/logoutPage.php'>Logout</a></td>
                                </tr>
                            </table>
                        </span>";  
                                                
    }