<?php

function connectToDb(){
    $dbConnection = parse_ini_file("db_connection.ini");
    extract($dbConnection);
    return new PDO($dsn, $user, $password);;
}

//----------------------------------- User Related Functions ---------------------------------
// Login Query function // Works
function loginQuery($UserId, $Password) {
    $myPdo = connectToDb();
    $sql = 'SELECT UserId, UserName AS Name FROM Users WHERE UserId = :userId AND UserPassword = :password';
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
    $sql = "INSERT INTO Users (UserId, UserName, Phone, UserPassword) VALUES (:userId, :name, :phone, :password)";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('userId' => $UserId, 'name' => $Name, 'phone' => $Phone, 'password' => $Password));
}

function checkUserId($UserId){
    $myPdo = connectToDb();
    $sql = 'SELECT UserName As Name FROM Users WHERE UserId = :userId';
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('userId' => $UserId));
    $data = $pStatment->fetch();
    if ($data)
        return TRUE; // If User Exists
    else
        return FALSE; // If User does not exist
}




//----------------------------------- Albums Functions -------------------------------------------------
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

// Get a single album
function getAnAlbum($albumID) {
    $myPdo = connectToDb();
    $sql = "SELECT *
        FROM album
        WHERE Album_Id = :albumID;";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('albumID' => $albumID));
    $data = $pStatment->fetch();
    return $data;
}

// Get Albums from a User Query // Works
function showAlbums($ownerID) {
    $myPdo = connectToDb();
    $sql = "SELECT Album_Id, Title, Date_Updated, Owner_Id, Accessibility_Code, Description
            FROM album
            INNER JOIN users ON album.Owner_ID = users.UserId
            WHERE Owner_ID = :ownerID;";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('ownerID' => $ownerID));
    $data = $pStatment->fetchAll();
    return $data;
}

// To Do by Faizan for MyAlbums.php // Works
function saveAccessibilityChanges($Album_Id, $Accessibility_Code) {
    // $AlbumId need to integer
    // $Accessibility_Code accepts: shared, private
    $myPdo = connectToDb();
    $sql = "UPDATE Album SET Accessibility_Code = :accessibility_Code WHERE Album_Id = :album_Id;";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('accessibility_Code' => $Accessibility_Code, 'album_Id' => $Album_Id));
}

// To Do by Faizan for MyAlbums.php
function deleteAlbum($AlbumId) {
    // $AlbumId need to integer
    $myPdo = connectToDb();
    $sql = "DELETE FROM Album WHERE Album_Id = :albumId";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute( array('albumId' => $AlbumId) );
}

//---------------------------- My Friends Page Functions ------------------------------------
function getFriendsList($UserId){
    // Returns an containing Friends UserId, Name & Count of Shared Albums
    // $results is an array containing friends
    // Name: ['UserId'], ['Name'], ['AlbumsShared']

    $myPdo = connectToDb();
    $sql = "SELECT Users.UserId, Users.UserName As Name, Friendship.Status_Code
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
    $sql = "SELECT Users.UserId, Users.UserName AS Name, Friendship.Status_Code FROM Users INNER JOIN Friendship ON Users.UserId = Friendship.Friend_RequesterId   WHERE Friendship.Friend_RequesteeId = :userId AND Friendship.Status_Code = 'request'";
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

function addFriend($RequesterId, $RequesteeId){
    // Returns 0 If sending request to Self
    // Returns 1 If Requestee does not exist
    // Returns 2 If Requestee is already Requester's friend
    // Returns 3 If Requester has already sent a request to Requestee
    // Returns 4 They becomes friends if Requester has already friend Request from Requestee
    // Returns 5 Requester's friend request is sent to Requestee

    if(trim($RequesterId) == trim ($RequesteeId)){
        echo 'Cannot send request to self';
        return 0; // You cannot send request to your self
    }
    $myPdo = connectToDb();
    $sql = "SELECT UserId, UserName AS Name FROM Users WHERE UserId = :requesteeId";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('requesteeId' => $RequesteeId));
    $data = $pStatment->fetch();
    if(!$data){
        echo 'User Does not Exists';
        return 1; // User Does not Exists
    }

    $sql = "SELECT * FROM Friendship WHERE Friend_RequesterId = :requesterId AND Friend_RequesteeId = :requesteeId";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('requesterId' => $RequesterId, 'requesteeId' => $RequesteeId));
    $data = $pStatment->fetch();
    if($data){
        if($data['Status_Code'] == 'accepted'){
            echo 'Already a friend';
            return 2; // Already his friend
        }else{
            echo 'Already sent friend request';
            return 3; // already has sent friend request
        }
    }

    $sql = "SELECT * FROM Friendship WHERE Friend_RequesterId = :requesterId AND Friend_RequesteeId = :requesteeId";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('requesterId' => $RequesteeId, 'requesteeId' => $RequesterId));
    $data = $pStatment->fetch();
    if($data){
        if($data['Status_Code'] == 'accepted'){
            echo 'Already a friend';
            return 2; // Already his friend
        }else{
            $sql = "UPDATE Friendship SET Status_Code = 'accepted' WHERE Friend_RequesterId= :requesterId AND Friend_RequesteeId = :requesteeId";
            $pStatment = $myPdo->prepare($sql);
            $pStatment->execute(array('requesterId' => $RequesteeId, 'requesteeId' => $RequesterId));
            echo 'they become friends';
            return 4; // They become friends
        }
    }
    $sql = "INSERT INTO Friendship (Friend_RequesterId, Friend_RequesteeId, Status_Code) VALUES (:requesterId, :requesteeId, 'request')";
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('requesterId' => $RequesterId, 'requesteeId' => $RequesteeId));
    echo 'Sent Friend Request';
    return 5; // Friend Request Sent
}

?>