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
?>
<body>
    <div class="container">
        <h1 class="text-center">My Friends</h1>
        <br>
        <p class="text-center">
            Welcome <b><?php echo "$_SESSION[LoggedInUserName]"; ?></b>!
            (Not you? Change users <a href="<?php echo $directoryPrefix; ?>/Logout.php">here</a>.)
        </p>
        <br>
        <form class="form-horizontal" id="defriendForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row">
                <span class="col-lg-3">Friends:</span>
                <span class="col-lg-offset-7">
                    <a href="AddFriend.php">Add Friends</a>
                </span>
            </div>
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <th>Name</th>
                    <th>Shared Albums</th>
                    <th>Unfriend</th>
                </thead>
                <?php
                $listOfFriends = getFriendsList($_SESSION["LoggedInUserId"]);
                $index = 0;
                //var_dump($listOfFriends);
                foreach ($listOfFriends as $friend) {
                    echo <<<EOT
                    <tr>
                        <td>$friend[Name]</td>
                        <td>$friend[AlbumsShared]</td>
                        <td>
                            <input type="checkbox" name="friend$index" value="value$index" />
                        </td>
                    </tr>
EOT;
                }
                ?>
            </table>
            <input type="submit" name="Defriend" value="Unfriend" class="col-lg-2 btn btn-primary pull-right" />
            <div class="clearfix"></div>
        </form>

        <form class="form-horizontal" id="friendRequestForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <th>Name</th>
                    <th>Accept or Deny</th>
                </thead>
                <?php
                $listOfRequests = getFriendsRequests($_SESSION["LoggedInUserId"]);
                //var_dump($listOfRequests);
                foreach ($listOfRequests as $request) {
                    echo <<<EOT
                    <tr>
                        <td>$request[Name]</td>
                        <td>
                            <input type="checkbox" name="friend$index" value="value$index" />
                        </td>
                    </tr>
EOT;
                }
                ?>
            </table>
            <div class="form-group rows">
                <input type="button" name="Reject" value="Reject Selected" class="col-lg-2 btn btn-primary ml-10px pull-right" />
                <input type="submit" name="Accept" value="Accept Selected" class="col-lg-2 btn btn-primary pull-right" />
            </div>

            <div class="clearfix"></div>

        </form>
    </div><?php include ("./CommonFiles/Footer.php"); ?>
</body>
