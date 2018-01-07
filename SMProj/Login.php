<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<body>
    <?php include ("./CommonFiles/Header.php"); ?>
    <div class="row">
        <div class="col-sm-5 col-sm-offset-3"><h1>Log In</h1></div>
        <div class="col-sm-4"></div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-sm-offset-1">You need to <a href="<?php echo $directoryPrefix; ?>/NewUser.php">sign up</a> if you're a new user.</div>
        <div class="col-sm-8"></div>
    </div>
    <br />

    <form class="form-horizontal" id="loginForm" action="/" method="post">
        <div class="form-group">
            <label for="inputUserID" class="col-sm-3 col-sm-offset-1 control-label" style="text-align: left">User ID:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputUserID" name="name" placeholder="User ID" />
            </div>
            <div class="col-sm-4 text-danger"></div>
        </div>
    </form>

            <!--<div class="dataEntryContainer">
                <span>User ID:</span>
                <input type="text" name="name" value="" />
                <br />
                <br />
                <span>Password:</span>
                <input type="text" name="name" value="" />
                <br />
                <br />
                <div class="formButtons">
                    <input type="submit" name="name" value="Submit" />
                    <input type="reset" name="name" value="Clear" />
                </div>
            </div>-->
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
