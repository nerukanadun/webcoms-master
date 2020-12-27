<?php
    session_start();
    if($_SESSION['login_s'] != '6'){
        header('location:../../login.php');
    }
   
?>
<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
 	<link rel="stylesheet" href="../../css/nav_footer_styles.css">
   <link rel="stylesheet" href="../../css/reg_form_style.css">
 
</head>
<body>
 <nav>
       <div class="logo">WebComs</div>
           <input type="checkbox" id="click">
             <label for="click" class="menu-btn">
               <i class="fas fa-bars"></i>
             </label>
        <ul>
            <li><a href="publicationchairhomepage.php">Home</a></li>
			<li><a href="publishSubmissionGuidelines.php">Upload Guidelines For Paper Submission</a></li>
			<li><a href="uploadcoversub.php">Upload Pages</a></li>
			<li><a href="viewcamerareadycopies.php">View Camera-ready copy</a></li>
			<li><a href="autoproceeding.php">Auto generate proceeding</a></li>
            <li><a class="active" href="pub_change_password.php">Change Password</a></li>
			<li style="float:right; margin-right:40px"><a href="../logout.php">Log Out</a></li>
		
        <ul>

 </nav>
 <br><br>
   <h1>Change password</h1>
   <br><br>
   <div id="main-wrapper"> 
       
     <?php  
     
        ?>
           <form action="pub_change_password.php" method="post" class="myform">
               <fieldset>
                   <input type="password" name="pwd" id="" value="" placeholder="New Password"><br><br>
                   <input type="password" name="c_pwd" id="" value="" placeholder="Confirm Password"><br><br>

                   <button type="submit" name="submit">Change Password</button>

               </fieldset>
           </form>

       <?php


     ?>

     <?php
         if(isset($_POST["submit"])){
          require '../../dbconfig/config.php';
               $password=$_POST["pwd"];
               $c_password=$_POST["c_pwd"];
               $p_email=$_SESSION['p_email'];

               if(empty($password)||empty($c_password)){
                

                 echo '<script type="text/javascript">alert("Password Empty!!")</script>';

                exit();

               }else if($password !=$c_password){

                  echo '<script type="text/javascript">alert("Password Not same!!")</script>';

               }


                $encryptedpass = md5($password);

                $query="SELECT * from userinfotable WHERE email=? AND user_type=?;";
              
                 $user_type='PublicationChair';
                $stmt=mysqli_stmt_init($con);
                if(!mysqli_stmt_prepare($stmt,$query)){
                                   
                  echo "There was an error2";
                  exit();
                }else{
                  mysqli_stmt_bind_param($stmt,"ss",$p_email,$user_type);
                  mysqli_stmt_execute($stmt);
                  $result=mysqli_stmt_get_result($stmt);

                  if(!$row=mysqli_fetch_assoc($result) ){
                                 
                      echo "There was a error3!";
                      exit();
                  }else{
                  

                      $sql="UPDATE userinfotable SET password=? WHERE email=? AND user_type=?";

                      $stmt=mysqli_stmt_init($con);
                      if(!mysqli_stmt_prepare($stmt,$sql)){
                          
                            echo "There was an error4";
                            exit();
                      }else{
                            
                            $encryptedpass = md5($password);
                             mysqli_stmt_bind_param($stmt,"sss", $encryptedpass,$p_email,$user_type);
                             mysqli_stmt_execute($stmt);          
                            echo '<script type="text/javascript">alert("Password change succesfully!!")</script>';

                      }

                  }

            }
              

         }

     ?>
   </div>
   <div class="footer">
     <p>&copy;2020,All Rights Reserved By www.WebComs.lk </p>

   </div>


</body>
</html>

