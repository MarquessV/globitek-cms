<?php
  require_once('../private/initialize.php');
  include '../private/validate_functions.php';

  // Set default values for all variables the page needs.
  
  $username=$firstname=$lastname=$email="";
  $firsterror=$lasterror=$emailerror=$usererror=False;
  $namelength = array('min' => 2, 'max' => 255);
  $userlength = array('min' => 8, 'max' => 255);
  $namesymbols = array('-',',','.','\'');

  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['firstname'])) {
        $firstname=$_POST['firstname'];
        if(!has_length($firstname, $namelength) || !valid_symbols($firstname, $namesymbols)) {
            $firsterror=True; 
        }
    }
    if(isset($_POST['lastname'])) {
        $lastname=$_POST['lastname'];
        if(!has_length($lastname, $namelength) || !valid_symbols($lastname, $namesymbols)) {
            $lasterror=True; 
        }
    }
    if(isset($_POST['email'])) {
        $email=$_POST['email'];
        if(!has_valid_email_format($email)) {
            $emailerror=True; 
        }
    }
    if(isset($_POST['username'])) {
        $username=$_POST['username'];
        if(!has_length($username, $userlength) || !valid_user($username)) {
            $usererror=True; 
        }
    }
    if(!$firsterror && !$lasterror && !$emailerror && !$usererror) {
        $sql = "INSERT INTO users (first_name, last_name, email, username)
                VALUES (\"$firstname\", \"$lastname\", \"$email\", \"$username\")";
        $result = db_query($db, $sql);
        if($result) {
            db_close($db);
            header('Location: registration_success.php');
        }
        else {
            echo db_error($db);
            db_close($db);
            exit;
        }
    }
  }
?>
<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>
  <?php
    if($firsterror || $lasterror || $emailerror || $usererror) {
        echo "<ul>\n";
    }
    if($firsterror) {
        echo "<li>Invalid first name provided (2-255 alphabetic or -, ., ' characters).</li>\n";
    }
    if($lasterror) {
        echo "<li>Invalid last name provided (2-255 alphabetic or -, ., ' characters). </li>\n";
    }
    if($emailerror) {
        echo "<li>Invalid email address. </li>\n";
    }
    if($usererror) {
        echo "<li>Invalid username (8-255 alphanumeric or _ characters). </li>\n";
    }
    if($firsterror || $lasterror || $emailerror || $usererror) {
        echo "</ul>\n";
    }
  ?>

  <form action="" method="post">
    First name: <br>
    <input type="text" name="firstname" value="<?php echo htmlspecialchars($firstname) ?>"> <br>
    Last name: <br>
    <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname) ?>"> <br>
    Email: <br>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>"> <br>
    Username: <br>
    <input type="text" name="username" value="<?php echo htmlspecialchars($username) ?>"> <br>
    <br>
    <input type="submit" value="Submit"> <br>
  </form>
    

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
