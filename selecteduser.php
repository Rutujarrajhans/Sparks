
  
<?php
$server="remotemysql.com";
$username ="KtFn8Akxrf";
$password ="PfsUZWV9fc";
$dbname = "KtFn8Akxrf";
$conn=mysqli_connect($server,$username,$password,$dbname);

if($conn->connect_error){

	die("connection failed".$conn->connect_error);
}

if(isset($_POST['submit']))
{
    $from = $_GET['id'];
    $to = $_POST['to'];
    $amount = $_POST['amount'];

    $sql = "SELECT * from users where id=$from";
    $query = mysqli_query($conn,$sql);
    $sql1 = mysqli_fetch_array($query); // returns array or output of user from which the amount is to be transferred.

    $sql = "SELECT * from users where id=$to";
    $query = mysqli_query($conn,$sql);
    $sql2 = mysqli_fetch_array($query);



    // constraint to check input of negative value by user
    if (($amount)<0)
   {
        echo '<script type="text/javascript">';
        echo ' alert("Oops! Negative values cannot be transferred")';  // showing an alert box.
        echo '</script>';
    }


  
    // constraint to check insufficient balance.
    else if($amount > $sql1['Current_balance']) 
    {
        
        echo '<script type="text/javascript">';
        echo ' alert(" Insufficient Balance")';  // showing an alert box.
        echo '</script>';
    }
    


    // constraint to check zero values
    else if($amount == 0){

         echo "<script type='text/javascript'>";
         echo "alert('Oops! Zero value cannot be transferred')";
         echo "</script>";
     }


    else {
        
                // deducting amount from sender's account
                $newbalance = $sql1['Current_balance'] - $amount;
                $sql = "UPDATE users set Current_balance=$newbalance where id=$from";
                mysqli_query($conn,$sql);
             

                // adding amount to reciever's account
                $newbalance = $sql2['Current_balance'] + $amount;
                $sql = "UPDATE users set Current_balance=$newbalance where id=$to";
                mysqli_query($conn,$sql);
               
                
                $sender = $sql1['Name'];
                $receiver = $sql2['Name'];
                $sql = "INSERT INTO transactions(sender, receiver, balance) VALUES ('$sender','$receiver','$amount')";
               
                mysqli_query($conn,$sql);

                $query=mysqli_query($conn,$sql);

                if($query){
                
                     echo "<script> alert('Transaction Successful');
                                     window.location='transactionhistory.php';
                           </script>";
                    
                }

                $newbalance= 0;
                $amount =0;
        }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/table.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">

    <style type="text/css">
    	
		button{
			border:none;
			background: #d9d9d9;
		}
	    button:hover{
			background-color:#777E8B;
			transform: scale(1.1);
			color:white;
		}
body{
    background-image:url('');
    background-repeat:no-repeat;
    background-size:cover;
}
    </style>
</head>

<body>
 

 <nav class="navbar navbar-expand-md navbar-light bg-light">
 <a class="navbar-brand" href="index11.php">MCB BANK</a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
   <span class="navbar-toggler-icon"></span>
 </button>
 <div class="collapse navbar-collapse" id="collapsibleNavbar">
       <ul class="navbar-nav ml-auto">
         <li class="nav-item">
           <a class="nav-link" href="home.html">Home</a>
         </li>
       
         <li class="nav-item">
           <a class="nav-link" href="transfermoney.php">Transfer Money</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="transactionhistory.php">Transaction History</a>
         </li>
     </div>
  </nav>


	<div class="container">
        <h2 class="text-center pt-4">Transaction</h2>
            <?php
            $server="remotemysql.com";
		$username ="KtFn8Akxrf";
		$password ="PfsUZWV9fc";
		$dbname = "KtFn8Akxrf";
              
              $conn=mysqli_connect($server,$username,$password,$dbname);
              
              if($conn->connect_error){
              
                  die("connection failed".$conn->connect_error);
              }
              
                $sid=$_GET['id'];
                $sql = "SELECT * FROM  users where id=$sid";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo "Error : ".$sql."<br>".mysqli_error($conn);
                }
                $rows=mysqli_fetch_assoc($result);
            ?>
            <form method="post" name="tcredit" class="tabletext" ><br>
        <div>
            <table class="table table-striped table-condensed table-bordered">
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Balance</th>
                    <th class="text-center">Contact_no</th>
                    <th class="text-center">Age</th>
                </tr>
                <tr>
                    <td class="py-2"><?php echo $rows['id'] ?></td>
                    <td class="py-2"><?php echo $rows['Name'] ?></td>
                    <td class="py-2"><?php echo $rows['Email'] ?></td>
                    <td class="py-2"><?php echo $rows['Current_balance'] ?></td>
                    <td class="py-2"><?php echo $rows['Contact_no'] ?></td>
                    <td class="py-2"><?php echo $rows['age'] ?></td>
                </tr>
            </table>
        </div>
        <br><br><br>
        <label style="font-size:35px;">Transfer To:</label>
        <select name="to" class="form-control" required>
            <option value="" disabled selected>Choose</option>
            <?php
              $server="remotemysql.com";
$username ="KtFn8Akxrf";
$password ="PfsUZWV9fc";
$dbname = "KtFn8Akxrf";
               
               $conn=mysqli_connect($server,$username,$password,$dbname);
               
               if($conn->connect_error){
               
                   die("connection failed".$conn->connect_error);
               }
               
                $sid=$_GET['id'];
                $sql = "SELECT * FROM users where id!=$sid";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo "Error ".$sql."<br>".mysqli_error($conn);
                }
                while($rows = mysqli_fetch_assoc($result)) {
            ?>
                <option class="table" value="<?php echo $rows['id'];?>" >
                
                    <?php echo $rows['Name'] ;?> (Balance: 
                    <?php echo $rows['Current_balance'] ;?> ) 
               
                </option>
            <?php 
                } 
            ?>
            <div>
        </select>
        <br>
        <br>
            <label style="font-size:35px;">Amount:</label>
            <input type="number" class="form-control" name="amount" required>   
            <br><br>
                <div class="text-center" >
            <button class="btn mt-3" name="submit" type="submit" id="myBtn">Transfer</button>
            </div>
        </form>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
