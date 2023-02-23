<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "leave_forminfo.php" ?>
<?php include_once "user_profileinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$leave_form_delete = NULL; // Initialize page object first

class cleave_form_delete extends cleave_form {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'leave_form';

	// Page object name
	var $PageObjName = 'leave_form_delete';

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
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
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
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
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

		// Parent constuctor
		parent::__construct();

		// Table object (leave_form)
		if (!isset($GLOBALS["leave_form"]) || get_class($GLOBALS["leave_form"]) == "cleave_form") {
			$GLOBALS["leave_form"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["leave_form"];
		}

		// Table object (user_profile)
		if (!isset($GLOBALS['user_profile'])) $GLOBALS['user_profile'] = new cuser_profile();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'leave_form', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("leave_formlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
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

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->leave_id->SetVisibility();
		$this->date->SetVisibility();
		$this->time->SetVisibility();
		$this->staff_id->SetVisibility();
		$this->staff_name->SetVisibility();
		$this->company->SetVisibility();
		$this->department->SetVisibility();
		$this->leave_type->SetVisibility();
		$this->start_date->SetVisibility();
		$this->end_date->SetVisibility();
		$this->no_of_days->SetVisibility();
		$this->resumption_date->SetVisibility();
		$this->purpose_of_leave->SetVisibility();
		$this->status->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

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

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $leave_form;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($leave_form);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("leave_formlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in leave_form class, leave_forminfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("leave_formlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id->setDbValue($row['id']);
		$this->leave_id->setDbValue($row['leave_id']);
		$this->date->setDbValue($row['date']);
		$this->time->setDbValue($row['time']);
		$this->staff_id->setDbValue($row['staff_id']);
		$this->staff_name->setDbValue($row['staff_name']);
		$this->company->setDbValue($row['company']);
		$this->department->setDbValue($row['department']);
		$this->leave_type->setDbValue($row['leave_type']);
		$this->start_date->setDbValue($row['start_date']);
		$this->end_date->setDbValue($row['end_date']);
		$this->no_of_days->setDbValue($row['no_of_days']);
		$this->resumption_date->setDbValue($row['resumption_date']);
		$this->purpose_of_leave->setDbValue($row['purpose_of_leave']);
		$this->status->setDbValue($row['status']);
		$this->initiator_action->setDbValue($row['initiator_action']);
		$this->initiator_comments->setDbValue($row['initiator_comments']);
		$this->recommender_action->setDbValue($row['recommender_action']);
		$this->recommender_comments->setDbValue($row['recommender_comments']);
		$this->approver_action->setDbValue($row['approver_action']);
		$this->approver_comments->setDbValue($row['approver_comments']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['leave_id'] = NULL;
		$row['date'] = NULL;
		$row['time'] = NULL;
		$row['staff_id'] = NULL;
		$row['staff_name'] = NULL;
		$row['company'] = NULL;
		$row['department'] = NULL;
		$row['leave_type'] = NULL;
		$row['start_date'] = NULL;
		$row['end_date'] = NULL;
		$row['no_of_days'] = NULL;
		$row['resumption_date'] = NULL;
		$row['purpose_of_leave'] = NULL;
		$row['status'] = NULL;
		$row['initiator_action'] = NULL;
		$row['initiator_comments'] = NULL;
		$row['recommender_action'] = NULL;
		$row['recommender_comments'] = NULL;
		$row['approver_action'] = NULL;
		$row['approver_comments'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->leave_id->DbValue = $row['leave_id'];
		$this->date->DbValue = $row['date'];
		$this->time->DbValue = $row['time'];
		$this->staff_id->DbValue = $row['staff_id'];
		$this->staff_name->DbValue = $row['staff_name'];
		$this->company->DbValue = $row['company'];
		$this->department->DbValue = $row['department'];
		$this->leave_type->DbValue = $row['leave_type'];
		$this->start_date->DbValue = $row['start_date'];
		$this->end_date->DbValue = $row['end_date'];
		$this->no_of_days->DbValue = $row['no_of_days'];
		$this->resumption_date->DbValue = $row['resumption_date'];
		$this->purpose_of_leave->DbValue = $row['purpose_of_leave'];
		$this->status->DbValue = $row['status'];
		$this->initiator_action->DbValue = $row['initiator_action'];
		$this->initiator_comments->DbValue = $row['initiator_comments'];
		$this->recommender_action->DbValue = $row['recommender_action'];
		$this->recommender_comments->DbValue = $row['recommender_comments'];
		$this->approver_action->DbValue = $row['approver_action'];
		$this->approver_comments->DbValue = $row['approver_comments'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// leave_id
		// date
		// time
		// staff_id
		// staff_name
		// company
		// department
		// leave_type
		// start_date
		// end_date
		// no_of_days
		// resumption_date
		// purpose_of_leave
		// status
		// initiator_action
		// initiator_comments
		// recommender_action
		// recommender_comments
		// approver_action
		// approver_comments

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// leave_id
		$this->leave_id->ViewValue = $this->leave_id->CurrentValue;
		$this->leave_id->ViewCustomAttributes = "";

		// date
		$this->date->ViewValue = $this->date->CurrentValue;
		$this->date->ViewValue = ew_FormatDateTime($this->date->ViewValue, 7);
		$this->date->ViewCustomAttributes = "";

		// time
		$this->time->ViewValue = $this->time->CurrentValue;
		$this->time->ViewValue = ew_FormatDateTime($this->time->ViewValue, 3);
		$this->time->ViewCustomAttributes = "";

		// staff_id
		$this->staff_id->ViewValue = $this->staff_id->CurrentValue;
		$this->staff_id->ViewCustomAttributes = "";

		// staff_name
		$this->staff_name->ViewValue = $this->staff_name->CurrentValue;
		$this->staff_name->ViewCustomAttributes = "";

		// company
		if (strval($this->company->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->company->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `company`";
		$sWhereWrk = "";
		$this->company->LookupFilters = array("dx1" => '`description`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->company, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->company->ViewValue = $this->company->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->company->ViewValue = $this->company->CurrentValue;
			}
		} else {
			$this->company->ViewValue = NULL;
		}
		$this->company->ViewCustomAttributes = "";

		// department
		if (strval($this->department->CurrentValue) <> "") {
			$sFilterWrk = "`code`" . ew_SearchString("=", $this->department->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `code`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `department`";
		$sWhereWrk = "";
		$this->department->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->department, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->department->ViewValue = $this->department->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->department->ViewValue = $this->department->CurrentValue;
			}
		} else {
			$this->department->ViewValue = NULL;
		}
		$this->department->ViewCustomAttributes = "";

		// leave_type
		if (strval($this->leave_type->CurrentValue) <> "") {
			$sFilterWrk = "`code`" . ew_SearchString("=", $this->leave_type->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `code`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `leave_type`";
		$sWhereWrk = "";
		$this->leave_type->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->leave_type, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `description` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->leave_type->ViewValue = $this->leave_type->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->leave_type->ViewValue = $this->leave_type->CurrentValue;
			}
		} else {
			$this->leave_type->ViewValue = NULL;
		}
		$this->leave_type->ViewCustomAttributes = "";

		// start_date
		$this->start_date->ViewValue = $this->start_date->CurrentValue;
		$this->start_date->ViewValue = ew_FormatDateTime($this->start_date->ViewValue, 14);
		$this->start_date->ViewCustomAttributes = "";

		// end_date
		$this->end_date->ViewValue = $this->end_date->CurrentValue;
		$this->end_date->ViewValue = ew_FormatDateTime($this->end_date->ViewValue, 14);
		$this->end_date->ViewCustomAttributes = "";

		// no_of_days
		$this->no_of_days->ViewValue = $this->no_of_days->CurrentValue;
		$this->no_of_days->ViewCustomAttributes = "";

		// resumption_date
		$this->resumption_date->ViewValue = $this->resumption_date->CurrentValue;
		$this->resumption_date->ViewValue = ew_FormatDateTime($this->resumption_date->ViewValue, 14);
		$this->resumption_date->ViewCustomAttributes = "";

		// purpose_of_leave
		$this->purpose_of_leave->ViewValue = $this->purpose_of_leave->CurrentValue;
		$this->purpose_of_leave->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		if (strval($this->status->CurrentValue) <> "") {
			$sFilterWrk = "`code`" . ew_SearchString("=", $this->status->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `code`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `status`";
		$sWhereWrk = "";
		$this->status->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->status, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `code` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->status->ViewValue = $this->status->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->status->ViewValue = $this->status->CurrentValue;
			}
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// initiator_action
		if (strval($this->initiator_action->CurrentValue) <> "") {
			$this->initiator_action->ViewValue = $this->initiator_action->OptionCaption($this->initiator_action->CurrentValue);
		} else {
			$this->initiator_action->ViewValue = NULL;
		}
		$this->initiator_action->ViewCustomAttributes = "";

		// initiator_comments
		$this->initiator_comments->ViewValue = $this->initiator_comments->CurrentValue;
		$this->initiator_comments->ViewCustomAttributes = "";

		// recommender_action
		if (strval($this->recommender_action->CurrentValue) <> "") {
			$this->recommender_action->ViewValue = $this->recommender_action->OptionCaption($this->recommender_action->CurrentValue);
		} else {
			$this->recommender_action->ViewValue = NULL;
		}
		$this->recommender_action->ViewCustomAttributes = "";

		// recommender_comments
		$this->recommender_comments->ViewValue = $this->recommender_comments->CurrentValue;
		$this->recommender_comments->ViewCustomAttributes = "";

		// approver_action
		if (strval($this->approver_action->CurrentValue) <> "") {
			$this->approver_action->ViewValue = $this->approver_action->OptionCaption($this->approver_action->CurrentValue);
		} else {
			$this->approver_action->ViewValue = NULL;
		}
		$this->approver_action->ViewCustomAttributes = "";

		// approver_comments
		$this->approver_comments->ViewValue = $this->approver_comments->CurrentValue;
		$this->approver_comments->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// leave_id
			$this->leave_id->LinkCustomAttributes = "";
			$this->leave_id->HrefValue = "";
			$this->leave_id->TooltipValue = "";

			// date
			$this->date->LinkCustomAttributes = "";
			$this->date->HrefValue = "";
			$this->date->TooltipValue = "";

			// time
			$this->time->LinkCustomAttributes = "";
			$this->time->HrefValue = "";
			$this->time->TooltipValue = "";

			// staff_id
			$this->staff_id->LinkCustomAttributes = "";
			$this->staff_id->HrefValue = "";
			$this->staff_id->TooltipValue = "";

			// staff_name
			$this->staff_name->LinkCustomAttributes = "";
			$this->staff_name->HrefValue = "";
			$this->staff_name->TooltipValue = "";

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";
			$this->company->TooltipValue = "";

			// department
			$this->department->LinkCustomAttributes = "";
			$this->department->HrefValue = "";
			$this->department->TooltipValue = "";

			// leave_type
			$this->leave_type->LinkCustomAttributes = "";
			$this->leave_type->HrefValue = "";
			$this->leave_type->TooltipValue = "";

			// start_date
			$this->start_date->LinkCustomAttributes = "";
			$this->start_date->HrefValue = "";
			$this->start_date->TooltipValue = "";

			// end_date
			$this->end_date->LinkCustomAttributes = "";
			$this->end_date->HrefValue = "";
			$this->end_date->TooltipValue = "";

			// no_of_days
			$this->no_of_days->LinkCustomAttributes = "";
			$this->no_of_days->HrefValue = "";
			$this->no_of_days->TooltipValue = "";

			// resumption_date
			$this->resumption_date->LinkCustomAttributes = "";
			$this->resumption_date->HrefValue = "";
			$this->resumption_date->TooltipValue = "";

			// purpose_of_leave
			$this->purpose_of_leave->LinkCustomAttributes = "";
			$this->purpose_of_leave->HrefValue = "";
			$this->purpose_of_leave->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("leave_formlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($leave_form_delete)) $leave_form_delete = new cleave_form_delete();

// Page init
$leave_form_delete->Page_Init();

// Page main
$leave_form_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$leave_form_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fleave_formdelete = new ew_Form("fleave_formdelete", "delete");

// Form_CustomValidate event
fleave_formdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fleave_formdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fleave_formdelete.Lists["x_company"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":["x_department"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fleave_formdelete.Lists["x_company"].Data = "<?php echo $leave_form_delete->company->LookupFilterQuery(FALSE, "delete") ?>";
fleave_formdelete.Lists["x_department"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"department"};
fleave_formdelete.Lists["x_department"].Data = "<?php echo $leave_form_delete->department->LookupFilterQuery(FALSE, "delete") ?>";
fleave_formdelete.Lists["x_leave_type"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"leave_type"};
fleave_formdelete.Lists["x_leave_type"].Data = "<?php echo $leave_form_delete->leave_type->LookupFilterQuery(FALSE, "delete") ?>";
fleave_formdelete.Lists["x_status"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"status"};
fleave_formdelete.Lists["x_status"].Data = "<?php echo $leave_form_delete->status->LookupFilterQuery(FALSE, "delete") ?>";
fleave_formdelete.AutoSuggests["x_status"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $leave_form_delete->status->LookupFilterQuery(TRUE, "delete"))) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $leave_form_delete->ShowPageHeader(); ?>
<?php
$leave_form_delete->ShowMessage();
?>
<form name="fleave_formdelete" id="fleave_formdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($leave_form_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $leave_form_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="leave_form">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($leave_form_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($leave_form->id->Visible) { // id ?>
		<th class="<?php echo $leave_form->id->HeaderCellClass() ?>"><span id="elh_leave_form_id" class="leave_form_id"><?php echo $leave_form->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->leave_id->Visible) { // leave_id ?>
		<th class="<?php echo $leave_form->leave_id->HeaderCellClass() ?>"><span id="elh_leave_form_leave_id" class="leave_form_leave_id"><?php echo $leave_form->leave_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->date->Visible) { // date ?>
		<th class="<?php echo $leave_form->date->HeaderCellClass() ?>"><span id="elh_leave_form_date" class="leave_form_date"><?php echo $leave_form->date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->time->Visible) { // time ?>
		<th class="<?php echo $leave_form->time->HeaderCellClass() ?>"><span id="elh_leave_form_time" class="leave_form_time"><?php echo $leave_form->time->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->staff_id->Visible) { // staff_id ?>
		<th class="<?php echo $leave_form->staff_id->HeaderCellClass() ?>"><span id="elh_leave_form_staff_id" class="leave_form_staff_id"><?php echo $leave_form->staff_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->staff_name->Visible) { // staff_name ?>
		<th class="<?php echo $leave_form->staff_name->HeaderCellClass() ?>"><span id="elh_leave_form_staff_name" class="leave_form_staff_name"><?php echo $leave_form->staff_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->company->Visible) { // company ?>
		<th class="<?php echo $leave_form->company->HeaderCellClass() ?>"><span id="elh_leave_form_company" class="leave_form_company"><?php echo $leave_form->company->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->department->Visible) { // department ?>
		<th class="<?php echo $leave_form->department->HeaderCellClass() ?>"><span id="elh_leave_form_department" class="leave_form_department"><?php echo $leave_form->department->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->leave_type->Visible) { // leave_type ?>
		<th class="<?php echo $leave_form->leave_type->HeaderCellClass() ?>"><span id="elh_leave_form_leave_type" class="leave_form_leave_type"><?php echo $leave_form->leave_type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->start_date->Visible) { // start_date ?>
		<th class="<?php echo $leave_form->start_date->HeaderCellClass() ?>"><span id="elh_leave_form_start_date" class="leave_form_start_date"><?php echo $leave_form->start_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->end_date->Visible) { // end_date ?>
		<th class="<?php echo $leave_form->end_date->HeaderCellClass() ?>"><span id="elh_leave_form_end_date" class="leave_form_end_date"><?php echo $leave_form->end_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->no_of_days->Visible) { // no_of_days ?>
		<th class="<?php echo $leave_form->no_of_days->HeaderCellClass() ?>"><span id="elh_leave_form_no_of_days" class="leave_form_no_of_days"><?php echo $leave_form->no_of_days->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->resumption_date->Visible) { // resumption_date ?>
		<th class="<?php echo $leave_form->resumption_date->HeaderCellClass() ?>"><span id="elh_leave_form_resumption_date" class="leave_form_resumption_date"><?php echo $leave_form->resumption_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->purpose_of_leave->Visible) { // purpose_of_leave ?>
		<th class="<?php echo $leave_form->purpose_of_leave->HeaderCellClass() ?>"><span id="elh_leave_form_purpose_of_leave" class="leave_form_purpose_of_leave"><?php echo $leave_form->purpose_of_leave->FldCaption() ?></span></th>
<?php } ?>
<?php if ($leave_form->status->Visible) { // status ?>
		<th class="<?php echo $leave_form->status->HeaderCellClass() ?>"><span id="elh_leave_form_status" class="leave_form_status"><?php echo $leave_form->status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$leave_form_delete->RecCnt = 0;
$i = 0;
while (!$leave_form_delete->Recordset->EOF) {
	$leave_form_delete->RecCnt++;
	$leave_form_delete->RowCnt++;

	// Set row properties
	$leave_form->ResetAttrs();
	$leave_form->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$leave_form_delete->LoadRowValues($leave_form_delete->Recordset);

	// Render row
	$leave_form_delete->RenderRow();
?>
	<tr<?php echo $leave_form->RowAttributes() ?>>
<?php if ($leave_form->id->Visible) { // id ?>
		<td<?php echo $leave_form->id->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_id" class="leave_form_id">
<span<?php echo $leave_form->id->ViewAttributes() ?>>
<?php echo $leave_form->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->leave_id->Visible) { // leave_id ?>
		<td<?php echo $leave_form->leave_id->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_leave_id" class="leave_form_leave_id">
<span<?php echo $leave_form->leave_id->ViewAttributes() ?>>
<?php echo $leave_form->leave_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->date->Visible) { // date ?>
		<td<?php echo $leave_form->date->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_date" class="leave_form_date">
<span<?php echo $leave_form->date->ViewAttributes() ?>>
<?php echo $leave_form->date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->time->Visible) { // time ?>
		<td<?php echo $leave_form->time->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_time" class="leave_form_time">
<span<?php echo $leave_form->time->ViewAttributes() ?>>
<?php echo $leave_form->time->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->staff_id->Visible) { // staff_id ?>
		<td<?php echo $leave_form->staff_id->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_staff_id" class="leave_form_staff_id">
<span<?php echo $leave_form->staff_id->ViewAttributes() ?>>
<?php echo $leave_form->staff_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->staff_name->Visible) { // staff_name ?>
		<td<?php echo $leave_form->staff_name->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_staff_name" class="leave_form_staff_name">
<span<?php echo $leave_form->staff_name->ViewAttributes() ?>>
<?php echo $leave_form->staff_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->company->Visible) { // company ?>
		<td<?php echo $leave_form->company->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_company" class="leave_form_company">
<span<?php echo $leave_form->company->ViewAttributes() ?>>
<?php echo $leave_form->company->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->department->Visible) { // department ?>
		<td<?php echo $leave_form->department->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_department" class="leave_form_department">
<span<?php echo $leave_form->department->ViewAttributes() ?>>
<?php echo $leave_form->department->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->leave_type->Visible) { // leave_type ?>
		<td<?php echo $leave_form->leave_type->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_leave_type" class="leave_form_leave_type">
<span<?php echo $leave_form->leave_type->ViewAttributes() ?>>
<?php echo $leave_form->leave_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->start_date->Visible) { // start_date ?>
		<td<?php echo $leave_form->start_date->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_start_date" class="leave_form_start_date">
<span<?php echo $leave_form->start_date->ViewAttributes() ?>>
<?php echo $leave_form->start_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->end_date->Visible) { // end_date ?>
		<td<?php echo $leave_form->end_date->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_end_date" class="leave_form_end_date">
<span<?php echo $leave_form->end_date->ViewAttributes() ?>>
<?php echo $leave_form->end_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->no_of_days->Visible) { // no_of_days ?>
		<td<?php echo $leave_form->no_of_days->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_no_of_days" class="leave_form_no_of_days">
<span<?php echo $leave_form->no_of_days->ViewAttributes() ?>>
<?php echo $leave_form->no_of_days->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->resumption_date->Visible) { // resumption_date ?>
		<td<?php echo $leave_form->resumption_date->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_resumption_date" class="leave_form_resumption_date">
<span<?php echo $leave_form->resumption_date->ViewAttributes() ?>>
<?php echo $leave_form->resumption_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->purpose_of_leave->Visible) { // purpose_of_leave ?>
		<td<?php echo $leave_form->purpose_of_leave->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_purpose_of_leave" class="leave_form_purpose_of_leave">
<span<?php echo $leave_form->purpose_of_leave->ViewAttributes() ?>>
<?php echo $leave_form->purpose_of_leave->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($leave_form->status->Visible) { // status ?>
		<td<?php echo $leave_form->status->CellAttributes() ?>>
<span id="el<?php echo $leave_form_delete->RowCnt ?>_leave_form_status" class="leave_form_status">
<span<?php echo $leave_form->status->ViewAttributes() ?>>
<?php echo $leave_form->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$leave_form_delete->Recordset->MoveNext();
}
$leave_form_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $leave_form_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fleave_formdelete.Init();
</script>
<?php
$leave_form_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$leave_form_delete->Page_Terminate();
?>
