<?php

/** Reviews Model **/

//add a review
function addReview($invId, $clientId, $reviewText) {
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO reviews (invId, clientId, reviewText)
            VALUES (:invId, :clientId, :reviewText)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

//return reviews by invId
function getReviewsByinvId($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT reviewId, reviewText, reviewDate, clientLastname, clientFirstname FROM reviews 
            JOIN clients ON reviews.clientId = clients.clientId WHERE invId = :invId ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
}

//return reviews written by clientId
function getReviewsByClientId($clientId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT reviewId, reviewText, reviewDate, invMake, invModel, reviews.invId FROM reviews 
            JOIN inventory ON reviews.invId = inventory.invId WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
}

//get review by reviewId
function getReviewById($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT reviewId, reviewText, reviewDate, invMake, invModel, reviews.invId, clientId FROM reviews 
            JOIN inventory ON reviews.invId = inventory.invId WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $review;
}

//update review
function updateReview($reviewId, $reviewText, $invId, $clientId) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE reviews SET reviewText = :reviewText, invId = :invId, clientId = :clientId
            WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue('reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue('invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue('clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue('reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

//delete review
function deleteReview($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue('reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
