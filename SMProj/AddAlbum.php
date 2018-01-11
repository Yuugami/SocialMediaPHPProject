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
// On Post...
// 1. Validate
// 2. Add To Databse
if ($_POST) {
    /* Section One */
    $error = false;
    if (!validateAddAlbum($_POST[title])) {
        $titleerrormsg = "Required Field";
        $error = true;
    }

    if (!validateAddAlbum($_POST[accessibility])) {
        $accessibilityerrormsg = "Required Field";
        $error = true;
    }

    /* Section Two */
    if (!$error) {
        $time = date('Y-m-d');
        $createdAlbumID = CreateAlbum($_POST[title], $_POST[description], $time, $_SESSION[LoggedInUserId], $_POST[accessibility]);
        mkdir("Pictures/$createdAlbumID");
        mkdir("Pictures/$createdAlbumID/Original");
        mkdir("Pictures/$createdAlbumID/Album");
        mkdir("Pictures/$createdAlbumID/Thumbnail");
    }
}
?>
<body>
    <div class="container">
        <h1 style="text-align: center">Create New Album</h1>
        <br>
        <p class="text-center">
            Welcome <b><?php
                        $Name = htmlspecialchars($_SESSION[LoggedInUserName]);
                        echo "$Name"; ?></b>! 
            (Not you? Change users <a href="<?php echo $directoryPrefix; ?>/Logout.php">here</a>.)
        </p>
        <br>
        <form class="form-horizontal" id="depositForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="title" class="col-lg-2 col-lg-offset-1 control-label" style="text-align: left">Title</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
                </div>
                <div class="col-lg-4 text-danger">
                    <?php echo $titleerrormsg ?>
                </div>                        
            </div>
            <div class="form-group">
                <label for="accessibility" class="col-lg-2 col-lg-offset-1 control-label" style="text-align: left">Accessibility:</label>
                <div class="col-lg-5">
                    <select class="form-control" id="accessibility" name="accessibility" value="<?php echo $accessibility; ?>">
                        <option value="" style="display:none">Please Select Level of Access</option>
                        <option value="private">Accessible Only by Owner</option>
                        <option value="shared">Accessible by Owner and Friends</option>              
                    </select>
                </div>
                <div class="col-lg-4 text-danger">
                    <?php echo $accessibilityerrormsg ?>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-lg-2 col-lg-offset-1 control-label" style="text-align: left">Description:</label>
                <div class="col-lg-5">
                    <textarea rows="6" type="" class="form-control" id="description" name="description" value="<?php echo $description; ?>"></textarea>
                </div>                        
            </div>
            <br>
            <div class="col-lg-offset-1">
                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                <button class="btn btn-primary" type="submit" name="reset">Clear</button>
            </div>
            <br>
        </form>
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
