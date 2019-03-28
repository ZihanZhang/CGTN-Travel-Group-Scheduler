<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Registration Page</h2>
        <a href="index.php">Click here to go back</a><br/><br/>
        <form action="register.php" method="POST">
           Enter Username: <br/>
           <input type="text" name="username" required="required" /> <br/>
           Enter password: <br/>
           <input type="password" name="password" required="required" /> <br/>
           <input type="submit" value="Register"/>
        </form>
    </body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $con = mysqli_connect("localhost", "root", "") or die(mysqli_error());
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  $bool = true;

  mysqli_select_db($con, "first_db")or die("Cannot connect to database");
  $query = mysqli_query($con, "Select * from users");
  while($row = mysqli_fetch_array($query)) {
    $table_users = $row['username'];
    if ($username == $table_users) {
      $bool = false;
      print '<script>alert("Username has been taken!");</script>';
      print '<script>window.location.assign(register.php");</script>';
    }
  }

  if($bool) {
    mysqli_query($con, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
    print '<script>alert("successfully Registered!");</script>';
    print '<script>window.location.assign("register.php");</script>';
  }

  echo "Username entered is ". $username . "<br/>";
  echo "Password entered is ". $password;
}
    
?>