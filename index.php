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

    <label for="search">Contact to be searched:<input type="text" name="search" id="search" palceholder="Search Contact"></label>
    <button type="button" id="button">Search</button>

    <div name="result" id="result"></div>

    </div>


<?php

    if($user->hasPermission('admin')) {
        echo '<p>You are a Administrator!</p>';
        if(Input::exists('post'))
        {   if(Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'name' => 'Name',
                    'required' => true,
                    'min' => 4,
                    'max' => 50
                ),
                'contact'=>array(
                    'name'=>'contact',
                    'min'=>10,
                    'max'=>12,
                    'required'=>true
                ),
                'year'=>array(
                    'name'=>'year',
                    'min'=>1,
                    'max'=>1,
                    'required'=>true
                )));
                if($validate->passed())
                {

                    $db=DB::getInstance();
                    try {
                        $data = $db->insert('contact', array(
                            'name' => Input::get('name'),
                            'contact' => Input::get('contact'),
                            'year' => Input::get('contact')
                        ));
                    }catch (Exception $e){
                        echo $e->getMessage();
                    }
                }
                else
                {foreach ($validate->errors() as $error) {
                    echo $error . "<br>";
                }}

            }
        }
        else{echo "Please fill the details!";}
        $token=Token::generate();

        echo "<form action='index.php' method='post'>
                   <label for='name'>Name: <input type='text' name='name' id='name' placeholder='name'></label>
                    <label for='contact'>Contact:<input type='text' name='contact' id='contact' placeholder='contact'></label>
                    <label for='year'>Year:<input type='text' name='year' id='year' placeholder='year'></label>
                    <input type='hidden' name='token' value='".$token."'>
                    <button type='submit'>Submit</button>
            </form>";
    }

} else {
    echo '<p>You need to <a href="login.php">login</a> or <a href="register.php">register.</a></p>';
}
?>
</body>
</html>