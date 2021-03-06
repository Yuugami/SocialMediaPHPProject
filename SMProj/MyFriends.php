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

if ($_POST) {
    if ($_POST[Defriend]) {
        if ($_POST[friend] != null) {
            $friendsToDelete = $_POST[friend];
            foreach ($friendsToDelete as $goodByeFriend) {
                deleteFriend($_SESSION["LoggedInUserId"], $goodByeFriend);
            }    
        }
    }

    if ($_POST[Accept]) {
        if ($_POST[friend] != null) {
            foreach ($_POST[friend] as $friend) {
                AcceptFriendRequest($_SESSION["LoggedInUserId"], $friend);
            }            
        }
    }

    if ($_POST[Reject]) {
        if ($_POST[friend] != null) {
            foreach ($_POST[friend] as $friend) {
                RejectFriendRequest($_SESSION["LoggedInUserId"], $friend);
            }            
        }
    }
}
?>
<body>
    <div class="container">
        <h1 class="text-center">My Friends</h1>
        <br>
        <p class="text-center">
            
            Welcome <b>
            <?php 
            $Name = htmlspecialchars($_SESSION[LoggedInUserName]);
            echo "$Name"; 
            ?></b>!
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
                    $friendsName = htmlspecialchars($friend[Name]);
                    $friendsID = htmlspecialchars($friend[UserId]);
                    $friendsAlbumShared = htmlspecialchars($friend[AlbumsShared]);
                    echo <<<EOT
                    <tr>
                        <td><a href='FriendPictures.php?friendID=$friendsID'>$friendsName</a></td>
                        <td>$friendsAlbumShared</td>
                        <td>
                            <input type="checkbox" name="friend[]" value='$friendsID'/>
                        </td>
                    </tr>
EOT;
                    $index++;
                }
                ?>
            </table>
            <input type="submit" name="Defriend" value="Unfriend" class="col-lg-2 btn btn-primary pull-right" />
            <div class="clearfix"></div>
        </form>

        <form class="form-horizontal" id="friendRequestForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <p>Friend Requests:</p>
            <table class="table table-striped">
                <thead class="thead-inverse">
                    <th>Name</th>
                    <th>Accept or Deny</th>
                </thead>
                <?php
                $listOfRequests = getFriendsRequests($_SESSION["LoggedInUserId"]);
                //var_dump($listOfRequests);
                if ($listOfRequests != null) {
                    foreach ($listOfRequests as $request) {
                        $RequestsName = htmlspecialchars($request[Name]);
                        echo <<<EOT
                        <tr>
                            <td>$RequestsName</td>
                            <td>
                                <input type="checkbox" name="friend[]" value="$request[UserId]" />
                            </td>
                        </tr>
EOT;
                    }                    
                }
                ?>
            </table>
            <div class="form-group rows">
                <input type="submit" name="Reject" value="Reject Selected" class="col-lg-2 btn btn-primary ml-10px pull-right" onclick="confirm('Are You Sure You Want to Delete The Selected Request(s)?')" />
                <input type="submit" name="Accept" value="Accept Selected" class="col-lg-2 btn btn-primary pull-right" />
            </div>

            <div class="clearfix"></div>

        </form>
    </div><?php include ("./CommonFiles/Footer.php"); ?>
    <script>
        $(document).ready(function () {
            $("input[name=Defriend]").on("click", function () {
                return confirm("The selected friends will be deleted!");
            });
        });
    </script>
</body>
