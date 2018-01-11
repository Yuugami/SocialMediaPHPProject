<?php include ("./CommonFiles/Header.php"); ?>
<!--
Windjy Jean, Sarah Liu, Faizan Alam
CST8257 - Web Applications Development
PHP Social Media Project
-->
<?php
// If user is logged in, assign Student object to $LoggedInUser, otherwise redirect to login and die (self-executing function)
if (!isset($_SESSION["LoggedInUserId"])) {
    header("Location: Login.php?returnUrl=".urlencode($_SERVER['REQUEST_URI']));
    die();
}

if ($_GET) {
    $selectedAlbum = getAnAlbum($_GET[albumID]);
    $fileName = getAPictureInfo($_GET[photoID]);
    $fileName = $fileName[FileName];
    $path = "./Pictures/" . $_GET[albumID] ."/Original/" . $fileName;
    var_dump($path);

    if ($_GET[action] == "rotateLeft") {
        $direction = 90;
        rotatePicture($path, $direction, $_GET[albumID]);
    }

    if ($_GET[action] == "rotateRight") {
        $direction = 270;
        rotatePicture($path, $direction, $_GET[albumID]);
    }

    if ($_GET[action] == "download") {
        downloadPicture($path);
    }

    if ($_GET[action] == "delete") {
        deletePictureFromDb($_GET[photoID]);
        unlink($path);
        //deletePicture($path);
    }

    if ($_GET[action]) {
        $currentURL = $_SERVER[REQUEST_URI];
        $whatToDelete = strpos($currentURL, "&action");
        $newURL = substr_replace($currentURL,"", $whatToDelete);
        header("Location: " . $newURL);
    }
}

$loggedInUsersAlbums = showAlbums($_SESSION["LoggedInUserId"]);

// save comments to db
$leavecomment = "";
$date = date("Y-m-d");
if ($_GET[photoID] != null)
{
    $pictureid = $_GET[photoID];
    $_SESSION["theThumbLastClicked"] = $pictureid;
}
if (isset($_POST["submit"])) {
    if (isset($leavecomment)) {
        $leavecomment = trim($_POST["leavecomment"]);
        if ($_SESSION["theThumbLastClicked"] != null && $leavecomment != "") {
            saveCommentsDb($_SESSION["LoggedInUserId"], $_SESSION["theThumbLastClicked"], $leavecomment, $date);
        }
    }
}

if($_POST) {
    $postAlbumID = $_POST[albums];
    $postImageID = $_SESSION["theThumbLastClicked"];
    header("Location: MyPictures.php?albumID=$postAlbumID&photoID=$postImageID");
}


