<!DOCTYPE html>
<!--
Windjy Jean, Sarah Liu, Faizan Alam
CST8257 - Web Applications Development
PHP Social Media Project
-->

<body>
    <?php include ("./CommonFiles/Header.php"); ?>
    <div class="container">
        <h1 style="text-align: center">Create New Album</h1><br>
        <p class="text-center">Welcome <b>(insert name here)</b>! (Not you? Change user <a href="(insertlinkhere)">here</a>.)</p><br>

        <form class="form-horizontal" id="depositForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="title" class="col-lg-3 col-lg-offset-1 control-label" style="text-align: left">Title</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
                </div>
                <div class="col-lg-4 text-danger">
                    <?php echo $titleerrormsg ?>
                </div>                        
            </div>
            <div class="form-group">
                <label for="accessibility" class="col-lg-3 col-lg-offset-1 control-label" style="text-align: left">Accessibility:</label>
                <div class="col-lg-4">
                    <select class="form-control" id="accessibility" name="accessibility" value="<?php echo $accessibility; ?>">
                        <option style="display:none">Please Select Level of Access</option>
                        <option value="private">Accessible Only by Owner</option>
                        <option value="shared">Accessible by Owner and Friends</option>              
                    </select>
                </div>
                <div class="col-lg-4 text-danger">
                    <?php echo $accessibilityerrormsg ?>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-lg-3 col-lg-offset-1 control-label" style="text-align: left">Description:</label>
                <div class="col-lg-4">
                    <textarea rows="6" type="" class="form-control" id="description" name="description" value="<?php echo $description; ?>"></textarea>
                </div>
                <div class="col-lg-4 text-danger">
                    <?php echo $descriptionerrormsg ?>
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
