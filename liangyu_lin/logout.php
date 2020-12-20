
<?php
session_start();
// Destroy session
if(session_destroy())
{
// Redirecting to sign page
header("Location: sign_page.php");
}
?>
