<?php
// Include important pages here
include_once("CommonFiles/ConstantsAndSettings.php");
include_once("Classes.php");
// ================ Models ================

// ================ Database ==============
include_once("SqlScripts/Queries.php");
// ================ Sessions ==============
/* $_SESSION["LoggedInUserId"] - User's ID
 * $_SESSION["LoggedInUserName"] - User's name
*/
// ================================================================================
// Start the Session in the Header since the header is included in all the pages
session_start();
?>