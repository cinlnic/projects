<?php

/*
* Vehicle Model
*/

//Add a classification

function addClassification($classificationName) {
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();

    $sql = 'INSERT INTO carclassification (classificationName)
            VALUES (:classificationName)';
    
    //creates the prepared stmt
    $stmt = $db->prepare($sql);

    //replace placeholders in the SQL stmt with actual values and tells the db the type of data
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);

    //insert the data
    $stmt->execute();

    //asks how many rows changed
    $rowsChanged = $stmt->rowCount();

    //close the db interaction
    $stmt->closeCursor();

    //return # of rows changed
    return $rowsChanged;
}

//Add a vehicle
function addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId) {
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();

    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId)
            VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)';
    
    //creates the prepared stmt
    $stmt = $db->prepare($sql);

    //replace placeholders in the SQL stmt with actual values and tells the db the type of data
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue('invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue('invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue('invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue('invPrice', $invPrice, PDO::PARAM_INT);
    $stmt->bindValue('invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue('invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue('classificationId', $classificationId, PDO::PARAM_INT);

    //insert the data
    $stmt->execute();

    //asks how many rows changed
    $rowsChanged = $stmt->rowCount();

    //close the db interaction
    $stmt->closeCursor();

    //return # of rows changed
    return $rowsChanged;
}

//Get vehicles by classificationId
function getInventoryByClassifications($classificationId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE classificationId = :classificationId';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $inventory;
}

//get vehicle info by id
function getInvItemInfo($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

//Update vehicle info
function updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId) {
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();

    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, 
            invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId
            WHERE invId = :invId';
            
    
    //creates the prepared stmt
    $stmt = $db->prepare($sql);

    //replace placeholders in the SQL stmt with actual values and tells the db the type of data
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue('invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue('invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue('invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue('invPrice', $invPrice, PDO::PARAM_INT);
    $stmt->bindValue('invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue('invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue('classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);

    //insert the data
    $stmt->execute();

    //asks how many rows changed
    $rowsChanged = $stmt->rowCount();

    //close the db interaction
    $stmt->closeCursor();

    //return # of rows changed
    return $rowsChanged;
}

//delete vehicle from database
function deleteVehicle($invId) {
    //create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();

    $sql = 'DELETE FROM inventory WHERE invId = :invId';
            
    //creates the prepared stmt
    $stmt = $db->prepare($sql);

    //replace placeholders in the SQL stmt with actual values and tells the db the type of data
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);

    //insert the data
    $stmt->execute();

    //asks how many rows changed
    $rowsChanged = $stmt->rowCount();

    //close the db interaction
    $stmt->closeCursor();

    //return # of rows changed
    return $rowsChanged;
}

//get vehicles by classification Name
function getVehiclesByClassification($classificationName) {
    $db = phpmotorsConnect();
    $sql = 'SELECT inventory.invId, invMake, invModel, invPrice, classificationId, imgPath FROM inventory JOIN images ON inventory.invId = images.invId
            WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName) 
                AND imgPath LIKE "%-tn%" AND imgPrimary = 1';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
}

function getVehicleDetail($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT inventory.invId, invMake, invModel, invPrice, invColor, invDescription, imgPath FROM inventory JOIN images ON inventory.invId = images.invId 
            WHERE inventory.invId = :invId AND imgPath NOT LIKE "%-tn%" AND imgPrimary = 1';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

function getVehicles() {
    $db = phpmotorsConnect();
    $sql = 'SELECT invId, invMake, invModel FROM inventory';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}