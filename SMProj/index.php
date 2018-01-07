<?php include ("./CommonFiles/Header.php"); ?>
<!--
Windjy Jean, Sarah Liu, Faizan Alam
CST8257 - Web Applications Development
PHP Social Media Project
-->
<?php
$LoggedView = false;
if ($_SESSION["LoggedInUserId"]) {
    $LoggedView = true;
}
?>
<body>
    <div class="container-fluid" style="padding-top: 20px; padding-left: 40px">
        <h1>Welcome to the Algonquin Social Media Website<?php if($LoggedView) {echo ", $_SESSION[LoggedInUserName]";} ?></h1><br>
        <?php if ($LoggedView) : ?>
        <p>What will you do today?</p>
        <ul class="thingsToDoIndex">
            <li>See my <a href="MyFriends.php">Friends</a></li>
            <li>See my <a href="MyAlbums.php">Albums</a></li>
            <li>See my <a href="MyPictures.php">Pictures</a></li>
            <li>Upload <a href="UploadPictures.php">Pictures</a></li>
        </ul>
        <?php else : ?>
        <p>
            If you have never used this website before,
            <a href="./NewUser.php">sign-up</a> is required.
        </p>
        <p>
            If you have already signed up, you can
            <a href="./Login.php">login</a> now.
        </p>
        <?php endif; ?>
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>