<?php

/*
* Accounts Model
*/

//Register a New Client

function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword) {
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();

    $sql = 'INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword)
            VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';
    
    //creates the prepared stmt
    $stmt = $db->prepare($sql);

    //replace placeholders in the SQL stmt with actual values and tells the db the type of data
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);

    //insert the data
    $stmt->execute();

    //asks how many rows changed
    $rowsChanged = $stmt->rowCount();

    //close the db interaction
    $stmt->closeCursor();

    //return # of rows changed
    return $rowsChanged;

}

//check if email already exists in database

function checkExistingEmail($clientEmail) {
    //connection object to phpmotors db
    $db = phpmotorsConnect();

    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';

    //prepare stmt
    $stmt = $db->prepare($sql);

    //adds data to variable
    $stmt->bindvalue(':email', $clientEmail, PDO::PARAM_STR);

    //gets data
    $stmt->execute();

    //returns email to variable
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);

    //closes db interaction
    $stmt->closeCursor();

    //checks if email matches
    if(empty($matchEmail)) {
        return 0;
    } else {
       return 1;
    }
}

//get client data based on email address
function getClient($clientEmail) {
    $db = phpmotorsConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword 
            FROM clients WHERE clientEmail = :clientEmail';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

function updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId) {
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();

    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, clientEmail = :clientEmail
            WHERE clientId = :clientId';
    
    //creates the prepared stmt
    $stmt = $db->prepare($sql);

    //replace placeholders in the SQL stmt with actual values and tells the db the type of data
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);

    //insert the data
    $stmt->execute();

    //asks how many rows changed
    $rowsChanged = $stmt->rowCount();

    //close the db interaction
    $stmt->closeCursor();

    //return # of rows changed
    return $rowsChanged;

}

//get client data based on client Id
function getClientInfo($clientId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword 
            FROM clients WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

function updatePassword($clientPassword, $clientId) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE clients SET clientpassword = :clientPassword WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}


