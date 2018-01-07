<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<body>
    <?php include ("./CommonFiles/Header.php"); ?>
    <div class="container">
        <h1>Log In</h1>
        <p>You need to <a href="<?php echo $directoryPrefix; ?>/NewUser.php">sign up</a> if you're a new user.</p>
        <form class="form-horizontal" id="loginForm" action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="inputUserID" class="col-lg-2 control-label" style="text-align: left">User ID:</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="inputUserID" name="id" placeholder="User ID" />
                </div>
                <div class="col-lg-4 text-danger"></div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-lg-2 control-label" style="text-align: left">Password:</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="inputPassword" name="password" placeholder="Password" />
                </div>
                <div class="col-lg-4 text-danger"></div>
            </div>
            <input type="submit" name="btnLogin" class="col-lg-2 mb-2 btn btn-primary" value="Log In" />
            <input type="reset" name="btnReset" class="col-lg-2 mb-2 btn btn-primary" value="Reset" />
        </form>
    </div>

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
