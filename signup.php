<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="su.css">
</head>
<body>
<div class="container">
<form action="rAction.php" method="post" enctype="multipart/form-data">
  <h1><img src="deped.png" alt="DepEd" width="175px" height="140px"></h1>
  <form id="signup-form">
    <div class="form-group">
      <input type="text" name="fname" placeholder="First Name" required>
    </div>
    <div class="form-group">
      <input type="text" name="lname" placeholder="Last Name" required>
    </div>      
    <div class="form-group">
      <input type="text" name="contact" placeholder="Contact Number" required>
    </div>
    <div class="form-group">
      <input type="text" name="username" placeholder="Username" required>
    </div>
    <div class="form-group">
      <input type="password" name="password" placeholder="Password" required>
    </div>
    <div style="text-align:center;">
      <input type="checkbox" required> By creating an account you agree to our <a href="tnp.php" style="color:dodgerblue">Terms & Privacy</a>.
    </div>
    <div class="form-group">
      <button href="" type="submit" style="margin-top:20px">Sign Up</button>
    </div>
    <div style="text-align:center;">
      <a href="admin_login.php" style="color:dodgerblue">Already have an acccount?</a>
    </div>
  </form>
</div>

</body>
</html>
