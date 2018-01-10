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
        <select class="form-control" id="albums" name="albums">            
            <?php
            foreach ($loggedInUsersAlbums as $anAlbum) {
                if ($anAlbum[Album_Id] == $selectedAlbum[Album_Id]) {
                    echo "<option value='$anAlbum[Album_Id]' selected>$anAlbum[Title]</option>";
                }
                else {
                    echo "<option value='$anAlbum[Album_Id]'>$anAlbum[Title]</option>";
                }
            }
            ?>
        </select>

        <div class="row">
            <h2 class="col-lg-8 col-lg-offset-3"><?php echo $selectedAlbum[Title]?></h2>
        </div>
        <div class="row">
            <div class="selectedPicture col-lg-8">
                <div class="thePicture">Picture Goes Here</div>
                <div class="filmStrip">                    <?php
                    $index = 0;
                    for ($i = 0; $i < 19; $i++)
                    {
                    echo "<div class='item'><img id='$index' src='' alt='A Picture' /></div>";
                    $index++;
                    }
                    ?>
                </div>
            </div>
            <div class="commentSection col-lg-4">Comments Goes Here</div>
        </div>
    </div><?php include ("./CommonFiles/Footer.php"); ?>
</body>
