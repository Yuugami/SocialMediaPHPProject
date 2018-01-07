<?php include ("./CommonFiles/Header.php"); ?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    // If user is logged in, assign Student object to $LoggedInUser, otherwise redirect to login and die (self-executing function)
    //$LoggedInUser = isset($_SESSION["LoggedInUser"]) ? $_SESSION["LoggedInUser"] : (function() { header("Location: Login.php?returnUrl=".urlencode($_SERVER['REQUEST_URI'])); die();})();
$loginError = false;

if ($_POST) {
    $studentID = $_POST["inputUserID"];
    $password = $_POST["inputPassword"];
}
?>

<body>
    <div class="container">
        <h1>Log In</h1>
        <p>You need to <a href="<?php echo $directoryPrefix; ?>/NewUser.php">sign up</a> if you're a new user.</p>
        <form class="form-horizontal" id="loginForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="form-group">
                <label for="inputUserID" class="col-lg-2 control-label" style="text-align: left">User ID:</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="inputUserID" name="inputUserID" placeholder="User ID" />
                </div>
                <div class="col-lg-4 text-danger"></div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-lg-2 control-label" style="text-align: left">Password:</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" />
                </div>
                <div class="col-lg-4 text-danger"></div>
            </div>
            <input type="submit" name="btnLogin" class="col-lg-2 mb-2 btn btn-primary" value="Log In" />
            <input type="reset" name="btnReset" class="col-lg-2 mb-2 btn btn-primary" value="Reset" />
        </form>
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
