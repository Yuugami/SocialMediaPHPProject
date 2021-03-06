<?php include_once ("DirectorySettings.php") ?>
<?php include_once ("IncludeAll.php"); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html lang="en" style="position: relative; min-height: 100%;">
<head>
    <title>Algonquin Social Media Website</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo $directoryPrefix; ?>/SiteResources/Contents/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $directoryPrefix; ?>/SiteResources/Contents/AlgCss/Site.css" rel="stylesheet" type="text/css" />
    <?php include ("./CommonFiles/Functions.php"); ?>
</head>
<body style="padding-top: 50px; margin-bottom: 60px;">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="padding: 10px" href="http://www.algonquincollege.com">
                    <img src="<?php echo $directoryPrefix; ?>/SiteResources/Contents/img/AC.png"
                         alt="Algonquin College" style="max-width:100%; max-height:100%;" />
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo $directoryPrefix; ?>/Index.php">Home</a></li>
                    <li><a href="<?php echo $directoryPrefix; ?>/MyFriends.php">My Friends</a></li>
                    <li><a href="<?php echo $directoryPrefix; ?>/MyAlbums.php">My Albums</a></li>
                    <li><a href="<?php echo $directoryPrefix; ?>/MyPictures.php">My Pictures</a></li>
                    <li><a href="<?php echo $directoryPrefix; ?>/UploadPictures.php">Upload Pictures</a></li>
                    <?php if (empty($_SESSION["LoggedInUserId"])) : ?>
                    <li><a href="<?php echo $directoryPrefix; ?>/Login.php">Log In</a></li>
                    <?php else : ?>
                    <li><a href="<?php echo $directoryPrefix; ?>/Logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
