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

$albumList = showAlbums($_SESSION["LoggedInUserId"]);

$album = "";
$albumerrormsg = "";

$file = "";
$fileerrormsg = "";

$title = "";

$description = "";

if (isset($_POST["submit"])) {    
    $filesize = $_FILES["file"]["size"];
    
    if (isset($album)) {
        $album = trim($_POST["album"]);        
    }
    $albumerrormsg = ValidateAlbum($album);

    if ($_FILES["file"]["name"][0] == "") {
        $fileerrormsg = "File(s) Required";
    } else {
        $fileerrormsg = "";
    }
    
    if (isset($title)) {
        $title = trim($_POST["title"]);
        $title = str_replace(array( '<', '>' ), '', $title);
    }

    if (isset($description)) {
        $description = trim($_POST["description"]);        
    }
    
    $date = date("Y-m-d");
    
    // CHANGE TO DYNAMIC PATH
    $pathSaveOriginal = "./Pictures/".$album."/Original";
    $pathSaveAlbum = "./Pictures/".$album."/Album";
    $pathSaveThumb = "./Pictures/".$album."/Thumbnail";
    
    for ($i = 0; $i < count($_FILES["file"]["tmp_name"]); $i++)
    {
        if ($_FILES["file"]["error"][$i] == 0)
        {
            $path = savefile($pathSaveOriginal, $i);

            $details = getimagesize($path);

            if ($details && in_array($details[2], $supportedImageTypes))
            {
                resamplefile($path, $pathSaveAlbum, IMAGE_MAX_WIDTH, IMAGE_MAX_HEIGHT);
                resamplefile($path, $pathSaveThumb, THUMB_MAX_WIDTH, THUMB_MAX_HEIGHT);
                UploadPictureDataDb($album, $_FILES["file"]["name"][$i], $title, $description, $date);
            }
            else
            {
                $error = "Uploaded file is not of an accepted file type.";
                unlink($path);
            }
        }
        elseif ($_FILES["file"]["error"][$i] == 1)
        {
            $error = "Uploaded file is too large.";
        }
        elseif ($_FILES["file"]["error"][$i] == 4)
        {
            $error = "No upload file specified.";
        }
        else
        {
            $error = "Error occurred while uploading file. Please try again later.";
        }        
    }
}

?>
<body>
    <div class="container">
        <h1 style="text-align: center">Upload Pictures</h1>
        <br>
        <div class="col-lg-offset-1">
            <p>Accepted picture types: JPG (JPEG), GIF, and PNG.</p>
            <p>You can upload multiple pictures at a time by holding the SHIFT key while selecting pictures.</p>
            <p>When uploading multiple pictures, the title and description fields will be applied to all pictures.</p>            
        </div>
        <br>
            
        <form action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">   
            <div class="form-group row">
                <label for="album" class="col-lg-2 col-lg-offset-1 control-label" style="text-align: left">Upload to Album:</label>
                <div class="col-lg-5">
                    <select class="form-control" id="album" name="album" value="<?php echo $album; ?>">
                        <option value="" style="display:none">Please Select Album to Use</option>
                            <?php
                            foreach ($albumList as $eachalbum) {
                                $albumTitle = htmlspecialchars($eachalbum[Title]);
                                echo "<option value='", $eachalbum["Album_Id"], "'", isset($_POST["album"]) && $_POST["album"] == $eachalbum[Title] ? "selected='selected'" : "", ">", $albumTitle, "</option>";
                            }
                            ?>           
                    </select>
                </div>
                <div class="col-lg-4 text-danger">
                    <?php echo $albumerrormsg ?>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="file" class="col-lg-2 col-lg-offset-1 control-label" style="text-align: left">File to Upload:</label>
                <div class="col-lg-5">
                    <input type="file" multiple accept="image/gif, image/jpeg, image/png" class="form-control" id="file" name="file[]" value="<?php echo $file; ?>" />
                </div>
                <div class="col-lg-4 text-danger">
                    <?php echo $fileerrormsg ?>
                </div>    
            </div>
            
            <div class="form-group row">
                <label for="title" class="col-lg-2 col-lg-offset-1 control-label" style="text-align: left">Title:</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
                </div>   
            </div>
                
            <div class="form-group row">
                <label for="description" class="col-lg-2 col-lg-offset-1 control-label" style="text-align: left">Description:</label>
                <div class="col-lg-5">
                    <textarea rows="6" type="" class="form-control" id="description" name="description"><?php if(isset($_POST['description'])) { echo $_POST['description']; } ?></textarea>
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