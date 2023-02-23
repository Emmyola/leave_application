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

$leave_form_add = NULL; // Initialize page object first

class cleave_form_add extends cleave_form {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'leave_form';

	// Page object name
	var $PageObjName = 'leave_form_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		$this->initiator_action->SetVisibility();
		$this->initiator_comments->SetVisibility();
		$this->verified_staff->SetVisibility();
		$this->verified_replacement_staff->SetVisibility();
		$this->recommender_action->SetVisibility();
		$this->recommender_comments->SetVisibility();
		$this->approver_action->SetVisibility();
		$this->approver_comments->SetVisibility();
		$this->last_updated_date->SetVisibility();

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "leave_formview.php")
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
	var $MultiPages; // Multi pages object

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
					$this->Page_Terminate("leave_formlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "leave_formlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "leave_formview.php")
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
		$this->leave_id->CurrentValue = NULL;
		$this->leave_id->OldValue = $this->leave_id->CurrentValue;
		$this->date_created->CurrentValue = NULL;
		$this->time->CurrentValue = NULL;
		$this->time->OldValue = $this->time->CurrentValue;
		$this->staff_id->CurrentValue = NULL;
		$this->staff_id->OldValue = $this->staff_id->CurrentValue;
		$this->staff_name->CurrentValue = NULL;
		$this->staff_name->OldValue = $this->staff_name->CurrentValue;
		$this->company->CurrentValue = NULL;
		$this->company->OldValue = $this->company->CurrentValue;
		$this->department->CurrentValue = NULL;
		$this->department->OldValue = $this->department->CurrentValue;
		$this->leave_type->CurrentValue = NULL;
		$this->leave_type->OldValue = $this->leave_type->CurrentValue;
		$this->start_date->CurrentValue = NULL;
		$this->start_date->OldValue = $this->start_date->CurrentValue;
		$this->end_date->CurrentValue = NULL;
		$this->end_date->OldValue = $this->end_date->CurrentValue;
		$this->no_of_days->CurrentValue = 0;
		$this->resumption_date->CurrentValue = NULL;
		$this->resumption_date->OldValue = $this->resumption_date->CurrentValue;
		$this->replacement_assign_staff->CurrentValue = NULL;
		$this->replacement_assign_staff->OldValue = $this->replacement_assign_staff->CurrentValue;
		$this->purpose_of_leave->CurrentValue = NULL;
		$this->purpose_of_leave->OldValue = $this->purpose_of_leave->CurrentValue;
		$this->status->CurrentValue = 0;
		$this->initiator_action->CurrentValue = NULL;
		$this->initiator_action->OldValue = $this->initiator_action->CurrentValue;
		$this->initiator_comments->CurrentValue = NULL;
		$this->initiator_comments->OldValue = $this->initiator_comments->CurrentValue;
		$this->verified_staff->CurrentValue = NULL;
		$this->verified_staff->OldValue = $this->verified_staff->CurrentValue;
		$this->verified_replacement_staff->CurrentValue = NULL;
		$this->verified_replacement_staff->OldValue = $this->verified_replacement_staff->CurrentValue;
		$this->recommender_action->CurrentValue = NULL;
		$this->recommender_action->OldValue = $this->recommender_action->CurrentValue;
		$this->recommender_comments->CurrentValue = NULL;
		$this->recommender_comments->OldValue = $this->recommender_comments->CurrentValue;
		$this->approver_action->CurrentValue = NULL;
		$this->approver_action->OldValue = $this->approver_action->CurrentValue;
		$this->approver_comments->CurrentValue = NULL;
		$this->approver_comments->OldValue = $this->approver_comments->CurrentValue;
		$this->last_updated_date->CurrentValue = NULL;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->leave_id->FldIsDetailKey) {
			$this->leave_id->setFormValue($objForm->GetValue("x_leave_id"));
		}
		if (!$this->date_created->FldIsDetailKey) {
			$this->date_created->setFormValue($objForm->GetValue("x_date_created"));
			$this->date_created->CurrentValue = ew_UnFormatDateTime($this->date_created->CurrentValue, 7);
		}
		if (!$this->time->FldIsDetailKey) {
			$this->time->setFormValue($objForm->GetValue("x_time"));
			$this->time->CurrentValue = ew_UnFormatDateTime($this->time->CurrentValue, 3);
		}
		if (!$this->staff_id->FldIsDetailKey) {
			$this->staff_id->setFormValue($objForm->GetValue("x_staff_id"));
		}
		if (!$this->staff_name->FldIsDetailKey) {
			$this->staff_name->setFormValue($objForm->GetValue("x_staff_name"));
		}
		if (!$this->company->FldIsDetailKey) {
			$this->company->setFormValue($objForm->GetValue("x_company"));
		}
		if (!$this->department->FldIsDetailKey) {
			$this->department->setFormValue($objForm->GetValue("x_department"));
		}
		if (!$this->leave_type->FldIsDetailKey) {
			$this->leave_type->setFormValue($objForm->GetValue("x_leave_type"));
		}
		if (!$this->start_date->FldIsDetailKey) {
			$this->start_date->setFormValue($objForm->GetValue("x_start_date"));
			$this->start_date->CurrentValue = ew_UnFormatDateTime($this->start_date->CurrentValue, 14);
		}
		if (!$this->end_date->FldIsDetailKey) {
			$this->end_date->setFormValue($objForm->GetValue("x_end_date"));
			$this->end_date->CurrentValue = ew_UnFormatDateTime($this->end_date->CurrentValue, 14);
		}
		if (!$this->no_of_days->FldIsDetailKey) {
			$this->no_of_days->setFormValue($objForm->GetValue("x_no_of_days"));
		}
		if (!$this->resumption_date->FldIsDetailKey) {
			$this->resumption_date->setFormValue($objForm->GetValue("x_resumption_date"));
			$this->resumption_date->CurrentValue = ew_UnFormatDateTime($this->resumption_date->CurrentValue, 14);
		}
		if (!$this->replacement_assign_staff->FldIsDetailKey) {
			$this->replacement_assign_staff->setFormValue($objForm->GetValue("x_replacement_assign_staff"));
		}
		if (!$this->purpose_of_leave->FldIsDetailKey) {
			$this->purpose_of_leave->setFormValue($objForm->GetValue("x_purpose_of_leave"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->initiator_action->FldIsDetailKey) {
			$this->initiator_action->setFormValue($objForm->GetValue("x_initiator_action"));
		}
		if (!$this->initiator_comments->FldIsDetailKey) {
			$this->initiator_comments->setFormValue($objForm->GetValue("x_initiator_comments"));
		}
		if (!$this->verified_staff->FldIsDetailKey) {
			$this->verified_staff->setFormValue($objForm->GetValue("x_verified_staff"));
		}
		if (!$this->verified_replacement_staff->FldIsDetailKey) {
			$this->verified_replacement_staff->setFormValue($objForm->GetValue("x_verified_replacement_staff"));
		}
		if (!$this->recommender_action->FldIsDetailKey) {
			$this->recommender_action->setFormValue($objForm->GetValue("x_recommender_action"));
		}
		if (!$this->recommender_comments->FldIsDetailKey) {
			$this->recommender_comments->setFormValue($objForm->GetValue("x_recommender_comments"));
		}
		if (!$this->approver_action->FldIsDetailKey) {
			$this->approver_action->setFormValue($objForm->GetValue("x_approver_action"));
		}
		if (!$this->approver_comments->FldIsDetailKey) {
			$this->approver_comments->setFormValue($objForm->GetValue("x_approver_comments"));
		}
		if (!$this->last_updated_date->FldIsDetailKey) {
			$this->last_updated_date->setFormValue($objForm->GetValue("x_last_updated_date"));
			$this->last_updated_date->CurrentValue = ew_UnFormatDateTime($this->last_updated_date->CurrentValue, 7);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->leave_id->CurrentValue = $this->leave_id->FormValue;
		$this->date_created->CurrentValue = $this->date_created->FormValue;
		$this->date_created->CurrentValue = ew_UnFormatDateTime($this->date_created->CurrentValue, 7);
		$this->time->CurrentValue = $this->time->FormValue;
		$this->time->CurrentValue = ew_UnFormatDateTime($this->time->CurrentValue, 3);
		$this->staff_id->CurrentValue = $this->staff_id->FormValue;
		$this->staff_name->CurrentValue = $this->staff_name->FormValue;
		$this->company->CurrentValue = $this->company->FormValue;
		$this->department->CurrentValue = $this->department->FormValue;
		$this->leave_type->CurrentValue = $this->leave_type->FormValue;
		$this->start_date->CurrentValue = $this->start_date->FormValue;
		$this->start_date->CurrentValue = ew_UnFormatDateTime($this->start_date->CurrentValue, 14);
		$this->end_date->CurrentValue = $this->end_date->FormValue;
		$this->end_date->CurrentValue = ew_UnFormatDateTime($this->end_date->CurrentValue, 14);
		$this->no_of_days->CurrentValue = $this->no_of_days->FormValue;
		$this->resumption_date->CurrentValue = $this->resumption_date->FormValue;
		$this->resumption_date->CurrentValue = ew_UnFormatDateTime($this->resumption_date->CurrentValue, 14);
		$this->replacement_assign_staff->CurrentValue = $this->replacement_assign_staff->FormValue;
		$this->purpose_of_leave->CurrentValue = $this->purpose_of_leave->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->initiator_action->CurrentValue = $this->initiator_action->FormValue;
		$this->initiator_comments->CurrentValue = $this->initiator_comments->FormValue;
		$this->verified_staff->CurrentValue = $this->verified_staff->FormValue;
		$this->verified_replacement_staff->CurrentValue = $this->verified_replacement_staff->FormValue;
		$this->recommender_action->CurrentValue = $this->recommender_action->FormValue;
		$this->recommender_comments->CurrentValue = $this->recommender_comments->FormValue;
		$this->approver_action->CurrentValue = $this->approver_action->FormValue;
		$this->approver_comments->CurrentValue = $this->approver_comments->FormValue;
		$this->last_updated_date->CurrentValue = $this->last_updated_date->FormValue;
		$this->last_updated_date->CurrentValue = ew_UnFormatDateTime($this->last_updated_date->CurrentValue, 7);
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
		$this->date_created->setDbValue($row['date_created']);
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
		$this->replacement_assign_staff->setDbValue($row['replacement_assign_staff']);
		$this->purpose_of_leave->setDbValue($row['purpose_of_leave']);
		$this->status->setDbValue($row['status']);
		$this->initiator_action->setDbValue($row['initiator_action']);
		$this->initiator_comments->setDbValue($row['initiator_comments']);
		$this->verified_staff->setDbValue($row['verified_staff']);
		$this->verified_replacement_staff->setDbValue($row['verified_replacement_staff']);
		$this->recommender_action->setDbValue($row['recommender_action']);
		$this->recommender_comments->setDbValue($row['recommender_comments']);
		$this->approver_action->setDbValue($row['approver_action']);
		$this->approver_comments->setDbValue($row['approver_comments']);
		$this->last_updated_date->setDbValue($row['last_updated_date']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['leave_id'] = $this->leave_id->CurrentValue;
		$row['date_created'] = $this->date_created->CurrentValue;
		$row['time'] = $this->time->CurrentValue;
		$row['staff_id'] = $this->staff_id->CurrentValue;
		$row['staff_name'] = $this->staff_name->CurrentValue;
		$row['company'] = $this->company->CurrentValue;
		$row['department'] = $this->department->CurrentValue;
		$row['leave_type'] = $this->leave_type->CurrentValue;
		$row['start_date'] = $this->start_date->CurrentValue;
		$row['end_date'] = $this->end_date->CurrentValue;
		$row['no_of_days'] = $this->no_of_days->CurrentValue;
		$row['resumption_date'] = $this->resumption_date->CurrentValue;
		$row['replacement_assign_staff'] = $this->replacement_assign_staff->CurrentValue;
		$row['purpose_of_leave'] = $this->purpose_of_leave->CurrentValue;
		$row['status'] = $this->status->CurrentValue;
		$row['initiator_action'] = $this->initiator_action->CurrentValue;
		$row['initiator_comments'] = $this->initiator_comments->CurrentValue;
		$row['verified_staff'] = $this->verified_staff->CurrentValue;
		$row['verified_replacement_staff'] = $this->verified_replacement_staff->CurrentValue;
		$row['recommender_action'] = $this->recommender_action->CurrentValue;
		$row['recommender_comments'] = $this->recommender_comments->CurrentValue;
		$row['approver_action'] = $this->approver_action->CurrentValue;
		$row['approver_comments'] = $this->approver_comments->CurrentValue;
		$row['last_updated_date'] = $this->last_updated_date->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->leave_id->DbValue = $row['leave_id'];
		$this->date_created->DbValue = $row['date_created'];
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
		$this->replacement_assign_staff->DbValue = $row['replacement_assign_staff'];
		$this->purpose_of_leave->DbValue = $row['purpose_of_leave'];
		$this->status->DbValue = $row['status'];
		$this->initiator_action->DbValue = $row['initiator_action'];
		$this->initiator_comments->DbValue = $row['initiator_comments'];
		$this->verified_staff->DbValue = $row['verified_staff'];
		$this->verified_replacement_staff->DbValue = $row['verified_replacement_staff'];
		$this->recommender_action->DbValue = $row['recommender_action'];
		$this->recommender_comments->DbValue = $row['recommender_comments'];
		$this->approver_action->DbValue = $row['approver_action'];
		$this->approver_comments->DbValue = $row['approver_comments'];
		$this->last_updated_date->DbValue = $row['last_updated_date'];
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
		// initiator_action
		// initiator_comments
		// verified_staff
		// verified_replacement_staff
		// recommender_action
		// recommender_comments
		// approver_action
		// approver_comments
		// last_updated_date

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// leave_id
		$this->leave_id->ViewValue = $this->leave_id->CurrentValue;
		$this->leave_id->ViewCustomAttributes = "";

		// date_created
		$this->date_created->ViewValue = $this->date_created->CurrentValue;
		$this->date_created->ViewValue = ew_FormatDateTime($this->date_created->ViewValue, 7);
		$this->date_created->ViewCustomAttributes = "";

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

		// replacement_assign_staff
		if (strval($this->replacement_assign_staff->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->replacement_assign_staff->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `first_name` AS `DispFld`, `last_name` AS `Disp2Fld`, `mobile` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `user_profile`";
		$sWhereWrk = "";
		$this->replacement_assign_staff->LookupFilters = array("dx1" => '`first_name`', "dx2" => '`last_name`', "dx3" => '`mobile`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->replacement_assign_staff, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->replacement_assign_staff->ViewValue = $this->replacement_assign_staff->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->replacement_assign_staff->ViewValue = $this->replacement_assign_staff->CurrentValue;
			}
		} else {
			$this->replacement_assign_staff->ViewValue = NULL;
		}
		$this->replacement_assign_staff->ViewCustomAttributes = "";

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

		// verified_staff
		if (strval($this->verified_staff->CurrentValue) <> "") {
			$this->verified_staff->ViewValue = $this->verified_staff->OptionCaption($this->verified_staff->CurrentValue);
		} else {
			$this->verified_staff->ViewValue = NULL;
		}
		$this->verified_staff->ViewCustomAttributes = "";

		// verified_replacement_staff
		if (strval($this->verified_replacement_staff->CurrentValue) <> "") {
			$this->verified_replacement_staff->ViewValue = $this->verified_replacement_staff->OptionCaption($this->verified_replacement_staff->CurrentValue);
		} else {
			$this->verified_replacement_staff->ViewValue = NULL;
		}
		$this->verified_replacement_staff->ViewCustomAttributes = "";

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

		// last_updated_date
		$this->last_updated_date->ViewValue = $this->last_updated_date->CurrentValue;
		$this->last_updated_date->ViewValue = ew_FormatDateTime($this->last_updated_date->ViewValue, 7);
		$this->last_updated_date->ViewCustomAttributes = "";

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

			// initiator_action
			$this->initiator_action->LinkCustomAttributes = "";
			$this->initiator_action->HrefValue = "";
			$this->initiator_action->TooltipValue = "";

			// initiator_comments
			$this->initiator_comments->LinkCustomAttributes = "";
			$this->initiator_comments->HrefValue = "";
			$this->initiator_comments->TooltipValue = "";

			// verified_staff
			$this->verified_staff->LinkCustomAttributes = "";
			$this->verified_staff->HrefValue = "";
			$this->verified_staff->TooltipValue = "";

			// verified_replacement_staff
			$this->verified_replacement_staff->LinkCustomAttributes = "";
			$this->verified_replacement_staff->HrefValue = "";
			$this->verified_replacement_staff->TooltipValue = "";

			// recommender_action
			$this->recommender_action->LinkCustomAttributes = "";
			$this->recommender_action->HrefValue = "";
			$this->recommender_action->TooltipValue = "";

			// recommender_comments
			$this->recommender_comments->LinkCustomAttributes = "";
			$this->recommender_comments->HrefValue = "";
			$this->recommender_comments->TooltipValue = "";

			// approver_action
			$this->approver_action->LinkCustomAttributes = "";
			$this->approver_action->HrefValue = "";
			$this->approver_action->TooltipValue = "";

			// approver_comments
			$this->approver_comments->LinkCustomAttributes = "";
			$this->approver_comments->HrefValue = "";
			$this->approver_comments->TooltipValue = "";

			// last_updated_date
			$this->last_updated_date->LinkCustomAttributes = "";
			$this->last_updated_date->HrefValue = "";
			$this->last_updated_date->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// leave_id
			$this->leave_id->EditAttrs["class"] = "form-control";
			$this->leave_id->EditCustomAttributes = "";
			$this->leave_id->EditValue = ew_HtmlEncode($this->leave_id->CurrentValue);
			$this->leave_id->PlaceHolder = ew_RemoveHtml($this->leave_id->FldCaption());

			// date_created
			$this->date_created->EditAttrs["class"] = "form-control";
			$this->date_created->EditCustomAttributes = "";
			$this->date_created->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_created->CurrentValue, 7));
			$this->date_created->PlaceHolder = ew_RemoveHtml($this->date_created->FldCaption());

			// time
			$this->time->EditAttrs["class"] = "form-control";
			$this->time->EditCustomAttributes = "";
			$this->time->EditValue = ew_HtmlEncode($this->time->CurrentValue);
			$this->time->PlaceHolder = ew_RemoveHtml($this->time->FldCaption());

			// staff_id
			$this->staff_id->EditAttrs["class"] = "form-control";
			$this->staff_id->EditCustomAttributes = "";
			$this->staff_id->EditValue = ew_HtmlEncode($this->staff_id->CurrentValue);
			$this->staff_id->PlaceHolder = ew_RemoveHtml($this->staff_id->FldCaption());

			// staff_name
			$this->staff_name->EditAttrs["class"] = "form-control";
			$this->staff_name->EditCustomAttributes = "";
			$this->staff_name->EditValue = ew_HtmlEncode($this->staff_name->CurrentValue);
			$this->staff_name->PlaceHolder = ew_RemoveHtml($this->staff_name->FldCaption());

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
			$this->department->EditAttrs["class"] = "form-control";
			$this->department->EditCustomAttributes = "";
			if (trim(strval($this->department->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`code`" . ew_SearchString("=", $this->department->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `code`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `company_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `department`";
			$sWhereWrk = "";
			$this->department->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->department, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->department->EditValue = $arwrk;

			// leave_type
			$this->leave_type->EditAttrs["class"] = "form-control";
			$this->leave_type->EditCustomAttributes = "";
			if (trim(strval($this->leave_type->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`code`" . ew_SearchString("=", $this->leave_type->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `code`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `leave_type`";
			$sWhereWrk = "";
			$this->leave_type->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->leave_type, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `description` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->leave_type->EditValue = $arwrk;

			// start_date
			$this->start_date->EditAttrs["class"] = "form-control";
			$this->start_date->EditCustomAttributes = "";
			$this->start_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->start_date->CurrentValue, 14));
			$this->start_date->PlaceHolder = ew_RemoveHtml($this->start_date->FldCaption());

			// end_date
			$this->end_date->EditAttrs["class"] = "form-control";
			$this->end_date->EditCustomAttributes = "";
			$this->end_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->end_date->CurrentValue, 14));
			$this->end_date->PlaceHolder = ew_RemoveHtml($this->end_date->FldCaption());

			// no_of_days
			$this->no_of_days->EditAttrs["class"] = "form-control";
			$this->no_of_days->EditCustomAttributes = "";
			$this->no_of_days->EditValue = ew_HtmlEncode($this->no_of_days->CurrentValue);
			$this->no_of_days->PlaceHolder = ew_RemoveHtml($this->no_of_days->FldCaption());

			// resumption_date
			$this->resumption_date->EditAttrs["class"] = "form-control";
			$this->resumption_date->EditCustomAttributes = "";
			$this->resumption_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->resumption_date->CurrentValue, 14));
			$this->resumption_date->PlaceHolder = ew_RemoveHtml($this->resumption_date->FldCaption());

			// replacement_assign_staff
			$this->replacement_assign_staff->EditCustomAttributes = "";
			if (trim(strval($this->replacement_assign_staff->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->replacement_assign_staff->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `first_name` AS `DispFld`, `last_name` AS `Disp2Fld`, `mobile` AS `Disp3Fld`, '' AS `Disp4Fld`, `company` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `user_profile`";
			$sWhereWrk = "";
			$this->replacement_assign_staff->LookupFilters = array("dx1" => '`first_name`', "dx2" => '`last_name`', "dx3" => '`mobile`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			if (!$GLOBALS["leave_form"]->UserIDAllow("add")) $sWhereWrk = $GLOBALS["user_profile"]->AddUserIDFilter($sWhereWrk);
			$this->Lookup_Selecting($this->replacement_assign_staff, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
				$this->replacement_assign_staff->ViewValue = $this->replacement_assign_staff->DisplayValue($arwrk);
			} else {
				$this->replacement_assign_staff->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->replacement_assign_staff->EditValue = $arwrk;

			// purpose_of_leave
			$this->purpose_of_leave->EditAttrs["class"] = "form-control";
			$this->purpose_of_leave->EditCustomAttributes = "";
			$this->purpose_of_leave->EditValue = ew_HtmlEncode($this->purpose_of_leave->CurrentValue);
			$this->purpose_of_leave->PlaceHolder = ew_RemoveHtml($this->purpose_of_leave->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = ew_HtmlEncode($this->status->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->status->EditValue = $this->status->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->status->EditValue = ew_HtmlEncode($this->status->CurrentValue);
				}
			} else {
				$this->status->EditValue = NULL;
			}
			$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

			// initiator_action
			$this->initiator_action->EditCustomAttributes = "";
			$this->initiator_action->EditValue = $this->initiator_action->Options(FALSE);

			// initiator_comments
			$this->initiator_comments->EditAttrs["class"] = "form-control";
			$this->initiator_comments->EditCustomAttributes = "";
			$this->initiator_comments->EditValue = ew_HtmlEncode($this->initiator_comments->CurrentValue);
			$this->initiator_comments->PlaceHolder = ew_RemoveHtml($this->initiator_comments->FldCaption());

			// verified_staff
			$this->verified_staff->EditCustomAttributes = "";
			$this->verified_staff->EditValue = $this->verified_staff->Options(FALSE);

			// verified_replacement_staff
			$this->verified_replacement_staff->EditCustomAttributes = "";
			$this->verified_replacement_staff->EditValue = $this->verified_replacement_staff->Options(FALSE);

			// recommender_action
			$this->recommender_action->EditCustomAttributes = "";
			$this->recommender_action->EditValue = $this->recommender_action->Options(FALSE);

			// recommender_comments
			$this->recommender_comments->EditAttrs["class"] = "form-control";
			$this->recommender_comments->EditCustomAttributes = "";
			$this->recommender_comments->EditValue = ew_HtmlEncode($this->recommender_comments->CurrentValue);
			$this->recommender_comments->PlaceHolder = ew_RemoveHtml($this->recommender_comments->FldCaption());

			// approver_action
			$this->approver_action->EditCustomAttributes = "";
			$this->approver_action->EditValue = $this->approver_action->Options(FALSE);

			// approver_comments
			$this->approver_comments->EditAttrs["class"] = "form-control";
			$this->approver_comments->EditCustomAttributes = "";
			$this->approver_comments->EditValue = ew_HtmlEncode($this->approver_comments->CurrentValue);
			$this->approver_comments->PlaceHolder = ew_RemoveHtml($this->approver_comments->FldCaption());

			// last_updated_date
			$this->last_updated_date->EditAttrs["class"] = "form-control";
			$this->last_updated_date->EditCustomAttributes = "";
			$this->last_updated_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->last_updated_date->CurrentValue, 7));
			$this->last_updated_date->PlaceHolder = ew_RemoveHtml($this->last_updated_date->FldCaption());

			// Add refer script
			// leave_id

			$this->leave_id->LinkCustomAttributes = "";
			$this->leave_id->HrefValue = "";

			// date_created
			$this->date_created->LinkCustomAttributes = "";
			$this->date_created->HrefValue = "";

			// time
			$this->time->LinkCustomAttributes = "";
			$this->time->HrefValue = "";

			// staff_id
			$this->staff_id->LinkCustomAttributes = "";
			$this->staff_id->HrefValue = "";

			// staff_name
			$this->staff_name->LinkCustomAttributes = "";
			$this->staff_name->HrefValue = "";

			// company
			$this->company->LinkCustomAttributes = "";
			$this->company->HrefValue = "";

			// department
			$this->department->LinkCustomAttributes = "";
			$this->department->HrefValue = "";

			// leave_type
			$this->leave_type->LinkCustomAttributes = "";
			$this->leave_type->HrefValue = "";

			// start_date
			$this->start_date->LinkCustomAttributes = "";
			$this->start_date->HrefValue = "";

			// end_date
			$this->end_date->LinkCustomAttributes = "";
			$this->end_date->HrefValue = "";

			// no_of_days
			$this->no_of_days->LinkCustomAttributes = "";
			$this->no_of_days->HrefValue = "";

			// resumption_date
			$this->resumption_date->LinkCustomAttributes = "";
			$this->resumption_date->HrefValue = "";

			// replacement_assign_staff
			$this->replacement_assign_staff->LinkCustomAttributes = "";
			$this->replacement_assign_staff->HrefValue = "";

			// purpose_of_leave
			$this->purpose_of_leave->LinkCustomAttributes = "";
			$this->purpose_of_leave->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// initiator_action
			$this->initiator_action->LinkCustomAttributes = "";
			$this->initiator_action->HrefValue = "";

			// initiator_comments
			$this->initiator_comments->LinkCustomAttributes = "";
			$this->initiator_comments->HrefValue = "";

			// verified_staff
			$this->verified_staff->LinkCustomAttributes = "";
			$this->verified_staff->HrefValue = "";

			// verified_replacement_staff
			$this->verified_replacement_staff->LinkCustomAttributes = "";
			$this->verified_replacement_staff->HrefValue = "";

			// recommender_action
			$this->recommender_action->LinkCustomAttributes = "";
			$this->recommender_action->HrefValue = "";

			// recommender_comments
			$this->recommender_comments->LinkCustomAttributes = "";
			$this->recommender_comments->HrefValue = "";

			// approver_action
			$this->approver_action->LinkCustomAttributes = "";
			$this->approver_action->HrefValue = "";

			// approver_comments
			$this->approver_comments->LinkCustomAttributes = "";
			$this->approver_comments->HrefValue = "";

			// last_updated_date
			$this->last_updated_date->LinkCustomAttributes = "";
			$this->last_updated_date->HrefValue = "";
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
		if (!$this->leave_id->FldIsDetailKey && !is_null($this->leave_id->FormValue) && $this->leave_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->leave_id->FldCaption(), $this->leave_id->ReqErrMsg));
		}
		if (!$this->date_created->FldIsDetailKey && !is_null($this->date_created->FormValue) && $this->date_created->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->date_created->FldCaption(), $this->date_created->ReqErrMsg));
		}
		if (!$this->time->FldIsDetailKey && !is_null($this->time->FormValue) && $this->time->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->time->FldCaption(), $this->time->ReqErrMsg));
		}
		if (!$this->staff_id->FldIsDetailKey && !is_null($this->staff_id->FormValue) && $this->staff_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->staff_id->FldCaption(), $this->staff_id->ReqErrMsg));
		}
		if (!$this->staff_name->FldIsDetailKey && !is_null($this->staff_name->FormValue) && $this->staff_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->staff_name->FldCaption(), $this->staff_name->ReqErrMsg));
		}
		if (!$this->company->FldIsDetailKey && !is_null($this->company->FormValue) && $this->company->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->company->FldCaption(), $this->company->ReqErrMsg));
		}
		if (!$this->department->FldIsDetailKey && !is_null($this->department->FormValue) && $this->department->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->department->FldCaption(), $this->department->ReqErrMsg));
		}
		if (!$this->leave_type->FldIsDetailKey && !is_null($this->leave_type->FormValue) && $this->leave_type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->leave_type->FldCaption(), $this->leave_type->ReqErrMsg));
		}
		if (!$this->start_date->FldIsDetailKey && !is_null($this->start_date->FormValue) && $this->start_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->start_date->FldCaption(), $this->start_date->ReqErrMsg));
		}
		if (!ew_CheckShortEuroDate($this->start_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->start_date->FldErrMsg());
		}
		if (!$this->end_date->FldIsDetailKey && !is_null($this->end_date->FormValue) && $this->end_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->end_date->FldCaption(), $this->end_date->ReqErrMsg));
		}
		if (!ew_CheckShortEuroDate($this->end_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->end_date->FldErrMsg());
		}
		if (!$this->no_of_days->FldIsDetailKey && !is_null($this->no_of_days->FormValue) && $this->no_of_days->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->no_of_days->FldCaption(), $this->no_of_days->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->no_of_days->FormValue)) {
			ew_AddMessage($gsFormError, $this->no_of_days->FldErrMsg());
		}
		if (!$this->resumption_date->FldIsDetailKey && !is_null($this->resumption_date->FormValue) && $this->resumption_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->resumption_date->FldCaption(), $this->resumption_date->ReqErrMsg));
		}
		if (!ew_CheckShortEuroDate($this->resumption_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->resumption_date->FldErrMsg());
		}
		if (!$this->replacement_assign_staff->FldIsDetailKey && !is_null($this->replacement_assign_staff->FormValue) && $this->replacement_assign_staff->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->replacement_assign_staff->FldCaption(), $this->replacement_assign_staff->ReqErrMsg));
		}
		if (!$this->purpose_of_leave->FldIsDetailKey && !is_null($this->purpose_of_leave->FormValue) && $this->purpose_of_leave->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->purpose_of_leave->FldCaption(), $this->purpose_of_leave->ReqErrMsg));
		}
		if (!$this->status->FldIsDetailKey && !is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->status->FormValue)) {
			ew_AddMessage($gsFormError, $this->status->FldErrMsg());
		}
		if ($this->initiator_action->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->initiator_action->FldCaption(), $this->initiator_action->ReqErrMsg));
		}
		if (!$this->initiator_comments->FldIsDetailKey && !is_null($this->initiator_comments->FormValue) && $this->initiator_comments->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->initiator_comments->FldCaption(), $this->initiator_comments->ReqErrMsg));
		}
		if (!$this->last_updated_date->FldIsDetailKey && !is_null($this->last_updated_date->FormValue) && $this->last_updated_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->last_updated_date->FldCaption(), $this->last_updated_date->ReqErrMsg));
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
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// leave_id
		$this->leave_id->SetDbValueDef($rsnew, $this->leave_id->CurrentValue, "", FALSE);

		// date_created
		$this->date_created->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_created->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// time
		$this->time->SetDbValueDef($rsnew, $this->time->CurrentValue, ew_CurrentTime(), FALSE);

		// staff_id
		$this->staff_id->SetDbValueDef($rsnew, $this->staff_id->CurrentValue, "", FALSE);

		// staff_name
		$this->staff_name->SetDbValueDef($rsnew, $this->staff_name->CurrentValue, "", FALSE);

		// company
		$this->company->SetDbValueDef($rsnew, $this->company->CurrentValue, "", FALSE);

		// department
		$this->department->SetDbValueDef($rsnew, $this->department->CurrentValue, 0, FALSE);

		// leave_type
		$this->leave_type->SetDbValueDef($rsnew, $this->leave_type->CurrentValue, 0, FALSE);

		// start_date
		$this->start_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->start_date->CurrentValue, 14), ew_CurrentDate(), FALSE);

		// end_date
		$this->end_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->end_date->CurrentValue, 14), ew_CurrentDate(), FALSE);

		// no_of_days
		$this->no_of_days->SetDbValueDef($rsnew, $this->no_of_days->CurrentValue, 0, strval($this->no_of_days->CurrentValue) == "");

		// resumption_date
		$this->resumption_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->resumption_date->CurrentValue, 14), ew_CurrentDate(), FALSE);

		// replacement_assign_staff
		$this->replacement_assign_staff->SetDbValueDef($rsnew, $this->replacement_assign_staff->CurrentValue, "", FALSE);

		// purpose_of_leave
		$this->purpose_of_leave->SetDbValueDef($rsnew, $this->purpose_of_leave->CurrentValue, "", FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, strval($this->status->CurrentValue) == "");

		// initiator_action
		$this->initiator_action->SetDbValueDef($rsnew, $this->initiator_action->CurrentValue, 0, FALSE);

		// initiator_comments
		$this->initiator_comments->SetDbValueDef($rsnew, $this->initiator_comments->CurrentValue, "", FALSE);

		// verified_staff
		$this->verified_staff->SetDbValueDef($rsnew, $this->verified_staff->CurrentValue, NULL, FALSE);

		// verified_replacement_staff
		$this->verified_replacement_staff->SetDbValueDef($rsnew, $this->verified_replacement_staff->CurrentValue, NULL, FALSE);

		// recommender_action
		$this->recommender_action->SetDbValueDef($rsnew, $this->recommender_action->CurrentValue, NULL, FALSE);

		// recommender_comments
		$this->recommender_comments->SetDbValueDef($rsnew, $this->recommender_comments->CurrentValue, NULL, FALSE);

		// approver_action
		$this->approver_action->SetDbValueDef($rsnew, $this->approver_action->CurrentValue, NULL, FALSE);

		// approver_comments
		$this->approver_comments->SetDbValueDef($rsnew, $this->approver_comments->CurrentValue, NULL, FALSE);

		// last_updated_date
		$this->last_updated_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_updated_date->CurrentValue, 7), NULL, FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("leave_formlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`code` IN ({filter_value})', "t0" => "3", "fn0" => "", "f1" => '`company_id` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->department, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_leave_type":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `code` AS `LinkFld`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `leave_type`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`code` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->leave_type, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `description` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_replacement_assign_staff":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `first_name` AS `DispFld`, `last_name` AS `Disp2Fld`, `mobile` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `user_profile`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`first_name`', "dx2" => '`last_name`', "dx3" => '`mobile`');
			if (!$GLOBALS["leave_form"]->UserIDAllow("add")) $sWhereWrk = $GLOBALS["user_profile"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "", "f1" => '`company` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->replacement_assign_staff, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_status":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `code` AS `LinkFld`, `description` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `status`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`code` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->status, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `code` ASC";
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
		case "x_status":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `code`, `description` AS `DispFld` FROM `status`";
			$sWhereWrk = "`description` LIKE '{query_value}%'";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->status, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `code` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
		// Getting the leave duration details

		ew_SetClientVar("GetLeaveDurationDetailsSearchModel", ew_Encrypt("SELECT `description`,`leave_duration` FROM `leave_type` WHERE `code`= '{query_value}'"));
		ew_SetClientVar("GetStaffLeaveDetailsSearchModel", ew_Encrypt("SELECT `leave_type`,`no_of_days` FROM `leave_form` WHERE `leave_type`= '{query_value_1}' AND `staff_id` ='{query_value_2}' AND `status` = 5"));
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
		$this->leave_type->CustomMsg .= "<div class='small' id='lnmessage' style='padding-top:3px; color:blue;'></div>";
		$this->no_of_days->CustomMsg .= "<div class='small' id='daysmessage' style='padding-top:3px; color:blue;'></div>";
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
		   $rs = $this->GetFieldValues("FormValue"); // Get the form values as array

			// Return error message in $CustomError
			if(CurrentUserLevel() == 1 && $this->status->CurrentValue == 0 && $rs["staff_id"] == '' || $this->status->CurrentValue == 3 && $rs["staff_id"] == '' ){
				$CustomError = "Staff Name Field Can not be Empty.";
				return FALSE;
			}
			if(CurrentUserLevel() == 1 && $this->status->CurrentValue == 0 && $rs["company"] == '' || $this->status->CurrentValue == 3 && $rs["company"] == '' ){
				$CustomError = "Company Name Field Can not be Empty.";
				return FALSE;
			}
			if(CurrentUserLevel() == 1 && $this->status->CurrentValue == 0 && $rs["department"] == '' || $this->status->CurrentValue == 3 && $rs["department"] == '' ){
				$CustomError = "Department Field Can not be Empty.";
				return FALSE;
			}
			if(CurrentUserLevel() == 1 && $this->status->CurrentValue == 0 && $rs["replacement_assign_staff"] == '' || $this->status->CurrentValue == 3 && $rs["replacement_assign_staff"] == '' ){
				$CustomError = "Replacement Staff Role Field Can not be Empty.";
				return FALSE;
			}
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($leave_form_add)) $leave_form_add = new cleave_form_add();

// Page init
$leave_form_add->Page_Init();

// Page main
$leave_form_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$leave_form_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fleave_formadd = new ew_Form("fleave_formadd", "add");

// Validate form
fleave_formadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_leave_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->leave_id->FldCaption(), $leave_form->leave_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_created");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->date_created->FldCaption(), $leave_form->date_created->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_time");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->time->FldCaption(), $leave_form->time->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_staff_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->staff_id->FldCaption(), $leave_form->staff_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_staff_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->staff_name->FldCaption(), $leave_form->staff_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_company");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->company->FldCaption(), $leave_form->company->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_department");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->department->FldCaption(), $leave_form->department->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_leave_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->leave_type->FldCaption(), $leave_form->leave_type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_start_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->start_date->FldCaption(), $leave_form->start_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_start_date");
			if (elm && !ew_CheckShortEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($leave_form->start_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_end_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->end_date->FldCaption(), $leave_form->end_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_end_date");
			if (elm && !ew_CheckShortEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($leave_form->end_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_no_of_days");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->no_of_days->FldCaption(), $leave_form->no_of_days->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_of_days");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($leave_form->no_of_days->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_resumption_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->resumption_date->FldCaption(), $leave_form->resumption_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_resumption_date");
			if (elm && !ew_CheckShortEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($leave_form->resumption_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_replacement_assign_staff");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->replacement_assign_staff->FldCaption(), $leave_form->replacement_assign_staff->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_purpose_of_leave");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->purpose_of_leave->FldCaption(), $leave_form->purpose_of_leave->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->status->FldCaption(), $leave_form->status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($leave_form->status->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_initiator_action");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->initiator_action->FldCaption(), $leave_form->initiator_action->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_initiator_comments");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->initiator_comments->FldCaption(), $leave_form->initiator_comments->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_last_updated_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->last_updated_date->FldCaption(), $leave_form->last_updated_date->ReqErrMsg)) ?>");

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
fleave_formadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
  	var currlevel = "<?php echo CurrentUserLevel() ?>";	
  	var sdate = new Date("<?php echo date("Y-m-d"); ?>");
 	var $row = $(this).fields();
  	if ((currlevel == 1) && moment($row["start_date"].value(),'DD/MM/YYYY') <= moment(sdate,'DD/MM/YYYY'))
  		return this.OnError($row["start_date"], "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->start_date->FldCaption(), "Start Date cannot be earlier than today!")) ?>"); 	
  	if ((currlevel == 1) && moment($row["end_date"].value(),'DD/MM/YYYY') <= moment($row["start_date"].value(),'DD/MM/YYYY'))
  		return this.OnError($row["end_date"], "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->end_date->FldCaption(), "End Date cannot be earlier than Start Date!")) ?>"); 
  	if ((currlevel == 1) && moment($row["resumption_date"].value(),'DD/MM/YYYY') <= moment($row["end_date"].value(),'DD/MM/YYYY'))
  		return this.OnError($row["resumption_date"], "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->resumption_date->FldCaption(), "Resumption Date cannot be earlier than End Date!")) ?>"); 
 	if ((currlevel == 1) && ($row["no_of_days"].value() <= 0 || $row["no_of_days"].value() == 'NaN'))
 		return this.OnError($row["no_of_days"], "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->no_of_days->FldCaption(), "No of Days cannot be empty or zero!")) ?>");
 	if ((currlevel == 1) && ($row["leave_type"].value() <= 0 || $row["leave_type"].value() == 'NaN'))
 		return this.OnError($row["leave_type"], "<?php echo ew_JsEncode2(str_replace("%s", $leave_form->leave_type->FldCaption(), "Leave Type cannot be empty!")) ?>");
  	return true;
 }

// Use JavaScript validation or not
fleave_formadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fleave_formadd.MultiPage = new ew_MultiPage("fleave_formadd");

// Dynamic selection lists
fleave_formadd.Lists["x_company"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":["x_department","x_replacement_assign_staff"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fleave_formadd.Lists["x_company"].Data = "<?php echo $leave_form_add->company->LookupFilterQuery(FALSE, "add") ?>";
fleave_formadd.Lists["x_department"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":["x_company"],"ChildFields":[],"FilterFields":["x_company_id"],"Options":[],"Template":"","LinkTable":"department"};
fleave_formadd.Lists["x_department"].Data = "<?php echo $leave_form_add->department->LookupFilterQuery(FALSE, "add") ?>";
fleave_formadd.Lists["x_leave_type"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"leave_type"};
fleave_formadd.Lists["x_leave_type"].Data = "<?php echo $leave_form_add->leave_type->LookupFilterQuery(FALSE, "add") ?>";
fleave_formadd.Lists["x_replacement_assign_staff"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_first_name","x_last_name","x_mobile",""],"ParentFields":["x_company"],"ChildFields":[],"FilterFields":["x_company"],"Options":[],"Template":"","LinkTable":"user_profile"};
fleave_formadd.Lists["x_replacement_assign_staff"].Data = "<?php echo $leave_form_add->replacement_assign_staff->LookupFilterQuery(FALSE, "add") ?>";
fleave_formadd.Lists["x_status"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"status"};
fleave_formadd.Lists["x_status"].Data = "<?php echo $leave_form_add->status->LookupFilterQuery(FALSE, "add") ?>";
fleave_formadd.AutoSuggests["x_status"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $leave_form_add->status->LookupFilterQuery(TRUE, "add"))) ?>;
fleave_formadd.Lists["x_initiator_action"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formadd.Lists["x_initiator_action"].Options = <?php echo json_encode($leave_form_add->initiator_action->Options()) ?>;
fleave_formadd.Lists["x_verified_staff"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formadd.Lists["x_verified_staff"].Options = <?php echo json_encode($leave_form_add->verified_staff->Options()) ?>;
fleave_formadd.Lists["x_verified_replacement_staff"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formadd.Lists["x_verified_replacement_staff"].Options = <?php echo json_encode($leave_form_add->verified_replacement_staff->Options()) ?>;
fleave_formadd.Lists["x_recommender_action"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formadd.Lists["x_recommender_action"].Options = <?php echo json_encode($leave_form_add->recommender_action->Options()) ?>;
fleave_formadd.Lists["x_approver_action"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formadd.Lists["x_approver_action"].Options = <?php echo json_encode($leave_form_add->approver_action->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
var staff_ID = "<?php echo $_SESSION['Staff_ID'] ?>";
$(document).ready(function(){

	//Company selected should be read only
	//$("#x_company").attr('readonly',true);
	//$("#x_company").css('pointer-events','none');
	//Get the leave form empty details

	$("#x_leave_type").on("change", function() {
	  		$("#x_start_date").val("");
	  		$("#x_end_date").val("");
	  		$("#x_no_of_days").val("");
	  		$("#x_resumption_date").val("");
	  		$('#daysmessage').html('');
			var leaveType = this.value;

	  		//alert(leaveType);
		 	if(leaveType !=''){
		 		var resultSearchModel = ew_Ajax(ewVar.GetLeaveDurationDetailsSearchModel, leaveType);

		 		//var resultSearchModel_2 = ew_Ajax(ewVar.GetStaffLeaveDetailsSearchModel, {q1: leaveType, q2: staff_ID});
		 		//alert(resultSearchModel);

		 		if(resultSearchModel !=''){
		 			var leave_duration = parseInt(resultSearchModel[1]);
		 			getDate = new Date();
		 			getDate = (getDate.getFullYear() + '/' + (getDate.getMonth()+1) + '/' + getDate.getDate());

					//alert('Total Leave Days for the selected Leave is: ' + leave_duration + 'Days');
					$('#lnmessage').html('Total Leave Days for the selected Leave is: ' + leave_duration + ' Days');

					//exit;
		 		}

		 		//Getting numbers of Day
		 	};

		//$('#lnmessage').html('Available Leave Days:' );
		//alertify.alert('The Selected Leave has been Exhusted for Year 2023.').set('title', 'Not permitted - Leave Type has Expired!');

	});
	$('#x_start_date').blur(function() {
		$("#x_end_date").val('');
		$("#x_no_of_days").val('');
		$("#x_resumption_date").val("");
		$('#daysmessage').html('');
	});
	$('#x_end_date').blur(function() {
		var from1 = $('#x_start_date').val().split("/");
		var started = new Date(from1[2], from1[1] - 1, from1[0]);

		//
		var end1 = $('#x_end_date').val().split("/");
		var ended = new Date(end1[2], end1[1] - 1, end1[0]);
		var days1 = ((ended - started) / (1000 * 60 * 60 * 24)) + 1;
		var leaveType = $("#x_leave_type").val();
		$("#x_no_of_days").val(days1.toFixed());
		var resultSearchModel_2 = ew_Ajax(ewVar.GetStaffLeaveDetailsSearchModel, {q1: leaveType, q2: staff_ID});
		var resultSearchModel = ew_Ajax(ewVar.GetLeaveDurationDetailsSearchModel, leaveType);
		var leave_duration = parseInt(resultSearchModel[1]);
		var total_number_of_leave_collected = parseInt(resultSearchModel_2[1]);

		//var testing = (total_number_of_leave_collected == leave_duration ) alert('Exhausted Already') : 
		// alert(total_number_of_leave_collected);
		// exit;
		// ==========My Codes=============

		var No_of_days = $("#x_no_of_days").val();
		var sum_previous_current_duration = parseInt(No_of_days) + total_number_of_leave_collected;

		// alert(sum_previous_current_duration);
		// exit;

		if(resultSearchModel_2 =='' && (No_of_days > leave_duration)){

			// if(No_of_days > leave_duration){
			//alertify.alert('The Selected Number of Day for this Leave Type Cant Excceded:.' + ' ' + leave_duration + 'Days').set('title', 'Not permitted - Leave Type has Expired!');
			//alert('The Selected Number of Day for this Leave Type Cant Excceded:.' + ' ' + leave_duration + 'Days');

				$('#daysmessage').html('The Number of Days for this Leave Type Can not Exceed:.'  + leave_duration + ' Days');

				//alertify.alert('The Selected Number of Day for this Leave Type Cant Excceded:.' + ' ' + leave_duration + 'Days').set('title', 'Not permitted - Leave Type has Expired!');
				$("#x_start_date").val("");
				$("#x_end_date").val("");
				$("#x_no_of_days").val("");
				$("#x_resumption_date").val("");

			// }
		}else if(resultSearchModel_2 =='' && (No_of_days < leave_duration)){

			//alert('It got here');
			var RemainDays = leave_duration -  parseInt(No_of_days);
			$('#daysmessage').html('Your Available Leave Days for the Selected Leave is: ' + RemainDays + ' Day');

			//$('#daysmessage').html(No_of_days);
		}
		else {
			if(resultSearchModel_2 !='' && (total_number_of_leave_collected == leave_duration)){
			   alertify.alert('You have Already Exhuasted your Leave for the Selected Leave Application,kindly apply for other Leave at your Disposal').set('title', 'Not permitted - Leave Type Exhausted!');

				//alert('Not Permitted');
				$("#x_leave_type").val("");	
				$("#x_start_date").val("");
				$("#x_end_date").val("");
				$("#x_no_of_days").val("");
				$("#x_resumption_date").val("");
				$('#lnmessage').html('');
			}else if(resultSearchModel_2 !='' && (sum_previous_current_duration > leave_duration)){
				alertify.alert('The Selected Number of Days Already Exceeds the allowable days for the Seleceted Leave, You have the Option to select between 1 to ' + (leave_duration - total_number_of_leave_collected) + ' Days').set('title', 'Not permitted - Leave Type Exhausted!');

				//alert('Not Permitted');
				//$("#x_leave_type").val("");

				$("#x_start_date").val("");
				$("#x_end_date").val("");
				$("#x_no_of_days").val("");
				$("#x_resumption_date").val("");

				//$('#lnmessage').html('');
			}else{
				var RemainDays = leave_duration -  sum_previous_current_duration;
				$('#daysmessage').html('Your Available Leave Days for the Selected Leave is: ' + RemainDays + ' Day');
			}

			// alertify.alert('The Selected Leave Type have been Exhousted').set('title', 'Not permitted - Leave Type has Expired!');
			// alert('The Selected Leave Type have been Exhausted');

		}

		//alert(days1.toFixed());
	});
})
</script>
<?php $leave_form_add->ShowPageHeader(); ?>
<?php
$leave_form_add->ShowMessage();
?>
<form name="fleave_formadd" id="fleave_formadd" class="<?php echo $leave_form_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($leave_form_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $leave_form_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="leave_form">
<?php if ($leave_form->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } else { ?>
<input type="hidden" name="a_add" id="a_add" value="F">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo intval($leave_form_add->IsModal) ?>">
<div class="ewMultiPage"><!-- multi-page -->
<div class="nav-tabs-custom" id="leave_form_add"><!-- multi-page .nav-tabs-custom -->
	<ul class="nav<?php echo $leave_form_add->MultiPages->NavStyle() ?>">
		<li<?php echo $leave_form_add->MultiPages->TabStyle("1") ?>><a href="#tab_leave_form1" data-toggle="tab"><?php echo $leave_form->PageCaption(1) ?></a></li>
		<li<?php echo $leave_form_add->MultiPages->TabStyle("2") ?>><a href="#tab_leave_form2" data-toggle="tab"><?php echo $leave_form->PageCaption(2) ?></a></li>
	</ul>
	<div class="tab-content"><!-- multi-page .nav-tabs-custom .tab-content -->
		<div class="tab-pane<?php echo $leave_form_add->MultiPages->PageStyle("1") ?>" id="tab_leave_form1"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($leave_form->leave_id->Visible) { // leave_id ?>
	<div id="r_leave_id" class="form-group">
		<label id="elh_leave_form_leave_id" for="x_leave_id" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->leave_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->leave_id->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_leave_id">
<input type="text" data-table="leave_form" data-field="x_leave_id" data-page="1" name="x_leave_id" id="x_leave_id" size="15" placeholder="<?php echo ew_HtmlEncode($leave_form->leave_id->getPlaceHolder()) ?>" value="<?php echo $leave_form->leave_id->EditValue ?>"<?php echo $leave_form->leave_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_leave_form_leave_id">
<span<?php echo $leave_form->leave_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->leave_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_leave_id" data-page="1" name="x_leave_id" id="x_leave_id" value="<?php echo ew_HtmlEncode($leave_form->leave_id->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->leave_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->date_created->Visible) { // date_created ?>
	<div id="r_date_created" class="form-group">
		<label id="elh_leave_form_date_created" for="x_date_created" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->date_created->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->date_created->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_date_created">
<input type="text" data-table="leave_form" data-field="x_date_created" data-page="1" data-format="7" name="x_date_created" id="x_date_created" size="10" placeholder="<?php echo ew_HtmlEncode($leave_form->date_created->getPlaceHolder()) ?>" value="<?php echo $leave_form->date_created->EditValue ?>"<?php echo $leave_form->date_created->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_leave_form_date_created">
<span<?php echo $leave_form->date_created->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->date_created->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_date_created" data-page="1" name="x_date_created" id="x_date_created" value="<?php echo ew_HtmlEncode($leave_form->date_created->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->date_created->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->time->Visible) { // time ?>
	<div id="r_time" class="form-group">
		<label id="elh_leave_form_time" for="x_time" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->time->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->time->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_time">
<input type="text" data-table="leave_form" data-field="x_time" data-page="1" name="x_time" id="x_time" size="10" placeholder="<?php echo ew_HtmlEncode($leave_form->time->getPlaceHolder()) ?>" value="<?php echo $leave_form->time->EditValue ?>"<?php echo $leave_form->time->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_leave_form_time">
<span<?php echo $leave_form->time->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->time->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_time" data-page="1" name="x_time" id="x_time" value="<?php echo ew_HtmlEncode($leave_form->time->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->time->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->staff_id->Visible) { // staff_id ?>
	<div id="r_staff_id" class="form-group">
		<label id="elh_leave_form_staff_id" for="x_staff_id" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->staff_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->staff_id->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_staff_id">
<input type="text" data-table="leave_form" data-field="x_staff_id" data-page="1" name="x_staff_id" id="x_staff_id" size="10" placeholder="<?php echo ew_HtmlEncode($leave_form->staff_id->getPlaceHolder()) ?>" value="<?php echo $leave_form->staff_id->EditValue ?>"<?php echo $leave_form->staff_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_leave_form_staff_id">
<span<?php echo $leave_form->staff_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->staff_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_staff_id" data-page="1" name="x_staff_id" id="x_staff_id" value="<?php echo ew_HtmlEncode($leave_form->staff_id->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->staff_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->staff_name->Visible) { // staff_name ?>
	<div id="r_staff_name" class="form-group">
		<label id="elh_leave_form_staff_name" for="x_staff_name" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->staff_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->staff_name->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_staff_name">
<input type="text" data-table="leave_form" data-field="x_staff_name" data-page="1" name="x_staff_name" id="x_staff_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($leave_form->staff_name->getPlaceHolder()) ?>" value="<?php echo $leave_form->staff_name->EditValue ?>"<?php echo $leave_form->staff_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_leave_form_staff_name">
<span<?php echo $leave_form->staff_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->staff_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_staff_name" data-page="1" name="x_staff_name" id="x_staff_name" value="<?php echo ew_HtmlEncode($leave_form->staff_name->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->staff_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->company->Visible) { // company ?>
	<div id="r_company" class="form-group">
		<label id="elh_leave_form_company" for="x_company" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->company->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->company->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_company">
<?php $leave_form->company->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$leave_form->company->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_company"><?php echo (strval($leave_form->company->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $leave_form->company->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($leave_form->company->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_company',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($leave_form->company->ReadOnly || $leave_form->company->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="leave_form" data-field="x_company" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $leave_form->company->DisplayValueSeparatorAttribute() ?>" name="x_company" id="x_company" value="<?php echo $leave_form->company->CurrentValue ?>"<?php echo $leave_form->company->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_leave_form_company">
<span<?php echo $leave_form->company->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->company->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_company" data-page="1" name="x_company" id="x_company" value="<?php echo ew_HtmlEncode($leave_form->company->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->company->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->department->Visible) { // department ?>
	<div id="r_department" class="form-group">
		<label id="elh_leave_form_department" for="x_department" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->department->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->department->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_department">
<select data-table="leave_form" data-field="x_department" data-page="1" data-value-separator="<?php echo $leave_form->department->DisplayValueSeparatorAttribute() ?>" id="x_department" name="x_department"<?php echo $leave_form->department->EditAttributes() ?>>
<?php echo $leave_form->department->SelectOptionListHtml("x_department") ?>
</select>
</span>
<?php } else { ?>
<span id="el_leave_form_department">
<span<?php echo $leave_form->department->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->department->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_department" data-page="1" name="x_department" id="x_department" value="<?php echo ew_HtmlEncode($leave_form->department->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->department->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->leave_type->Visible) { // leave_type ?>
	<div id="r_leave_type" class="form-group">
		<label id="elh_leave_form_leave_type" for="x_leave_type" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->leave_type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->leave_type->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_leave_type">
<select data-table="leave_form" data-field="x_leave_type" data-page="1" data-value-separator="<?php echo $leave_form->leave_type->DisplayValueSeparatorAttribute() ?>" id="x_leave_type" name="x_leave_type"<?php echo $leave_form->leave_type->EditAttributes() ?>>
<?php echo $leave_form->leave_type->SelectOptionListHtml("x_leave_type") ?>
</select>
</span>
<?php } else { ?>
<span id="el_leave_form_leave_type">
<span<?php echo $leave_form->leave_type->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->leave_type->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_leave_type" data-page="1" name="x_leave_type" id="x_leave_type" value="<?php echo ew_HtmlEncode($leave_form->leave_type->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->leave_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->start_date->Visible) { // start_date ?>
	<div id="r_start_date" class="form-group">
		<label id="elh_leave_form_start_date" for="x_start_date" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->start_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->start_date->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_start_date">
<input type="text" data-table="leave_form" data-field="x_start_date" data-page="1" data-format="14" name="x_start_date" id="x_start_date" size="10" placeholder="<?php echo ew_HtmlEncode($leave_form->start_date->getPlaceHolder()) ?>" value="<?php echo $leave_form->start_date->EditValue ?>"<?php echo $leave_form->start_date->EditAttributes() ?>>
<?php if (!$leave_form->start_date->ReadOnly && !$leave_form->start_date->Disabled && !isset($leave_form->start_date->EditAttrs["readonly"]) && !isset($leave_form->start_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fleave_formadd", "x_start_date", {"ignoreReadonly":true,"useCurrent":false,"format":14});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_leave_form_start_date">
<span<?php echo $leave_form->start_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->start_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_start_date" data-page="1" name="x_start_date" id="x_start_date" value="<?php echo ew_HtmlEncode($leave_form->start_date->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->start_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->end_date->Visible) { // end_date ?>
	<div id="r_end_date" class="form-group">
		<label id="elh_leave_form_end_date" for="x_end_date" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->end_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->end_date->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_end_date">
<input type="text" data-table="leave_form" data-field="x_end_date" data-page="1" data-format="14" name="x_end_date" id="x_end_date" size="10" placeholder="<?php echo ew_HtmlEncode($leave_form->end_date->getPlaceHolder()) ?>" value="<?php echo $leave_form->end_date->EditValue ?>"<?php echo $leave_form->end_date->EditAttributes() ?>>
<?php if (!$leave_form->end_date->ReadOnly && !$leave_form->end_date->Disabled && !isset($leave_form->end_date->EditAttrs["readonly"]) && !isset($leave_form->end_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fleave_formadd", "x_end_date", {"ignoreReadonly":true,"useCurrent":false,"format":14});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_leave_form_end_date">
<span<?php echo $leave_form->end_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->end_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_end_date" data-page="1" name="x_end_date" id="x_end_date" value="<?php echo ew_HtmlEncode($leave_form->end_date->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->end_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->no_of_days->Visible) { // no_of_days ?>
	<div id="r_no_of_days" class="form-group">
		<label id="elh_leave_form_no_of_days" for="x_no_of_days" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->no_of_days->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->no_of_days->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_no_of_days">
<input type="text" data-table="leave_form" data-field="x_no_of_days" data-page="1" name="x_no_of_days" id="x_no_of_days" size="5" placeholder="<?php echo ew_HtmlEncode($leave_form->no_of_days->getPlaceHolder()) ?>" value="<?php echo $leave_form->no_of_days->EditValue ?>"<?php echo $leave_form->no_of_days->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_leave_form_no_of_days">
<span<?php echo $leave_form->no_of_days->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->no_of_days->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_no_of_days" data-page="1" name="x_no_of_days" id="x_no_of_days" value="<?php echo ew_HtmlEncode($leave_form->no_of_days->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->no_of_days->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->resumption_date->Visible) { // resumption_date ?>
	<div id="r_resumption_date" class="form-group">
		<label id="elh_leave_form_resumption_date" for="x_resumption_date" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->resumption_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->resumption_date->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_resumption_date">
<input type="text" data-table="leave_form" data-field="x_resumption_date" data-page="1" data-format="14" name="x_resumption_date" id="x_resumption_date" size="10" placeholder="<?php echo ew_HtmlEncode($leave_form->resumption_date->getPlaceHolder()) ?>" value="<?php echo $leave_form->resumption_date->EditValue ?>"<?php echo $leave_form->resumption_date->EditAttributes() ?>>
<?php if (!$leave_form->resumption_date->ReadOnly && !$leave_form->resumption_date->Disabled && !isset($leave_form->resumption_date->EditAttrs["readonly"]) && !isset($leave_form->resumption_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fleave_formadd", "x_resumption_date", {"ignoreReadonly":true,"useCurrent":false,"format":14});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_leave_form_resumption_date">
<span<?php echo $leave_form->resumption_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->resumption_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_resumption_date" data-page="1" name="x_resumption_date" id="x_resumption_date" value="<?php echo ew_HtmlEncode($leave_form->resumption_date->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->resumption_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->replacement_assign_staff->Visible) { // replacement_assign_staff ?>
	<div id="r_replacement_assign_staff" class="form-group">
		<label id="elh_leave_form_replacement_assign_staff" for="x_replacement_assign_staff" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->replacement_assign_staff->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->replacement_assign_staff->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_replacement_assign_staff">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_replacement_assign_staff"><?php echo (strval($leave_form->replacement_assign_staff->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $leave_form->replacement_assign_staff->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($leave_form->replacement_assign_staff->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_replacement_assign_staff',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($leave_form->replacement_assign_staff->ReadOnly || $leave_form->replacement_assign_staff->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="leave_form" data-field="x_replacement_assign_staff" data-page="1" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $leave_form->replacement_assign_staff->DisplayValueSeparatorAttribute() ?>" name="x_replacement_assign_staff" id="x_replacement_assign_staff" value="<?php echo $leave_form->replacement_assign_staff->CurrentValue ?>"<?php echo $leave_form->replacement_assign_staff->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_leave_form_replacement_assign_staff">
<span<?php echo $leave_form->replacement_assign_staff->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->replacement_assign_staff->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_replacement_assign_staff" data-page="1" name="x_replacement_assign_staff" id="x_replacement_assign_staff" value="<?php echo ew_HtmlEncode($leave_form->replacement_assign_staff->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->replacement_assign_staff->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->purpose_of_leave->Visible) { // purpose_of_leave ?>
	<div id="r_purpose_of_leave" class="form-group">
		<label id="elh_leave_form_purpose_of_leave" for="x_purpose_of_leave" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->purpose_of_leave->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->purpose_of_leave->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_purpose_of_leave">
<textarea data-table="leave_form" data-field="x_purpose_of_leave" data-page="1" name="x_purpose_of_leave" id="x_purpose_of_leave" cols="34" rows="5" placeholder="<?php echo ew_HtmlEncode($leave_form->purpose_of_leave->getPlaceHolder()) ?>"<?php echo $leave_form->purpose_of_leave->EditAttributes() ?>><?php echo $leave_form->purpose_of_leave->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_leave_form_purpose_of_leave">
<span<?php echo $leave_form->purpose_of_leave->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->purpose_of_leave->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_purpose_of_leave" data-page="1" name="x_purpose_of_leave" id="x_purpose_of_leave" value="<?php echo ew_HtmlEncode($leave_form->purpose_of_leave->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->purpose_of_leave->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $leave_form_add->MultiPages->PageStyle("2") ?>" id="tab_leave_form2"><!-- multi-page .tab-pane -->
<div class="ewAddDiv"><!-- page* -->
<?php if ($leave_form->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_leave_form_status" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->status->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_status">
<?php
$wrkonchange = trim(" " . @$leave_form->status->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$leave_form->status->EditAttrs["onchange"] = "";
?>
<span id="as_x_status" style="white-space: nowrap; z-index: 8840">
	<input type="text" name="sv_x_status" id="sv_x_status" value="<?php echo $leave_form->status->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($leave_form->status->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($leave_form->status->getPlaceHolder()) ?>"<?php echo $leave_form->status->EditAttributes() ?>>
</span>
<input type="hidden" data-table="leave_form" data-field="x_status" data-page="2" data-value-separator="<?php echo $leave_form->status->DisplayValueSeparatorAttribute() ?>" name="x_status" id="x_status" value="<?php echo ew_HtmlEncode($leave_form->status->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script type="text/javascript">
fleave_formadd.CreateAutoSuggest({"id":"x_status","forceSelect":false});
</script>
</span>
<?php } else { ?>
<span id="el_leave_form_status">
<span<?php echo $leave_form->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_status" data-page="2" name="x_status" id="x_status" value="<?php echo ew_HtmlEncode($leave_form->status->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->initiator_action->Visible) { // initiator_action ?>
	<div id="r_initiator_action" class="form-group">
		<label id="elh_leave_form_initiator_action" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->initiator_action->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->initiator_action->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_initiator_action">
<div id="tp_x_initiator_action" class="ewTemplate"><input type="radio" data-table="leave_form" data-field="x_initiator_action" data-page="2" data-value-separator="<?php echo $leave_form->initiator_action->DisplayValueSeparatorAttribute() ?>" name="x_initiator_action" id="x_initiator_action" value="{value}"<?php echo $leave_form->initiator_action->EditAttributes() ?>></div>
<div id="dsl_x_initiator_action" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $leave_form->initiator_action->RadioButtonListHtml(FALSE, "x_initiator_action", 2) ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_leave_form_initiator_action">
<span<?php echo $leave_form->initiator_action->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->initiator_action->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_initiator_action" data-page="2" name="x_initiator_action" id="x_initiator_action" value="<?php echo ew_HtmlEncode($leave_form->initiator_action->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->initiator_action->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->initiator_comments->Visible) { // initiator_comments ?>
	<div id="r_initiator_comments" class="form-group">
		<label id="elh_leave_form_initiator_comments" for="x_initiator_comments" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->initiator_comments->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->initiator_comments->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_initiator_comments">
<textarea data-table="leave_form" data-field="x_initiator_comments" data-page="2" name="x_initiator_comments" id="x_initiator_comments" cols="34" rows="5" placeholder="<?php echo ew_HtmlEncode($leave_form->initiator_comments->getPlaceHolder()) ?>"<?php echo $leave_form->initiator_comments->EditAttributes() ?>><?php echo $leave_form->initiator_comments->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_leave_form_initiator_comments">
<span<?php echo $leave_form->initiator_comments->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->initiator_comments->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_initiator_comments" data-page="2" name="x_initiator_comments" id="x_initiator_comments" value="<?php echo ew_HtmlEncode($leave_form->initiator_comments->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->initiator_comments->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->verified_staff->Visible) { // verified_staff ?>
	<div id="r_verified_staff" class="form-group">
		<label id="elh_leave_form_verified_staff" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->verified_staff->FldCaption() ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->verified_staff->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_verified_staff">
<div id="tp_x_verified_staff" class="ewTemplate"><input type="radio" data-table="leave_form" data-field="x_verified_staff" data-page="2" data-value-separator="<?php echo $leave_form->verified_staff->DisplayValueSeparatorAttribute() ?>" name="x_verified_staff" id="x_verified_staff" value="{value}"<?php echo $leave_form->verified_staff->EditAttributes() ?>></div>
<div id="dsl_x_verified_staff" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $leave_form->verified_staff->RadioButtonListHtml(FALSE, "x_verified_staff", 2) ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_leave_form_verified_staff">
<span<?php echo $leave_form->verified_staff->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->verified_staff->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_verified_staff" data-page="2" name="x_verified_staff" id="x_verified_staff" value="<?php echo ew_HtmlEncode($leave_form->verified_staff->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->verified_staff->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->verified_replacement_staff->Visible) { // verified_replacement_staff ?>
	<div id="r_verified_replacement_staff" class="form-group">
		<label id="elh_leave_form_verified_replacement_staff" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->verified_replacement_staff->FldCaption() ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->verified_replacement_staff->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_verified_replacement_staff">
<div id="tp_x_verified_replacement_staff" class="ewTemplate"><input type="radio" data-table="leave_form" data-field="x_verified_replacement_staff" data-page="2" data-value-separator="<?php echo $leave_form->verified_replacement_staff->DisplayValueSeparatorAttribute() ?>" name="x_verified_replacement_staff" id="x_verified_replacement_staff" value="{value}"<?php echo $leave_form->verified_replacement_staff->EditAttributes() ?>></div>
<div id="dsl_x_verified_replacement_staff" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $leave_form->verified_replacement_staff->RadioButtonListHtml(FALSE, "x_verified_replacement_staff", 2) ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_leave_form_verified_replacement_staff">
<span<?php echo $leave_form->verified_replacement_staff->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->verified_replacement_staff->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_verified_replacement_staff" data-page="2" name="x_verified_replacement_staff" id="x_verified_replacement_staff" value="<?php echo ew_HtmlEncode($leave_form->verified_replacement_staff->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->verified_replacement_staff->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->recommender_action->Visible) { // recommender_action ?>
	<div id="r_recommender_action" class="form-group">
		<label id="elh_leave_form_recommender_action" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->recommender_action->FldCaption() ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->recommender_action->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_recommender_action">
<div id="tp_x_recommender_action" class="ewTemplate"><input type="radio" data-table="leave_form" data-field="x_recommender_action" data-page="2" data-value-separator="<?php echo $leave_form->recommender_action->DisplayValueSeparatorAttribute() ?>" name="x_recommender_action" id="x_recommender_action" value="{value}"<?php echo $leave_form->recommender_action->EditAttributes() ?>></div>
<div id="dsl_x_recommender_action" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $leave_form->recommender_action->RadioButtonListHtml(FALSE, "x_recommender_action", 2) ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_leave_form_recommender_action">
<span<?php echo $leave_form->recommender_action->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->recommender_action->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_recommender_action" data-page="2" name="x_recommender_action" id="x_recommender_action" value="<?php echo ew_HtmlEncode($leave_form->recommender_action->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->recommender_action->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->recommender_comments->Visible) { // recommender_comments ?>
	<div id="r_recommender_comments" class="form-group">
		<label id="elh_leave_form_recommender_comments" for="x_recommender_comments" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->recommender_comments->FldCaption() ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->recommender_comments->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_recommender_comments">
<textarea data-table="leave_form" data-field="x_recommender_comments" data-page="2" name="x_recommender_comments" id="x_recommender_comments" cols="34" rows="5" placeholder="<?php echo ew_HtmlEncode($leave_form->recommender_comments->getPlaceHolder()) ?>"<?php echo $leave_form->recommender_comments->EditAttributes() ?>><?php echo $leave_form->recommender_comments->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_leave_form_recommender_comments">
<span<?php echo $leave_form->recommender_comments->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->recommender_comments->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_recommender_comments" data-page="2" name="x_recommender_comments" id="x_recommender_comments" value="<?php echo ew_HtmlEncode($leave_form->recommender_comments->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->recommender_comments->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->approver_action->Visible) { // approver_action ?>
	<div id="r_approver_action" class="form-group">
		<label id="elh_leave_form_approver_action" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->approver_action->FldCaption() ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->approver_action->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_approver_action">
<div id="tp_x_approver_action" class="ewTemplate"><input type="radio" data-table="leave_form" data-field="x_approver_action" data-page="2" data-value-separator="<?php echo $leave_form->approver_action->DisplayValueSeparatorAttribute() ?>" name="x_approver_action" id="x_approver_action" value="{value}"<?php echo $leave_form->approver_action->EditAttributes() ?>></div>
<div id="dsl_x_approver_action" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $leave_form->approver_action->RadioButtonListHtml(FALSE, "x_approver_action", 2) ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_leave_form_approver_action">
<span<?php echo $leave_form->approver_action->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->approver_action->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_approver_action" data-page="2" name="x_approver_action" id="x_approver_action" value="<?php echo ew_HtmlEncode($leave_form->approver_action->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->approver_action->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->approver_comments->Visible) { // approver_comments ?>
	<div id="r_approver_comments" class="form-group">
		<label id="elh_leave_form_approver_comments" for="x_approver_comments" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->approver_comments->FldCaption() ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->approver_comments->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_approver_comments">
<textarea data-table="leave_form" data-field="x_approver_comments" data-page="2" name="x_approver_comments" id="x_approver_comments" cols="34" rows="5" placeholder="<?php echo ew_HtmlEncode($leave_form->approver_comments->getPlaceHolder()) ?>"<?php echo $leave_form->approver_comments->EditAttributes() ?>><?php echo $leave_form->approver_comments->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_leave_form_approver_comments">
<span<?php echo $leave_form->approver_comments->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->approver_comments->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_approver_comments" data-page="2" name="x_approver_comments" id="x_approver_comments" value="<?php echo ew_HtmlEncode($leave_form->approver_comments->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->approver_comments->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($leave_form->last_updated_date->Visible) { // last_updated_date ?>
	<div id="r_last_updated_date" class="form-group">
		<label id="elh_leave_form_last_updated_date" for="x_last_updated_date" class="<?php echo $leave_form_add->LeftColumnClass ?>"><?php echo $leave_form->last_updated_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $leave_form_add->RightColumnClass ?>"><div<?php echo $leave_form->last_updated_date->CellAttributes() ?>>
<?php if ($leave_form->CurrentAction <> "F") { ?>
<span id="el_leave_form_last_updated_date">
<input type="text" data-table="leave_form" data-field="x_last_updated_date" data-page="2" data-format="7" name="x_last_updated_date" id="x_last_updated_date" size="30" placeholder="<?php echo ew_HtmlEncode($leave_form->last_updated_date->getPlaceHolder()) ?>" value="<?php echo $leave_form->last_updated_date->EditValue ?>"<?php echo $leave_form->last_updated_date->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el_leave_form_last_updated_date">
<span<?php echo $leave_form->last_updated_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $leave_form->last_updated_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="leave_form" data-field="x_last_updated_date" data-page="2" name="x_last_updated_date" id="x_last_updated_date" value="<?php echo ew_HtmlEncode($leave_form->last_updated_date->FormValue) ?>">
<?php } ?>
<?php echo $leave_form->last_updated_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
	</div><!-- /multi-page .nav-tabs-custom .tab-content -->
</div><!-- /multi-page .nav-tabs-custom -->
</div><!-- /multi-page -->
<?php if (!$leave_form_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $leave_form_add->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($leave_form->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_add.value='F';"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $leave_form_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_add.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fleave_formadd.Init();
</script>
<?php
$leave_form_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$leave_form_add->Page_Terminate();
?>
