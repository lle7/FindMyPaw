<?php
// Initialize the session
require_once 'config.php';
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
$post_count = $link->query("SELECT * FROM POST WHERE post_type = 'FOUND'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
  ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: transparent;
}

li {
  float: left;
}

li a, .dropbtn {
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
  background-color: #93d6ae;
}
li .dropdown{
display: inline-block;
}
.dropdown-content{
display: none;
position: absolute;
background-color: #93d6ae;
min-width: 160px;
z-index: 1;
}
.dropdown-content a{
color: white;
padding: 12px 16px;
text-decoration: none;
display: block;
text-align: left;
}
.dropdown-content a:hover {
background-color: #f1f1f1
}
.dropdown:hover .dropdown-content{
display: block;
}
.picture {
  margin: 10px 0 20px 360px;
}
</style>
<meta charset="UTF-8">
<title>Post Form</title>
<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body style="background: linear-gradient(#D4EFDF, white)">
<!-- USING FONT FROM GOOGLE  -->
<link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
<!-- NAVIGATION BAR UP TOP  -->
<ul>
  <li><a class ="active" href="FindMyPaws.php" style="font-family: 'Poiret One', cursive;"> Home </a></li>
  <li> <a href="contactus.php" style="font-family: 'Poiret One', cursive;">Contact Us </a> </li>
  <li class="dropdown">
    <a href="Browsing_page.php" class="dropbtn" style="font-family: 'Poiret One', cursive;">Browse </a>
    <div class="dropdown-content">
      <a href="lost.php" style="font-family: 'Poiret One', cursive;"> Lost pet </a>
      <a href="found.php" style="font-family: 'Poiret One', cursive;"> Found pet</a>
    </div>
   </li>
  <li> <a href="#shelter" style="font-family: 'Poiret One', cursive;">Shelter near me </a> </li>
</ul>

<!-- NAVIGATION BAR TO SEARCH FOR RANDOM STUFF -->
<div id="searchBar">
          <!--general search box-->
  <input type="text" style="width:40%; font-family: 'Poiret One', cursive; " placeholder="Looking for?">
  <input type="button" value="Search" style="font-family: 'Poiret One', cursive;">
  </div>
</div>


  <!-- welcome statement for the user -->
<h1 style="font-family: 'Poiret One', cursive; "><b><?php echo $_SESSION['username']; ?></b>, Looking for any of these pets?!</h1>

          <!--picture of the location tag-->
<img src="locationClipArt.png" style="width:15%; padding: 0px 0px 0px 670px;position:relative; top:-75px;">
<h1 id="greeting"> Find My P<img src="whitepaw.png" style="width:2%;">ws</h1>
<!-- <img src="paws.png" style="width:500px; padding: 0px 0px 0px 400px;position:relative; top:-200px;"> -->
<button onclick="location = 'post.php';" style="position: relative; top:-100px;background-color:#A9DFBF;" name="postbtn">Create New Post</button>
<?php
if(isset($_POST['postbtn'])){
  header("Location: post.php");//WHEN BUTTON IS CLICK REDIRECT TO FindMyPaws.PHP
  exit;
}?>
  <!-- button to logout of the system -->
<button style="background-color:#C8C9C8; position: relative; top:-100px;" onclick="location = 'FindMyPaws.php'" name="logout">Sign Out</button>
<?php
if(isset($_POST['logout'])){
  header("Location: FindMyPaws.php"); //WHEN BUTTON IS CLICK REDIRECT TO FindMyPaws.PHP
  exit;
}?>
<div class="bg3" >
  <div class="caption1">
    <span class="border1" > Found Pet</span>
  </div>
</div>

