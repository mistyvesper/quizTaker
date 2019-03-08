<?php

/**
 * Description
 * 
 * Provides functions for web app account maintenance.
 * 
 * @author misty
 */

$directory = dirname(dirname(__FILE__));
require_once($directory . '/header.php');

// function to check for existing account

function checkForExistingAccount($user, $dbConnection) {
    
    // sanitize input
    
    $user = sanitizeString($user);
    
    // open database connection
        
    $con = $dbConnection->getDBConnection();

    // check for errors

    if (!$con->connect_error) {
    
        // get user from database

        $dbUser = mysqli_fetch_array(mysqli_query($con, "SELECT userName FROM User WHERE userName = '$user'"), MYSQLI_NUM)[0];

        // check if user exists

        if ($user != '' && $dbUser != '') {
            $dbConnection->closeDBConnection();
            return true;
        } else {
            $dbConnection->closeDBConnection();
            return false;
        }
    } else {
        $dbConnection->closeDBConnection();
        $_SESSION['displayMessage'] = InfoMessage::dbConnectError();
        return true;
    }
}

// function to check for existing email

function checkForExistingEmail($userEmail, $dbConnection) {
    
    // sanitize input
    
    $userEmail = sanitizeString($userEmail);
    
    // open database connection
        
    $con = $dbConnection->getDBConnection();

    // check for errors

    if (!$con->connect_error) {
    
        // get user email from database

        $dbUserEmail = mysqli_fetch_array(mysqli_query($con, "SELECT userEmail FROM User WHERE userEmail = '$userEmail'"), MYSQLI_NUM)[0];

        // check if user exists

        if ($userEmail != '' && $dbUserEmail != '') {
            $dbConnection->closeDBConnection();
            return true;
        } else {
            $dbConnection->closeDBConnection();
            return false;
        }
    } else {
        $dbConnection->closeDBConnection();
        $_SESSION['displayMessage'] = InfoMessage::dbConnectError();
        return true;
    }
    
}

// function to create account

function createAccount($userEmail, $user, $password, $dbConnection) {
    
    // sanitize input
    
    $userEmail = sanitizeString($userEmail);
    $user = sanitizeString($user);
    $password = sanitizeString($password);
    
    // declare and initialize variables
    
    $salt1 = '1234';
    $salt2 = '4321';
    if ($password != '') {
        $token = hash("ripemd128", "$salt1$password$salt2");
    }
    
    // open database connection
        
    $con = $dbConnection->getDBConnection();
    
    // check for errors

    if (!$con->connect_error) {

        // prepare update statement

        $statement = $con->prepare("CALL usp_quizqu(?, ?, ?);");
        $statement->bind_param('sss', $tempUser, $tempEmail, $tempPass);

        // get properties

        $tempUser = $user;
        $tempEmail = $userEmail;
        $tempPass = $token;

        $statement->execute();

        // check for errors

        if ($statement->error != '') {
            $dbConnection->closeDBConnection();
            return false;
        } else {
            $_SESSION['displayMessage'] = InfoMessage::accountCreationUnsuccessful($tempUser);
            $dbConnection->closeDBConnection();
            return true;
        } 
    } else {
        $_SESSION['displayMessage'] = InfoMessage::dbConnectError();
        $dbConnection->closeDBConnection();
        return false;
    }  
}

// function to validate account registration information

function validateAccountRegistration($email, $userName, $password, $db) {
    
    // sanitize input
    
    $email = sanitizeString($email);
    $userName = sanitizeString($userName);
    $password = sanitizeString($password);
    
    // check for errors
    
    if ($email != '' && $userName != '' && $password != '' && !checkForExistingAccount($userName, $db) && !checkForExistingEmail($email, $db)) {
        return true;
    } else if (($email == '' || $userName == '' || $password == '')) {
        $_SESSION['displayMessage'] = InfoMessage::invalidEntries();
        return false;
    } else if (strpos($email, '@') === false) {
        $_SESSION['displayMessage'] = InfoMessage::invalidEmail();
        return false;
    } else if ($email != '' && $userName != '' && $password != '' && checkForExistingEmail($email, $db)) {
        $_SESSION['displayMessage'] = InfoMessage::emailTaken($email);
        return false;
    } else if ($submitted == 1 && $email != '' && $userName != '' && $password != '' && checkForExistingAccount($userName, $db)) {
        $_SESSION['displayMessage'] = InfoMessage::accountTaken($user);
        return false;
    }
}