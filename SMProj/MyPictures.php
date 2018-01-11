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
}

$loggedInUsersAlbums = showAlbums($_SESSION["LoggedInUserId"]);

?>
<body>
    <div class="container">
        <h1>My Pictures</h1>
        <form action="/" method="post"></form>
        <select class="form-control" id="albums" name="albums" onchange="reloadPage(this.value)">
            <?php
            foreach ($loggedInUsersAlbums as $anAlbum) {
                if ($anAlbum[Album_Id] == $selectedAlbum[Album_Id]) {
                    echo "<option value='$anAlbum[Album_Id]' selected>$anAlbum[Title]</option>";
                }
                else {
                    echo "<option value='$anAlbum[Album_Id]'>$anAlbum[Title]</option>";
                }
            }
            $albumsPictures = getAlbumsPictures($_GET[albumID]);
            foreach ($albumsPictures as $picture) {
                if ($picture[Picture_Id] == $_GET[photoID]) {
                    $selectedPicture = $picture;
                }
            }
            ?>
        </select>
        <div class="row">
            <h2 class="col-lg-8 col-lg-offset-3"><?php echo $selectedAlbum[Title]?></h2>
        </div>
        <div class="row">
            <div class="selectedPicture col-lg-8">
                <div class="thePicture"><img src="/Images/OwnerID/AlbumID/Original/<?php echo $selectedPicture[FileName]?>" alt="Picture Goes Here" /></div>
                <div class="filmStrip">
                    <?php
                    $index = 0;
                    foreach ($albumsPictures as $picture)
                    {
                        echo "<div class='item'><img id='$picture[Picture_Id]' src='/Images/OwnerID/AlbumID/Thumbnail/$picture[FileName]' alt='A Picture $index' /></div>";
                        $index++;
                    }
                    ?>
                </div>
            </div>
            <div class="descriptionSection col-lg-4">
                <?php echo "<p><b>Description:</b></p>";
                echo "$selectedPicture[Description]"?>
            </div>
            <div class="commentSection col-lg-4">
                <?php
                $comments = getCommentsDb($selectedPicture[Picture_Id]);
                echo "<p><b>Comments:</b></p>";
                foreach ($comments as $aComment) {
                    echo "<p>";
                    $name = getUserName($aComment[Author_Id]);
                    $name = $name[UserName];
                    echo "<span class='distinct'>$name ";
                    echo "($aComment[Comment_Date]):</span> $aComment[Comment_Text]</p>";
                }
                ?>
            </div>
            <div class="leaveCommentSection col-lg-4"><textarea placeholder="Leave Comment..."></textarea></div>
            <div class="addCommentSection col-lg-4">
                <input type="submit" class="mb-2 btn btn-primary" name="name" value="Add Comment" />
            </div>
        </div>
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
        });
    </script>
</body>
