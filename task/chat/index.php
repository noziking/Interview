<?php
include('config.php'); 

if (isset($_POST["username"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
    $user = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $sql="SELECT * FROM user WHERE username='{$user}' and password='{$password}' ";
    $result=$conn->query($sql);
    if ($result->num_rows > 0) {
        $data= $result->fetch_assoc();
        $_SESSION["id"]=$data["id"];$_SESSION["username"]=$data["username"];
        header("location:chat.php");
    } else { 
        $error ="Email / password is incorrect";
    }
    
}
?>
<html>
    <head></head>
    <body><center>
        <br/><br/>
        <h2>Chat Application</h2>
        <div style="color: red"><?php if(isset($error)) echo $error ; ?></div>
        <form action="" method="post">
        <table>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="username" required/></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="password" name="password" required/></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="login" value="Login"></td>
            </tr>
        </table>
        </form></center>
    </body>
</html>
