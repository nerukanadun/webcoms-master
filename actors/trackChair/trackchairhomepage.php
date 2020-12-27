<?php
	session_start();
    if($_SESSION['login_s'] != '5'){
        header('location:../../login.php');
    }
    require '../../dbconfig/config.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Home Page</title>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
 	<link rel="stylesheet" href="../../css/nav_footer_styles.css">
   <link rel="stylesheet" href="../../css/reg_form_style.css">
   <link rel="stylesheet" href="../../css/new_table_and_button.css">
   <link rel="stylesheet" href="../../css/table_style.css">



</head>

<body >
	



  <nav>
  <div class="logo">Web-COMS</div>
  <input type="checkbox" id="click">
  <label for="click" class="menu-btn">
              <i class="fas fa-bars"></i>
            </label>
    <ul>
     


			<li><a class="active" href="trackchairhomepage.php">Home</a></li>
			<!--<li><a href="firstround.php">First-round paper evaluation</a></li>
      <li><a href="assignreviewrs.php">Assign Reviewers </a></li>
      <li><a href="trackchair_change_password.php">Change Password</a></li>-->
	    	  <li><a href="updateprofile.php">Update Profie</a></li>
			<li style="float:right; margin-right:40px"><a href="../logout.php">Log Out</a></li>
		


    </ul>
  </nav>

  <br><br>

	<div id="main-wrapper">
		<center>

    <h2 style="color:#111 ;margin-left:20px;">You Assign Conference List</h2>

<table class="content-table">
    <thead>
      <tr>
         <th>Number</th>
         <th>Conference</th>
         <th>Venue</th>
         <th>Country</th>
         <th>Start date</th>
         <th>End date</th>
         <th>Deadline</th>
         <th>Select</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $tEmail = $_SESSION['t_email'];
        $query_result = mysqli_query($con,"select distinct c.id as Id, c.name as Name, c.venue as Venue, c.country as Country,
        c.start_date as st_d, c.end_date as end_d, c.deadline_date as de_d  
        from conferences as c, conferencetrack as ct, conferencetrack_and_trackchair as ctt
        where (ctt.trackChairEmail = '$tEmail') and (ctt.conferenceTrackId = ct.ID) and (ct.conferenceID = c.id)");
        $count = 1;
        while($row = mysqli_fetch_assoc($query_result)){
      ?>
        <tr>
          <td><?= $count ?></td>
          <td><?= $row['Name'] ?></td>
          <td><?= $row['Venue'] ?></td>
          <td><?= $row['Country'] ?></td>
          <td><?= $row['st_d'] ?></td>
          <td><?= $row['end_d'] ?></td>
          <td><?= $row['de_d'] ?></td>
          <td><a href="route.php?c_selected=<?= $row['Id'] ?>" class="conListLink">Select</a></td>
        </tr>
        <?php
          $count++;}
        ?>
    </tbody>
</table>
</center>
	</div>
   <!-- Footer section -->
	<div class="footer">
            <p>&copy;2020, All rights reserved by www.WebComs.lk</p>
        </div>
</body>
</html>
