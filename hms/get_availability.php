<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if(isset($_POST['doctor']) && isset($_POST['date'])) {
    $doctorid = $_POST['doctor'];
    $date = $_POST['date'];
    
    // Get day of week from date
    $dayOfWeek = date('l', strtotime($date));
    
    // Query to get doctor's availability for that day
    $availabilityQuery = mysqli_query($con, "SELECT * FROM doctor_availability 
        WHERE doctor_id = '$doctorid' 
        AND day_of_week = '$dayOfWeek'
        ORDER BY start_time ASC");
    
    if(mysqli_num_rows($availabilityQuery) > 0) {
        echo '<select name="apptime" class="form-control" id="timeSelect" required>';
        echo '<option value="">Select Time</option>';
        
        while($availability = mysqli_fetch_assoc($availabilityQuery)) {
            // Get count of existing appointments for each time slot
            $countQuery = mysqli_query($con, "SELECT COUNT(*) as count FROM appointment 
                WHERE doctorId = '$doctorid' 
                AND appointmentDate = '$date' 
                AND appointmentTime = '$availability[start_time]'");
            $count = mysqli_fetch_assoc($countQuery)['count'];
            
            // Only show time slots that haven't reached max appointments
            if($count < $availability['max_appointments']) {
                echo '<option value="' . $availability['start_time'] . '">' . 
                     date('h:i A', strtotime($availability['start_time'])) . 
                     ' (' . ($availability['max_appointments'] - $count) . ' slots available)</option>';
            }
        }
        
        echo '</select>';
    } else {
        echo '<select name="apptime" class="form-control" id="timeSelect" required>';
        echo '<option value="">No time slots available for this doctor on ' . $dayOfWeek . '</option>';
        echo '</select>';
    }
} else {
    echo '<select name="apptime" class="form-control" id="timeSelect" required>';
    echo '<option value="">Please select a doctor first</option>';
    echo '</select>';
}
?>