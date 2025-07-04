<?php
session_start();
//error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if(isset($_POST['submit']))
{
    $specilization = $_POST['Doctorspecialization'];
    $doctorid = $_POST['doctor'];
    $userid = $_SESSION['id'];
    $fees = $_POST['fees'];
    $appdate = $_POST['appdate'];
    $time = $_POST['apptime'];
    $userstatus = 1;
    $docstatus = 1;

    // Get current date
    $currentDate = date('Y-m-d');
    
    // Validate appointment date (current day only)
    if($appdate != $currentDate) {
        $_SESSION['msg1'] = "Appointments can only be booked for the current day!";
    } else {
        // Check if the selected date and time match doctor's availability
        $availabilityCheck = mysqli_query($con, "SELECT * FROM doctor_availability 
            WHERE doctor_id = '$doctorid' 
            AND day_of_week = DAYNAME('$appdate') 
            AND '$time' BETWEEN start_time AND end_time");
        
        if(mysqli_num_rows($availabilityCheck) > 0) {
            $availability = mysqli_fetch_assoc($availabilityCheck);
            
            // Check max appointments for the day
            $appointmentsCount = mysqli_query($con, "SELECT COUNT(*) as count FROM appointment 
                WHERE doctorId = '$doctorid' 
                AND appointmentDate = '$appdate' 
                AND appointmentTime = '$time'");
            $count = mysqli_fetch_assoc($appointmentsCount)['count'];
            
            if($count < $availability['max_appointments']) {
                // Insert appointment with appointment number
                $appointmentNumber = $count + 1;
                $query = mysqli_query($con, "INSERT INTO appointment(doctorSpecialization, doctorId, userId, consultancyFees, appointmentDate, appointmentTime, userStatus, doctorStatus, appointmentNumber) 
                    VALUES('$specilization', '$doctorid', '$userid', '$fees', '$appdate', '$time', '$userstatus', '$docstatus', '$appointmentNumber')");
                
                if($query) {
                    echo "<script>alert('Your appointment successfully booked. You are appointment number $appointmentNumber for this time slot!');</script>";
                }
            } else {
                $_SESSION['msg1'] = "Sorry, maximum appointments ($availability[max_appointments]) reached for this time slot!";
            }
        } else {
            $_SESSION['msg1'] = "Selected time is not available for this doctor on the chosen date!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>User | Book Appointment</title>
    
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
        <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
        <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/plugins.css">
        <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
        <script src="vendor/jquery/jquery.min.js"></script>
        <script>
        function getdoctor(val) {
            $.ajax({
                type: "POST",
                url: "get_doctor.php",
                data: 'specilizationid=' + val,
                success: function(data) {
                    $("#doctor").html(data);
                },
                error: function(xhr, status, error) {
                    console.log("Doctor Load Error: " + error);
                    $("#doctor").html('<option value="">Error loading doctors</option>');
                }
            });
        }

        function getfee(val) {
            $.ajax({
                type: "POST",
                url: "get_doctor.php",
                data: 'doctor=' + val,
                success: function(data) {
                    $("#fees").html(data);
                    // Load times after fee is loaded
                    getAvailableTimes('<?php echo date('Y-m-d'); ?>');
                },
                error: function(xhr, status, error) {
                    console.log("Fees Load Error: " + error);
                    $("#fees").html('<option value="">Error loading fees</option>');
                }
            });
        }

        function getAvailableTimes(val) {
            var doctorId = $("#doctor").val();
            if (!doctorId) {
                $("#availableTimes").html('<select name="apptime" class="form-control" id="timeSelect" required><option value="">Select a doctor first</option></select>');
                return;
            }

            $.ajax({
                type: "POST",
                url: "get_availability.php",
                data: { doctor: doctorId, date: val },
                success: function(data) {
                    $("#availableTimes").html(data);
                },
                error: function(xhr, status, error) {
                    console.log("Time Load Error: " + error);
                    $("#availableTimes").html('<select name="apptime" class="form-control" id="timeSelect" required><option value="">Error loading times</option></select>');
                }
            });
        }
        </script>
    </head>
    <body>
        <div id="app">        
        <?php include('include/sidebar.php');?>
            <div class="app-content">
                <?php include('include/header.php');?>
                <div class="main-content">
                    <div class="wrap-content container" id="container">
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">User | Book Appointment</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>User</span></li>
                                    <li class="active"><span>Book Appointment</span></li>
                                </ol>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row margin-top-30">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title">Book Appointment</h5>
                                                </div>
                                                <div class="panel-body">
                                                    <p style="color:red;"><?php echo htmlentities($_SESSION['msg1']);?>
                                                    <?php echo htmlentities($_SESSION['msg1']="");?></p>    
                                                    <form role="form" name="book" method="post">
                                                        <div class="form-group">
                                                            <label for="DoctorSpecialization">Doctor Specialization</label>
                                                            <select name="Doctorspecialization" class="form-control" onChange="getdoctor(this.value);" required="required">
                                                                <option value="">Select Specialization</option>
                                                                <?php 
                                                                $ret = mysqli_query($con, "SELECT * FROM doctorspecilization");
                                                                while($row = mysqli_fetch_array($ret)) { 
                                                                ?>
                                                                    <option value="<?php echo htmlentities($row['specilization']);?>">
                                                                        <?php echo htmlentities($row['specilization']);?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="doctor">Doctors</label>
                                                            <select name="doctor" class="form-control" id="doctor" onChange="getfee(this.value);" required="required">
                                                                <option value="">Select Doctor</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="consultancyfees">Consultancy Fees</label>
                                                            <select name="fees" class="form-control" id="fees" readonly>
                                                                <option value="">Select Doctor First</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="AppointmentDate">Date</label>
                                                            <input class="form-control" name="appdate" value="<?php echo date('Y-m-d'); ?>" readonly required="required">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Appointmenttime">Time</label>
                                                            <div id="availableTimes">
                                                                <select name="apptime" class="form-control" id="timeSelect" required>
                                                                    <option value="">Select a doctor first</option>
                                                                </select>
                                                            </div>
                                                        </div>                                                      
                                                        <button type="submit" name="submit" class="btn btn-o btn-primary">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php');?>
            <?php include('include/setting.php');?>
        </div>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/modernizr/modernizr.js"></script>
        <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
        <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="vendor/switchery/switchery.min.js"></script>
        <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
        <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
        <script src="vendor/autosize/autosize.min.js"></script>
        <script src="vendor/selectFx/classie.js"></script>
        <script src="vendor/selectFx/selectFx.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/form-elements.js"></script>
        <script>
            jQuery(document).ready(function() {
                Main.init();
                FormElements.init();
            });
        </script>
    </body>
</html>