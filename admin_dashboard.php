<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    include "connect.php"; 
    
?>

<?php //add
include "connect.php";

if (isset($_POST['add_student'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $status ='Active';
    

    $sql = "INSERT INTO tblstudent (fname, lname, email, course, gender, number, status) 
            VALUES ('$fname', '$lname', '$email', '$course', '$gender','$number','$status')";

    if ($con->query($sql) === TRUE) {
        header("Location: admin_dashboard.php?success=Student added successfully");
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}
?>

<?php
// update
include "connect.php";

// Handle Update Request
if (isset($_GET['update'])) {
    $student_id = intval($_GET['update']); // Get the student ID

    // Fetch student data from the database
    $sql = "SELECT * FROM tblstudent WHERE student_id = $student_id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc(); // Fetch student details
    } else {
        echo "<script>alert('Student not found.');</script>";
        echo "<script>window.location.href = 'admin_dashboard.php';</script>";
        exit();
    }
}

// Handle Update Form Submission
if (isset($_POST['update_student'])) {
    $student_id = intval($_POST['student_id']);
    $fname = $con->real_escape_string($_POST['fname']);
    $lname = $con->real_escape_string($_POST['lname']);
    $email = $con->real_escape_string($_POST['email']);
    $course = $con->real_escape_string($_POST['course']);
    $gender = $con->real_escape_string($_POST['gender']);
    $status = $con->real_escape_string($_POST['status']);

    // Update the student record
    $sql = "UPDATE tblstudent SET fname='$fname', lname='$lname', email='$email', course='$course', gender='$gender', status='$status' WHERE student_id=$student_id";

    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Student updated successfully.');</script>";
        echo "<script>window.location.href = 'admin_dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating student: " . $con->error . "');</script>";
    }
}
?>

<?php
// delete
include "connect.php";

if (isset($_GET['delete'])) {
    $student_id = intval($_GET['delete']); 
   
    $sql = "DELETE FROM tblstudent WHERE student_id = $student_id";

    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Student deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting student: " . $con->error . "');</script>";
    }

    echo "<script>window.location.href = 'admin_dashboard.php';</script>";
    exit();
}
?>

<?php //per%
    include 'connect.php';

    $totalQuery = "SELECT COUNT(*) AS total_students FROM tblstudent";
    $totalResult = $con->query($totalQuery);
    $totalRow = $totalResult->fetch_assoc();
    $totalStudents = $totalRow['total_students'];

    $activeQuery = "SELECT COUNT(*) AS active_students FROM tblstudent WHERE status = 'Active'";
$activeResult = $con->query($activeQuery);
$activeRow = $activeResult->fetch_assoc();
$activeStudents = $activeRow['active_students'];

// Calculate percentage of active students
$activePercentage = 0;
if ($totalStudents > 0) {
    $activePercentage = ($activeStudents / $totalStudents) * 100;
}

