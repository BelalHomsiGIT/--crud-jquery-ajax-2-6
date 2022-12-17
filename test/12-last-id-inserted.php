<?php
    include '../assest/dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Last Inserted ID</title>
</head>
<body>
    <p id="lastID">Test</p>
    <button onclick="getLastId()">Click</button>

    <?php
        function lastID_PHP(){
            global $conn;
            $lastIdQry = mysqli_query($conn, "SELECT MAX(id) from students LIMIT 1;");
            if(mysqli_num_rows($lastIdQry) == 1){
                $lastID = mysqli_fetch_array($lastIdQry);
                $res = $lastID['MAX(id)'];
                return $res;
            }
            return false;
        }
    ?>

    <script>
        function getLastId(){
            let result = "<?php echo lastID_PHP() ?>"
            document.getElementById("lastID").innerHTML = result;
        }
    </script>
    <h2>Note: in the script we 'called' PHP function and 'recieved' value from PHP function</h2>

</body>
</html>