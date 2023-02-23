<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "reportinfo.php" ?>
<?php include_once "user_profileinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$report_search = NULL; // Initialize page object first

class creport_search extends creport {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'report';

	// Page object name
	var $PageObjName = 'report_search';

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

		// Table object (report)
		if (!isset($GLOBALS["report"]) || get_class($GLOBALS["report"]) == "creport") {
			$GLOBALS["report"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["report"];
		}

		// Table object (user_profile)
		if (!isset($GLOBALS['user_profile'])) $GLOBALS['user_profile'] = new cuser_profile();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'report', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

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
		if (!$Security->CanSearch()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("reportlist.php"));
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->leave_id->SetVisibility();
		$this->date_created->SetVisibility();
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
		$this->replacement_assign_staff->SetVisibility();
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
		global $EW_EXPORT, $report;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($report);
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "reportview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "reportlist.php" . "?" . $sSrchStr;
						$this->Page_Terminate($sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->leave_id); // leave_id
		$this->BuildSearchUrl($sSrchUrl, $this->date_created); // date_created
		$this->BuildSearchUrl($sSrchUrl, $this->time); // time
		$this->BuildSearchUrl($sSrchUrl, $this->staff_id); // staff_id
		$this->BuildSearchUrl($sSrchUrl, $this->staff_name); // staff_name
		$this->BuildSearchUrl($sSrchUrl, $this->company); // company
		$this->BuildSearchUrl($sSrchUrl, $this->department); // department
		$this->BuildSearchUrl($sSrchUrl, $this->leave_type); // leave_type
		$this->BuildSearchUrl($sSrchUrl, $this->start_date); // start_date
		$this->BuildSearchUrl($sSrchUrl, $this->end_date); // end_date
		$this->BuildSearchUrl($sSrchUrl, $this->no_of_days); // no_of_days
		$this->BuildSearchUrl($sSrchUrl, $this->resumption_date); // resumption_date
		$this->BuildSearchUrl($sSrchUrl, $this->replacement_assign_staff); // replacement_assign_staff
		$this->BuildSearchUrl($sSrchUrl, $this->purpose_of_leave); // purpose_of_leave
		$this->BuildSearchUrl($sSrchUrl, $this->status); // status
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = $Fld->FldParm();
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = $FldVal;
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $FldVal2;
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// leave_id

		$this->leave_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_leave_id");
		$this->leave_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_leave_id");

		// date_created
		$this->date_created->AdvancedSearch->SearchValue = $objForm->GetValue("x_date_created");
		$this->date_created->AdvancedSearch->SearchOperator = $objForm->GetValue("z_date_created");

		// time
		$this->time->AdvancedSearch->SearchValue = $objForm->GetValue("x_time");
		$this->time->AdvancedSearch->SearchOperator = $objForm->GetValue("z_time");

		// staff_id
		$this->staff_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_staff_id");
		$this->staff_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_staff_id");

		// staff_name
		$this->staff_name->AdvancedSearch->SearchValue = $objForm->GetValue("x_staff_name");
		$this->staff_name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_staff_name");

		// company
		$this->company->AdvancedSearch->SearchValue = $objForm->GetValue("x_company");
		$this->company->AdvancedSearch->SearchOperator = $objForm->GetValue("z_company");

		// department
		$this->department->AdvancedSearch->SearchValue = $objForm->GetValue("x_department");
		$this->department->AdvancedSearch->SearchOperator = $objForm->GetValue("z_department");

		// leave_type
		$this->leave_type->AdvancedSearch->SearchValue = $objForm->GetValue("x_leave_type");
		$this->leave_type->AdvancedSearch->SearchOperator = $objForm->GetValue("z_leave_type");

		// start_date
		$this->start_date->AdvancedSearch->SearchValue = $objForm->GetValue("x_start_date");
		$this->start_date->AdvancedSearch->SearchOperator = $objForm->GetValue("z_start_date");

		// end_date
		$this->end_date->AdvancedSearch->SearchValue = $objForm->GetValue("x_end_date");
		$this->end_date->AdvancedSearch->SearchOperator = $objForm->GetValue("z_end_date");

		// no_of_days
		$this->no_of_days->AdvancedSearch->SearchValue = $objForm->GetValue("x_no_of_days");
		$this->no_of_days->AdvancedSearch->SearchOperator = $objForm->GetValue("z_no_of_days");

		// resumption_date
		$this->resumption_date->AdvancedSearch->SearchValue = $objForm->GetValue("x_resumption_date");
		$this->resumption_date->AdvancedSearch->SearchOperator = $objForm->GetValue("z_resumption_date");

		// replacement_assign_staff
		$this->replacement_assign_staff->AdvancedSearch->SearchValue = $objForm->GetValue("x_replacement_assign_staff");
		$this->replacement_assign_staff->AdvancedSearch->SearchOperator = $objForm->GetValue("z_replacement_assign_staff");

		// purpose_of_leave
		$this->purpose_of_leave->AdvancedSearch->SearchValue = $objForm->GetValue("x_purpose_of_leave");
		$this->purpose_of_leave->AdvancedSearch->SearchOperator = $objForm->GetValue("z_purpose_of_leave");

		// status
		$this->status->AdvancedSearch->SearchValue = $objForm->GetValue("x_status");
		$this->status->AdvancedSearch->SearchOperator = $objForm->GetValue("z_status");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// leave_id
		// date_created
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
		// replacement_assign_staff
		// purpose_of_leave
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// leave_id
		$this->leave_id->ViewValue = $this->leave_id->CurrentValue;
		$this->leave_id->ViewCustomAttributes = "";

		// date_created
		$this->date_created->ViewValue = $this->date_created->CurrentValue;
		$this->date_created->ViewValue = ew_FormatDateTime($this->date_created->ViewValue, 0);
		$this->date_created->ViewCustomAttributes = "";

		// time
		$this->time->ViewValue = $this->time->CurrentValue;
		$this->time->ViewValue = ew_FormatDateTime($this->time->ViewValue, 4);
		$this->time->ViewCustomAttributes = "";

		// staff_id
		$this->staff_id->ViewValue = $this->staff_id->CurrentValue;
		$this->staff_id->ViewCustomAttributes = "";

		// staff_name
		$this->staff_name->ViewValue = $this->staff_name->CurrentValue;
		$this->staff_name->ViewCustomAttributes = "";

		// company
		$this->company->ViewValue = $this->company->CurrentValue;
		$this->company->ViewCustomAttributes = "";

		// department
		$this->department->ViewValue = $this->department->CurrentValue;
		$this->department->ViewCustomAttributes = "";

		// leave_type
		$this->leave_type->ViewValue = $this->leave_type->CurrentValue;
		$this->leave_type->ViewCustomAttributes = "";

		// start_date
		$this->start_date->ViewValue = $this->start_date->CurrentValue;
		$this->start_date->ViewValue = ew_FormatDateTime($this->start_date->ViewValue, 0);
		$this->start_date->ViewCustomAttributes = "";

		// end_date
		$this->end_date->ViewValue = $this->end_date->CurrentValue;
		$this->end_date->ViewValue = ew_FormatDateTime($this->end_date->ViewValue, 0);
		$this->end_date->ViewCustomAttributes = "";

		// no_of_days
		$this->no_of_days->ViewValue = $this->no_of_days->CurrentValue;
		$this->no_of_days->ViewCustomAttributes = "";

		// resumption_date
		$this->resumption_date->ViewValue = $this->resumption_date->CurrentValue;
		$this->resumption_date->ViewValue = ew_FormatDateTime($this->resumption_date->ViewValue, 0);
		$this->resumption_date->ViewCustomAttributes = "";

		// replacement_assign_staff
		$this->replacement_assign_staff->ViewValue = $this->replacement_assign_staff->CurrentValue;
		$this->replacement_assign_staff->ViewCustomAttributes = "";

		// purpose_of_leave
		$this->purpose_of_leave->ViewValue = $this->purpose_of_leave->CurrentValue;
		$this->purpose_of_leave->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

			// leave_id
			$this->leave_id->LinkCustomAttributes = "";
			$this->leave_id->HrefValue = "";
			$this->leave_id->TooltipValue = "";

			// date_created
			$this->date_created->LinkCustomAttributes = "";
			$this->date_created->HrefValue = "";
			$this->date_created->TooltipValue = "";

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

			// replacement_assign_staff
			$this->replacement_assign_staff->LinkCustomAttributes = "";
			$this->replacement_assign_staff->HrefValue = "";
			$this->replacement_assign_staff->TooltipValue = "";

			// purpose_of_leave
			$this->purpose_of_leave->LinkCustomAttributes = "";
			$this->purpose_of_leave->HrefValue = "";
			$this->purpose_of_leave->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// leave_id
			$this->leave_id->EditAttrs["class"] = "form-control";
			$this->leave_id->EditCustomAttributes = "";
			$this->leave_id->EditValue = ew_HtmlEncode($this->leave_id->AdvancedSearch->SearchValue);
			$this->leave_id->PlaceHolder = ew_RemoveHtml($this->leave_id->FldCaption());

			// date_created
			$this->date_created->EditAttrs["class"] = "form-control";
			$this->date_created->EditCustomAttributes = "";
			$this->date_created->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->date_created->AdvancedSearch->SearchValue, 0), 8));
			$this->date_created->PlaceHolder = ew_RemoveHtml($this->date_created->FldCaption());

			// time
			$this->time->EditAttrs["class"] = "form-control";
			$this->time->EditCustomAttributes = "";
			$this->time->EditValue = ew_HtmlEncode(ew_UnFormatDateTime($this->time->AdvancedSearch->SearchValue, 4));
			$this->time->PlaceHolder = ew_RemoveHtml($this->time->FldCaption());

			// staff_id
			$this->staff_id->EditAttrs["class"] = "form-control";
			$this->staff_id->EditCustomAttributes = "";
			$this->staff_id->EditValue = ew_HtmlEncode($this->staff_id->AdvancedSearch->SearchValue);
			$this->staff_id->PlaceHolder = ew_RemoveHtml($this->staff_id->FldCaption());

			// staff_name
			$this->staff_name->EditAttrs["class"] = "form-control";
			$this->staff_name->EditCustomAttributes = "";
			$this->staff_name->EditValue = ew_HtmlEncode($this->staff_name->AdvancedSearch->SearchValue);
			$this->staff_name->PlaceHolder = ew_RemoveHtml($this->staff_name->FldCaption());

			// company
			$this->company->EditAttrs["class"] = "form-control";
			$this->company->EditCustomAttributes = "";
			$this->company->EditValue = ew_HtmlEncode($this->company->AdvancedSearch->SearchValue);
			$this->company->PlaceHolder = ew_RemoveHtml($this->company->FldCaption());

			// department
			$this->department->EditAttrs["class"] = "form-control";
			$this->department->EditCustomAttributes = "";
			$this->department->EditValue = ew_HtmlEncode($this->department->AdvancedSearch->SearchValue);
			$this->department->PlaceHolder = ew_RemoveHtml($this->department->FldCaption());

			// leave_type
			$this->leave_type->EditAttrs["class"] = "form-control";
			$this->leave_type->EditCustomAttributes = "";
			$this->leave_type->EditValue = ew_HtmlEncode($this->leave_type->AdvancedSearch->SearchValue);
			$this->leave_type->PlaceHolder = ew_RemoveHtml($this->leave_type->FldCaption());

			// start_date
			$this->start_date->EditAttrs["class"] = "form-control";
			$this->start_date->EditCustomAttributes = "";
			$this->start_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->start_date->AdvancedSearch->SearchValue, 0), 8));
			$this->start_date->PlaceHolder = ew_RemoveHtml($this->start_date->FldCaption());

			// end_date
			$this->end_date->EditAttrs["class"] = "form-control";
			$this->end_date->EditCustomAttributes = "";
			$this->end_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->end_date->AdvancedSearch->SearchValue, 0), 8));
			$this->end_date->PlaceHolder = ew_RemoveHtml($this->end_date->FldCaption());

			// no_of_days
			$this->no_of_days->EditAttrs["class"] = "form-control";
			$this->no_of_days->EditCustomAttributes = "";
			$this->no_of_days->EditValue = ew_HtmlEncode($this->no_of_days->AdvancedSearch->SearchValue);
			$this->no_of_days->PlaceHolder = ew_RemoveHtml($this->no_of_days->FldCaption());

			// resumption_date
			$this->resumption_date->EditAttrs["class"] = "form-control";
			$this->resumption_date->EditCustomAttributes = "";
			$this->resumption_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->resumption_date->AdvancedSearch->SearchValue, 0), 8));
			$this->resumption_date->PlaceHolder = ew_RemoveHtml($this->resumption_date->FldCaption());

			// replacement_assign_staff
			$this->replacement_assign_staff->EditAttrs["class"] = "form-control";
			$this->replacement_assign_staff->EditCustomAttributes = "";
			$this->replacement_assign_staff->EditValue = ew_HtmlEncode($this->replacement_assign_staff->AdvancedSearch->SearchValue);
			$this->replacement_assign_staff->PlaceHolder = ew_RemoveHtml($this->replacement_assign_staff->FldCaption());

			// purpose_of_leave
			$this->purpose_of_leave->EditAttrs["class"] = "form-control";
			$this->purpose_of_leave->EditCustomAttributes = "";
			$this->purpose_of_leave->EditValue = ew_HtmlEncode($this->purpose_of_leave->AdvancedSearch->SearchValue);
			$this->purpose_of_leave->PlaceHolder = ew_RemoveHtml($this->purpose_of_leave->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = ew_HtmlEncode($this->status->AdvancedSearch->SearchValue);
			$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckDateDef($this->date_created->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->date_created->FldErrMsg());
		}
		if (!ew_CheckTime($this->time->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->time->FldErrMsg());
		}
		if (!ew_CheckInteger($this->department->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->department->FldErrMsg());
		}
		if (!ew_CheckInteger($this->leave_type->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->leave_type->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->start_date->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->start_date->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->end_date->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->end_date->FldErrMsg());
		}
		if (!ew_CheckInteger($this->no_of_days->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->no_of_days->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->resumption_date->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->resumption_date->FldErrMsg());
		}
		if (!ew_CheckInteger($this->status->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->status->FldErrMsg());
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->leave_id->AdvancedSearch->Load();
		$this->date_created->AdvancedSearch->Load();
		$this->time->AdvancedSearch->Load();
		$this->staff_id->AdvancedSearch->Load();
		$this->staff_name->AdvancedSearch->Load();
		$this->company->AdvancedSearch->Load();
		$this->department->AdvancedSearch->Load();
		$this->leave_type->AdvancedSearch->Load();
		$this->start_date->AdvancedSearch->Load();
		$this->end_date->AdvancedSearch->Load();
		$this->no_of_days->AdvancedSearch->Load();
		$this->resumption_date->AdvancedSearch->Load();
		$this->replacement_assign_staff->AdvancedSearch->Load();
		$this->purpose_of_leave->AdvancedSearch->Load();
		$this->status->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("reportlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($report_search)) $report_search = new creport_search();

// Page init
$report_search->Page_Init();

// Page main
$report_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$report_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($report_search->IsModal) { ?>
var CurrentAdvancedSearchForm = freportsearch = new ew_Form("freportsearch", "search");
<?php } else { ?>
var CurrentForm = freportsearch = new ew_Form("freportsearch", "search");
<?php } ?>

// Form_CustomValidate event
freportsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
freportsearch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search
// Validate function for search

freportsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_date_created");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($report->date_created->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_time");
	if (elm && !ew_CheckTime(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($report->time->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_department");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($report->department->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_leave_type");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($report->leave_type->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_start_date");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($report->start_date->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_end_date");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($report->end_date->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_no_of_days");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($report->no_of_days->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_resumption_date");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($report->resumption_date->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_status");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($report->status->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $report_search->ShowPageHeader(); ?>
<?php
$report_search->ShowMessage();
?>
<form name="freportsearch" id="freportsearch" class="<?php echo $report_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($report_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $report_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="report">
<input type="hidden" name="a_search" id="a_search" value="S">
<input type="hidden" name="modal" value="<?php echo intval($report_search->IsModal) ?>">
<div class="ewSearchDiv"><!-- page* -->
<?php if ($report->leave_id->Visible) { // leave_id ?>
	<div id="r_leave_id" class="form-group">
		<label for="x_leave_id" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_leave_id"><?php echo $report->leave_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_leave_id" id="z_leave_id" value="LIKE"></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->leave_id->CellAttributes() ?>>
			<span id="el_report_leave_id">
<input type="text" data-table="report" data-field="x_leave_id" name="x_leave_id" id="x_leave_id" size="30" maxlength="14" placeholder="<?php echo ew_HtmlEncode($report->leave_id->getPlaceHolder()) ?>" value="<?php echo $report->leave_id->EditValue ?>"<?php echo $report->leave_id->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->date_created->Visible) { // date_created ?>
	<div id="r_date_created" class="form-group">
		<label for="x_date_created" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_date_created"><?php echo $report->date_created->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_date_created" id="z_date_created" value="="></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->date_created->CellAttributes() ?>>
			<span id="el_report_date_created">
<input type="text" data-table="report" data-field="x_date_created" name="x_date_created" id="x_date_created" placeholder="<?php echo ew_HtmlEncode($report->date_created->getPlaceHolder()) ?>" value="<?php echo $report->date_created->EditValue ?>"<?php echo $report->date_created->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->time->Visible) { // time ?>
	<div id="r_time" class="form-group">
		<label for="x_time" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_time"><?php echo $report->time->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_time" id="z_time" value="="></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->time->CellAttributes() ?>>
			<span id="el_report_time">
<input type="text" data-table="report" data-field="x_time" name="x_time" id="x_time" placeholder="<?php echo ew_HtmlEncode($report->time->getPlaceHolder()) ?>" value="<?php echo $report->time->EditValue ?>"<?php echo $report->time->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->staff_id->Visible) { // staff_id ?>
	<div id="r_staff_id" class="form-group">
		<label for="x_staff_id" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_staff_id"><?php echo $report->staff_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_staff_id" id="z_staff_id" value="LIKE"></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->staff_id->CellAttributes() ?>>
			<span id="el_report_staff_id">
<input type="text" data-table="report" data-field="x_staff_id" name="x_staff_id" id="x_staff_id" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($report->staff_id->getPlaceHolder()) ?>" value="<?php echo $report->staff_id->EditValue ?>"<?php echo $report->staff_id->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->staff_name->Visible) { // staff_name ?>
	<div id="r_staff_name" class="form-group">
		<label for="x_staff_name" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_staff_name"><?php echo $report->staff_name->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_staff_name" id="z_staff_name" value="LIKE"></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->staff_name->CellAttributes() ?>>
			<span id="el_report_staff_name">
<input type="text" data-table="report" data-field="x_staff_name" name="x_staff_name" id="x_staff_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($report->staff_name->getPlaceHolder()) ?>" value="<?php echo $report->staff_name->EditValue ?>"<?php echo $report->staff_name->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->company->Visible) { // company ?>
	<div id="r_company" class="form-group">
		<label for="x_company" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_company"><?php echo $report->company->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_company" id="z_company" value="LIKE"></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->company->CellAttributes() ?>>
			<span id="el_report_company">
<input type="text" data-table="report" data-field="x_company" name="x_company" id="x_company" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($report->company->getPlaceHolder()) ?>" value="<?php echo $report->company->EditValue ?>"<?php echo $report->company->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->department->Visible) { // department ?>
	<div id="r_department" class="form-group">
		<label for="x_department" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_department"><?php echo $report->department->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_department" id="z_department" value="="></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->department->CellAttributes() ?>>
			<span id="el_report_department">
<input type="text" data-table="report" data-field="x_department" name="x_department" id="x_department" size="30" placeholder="<?php echo ew_HtmlEncode($report->department->getPlaceHolder()) ?>" value="<?php echo $report->department->EditValue ?>"<?php echo $report->department->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->leave_type->Visible) { // leave_type ?>
	<div id="r_leave_type" class="form-group">
		<label for="x_leave_type" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_leave_type"><?php echo $report->leave_type->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_leave_type" id="z_leave_type" value="="></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->leave_type->CellAttributes() ?>>
			<span id="el_report_leave_type">
<input type="text" data-table="report" data-field="x_leave_type" name="x_leave_type" id="x_leave_type" size="30" placeholder="<?php echo ew_HtmlEncode($report->leave_type->getPlaceHolder()) ?>" value="<?php echo $report->leave_type->EditValue ?>"<?php echo $report->leave_type->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->start_date->Visible) { // start_date ?>
	<div id="r_start_date" class="form-group">
		<label for="x_start_date" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_start_date"><?php echo $report->start_date->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_start_date" id="z_start_date" value="="></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->start_date->CellAttributes() ?>>
			<span id="el_report_start_date">
<input type="text" data-table="report" data-field="x_start_date" name="x_start_date" id="x_start_date" placeholder="<?php echo ew_HtmlEncode($report->start_date->getPlaceHolder()) ?>" value="<?php echo $report->start_date->EditValue ?>"<?php echo $report->start_date->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->end_date->Visible) { // end_date ?>
	<div id="r_end_date" class="form-group">
		<label for="x_end_date" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_end_date"><?php echo $report->end_date->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_end_date" id="z_end_date" value="="></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->end_date->CellAttributes() ?>>
			<span id="el_report_end_date">
<input type="text" data-table="report" data-field="x_end_date" name="x_end_date" id="x_end_date" placeholder="<?php echo ew_HtmlEncode($report->end_date->getPlaceHolder()) ?>" value="<?php echo $report->end_date->EditValue ?>"<?php echo $report->end_date->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->no_of_days->Visible) { // no_of_days ?>
	<div id="r_no_of_days" class="form-group">
		<label for="x_no_of_days" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_no_of_days"><?php echo $report->no_of_days->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_no_of_days" id="z_no_of_days" value="="></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->no_of_days->CellAttributes() ?>>
			<span id="el_report_no_of_days">
<input type="text" data-table="report" data-field="x_no_of_days" name="x_no_of_days" id="x_no_of_days" size="30" placeholder="<?php echo ew_HtmlEncode($report->no_of_days->getPlaceHolder()) ?>" value="<?php echo $report->no_of_days->EditValue ?>"<?php echo $report->no_of_days->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->resumption_date->Visible) { // resumption_date ?>
	<div id="r_resumption_date" class="form-group">
		<label for="x_resumption_date" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_resumption_date"><?php echo $report->resumption_date->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_resumption_date" id="z_resumption_date" value="="></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->resumption_date->CellAttributes() ?>>
			<span id="el_report_resumption_date">
<input type="text" data-table="report" data-field="x_resumption_date" name="x_resumption_date" id="x_resumption_date" placeholder="<?php echo ew_HtmlEncode($report->resumption_date->getPlaceHolder()) ?>" value="<?php echo $report->resumption_date->EditValue ?>"<?php echo $report->resumption_date->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->replacement_assign_staff->Visible) { // replacement_assign_staff ?>
	<div id="r_replacement_assign_staff" class="form-group">
		<label for="x_replacement_assign_staff" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_replacement_assign_staff"><?php echo $report->replacement_assign_staff->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_replacement_assign_staff" id="z_replacement_assign_staff" value="LIKE"></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->replacement_assign_staff->CellAttributes() ?>>
			<span id="el_report_replacement_assign_staff">
<input type="text" data-table="report" data-field="x_replacement_assign_staff" name="x_replacement_assign_staff" id="x_replacement_assign_staff" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($report->replacement_assign_staff->getPlaceHolder()) ?>" value="<?php echo $report->replacement_assign_staff->EditValue ?>"<?php echo $report->replacement_assign_staff->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->purpose_of_leave->Visible) { // purpose_of_leave ?>
	<div id="r_purpose_of_leave" class="form-group">
		<label for="x_purpose_of_leave" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_purpose_of_leave"><?php echo $report->purpose_of_leave->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_purpose_of_leave" id="z_purpose_of_leave" value="LIKE"></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->purpose_of_leave->CellAttributes() ?>>
			<span id="el_report_purpose_of_leave">
<input type="text" data-table="report" data-field="x_purpose_of_leave" name="x_purpose_of_leave" id="x_purpose_of_leave" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($report->purpose_of_leave->getPlaceHolder()) ?>" value="<?php echo $report->purpose_of_leave->EditValue ?>"<?php echo $report->purpose_of_leave->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($report->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label for="x_status" class="<?php echo $report_search->LeftColumnClass ?>"><span id="elh_report_status"><?php echo $report->status->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_status" id="z_status" value="="></p>
		</label>
		<div class="<?php echo $report_search->RightColumnClass ?>"><div<?php echo $report->status->CellAttributes() ?>>
			<span id="el_report_status">
<input type="text" data-table="report" data-field="x_status" name="x_status" id="x_status" size="30" placeholder="<?php echo ew_HtmlEncode($report->status->getPlaceHolder()) ?>" value="<?php echo $report->status->EditValue ?>"<?php echo $report->status->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$report_search->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $report_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
freportsearch.Init();
</script>
<?php
$report_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$report_search->Page_Terminate();
?>
