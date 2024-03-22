<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Enquiry form</title>
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
<link rel="stylesheet" href="css/form.css">

</head>
<body>

<div class="header">
  <h2>Enquiry Form</h2>
</div>

<form action="form_valid.php" method="POST"  style="text-align:center;">


  <div class="input-group">
    <label><b>Email Id</b></label>

    <input type="email" name="email_id" id="email_id" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{3,}"  placeholder="Email Id" required>

  </div>
  <div class="input-group">
    <label><b>User Name</b></label>
    <div class="input-group">
      <input type="text" name="name" id="name" placeholder="Full Name" required>

    </div>
    <div class="input-group">
      <label><b>Mobile No</b></label>

      <input type="text" name="phone_number" id="phone_number" pattern="[0-9]*" maxlength="10" minlength="10" placeholder="Mobile No" required>

    </div>

    <input class="button1" type="submit" value="Submit" id="Register"><br>




   
  </div>

</form>



</body>
</html>
