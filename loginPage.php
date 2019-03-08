<?php

/**
 * Description
 * 
 * Displays login page.  
 * 
 * @author misty
 */
        
    require_once 'header.php';

    // display web form
    
    echo "<!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>Quiz Taker Login</title>
                <style>
                    @import url('/QuizTaker/Stylesheets/main.css');
                </style>
                <style>
                    span.initial {
                        width: 500px;
                    }
                    #tdLoginSubmit {
                        text-align: right;
                    }
                    #tdRegisterForAccount {
                        text-align: center;
                        height: 80px;
                    }
                </style>
                <script src='http://code.jquery.com/jquery-latest.min.js'></script>
                <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'
                    integrity='sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30='crossorigin='anonymous'>
                </script>
                <script src='/QuizTaker/JavaScript/centerContent.js'></script>
            </head>
            <body class='initial' id='bdyLoginPage'>
                <span class='initial' id='spnLoginForm'>
                    <h1 class='initial' id='hdrLoginPage'>Quiz Taker Login</h1>
                        <form class='initial' id='frmLoginForm' method='post' action='loginPage.php' enctype='multipart/form-data'>
                            <table class='initial' id='tblLoginForm'>
                                <tr class='initial' id='trLoginUser'>
                                    <td class='form-label' id='tdLoginUserLabel'>User Name:</td>
                                    <td class='form-input' id='tdLoginUserInput'>
                                        <input class='form-input' id='inLoginUserName' type='text' name='userName' maxlength='25'>
                                    </td>
                                </tr>
                                <tr class='initial' id='trLoginPassword'>
                                    <td class='form-label' id='tdLoginPassLabel'>Password:</td>
                                    <td class='form-input' id='tdLoginPassInput'>
                                        <input class='form-input' id='inLoginUserPass' type='password' name='password' maxlength='25'>
                                    </td>
                                </tr>
                                <tr class='initial' id='trLoginSubmit'>
                                    <td class='initial' id='tdLoginSubmit' colspan=2>
                                        <input class='form-submit-button' id='subLogin' type='submit' name='login' value='Login'>
                                    </td>
                                </tr>
                                <tr class='initial' id='trRegisterForAccount'>
                                    <td class='initial' id='tdRegisterForAccount' colspan=2>
                                        <a class='link' id='lnkRegisterForAccount' href='/QuizTaker/registerForAccount.php'>Don't have an account? Register here.</a>
                                    </td>
                                </tr>
                            </table>
                        </form>";
                        
    // check for errors
    
    if (isset($_SESSION['displayMessage'])) {
        echo "<br><br>";
        echo $_SESSION['displayMessage'];
    }

    echo "</span></body></html>";