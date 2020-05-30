<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$pass  = "";
$cpass = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'BlogTime');

// REGISTER USER
if (isset($_POST['Add'])) {
  // receive all input values from the form
  $username= mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $pass = mysqli_real_escape_string($db, $_POST['password']);
  $cpass = mysqli_real_escape_string($db, $_POST['cpassword']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($pass)) { array_push($errors, "Password is required"); }
  if (empty($cpass)) { array_push($errors, "Confirm Password is required");}
  if (!($cpass)==($pass)) { array_push($errors, "Password is not matching");}
  

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($pass);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username,email) VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	
  	header('location: index.php');
  }
}
// LOGIN USER
if (isset($_POST['Login_User'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM mydb WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {

          $_SESSION['username'] = $username;
          $_SESSION['email'] = $email;
          $_SESSION['phone'] = $phone;
          $_SESSION['DOB'] = $DOB;
          $_SESSION['designation'] = $designation;
          $_SESSION['address'] = $address;
          $_SESSION['gender'] = $gender;
          $_SESSION['DOJ'] = $DOJ;
          $_SESSION['qualification'] = $qualification;
          $_SESSION['img_path'] = $img_path;

          // $_SESSION['username'] = $username;
          if($username=="Admin")
          {
            header('location: Admin_Panel.php');  
          }
          else{header('location: home.php');}

          $_SESSION['success'] = "You are now logged in";
          
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }
  // NOTIFICATION SECTION

  if (isset($_POST['send'])){

    $username_2 = mysqli_real_escape_string($db,$_POST['user2']);
    $msg = mysqli_real_escape_string($db,$_POST['msg']);

    $query = "UPDATE mydb SET msg='$msg' WHERE username='$username_2'";
    if (mysqli_query($db, $query)) {
      // echo "Record updated successfully";
  } else {
      // echo "Error updating record: " . mysqli_error($db);
  }
}
//EDIT USER
if (isset($_POST['Edit'])) {

  // receive all input values from the form
  // $pass_old =mysqli_real_escape_string($db, $_POST['passold']); 
  $username= mysqli_real_escape_string($db, $_POST['user']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $DOB = mysqli_real_escape_string($db, $_POST['DOB']);
  $phone = mysqli_real_escape_string($db, $_POST['phone']);
  $pass = mysqli_real_escape_string($db,$_POST['pass']);
  $cpass = mysqli_real_escape_string($db,$_POST['cpass']);
  $designation = mysqli_real_escape_string($db, $_POST['designation']);
  $img_path = mysqli_real_escape_string($db, $_POST['img_path']);
  $perjob = mysqli_real_escape_string($db, $_POST['perjob']);
  $experience = mysqli_real_escape_string($db, $_POST['experience']);
  $FOW = mysqli_real_escape_string($db, $_POST['FOW']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($DOB)) { array_push($errors, "Date of Birth is required"); }
  if (empty($phone)) { array_push($errors, "Contact Number is required"); }
  

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    if($pass == $cpass)
    {
    $password = md5($cpass);
    
    $query = "UPDATE mydb SET username='$username' ,email='$email' ,phone = '$phone', DOB='$DOB' ,password='$password' ,designation = '$designation' , img_path = '$img_path' ,perjob='$perjob' ,experience='$experience',  FOW='$FOW' WHERE username='".$_SESSION['username']."' ";

    if (mysqli_query($db, $query)) {
      // echo "Record updated successfully";
      // header(' Location : index.php');
  } else {
      // echo "Something went wrong : ";
    // header('Location : home.php?logout=1 '); 
   }


  }
}
    
  }
  if (isset($_POST['ADD_TASK'])) {

    // receive all input values from the form
    // $pass_old =mysqli_real_escape_string($db, $_POST['passold']); 
    $username= mysqli_real_escape_string($db, $_POST['name']);
    // $email = mysqli_real_escape_string($db, $_POST['email']);
    // $DOB = mysqli_real_escape_string($db, $_POST['DOB']);
    // $phone = mysqli_real_escape_string($db, $_POST['phone']);
    // $pass = mysqli_real_escape_string($db,$_POST['pass']);
    // $cpass = mysqli_real_escape_string($db,$_POST['cpass']);
    $taskpath= mysqli_real_escape_string($db, $_POST['taskpath']);
  
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    // if (empty($email)) { array_push($errors, "Email is required"); }
    // if (empty($DOB)) { array_push($errors, "Date of Birth is required"); }
    // if (empty($phone)) { array_push($errors, "Contact Number is required"); }
    if (empty($taskpath)) { array_push($errors, "task path is required"); }
  
    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
      if($pass == $cpass)
      {
      $password = md5($cpass);
      
      $query = "UPDATE mydb SET taskpath='$taskpath'  WHERE username='$username' ";
  
      if (mysqli_query($db, $query)) {
        // echo "Record updated successfully";
        // header(' Location : Task.php');
    } else {
        // echo "Error updating record: " . mysqli_error($db);
    }
  
  
    }
  }
    }

    if (isset($_POST['SUB_TASK'])) {

      // receive all input values from the form
      // $pass_old =mysqli_real_escape_string($db, $_POST['passold']); 
      $username= mysqli_real_escape_string($db, $_POST['username']);
      // $email = mysqli_real_escape_string($db, $_POST['email']);
      // $DOB = mysqli_real_escape_string($db, $_POST['DOB']);
      // $phone = mysqli_real_escape_string($db, $_POST['phone']);
      // $pass = mysqli_real_escape_string($db,$_POST['pass']);
      // $cpass = mysqli_real_escape_string($db,$_POST['cpass']);
      $file_submit= mysqli_real_escape_string($db, $_POST['file_submit']);
    
      // form validation: ensure that the form is correctly filled ...
      // by adding (array_push()) corresponding error unto $errors array
      // if (empty($username)) { array_push($errors, "Username is required"); }
      // if (empty($email)) { array_push($errors, "Email is required"); }
      // if (empty($DOB)) { array_push($errors, "Date of Birth is required"); }
      // if (empty($phone)) { array_push($errors, "Contact Number is required"); }
      // if (empty($taskpath)) { array_push($errors, "task path is required"); }
    
      // Finally, register user if there are no errors in the form
      if (count($errors) == 0) {
        if($pass == $cpass)
        {
        $password = md5($cpass);
        
        $query = "UPDATE mydb SET file_submit='$file_submit' , complete='1' WHERE username='".$_SESSION['username']."' ";
    
        if (mysqli_query($db, $query)) {
          // echo "Record updated successfully";
          // header(' Location : Task.php');
      } else {
          // echo "Error updating record: " . mysqli_error($db);
      }
    
    
      }
    }
      }
      if (isset($_POST['take_attendance'])) {

          $sql = "SELECT * FROM mydb";

          $result = mysqli_query($db,$sql);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               
                $totaldays = $row["totaldays"];
               
        
            //    echo "Name: " . $row["username"]. "<br>";
            }
         } else {
            // echo "0 results";
         }

         $totaldays = $totaldays +1;
        
          $query = "UPDATE mydb SET atndnc='0' , totaldays='$totaldays' ";
      
          if (mysqli_query($db, $query)) {
            // echo "Record updated successfully";
            // header(' Location : Task.php');
        } else {
            // echo "Error updating record: " . mysqli_error($db);
        }
      
      //PAYMENT
        }
        if (isset($_POST['status'])) {

          $query = "UPDATE mydb SET status='1' ";
      
          if (mysqli_query($db, $query)) {
            // echo "Payment Process Executed Successfully !";
            // header(' Location : ad_salary_report.php');
        } else {
            // echo "Error updating record: " . mysqli_error($db);
        }
      
      
        }

      if (isset($_POST['apply_leave'])) {
      
      $user3 = mysqli_real_escape_string($db, $_POST['user3']);
      $fromdt = mysqli_real_escape_string($db, $_POST['fromdt']);
      $todt = mysqli_real_escape_string($db, $_POST['todt']);
      $leavetype = mysqli_real_escape_string($db, $_POST['leavetype']);
      $reason = mysqli_real_escape_string($db,$_POST['reason']);
      // $cpass = mysqli_real_escape_string($db,$_POST['cpass']);

        $query = "UPDATE mydb SET leavetype = '$leavetype',  reason='$reason' , fromdt='$fromdt' , todt = '$todt' , application=1 , approved=0  WHERE username= '".$_SESSION['username']."' ";
      
          if (mysqli_query($db, $query)) {
            echo "Leave Application process executed !";
            // header(' Location : ad_salary_report.php');
        } else {
            // echo "Error updating record: " . mysqli_error($db);
        }
      
      
        }

        if (isset($_POST['accept'])) {
          $sql = "SELECT * FROM mydb where application=1";

          $result = mysqli_query($db,$sql);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
               
                $user3 = $row["username"];
               
        
            //  echo "Name: " . $user3. "<br>";
            }
         } else {
            // echo "0 results";
         }
          


          
          $query = "UPDATE mydb SET approved='1' ,application ='0' WHERE username='$user3'";
          if (mysqli_query($db, $query)) {
            // echo "Record updated successfully 5";
        } else {
            // echo "Error updating record: " . mysqli_error($db);
        }

        }
        if (isset($_POST['decline'])) {
          
          $query = "UPDATE mydb SET approved='1' WHERE username='$user3'";
          if (mysqli_query($db, $query)) {
            // echo "Record updated successfully";
        } else {
            // echo "Error updating record: " . mysqli_error($db);
        }
        }

?>