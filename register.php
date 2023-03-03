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

$register = NULL; // Initialize page object first

class cregister extends cuser_profile {

	// Page ID
	var $PageID = 'register';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Page object name
	var $PageObjName = 'register';

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
		return TRUE;
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
		if (!isset($GLOBALS["user_profile"])) $GLOBALS["user_profile"] = new cuser_profile();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'register', TRUE);

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

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Set up multi page object
		$this->SetupMultiPages();

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
	var $FormClassName = "form-horizontal ewForm ewRegisterForm";
	var $MultiPages; // Multi pages object

	//
	// Page main
	//
	function Page_Main() {
		global $UserTableConn, $Security, $Language, $gsLanguage, $gsFormError, $objForm;
		global $Breadcrumb;
		$this->FormClassName = "ewForm ewRegisterForm form-horizontal";

		// Set up Breadcrumb
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("register", "RegisterPage", $url, "", "", TRUE);
		$this->Heading = $Language->Phrase("RegisterPage");
		$bUserExists = FALSE;
		$this->LoadRowValues(); // Load default values
		if (@$_POST["a_register"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_register"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->CurrentAction = "I"; // Display blank record
		}

		// Handle email activation
		if (@$_GET["action"] <> "") {
			$sAction = $_GET["action"];
			$sEmail = @$_GET["email"];
			$sCode = @$_GET["token"];
			@list($sApprovalCode, $sUsr, $sPwd) = explode(",", $sCode, 3);
			$sApprovalCode = ew_Decrypt($sApprovalCode);
			$sUsr = ew_Decrypt($sUsr);
			$sPwd = ew_Decrypt($sPwd);
			if ($sEmail == $sApprovalCode) {
				if (strtolower($sAction) == "confirm") { // Email activation
					if ($this->ActivateEmail($sEmail)) { // Activate this email
						if ($this->getSuccessMessage() == "")
							$this->setSuccessMessage($Language->Phrase("ActivateAccount")); // Set up message acount activated
						$this->Page_Terminate("login.php"); // Go to login page
					}
				}
			}
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("ActivateFailed")); // Set activate failed message
			$this->Page_Terminate("login.php"); // Go to login page
		}
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add

				// Check for duplicate User ID
				$sFilter = str_replace("%u", ew_AdjustSql($this->username->CurrentValue, EW_USER_TABLE_DBID), EW_USER_NAME_FILTER);

				// Set up filter (SQL WHERE clause) and get return SQL
				// SQL constructor in user_profile class, user_profileinfo.php

				$this->CurrentFilter = $sFilter;
				$sUserSql = $this->SQL();
				if ($rs = $UserTableConn->Execute($sUserSql)) {
					if (!$rs->EOF) {
						$bUserExists = TRUE;
						$this->RestoreFormValues(); // Restore form values
						$this->setFailureMessage($Language->Phrase("UserExists")); // Set user exist message
					}
					$rs->Close();
				}
				if (!$bUserExists) {
					$this->SendEmail = TRUE; // Send email on add success
					if ($this->AddRow()) { // Add record
						$Email = $this->PrepareRegisterEmail();

						// Get new recordset
						$this->CurrentFilter = $this->KeyFilter();
						$sSql = $this->SQL();
						$rsnew = $UserTableConn->Execute($sSql);
						$row = $rsnew->fields;
						$Args = array();
						$Args["rs"] = $row;
						$bEmailSent = FALSE;
						if ($this->Email_Sending($Email, $Args))
							$bEmailSent = $Email->Send();

						// Send email failed
						if (!$bEmailSent)
							$this->setFailureMessage($Email->SendErrDescription);
						if ($this->getSuccessMessage() == "")
							$this->setSuccessMessage($Language->Phrase("RegisterSuccessActivate")); // Activate success
						$this->Page_Terminate("login.php"); // Return
					} else {
						$this->RestoreFormValues(); // Restore form values
					}
				}
		}

		// Render row
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render view
		} else {
			$this->RowType = EW_ROWTYPE_ADD; // Render add
		}
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Activate account based on email
	function ActivateEmail($email) {
		global $UserTableConn, $Language;
		$sFilter = str_replace("%e", ew_AdjustSql($email, EW_USER_TABLE_DBID), EW_USER_EMAIL_FILTER);
		$sSql = $this->GetSQL($sFilter, "");
		$UserTableConn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $UserTableConn->Execute($sSql);
		$UserTableConn->raiseErrorFn = '';
		if (!$rs)
			return FALSE;
		if (!$rs->EOF) {
			$rsnew = $rs->fields;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
			$rsact = array('status' => 1); // Auto register
			$this->CurrentFilter = $sFilter;
			$res = $this->Update($rsact);
			if ($res) { // Call User Activated event
				$rsnew['status'] = 1;
				$this->User_Activated($rsnew);
			}
			return $res;
		} else {
			$this->setFailureMessage($Language->Phrase("NoRecord"));
			$rs->Close();
			return FALSE;
		}
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
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->gender->CurrentValue = NULL;
		$this->gender->OldValue = $this->gender->CurrentValue;
		$this->marital_status->CurrentValue = NULL;
		$this->marital_status->OldValue = $this->marital_status->CurrentValue;
		$this->date_of_birth->CurrentValue = NULL;
		$this->date_of_birth->OldValue = $this->date_of_birth->CurrentValue;
		$this->username->CurrentValue = NULL;
		$this->username->OldValue = $this->username->CurrentValue;
		$this->mobile->CurrentValue = NULL;
		$this->mobile->OldValue = $this->mobile->CurrentValue;
		$this->company->CurrentValue = NULL;
		$this->company->OldValue = $this->company->CurrentValue;
		$this->department->CurrentValue = NULL;
		$this->department->OldValue = $this->department->CurrentValue;
		$this->home_address->CurrentValue = NULL;
		$this->home_address->OldValue = $this->home_address->CurrentValue;
		$this->town_city->CurrentValue = NULL;
		$this->town_city->OldValue = $this->town_city->CurrentValue;
		$this->state_origin->CurrentValue = NULL;
		$this->state_origin->OldValue = $this->state_origin->CurrentValue;
		$this->local_gra->CurrentValue = NULL;
		$this->local_gra->OldValue = $this->local_gra->CurrentValue;
		$this->next_kin->CurrentValue = NULL;
		$this->next_kin->OldValue = $this->next_kin->CurrentValue;
		$this->resident_nxt_kin->CurrentValue = NULL;
		$this->resident_nxt_kin->OldValue = $this->resident_nxt_kin->CurrentValue;
		$this->nearest_bus_stop->CurrentValue = NULL;
		$this->nearest_bus_stop->OldValue = $this->nearest_bus_stop->CurrentValue;
		$this->town_city_nxt_kin->CurrentValue = NULL;
		$this->town_city_nxt_kin->OldValue = $this->town_city_nxt_kin->CurrentValue;
		$this->email_nxt_kin->CurrentValue = NULL;
		$this->email_nxt_kin->OldValue = $this->email_nxt_kin->CurrentValue;
		$this->phone_nxt_kin->CurrentValue = NULL;
		$this->phone_nxt_kin->OldValue = $this->phone_nxt_kin->CurrentValue;
		$this->qualification_level->CurrentValue = NULL;
		$this->qualification_level->OldValue = $this->qualification_level->CurrentValue;
		$this->qualification_grade->CurrentValue = NULL;
		$this->qualification_grade->OldValue = $this->qualification_grade->CurrentValue;
		$this->upload_of_credentcial->Upload->DbValue = NULL;
		$this->upload_of_credentcial->OldValue = $this->upload_of_credentcial->Upload->DbValue;
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
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		if (!$this->marital_status->FldIsDetailKey) {
			$this->marital_status->setFormValue($objForm->GetValue("x_marital_status"));
		}
		if (!$this->date_of_birth->FldIsDetailKey) {
			$this->date_of_birth->setFormValue($objForm->GetValue("x_date_of_birth"));
			$this->date_of_birth->CurrentValue = ew_UnFormatDateTime($this->date_of_birth->CurrentValue, 7);
		}
		if (!$this->username->FldIsDetailKey) {
			$this->username->setFormValue($objForm->GetValue("x_username"));
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
		if (!$this->home_address->FldIsDetailKey) {
			$this->home_address->setFormValue($objForm->GetValue("x_home_address"));
		}
		if (!$this->town_city->FldIsDetailKey) {
			$this->town_city->setFormValue($objForm->GetValue("x_town_city"));
		}
		if (!$this->state_origin->FldIsDetailKey) {
			$this->state_origin->setFormValue($objForm->GetValue("x_state_origin"));
		}
		if (!$this->local_gra->FldIsDetailKey) {
			$this->local_gra->setFormValue($objForm->GetValue("x_local_gra"));
		}
		if (!$this->next_kin->FldIsDetailKey) {
			$this->next_kin->setFormValue($objForm->GetValue("x_next_kin"));
		}
		if (!$this->resident_nxt_kin->FldIsDetailKey) {
			$this->resident_nxt_kin->setFormValue($objForm->GetValue("x_resident_nxt_kin"));
		}
		if (!$this->nearest_bus_stop->FldIsDetailKey) {
			$this->nearest_bus_stop->setFormValue($objForm->GetValue("x_nearest_bus_stop"));
		}
		if (!$this->town_city_nxt_kin->FldIsDetailKey) {
			$this->town_city_nxt_kin->setFormValue($objForm->GetValue("x_town_city_nxt_kin"));
		}
		if (!$this->email_nxt_kin->FldIsDetailKey) {
			$this->email_nxt_kin->setFormValue($objForm->GetValue("x_email_nxt_kin"));
		}
		if (!$this->phone_nxt_kin->FldIsDetailKey) {
			$this->phone_nxt_kin->setFormValue($objForm->GetValue("x_phone_nxt_kin"));
		}
		if (!$this->qualification_level->FldIsDetailKey) {
			$this->qualification_level->setFormValue($objForm->GetValue("x_qualification_level"));
		}
		if (!$this->qualification_grade->FldIsDetailKey) {
			$this->qualification_grade->setFormValue($objForm->GetValue("x_qualification_grade"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		$this->password->ConfirmValue = $objForm->GetValue("c_password");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->staff_id->CurrentValue = $this->staff_id->FormValue;
		$this->last_name->CurrentValue = $this->last_name->FormValue;
		$this->first_name->CurrentValue = $this->first_name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->marital_status->CurrentValue = $this->marital_status->FormValue;
		$this->date_of_birth->CurrentValue = $this->date_of_birth->FormValue;
		$this->date_of_birth->CurrentValue = ew_UnFormatDateTime($this->date_of_birth->CurrentValue, 7);
		$this->username->CurrentValue = $this->username->FormValue;
		$this->mobile->CurrentValue = $this->mobile->FormValue;
		$this->company->CurrentValue = $this->company->FormValue;
		$this->department->CurrentValue = $this->department->FormValue;
		$this->home_address->CurrentValue = $this->home_address->FormValue;
		$this->town_city->CurrentValue = $this->town_city->FormValue;
		$this->state_origin->CurrentValue = $this->state_origin->FormValue;
		$this->local_gra->CurrentValue = $this->local_gra->FormValue;
		$this->next_kin->CurrentValue = $this->next_kin->FormValue;
		$this->resident_nxt_kin->CurrentValue = $this->resident_nxt_kin->FormValue;
		$this->nearest_bus_stop->CurrentValue = $this->nearest_bus_stop->FormValue;
		$this->town_city_nxt_kin->CurrentValue = $this->town_city_nxt_kin->FormValue;
		$this->email_nxt_kin->CurrentValue = $this->email_nxt_kin->FormValue;
		$this->phone_nxt_kin->CurrentValue = $this->phone_nxt_kin->FormValue;
		$this->qualification_level->CurrentValue = $this->qualification_level->FormValue;
		$this->qualification_grade->CurrentValue = $this->qualification_grade->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['staff_id'] = $this->staff_id->CurrentValue;
		$row['last_name'] = $this->last_name->CurrentValue;
		$row['first_name'] = $this->first_name->CurrentValue;
		$row['email'] = $this->_email->CurrentValue;
		$row['gender'] = $this->gender->CurrentValue;
		$row['marital_status'] = $this->marital_status->CurrentValue;
		$row['date_of_birth'] = $this->date_of_birth->CurrentValue;
		$row['username'] = $this->username->CurrentValue;
		$row['mobile'] = $this->mobile->CurrentValue;
		$row['company'] = $this->company->CurrentValue;
		$row['department'] = $this->department->CurrentValue;
		$row['home_address'] = $this->home_address->CurrentValue;
		$row['town_city'] = $this->town_city->CurrentValue;
		$row['state_origin'] = $this->state_origin->CurrentValue;
		$row['local_gra'] = $this->local_gra->CurrentValue;
		$row['next_kin'] = $this->next_kin->CurrentValue;
		$row['resident_nxt_kin'] = $this->resident_nxt_kin->CurrentValue;
		$row['nearest_bus_stop'] = $this->nearest_bus_stop->CurrentValue;
		$row['town_city_nxt_kin'] = $this->town_city_nxt_kin->CurrentValue;
		$row['email_nxt_kin'] = $this->email_nxt_kin->CurrentValue;
		$row['phone_nxt_kin'] = $this->phone_nxt_kin->CurrentValue;
		$row['qualification_level'] = $this->qualification_level->CurrentValue;
		$row['qualification_grade'] = $this->qualification_grade->CurrentValue;
		$row['upload_of_credentcial'] = $this->upload_of_credentcial->Upload->DbValue;
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

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
			$this->password->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// staff_id
			$this->staff_id->EditAttrs["class"] = "form-control";
			$this->staff_id->EditCustomAttributes = "";
			$this->staff_id->EditValue = ew_HtmlEncode($this->staff_id->CurrentValue);
			$this->staff_id->PlaceHolder = ew_RemoveHtml($this->staff_id->FldCaption());

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

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// gender
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = $this->gender->Options(FALSE);

			// marital_status
			$this->marital_status->EditCustomAttributes = "";
			$this->marital_status->EditValue = $this->marital_status->Options(TRUE);

			// date_of_birth
			$this->date_of_birth->EditAttrs["class"] = "form-control";
			$this->date_of_birth->EditCustomAttributes = "";
			$this->date_of_birth->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_of_birth->CurrentValue, 7));
			$this->date_of_birth->PlaceHolder = ew_RemoveHtml($this->date_of_birth->FldCaption());

			// username
			$this->username->EditAttrs["class"] = "form-control";
			$this->username->EditCustomAttributes = "";
			$this->username->EditValue = ew_HtmlEncode($this->username->CurrentValue);
			$this->username->PlaceHolder = ew_RemoveHtml($this->username->FldCaption());

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

			// home_address
			$this->home_address->EditAttrs["class"] = "form-control";
			$this->home_address->EditCustomAttributes = "";
			$this->home_address->EditValue = ew_HtmlEncode($this->home_address->CurrentValue);
			$this->home_address->PlaceHolder = ew_RemoveHtml($this->home_address->FldCaption());

			// town_city
			$this->town_city->EditCustomAttributes = "";
			if (trim(strval($this->town_city->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`code`" . ew_SearchString("=", $this->town_city->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `code`, `state_descriptions` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `states_table`";
			$sWhereWrk = "";
			$this->town_city->LookupFilters = array("dx1" => '`state_descriptions`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->town_city, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->town_city->ViewValue = $this->town_city->DisplayValue($arwrk);
			} else {
				$this->town_city->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->town_city->EditValue = $arwrk;

			// state_origin
			$this->state_origin->EditCustomAttributes = "";
			if (trim(strval($this->state_origin->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`code`" . ew_SearchString("=", $this->state_origin->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `code`, `state_descriptions` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `states_table`";
			$sWhereWrk = "";
			$this->state_origin->LookupFilters = array("dx1" => '`state_descriptions`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->state_origin, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->state_origin->ViewValue = $this->state_origin->DisplayValue($arwrk);
			} else {
				$this->state_origin->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->state_origin->EditValue = $arwrk;

			// local_gra
			$this->local_gra->EditCustomAttributes = "";
			if (trim(strval($this->local_gra->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`code`" . ew_SearchString("=", $this->local_gra->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `code`, `lga_descriptions` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `state_code` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lga_states`";
			$sWhereWrk = "";
			$this->local_gra->LookupFilters = array("dx1" => '`lga_descriptions`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->local_gra, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->local_gra->ViewValue = $this->local_gra->DisplayValue($arwrk);
			} else {
				$this->local_gra->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->local_gra->EditValue = $arwrk;

			// next_kin
			$this->next_kin->EditAttrs["class"] = "form-control";
			$this->next_kin->EditCustomAttributes = "";
			$this->next_kin->EditValue = ew_HtmlEncode($this->next_kin->CurrentValue);
			$this->next_kin->PlaceHolder = ew_RemoveHtml($this->next_kin->FldCaption());

			// resident_nxt_kin
			$this->resident_nxt_kin->EditAttrs["class"] = "form-control";
			$this->resident_nxt_kin->EditCustomAttributes = "";
			$this->resident_nxt_kin->EditValue = ew_HtmlEncode($this->resident_nxt_kin->CurrentValue);
			$this->resident_nxt_kin->PlaceHolder = ew_RemoveHtml($this->resident_nxt_kin->FldCaption());

			// nearest_bus_stop
			$this->nearest_bus_stop->EditAttrs["class"] = "form-control";
			$this->nearest_bus_stop->EditCustomAttributes = "";
			$this->nearest_bus_stop->EditValue = ew_HtmlEncode($this->nearest_bus_stop->CurrentValue);
			$this->nearest_bus_stop->PlaceHolder = ew_RemoveHtml($this->nearest_bus_stop->FldCaption());

			// town_city_nxt_kin
			$this->town_city_nxt_kin->EditAttrs["class"] = "form-control";
			$this->town_city_nxt_kin->EditCustomAttributes = "";
			$this->town_city_nxt_kin->EditValue = ew_HtmlEncode($this->town_city_nxt_kin->CurrentValue);
			$this->town_city_nxt_kin->PlaceHolder = ew_RemoveHtml($this->town_city_nxt_kin->FldCaption());

			// email_nxt_kin
			$this->email_nxt_kin->EditAttrs["class"] = "form-control";
			$this->email_nxt_kin->EditCustomAttributes = "";
			$this->email_nxt_kin->EditValue = ew_HtmlEncode($this->email_nxt_kin->CurrentValue);
			$this->email_nxt_kin->PlaceHolder = ew_RemoveHtml($this->email_nxt_kin->FldCaption());

			// phone_nxt_kin
			$this->phone_nxt_kin->EditAttrs["class"] = "form-control";
			$this->phone_nxt_kin->EditCustomAttributes = "";
			$this->phone_nxt_kin->EditValue = ew_HtmlEncode($this->phone_nxt_kin->CurrentValue);
			$this->phone_nxt_kin->PlaceHolder = ew_RemoveHtml($this->phone_nxt_kin->FldCaption());

			// qualification_level
			$this->qualification_level->EditAttrs["class"] = "form-control";
			$this->qualification_level->EditCustomAttributes = "";
			$this->qualification_level->EditValue = $this->qualification_level->Options(TRUE);

			// qualification_grade
			$this->qualification_grade->EditAttrs["class"] = "form-control";
			$this->qualification_grade->EditCustomAttributes = "";
			$this->qualification_grade->EditValue = $this->qualification_grade->Options(TRUE);

			// password
			$this->password->EditAttrs["class"] = "form-control";
			$this->password->EditCustomAttributes = "";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);
			$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

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

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";

			// marital_status
			$this->marital_status->LinkCustomAttributes = "";
			$this->marital_status->HrefValue = "";

			// date_of_birth
			$this->date_of_birth->LinkCustomAttributes = "";
			$this->date_of_birth->HrefValue = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";

			// department
			$this->department->LinkCustomAttributes = "";
			$this->department->HrefValue = "";

			// home_address
			$this->home_address->LinkCustomAttributes = "";
			$this->home_address->HrefValue = "";

			// town_city
			$this->town_city->LinkCustomAttributes = "";
			$this->town_city->HrefValue = "";

			// state_origin
			$this->state_origin->LinkCustomAttributes = "";
			$this->state_origin->HrefValue = "";

			// local_gra
			$this->local_gra->LinkCustomAttributes = "";
			$this->local_gra->HrefValue = "";

			// next_kin
			$this->next_kin->LinkCustomAttributes = "";
			$this->next_kin->HrefValue = "";

			// resident_nxt_kin
			$this->resident_nxt_kin->LinkCustomAttributes = "";
			$this->resident_nxt_kin->HrefValue = "";

			// nearest_bus_stop
			$this->nearest_bus_stop->LinkCustomAttributes = "";
			$this->nearest_bus_stop->HrefValue = "";

			// town_city_nxt_kin
			$this->town_city_nxt_kin->LinkCustomAttributes = "";
			$this->town_city_nxt_kin->HrefValue = "";

			// email_nxt_kin
			$this->email_nxt_kin->LinkCustomAttributes = "";
			$this->email_nxt_kin->HrefValue = "";

			// phone_nxt_kin
			$this->phone_nxt_kin->LinkCustomAttributes = "";
			$this->phone_nxt_kin->HrefValue = "";

			// qualification_level
			$this->qualification_level->LinkCustomAttributes = "";
			$this->qualification_level->HrefValue = "";

			// qualification_grade
			$this->qualification_grade->LinkCustomAttributes = "";
			$this->qualification_grade->HrefValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
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
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_email->FldCaption(), $this->_email->ReqErrMsg));
		}
		if ($this->gender->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->gender->FldCaption(), $this->gender->ReqErrMsg));
		}
		if (!$this->marital_status->FldIsDetailKey && !is_null($this->marital_status->FormValue) && $this->marital_status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->marital_status->FldCaption(), $this->marital_status->ReqErrMsg));
		}
		if (!$this->date_of_birth->FldIsDetailKey && !is_null($this->date_of_birth->FormValue) && $this->date_of_birth->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->date_of_birth->FldCaption(), $this->date_of_birth->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->date_of_birth->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_of_birth->FldErrMsg());
		}
		if (!$this->username->FldIsDetailKey && !is_null($this->username->FormValue) && $this->username->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterUserName"));
		}
		if (!$this->mobile->FldIsDetailKey && !is_null($this->mobile->FormValue) && $this->mobile->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->mobile->FldCaption(), $this->mobile->ReqErrMsg));
		}
		if (!$this->department->FldIsDetailKey && !is_null($this->department->FormValue) && $this->department->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->department->FldCaption(), $this->department->ReqErrMsg));
		}
		if (!$this->town_city->FldIsDetailKey && !is_null($this->town_city->FormValue) && $this->town_city->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->town_city->FldCaption(), $this->town_city->ReqErrMsg));
		}
		if (!$this->state_origin->FldIsDetailKey && !is_null($this->state_origin->FormValue) && $this->state_origin->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->state_origin->FldCaption(), $this->state_origin->ReqErrMsg));
		}
		if (!$this->local_gra->FldIsDetailKey && !is_null($this->local_gra->FormValue) && $this->local_gra->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->local_gra->FldCaption(), $this->local_gra->ReqErrMsg));
		}
		if (!$this->qualification_level->FldIsDetailKey && !is_null($this->qualification_level->FormValue) && $this->qualification_level->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->qualification_level->FldCaption(), $this->qualification_level->ReqErrMsg));
		}
		if (!$this->qualification_grade->FldIsDetailKey && !is_null($this->qualification_grade->FormValue) && $this->qualification_grade->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->qualification_grade->FldCaption(), $this->qualification_grade->ReqErrMsg));
		}
		if (!$this->password->FldIsDetailKey && !is_null($this->password->FormValue) && $this->password->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterPassword"));
		}
		if ($this->password->ConfirmValue <> $this->password->FormValue) {
			ew_AddMessage($gsFormError, $Language->Phrase("MismatchPassword"));
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
			$this->upload_of_credentcial->OldUploadPath = "uploads/";
			$this->upload_of_credentcial->UploadPath = $this->upload_of_credentcial->OldUploadPath;
		}
		$rsnew = array();

		// staff_id
		$this->staff_id->SetDbValueDef($rsnew, $this->staff_id->CurrentValue, 0, FALSE);

		// last_name
		$this->last_name->SetDbValueDef($rsnew, $this->last_name->CurrentValue, NULL, FALSE);

		// first_name
		$this->first_name->SetDbValueDef($rsnew, $this->first_name->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", FALSE);

		// gender
		$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, FALSE);

		// marital_status
		$this->marital_status->SetDbValueDef($rsnew, $this->marital_status->CurrentValue, NULL, FALSE);

		// date_of_birth
		$this->date_of_birth->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_of_birth->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// username
		$this->username->SetDbValueDef($rsnew, $this->username->CurrentValue, NULL, FALSE);

		// mobile
		$this->mobile->SetDbValueDef($rsnew, $this->mobile->CurrentValue, "", FALSE);

		// company
		$this->company->SetDbValueDef($rsnew, $this->company->CurrentValue, NULL, FALSE);

		// department
		$this->department->SetDbValueDef($rsnew, $this->department->CurrentValue, NULL, FALSE);

		// home_address
		$this->home_address->SetDbValueDef($rsnew, $this->home_address->CurrentValue, NULL, FALSE);

		// town_city
		$this->town_city->SetDbValueDef($rsnew, $this->town_city->CurrentValue, NULL, FALSE);

		// state_origin
		$this->state_origin->SetDbValueDef($rsnew, $this->state_origin->CurrentValue, NULL, FALSE);

		// local_gra
		$this->local_gra->SetDbValueDef($rsnew, $this->local_gra->CurrentValue, NULL, FALSE);

		// next_kin
		$this->next_kin->SetDbValueDef($rsnew, $this->next_kin->CurrentValue, NULL, FALSE);

		// resident_nxt_kin
		$this->resident_nxt_kin->SetDbValueDef($rsnew, $this->resident_nxt_kin->CurrentValue, NULL, FALSE);

		// nearest_bus_stop
		$this->nearest_bus_stop->SetDbValueDef($rsnew, $this->nearest_bus_stop->CurrentValue, NULL, FALSE);

		// town_city_nxt_kin
		$this->town_city_nxt_kin->SetDbValueDef($rsnew, $this->town_city_nxt_kin->CurrentValue, NULL, FALSE);

		// email_nxt_kin
		$this->email_nxt_kin->SetDbValueDef($rsnew, $this->email_nxt_kin->CurrentValue, NULL, FALSE);

		// phone_nxt_kin
		$this->phone_nxt_kin->SetDbValueDef($rsnew, $this->phone_nxt_kin->CurrentValue, NULL, FALSE);

		// qualification_level
		$this->qualification_level->SetDbValueDef($rsnew, $this->qualification_level->CurrentValue, NULL, FALSE);

		// qualification_grade
		$this->qualification_grade->SetDbValueDef($rsnew, $this->qualification_grade->CurrentValue, NULL, FALSE);

		// password
		$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", FALSE);

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

			// Call User Registered event
			$this->User_Registered($rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Style = "tabs";
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$this->MultiPages = $pages;
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
		case "x_town_city":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `code` AS `LinkFld`, `state_descriptions` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `states_table`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`state_descriptions`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`code` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->town_city, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_state_origin":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `code` AS `LinkFld`, `state_descriptions` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `states_table`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`state_descriptions`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`code` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->state_origin, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_local_gra":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `code` AS `LinkFld`, `lga_descriptions` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lga_states`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`lga_descriptions`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`code` IN ({filter_value})', "t0" => "3", "fn0" => "", "f1" => '`state_code` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->local_gra, $sWhereWrk); // Call Lookup Selecting
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
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

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

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// User Registered event
	function User_Registered(&$rs) {

		//echo "User_Registered";
	}

	// User Activated event
	function User_Activated(&$rs) {

		//echo "User_Activated";
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($register)) $register = new cregister();

// Page init
$register->Page_Init();

// Page main
$register->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$register->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "register";
var CurrentForm = fregister = new ew_Form("fregister", "register");

// Validate form
fregister.Validate = function() {
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
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->_email->FldCaption(), $user_profile->_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_gender");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->gender->FldCaption(), $user_profile->gender->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_marital_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->marital_status->FldCaption(), $user_profile->marital_status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_of_birth");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->date_of_birth->FldCaption(), $user_profile->date_of_birth->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_of_birth");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($user_profile->date_of_birth->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_username");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterUserName"));
			elm = this.GetElements("x" + infix + "_mobile");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->mobile->FldCaption(), $user_profile->mobile->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_department");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->department->FldCaption(), $user_profile->department->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_town_city");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->town_city->FldCaption(), $user_profile->town_city->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_state_origin");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->state_origin->FldCaption(), $user_profile->state_origin->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_local_gra");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->local_gra->FldCaption(), $user_profile->local_gra->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_qualification_level");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->qualification_level->FldCaption(), $user_profile->qualification_level->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_qualification_grade");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->qualification_grade->FldCaption(), $user_profile->qualification_grade->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterPassword"));
			if (fobj.c_password.value != fobj.x_password.value)
				return this.OnError(fobj.c_password, ewLanguage.Phrase("MismatchPassword"));

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fregister.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fregister.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fregister.MultiPage = new ew_MultiPage("fregister");

// Dynamic selection lists
fregister.Lists["x_gender"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fregister.Lists["x_gender"].Options = <?php echo json_encode($register->gender->Options()) ?>;
fregister.Lists["x_marital_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fregister.Lists["x_marital_status"].Options = <?php echo json_encode($register->marital_status->Options()) ?>;
fregister.Lists["x_company"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":["x_department"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fregister.Lists["x_company"].Data = "<?php echo $register->company->LookupFilterQuery(FALSE, "register") ?>";
fregister.Lists["x_department"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":["x_company"],"ChildFields":[],"FilterFields":["x_company_id"],"Options":[],"Template":"","LinkTable":"department"};
fregister.Lists["x_department"].Data = "<?php echo $register->department->LookupFilterQuery(FALSE, "register") ?>";
fregister.Lists["x_town_city"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_state_descriptions","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"states_table"};
fregister.Lists["x_town_city"].Data = "<?php echo $register->town_city->LookupFilterQuery(FALSE, "register") ?>";
fregister.Lists["x_state_origin"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_state_descriptions","","",""],"ParentFields":[],"ChildFields":["x_local_gra"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"states_table"};
fregister.Lists["x_state_origin"].Data = "<?php echo $register->state_origin->LookupFilterQuery(FALSE, "register") ?>";
fregister.Lists["x_local_gra"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_lga_descriptions","","",""],"ParentFields":["x_state_origin"],"ChildFields":[],"FilterFields":["x_state_code"],"Options":[],"Template":"","LinkTable":"lga_states"};
fregister.Lists["x_local_gra"].Data = "<?php echo $register->local_gra->LookupFilterQuery(FALSE, "register") ?>";
fregister.Lists["x_qualification_level"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fregister.Lists["x_qualification_level"].Options = <?php echo json_encode($register->qualification_level->Options()) ?>;
fregister.Lists["x_qualification_grade"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fregister.Lists["x_qualification_grade"].Options = <?php echo json_encode($register->qualification_grade->Options()) ?>;

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
<?php $register->ShowPageHeader(); ?>
<?php
$register->ShowMessage();
?>
<form name="fregister" id="fregister" class="<?php echo $register->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($register->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $register->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="user_profile">
<input type="hidden" name="a_register" id="a_register" value="A">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<?php if ($user_profile->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } ?>
<div class="ewMultiPage"><!-- multi-page -->
<div class="nav-tabs-custom" id="register"><!-- multi-page .nav-tabs-custom -->
	<ul class="nav<?php echo $register->MultiPages->NavStyle() ?>">
		<li<?php echo $register->MultiPages->TabStyle("1") ?>><a href="#tab_user_profile1" data-toggle="tab"><?php echo $user_profile->PageCaption(1) ?></a></li>
		<li<?php echo $register->MultiPages->TabStyle("2") ?>><a href="#tab_user_profile2" data-toggle="tab"><?php echo $user_profile->PageCaption(2) ?></a></li>
	</ul>
	<div class="tab-content"><!-- multi-page .nav-tabs-custom .tab-content -->
		<div class="tab-pane<?php echo $register->MultiPages->PageStyle("1") ?>" id="tab_user_profile1"><!-- multi-page .tab-pane -->
<div class="ewRegisterDiv"><!-- page* -->
<?php if ($user_profile->staff_id->Visible) { // staff_id ?>
	<div id="r_staff_id" class="form-group">
		<label id="elh_user_profile_staff_id" for="x_staff_id" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->staff_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->staff_id->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_staff_id">
<input type="text" data-table="user_profile" data-field="x_staff_id" data-page="1" name="x_staff_id" id="x_staff_id" placeholder="<?php echo ew_HtmlEncode($user_profile->staff_id->getPlaceHolder()) ?>" value="<?php echo $user_profile->staff_id->EditValue ?>"<?php echo $user_profile->staff_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_staff_id">
<span<?php echo $user_profile->staff_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->staff_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_staff_id" data-page="1" name="x_staff_id" id="x_staff_id" value="<?php echo ew_HtmlEncode($user_profile->staff_id->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->staff_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->last_name->Visible) { // last_name ?>
	<div id="r_last_name" class="form-group">
		<label id="elh_user_profile_last_name" for="x_last_name" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->last_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->last_name->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_last_name">
<input type="text" data-table="user_profile" data-field="x_last_name" data-page="1" name="x_last_name" id="x_last_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->last_name->getPlaceHolder()) ?>" value="<?php echo $user_profile->last_name->EditValue ?>"<?php echo $user_profile->last_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_last_name">
<span<?php echo $user_profile->last_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->last_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_last_name" data-page="1" name="x_last_name" id="x_last_name" value="<?php echo ew_HtmlEncode($user_profile->last_name->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->last_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->first_name->Visible) { // first_name ?>
	<div id="r_first_name" class="form-group">
		<label id="elh_user_profile_first_name" for="x_first_name" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->first_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->first_name->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_first_name">
<input type="text" data-table="user_profile" data-field="x_first_name" data-page="1" name="x_first_name" id="x_first_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->first_name->getPlaceHolder()) ?>" value="<?php echo $user_profile->first_name->EditValue ?>"<?php echo $user_profile->first_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_first_name">
<span<?php echo $user_profile->first_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->first_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_first_name" data-page="1" name="x_first_name" id="x_first_name" value="<?php echo ew_HtmlEncode($user_profile->first_name->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->first_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_user_profile__email" for="x__email" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->_email->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile__email">
<input type="text" data-table="user_profile" data-field="x__email" data-page="1" name="x__email" id="x__email" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($user_profile->_email->getPlaceHolder()) ?>" value="<?php echo $user_profile->_email->EditValue ?>"<?php echo $user_profile->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile__email">
<span<?php echo $user_profile->_email->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->_email->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x__email" data-page="1" name="x__email" id="x__email" value="<?php echo ew_HtmlEncode($user_profile->_email->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->gender->Visible) { // gender ?>
	<div id="r_gender" class="form-group">
		<label id="elh_user_profile_gender" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->gender->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->gender->CellAttributes() ?>>
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
<?php echo $user_profile->gender->RadioButtonListHtml(TRUE, "x_gender", 1) ?>
		</div>
	</div>
	<div id="tp_x_gender" class="ewTemplate"><input type="radio" data-table="user_profile" data-field="x_gender" data-page="1" data-value-separator="<?php echo $user_profile->gender->DisplayValueSeparatorAttribute() ?>" name="x_gender" id="x_gender" value="{value}"<?php echo $user_profile->gender->EditAttributes() ?>></div>
</div>
</span>
<?php } else { ?>
<span id="el_user_profile_gender">
<span<?php echo $user_profile->gender->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->gender->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_gender" data-page="1" name="x_gender" id="x_gender" value="<?php echo ew_HtmlEncode($user_profile->gender->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->gender->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->marital_status->Visible) { // marital_status ?>
	<div id="r_marital_status" class="form-group">
		<label id="elh_user_profile_marital_status" for="x_marital_status" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->marital_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->marital_status->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_marital_status">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($user_profile->marital_status->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $user_profile->marital_status->ViewValue ?>
	</span>
	<?php if (!$user_profile->marital_status->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_marital_status" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $user_profile->marital_status->RadioButtonListHtml(TRUE, "x_marital_status", 1) ?>
		</div>
	</div>
	<div id="tp_x_marital_status" class="ewTemplate"><input type="radio" data-table="user_profile" data-field="x_marital_status" data-page="1" data-value-separator="<?php echo $user_profile->marital_status->DisplayValueSeparatorAttribute() ?>" name="x_marital_status" id="x_marital_status" value="{value}"<?php echo $user_profile->marital_status->EditAttributes() ?>></div>
</div>
</span>
<?php } else { ?>
<span id="el_user_profile_marital_status">
<span<?php echo $user_profile->marital_status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->marital_status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_marital_status" data-page="1" name="x_marital_status" id="x_marital_status" value="<?php echo ew_HtmlEncode($user_profile->marital_status->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->marital_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->date_of_birth->Visible) { // date_of_birth ?>
	<div id="r_date_of_birth" class="form-group">
		<label id="elh_user_profile_date_of_birth" for="x_date_of_birth" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->date_of_birth->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->date_of_birth->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_date_of_birth">
<input type="text" data-table="user_profile" data-field="x_date_of_birth" data-page="1" data-format="7" name="x_date_of_birth" id="x_date_of_birth" size="10" placeholder="<?php echo ew_HtmlEncode($user_profile->date_of_birth->getPlaceHolder()) ?>" value="<?php echo $user_profile->date_of_birth->EditValue ?>"<?php echo $user_profile->date_of_birth->EditAttributes() ?>>
<?php if (!$user_profile->date_of_birth->ReadOnly && !$user_profile->date_of_birth->Disabled && !isset($user_profile->date_of_birth->EditAttrs["readonly"]) && !isset($user_profile->date_of_birth->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fregister", "x_date_of_birth", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_user_profile_date_of_birth">
<span<?php echo $user_profile->date_of_birth->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->date_of_birth->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_date_of_birth" data-page="1" name="x_date_of_birth" id="x_date_of_birth" value="<?php echo ew_HtmlEncode($user_profile->date_of_birth->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->date_of_birth->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->username->Visible) { // username ?>
	<div id="r_username" class="form-group">
		<label id="elh_user_profile_username" for="x_username" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->username->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_username">
<input type="text" data-table="user_profile" data-field="x_username" data-page="1" name="x_username" id="x_username" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->username->getPlaceHolder()) ?>" value="<?php echo $user_profile->username->EditValue ?>"<?php echo $user_profile->username->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_username">
<span<?php echo $user_profile->username->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->username->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_username" data-page="1" name="x_username" id="x_username" value="<?php echo ew_HtmlEncode($user_profile->username->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->username->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->mobile->Visible) { // mobile ?>
	<div id="r_mobile" class="form-group">
		<label id="elh_user_profile_mobile" for="x_mobile" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->mobile->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->mobile->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_mobile">
<input type="text" data-table="user_profile" data-field="x_mobile" data-page="1" name="x_mobile" id="x_mobile" size="30" maxlength="11" placeholder="<?php echo ew_HtmlEncode($user_profile->mobile->getPlaceHolder()) ?>" value="<?php echo $user_profile->mobile->EditValue ?>"<?php echo $user_profile->mobile->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_mobile">
<span<?php echo $user_profile->mobile->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->mobile->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_mobile" data-page="1" name="x_mobile" id="x_mobile" value="<?php echo ew_HtmlEncode($user_profile->mobile->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->company->Visible) { // company ?>
	<div id="r_company" class="form-group">
		<label id="elh_user_profile_company" for="x_company" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->company->FldCaption() ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->company->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_company">
<?php $user_profile->company->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$user_profile->company->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_company"><?php echo (strval($user_profile->company->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $user_profile->company->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($user_profile->company->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_company',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($user_profile->company->ReadOnly || $user_profile->company->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="user_profile" data-field="x_company" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $user_profile->company->DisplayValueSeparatorAttribute() ?>" name="x_company" id="x_company" value="<?php echo $user_profile->company->CurrentValue ?>"<?php echo $user_profile->company->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_company">
<span<?php echo $user_profile->company->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->company->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_company" data-page="1" name="x_company" id="x_company" value="<?php echo ew_HtmlEncode($user_profile->company->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->company->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->department->Visible) { // department ?>
	<div id="r_department" class="form-group">
		<label id="elh_user_profile_department" for="x_department" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->department->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->department->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_department">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_department"><?php echo (strval($user_profile->department->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $user_profile->department->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($user_profile->department->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_department',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($user_profile->department->ReadOnly || $user_profile->department->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="user_profile" data-field="x_department" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $user_profile->department->DisplayValueSeparatorAttribute() ?>" name="x_department" id="x_department" value="<?php echo $user_profile->department->CurrentValue ?>"<?php echo $user_profile->department->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_department">
<span<?php echo $user_profile->department->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->department->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_department" data-page="1" name="x_department" id="x_department" value="<?php echo ew_HtmlEncode($user_profile->department->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->department->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->home_address->Visible) { // home_address ?>
	<div id="r_home_address" class="form-group">
		<label id="elh_user_profile_home_address" for="x_home_address" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->home_address->FldCaption() ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->home_address->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_home_address">
<input type="text" data-table="user_profile" data-field="x_home_address" data-page="1" name="x_home_address" id="x_home_address" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($user_profile->home_address->getPlaceHolder()) ?>" value="<?php echo $user_profile->home_address->EditValue ?>"<?php echo $user_profile->home_address->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_home_address">
<span<?php echo $user_profile->home_address->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->home_address->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_home_address" data-page="1" name="x_home_address" id="x_home_address" value="<?php echo ew_HtmlEncode($user_profile->home_address->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->home_address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->town_city->Visible) { // town_city ?>
	<div id="r_town_city" class="form-group">
		<label id="elh_user_profile_town_city" for="x_town_city" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->town_city->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->town_city->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_town_city">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_town_city"><?php echo (strval($user_profile->town_city->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $user_profile->town_city->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($user_profile->town_city->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_town_city',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($user_profile->town_city->ReadOnly || $user_profile->town_city->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="user_profile" data-field="x_town_city" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $user_profile->town_city->DisplayValueSeparatorAttribute() ?>" name="x_town_city" id="x_town_city" value="<?php echo $user_profile->town_city->CurrentValue ?>"<?php echo $user_profile->town_city->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_town_city">
<span<?php echo $user_profile->town_city->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->town_city->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_town_city" data-page="1" name="x_town_city" id="x_town_city" value="<?php echo ew_HtmlEncode($user_profile->town_city->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->town_city->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->state_origin->Visible) { // state_origin ?>
	<div id="r_state_origin" class="form-group">
		<label id="elh_user_profile_state_origin" for="x_state_origin" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->state_origin->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->state_origin->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_state_origin">
<?php $user_profile->state_origin->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$user_profile->state_origin->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_state_origin"><?php echo (strval($user_profile->state_origin->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $user_profile->state_origin->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($user_profile->state_origin->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_state_origin',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($user_profile->state_origin->ReadOnly || $user_profile->state_origin->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="user_profile" data-field="x_state_origin" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $user_profile->state_origin->DisplayValueSeparatorAttribute() ?>" name="x_state_origin" id="x_state_origin" value="<?php echo $user_profile->state_origin->CurrentValue ?>"<?php echo $user_profile->state_origin->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_state_origin">
<span<?php echo $user_profile->state_origin->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->state_origin->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_state_origin" data-page="1" name="x_state_origin" id="x_state_origin" value="<?php echo ew_HtmlEncode($user_profile->state_origin->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->state_origin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->local_gra->Visible) { // local_gra ?>
	<div id="r_local_gra" class="form-group">
		<label id="elh_user_profile_local_gra" for="x_local_gra" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->local_gra->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->local_gra->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_local_gra">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_local_gra"><?php echo (strval($user_profile->local_gra->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $user_profile->local_gra->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($user_profile->local_gra->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_local_gra',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($user_profile->local_gra->ReadOnly || $user_profile->local_gra->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="user_profile" data-field="x_local_gra" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $user_profile->local_gra->DisplayValueSeparatorAttribute() ?>" name="x_local_gra" id="x_local_gra" value="<?php echo $user_profile->local_gra->CurrentValue ?>"<?php echo $user_profile->local_gra->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_local_gra">
<span<?php echo $user_profile->local_gra->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->local_gra->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_local_gra" data-page="1" name="x_local_gra" id="x_local_gra" value="<?php echo ew_HtmlEncode($user_profile->local_gra->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->local_gra->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $register->MultiPages->PageStyle("2") ?>" id="tab_user_profile2"><!-- multi-page .tab-pane -->
<div class="ewRegisterDiv"><!-- page* -->
<?php if ($user_profile->next_kin->Visible) { // next_kin ?>
	<div id="r_next_kin" class="form-group">
		<label id="elh_user_profile_next_kin" for="x_next_kin" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->next_kin->FldCaption() ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->next_kin->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_next_kin">
<input type="text" data-table="user_profile" data-field="x_next_kin" data-page="2" name="x_next_kin" id="x_next_kin" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($user_profile->next_kin->getPlaceHolder()) ?>" value="<?php echo $user_profile->next_kin->EditValue ?>"<?php echo $user_profile->next_kin->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_next_kin">
<span<?php echo $user_profile->next_kin->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->next_kin->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_next_kin" data-page="2" name="x_next_kin" id="x_next_kin" value="<?php echo ew_HtmlEncode($user_profile->next_kin->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->next_kin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->resident_nxt_kin->Visible) { // resident_nxt_kin ?>
	<div id="r_resident_nxt_kin" class="form-group">
		<label id="elh_user_profile_resident_nxt_kin" for="x_resident_nxt_kin" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->resident_nxt_kin->FldCaption() ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->resident_nxt_kin->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_resident_nxt_kin">
<input type="text" data-table="user_profile" data-field="x_resident_nxt_kin" data-page="2" name="x_resident_nxt_kin" id="x_resident_nxt_kin" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($user_profile->resident_nxt_kin->getPlaceHolder()) ?>" value="<?php echo $user_profile->resident_nxt_kin->EditValue ?>"<?php echo $user_profile->resident_nxt_kin->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_resident_nxt_kin">
<span<?php echo $user_profile->resident_nxt_kin->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->resident_nxt_kin->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_resident_nxt_kin" data-page="2" name="x_resident_nxt_kin" id="x_resident_nxt_kin" value="<?php echo ew_HtmlEncode($user_profile->resident_nxt_kin->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->resident_nxt_kin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->nearest_bus_stop->Visible) { // nearest_bus_stop ?>
	<div id="r_nearest_bus_stop" class="form-group">
		<label id="elh_user_profile_nearest_bus_stop" for="x_nearest_bus_stop" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->nearest_bus_stop->FldCaption() ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->nearest_bus_stop->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_nearest_bus_stop">
<input type="text" data-table="user_profile" data-field="x_nearest_bus_stop" data-page="2" name="x_nearest_bus_stop" id="x_nearest_bus_stop" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($user_profile->nearest_bus_stop->getPlaceHolder()) ?>" value="<?php echo $user_profile->nearest_bus_stop->EditValue ?>"<?php echo $user_profile->nearest_bus_stop->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_nearest_bus_stop">
<span<?php echo $user_profile->nearest_bus_stop->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->nearest_bus_stop->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_nearest_bus_stop" data-page="2" name="x_nearest_bus_stop" id="x_nearest_bus_stop" value="<?php echo ew_HtmlEncode($user_profile->nearest_bus_stop->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->nearest_bus_stop->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->town_city_nxt_kin->Visible) { // town_city_nxt_kin ?>
	<div id="r_town_city_nxt_kin" class="form-group">
		<label id="elh_user_profile_town_city_nxt_kin" for="x_town_city_nxt_kin" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->town_city_nxt_kin->FldCaption() ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->town_city_nxt_kin->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_town_city_nxt_kin">
<input type="text" data-table="user_profile" data-field="x_town_city_nxt_kin" data-page="2" name="x_town_city_nxt_kin" id="x_town_city_nxt_kin" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($user_profile->town_city_nxt_kin->getPlaceHolder()) ?>" value="<?php echo $user_profile->town_city_nxt_kin->EditValue ?>"<?php echo $user_profile->town_city_nxt_kin->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_town_city_nxt_kin">
<span<?php echo $user_profile->town_city_nxt_kin->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->town_city_nxt_kin->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_town_city_nxt_kin" data-page="2" name="x_town_city_nxt_kin" id="x_town_city_nxt_kin" value="<?php echo ew_HtmlEncode($user_profile->town_city_nxt_kin->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->town_city_nxt_kin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->email_nxt_kin->Visible) { // email_nxt_kin ?>
	<div id="r_email_nxt_kin" class="form-group">
		<label id="elh_user_profile_email_nxt_kin" for="x_email_nxt_kin" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->email_nxt_kin->FldCaption() ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->email_nxt_kin->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_email_nxt_kin">
<input type="text" data-table="user_profile" data-field="x_email_nxt_kin" data-page="2" name="x_email_nxt_kin" id="x_email_nxt_kin" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->email_nxt_kin->getPlaceHolder()) ?>" value="<?php echo $user_profile->email_nxt_kin->EditValue ?>"<?php echo $user_profile->email_nxt_kin->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_email_nxt_kin">
<span<?php echo $user_profile->email_nxt_kin->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->email_nxt_kin->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_email_nxt_kin" data-page="2" name="x_email_nxt_kin" id="x_email_nxt_kin" value="<?php echo ew_HtmlEncode($user_profile->email_nxt_kin->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->email_nxt_kin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->phone_nxt_kin->Visible) { // phone_nxt_kin ?>
	<div id="r_phone_nxt_kin" class="form-group">
		<label id="elh_user_profile_phone_nxt_kin" for="x_phone_nxt_kin" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->phone_nxt_kin->FldCaption() ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->phone_nxt_kin->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_phone_nxt_kin">
<input type="text" data-table="user_profile" data-field="x_phone_nxt_kin" data-page="2" name="x_phone_nxt_kin" id="x_phone_nxt_kin" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($user_profile->phone_nxt_kin->getPlaceHolder()) ?>" value="<?php echo $user_profile->phone_nxt_kin->EditValue ?>"<?php echo $user_profile->phone_nxt_kin->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_user_profile_phone_nxt_kin">
<span<?php echo $user_profile->phone_nxt_kin->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->phone_nxt_kin->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_phone_nxt_kin" data-page="2" name="x_phone_nxt_kin" id="x_phone_nxt_kin" value="<?php echo ew_HtmlEncode($user_profile->phone_nxt_kin->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->phone_nxt_kin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->qualification_level->Visible) { // qualification_level ?>
	<div id="r_qualification_level" class="form-group">
		<label id="elh_user_profile_qualification_level" for="x_qualification_level" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->qualification_level->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->qualification_level->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_qualification_level">
<select data-table="user_profile" data-field="x_qualification_level" data-page="2" data-value-separator="<?php echo $user_profile->qualification_level->DisplayValueSeparatorAttribute() ?>" id="x_qualification_level" name="x_qualification_level"<?php echo $user_profile->qualification_level->EditAttributes() ?>>
<?php echo $user_profile->qualification_level->SelectOptionListHtml("x_qualification_level") ?>
</select>
</span>
<?php } else { ?>
<span id="el_user_profile_qualification_level">
<span<?php echo $user_profile->qualification_level->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->qualification_level->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_qualification_level" data-page="2" name="x_qualification_level" id="x_qualification_level" value="<?php echo ew_HtmlEncode($user_profile->qualification_level->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->qualification_level->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->qualification_grade->Visible) { // qualification_grade ?>
	<div id="r_qualification_grade" class="form-group">
		<label id="elh_user_profile_qualification_grade" for="x_qualification_grade" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->qualification_grade->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->qualification_grade->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_qualification_grade">
<select data-table="user_profile" data-field="x_qualification_grade" data-page="2" data-value-separator="<?php echo $user_profile->qualification_grade->DisplayValueSeparatorAttribute() ?>" id="x_qualification_grade" name="x_qualification_grade"<?php echo $user_profile->qualification_grade->EditAttributes() ?>>
<?php echo $user_profile->qualification_grade->SelectOptionListHtml("x_qualification_grade") ?>
</select>
</span>
<?php } else { ?>
<span id="el_user_profile_qualification_grade">
<span<?php echo $user_profile->qualification_grade->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->qualification_grade->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_qualification_grade" data-page="2" name="x_qualification_grade" id="x_qualification_grade" value="<?php echo ew_HtmlEncode($user_profile->qualification_grade->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->qualification_grade->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->password->Visible) { // password ?>
	<div id="r_password" class="form-group">
		<label id="elh_user_profile_password" for="x_password" class="<?php echo $register->LeftColumnClass ?>"><?php echo $user_profile->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->password->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_password">
<div class="input-group" id="ig_password">
<input type="password" data-password-generated="pgt_password" data-table="user_profile" data-field="x_password" data-page="2" name="x_password" id="x_password" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->password->getPlaceHolder()) ?>"<?php echo $user_profile->password->EditAttributes() ?>>
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
<input type="hidden" data-table="user_profile" data-field="x_password" data-page="2" name="x_password" id="x_password" value="<?php echo ew_HtmlEncode($user_profile->password->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->password->Visible) { // password ?>
	<div id="r_c_password" class="form-group">
		<label id="elh_c_user_profile_password" for="c_password" class="<?php echo $register->LeftColumnClass ?>"><?php echo $Language->Phrase("Confirm") ?> <?php echo $user_profile->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $register->RightColumnClass ?>"><div<?php echo $user_profile->password->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_c_user_profile_password">
<input type="password" data-field="c_password" name="c_password" id="c_password" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->password->getPlaceHolder()) ?>"<?php echo $user_profile->password->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_c_user_profile_password">
<span<?php echo $user_profile->password->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->password->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="c_password" data-page="2" name="c_password" id="c_password" value="<?php echo ew_HtmlEncode($user_profile->password->FormValue) ?>">
<?php } ?>
</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
	</div><!-- /multi-page .nav-tabs-custom .tab-content -->
</div><!-- /multi-page .nav-tabs-custom -->
</div><!-- /multi-page -->
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $register->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($user_profile->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_register.value='F';"><?php echo $Language->Phrase("RegisterBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_register.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
</form>
<script type="text/javascript">
fregister.Init();
</script>
<?php
$register->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$register->Page_Terminate();
?>
