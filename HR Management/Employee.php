<?php
ob_start();
session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
// select logged in users detail
$user_id = mysqli_insert_id($conn);
$_SESSION['user']=$user_id;     
$res = $conn->query("SELECT * FROM users WHERE id=" . $_SESSION['user']);
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);

?>
<?php
if (isset($_POST['submit'])) {

    $engagementDAte = trim($_POST['date']); // get posted data and remove whitespace
    $activity = trim($_POST['activity']);
    $time=trim($_POST['time']);
    $description = trim($_POST['description']);
    $type=trim($_POST['Type']);

    $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $count = $result->num_rows;

    if ($count == 0) { 

        $stmts = $conn->prepare("INSERT INTO eDetails(EngagementDate, timea,Activity, Description,Type) VALUES(?, ?, ?, ?,?)");
        $stmts->bind_param("sssss", $engagementDAte, $time, $activity, $description, $type);
        $res = $stmts->execute();//get result
        $stmts->close();}
    }

?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hello,<?php echo $userRow['email']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="assets/css/index.css" type="text/css"/>
</head>
<body>

<!-- Navigation Bar-->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">HR Management</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="Employee.php">Home</a></li>
                <li><a href="accountdetails.php">Account Details</a></li>
                <li><a href="#">About</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span
                            class="glyphicon glyphicon-user"></span>&nbsp;Logged
                        in: <?php echo $userRow['email']; ?>
                        &nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>




<div class="container">
    <!-- Jumbotron-->
    <div class="jumbotron">
        <h1>Hello, User</h1>

         <div class="container">
         </Br>
          </Br>
           </Br>

  <form method="post" action="Employee.php">
    
    <label> Activity</label>
    <input type="text" id="lname" name="activity" placeholder="">
     </Br>
     </Br>
    <label for="start"> Engagement Date </label>
    <input type="date" id="date" name="date"
               value="2018-07-22"
               min="2018-01-01" max="2018-12-31" />
     </Br>
     </Br>
    <label>Enter time:</label>
  <input type="time" name="time">
  </Br>
     </Br>

    <table>
        <th>Description </th>
        <td>
        </td>
    </table>
    
     <textarea rows="4" cols="50" name="description" id="description">
</textarea> 
</Br>
     </Br>

    <div class="input-group">
        <label>Engagement Type</label>
                        <select name="Type" >
                            <option>Core</option>
                            <option>Non-Core</option>
                        </select>
                    </div>
    
</Br>
     </Br>
</div> 
        <button type="submit" class="btn btn-primary btn-lg" name="submit">Enter Project Details</button>
    </div>
        

  </form>


    <div class="row">
        <div class="col-lg-12">
            
        </div>


    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>