<div style="font-family:'Poiret One', cursive; color: #F08080; background-color: white; text-align: center; padding: 5px 8px; text-align:justify;">

  <div style="text-align:center; font-size:20px">

   <?php
   require_once 'config.php';
   $sql = "SELECT * FROM POST WHERE post_type = 'FOUND'";


   $result = mysqli_query($link, $sql);
   $post_count = $link->query("SELECT * FROM POST WHERE post_type = 'FOUND'");

   while($row = mysqli_fetch_assoc($result)){
     ?>
     <!-- display the images from database -->
     <p> Post ID: <?php $postid = $row['post_ID']; echo $postid; /*echo ", Username: ".$row['username'];*/?></p>

     <?php
       require_once 'config.php';
       $query = mysqli_query($link, "SELECT USER.username, POST.post_ID FROM USER INNER JOIN POST ON POST.user_ID = USER.user_ID");
       while($row3 = mysqli_fetch_assoc($query)){
         if($row['post_ID'] == $row3['post_ID']){
           echo  "<b>".$row3['username']."</b>";
         }
       }
     ?>


     <div style="cursor: pointer;">
       <!-- DISPLAY THE POST PHOTO  -->
         <img src="<?php echo $row['pic'];?>" height = '200px'; width = '200px' onclick="document.getElementById('id02').style.display = 'block';">
     </div>
     <div id="id02" class="modal">
       <span onclick="document.getElementById('id02').style.display ='none'" class="close" title="Close Modal"></span>
       <form class="modal-content animate" action="comment.php" method="post">
         <div class="container">
           <label> <b> Comment </b> </label>
           <input type="text" style="font-family:'Poiret One', cursive; font-size:20px;" placeholder="Say something" name="comment" required >
           <button type="submit">Comment</button>

           <div style="background-color: #f1f1f1">
             <!-- <button style="background-color:#C8C9C8;"type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button> -->
             <button style="background-color:#C8C9C8;"type="button" onclick="location = 'found.php'" name="cancel">Cancel</button>
             <?php
             if(isset($_POST['cancel'])){
               header("Location: found.php");
               exit;
             }
             ?>
           </div>
         </div>
     </div>
         <p style='color: red;'><b> <?php echo $row['post_type']; ?></b></p>
         <p><b> Petname: <?php echo $row['petname']; ?> </b></p>
         <p><b> Description: <?php echo $row['description']; ?> </b></p>
         <p><b> DOP: <?php echo $row['date']; ?> </b></p>
         <p> View Comments</p>


     <!-- CLICK TO COMMENT THE POST  -->
         <div id="id03" class="modal">
               <span onclick="document.getElementById('id03').style.display = 'none'" class="close" title="Close Modal"></span>
               <form class="modal-content animate" action="/action_page.php">
                 <div class="container">
                   <label> <b> View comment </b> </label>
                   <button style="background-color:#C8C9C8;"type="button" onclick="location = 'found.php'" name="close">Close</button>
                   <?php
                   if(isset($_POST['close'])){
                     header("Location: found.php");
                     exit;
                   }
                   ?>
                 </div>
               </form>
         </div>


     <?php
       require_once 'config.php';
       $query = mysqli_query($link, "SELECT USER.username, COMMENT.comment, POST.post_ID FROM USER INNER JOIN COMMENT ON USER.user_ID = COMMENT.user_ID INNER JOIN POST ON POST.post_ID = COMMENT.post_ID");
       while($row1 = mysqli_fetch_assoc($query)){
         if($row['post_ID'] == $row1['post_ID']){
           echo  $row1['username']."<b>: </b>". $row1['comment']. "<br>";
         }
       }
     ?>
     <br>


     <!-- TYPE TO COMMENT ON THE POST, SO WE HAVE TWO WAYS OF COMMENTING  -->
    <form method="post" action="commentfound.php">
       <label> <b> Comment </b> </label>
       <input type="text" style="font-family:'Poiret One', cursive; font-size:20px;" placeholder="Say something..." name="comment" >
       <input type="hidden" value="<?php echo $row['post_ID'];?>" name="postid">
       <button type="submit" name="submit">Comment</button>
   </form>
     <br>
     <br>
   <?php } ?>
 </div>
 <div>
   <td> <b>Total found pet post: </b></td>
   <td> <?php echo $post_count->num_rows; ?>
 </div>
</div>


</body>
</html>
