<?php 
require_once ("class/DBController.php");
class Attendance {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }
    
    function addAttendance($attendance_date, $student_id, $present, $absent) {
        $query = "INSERT INTO pritomnost (attendance_date,student_id,present,absent) VALUES (?, ?, ?, ?)";
        $paramType = "siii";
        $paramValue = array(
            $attendance_date,
            $student_id,
            $present,
            $absent
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);
        return $insertId;
    }
    
    function deleteAttendanceByDate($attendance_date) {
        $query = "DELETE FROM pritomnost WHERE attendance_date = ?";
        $paramType = "s";
        $paramValue = array(
            $attendance_date
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function getAttendanceByDate($attendance_date) {
        $sql = "SELECT * FROM pritomnost LEFT JOIN student ON tbl_attendance.student_id = tbl_student.id WHERE attendance_date = ? ORDER By student_id";
        
        
        $result = $this->db_handle->runQueryAll($sql);
        return $result;
    }
    
    function getAttendance() {
        $sql = "SELECT id, attendance_date, sum(present) as present, sum(absent) as absent FROM pritomnost GROUP By attendance_date";
        $result = $this->db_handle->runQueryAll($sql);
        return $result;
    }
}
?>