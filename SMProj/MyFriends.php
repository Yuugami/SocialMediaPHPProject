<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php include ("./CommonFiles/Header.php"); ?>
        <div class="container">
            <h1 class="text-center">My Friends</h1>
            <p>Welcome Wei Gong!(not you change user <a>here</a>)!</p>
            <form class="form-horizontal" id="defriendForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="table table-striped">
                    <thead class="thead-inverse">
                       <th>Name</th>
                       <th>Shared Albums</th>
                       <th>Defriend</th>
                    </thead>
                    <tr>
                        <td>John Smith</td>
                        <td>0</td>
                        <td><input type="checkbox" name="friend1" value="value1"></td>
                    </tr>
                    <tr>
                        <td>Peter Adams</td>
                        <td>0</td>
                        <td><input type="checkbox" name="friend2" value="value2"></td>
                    </tr>
                </table>
                <input type="submit" name="Defriend" value="Defriend" class="col-lg-2 btn btn-primary pull-right" />
                <div class="clearfix"></div>
            </form>
            
            <form class="form-horizontal" id="friendRequestForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="table table-striped">
                    <thead class="thead-inverse">
                       <th>Name</th>
                       <th>Accept</th>
                    </thead>
                    <tr>
                        <td>Mary Johnson</td>
                        <td><input type="checkbox" name="friend3" value="value3"></td>
                    </tr>
                    <tr>
                        <td>Mark Watson</td>
                        <td><input type="checkbox" name="friend4" value="value4"></td>
                    </tr>
                </table> 
                <div class="form-group rows">
                    <input type="button" name="Regject" value="Reject Selected" class="col-lg-2 btn btn-primary ml-10px pull-right" />
                    <input type="submit" name="Accept" value="Accept Selected" class="col-lg-2 btn btn-primary pull-right" />
                </div>
                
                <div class="clearfix"></div>
                
            </form>
        </div>
        <?php include ("./CommonFiles/Footer.php"); ?>
    </body>
</html>
