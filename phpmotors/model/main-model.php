<?php

//Main PHP Motors Model

function getClassifications() {

    //creates connection object from phpmotors connection function
    $db = phpmotorsConnect();
    $sql = 'SELECT classificationId, classificationName FROM carclassification ORDER BY classificationName ASC';
    //creates prepared statement using phpmotors connection
    $stmt = $db -> prepare($sql);
    //runs prepared statement
    $stmt -> execute();
    //gets data from database and stores it as an array
    $classifications = $stmt -> fetchALL();
    //closes interactions with database
    $stmt -> closeCursor();

    return $classifications;
}

?>