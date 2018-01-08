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
        <h1 style="text-align: center">Upload Pictures</h1>
        <p>Accepted picture types: JPG(JPEG), GIF, PNG</p>
        <p class="mb-5">You can upload multiple pictures at a time by pressing the shift key while selecting pictures</p>
            
        <form action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <p>Accepted picture types: JPG(JPEG), GIF, PNG</p>
            <p>You can upload multiple picture at a time by pressing shift key while selecting pictures</p>
            <p>When uploading multiple pictures, the tile and description fields will be applied to all pictures.</p>
            <br />
            <div class="form-group row">
                <label for="albums" class="col-lg-2">Album:</label>
                <div class="col-lg-4">
                    <select class="form-control" id="albums">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <span class="col-lg-5 text-danger">
                    Album dropdown error field
                </span>
            </div>

            <div class="form-group row">
                <label for="example-text-input" class="col-lg-2 col-form-label">Upload Pictures:</label>
                <div class="col-lg-4">
                    <input type="file" class="form-control" name="txtUpload[]" accept="image/gif, image/jpeg, image/png" multiple />
                </div>
                <span class="col-lg-5 text-danger">
                    Upload Picture error field
                </span>
            </div>
                
            <div class="form-group row">
                <label for="example-text-input" class="col-lg-2 col-form-label">Title:</label>
                <div class="col-lg-4">
                    <input class="form-control" type="text" value="" id="example-text-input">
                </div>
                <span class="col-lg-5 text-danger">
                    Title error field
                </span>
            </div>
                
            <div class="form-group row">
                <label for="exampleTextarea" class="col-lg-2 col-form-label">Description</label>
                <div class="col-lg-4">
                    <textarea class="form-control" id="description" rows="3"></textarea>
                </div>
            </div>
            <br>
            <input type="submit" name="btnUpload" class="col-md-2 mb-2 btn btn-primary" />
            <br>
            <br>
            <br>
        </form>
                        
        <div class="col-lg-5 text-danger">
            <?php echo $error ?>
        </div>
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>