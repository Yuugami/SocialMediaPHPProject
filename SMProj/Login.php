<?php include ("./CommonFiles/Header.php"); ?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$loginError = false;

if ($_POST) {
    // Gather Info
    $studentID = $_POST["inputUserID"];
    $password = $_POST["inputPassword"];

    // Connect to DB
    $info = loginQuery($studentID, $password);

    // Parse the Info
    $loginError = false;

    if ($info) {
        $_SESSION["LoggedInUserId"] = $info["UserId"];
        $_SESSION["LoggedInUserName"] = $info["Name"];

        // If there was an attempt to access a protected page...
        $returnToPath = $_SERVER["HTTP_REFERER"];
        // It will fetch it here...
        $theProtectedPage = explode("%2F", $returnToPath);
        // Otherwise it will go straight to index.
        if (sizeof($theProtectedPage) == 2)
            header("Location: $theProtectedPage[1]");
        else
            header("Location: index.php");
    }
    else {
        $loginError = true;
    }
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
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-lg-2 control-label" style="text-align: left">Password:</label>
                <div class="col-lg-3">
                    <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" />
                </div>
            </div>
            <?php
            if ($loginError) {
                echo <<<EOT
<div class="incorrectInfo">
    <p>Username or password is incorrect.</p>
</div>
EOT;
            }
            ?>
            <input type="submit" name="btnLogin" class="col-lg-2 mb-2 btn btn-primary" value="Log In" />
            <input type="reset" name="btnReset" class="col-lg-2 mb-2 btn btn-primary" value="Reset" />
        </form>
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
