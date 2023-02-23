<?php

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
}

// Page Rendering event
function Page_Rendering() {

	//echo "Page Rendering";
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}

function get_unique_id(){

	//$num0 = (rand(10,100));
	//$num2 = (rand(100,1000));
	//$num3 = time();
	//$randnum = $num0 . $num2 . $num3;
	//return $randnum ;

	$randStrs =	mt_rand(1000000000,9999999999);
	return "LEV1".$randStrs;

	//$date = date_create();
	//return (date_timestamp_get($date));

}	
if (CurrentUserLevel() == -1 || CurrentUserLevel() == 1 || CurrentUserLevel() == 2 || CurrentUserLevel() == 3) {
	$_SESSION['MyReworkCount'] = ew_ExecuteScalar("SELECT COUNT(id) FROM `leave_form` WHERE `status` in (1) ");
	$_SESSION['MyApproverCount'] = ew_ExecuteScalar("SELECT COUNT(id) FROM `leave_form` WHERE `status` in (5) ");
	$_SESSION['MyRejectionCount']  = ew_ExecuteScalar("SELECT COUNT(id) FROM `leave_form` WHERE `status` in (2) ");
	$_SESSION['MyPendingCount'] = ew_ExecuteScalar("SELECT COUNT(id) FROM `leave_form` WHERE `status` in (4) ");		
}

//// Session the Staff Name and Company Name here
if (CurrentUserLevel() == -1 || CurrentUserLevel() == 1  || CurrentUserLevel() == 2 || CurrentUserLevel() == 3) {
	$company_name = $_SESSION['Company'];
	$role_name    = $_SESSION['Department'];
	$_SESSION['MyReworkCount'] = ew_ExecuteScalar("SELECT COUNT(id) FROM `leave_form` WHERE `status` in (1) ");
	$_SESSION['MyApproverCount'] = ew_ExecuteScalar("SELECT COUNT(id) FROM `leave_form` WHERE `status` in (5) ");
	$_SESSION['MyRejectionCount']  = ew_ExecuteScalar("SELECT COUNT(id) FROM `leave_form` WHERE `status` in (2) ");
	$_SESSION['company_name']  = ew_ExecuteScalar("SELECT `description` FROM `company` WHERE `id` = $company_name ");
	$_SESSION['role_name']  = ew_ExecuteScalar("SELECT `description` FROM `department` WHERE `code` = $role_name ");
}

//// Session the Analysis Report here
if(CurrentUserLevel() == -1 || CurrentUserLevel() == 1 || CurrentUserLevel() == 2 || CurrentUserLevel() == 3){
	$_SESSION['AnaysisDateTime'] = ew_ExecuteScalar("SELECT CONCAT(`date`, ' ',`time`) FROM `leave_form` WHERE `status` IN (5)");
	$_SESSION['AnalysisLeaveType'] = ew_ExecuteScalar("SELECT `description` FROM `leave_type` JOIN `leave_form` ON leave_type.code = leave_form.leave_type WHERE leave_form.leave_type AND `status` IN (5)");
	$_SESSION['AnalysisNumberOfDays'] = ew_ExecuteScalar("SELECT COUNT(no_of_days) FROM `leave_form` WHERE `status` in (5)");
	$_SESSION['AnalysisStatus'] = ew_ExecuteScalar("SELECT `description` FROM `status` JOIN `leave_form` ON status.code = leave_form.status WHERE leave_form.status in (5)");

	//$_SESSION['AnalysisNumberOfDays'] = ew_ExecuteScalar("SELECT COUNT(`no_of_days`) FROM `leave_form` WHERE `status` in (5)");
}
?>
