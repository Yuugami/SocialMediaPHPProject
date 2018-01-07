
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<body>
    <?php include ("./CommonFiles/Header.php"); ?>
    <div class="container">
        <h1 style="text-align: center">My Albums</h1>
        <br>
        <p class="text-center">
            Welcome <b><?php echo "$_SESSION[LoggedInUserName]"; ?></b>! 
            (Not you? Change users <a href="<?php echo $directoryPrefix; ?>/Logout.php">here</a>.)
        </p>
        <br>
        <table class="table">
            <tr>
                <th>Title</th>
                <th>Date Updated</th>
                <th>Number of Pictures</th>
                <th>Accessibility</th>
                <th></th>
            </tr>
            <?php
            // Print All Albums
            for ($i = 0; $i <= 5; $i++) {
                echo <<< EOT
                <tr>
                <td>My China Trip</td>
                <td>2017-09-04</td>
                <td>14</td>
                <td>
                    <select class="form-control" id="accessibility" name="accessibility" value="<?php echo $accessibility; ?>">
                        <option style="display:none">Please Select Number of Years</option>
                        <option value="private">Accessible Only by Owner</option>
                        <option value="shared">Accessible by Owner and Friends</option>
                    </select>
                <td><a href="#">delete</a></td>
EOT;
            }
            ?>
        </table>
    </div>
    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
