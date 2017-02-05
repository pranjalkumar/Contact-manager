<!DOCTYPE html>
<html>
<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
<script>
    $(document).ready(function(){
        $("#button").click(function(){
            var name=$("#search").val();
            $.ajax({
                url:'search.php',
                data:"name="+name,
                success:function (data) {
                    $("#result").html(data);
                }
            });
        });
    });
</script>
<?php


require_once 'core/init.php';

if(Session::exists('home')) {
    echo '<p>' . Session::flash('home'). '</p>';
}

$user = new User(); //Current

if($user->isLoggedIn()) {
?>

    <p>Hello, <a href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username); ?></p>

    <ul>
        <li><a href="update.php">Update Profile</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
    <p> Enter the details below to find the contact of the person</p>

    <label for="search"><input type="text" name="search" id="search" palceholder="Search Contact"></label>
    <button type="button" id="button">Search</button>

    <div name="result" id="result"></div>

    </div>


<?php

    if($user->hasPermission('admin')) {
        echo '<p>You are a Administrator!</p>';
    }

} else {
    echo '<p>You need to <a href="login.php">login</a> or <a href="register.php">register.</a></p>';
}
?>
</body>
</html>