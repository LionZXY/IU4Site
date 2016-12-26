<?php
function getUser($userid, $conn)
{
    $sql = "SELECT * FROM `user` WHERE `id` = $userid;";
    $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $row['password_md5']=null;
    return $row;
}

?>