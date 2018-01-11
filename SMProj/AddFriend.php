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
?>
<body>
    <div class="container">
        <h1 style="text-align: center">Add Friend</h1>
        <br>
        <p class="text-center">
            Welcome <b><?php
                        $Name = htmlspecialchars($_SESSION[LoggedInUserName]);
                        echo "$Name"; ?></b>! 
            (Not you? Change users <a href="<?php echo $directoryPrefix; ?>/Logout.php">here</a>.)
        </p>
        <p class="text-center">Enter the ID of the user you want to add as a friend.</p><br>
        <?php
        if ($_POST) {
            echo "<p class='error' style='text-align: center'>";
            $code = addFriend($_SESSION["LoggedInUserId"], $_POST["id"]);
            $requestee = getUserName($_POST["id"]);
            $requestee = $requestee["UserName"];
            switch($code) {
                case 0:
                    echo "You can't send a request to yourself!";
                    break;
                case 1:
                    echo "This user does not exist.";
                    break;
                case 2:
                    echo "This user is already your friend! Go message him!";
                    break;
                case 3:
                    echo "You've already sent a request. Be patient.";
                    break;
                case 4:
                    echo "This user sent you a request as well! You guys are now friends!";
                    break;
                case 5:
                    echo "Your request has been sent to $requestee.<br>Once $requestee accepts your request, you and $requestee will be friends and be able to view each other's shared albums.";
                    break;
                default:
                    echo "If you get here, you're an actual shit.";

            }
            echo "</p><br>";
        }
        ?>
        <form class="form-horizontal col-lg-offset-2" id="depositForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="id" class="col-lg-1 col-lg-offset-1 control-label" style="text-align: left">ID:</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?>">
                </div>
                <div class="col-lg-6 text-danger">
                    <button class="btn btn-primary" type="submit" name="submit">Send Friend Request</button>
                    <?php echo $iderrormsg ?>
                </div>                        
            </div>
            <br>
        </form>
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>