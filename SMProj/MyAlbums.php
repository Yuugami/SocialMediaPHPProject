
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<body>
    <?php include ("./CommonFiles/Header.php"); ?>
    <div class="container">
        <h1>My Albums</h1>
        <p>
            Welcome <?php echo $studentName?>! (not you? change user <a href="<?php echo $directoryPrefix;?>/Logout.php">here</a>
        </p>
        <table class="table">
            <tr>
                <td>Title</td>
                <td>Date Updated</td>
                <td>Number of Pictures</td>
                <td>Accessibilitiy</td>
                <td></td>
            </tr>
        </table>
    </div>

    <?php include ("./CommonFiles/Footer.php"); ?>
</body>
