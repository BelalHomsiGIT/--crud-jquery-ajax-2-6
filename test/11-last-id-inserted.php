<?php
    include '../assest/dbconn.php';

    //Get Last inserted Id:
    //---------------------

        //1- using MAX(id):
        $maxIdQry = mysqli_query($conn, "SELECT MAX(id) from students LIMIT 1;");
        $num = mysqli_num_rows($maxIdQry);
        $lastID1 = mysqli_fetch_array($maxIdQry);
        $res1 = $lastID1['MAX(id)'];
        echo "<p> MAX(id): " . $res1 . "</p>";
        
        //2- using mysqli_insert_id() method, after insert statement directly:
        $insertID = "INSERT INTO students(name, email, phone, course) VALUES('test1', 'test1', 'test1', 'test1')";
        if(mysqli_query($conn, $insertID)){
            $lastID2 = mysqli_insert_id($conn);
            echo "<p> mysqli_insert_id: " . $lastID2 . "</p>";
        }

        // 3-using LAST_INSERT_ID() - after last insert statement:
            $last = mysqli_query($conn, "SELECT LAST_INSERT_ID()");
            echo "<p> LAST_INSERT_ID(): " . $lastID2 . "</p>";
            
        // 4- ORDER BY DESC:
            $orderDesc = mysqli_query($conn, "SELECT id from students ORDER BY id DESC");
            $lastID = mysqli_fetch_array($orderDesc);
            echo "<p> ordered ID desc: " . $lastID['id'] . "</p>";
            
    ?>

</body>
</html>