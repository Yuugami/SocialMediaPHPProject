<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<body>
    <?php include ("./CommonFiles/Header.php"); ?>

    <h1>Log In</h1>
    <div class="wrapper">
        <p class="col-sm-3 col-sm-offset-1 control-label">
            You need to
            <a href="#">sign up</a>
            if you're a new user.
        </p>
        <form class="form-horizontal" id="loginForm" action="/" method="post">
            <div class="form-group">
                <label for="name" class="col-sm-3 col-sm-offset-1 control-label" style="text-align: left">Student ID:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name" name="studentid" value="<?php echo $studentid; ?>" />
                </div>
                <div class="col-sm-4 text-danger">
                    <?php echo $studenterrormsg ?>
                </div>
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
        </form>
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
