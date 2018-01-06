<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <meta charset="UTF-8" />
    <title>Algonquin Social Media Website</title>
</head>
<body>
    <?php include ("./CommonFiles/Header.php"); ?>

    <h1>Log In</h1>
    <div class="wrapper">
        <p>
            You need to
            <a href="#">sign up</a>
            if you're a new user.
        </p>
        <form action="/" method="post">
            <div class="dataEntryContainer">
                <span>User ID:</span>
                <input type="text" name="name" value="" />
                <br /><br />
                <span>Password:</span>
                <input type="text" name="name" value="" />
                <br /><br />
                <div class="formButtons">
                    <input type="submit" name="name" value="Submit" />
                    <input type="reset" name="name" value="Clear" />
                </div>
            </div>
        </form>
    </div>


    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
</html>
