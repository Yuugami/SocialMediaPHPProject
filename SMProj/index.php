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
        <p>
            If you have never used this website before,
            <a href="./NewUser.php">sign-up</a> is required.
        </p>
        <p>
            If you have already signed up, you can
            <a href="./Login.php">login</a> now.
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>