// Format percentage to 2 decimal places (optional)
    $activePercentage = number_format($activePercentage, 2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="img/admin.png" alt="Admin Logo">
                <h3>Admin Panel</h3>
            </div>
            <div class="profile-info">
                <h4><?php echo $_SESSION['username']; ?></h4>
                <span>Administrator</span>
            </div>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php" class="active"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="javascript:void(0)" onclick="showAddStudentForm()"><i class="fas fa-user-plus"></i> Add Student</a></li>
                    <li><a href=""><i class="fas fa-file-alt"></i> Reports</a></li>
                    <li><a href=""><i class="fas fa-cog"></i> Settings</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </div>

        
        <div class="main">
            <div class="topbar">
                <div class="search">
                    <form method="GET" action="admin_dashboard.php">
                        <input type="text" name="search_query" placeholder="Search students...">
                        <button type="submit"><i class="fas fa-search"></i> Search</button>
                    </form>
                </div>
                <div class="user-menu">
                </div>
            </div>

           
            <div class="cards-container">
                <div class="info-card">
                    <div class="card-content">
                        <i class="fas fa-users"></i>
                        <div class="numbers">
                            <?php
                            $sql = "SELECT COUNT(*) as count FROM tblstudent";
                            $result = $con->query($sql);
                            $row = $result->fetch_assoc();
                            echo $row['count'];
                            ?>
                        </div>
                        <div class="card-name">Total Students</div>
                    </div>
                </div>
                <div class="info-card">
                    <div class="card-content">
                        <i class="fas fa-user-graduate"></i>
                        <div class="numbers">5</div>
                        <div class="card-name">Courses</div>
                    </div>
                </div>
                <div class="info-card">
                    <div class="card-content">
                        <i class="fas fa-chart-bar"></i>
                        <div class="numbers"><?php echo $activePercentage; ?></div>
                        <div class="card-name">Performance</div>
                    </div>
                </div>
            </div>

            
            <div class="table-container">
                <div class="table-header">
                    <h2 style="text-align:center">STUDENT RECORDS</h2>
                </div>
                <div class="table-content">
                    <?php
                    
                    if (isset($_GET['search_query'])) {
                        $search_query = $con->real_escape_string($_GET['search_query']);
                        $sql = "SELECT * FROM tblstudent WHERE fname LIKE '%$search_query%' 
                                OR lname LIKE '%$search_query%'";
                    } else {
                        $sql = "SELECT * FROM tblstudent";
                    }
                    
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>Status</th>
                                        <th>Actions</th>   
                                    </tr>
                                </thead>
                                <tbody>";
                        
                        while ($row = $result->fetch_assoc()) {

                            $statusClass = $row['status'] === 'Active' ? 'status-active' : 'status-inactive';

                            echo "<tr>
                                    <td>#".$row["student_id"]."</td>
                                    <td>
                                        <div class='student-info'>
                                            <div>
                                                <span>".$row["fname"]." ".$row["lname"]."</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>".$row["course"]."</td>
                                    <td>".$row["gender"]."</td>
                                    <td>".$row["email"]."</td>
                                    <td>".$row["number"]."</td>
                                    <td><span class='status $statusClass'>{$row['status']}</span></td>
                                    <td class='actions'>
                                        <button onclick='location.href=\"?update=".$row["student_id"]."\"' class='edit'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                        <button onclick='deleteStudent(".$row["student_id"].")' class='delete'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </td>
                                  </tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "<div class='no-data'>
                                <i class='fas fa-folder-open'></i>
                                <p>No students found</p>
                              </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>//add
    function showAddStudentForm(){
        document.getElementById('addStudentForm').style.display = 'block';
    }
    function hideAddStudentForm(){
        document.getElementById('addStudentForm').style.display = 'none';
    }
    </script>

    <div class="add-student-form" id="addStudentForm">
    <h2>Add New Student</h2>
    <form method="POST" action="admin_dashboard.php">
        <div class="form-group">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" placeholder="Enter first name" required>
        </div>
        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" placeholder="Enter last name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label for="number">Contact Number:</label>
            <input type="text" id="number" name="number" placeholder="Enter Contact Number" required>
        </div>
        <div class="form-group">
            <label for="course">Course:</label>
            <select id="course" name="course" required>
                <option value="">Select Course</option>
                <option value="BSIT">BSIT</option>
                <option value="BSHM">BSHM</option>
                <option value="BSBA">BSBA</option>
                <option value="BSEE">BSEE</option>
                <option value="BSED">BSED</option>
            </select>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Non-Binary">Non-Binary</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" name="add_student" class="add-btn">Add Student</button>
            <button type="button" onclick="hideAddStudentForm()" class="cancel-btn">Cancel</button>
        </div>
    </form>
</div>


    
    <?php //update
    if (isset($_GET['update'])): ?>
<div class="overlay"></div>
<div class="update-form">
    <h2>Update Student</h2>
    <form method="POST" action="admin_dashboard.php">
        <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
        <div class="form-group">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo $student['fname']; ?>" required>
        </div>
        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo $student['lname']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $student['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="course">Course:</label>
                <select id="course" name="course" required>
                <option value="">Select Course</option>
                <option value="BSIT" <?php if ($student['course'] == 'BSIT') echo 'selected'; ?>>BSIT</option>
                <option value="BSHM" <?php if ($student['course'] == 'BSHM') echo 'selected'; ?>>BSHM</option>
                <option value="BSBA" <?php if ($student['course'] == 'BSBA') echo 'selected'; ?>>BSBA</option>
                <option value="BSEE" <?php if ($student['course'] == 'BSEE') echo 'selected'; ?>>BSEE</option>
                <option value="BSED" <?php if ($student['course'] == 'BSED') echo 'selected'; ?>>BSED</option>
                </select>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male" <?php if ($student['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($student['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Non-Binary" <?php if ($student['gender'] == 'Non-Binary') echo 'selected'; ?>>Non-Binary</option>
                </select>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
                <select id="status" name="status" required>
                <option value="">Select Status</option>
                <option value="Active" <?php if ($student['status'] == 'Active') echo 'selected'; ?>>Active</option>
                <option value="Inactive" <?php if ($student['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                </select>
                </div>
        <button type="submit" name="update_student" class="update-btn">Update</button>
        <button type="button" onclick="window.location.href='admin_dashboard.php'" class="cancel-btn">Cancel</button>
    </form>
</div>
<?php endif; ?>


    <script>
        //delete
    function deleteStudent(id) {
        if (confirm('Are you sure you want to delete this student?')) {
            
            window.location.href = 'admin_dashboard.php?delete=' + id;
        }
    }
</script>

</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>