?>
<body>
    <div class="container">
        <h1>My Pictures</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <select class="form-control" id="albums" name="albums" onchange="reloadPage(this.value)">
                <option value="" style="display:none">Please Select Album to Display</option>
                <?php
                foreach ($loggedInUsersAlbums as $anAlbum) {
                    if ($anAlbum[Album_Id] == $selectedAlbum[Album_Id]) {
                        $albumTitle = htmlspecialchars($anAlbum[Title]);
                        $albumTitle = htmlspecialchars($albumTitle);
                        echo "<option value='$anAlbum[Album_Id]' selected>$albumTitle</option>";
                    }
                    else {
                        $albumTitle = htmlspecialchars($anAlbum[Title]);
                        echo "<option value='$anAlbum[Album_Id]'>$albumTitle</option>";
                    }
                }
                $albumsPictures = getAlbumsPictures($_GET[albumID]);
                foreach ($albumsPictures as $picture) {
                    if ($picture[Picture_Id] == $_GET[photoID]) {
                        $selectedPicture = $picture;
                        $_SESSION["theLastPickedPicture"] = $selectedPicture;
                    }
                }
                ?>
            </select>
            <div class="row">
                <h2 class="col-lg-8 col-lg-offset-3">
                    <?php
                    $selectedPictureTitle = htmlspecialchars($selectedPicture[Title]);
                    echo $selectedPictureTitle ?>
                </h2>
            </div>
            <div class="row">
                <div class="selectedPicture col-lg-8">
                    <div class="thePicture">
                        <img src="./Pictures/<?php echo $selectedAlbum[Album_Id]?>/Album/<?php echo htmlspecialchars($selectedPicture[FileName]) ?>?<?php echo time() ?>" alt="Picture Goes Here" />
                    </div>
                    <div class="pictureIcons">
                        <a href="<?php echo $_SERVER[REQUEST_URI]?>&action=rotateLeft" id="rotateLeft">
                            <span class="glyphicon glyphicon-repeat gly-flip-horizontal"></span>
                        </a>
                        <a href="<?php echo $_SERVER[REQUEST_URI]?>&action=rotateRight" id="rotateRight">
                            <span class="glyphicon glyphicon-repeat"></span>
                        </a>
                        <a href="<?php echo $_SERVER[REQUEST_URI]?>&action=download" id="download">
                            <span class="glyphicon glyphicon-download-alt"></span>
                        </a>
                        <a href="<?php echo $_SERVER[REQUEST_URI]?>&action=delete" id="trash">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </div>
                </div>
                <div class="descriptionSection col-lg-4">
                    <?php echo "<p><b>Description:</b></p>";
                    $selectedPic = htmlspecialchars($selectedPicture[Description]);
                    echo "$selectedPic"?>
                </div>
                <div class="commentSection col-lg-4">
                    <?php
                    //$selectedPicture[Picture_Id] = 1;
                    $comments = getCommentsDb($selectedPicture[Picture_Id]);
                    echo "<p><b>Comments:</b></p>";
                    foreach ($comments as $aComment) {
                        echo "<p>";
                        $name = getUserName($aComment[Author_Id]);
                        $name = htmlspecialchars($name[UserName]);
                        echo "<span class='distinct'>$name ";
                        $date = $aComment[Comment_Date];
                        $date = date_create_from_format('Y-m-d H:i:s', $date);
                        $date = date_format($date, 'Y-m-d');
                        echo "(";
                        echo $date;
                        $ComentText = htmlspecialchars($aComment[Comment_Text]);
                        echo "):</span> $ComentText</p>";
                    }
                    ?>
                </div>
                <div class="leaveCommentSection col-lg-4">
                    <textarea class="form-control" id="leavecomment" name="leavecomment" placeholder="Leave Comment..."></textarea>
                </div>
                <div class="addCommentSection col-lg-4">
                    <input type="submit" class="mb-2 btn btn-primary" name="submit" value="Add Comment" />
                </div>
                <div class="filmStrip col-lg-8">
                    <?php
                    $index = 0;
                    foreach ($albumsPictures as $picture)
                    {
                        if ($picture[Picture_Id] == $selectedPicture[Picture_Id]) {
                            echo "<div class='item selectedThumbnail'><img name='$picture[Picture_Id]' id='$picture[Picture_Id]' src='./Pictures/$selectedAlbum[Album_Id]/Thumbnail/$picture[FileName]?".time()."' alt='A Picture $index' /></div>";
                        }
                        else {
                            echo "<div class='item'><img id='$picture[Picture_Id]' src='./Pictures/$selectedAlbum[Album_Id]/Thumbnail/$picture[FileName]?".time()."' alt='A Picture $index' /></div>";
                        }

                        $index++;
                    }
                    ?>
                </div>
            </div>
        </form>    
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
    <script>
        function reloadPage(albumID) {
            document.location = 'MyPictures.php?albumID=' + albumID;
        }

        $(document).ready(function () {

            $(".item img").click(function () {
                var a = window.location.href;
                var regex = "&photoID";
                // If the photoID tag doesn't exist...
                if (a.search(regex) == -1) {
                    // Add one!
                    document.location = a + "&photoID=" + $(this).attr("id");
                }
                else {
                    // Otherwise remove it and add a new one.
                    var b = a.search(regex);
                    var whatToRemove = a.substr(b);
                    a = a.replace(whatToRemove, "");
                    document.location = a + "&photoID=" + $(this).attr("id");
                }
                
                //var srcName = $(this).attr("src");
                //var srcNameParts = srcName.split("/");
                //var albumPicture = '/Images/OwnerID/AlbumID/Album/' + srcNameParts[3];
                //$(".thePicture img").attr("src", albumPicture);
                 
                //$(".item").css("border-color", "black");
                //$(this).parent().css("border-color", "blue");
            });

            $(".selectedPicture").hover(function () {
                $(".pictureIcons").show();
            }, function () {
                $(".pictureIcons").hide();
            });
        });
    </script>
</body>
