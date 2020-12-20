<!-- for comment setting and getting in detail page-->
<?php
function setComments($connection){
  if (isset($_POST['commentSubmit'])) {
  $uid = $_POST['uid'];//user ID
  $date = $_POST['date'];//time
  $message = $_POST['message'];//write done the comments
  $game= $_POST['game'];//game name

  $sql = "INSERT INTO comments (uid, date, message, game) VALUES ('$uid','$date', '$message', '$game')";

  $result = $connection->query($sql);
  }
}

function getComments($connection) {
  $game= $_GET['varname'];
  $sql = "SELECT * FROM comments WHERE game = '$game'";
  $result = $connection->query($sql);
  while ($row = $result->fetch_assoc()) {
    echo "<div class='comment-box'><p>";
    echo $row['uid']."<br>";//show user ID
    echo $row['date']."<br>";//show time
    echo nl2br($row['message']);//long breaks when user write comments
    echo "</p></div>";
  }

}
