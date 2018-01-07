<?php
// Login Query function
function connectToDb(){
    $dbConnection = parse_ini_file("db_connection.ini");
    extract($dbConnection);
    return new PDO($dsn, $user, $password);;
}

function loginQuery($UserId, $Password) {
    $myPdo = connectToDb();
    $sql = 'SELECT UserId, Name FROM Users WHERE UserId = :userId AND Password = :password';
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('userId' => $UserId, 'password' => $Password));
    $data = $pStatment->fetch();
    if ($data)
        return $data;
    else
        return FALSE;
}

function checkUserId($UserId){
    $myPdo = connectToDb();
    $sql = 'SELECT Name FROM Users WHERE UserId = :userId';
    $pStatment = $myPdo->prepare($sql);
    $pStatment->execute(array('userId' => $UserId));
    $data = $pStatment->fetch();
    if ($data)
        return TRUE; // If User Exists
    else
        return FALSE; // If User does not exist
}

function CreateAlbum($title, $description, $date, $ownerId, $accessibility){

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
?>