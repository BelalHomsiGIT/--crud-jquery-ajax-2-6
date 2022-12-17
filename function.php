<?php
    require "assest/dbconn.php";

    // Save new Student -calling from submit in #saveStudentForm form
    // we recieve the data from ajax data -formData- by $_POST array
    if(isset($_POST['save_student'])){
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $course = mysqli_real_escape_string($conn, $_POST['course']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
        if($name == null || $email == null || $course == null || $phone == null){
            $res = ['status' => 422, 'message' => 'All fields are required'];
            echo json_encode($res);
            return false;
        }

        $stmt = "INSERT INTO students(name, email, phone, course) VALUES('$name', '$email', '$phone', '$course')";
        $query = mysqli_query($conn, $stmt);

        if($query){
            // after insert new row (student), we get it's data to add it to student table without refresh the page or the table area.
            $insertedNewID = mysqli_insert_id($conn); // get the new id inserted by last insert statement -above
            $stmt = "SELECT * FROM students WHERE id='$insertedNewID'";
            $query = mysqli_query($conn, $stmt);
            $insertedStudentData = mysqli_fetch_array($query);
            //now we send all new row data with another data to calling place, which recieved them as response of request.
            $res = ['status' => 200, 'insertedData' => $insertedStudentData, 'message' => 'Student added successfully.'];
            //conver data to json object and send it.
            echo json_encode($res);
            return false;
        }else{
            $res = ['status' => 500, 'message' => 'Error - Student not added'];
            echo json_encode($res);
            return false;
        }

    //view student | update student - collect the student data and send it to view modal or to edit modal
    }elseif(isset($_GET['studentIDViewEdit'])){
        $studentID = mysqli_escape_string($conn, $_GET['studentIDViewEdit']);
        $rowIndex = ''; // using for update the row without reloading - for index of the specified row.
        if(isset($_GET['rowIndex'])){
            $rowIndex = mysqli_escape_string($conn, $_GET['rowIndex']);
        }

        $stmt = "SELECT * FROM students WHERE id='$studentID'";
        $query = mysqli_query($conn, $stmt);

        if(mysqli_num_rows($query) == 1){
            $studentData = mysqli_fetch_array($query);
            $res = ['status' => 200, 'message' => 'Student fetched successfully.', 'rowidx' => $rowIndex, 'studentData' => $studentData];
            echo json_encode($res);
            return false;
        }else{
            $res = ['status' => 404, 'message' => 'Error - Student ID Not Found!'];
            echo json_encode($res);
            return false;
        }

    // recieve request from clicking on 'Update Student', to execute the update, and return the new data to view it in #studentsTable.
    }elseif(isset($_POST['update_student'])){
        $rowidx = $_POST['row_index'];
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $course = mysqli_real_escape_string($conn, $_POST['course']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
        if($name == null || $email == null || $course == null || $phone == null){
            $res = ['status' => 422, 'message' => 'All fields are required'];
            echo json_encode($res);
            return false;
        }

        $stmt = "UPDATE students SET name='$name', email='$email', phone='$phone', course='$course' WHERE id='$student_id'";
        $query = mysqli_query($conn, $stmt);

        if($query){
            $stmt = "SELECT * FROM students WHERE id='$student_id'";
            $query = mysqli_query($conn, $stmt);
            $updatedStudentData = mysqli_fetch_array($query);
            $res = ['status' => 200, 'rowidx' => $rowidx, 'updatedData' => $updatedStudentData, 'message' => 'Student updated successfully.'];
            echo json_encode($res);
            return false;
        }else{
            $res = ['status' => 500, 'message' => 'Error - Student not updated'];
            echo json_encode($res);
            return false;
        }

    // delete the row
    }elseif(isset($_POST['delete_student'])){
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $stmt = "DELETE FROM students WHERE id='$student_id'";
        $query = mysqli_query($conn, $stmt);
        if($query){
            $res = ['status' => 200, 'message' => 'Student deleted successfully.'];
            echo json_encode($res);
            return false;
        }else{
            $res = ['status' => 500, 'message' => 'Error - Student not deleted'];
            echo json_encode($res);
            return false;
        }
    }
?>