<?php 
$names=$_POST['names'];
$emails=$_POST['emails'];
$mobileno=$_POST['mobileno'];

if (!empty($names) || !empty($emails) || !empty($mobileno))
{
    $host="localhost";
    $dbusername="root";
    $dbpassword="";
    $dbname="portfolio-balakrishnan";

    $conn=new mysqli($host,$dbusername,$dbpassword,$dbname);
    
    if (mysqli_connect_error())
    {
        die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    }
    
    else
    {
        $SELECT="SELECT emails From cont 
        Where emails=? Limit 1";
        $INSERT="INSERT Into cont(names,emails,mobileno) values(?,?,?)";
    
        $stmt=$conn->prepare($SELECT);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum=$stmt->num_rows;

        if($rnum==0){
            $stmt->close();
            $stmt=$conn->prepare($INSERT);
            $stmt->bind_param("ssi",$names,$emails,$mobileno);
            $stmt->execute();
            echo"New record inserteed sucessfully";

        }
        else{
            echo "Someone already register using this email";
        }
        $stmt->close();
        $conn->close();
    }
}
else{
    echo "All field are required";
    die();
}

?>