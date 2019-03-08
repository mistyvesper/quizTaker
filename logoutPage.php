<?php

/**
 * Description
 * 
 * Displays successful account registration page.  
 * 
 * @author misty
 */

require_once 'header.php';

// destroy session

unset($_SESSION['user']);
$appUser = '';
session_destroy();

// display message

echo "<!DOCTYPE html>
        <html>
            <head>
                <meta charset='UTF-8'>
                <title>Logged Out</title>
                <style>
                    @import url('/Stylesheets/main.css');
                </style>
                <style>
                    #spnLoggedOut {
                        padding: 50px 100px 75px 100px;
                    }
                    #tblLoggedOut {
                        text-align: center;
                        padding: 50px 0px 50px 0px;
                    }
                </style>
                <script src='http://code.jquery.com/jquery-latest.min.js'></script>
                <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'
                    integrity='sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30='crossorigin='anonymous'>
                </script>
                <script src='/JavaScript/centerContent.js'></script>
            </head>
            <body class='initial' id='bdyLoggedOut'>
                <span class='initial' id='spnLoggedOut'>
                    <table class='initial' id='tblLoggedOut'>
                        <tr class='initial' id='trLoggedOutHeader'>
                            <th class='initial' id='thLoggedOutHeader'>
                                <h1 class='initial' id='hdrLoggedOut'>Logged Out</h1>
                            </th>
                        </tr>
                        <tr class='initial' id='trLoggedOut'>
                            <td class='initial' id='tdLoggedOut'>
                                You have been successfully logged out.
                                To log back in, please visit the <a class='link' id='lnkBackToLoginFromLogout' href='/loginPage.php'>Login Page</a>.
                            </td>
                        </tr>
                    </table>
                </span>
            </body>
        </html>";