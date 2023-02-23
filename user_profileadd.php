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

$user_profile_add = NULL; // Initialize page object first

class cuser_profile_add extends cuser_profile {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'user_profile';

	// Page object name
	var $PageObjName = 'user_profile_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->staff_id->SetVisibility();
		$this->last_name->SetVisibility();
		$this->first_name->SetVisibility();
		$this->gender->SetVisibility();
		$this->date_of_birth->SetVisibility();
		$this->_email->SetVisibility();
		$this->mobile->SetVisibility();
		$this->company->SetVisibility();
		$this->department->SetVisibility();
		$this->username->SetVisibility();
		$this->password->SetVisibility();
		$this->accesslevel->SetVisibility();
		$this->status->SetVisibility();
		$this->profile->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "user_profileview.php")
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("user_profilelist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "user_profilelist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "user_profileview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render view type
		} else {
			$this->RowType = EW_ROWTYPE_ADD; // Render add type
		}

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->staff_id->CurrentValue = NULL;
		$this->staff_id->OldValue = $this->staff_id->CurrentValue;
		$this->last_name->CurrentValue = NULL;
		$this->last_name->OldValue = $this->last_name->CurrentValue;
		$this->first_name->CurrentValue = NULL;
		$this->first_name->OldValue = $this->first_name->CurrentValue;
		$this->gender->CurrentValue = NULL;
		$this->gender->OldValue = $this->gender->CurrentValue;
		$this->date_of_birth->CurrentValue = NULL;
		$this->date_of_birth->OldValue = $this->date_of_birth->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->mobile->CurrentValue = NULL;
		$this->mobile->OldValue = $this->mobile->CurrentValue;
		$this->company->CurrentValue = NULL;
		$this->company->OldValue = $this->company->CurrentValue;
		$this->department->CurrentValue = NULL;
		$this->department->OldValue = $this->department->CurrentValue;
		$this->username->CurrentValue = NULL;
		$this->username->OldValue = $this->username->CurrentValue;
		$this->password->CurrentValue = NULL;
		$this->password->OldValue = $this->password->CurrentValue;
		$this->accesslevel->CurrentValue = NULL;
		$this->accesslevel->OldValue = $this->accesslevel->CurrentValue;
		$this->status->CurrentValue = 0;
		$this->profile->CurrentValue = NULL;
		$this->profile->OldValue = $this->profile->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->staff_id->FldIsDetailKey) {
			$this->staff_id->setFormValue($objForm->GetValue("x_staff_id"));
		}
		if (!$this->last_name->FldIsDetailKey) {
			$this->last_name->setFormValue($objForm->GetValue("x_last_name"));
		}
		if (!$this->first_name->FldIsDetailKey) {
			$this->first_name->setFormValue($objForm->GetValue("x_first_name"));
		}
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		if (!$this->date_of_birth->FldIsDetailKey) {
			$this->date_of_birth->setFormValue($objForm->GetValue("x_date_of_birth"));
			$this->date_of_birth->CurrentValue = ew_UnFormatDateTime($this->date_of_birth->CurrentValue, 7);
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->mobile->FldIsDetailKey) {
			$this->mobile->setFormValue($objForm->GetValue("x_mobile"));
		}
		if (!$this->company->FldIsDetailKey) {
			$this->company->setFormValue($objForm->GetValue("x_company"));
		}
		if (!$this->department->FldIsDetailKey) {
			$this->department->setFormValue($objForm->GetValue("x_department"));
		}
		if (!$this->username->FldIsDetailKey) {
			$this->username->setFormValue($objForm->GetValue("x_username"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		if (!$this->accesslevel->FldIsDetailKey) {
			$this->accesslevel->setFormValue($objForm->GetValue("x_accesslevel"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->profile->FldIsDetailKey) {
			$this->profile->setFormValue($objForm->GetValue("x_profile"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->staff_id->CurrentValue = $this->staff_id->FormValue;
		$this->last_name->CurrentValue = $this->last_name->FormValue;
		$this->first_name->CurrentValue = $this->first_name->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->date_of_birth->CurrentValue = $this->date_of_birth->FormValue;
		$this->date_of_birth->CurrentValue = ew_UnFormatDateTime($this->date_of_birth->CurrentValue, 7);
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->mobile->CurrentValue = $this->mobile->FormValue;
		$this->company->CurrentValue = $this->company->FormValue;
		$this->department->CurrentValue = $this->department->FormValue;
		$this->username->CurrentValue = $this->username->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
		$this->accesslevel->CurrentValue = $this->accesslevel->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->profile->CurrentValue = $this->profile->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('add');
			if (!$res) {
				$sUserIdMsg = ew_DeniedMsg();
				$this->setFailureMessage($sUserIdMsg);
			}
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
		$this->gender->setDbValue($row['gender']);
		$this->date_of_birth->setDbValue($row['date_of_birth']);
		$this->_email->setDbValue($row['email']);
		$this->mobile->setDbValue($row['mobile']);
		$this->company->setDbValue($row['company']);
		$this->department->setDbValue($row['department']);
		$this->username->setDbValue($row['username']);
		$this->password->setDbValue($row['password']);
		$this->accesslevel->setDbValue($row['accesslevel']);
		$this->status->setDbValue($row['status']);
		$this->profile->setDbValue($row['profile']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['staff_id'] = $this->staff_id->CurrentValue;
		$row['last_name'] = $this->last_name->CurrentValue;
		$row['first_name'] = $this->first_name->CurrentValue;
		$row['gender'] = $this->gender->CurrentValue;
		$row['date_of_birth'] = $this->date_of_birth->CurrentValue;
		$row['email'] = $this->_email->CurrentValue;
		$row['mobile'] = $this->mobile->CurrentValue;
		$row['company'] = $this->company->CurrentValue;
		$row['department'] = $this->department->CurrentValue;
		$row['username'] = $this->username->CurrentValue;
		$row['password'] = $this->password->CurrentValue;
		$row['accesslevel'] = $this->accesslevel->CurrentValue;
		$row['status'] = $this->status->CurrentValue;
		$row['profile'] = $this->profile->CurrentValue;
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
		$this->gender->DbValue = $row['gender'];
		$this->date_of_birth->DbValue = $row['date_of_birth'];
		$this->_email->DbValue = $row['email'];
		$this->mobile->DbValue = $row['mobile'];
		$this->company->DbValue = $row['company'];
		$this->department->DbValue = $row['department'];
		$this->username->DbValue = $row['username'];
		$this->password->DbValue = $row['password'];
		$this->accesslevel->DbValue = $row['accesslevel'];
		$this->status->DbValue = $row['status'];
		$this->profile->DbValue = $row['profile'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
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
		// gender
		// date_of_birth
		// email
		// mobile
		// company
		// department
		// username
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

		// gender
		if (strval($this->gender->CurrentValue) <> "") {
			$this->gender->ViewValue = $this->gender->OptionCaption($this->gender->CurrentValue);
		} else {
			$this->gender->ViewValue = NULL;
		}
		$this->gender->ViewCustomAttributes = "";

		// date_of_birth
		$this->date_of_birth->ViewValue = $this->date_of_birth->CurrentValue;
		$this->date_of_birth->ViewValue = ew_FormatDateTime($this->date_of_birth->ViewValue, 7);
		$this->date_of_birth->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

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

		// username
		$this->username->ViewValue = $this->username->CurrentValue;
		$this->username->ViewCustomAttributes = "";

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

		// profile
		$this->profile->ViewValue = $this->profile->CurrentValue;
		$this->profile->ViewCustomAttributes = "";

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

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// date_of_birth
			$this->date_of_birth->LinkCustomAttributes = "";
			$this->date_of_birth->HrefValue = "";
			$this->date_of_birth->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

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

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";
			$this->username->TooltipValue = "";

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

			// profile
			$this->profile->LinkCustomAttributes = "";
			$this->profile->HrefValue = "";
			$this->profile->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// staff_id
			$this->staff_id->EditAttrs["class"] = "form-control";
			$this->staff_id->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow("add")) { // Non system admin
				$this->staff_id->CurrentValue = CurrentUserID();
			$this->staff_id->EditValue = $this->staff_id->CurrentValue;
			$this->staff_id->ViewCustomAttributes = "";
			} else {
			$this->staff_id->EditValue = ew_HtmlEncode($this->staff_id->CurrentValue);
			$this->staff_id->PlaceHolder = ew_RemoveHtml($this->staff_id->FldCaption());
			}

			// last_name
			$this->last_name->EditAttrs["class"] = "form-control";
			$this->last_name->EditCustomAttributes = "";
			$this->last_name->EditValue = ew_HtmlEncode($this->last_name->CurrentValue);
			$this->last_name->PlaceHolder = ew_RemoveHtml($this->last_name->FldCaption());

			// first_name
			$this->first_name->EditAttrs["class"] = "form-control";
			$this->first_name->EditCustomAttributes = "";
			$this->first_name->EditValue = ew_HtmlEncode($this->first_name->CurrentValue);
			$this->first_name->PlaceHolder = ew_RemoveHtml($this->first_name->FldCaption());

			// gender
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = $this->gender->Options(FALSE);

			// date_of_birth
			$this->date_of_birth->EditAttrs["class"] = "form-control";
			$this->date_of_birth->EditCustomAttributes = "";
			$this->date_of_birth->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_of_birth->CurrentValue, 7));
			$this->date_of_birth->PlaceHolder = ew_RemoveHtml($this->date_of_birth->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// mobile
			$this->mobile->EditAttrs["class"] = "form-control";
			$this->mobile->EditCustomAttributes = "";
			$this->mobile->EditValue = ew_HtmlEncode($this->mobile->CurrentValue);
			$this->mobile->PlaceHolder = ew_RemoveHtml($this->mobile->FldCaption());

			// company
			$this->company->EditCustomAttributes = "";
			if (trim(strval($this->company->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->company->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `company`";
			$sWhereWrk = "";
			$this->company->LookupFilters = array("dx1" => '`description`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->company, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->company->ViewValue = $this->company->DisplayValue($arwrk);
			} else {
				$this->company->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->company->EditValue = $arwrk;

			// department
			$this->department->EditCustomAttributes = "";
			if (trim(strval($this->department->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`code`" . ew_SearchString("=", $this->department->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `code`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `company_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `department`";
			$sWhereWrk = "";
			$this->department->LookupFilters = array("dx1" => '`description`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->department, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `description` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->department->ViewValue = $this->department->DisplayValue($arwrk);
			} else {
				$this->department->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->department->EditValue = $arwrk;

			// username
			$this->username->EditAttrs["class"] = "form-control";
			$this->username->EditCustomAttributes = "";
			$this->username->EditValue = ew_HtmlEncode($this->username->CurrentValue);
			$this->username->PlaceHolder = ew_RemoveHtml($this->username->FldCaption());

			// password
			$this->password->EditAttrs["class"] = "form-control";
			$this->password->EditCustomAttributes = "";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);
			$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

			// accesslevel
			$this->accesslevel->EditAttrs["class"] = "form-control";
			$this->accesslevel->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->accesslevel->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->accesslevel->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->accesslevel->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			$this->accesslevel->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->accesslevel, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->accesslevel->EditValue = $arwrk;
			}

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// profile
			$this->profile->EditAttrs["class"] = "form-control";
			$this->profile->EditCustomAttributes = "";
			$this->profile->EditValue = ew_HtmlEncode($this->profile->CurrentValue);
			$this->profile->PlaceHolder = ew_RemoveHtml($this->profile->FldCaption());

			// Add refer script
			// staff_id

			$this->staff_id->LinkCustomAttributes = "";
			$this->staff_id->HrefValue = "";

			// last_name
			$this->last_name->LinkCustomAttributes = "";
			$this->last_name->HrefValue = "";

			// first_name
			$this->first_name->LinkCustomAttributes = "";
			$this->first_name->HrefValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";

			// date_of_birth
			$this->date_of_birth->LinkCustomAttributes = "";
			$this->date_of_birth->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";

			// department
			$this->department->LinkCustomAttributes = "";
			$this->department->HrefValue = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";

			// accesslevel
			$this->accesslevel->LinkCustomAttributes = "";
			$this->accesslevel->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// profile
			$this->profile->LinkCustomAttributes = "";
			$this->profile->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->staff_id->FldIsDetailKey && !is_null($this->staff_id->FormValue) && $this->staff_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->staff_id->FldCaption(), $this->staff_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->staff_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->staff_id->FldErrMsg());
		}
		if (!$this->last_name->FldIsDetailKey && !is_null($this->last_name->FormValue) && $this->last_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->last_name->FldCaption(), $this->last_name->ReqErrMsg));
		}
		if (!$this->first_name->FldIsDetailKey && !is_null($this->first_name->FormValue) && $this->first_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->first_name->FldCaption(), $this->first_name->ReqErrMsg));
		}
		if ($this->gender->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->gender->FldCaption(), $this->gender->ReqErrMsg));
		}
		if (!$this->date_of_birth->FldIsDetailKey && !is_null($this->date_of_birth->FormValue) && $this->date_of_birth->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->date_of_birth->FldCaption(), $this->date_of_birth->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->date_of_birth->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_of_birth->FldErrMsg());
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_email->FldCaption(), $this->_email->ReqErrMsg));
		}
		if (!$this->mobile->FldIsDetailKey && !is_null($this->mobile->FormValue) && $this->mobile->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->mobile->FldCaption(), $this->mobile->ReqErrMsg));
		}
		if (!$this->department->FldIsDetailKey && !is_null($this->department->FormValue) && $this->department->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->department->FldCaption(), $this->department->ReqErrMsg));
		}
		if (!$this->username->FldIsDetailKey && !is_null($this->username->FormValue) && $this->username->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->username->FldCaption(), $this->username->ReqErrMsg));
		}
		if (!$this->password->FldIsDetailKey && !is_null($this->password->FormValue) && $this->password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->password->FldCaption(), $this->password->ReqErrMsg));
		}
		if (!$this->accesslevel->FldIsDetailKey && !is_null($this->accesslevel->FormValue) && $this->accesslevel->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->accesslevel->FldCaption(), $this->accesslevel->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;

		// Check if valid User ID
		$bValidUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->staff_id->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidUser = $Security->IsValidUserID($this->staff_id->CurrentValue);
			if (!$bValidUser) {
				$sUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedUserID"));
				$sUserIdMsg = str_replace("%u", $this->staff_id->CurrentValue, $sUserIdMsg);
				$this->setFailureMessage($sUserIdMsg);
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// staff_id
		$this->staff_id->SetDbValueDef($rsnew, $this->staff_id->CurrentValue, 0, FALSE);

		// last_name
		$this->last_name->SetDbValueDef($rsnew, $this->last_name->CurrentValue, NULL, FALSE);

		// first_name
		$this->first_name->SetDbValueDef($rsnew, $this->first_name->CurrentValue, NULL, FALSE);

		// gender
		$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, FALSE);

		// date_of_birth
		$this->date_of_birth->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_of_birth->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", FALSE);

		// mobile
		$this->mobile->SetDbValueDef($rsnew, $this->mobile->CurrentValue, "", FALSE);

		// company
		$this->company->SetDbValueDef($rsnew, $this->company->CurrentValue, NULL, FALSE);

		// department
		$this->department->SetDbValueDef($rsnew, $this->department->CurrentValue, NULL, FALSE);

		// username
		$this->username->SetDbValueDef($rsnew, $this->username->CurrentValue, NULL, FALSE);

		// password
		$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", FALSE);

		// accesslevel
		if ($Security->CanAdmin()) { // System admin
		$this->accesslevel->SetDbValueDef($rsnew, $this->accesslevel->CurrentValue, 0, strval($this->accesslevel->CurrentValue) == "");
		}

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, strval($this->status->CurrentValue) == "");

		// profile
		$this->profile->SetDbValueDef($rsnew, $this->profile->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_company":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `company`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`description`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->company, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_department":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `code` AS `LinkFld`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `department`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`description`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`code` IN ({filter_value})', "t0" => "3", "fn0" => "", "f1" => '`company_id` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->department, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `description` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_accesslevel":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `userlevelid` AS `LinkFld`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`userlevelid` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->accesslevel, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($user_profile_add)) $user_profile_add = new cuser_profile_add();

// Page init
$user_profile_add->Page_Init();

// Page main
$user_profile_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$user_profile_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fuser_profileadd = new ew_Form("fuser_profileadd", "add");

// Validate form
fuser_profileadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_staff_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->staff_id->FldCaption(), $user_profile->staff_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_staff_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($user_profile->staff_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->last_name->FldCaption(), $user_profile->last_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_first_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->first_name->FldCaption(), $user_profile->first_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_gender");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->gender->FldCaption(), $user_profile->gender->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_of_birth");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->date_of_birth->FldCaption(), $user_profile->date_of_birth->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_of_birth");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($user_profile->date_of_birth->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->_email->FldCaption(), $user_profile->_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_mobile");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->mobile->FldCaption(), $user_profile->mobile->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_department");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->department->FldCaption(), $user_profile->department->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_username");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->username->FldCaption(), $user_profile->username->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->password->FldCaption(), $user_profile->password->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_accesslevel");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->accesslevel->FldCaption(), $user_profile->accesslevel->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fuser_profileadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fuser_profileadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuser_profileadd.Lists["x_gender"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profileadd.Lists["x_gender"].Options = <?php echo json_encode($user_profile_add->gender->Options()) ?>;
fuser_profileadd.Lists["x_company"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":["x_department"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fuser_profileadd.Lists["x_company"].Data = "<?php echo $user_profile_add->company->LookupFilterQuery(FALSE, "add") ?>";
fuser_profileadd.Lists["x_department"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":["x_company"],"ChildFields":[],"FilterFields":["x_company_id"],"Options":[],"Template":"","LinkTable":"department"};
fuser_profileadd.Lists["x_department"].Data = "<?php echo $user_profile_add->department->LookupFilterQuery(FALSE, "add") ?>";
fuser_profileadd.Lists["x_accesslevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};
fuser_profileadd.Lists["x_accesslevel"].Data = "<?php echo $user_profile_add->accesslevel->LookupFilterQuery(FALSE, "add") ?>";
fuser_profileadd.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profileadd.Lists["x_status"].Options = <?php echo json_encode($user_profile_add->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
$(document).ready(function(){
	$('#x_last_name').blur(function() {
	   var currVal = $(this).val().trim().replace(/\s+/g, ' ');
	   currVal = currVal.toUpperCase().replace(/(^[a-z]| [a-z]|-[a-z])/g, function(txtVal) {
		  return txtVal.toUpperCase();
	   });
	   $(this).val(currVal);
	});
	$('#x_first_name').blur(function() {
	   var currVal = $(this).val().trim().replace(/\s+/g, ' ');
	   currVal = currVal.toLowerCase().replace(/(^[a-z]| [a-z]|-[a-z])/g, function(txtVal) {
		  return txtVal.toUpperCase();
	   });
	   $(this).val(currVal);
	});
	$('#x__email').blur(function() {
		var currVal = $(this).val().trim().replace(/\s+/g, ' ');
		$(this).val(currVal.toLowerCase());
	});
})
</script>
<?php $user_profile_add->ShowPageHeader(); ?>
<?php
$user_profile_add->ShowMessage();
?>
<form name="fuser_profileadd" id="fuser_profileadd" class="<?php echo $user_profile_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($user_profile_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $user_profile_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="user_profile">
<?php if ($user_profile->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } else { ?>
<input type="hidden" name="a_add" id="a_add" value="F">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo intval($user_profile_add->IsModal) ?>">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($user_profile->staff_id->Visible) { // staff_id ?>
	<div id="r_staff_id" class="form-group">
		<label id="elh_user_profile_staff_id" for="x_staff_id" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->staff_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->staff_id->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$user_profile->UserIDAllow("add")) { // Non system admin ?>
<span id="el_user_profile_staff_id">
<span<?php echo $user_profile->staff_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->staff_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_staff_id" name="x_staff_id" id="x_staff_id" value="<?php echo ew_HtmlEncode($user_profile->staff_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_user_profile_staff_id">
<input type="text" data-table="user_profile" data-field="x_staff_id" name="x_staff_id" id="x_staff_id" placeholder="<?php echo ew_HtmlEncode($user_profile->staff_id->getPlaceHolder()) ?>" value="<?php echo $user_profile->staff_id->EditValue ?>"<?php echo $user_profile->staff_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_user_profile_staff_id">
<span<?php echo $user_profile->staff_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->staff_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_staff_id" name="x_staff_id" id="x_staff_id" value="<?php echo ew_HtmlEncode($user_profile->staff_id->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->staff_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->last_name->Visible) { // last_name ?>
	<div id="r_last_name" class="form-group">
		<label id="elh_user_profile_last_name" for="x_last_name" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->last_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->last_name->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_last_name">
<input type="text" data-table="user_profile" data-field="x_last_name" name="x_last_name" id="x_last_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->last_name->getPlaceHolder()) ?>" value="<?php echo $user_profile->last_name->EditValue ?>"<?php echo $user_profile->last_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_last_name">
<span<?php echo $user_profile->last_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->last_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_last_name" name="x_last_name" id="x_last_name" value="<?php echo ew_HtmlEncode($user_profile->last_name->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->last_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->first_name->Visible) { // first_name ?>
	<div id="r_first_name" class="form-group">
		<label id="elh_user_profile_first_name" for="x_first_name" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->first_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->first_name->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_first_name">
<input type="text" data-table="user_profile" data-field="x_first_name" name="x_first_name" id="x_first_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->first_name->getPlaceHolder()) ?>" value="<?php echo $user_profile->first_name->EditValue ?>"<?php echo $user_profile->first_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_first_name">
<span<?php echo $user_profile->first_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->first_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_first_name" name="x_first_name" id="x_first_name" value="<?php echo ew_HtmlEncode($user_profile->first_name->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->first_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->gender->Visible) { // gender ?>
	<div id="r_gender" class="form-group">
		<label id="elh_user_profile_gender" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->gender->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->gender->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_gender">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($user_profile->gender->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $user_profile->gender->ViewValue ?>
	</span>
	<?php if (!$user_profile->gender->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_gender" data-repeatcolumn="5" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $user_profile->gender->RadioButtonListHtml(TRUE, "x_gender") ?>
		</div>
	</div>
	<div id="tp_x_gender" class="ewTemplate"><input type="radio" data-table="user_profile" data-field="x_gender" data-value-separator="<?php echo $user_profile->gender->DisplayValueSeparatorAttribute() ?>" name="x_gender" id="x_gender" value="{value}"<?php echo $user_profile->gender->EditAttributes() ?>></div>
</div>
</span>
<?php } else { ?>
<span id="el_user_profile_gender">
<span<?php echo $user_profile->gender->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->gender->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_gender" name="x_gender" id="x_gender" value="<?php echo ew_HtmlEncode($user_profile->gender->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->gender->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->date_of_birth->Visible) { // date_of_birth ?>
	<div id="r_date_of_birth" class="form-group">
		<label id="elh_user_profile_date_of_birth" for="x_date_of_birth" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->date_of_birth->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->date_of_birth->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_date_of_birth">
<input type="text" data-table="user_profile" data-field="x_date_of_birth" data-format="7" name="x_date_of_birth" id="x_date_of_birth" size="10" placeholder="<?php echo ew_HtmlEncode($user_profile->date_of_birth->getPlaceHolder()) ?>" value="<?php echo $user_profile->date_of_birth->EditValue ?>"<?php echo $user_profile->date_of_birth->EditAttributes() ?>>
<?php if (!$user_profile->date_of_birth->ReadOnly && !$user_profile->date_of_birth->Disabled && !isset($user_profile->date_of_birth->EditAttrs["readonly"]) && !isset($user_profile->date_of_birth->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fuser_profileadd", "x_date_of_birth", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_user_profile_date_of_birth">
<span<?php echo $user_profile->date_of_birth->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->date_of_birth->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_date_of_birth" name="x_date_of_birth" id="x_date_of_birth" value="<?php echo ew_HtmlEncode($user_profile->date_of_birth->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->date_of_birth->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_user_profile__email" for="x__email" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->_email->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile__email">
<input type="text" data-table="user_profile" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($user_profile->_email->getPlaceHolder()) ?>" value="<?php echo $user_profile->_email->EditValue ?>"<?php echo $user_profile->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile__email">
<span<?php echo $user_profile->_email->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->_email->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x__email" name="x__email" id="x__email" value="<?php echo ew_HtmlEncode($user_profile->_email->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->mobile->Visible) { // mobile ?>
	<div id="r_mobile" class="form-group">
		<label id="elh_user_profile_mobile" for="x_mobile" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->mobile->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->mobile->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_mobile">
<input type="text" data-table="user_profile" data-field="x_mobile" name="x_mobile" id="x_mobile" size="30" maxlength="11" placeholder="<?php echo ew_HtmlEncode($user_profile->mobile->getPlaceHolder()) ?>" value="<?php echo $user_profile->mobile->EditValue ?>"<?php echo $user_profile->mobile->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_mobile">
<span<?php echo $user_profile->mobile->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->mobile->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_mobile" name="x_mobile" id="x_mobile" value="<?php echo ew_HtmlEncode($user_profile->mobile->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->company->Visible) { // company ?>
	<div id="r_company" class="form-group">
		<label id="elh_user_profile_company" for="x_company" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->company->FldCaption() ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->company->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_company">
<?php $user_profile->company->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$user_profile->company->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_company"><?php echo (strval($user_profile->company->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $user_profile->company->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($user_profile->company->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_company',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($user_profile->company->ReadOnly || $user_profile->company->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="user_profile" data-field="x_company" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $user_profile->company->DisplayValueSeparatorAttribute() ?>" name="x_company" id="x_company" value="<?php echo $user_profile->company->CurrentValue ?>"<?php echo $user_profile->company->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_company">
<span<?php echo $user_profile->company->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->company->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_company" name="x_company" id="x_company" value="<?php echo ew_HtmlEncode($user_profile->company->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->company->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->department->Visible) { // department ?>
	<div id="r_department" class="form-group">
		<label id="elh_user_profile_department" for="x_department" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->department->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->department->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_department">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_department"><?php echo (strval($user_profile->department->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $user_profile->department->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($user_profile->department->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_department',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($user_profile->department->ReadOnly || $user_profile->department->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="user_profile" data-field="x_department" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $user_profile->department->DisplayValueSeparatorAttribute() ?>" name="x_department" id="x_department" value="<?php echo $user_profile->department->CurrentValue ?>"<?php echo $user_profile->department->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_department">
<span<?php echo $user_profile->department->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->department->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_department" name="x_department" id="x_department" value="<?php echo ew_HtmlEncode($user_profile->department->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->department->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->username->Visible) { // username ?>
	<div id="r_username" class="form-group">
		<label id="elh_user_profile_username" for="x_username" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->username->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_username">
<input type="text" data-table="user_profile" data-field="x_username" name="x_username" id="x_username" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->username->getPlaceHolder()) ?>" value="<?php echo $user_profile->username->EditValue ?>"<?php echo $user_profile->username->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_username">
<span<?php echo $user_profile->username->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->username->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_username" name="x_username" id="x_username" value="<?php echo ew_HtmlEncode($user_profile->username->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->username->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->password->Visible) { // password ?>
	<div id="r_password" class="form-group">
		<label id="elh_user_profile_password" for="x_password" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->password->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_password">
<div class="input-group" id="ig_password">
<input type="password" data-password-generated="pgt_password" data-table="user_profile" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->password->getPlaceHolder()) ?>"<?php echo $user_profile->password->EditAttributes() ?>>
<span class="input-group-btn">
	<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="x_password" data-password-confirm="c_password" data-password-generated="pgt_password"><?php echo $Language->Phrase("GeneratePassword") ?></button>
</span>
</div>
<span class="help-block" id="pgt_password" style="display: none;"></span>
</span>
<?php } else { ?>
<span id="el_user_profile_password">
<span<?php echo $user_profile->password->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->password->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_password" name="x_password" id="x_password" value="<?php echo ew_HtmlEncode($user_profile->password->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->accesslevel->Visible) { // accesslevel ?>
	<div id="r_accesslevel" class="form-group">
		<label id="elh_user_profile_accesslevel" for="x_accesslevel" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->accesslevel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->accesslevel->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_user_profile_accesslevel">
<p class="form-control-static"><?php echo $user_profile->accesslevel->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_user_profile_accesslevel">
<select data-table="user_profile" data-field="x_accesslevel" data-value-separator="<?php echo $user_profile->accesslevel->DisplayValueSeparatorAttribute() ?>" id="x_accesslevel" name="x_accesslevel"<?php echo $user_profile->accesslevel->EditAttributes() ?>>
<?php echo $user_profile->accesslevel->SelectOptionListHtml("x_accesslevel") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_user_profile_accesslevel">
<span<?php echo $user_profile->accesslevel->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->accesslevel->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_accesslevel" name="x_accesslevel" id="x_accesslevel" value="<?php echo ew_HtmlEncode($user_profile->accesslevel->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->accesslevel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_user_profile_status" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->status->FldCaption() ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->status->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="user_profile" data-field="x_status" data-value-separator="<?php echo $user_profile->status->DisplayValueSeparatorAttribute() ?>" name="x_status" id="x_status" value="{value}"<?php echo $user_profile->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $user_profile->status->RadioButtonListHtml(FALSE, "x_status") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_user_profile_status">
<span<?php echo $user_profile->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_status" name="x_status" id="x_status" value="<?php echo ew_HtmlEncode($user_profile->status->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->profile->Visible) { // profile ?>
	<div id="r_profile" class="form-group">
		<label id="elh_user_profile_profile" for="x_profile" class="<?php echo $user_profile_add->LeftColumnClass ?>"><?php echo $user_profile->profile->FldCaption() ?></label>
		<div class="<?php echo $user_profile_add->RightColumnClass ?>"><div<?php echo $user_profile->profile->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_profile">
<textarea data-table="user_profile" data-field="x_profile" name="x_profile" id="x_profile" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($user_profile->profile->getPlaceHolder()) ?>"<?php echo $user_profile->profile->EditAttributes() ?>><?php echo $user_profile->profile->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_user_profile_profile">
<span<?php echo $user_profile->profile->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->profile->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_profile" name="x_profile" id="x_profile" value="<?php echo ew_HtmlEncode($user_profile->profile->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->profile->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$user_profile_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $user_profile_add->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($user_profile->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_add.value='F';"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $user_profile_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_add.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fuser_profileadd.Init();
</script>
<?php
$user_profile_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$user_profile_add->Page_Terminate();
?>
