<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "user_profileinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$user_profile_delete = NULL; // Initialize page object first

class cuser_profile_delete extends cuser_profile {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'user_profile';

	// Page object name
	var $PageObjName = 'user_profile_delete';

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

		// Table object (user_profile)
		if (!isset($GLOBALS["user_profile"]) || get_class($GLOBALS["user_profile"]) == "cuser_profile") {
			$GLOBALS["user_profile"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["user_profile"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'user_profile', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("user_profilelist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("user_profilelist.php"));
			}
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->staff_id->SetVisibility();
		$this->last_name->SetVisibility();
		$this->first_name->SetVisibility();
		$this->_email->SetVisibility();
		$this->gender->SetVisibility();
		$this->marital_status->SetVisibility();
		$this->date_of_birth->SetVisibility();
		$this->username->SetVisibility();
		$this->mobile->SetVisibility();
		$this->company->SetVisibility();
		$this->department->SetVisibility();
		$this->home_address->SetVisibility();
		$this->town_city->SetVisibility();
		$this->state_origin->SetVisibility();
		$this->local_gra->SetVisibility();
		$this->next_kin->SetVisibility();
		$this->resident_nxt_kin->SetVisibility();
		$this->nearest_bus_stop->SetVisibility();
		$this->town_city_nxt_kin->SetVisibility();
		$this->email_nxt_kin->SetVisibility();
		$this->phone_nxt_kin->SetVisibility();
		$this->qualification_level->SetVisibility();
		$this->qualification_grade->SetVisibility();
		$this->upload_of_credentcial->SetVisibility();
		$this->password->SetVisibility();
		$this->accesslevel->SetVisibility();
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
		global $EW_EXPORT, $user_profile;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($user_profile);
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
			$this->Page_Terminate("user_profilelist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in user_profile class, user_profileinfo.php

		$this->CurrentFilter = $sFilter;

		// Check if valid user id
		$conn = &$this->Connection();
		$sql = $this->GetSQL($this->CurrentFilter, "");
		if ($this->Recordset = ew_LoadRecordset($sql, $conn)) {
			$res = TRUE;
			while (!$this->Recordset->EOF) {
				$this->LoadRowValues($this->Recordset);
				if (!$this->ShowOptionLink('delete')) {
					$sUserIdMsg = $Language->Phrase("NoDeletePermission");
					$this->setFailureMessage($sUserIdMsg);
					$res = FALSE;
					break;
				}
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
			if (!$res) $this->Page_Terminate("user_profilelist.php"); // Return to list
		}

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
				$this->Page_Terminate("user_profilelist.php"); // Return to list
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
		$this->staff_id->setDbValue($row['staff_id']);
		$this->last_name->setDbValue($row['last_name']);
		$this->first_name->setDbValue($row['first_name']);
		$this->_email->setDbValue($row['email']);
		$this->gender->setDbValue($row['gender']);
		$this->marital_status->setDbValue($row['marital_status']);
		$this->date_of_birth->setDbValue($row['date_of_birth']);
		$this->username->setDbValue($row['username']);
		$this->mobile->setDbValue($row['mobile']);
		$this->company->setDbValue($row['company']);
		$this->department->setDbValue($row['department']);
		$this->home_address->setDbValue($row['home_address']);
		$this->town_city->setDbValue($row['town_city']);
		$this->state_origin->setDbValue($row['state_origin']);
		$this->local_gra->setDbValue($row['local_gra']);
		$this->next_kin->setDbValue($row['next_kin']);
		$this->resident_nxt_kin->setDbValue($row['resident_nxt_kin']);
		$this->nearest_bus_stop->setDbValue($row['nearest_bus_stop']);
		$this->town_city_nxt_kin->setDbValue($row['town_city_nxt_kin']);
		$this->email_nxt_kin->setDbValue($row['email_nxt_kin']);
		$this->phone_nxt_kin->setDbValue($row['phone_nxt_kin']);
		$this->qualification_level->setDbValue($row['qualification_level']);
		$this->qualification_grade->setDbValue($row['qualification_grade']);
		$this->upload_of_credentcial->Upload->DbValue = $row['upload_of_credentcial'];
		$this->upload_of_credentcial->setDbValue($this->upload_of_credentcial->Upload->DbValue);
		$this->password->setDbValue($row['password']);
		$this->accesslevel->setDbValue($row['accesslevel']);
		$this->status->setDbValue($row['status']);
		$this->profile->setDbValue($row['profile']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['staff_id'] = NULL;
		$row['last_name'] = NULL;
		$row['first_name'] = NULL;
		$row['email'] = NULL;
		$row['gender'] = NULL;
		$row['marital_status'] = NULL;
		$row['date_of_birth'] = NULL;
		$row['username'] = NULL;
		$row['mobile'] = NULL;
		$row['company'] = NULL;
		$row['department'] = NULL;
		$row['home_address'] = NULL;
		$row['town_city'] = NULL;
		$row['state_origin'] = NULL;
		$row['local_gra'] = NULL;
		$row['next_kin'] = NULL;
		$row['resident_nxt_kin'] = NULL;
		$row['nearest_bus_stop'] = NULL;
		$row['town_city_nxt_kin'] = NULL;
		$row['email_nxt_kin'] = NULL;
		$row['phone_nxt_kin'] = NULL;
		$row['qualification_level'] = NULL;
		$row['qualification_grade'] = NULL;
		$row['upload_of_credentcial'] = NULL;
		$row['password'] = NULL;
		$row['accesslevel'] = NULL;
		$row['status'] = NULL;
		$row['profile'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->staff_id->DbValue = $row['staff_id'];
		$this->last_name->DbValue = $row['last_name'];
		$this->first_name->DbValue = $row['first_name'];
		$this->_email->DbValue = $row['email'];
		$this->gender->DbValue = $row['gender'];
		$this->marital_status->DbValue = $row['marital_status'];
		$this->date_of_birth->DbValue = $row['date_of_birth'];
		$this->username->DbValue = $row['username'];
		$this->mobile->DbValue = $row['mobile'];
		$this->company->DbValue = $row['company'];
		$this->department->DbValue = $row['department'];
		$this->home_address->DbValue = $row['home_address'];
		$this->town_city->DbValue = $row['town_city'];
		$this->state_origin->DbValue = $row['state_origin'];
		$this->local_gra->DbValue = $row['local_gra'];
		$this->next_kin->DbValue = $row['next_kin'];
		$this->resident_nxt_kin->DbValue = $row['resident_nxt_kin'];
		$this->nearest_bus_stop->DbValue = $row['nearest_bus_stop'];
		$this->town_city_nxt_kin->DbValue = $row['town_city_nxt_kin'];
		$this->email_nxt_kin->DbValue = $row['email_nxt_kin'];
		$this->phone_nxt_kin->DbValue = $row['phone_nxt_kin'];
		$this->qualification_level->DbValue = $row['qualification_level'];
		$this->qualification_grade->DbValue = $row['qualification_grade'];
		$this->upload_of_credentcial->Upload->DbValue = $row['upload_of_credentcial'];
		$this->password->DbValue = $row['password'];
		$this->accesslevel->DbValue = $row['accesslevel'];
		$this->status->DbValue = $row['status'];
		$this->profile->DbValue = $row['profile'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// staff_id
		// last_name
		// first_name
		// email
		// gender
		// marital_status
		// date_of_birth
		// username
		// mobile
		// company
		// department
		// home_address
		// town_city
		// state_origin
		// local_gra
		// next_kin
		// resident_nxt_kin
		// nearest_bus_stop
		// town_city_nxt_kin
		// email_nxt_kin
		// phone_nxt_kin
		// qualification_level
		// qualification_grade
		// upload_of_credentcial
		// password
		// accesslevel
		// status
		// profile

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// staff_id
		$this->staff_id->ViewValue = $this->staff_id->CurrentValue;
		$this->staff_id->ViewCustomAttributes = "";

		// last_name
		$this->last_name->ViewValue = $this->last_name->CurrentValue;
		$this->last_name->ViewCustomAttributes = "";

		// first_name
		$this->first_name->ViewValue = $this->first_name->CurrentValue;
		$this->first_name->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// gender
		if (strval($this->gender->CurrentValue) <> "") {
			$this->gender->ViewValue = $this->gender->OptionCaption($this->gender->CurrentValue);
		} else {
			$this->gender->ViewValue = NULL;
		}
		$this->gender->ViewCustomAttributes = "";

		// marital_status
		if (strval($this->marital_status->CurrentValue) <> "") {
			$this->marital_status->ViewValue = $this->marital_status->OptionCaption($this->marital_status->CurrentValue);
		} else {
			$this->marital_status->ViewValue = NULL;
		}
		$this->marital_status->ViewCustomAttributes = "";

		// date_of_birth
		$this->date_of_birth->ViewValue = $this->date_of_birth->CurrentValue;
		$this->date_of_birth->ViewValue = ew_FormatDateTime($this->date_of_birth->ViewValue, 7);
		$this->date_of_birth->ViewCustomAttributes = "";

		// username
		$this->username->ViewValue = $this->username->CurrentValue;
		$this->username->ViewCustomAttributes = "";

		// mobile
		$this->mobile->ViewValue = $this->mobile->CurrentValue;
		$this->mobile->ViewCustomAttributes = "";

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
		$this->department->LookupFilters = array("dx1" => '`description`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->department, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `description` ASC";
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

		// home_address
		$this->home_address->ViewValue = $this->home_address->CurrentValue;
		$this->home_address->ViewCustomAttributes = "";

		// town_city
		if (strval($this->town_city->CurrentValue) <> "") {
			$sFilterWrk = "`code`" . ew_SearchString("=", $this->town_city->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `code`, `state_descriptions` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `states_table`";
		$sWhereWrk = "";
		$this->town_city->LookupFilters = array("dx1" => '`state_descriptions`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->town_city, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->town_city->ViewValue = $this->town_city->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->town_city->ViewValue = $this->town_city->CurrentValue;
			}
		} else {
			$this->town_city->ViewValue = NULL;
		}
		$this->town_city->ViewCustomAttributes = "";

		// state_origin
		if (strval($this->state_origin->CurrentValue) <> "") {
			$sFilterWrk = "`code`" . ew_SearchString("=", $this->state_origin->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `code`, `state_descriptions` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `states_table`";
		$sWhereWrk = "";
		$this->state_origin->LookupFilters = array("dx1" => '`state_descriptions`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->state_origin, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->state_origin->ViewValue = $this->state_origin->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->state_origin->ViewValue = $this->state_origin->CurrentValue;
			}
		} else {
			$this->state_origin->ViewValue = NULL;
		}
		$this->state_origin->ViewCustomAttributes = "";

		// local_gra
		if (strval($this->local_gra->CurrentValue) <> "") {
			$sFilterWrk = "`code`" . ew_SearchString("=", $this->local_gra->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `code`, `lga_descriptions` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lga_states`";
		$sWhereWrk = "";
		$this->local_gra->LookupFilters = array("dx1" => '`lga_descriptions`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->local_gra, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->local_gra->ViewValue = $this->local_gra->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->local_gra->ViewValue = $this->local_gra->CurrentValue;
			}
		} else {
			$this->local_gra->ViewValue = NULL;
		}
		$this->local_gra->ViewCustomAttributes = "";

		// next_kin
		$this->next_kin->ViewValue = $this->next_kin->CurrentValue;
		$this->next_kin->ViewCustomAttributes = "";

		// resident_nxt_kin
		$this->resident_nxt_kin->ViewValue = $this->resident_nxt_kin->CurrentValue;
		$this->resident_nxt_kin->ViewCustomAttributes = "";

		// nearest_bus_stop
		$this->nearest_bus_stop->ViewValue = $this->nearest_bus_stop->CurrentValue;
		$this->nearest_bus_stop->ViewCustomAttributes = "";

		// town_city_nxt_kin
		$this->town_city_nxt_kin->ViewValue = $this->town_city_nxt_kin->CurrentValue;
		$this->town_city_nxt_kin->ViewCustomAttributes = "";

		// email_nxt_kin
		$this->email_nxt_kin->ViewValue = $this->email_nxt_kin->CurrentValue;
		$this->email_nxt_kin->ViewCustomAttributes = "";

		// phone_nxt_kin
		$this->phone_nxt_kin->ViewValue = $this->phone_nxt_kin->CurrentValue;
		$this->phone_nxt_kin->ViewCustomAttributes = "";

		// qualification_level
		if (strval($this->qualification_level->CurrentValue) <> "") {
			$this->qualification_level->ViewValue = $this->qualification_level->OptionCaption($this->qualification_level->CurrentValue);
		} else {
			$this->qualification_level->ViewValue = NULL;
		}
		$this->qualification_level->ViewCustomAttributes = "";

		// qualification_grade
		if (strval($this->qualification_grade->CurrentValue) <> "") {
			$this->qualification_grade->ViewValue = $this->qualification_grade->OptionCaption($this->qualification_grade->CurrentValue);
		} else {
			$this->qualification_grade->ViewValue = NULL;
		}
		$this->qualification_grade->ViewCustomAttributes = "";

		// upload_of_credentcial
		$this->upload_of_credentcial->UploadPath = "uploads/";
		if (!ew_Empty($this->upload_of_credentcial->Upload->DbValue)) {
			$this->upload_of_credentcial->ViewValue = $this->upload_of_credentcial->Upload->DbValue;
		} else {
			$this->upload_of_credentcial->ViewValue = "";
		}
		$this->upload_of_credentcial->ViewCustomAttributes = "";

		// password
		$this->password->ViewValue = $Language->Phrase("PasswordMask");
		$this->password->ViewCustomAttributes = "";

		// accesslevel
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->accesslevel->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->accesslevel->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		$this->accesslevel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->accesslevel, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->accesslevel->ViewValue = $this->accesslevel->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->accesslevel->ViewValue = $this->accesslevel->CurrentValue;
			}
		} else {
			$this->accesslevel->ViewValue = NULL;
		}
		} else {
			$this->accesslevel->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->accesslevel->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// staff_id
			$this->staff_id->LinkCustomAttributes = "";
			$this->staff_id->HrefValue = "";
			$this->staff_id->TooltipValue = "";

			// last_name
			$this->last_name->LinkCustomAttributes = "";
			$this->last_name->HrefValue = "";
			$this->last_name->TooltipValue = "";

			// first_name
			$this->first_name->LinkCustomAttributes = "";
			$this->first_name->HrefValue = "";
			$this->first_name->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// marital_status
			$this->marital_status->LinkCustomAttributes = "";
			$this->marital_status->HrefValue = "";
			$this->marital_status->TooltipValue = "";

			// date_of_birth
			$this->date_of_birth->LinkCustomAttributes = "";
			$this->date_of_birth->HrefValue = "";
			$this->date_of_birth->TooltipValue = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";
			$this->username->TooltipValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";
			$this->mobile->TooltipValue = "";

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";
			$this->company->TooltipValue = "";

			// department
			$this->department->LinkCustomAttributes = "";
			$this->department->HrefValue = "";
			$this->department->TooltipValue = "";

			// home_address
			$this->home_address->LinkCustomAttributes = "";
			$this->home_address->HrefValue = "";
			$this->home_address->TooltipValue = "";

			// town_city
			$this->town_city->LinkCustomAttributes = "";
			$this->town_city->HrefValue = "";
			$this->town_city->TooltipValue = "";

			// state_origin
			$this->state_origin->LinkCustomAttributes = "";
			$this->state_origin->HrefValue = "";
			$this->state_origin->TooltipValue = "";

			// local_gra
			$this->local_gra->LinkCustomAttributes = "";
			$this->local_gra->HrefValue = "";
			$this->local_gra->TooltipValue = "";

			// next_kin
			$this->next_kin->LinkCustomAttributes = "";
			$this->next_kin->HrefValue = "";
			$this->next_kin->TooltipValue = "";

			// resident_nxt_kin
			$this->resident_nxt_kin->LinkCustomAttributes = "";
			$this->resident_nxt_kin->HrefValue = "";
			$this->resident_nxt_kin->TooltipValue = "";

			// nearest_bus_stop
			$this->nearest_bus_stop->LinkCustomAttributes = "";
			$this->nearest_bus_stop->HrefValue = "";
			$this->nearest_bus_stop->TooltipValue = "";

			// town_city_nxt_kin
			$this->town_city_nxt_kin->LinkCustomAttributes = "";
			$this->town_city_nxt_kin->HrefValue = "";
			$this->town_city_nxt_kin->TooltipValue = "";

			// email_nxt_kin
			$this->email_nxt_kin->LinkCustomAttributes = "";
			$this->email_nxt_kin->HrefValue = "";
			$this->email_nxt_kin->TooltipValue = "";

			// phone_nxt_kin
			$this->phone_nxt_kin->LinkCustomAttributes = "";
			$this->phone_nxt_kin->HrefValue = "";
			$this->phone_nxt_kin->TooltipValue = "";

			// qualification_level
			$this->qualification_level->LinkCustomAttributes = "";
			$this->qualification_level->HrefValue = "";
			$this->qualification_level->TooltipValue = "";

			// qualification_grade
			$this->qualification_grade->LinkCustomAttributes = "";
			$this->qualification_grade->HrefValue = "";
			$this->qualification_grade->TooltipValue = "";

			// upload_of_credentcial
			$this->upload_of_credentcial->LinkCustomAttributes = "";
			$this->upload_of_credentcial->HrefValue = "";
			$this->upload_of_credentcial->HrefValue2 = $this->upload_of_credentcial->UploadPath . $this->upload_of_credentcial->Upload->DbValue;
			$this->upload_of_credentcial->TooltipValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
			$this->password->TooltipValue = "";

			// accesslevel
			$this->accesslevel->LinkCustomAttributes = "";
			$this->accesslevel->HrefValue = "";
			$this->accesslevel->TooltipValue = "";

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

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->staff_id->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("user_profilelist.php"), "", $this->TableVar, TRUE);
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
if (!isset($user_profile_delete)) $user_profile_delete = new cuser_profile_delete();

// Page init
$user_profile_delete->Page_Init();

// Page main
$user_profile_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$user_profile_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fuser_profiledelete = new ew_Form("fuser_profiledelete", "delete");

// Form_CustomValidate event
fuser_profiledelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fuser_profiledelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuser_profiledelete.Lists["x_gender"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profiledelete.Lists["x_gender"].Options = <?php echo json_encode($user_profile_delete->gender->Options()) ?>;
fuser_profiledelete.Lists["x_marital_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profiledelete.Lists["x_marital_status"].Options = <?php echo json_encode($user_profile_delete->marital_status->Options()) ?>;
fuser_profiledelete.Lists["x_company"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":["x_department"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fuser_profiledelete.Lists["x_company"].Data = "<?php echo $user_profile_delete->company->LookupFilterQuery(FALSE, "delete") ?>";
fuser_profiledelete.Lists["x_department"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"department"};
fuser_profiledelete.Lists["x_department"].Data = "<?php echo $user_profile_delete->department->LookupFilterQuery(FALSE, "delete") ?>";
fuser_profiledelete.Lists["x_town_city"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_state_descriptions","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"states_table"};
fuser_profiledelete.Lists["x_town_city"].Data = "<?php echo $user_profile_delete->town_city->LookupFilterQuery(FALSE, "delete") ?>";
fuser_profiledelete.Lists["x_state_origin"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_state_descriptions","","",""],"ParentFields":[],"ChildFields":["x_local_gra"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"states_table"};
fuser_profiledelete.Lists["x_state_origin"].Data = "<?php echo $user_profile_delete->state_origin->LookupFilterQuery(FALSE, "delete") ?>";
fuser_profiledelete.Lists["x_local_gra"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_lga_descriptions","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"lga_states"};
fuser_profiledelete.Lists["x_local_gra"].Data = "<?php echo $user_profile_delete->local_gra->LookupFilterQuery(FALSE, "delete") ?>";
fuser_profiledelete.Lists["x_qualification_level"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profiledelete.Lists["x_qualification_level"].Options = <?php echo json_encode($user_profile_delete->qualification_level->Options()) ?>;
fuser_profiledelete.Lists["x_qualification_grade"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profiledelete.Lists["x_qualification_grade"].Options = <?php echo json_encode($user_profile_delete->qualification_grade->Options()) ?>;
fuser_profiledelete.Lists["x_accesslevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};
fuser_profiledelete.Lists["x_accesslevel"].Data = "<?php echo $user_profile_delete->accesslevel->LookupFilterQuery(FALSE, "delete") ?>";
fuser_profiledelete.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profiledelete.Lists["x_status"].Options = <?php echo json_encode($user_profile_delete->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $user_profile_delete->ShowPageHeader(); ?>
<?php
$user_profile_delete->ShowMessage();
?>
<form name="fuser_profiledelete" id="fuser_profiledelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($user_profile_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $user_profile_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="user_profile">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($user_profile_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($user_profile->id->Visible) { // id ?>
		<th class="<?php echo $user_profile->id->HeaderCellClass() ?>"><span id="elh_user_profile_id" class="user_profile_id"><?php echo $user_profile->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->staff_id->Visible) { // staff_id ?>
		<th class="<?php echo $user_profile->staff_id->HeaderCellClass() ?>"><span id="elh_user_profile_staff_id" class="user_profile_staff_id"><?php echo $user_profile->staff_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->last_name->Visible) { // last_name ?>
		<th class="<?php echo $user_profile->last_name->HeaderCellClass() ?>"><span id="elh_user_profile_last_name" class="user_profile_last_name"><?php echo $user_profile->last_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->first_name->Visible) { // first_name ?>
		<th class="<?php echo $user_profile->first_name->HeaderCellClass() ?>"><span id="elh_user_profile_first_name" class="user_profile_first_name"><?php echo $user_profile->first_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->_email->Visible) { // email ?>
		<th class="<?php echo $user_profile->_email->HeaderCellClass() ?>"><span id="elh_user_profile__email" class="user_profile__email"><?php echo $user_profile->_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->gender->Visible) { // gender ?>
		<th class="<?php echo $user_profile->gender->HeaderCellClass() ?>"><span id="elh_user_profile_gender" class="user_profile_gender"><?php echo $user_profile->gender->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->marital_status->Visible) { // marital_status ?>
		<th class="<?php echo $user_profile->marital_status->HeaderCellClass() ?>"><span id="elh_user_profile_marital_status" class="user_profile_marital_status"><?php echo $user_profile->marital_status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->date_of_birth->Visible) { // date_of_birth ?>
		<th class="<?php echo $user_profile->date_of_birth->HeaderCellClass() ?>"><span id="elh_user_profile_date_of_birth" class="user_profile_date_of_birth"><?php echo $user_profile->date_of_birth->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->username->Visible) { // username ?>
		<th class="<?php echo $user_profile->username->HeaderCellClass() ?>"><span id="elh_user_profile_username" class="user_profile_username"><?php echo $user_profile->username->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->mobile->Visible) { // mobile ?>
		<th class="<?php echo $user_profile->mobile->HeaderCellClass() ?>"><span id="elh_user_profile_mobile" class="user_profile_mobile"><?php echo $user_profile->mobile->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->company->Visible) { // company ?>
		<th class="<?php echo $user_profile->company->HeaderCellClass() ?>"><span id="elh_user_profile_company" class="user_profile_company"><?php echo $user_profile->company->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->department->Visible) { // department ?>
		<th class="<?php echo $user_profile->department->HeaderCellClass() ?>"><span id="elh_user_profile_department" class="user_profile_department"><?php echo $user_profile->department->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->home_address->Visible) { // home_address ?>
		<th class="<?php echo $user_profile->home_address->HeaderCellClass() ?>"><span id="elh_user_profile_home_address" class="user_profile_home_address"><?php echo $user_profile->home_address->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->town_city->Visible) { // town_city ?>
		<th class="<?php echo $user_profile->town_city->HeaderCellClass() ?>"><span id="elh_user_profile_town_city" class="user_profile_town_city"><?php echo $user_profile->town_city->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->state_origin->Visible) { // state_origin ?>
		<th class="<?php echo $user_profile->state_origin->HeaderCellClass() ?>"><span id="elh_user_profile_state_origin" class="user_profile_state_origin"><?php echo $user_profile->state_origin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->local_gra->Visible) { // local_gra ?>
		<th class="<?php echo $user_profile->local_gra->HeaderCellClass() ?>"><span id="elh_user_profile_local_gra" class="user_profile_local_gra"><?php echo $user_profile->local_gra->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->next_kin->Visible) { // next_kin ?>
		<th class="<?php echo $user_profile->next_kin->HeaderCellClass() ?>"><span id="elh_user_profile_next_kin" class="user_profile_next_kin"><?php echo $user_profile->next_kin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->resident_nxt_kin->Visible) { // resident_nxt_kin ?>
		<th class="<?php echo $user_profile->resident_nxt_kin->HeaderCellClass() ?>"><span id="elh_user_profile_resident_nxt_kin" class="user_profile_resident_nxt_kin"><?php echo $user_profile->resident_nxt_kin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->nearest_bus_stop->Visible) { // nearest_bus_stop ?>
		<th class="<?php echo $user_profile->nearest_bus_stop->HeaderCellClass() ?>"><span id="elh_user_profile_nearest_bus_stop" class="user_profile_nearest_bus_stop"><?php echo $user_profile->nearest_bus_stop->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->town_city_nxt_kin->Visible) { // town_city_nxt_kin ?>
		<th class="<?php echo $user_profile->town_city_nxt_kin->HeaderCellClass() ?>"><span id="elh_user_profile_town_city_nxt_kin" class="user_profile_town_city_nxt_kin"><?php echo $user_profile->town_city_nxt_kin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->email_nxt_kin->Visible) { // email_nxt_kin ?>
		<th class="<?php echo $user_profile->email_nxt_kin->HeaderCellClass() ?>"><span id="elh_user_profile_email_nxt_kin" class="user_profile_email_nxt_kin"><?php echo $user_profile->email_nxt_kin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->phone_nxt_kin->Visible) { // phone_nxt_kin ?>
		<th class="<?php echo $user_profile->phone_nxt_kin->HeaderCellClass() ?>"><span id="elh_user_profile_phone_nxt_kin" class="user_profile_phone_nxt_kin"><?php echo $user_profile->phone_nxt_kin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->qualification_level->Visible) { // qualification_level ?>
		<th class="<?php echo $user_profile->qualification_level->HeaderCellClass() ?>"><span id="elh_user_profile_qualification_level" class="user_profile_qualification_level"><?php echo $user_profile->qualification_level->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->qualification_grade->Visible) { // qualification_grade ?>
		<th class="<?php echo $user_profile->qualification_grade->HeaderCellClass() ?>"><span id="elh_user_profile_qualification_grade" class="user_profile_qualification_grade"><?php echo $user_profile->qualification_grade->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->upload_of_credentcial->Visible) { // upload_of_credentcial ?>
		<th class="<?php echo $user_profile->upload_of_credentcial->HeaderCellClass() ?>"><span id="elh_user_profile_upload_of_credentcial" class="user_profile_upload_of_credentcial"><?php echo $user_profile->upload_of_credentcial->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->password->Visible) { // password ?>
		<th class="<?php echo $user_profile->password->HeaderCellClass() ?>"><span id="elh_user_profile_password" class="user_profile_password"><?php echo $user_profile->password->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->accesslevel->Visible) { // accesslevel ?>
		<th class="<?php echo $user_profile->accesslevel->HeaderCellClass() ?>"><span id="elh_user_profile_accesslevel" class="user_profile_accesslevel"><?php echo $user_profile->accesslevel->FldCaption() ?></span></th>
<?php } ?>
<?php if ($user_profile->status->Visible) { // status ?>
		<th class="<?php echo $user_profile->status->HeaderCellClass() ?>"><span id="elh_user_profile_status" class="user_profile_status"><?php echo $user_profile->status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$user_profile_delete->RecCnt = 0;
$i = 0;
while (!$user_profile_delete->Recordset->EOF) {
	$user_profile_delete->RecCnt++;
	$user_profile_delete->RowCnt++;

	// Set row properties
	$user_profile->ResetAttrs();
	$user_profile->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$user_profile_delete->LoadRowValues($user_profile_delete->Recordset);

	// Render row
	$user_profile_delete->RenderRow();
?>
	<tr<?php echo $user_profile->RowAttributes() ?>>
<?php if ($user_profile->id->Visible) { // id ?>
		<td<?php echo $user_profile->id->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_id" class="user_profile_id">
<span<?php echo $user_profile->id->ViewAttributes() ?>>
<?php echo $user_profile->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->staff_id->Visible) { // staff_id ?>
		<td<?php echo $user_profile->staff_id->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_staff_id" class="user_profile_staff_id">
<span<?php echo $user_profile->staff_id->ViewAttributes() ?>>
<?php echo $user_profile->staff_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->last_name->Visible) { // last_name ?>
		<td<?php echo $user_profile->last_name->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_last_name" class="user_profile_last_name">
<span<?php echo $user_profile->last_name->ViewAttributes() ?>>
<?php echo $user_profile->last_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->first_name->Visible) { // first_name ?>
		<td<?php echo $user_profile->first_name->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_first_name" class="user_profile_first_name">
<span<?php echo $user_profile->first_name->ViewAttributes() ?>>
<?php echo $user_profile->first_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->_email->Visible) { // email ?>
		<td<?php echo $user_profile->_email->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile__email" class="user_profile__email">
<span<?php echo $user_profile->_email->ViewAttributes() ?>>
<?php echo $user_profile->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->gender->Visible) { // gender ?>
		<td<?php echo $user_profile->gender->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_gender" class="user_profile_gender">
<span<?php echo $user_profile->gender->ViewAttributes() ?>>
<?php echo $user_profile->gender->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->marital_status->Visible) { // marital_status ?>
		<td<?php echo $user_profile->marital_status->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_marital_status" class="user_profile_marital_status">
<span<?php echo $user_profile->marital_status->ViewAttributes() ?>>
<?php echo $user_profile->marital_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->date_of_birth->Visible) { // date_of_birth ?>
		<td<?php echo $user_profile->date_of_birth->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_date_of_birth" class="user_profile_date_of_birth">
<span<?php echo $user_profile->date_of_birth->ViewAttributes() ?>>
<?php echo $user_profile->date_of_birth->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->username->Visible) { // username ?>
		<td<?php echo $user_profile->username->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_username" class="user_profile_username">
<span<?php echo $user_profile->username->ViewAttributes() ?>>
<?php echo $user_profile->username->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->mobile->Visible) { // mobile ?>
		<td<?php echo $user_profile->mobile->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_mobile" class="user_profile_mobile">
<span<?php echo $user_profile->mobile->ViewAttributes() ?>>
<?php echo $user_profile->mobile->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->company->Visible) { // company ?>
		<td<?php echo $user_profile->company->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_company" class="user_profile_company">
<span<?php echo $user_profile->company->ViewAttributes() ?>>
<?php echo $user_profile->company->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->department->Visible) { // department ?>
		<td<?php echo $user_profile->department->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_department" class="user_profile_department">
<span<?php echo $user_profile->department->ViewAttributes() ?>>
<?php echo $user_profile->department->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->home_address->Visible) { // home_address ?>
		<td<?php echo $user_profile->home_address->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_home_address" class="user_profile_home_address">
<span<?php echo $user_profile->home_address->ViewAttributes() ?>>
<?php echo $user_profile->home_address->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->town_city->Visible) { // town_city ?>
		<td<?php echo $user_profile->town_city->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_town_city" class="user_profile_town_city">
<span<?php echo $user_profile->town_city->ViewAttributes() ?>>
<?php echo $user_profile->town_city->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->state_origin->Visible) { // state_origin ?>
		<td<?php echo $user_profile->state_origin->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_state_origin" class="user_profile_state_origin">
<span<?php echo $user_profile->state_origin->ViewAttributes() ?>>
<?php echo $user_profile->state_origin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->local_gra->Visible) { // local_gra ?>
		<td<?php echo $user_profile->local_gra->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_local_gra" class="user_profile_local_gra">
<span<?php echo $user_profile->local_gra->ViewAttributes() ?>>
<?php echo $user_profile->local_gra->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->next_kin->Visible) { // next_kin ?>
		<td<?php echo $user_profile->next_kin->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_next_kin" class="user_profile_next_kin">
<span<?php echo $user_profile->next_kin->ViewAttributes() ?>>
<?php echo $user_profile->next_kin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->resident_nxt_kin->Visible) { // resident_nxt_kin ?>
		<td<?php echo $user_profile->resident_nxt_kin->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_resident_nxt_kin" class="user_profile_resident_nxt_kin">
<span<?php echo $user_profile->resident_nxt_kin->ViewAttributes() ?>>
<?php echo $user_profile->resident_nxt_kin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->nearest_bus_stop->Visible) { // nearest_bus_stop ?>
		<td<?php echo $user_profile->nearest_bus_stop->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_nearest_bus_stop" class="user_profile_nearest_bus_stop">
<span<?php echo $user_profile->nearest_bus_stop->ViewAttributes() ?>>
<?php echo $user_profile->nearest_bus_stop->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->town_city_nxt_kin->Visible) { // town_city_nxt_kin ?>
		<td<?php echo $user_profile->town_city_nxt_kin->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_town_city_nxt_kin" class="user_profile_town_city_nxt_kin">
<span<?php echo $user_profile->town_city_nxt_kin->ViewAttributes() ?>>
<?php echo $user_profile->town_city_nxt_kin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->email_nxt_kin->Visible) { // email_nxt_kin ?>
		<td<?php echo $user_profile->email_nxt_kin->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_email_nxt_kin" class="user_profile_email_nxt_kin">
<span<?php echo $user_profile->email_nxt_kin->ViewAttributes() ?>>
<?php echo $user_profile->email_nxt_kin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->phone_nxt_kin->Visible) { // phone_nxt_kin ?>
		<td<?php echo $user_profile->phone_nxt_kin->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_phone_nxt_kin" class="user_profile_phone_nxt_kin">
<span<?php echo $user_profile->phone_nxt_kin->ViewAttributes() ?>>
<?php echo $user_profile->phone_nxt_kin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->qualification_level->Visible) { // qualification_level ?>
		<td<?php echo $user_profile->qualification_level->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_qualification_level" class="user_profile_qualification_level">
<span<?php echo $user_profile->qualification_level->ViewAttributes() ?>>
<?php echo $user_profile->qualification_level->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->qualification_grade->Visible) { // qualification_grade ?>
		<td<?php echo $user_profile->qualification_grade->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_qualification_grade" class="user_profile_qualification_grade">
<span<?php echo $user_profile->qualification_grade->ViewAttributes() ?>>
<?php echo $user_profile->qualification_grade->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->upload_of_credentcial->Visible) { // upload_of_credentcial ?>
		<td<?php echo $user_profile->upload_of_credentcial->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_upload_of_credentcial" class="user_profile_upload_of_credentcial">
<span<?php echo $user_profile->upload_of_credentcial->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($user_profile->upload_of_credentcial, $user_profile->upload_of_credentcial->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->password->Visible) { // password ?>
		<td<?php echo $user_profile->password->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_password" class="user_profile_password">
<span<?php echo $user_profile->password->ViewAttributes() ?>>
<?php echo $user_profile->password->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->accesslevel->Visible) { // accesslevel ?>
		<td<?php echo $user_profile->accesslevel->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_accesslevel" class="user_profile_accesslevel">
<span<?php echo $user_profile->accesslevel->ViewAttributes() ?>>
<?php echo $user_profile->accesslevel->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($user_profile->status->Visible) { // status ?>
		<td<?php echo $user_profile->status->CellAttributes() ?>>
<span id="el<?php echo $user_profile_delete->RowCnt ?>_user_profile_status" class="user_profile_status">
<span<?php echo $user_profile->status->ViewAttributes() ?>>
<?php echo $user_profile->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$user_profile_delete->Recordset->MoveNext();
}
$user_profile_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $user_profile_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fuser_profiledelete.Init();
</script>
<?php
$user_profile_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$user_profile_delete->Page_Terminate();
?>
