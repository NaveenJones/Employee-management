
<?php

$host = "localhost";
$user = "root";
$password ="";
$database = "test_db";

$id = "";
$fname = "";
$lname = "";
$mobile = "";
$email = "";
$gender =  "";
$skills = "";
$address = "";
$status = "";
$dob = "";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>

<center>
<h2>Employee management</h2>
 <?php
// connect to mysql database
try{
    $connect = mysqli_connect($host, $user, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo 'Error';
}

// get values from the form
function getPosts()
{
    $posts = array();
    $posts[0] = $_POST['id'];
    $posts[1] = $_POST['fname'];
    $posts[2] = $_POST['lname'];
    $posts[3] = $_POST['mobile'];
    $posts[4] = $_POST['email'];
    $posts[5] = $_POST['gender'];
    $posts[6] = $_POST['skills'];
    $posts[7] = $_POST['address'];
    $posts[8] = $_POST['status'];
    $posts[9] = $_POST['dob'];


    return $posts;
}

// Search

if(isset($_POST['search']))
{
    $data = getPosts();
    
    $search_Query = "SELECT * FROM users WHERE id = $data[0]";
    
    $search_Result = mysqli_query($connect, $search_Query);
    
    if($search_Result)
    {
        if(mysqli_num_rows($search_Result))
        {
            while($row = mysqli_fetch_array($search_Result))
            {
                $id = $row['id'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $mobile = $row['mobile'];
                $email = $row['email'];
                $gender = $row['gender'];
                $skills = $row['skills'];
                $address = $row['address'];
                $status = $row['status'];
                $dob =  $row['dob'];
            }
        }else{
            echo 'No Data is present For This Id';
        }
    }else{
        echo 'Result Error';
    }
}

 $msg = "";
// Insert
if(isset($_POST['insert']))
{




    $filename = $_FILES["profilepic"]["name"];
    $tempname = $_FILES["profilepic"]["tmp_name"];   
        $folder = "profile_image/".$filename;
         
   
 
      //   // Get all the submitted data from the form
      //   $sql = "INSERT INTO `users` (`profilepic`) VALUES ('$filename')";
 
      //   // Execute query
      //   mysqli_query($connect, $sql);
         
      //   // Now let's move the uploaded image into the folder: image
     








    $data = getPosts();
    $insert_Query = "INSERT INTO `users`(`fname`, `lname`, `mobile`,`email`,`gender`,`skills`,`address`,`status`,`dob`,`profilepic`) VALUES ('$data[1]','$data[2]',$data[3],'$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$filename')";

       if (move_uploaded_file($tempname, $folder))  {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
      }

    try{
        $insert_Result = mysqli_query($connect, $insert_Query);
        
        if($insert_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                echo 'Data Inserted Successfully';
            }else{
                echo 'Data Not Inserted ';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Insert '.$ex->getMessage();
    }
}

// Delete
if(isset($_POST['delete']))
{
    $data = getPosts();
    $delete_Query = "DELETE FROM `users` WHERE `id` = $data[0]";
    try{
        $delete_Result = mysqli_query($connect, $delete_Query);
        
        if($delete_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                echo 'Data Deleted Successfully';
            }else{
                echo 'Data Not Deleted';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Delete '.$ex->getMessage();
    }
}

// Edit
if(isset($_POST['update']))
{


    $data = getPosts();
    $update_Query = "UPDATE `users` SET `fname`='$data[1]',`lname`='$data[2]',`mobile`=$data[3] ,`email`='$data[4]',`gender`='$data[5]',`skills`='$data[6]',`address`='$data[7]',`status`='$data[8]',`dob`='$data[9]' WHERE `id` = $data[0]";

    try{
        $update_Result = mysqli_query($connect, $update_Query);
        
        if($update_Result)
        {
            if(mysqli_affected_rows($connect) > 0)
            {
                echo 'Data Updated Successfully';
            }else{
                echo 'Data Not Updated';
            }
        }
    } catch (Exception $ex) {
        echo 'Error Update '.$ex->getMessage();
    }
}



?>
</center>

<!DOCTYPE Html>
<html>
    <head>
        <title>Employee management</title>
    </head>
    <body>
        <form action="index.php" method="post" enctype="multipart/form-data" align="center"><br><br>
            <label> Search using ID : </label>
            <input type="number" style="width: 20%;" name="id" placeholder="Enter an ID to update or delete" value="<?php echo @$id;?>"><br><br>
            <label> First name : </label>
            <input type="text" name="fname" placeholder="Enter your first name" value="<?php echo @$fname;?>"><br><br>
            <label> Second name : </label>
            <input type="text" name="lname" placeholder="Enter your last name" value="<?php echo @$lname;?>"><br><br>
            <label> Mobile no. : </label>
             <input type="number" name="mobile" placeholder="Enter your mobile no." value="<?php echo @$mobile;?>"><br><br>
             <label> Email address : </label>
             <input type="text" name="email" placeholder="Enter your Email"  value="<?php echo @$email;?>" ><br><br>
             <label> Gender : </label>
              <input type="text" name="gender" placeholder="gender"  value="<?php echo @$gender;?>" ><br><br>
              <label> Skills : </label>
               <input type="text" name="skills" placeholder="Enter your skills" value="<?php echo @$skills;?>"><br><br>
               <label> Address : </label>
              <input type="text" name="address" placeholder="Enter your address" value="<?php echo @$address;?>"><br><br>
              <label> Status : </label>
              <input type="text" name="status" placeholder="Enter the status" value="<?php echo @$status;?>"><br><br>
              <label> Date of Birth : </label>
              <input type="date"  name="dob" placeholder="Date of birth" value="<?php echo @$dob;?>" ><br><br>
              <label> Profile picture : </label>
               <input type="file" name="profilepic" placeholder="Profile pic"  value="<?php echo @$profilepic;?>"><br><br><br><br>
            <div>
                <!-- Input For Add Values To Database-->
                <input type="submit" name="insert" value="Insert">
                
                <!-- Input For Edit Values -->
                <input type="submit" name="update" value="Update">
                
                <!-- Input For Clear Values -->
                <input type="submit" name="delete" value="Delete">
                
                <!-- Input For Find Values With The given ID -->
                <input type="submit" name="search" value="Search">
            </div>
        </form>
    </body>

</html>