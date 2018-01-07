
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
// If user is logged in, assign Student object to $LoggedInUser, otherwise redirect to login and die (self-executing function)
$LoggedInUser = isset($_SESSION["LoggedInUser"]) ? $_SESSION["LoggedInUser"] : (function() { header("Location: Login.php?returnUrl=".urlencode($_SERVER['REQUEST_URI'])); die();})();
?>
<body>
    <?php include ("./CommonFiles/Header.php"); ?>
    <div class="container">
        <h1>My Pictures</h1>
        <select class="form-control" id="albums" name="albums" value="<?php echo $album; ?>">
            <?php
            for ($i = 0; $i <= 5; $i++) {
                echo <<< EOT
<option>$i</option>
EOT;
            }
            ?>
        </select>

        <div class="row">
            <h2 class="col-lg-8 col-lg-offset-3"><?php echo $selectedAlbum?>MIT</h2>
        </div>
        <div class="row">
            <div class="selectedPicture col-lg-8">
                Picture Goes Here
                <div class="filmStrip">
                    <?php
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
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
