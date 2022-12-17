<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <title>Students-CRUD-AJAX</title>
    <style>
        .btn-action{
            width: 55px;
            height: 30px;
            font-size: 12px;
            font-weight: bold;
            padding: 5px;
            color: whitesmoke;
        }
    </style>
  </head>

  <body>
  <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-header">
                        <h4>PHP AJAX CRUD with jQUERY & BOOTSTRAP</h4>
                        <!-- this button shows us the #studentAddModal which has form to fill new data -->
                        <button type="button" id="addNewUserBtn" class="btn btn-primary float-end">Add Student</button>
                    </div>
                    <div class="card-body">
                        <table id="studentsTable" class="table table-bordered table-striped">
                            <thead class="text-center table-dark text-white-50">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require "assest/dbconn.php";
                                    $stmtAll = "SELECT * FROM students";
                                    $queryAll = mysqli_query($conn, $stmtAll);
                                    if(mysqli_num_rows($queryAll) > 0){
                                        foreach($queryAll as $student){
                                            ?>
                                            <tr id="<?= $student['id'] ?>">
                                                <td><?= $student['id'] ?></td>
                                                <td><?= $student['name'] ?></td>
                                                <td><?= $student['email'] ?></td>
                                                <td><?= $student['phone'] ?></td>
                                                <td><?= $student['course'] ?></td>
                                                <td class="text-center"  style="width:250px;">
                                                    <button type="button" value="<?= $student['id'] ?>" class="btn btn-info btn-action" id="viewStudentBtn">View</button>
                                                    <button type="button" value="<?= $student['id'] ?>" class="btn btn-success btn-action" id="editStudentBtn">Edit</button>
                                                    <button type="button" value="<?= $student['id'] ?>" class="btn btn-danger btn-action" id="delteStudentBtn">Del</button>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Student Modal - Start -->
    <div class="modal fade" id="studentAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="saveStudentForm">
                    <div class="modal-body">

                        <div id="errorAddMessage" class="alert alert-warning d-none"></div>

                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Course</label>
                            <input type="text" name="course" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- the next button has type="submit", so we can get all fields by FormData -
                             to execute the script to save data -->
                        <button type="submit" class="btn btn-primary">Save Student</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Add Student Modal - End -->

    <!-- Edit Student Modal - Start -->
    <div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="updateStudentForm">
                    <div class="modal-body">

                        <div id="errorUpdateMessage" class="alert alert-warning d-none"></div>
                        <!-- These hidden inputs store id and index of the row -->
                        <input type="hidden" name="student_id" id="student_id">
                        <input type="hidden" name="row_index" id="row_index">

                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" id="name"  class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="text" name="email" id="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Course</label>
                            <input type="text" name="course" id="course" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- the next button has type="submit" to execute the script to save data -->
                        <button type="submit" class="btn btn-primary">Update Student</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Edit Student Modal -End -->


    <!-- View Student Modal - Start -->
    <div class="modal fade" id="studentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">

                        <div id="errorViewMessage" class="alert alert-warning d-none"></div>

                        <input type="hidden" name="student_id" id="student_id">

                        <div class="mb-3">
                            <label for="">Name</label>
                            <p id="view_name" class="form-control"> </p>
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <p id="view_email" class="form-control"> </p>
                        </div>
                        <div class="mb-3">
                            <label for="">Course</label>
                            <p id="view_course" class="form-control"> </p>
                        </div>
                        <div class="mb-3">
                            <label for="">Phone</label>
                            <p id="view_phone" class="form-control"> </p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- View Student Modal -End -->

   

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script src="assest/jquery-3.6.1.min.js"></script>

    <script>
        //Show Add-Student Modal
        $(document).on('click', '#addNewUserBtn', function(){
            $('#studentAddModal').modal('show');
        });

        //Save New Student
        //when submit is triggered, the selector which execute on it, is #saveStudentForm (the Form in the Model):
        $(document).on("submit", "#saveStudentForm", function(myEvent){
            myEvent.preventDefault();
            let formData = new FormData(this); // this refers to #saveStudentForm element (our form)
            formData.append("save_student", true); // Adding additional data to fromData by .aapend method - to know the action is save data in students table.
            $.ajax({
                type : "post",
                url : "function.php",
                data : formData,
                processData: false,
                contentType: false,
                success: function(resp){ // recieve the data as response, it's a json object.
                    // the response is: ['status', 'insertedData', 'message']
                    // insertedData is array has ( id, name, email, phone, course) as part in the response.
                    let myResponse = $.parseJSON(resp);
                    if(myResponse.status == 422){
                        $("#errorAddMessage").text(myResponse.message);
                        $("#errorAddMessage").removeClass("d-none");
                    }else if(myResponse.status == 200){
                        $("#errorAddMessage").addClass("d-none");
                        $("#studentAddModal").modal('hide'); // $(selector-mdal).modal('hide' | 'show' | 'trigger')
                        $("#saveStudentForm")[0].reset()
                        /* when new student added, the table must reloading (refresh it's data):
                            location.href return entire URL of the current page. */
                        /* $("#studentsTable").load(location.href + " #studentsTable"); */
                        // I replaced the previous line with the next:
                        const btnView = `<button type="button" value="${myResponse.insertedData['id']}" class="btn btn-info btn-action" id="viewStudentBtn">View</button> `
                        const btnEdit = `<button type="button" value="${myResponse.insertedData['id']}" class="btn btn-success btn-action" id="editStudentBtn">Edit</button> `
                        const btnDel = `<button type="button" value="${myResponse.insertedData['id']}" class="btn btn-danger btn-action" id="delteStudentBtn">Del</button> `
                        let dataInRow = "<td>"+myResponse.insertedData['id'];
                            dataInRow += "<td>"+myResponse.insertedData['name'];
                            dataInRow += "<td>"+myResponse.insertedData['email'];
                            dataInRow += "<td>"+myResponse.insertedData['phone'];
                            dataInRow += "<td>"+myResponse.insertedData['course'];
                            dataInRow += "<td style='width:250px;'>"+ btnView + btnEdit + btnDel ;
                        // let newRow = "<tr id=" + myResponse.insertedData['id'] + ">" + dataInRow + "</tr>"
                        let newRow = `<tr id="${myResponse.insertedData['id']}"> ${dataInRow}</tr> `
                        $("#studentsTable").append(newRow);
                    }
                }
            })
        });

        // View Student data in modal has a paragraphs - not to change any thing.
        $(document).on('click', '#viewStudentBtn', function(){
            let studentID = $(this).val();
            $.ajax({
                type: 'get',
                url: 'function.php?studentIDViewEdit=' + studentID,
                success: function(resp){
                    let myResponse = $.parseJSON(resp);
                    if(myResponse.status == 404){
                        alert(myResponse.message);
                    }else if(myResponse.status == 200){
                        // $("#student_id").val(myResponse.studentData.id)
                        $("#view_name").text(myResponse.studentData.name)
                        $("#view_email").text(myResponse.studentData.email)
                        $("#view_phone").text(myResponse.studentData.phone)
                        $("#view_course").text(myResponse.studentData.course)
                        
                        $("#studentViewModal").modal('show'); // $(selector-mdal).modal('hide' | 'show' | 'trigger')
                    }
                }
            })
        });

        // view student data for changing, then the studentEditModal modal is shown with this data.
        $(document).on('click', '#editStudentBtn', function(){
            // defint the index of currnet row in table to change the text after update database.
            let studentRowIndex = $(this).parent().parent().index(); // btn -> td -> tr .index()
            ++studentRowIndex; // the first row is 0, so any row-index will be +1 .
            let studentID = $(this).val();
            // alert(studentID)
            $.ajax({
                type: 'get',
                url: 'function.php?studentIDViewEdit=' + studentID + '&rowIndex=' + studentRowIndex ,
                success: function(resp){
                    let myResponse = $.parseJSON(resp);
                    if(myResponse.status == 404){
                        alert(myResponse.message);
                    }else if(myResponse.status == 200){
                        // fill the form inputs by student data.
                        $("#row_index").val(myResponse.rowidx)  // hidden field
                        $("#student_id").val(myResponse.studentData.id)  // hidden field
                        $("#name").val(myResponse.studentData.name)
                        $("#email").val(myResponse.studentData.email)
                        $("#phone").val(myResponse.studentData.phone)
                        $("#course").val(myResponse.studentData.course)
                        // show the modal which content the form for updating.
                        $("#studentEditModal").modal('show'); // $(selector-mdal).modal('hide' | 'show' | 'trigger')
                    }
                }
            })
        });

        // when click on 'Update Student' as submit in updateStudentForm form - update the table in database and in #studentsTable.
        $(document).on("submit", "#updateStudentForm", function(myEvent){
            myEvent.preventDefault();
            //Note that the index of the currnt row is in the form - row-index, and will send with the formData.
            let formData = new FormData(this); // this refers to #updateStudentForm element (our form)
            formData.append("update_student", true); // Adding additional data to fromData by .aapend method - to know the action is save data in students table.
            $.ajax({
                type : "post",
                url : "function.php",
                data : formData,
                processData: false,
                contentType: false,
                success: function(resp){
                    let myResponse = $.parseJSON(resp);
                    if(myResponse.status == 422){
                        $("#errorUpdateMessage").text(myResponse.message);
                        $("#errorUpdateMessage").removeClass("d-none");
                    }else if(myResponse.status == 200){
                        $("#errorUpdateMessage").addClass("d-none");
                        $("#studentEditModal").modal('hide'); // $(selector-mdal).modal('hide' | 'show' | 'trigger')
                        $("#updateStudentForm")[0].reset()

                        //when new student added, the table must reloading (refresh it's data):
                        // location.href return entire URL of the current page.
                        // $("#studentsTable").load(location.href + " #studentsTable");
                        //
                        // console.log(myResponse.rowidx)
                        // let rowData2 = $("#studentsTable tr").eq(4).text();
                        // let rowData2 = $("#studentsTable tr").eq(myResponse.rowidx).text();

                        // refill the same row by date after changing.
                        $("#studentsTable tr").eq(myResponse.rowidx).find("td:eq(1)").text(myResponse.updatedData.name)                        
                        $("#studentsTable tr").eq(myResponse.rowidx).find("td:eq(2)").text(myResponse.updatedData.email)                       
                        $("#studentsTable tr").eq(myResponse.rowidx).find("td:eq(3)").text(myResponse.updatedData.phone)                       
                        $("#studentsTable tr").eq(myResponse.rowidx).find("td:eq(4)").text(myResponse.updatedData.course)                      
                    }
                }
            })
        });

        // delete the specific row in table - delete in database and remove in #studentsTable.
        $(document).on('click', '#delteStudentBtn', function(e){
            e.preventDefault();
            if(confirm('Are youe Sure you want to Delete this Student ?')){
                let studentID = $(this).val();
                $.ajax({
                    type: 'post',
                    url: 'function.php',
                    data: {
                        'delete_student': true,
                        'student_id': studentID
                    },
                    success: function(resp){
                        let myResponse = $.parseJSON(resp);
                        if(myResponse.status == 500){
                            alert(myResponse.message);
                        }else{
                            // alert(myResponse.message);
                            // alertify.set('notifier','position', 'bottom-center');
                            // alertify.success('Student Deleted Successfully.');
                            // $("#studentsTable").load(location.href + " #studentsTable");
                            // we cathc the <tr> by it's id value.
                            $("#"+studentID).css("display","none");
                        }
                    }
                })
            }
        })
    </script>

  </body>
</html>