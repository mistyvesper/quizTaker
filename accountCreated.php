<?php

/**
 * Description
 * 
 * Displays successful account registration page.  
 * 
 * @author misty
 */

echo "<!DOCTYPE html>
        <html>
            <head>
                <meta charset='UTF-8'>
                <title>Account Created</title>
                <style>
                    @import url('/QuizTaker/Stylesheets/main.css');
                </style>
                <style>
                    #spnAccountCreated {
                        padding: 50px 175px 75px 100px;
                    }
                    #tblAccountCreated {
                        text-align: center;
                        padding: 50px 0px 50px 0px;
                    }
                </style>
                <script src='http://code.jquery.com/jquery-latest.min.js'></script>
                <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'
                    integrity='sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30='crossorigin='anonymous'>
                </script>
                <script src='/QuizTaker/JavaScript/centerContent.js'></script>
            </head>
            <body class='initial' id='bdyAccountCreated'>
                <span class='initial' id='spnAccountCreated'>
                    <table class='initial' id='tblAccountCreated'>
                        <tr class='initial' id='trAccountCreatedHeader'>
                            <td class='initial' id='tdAccountCreatedHeader'>
                                <h1 class='initial' id='hdrAccountCreated'>Account Created</h1>
                            </td>
                        </tr>
                        <tr class = 'initial' id='trAccountCreated'>
                            <td class='initial' id='tdAccountCreated'>
                                 Congrats! Your account has now been created. 
                                To log in to the site, please visit the <a class='link'href='/QuizTaker/loginPage.php' id='lnkGoToLogin'>Login Page</a>.
                            </td>
                        </tr>
                    </table>
                </span>
            <body>
        </html>";