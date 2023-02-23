<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php $EW_ROOT_RELATIVE_PATH = ""; ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "user_profileinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$home_php = NULL; // Initialize page object first

class chome_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'home.php';

	// Page object name
	var $PageObjName = 'home_php';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'custom', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'home.php', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect();

		// User table object (user_profile)
		if (!isset($UserTable)) {
			$UserTable = new cuser_profile();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (IsPasswordExpired())
			$this->Page_Terminate(ew_GetUrl("changepwd.php"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanReport()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		if (@$_GET["export"] <> "")
			$gsExport = $_GET["export"]; // Get export parameter, used in header

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		// Close connection

		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}

	//
	// Page main
	//
	function Page_Main() {

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("custom", "home_php", $url, "", "home_php", TRUE);
		$this->Heading = $Language->TablePhrase("home_php", "TblCaption"); 
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($home_php)) $home_php = new chome_php();

// Page init
$home_php->Page_Init();

// Page main
$home_php->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php" ?>
<div class="panel panel-default">
	<div class="panel-heading">
	 	<marquee width="70%" direction="left" height="20px">
		<strong><span style="color:#8d1c2d !important">WELCOME TO LEAVE APPLICATION MANAGEMENT SYSTEM : <?php echo $_SESSION['Staff_Name']?> </span></strong> 
		<i style="color:#8d1c3d"> | Staff ID: <?php echo $_SESSION['Staff_ID']?> | Role: <?php echo $_SESSION['role_name']?> | Company: <?php echo $_SESSION["company_name" ]?> </i>
		</marquee>
		<p style="color:#0000 !important, align-test: center !important">NB: Applying for Leave should be two Weeks before applied Leave application due date.....</p>
	</div>
</div>
	<br><br>
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box bg-yellow-gradient">
			<span class="info-box-icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Return For Rework</span>
				<span class="info-box-number"><?php echo $_SESSION['MyReworkCount'] ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box bg-aqua-gradient">
			<span class="info-box-icon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Pending Leaves</span>
				<span class="info-box-number"><?php echo $_SESSION['MyPendingCount'] ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box bg-red-gradient">
			<span class="info-box-icon"><i class="fa fa-ban" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Leave Rejected</span>
				<span class="info-box-number"><?php echo $_SESSION['MyRejectionCount'] ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box bg-green-gradient">
			<span class="info-box-icon"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Approved Leave</span>
				<span class="info-box-number"><?php echo $_SESSION['MyApproverCount'] ?></span>
			</div>
		</div>
	</div><br><br>
	
	<?php $dbhelper = &DbHelper();?>
	<div id="r_drugs_dashboard" class="col-lg-6 col-md-6 col-sm-6">
		<div class="panel panel-success">
			<div class="panel-heading"><strong><?php date_default_timezone_set("Africa/Lagos"); echo "Approved Leave  Details - Today (" . date("l jS \of F Y") . ")"; ?></strong></div>
				<div class="panel-body">
				<?php 
				$sql = "SELECT DISTINCT " .  
				"`leave_form`.`id` AS `ID`,".
				"`date`.`time` AS `Initiated Date`,".
				"`leave_type` AS `Leave Type`,".
				"`leave_duration` AS `Leave Duration`,".
				"`status` AS `Status` = 5".
				" FROM `leave_form`";
				echo $dbhelper->ExecuteHtml($sql, array("fieldcaption" => TRUE, "tablename" => array("leave_form")));
				?>
			</div>
		</div>
	</div>
	<?php $dbhelper = &DbHelper();?>
	<div id="r_drugs_dashboard" class="col-lg-6 col-md-6 col-sm-6">
		<div class="panel panel-danger">
			<div class="panel-heading"><strong><?php date_default_timezone_set("Africa/Lagos"); echo "Reject Leave  Details - Today (" . date("l jS \of F Y") . ")"; ?></strong></div>
				<div class="panel-body">
				<?php 
				$sql = "SELECT DISTINCT " .  
				"`leave_form`.`id` AS `ID`,".
				"`date`.`time` AS `Initiated Date`,".
				"`leave_type` AS `Leave Type`,".
				"`leave_duration` AS `Leave Duration`,".
				"`status` AS `Status` = 2".
				" FROM `leave_form`";
				echo $dbhelper->ExecuteHtml($sql, array("fieldcaption" => TRUE, "tablename" => array("leave_form")));
				?>
			</div>
		</div>
	</div>

</div>
 


	<!--other side-->

	
<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$home_php->Page_Terminate();
?>
