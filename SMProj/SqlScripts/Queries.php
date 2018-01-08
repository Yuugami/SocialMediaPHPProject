<?php

function connectToDb(){
    $dbConnection = parse_ini_file("db_connection.ini");
    extract($dbConnection);
    return new PDO($dsn, $user, $password);;
}

// Login Query function // Works
function loginQuery($UserId, $Password) {
    $myPdo = connectToDb();
    $sql = 'SELECT UserId, UserName FROM Users WHERE UserId = :userId AND UserPassword = :password';
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('userId' => $UserId, 'password' => $Password));
    $data = $pStatment->fetch();
    if ($data)
        return $data;
    else
        return FALSE;
}

// New User Query // Works
function NewUser($UserId, $Name, $Phone, $Password){
    $myPdo = connectToDb();
    $sql = "INSERT INTO Users (UserId, UserName, Phone, UserPassword) VALUES (:userId, :name, :phone, :password);";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('userId' => $UserId, 'name' => $Name, 'phone' => $Phone, 'password' => $Password));
}

function checkUserId($UserId){
    $myPdo = connectToDb();
    $sql = 'SELECT UserName FROM Users WHERE UserId = :userId';
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('userId' => $UserId));
    $data = $pStatment->fetch();
    if ($data)
        return TRUE; // If User Exists
    else
        return FALSE; // If User does not exist
}

// Create Album Query // Works
function CreateAlbum($title, $description, $date, $ownerId, $accessibility) {

// Return 0 if OwnerId doesnot exist
// Return -1 if Accessibility_Code does not exist
// Does Insert and returns AlbumId if successfull

    $myPdo = connectToDb();

    $sql = 'SELECT UserId FROM Users WHERE UserId = :userId';
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('userId' => $ownerId));
    $data = $pStatment->fetch();
    if(!$data){
        return 0;
    }

    $sql = 'SELECT Accessibility_Code FROM Accessibility WHERE Accessibility_Code = :accessibility';
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('accessibility' => $accessibility));
    $data = $pStatment->fetch();
    if(!$data){
        return -1;
    }

    $sql = "INSERT INTO Album (Title, Description, Date_Updated, Owner_Id, Accessibility_Code) VALUES (:title, :description, :date, :ownerId, :accessibility)";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('title' => $title, 'description' => $description, 'date' => $date, 'ownerId' => $ownerId, 'accessibility' => $accessibility));

    return $myPdo->lastInsertId();
}

// Get Albums from a User Query // Works
function showAlbums($ownerID) {
    $myPdo = connectToDb();
    $sql = "SELECT Title, Date_Updated, Owner_Id, Accessibility_Code, Description
            FROM album
            INNER JOIN users ON album.Owner_ID = users.UserId
            WHERE Owner_ID = :ownerID;";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('ownerID' => $ownerID));
    $data = $pStatment->fetchAll();
    return $data;
}

// To Do by Faizan for MyAlbums.php
function saveAccessibilityChanges() {
    $myPdo = connectToDb();
}

// To Do by Faizan for MyAlbums.php
function deleteAlbum() {

}

function getFriendsList($UserId){
    // Returns an containing Friends UserId, Name & Count of Shared Albums
    // $results is an array containing friends
    // Name: ['UserId'], ['Name'], ['AlbumsShared']

    $myPdo = connectToDb();
    $sql = "SELECT Users.UserId, Users.UserName, Friendship.Status_Code
            FROM Users
            INNER JOIN Friendship ON Users.UserId = Friendship.Friend_RequesteeId
            WHERE Friendship.Friend_RequesterId = :userId AND Friendship.Status_Code = 'accepted'";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('userId' => $UserId));
    $data = $pStatment->fetchAll();

    $results = array();
    foreach ($data as $row){
        $sql = "SELECT count(Album.Album_Id) AS SharedCount  FROM Album WHERE Album.Owner_Id = :userId AND Album.Accessibility_Code = 'shared';";
        $pStatment = $myPdo->prepare($sql);
        $pStatment->execute( array('userId' => $row['UserId']));
        $numberOfSharedAlbums = $pStatment->fetch();
        array_push($results, array('UserId' => $row['UserId'], 'Name' => $row['Name'], 'AlbumsShared' =>  $numberOfSharedAlbums['SharedCount']));
    }
    return $results;
}
function getFriendsRequests($UserId){
    // Returns an array containing FriendsRequests that contains UserId, Name
    // Returns False on no FriendRequests

    $myPdo = connectToDb();
    $sql = "SELECT Users.UserId, Users.UserName, Friendship.Status_Code FROM Users INNER JOIN Friendship ON Users.UserId = Friendship.Friend_RequesterId   WHERE Friendship.Friend_RequesteeId = :userId AND Friendship.Status_Code = 'request'";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('userId' => $UserId));
    $data = $pStatment->fetchAll();

    if(!$data){
        return FALSE;
    }
    return $data;
}
function deleteFriend($UserId, $FriendId){
    //Returns True on Successfull delete
    //Returns False on unccessfully delete

    $flag = null;
    $myPdo = connectToDb();
    $sql = "SELECT * FROM Friendship WHERE Friend_RequesterId = :userId AND Friend_RequesteeId = :friendId AND Status_Code = 'accepted'";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('userId' => $UserId, 'friendId' => $FriendId));
    $data = $pStatment->fetch();
    if($data){
        $sql = "DELETE FROM Friendship WHERE Friend_RequesterId = :userId AND Friend_RequesteeId = :friendId AND Status_Code = 'accepted'";
        $pStatment = $myPdo->prepare($sql);
        $pStatment->execute( array('userId' => $UserId, 'friendId' => $FriendId));
        return TRUE;
    }
    $sql = "SELECT * FROM Friendship WHERE Friend_RequesterId = :friendId AND Friend_RequesteeId = :userId AND Status_Code = 'accepted'";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('userId' => $UserId, 'friendId' => $FriendId));
    $data = $pStatment->fetch();
    if($data){
        $sql = "DELETE FROM Friendship WHERE Friend_RequesterId = :friendId AND Friend_RequesteeId = :userId AND Status_Code = 'accepted'";
        $pStatment = $myPdo->prepare($sql);
        $pStatment->execute( array('friendId' => $FriendId, 'userId' => $UserId ));
        return TRUE;
    }
    return FALSE;
}

function AcceptFriendRequest($UserId, $RequesterId){
    // Changes status_code to accepted
    
    $myPdo = connectToDb();
    $sql = "UPDATE Friendship SET Friendship.Status_Code = 'accepted' WHERE Friend_RequesteeId = :userId AND Friend_RequesterId = :requesterId";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('userId' => $UserId, 'requesterId' => $RequesterId));
}

function RejectFriendRequest($UserId, $RequesterId){
    // Removes the entires with only Stats_code = 'Requested'
    // Will not work on removing existing friends (Use deleteFriend Function)
    
    $myPdo = connectToDb();
    $sql = "DELETE FROM Friendship WHERE Friend_RequesteeId = :userId AND Friend_RequesterId = :requesterId AND Status_Code = 'request'";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('userId' => $UserId, 'requesterId' => $RequesterId));
}
?>