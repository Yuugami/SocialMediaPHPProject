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
        <h1 style="text-align: center">My Albums</h1>
        <br>
        <p class="text-center">
            Welcome <b><?php echo "$_SESSION[LoggedInUserName]"; ?></b>!
            (Not you? Change users <a href="<?php echo $directoryPrefix; ?>/Logout.php">here</a>.)
        </p>
        <br>
        <p class="col-lg-offset-10">
            <a href="AddAlbum.php">Create a New Album</a>
        </p>
        <table class="table">
            <tr>
                <th>Title</th>
                <th>Date Updated</th>
                <th>Number of Pictures</th>
                <th>Accessibility</th>
                <th></th>
            </tr>
            <?php
            // Print All Albums Portion
            // Get the album list
            $albumList = showAlbums($_SESSION["LoggedInUserId"]);
            //var_dump($albumList);
            foreach ($albumList as $album) {
            echo <<< EOT
            <tr>
            <td>$album[Title]</td>
            <td>$album[Date_Updated]</td>
            <td>14</td>
            <td>
                <select class="form-control" id="accessibility" name="accessibility" value="<?php echo $accessibility; ?>">
EOT;
                if ($album[Accessibility_Code] == "shared") {
                    echo "<option value='private'>Accessible Only by Owner</option>";
                    echo "<option value='shared' selected>Accessible by Owner and Friends</option>";
                }
                else {
                    echo "<option value='private' selected>Accessible Only by Owner</option>";
                    echo "<option value='shared'>Accessible by Owner and Friends</option>";
                }

            echo "</select>";
            echo "</td>";
            echo "<td><a href='#'>delete</a></td>";
            }
            ?>
        </table>
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
