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

$user_profile_edit = NULL; // Initialize page object first

class cuser_profile_edit extends cuser_profile {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'user_profile';

	// Page object name
	var $PageObjName = 'user_profile_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->profile->SetVisibility();

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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $MultiPages; // Multi pages object

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_id")) {
				$this->id->setFormValue($objForm->GetValue("x_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id"])) {
				$this->id->setQueryStringValue($_GET["id"]);
				$loadByQuery = TRUE;
			} else {
				$this->id->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("user_profilelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "user_profilelist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		if ($this->CurrentAction == "F") { // Confirm page
			$this->RowType = EW_ROWTYPE_VIEW; // Render as View
		} else {
			$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		}
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->upload_of_credentcial->Upload->Index = $objForm->Index;
		$this->upload_of_credentcial->Upload->UploadFile();
		$this->upload_of_credentcial->CurrentValue = $this->upload_of_credentcial->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
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
		$this->id->CurrentValue = $this->id->FormValue;
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
			$res = $this->ShowOptionLink('edit');
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

		// profile
		$this->profile->ViewValue = $this->profile->CurrentValue;
		$this->profile->ViewCustomAttributes = "";

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

			// profile
			$this->profile->LinkCustomAttributes = "";
			$this->profile->HrefValue = "";
			$this->profile->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// staff_id
			$this->staff_id->EditAttrs["class"] = "form-control";
			$this->staff_id->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow("edit")) { // Non system admin
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

			// upload_of_credentcial
			$this->upload_of_credentcial->EditAttrs["class"] = "form-control";
			$this->upload_of_credentcial->EditCustomAttributes = "";
			$this->upload_of_credentcial->UploadPath = "uploads/";
			if (!ew_Empty($this->upload_of_credentcial->Upload->DbValue)) {
				$this->upload_of_credentcial->EditValue = $this->upload_of_credentcial->Upload->DbValue;
			} else {
				$this->upload_of_credentcial->EditValue = "";
			}
			if (!ew_Empty($this->upload_of_credentcial->CurrentValue))
					$this->upload_of_credentcial->Upload->FileName = $this->upload_of_credentcial->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->upload_of_credentcial);

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

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

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

			// upload_of_credentcial
			$this->upload_of_credentcial->LinkCustomAttributes = "";
			$this->upload_of_credentcial->HrefValue = "";
			$this->upload_of_credentcial->HrefValue2 = $this->upload_of_credentcial->UploadPath . $this->upload_of_credentcial->Upload->DbValue;

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
			ew_AddMessage($gsFormError, str_replace("%s", $this->username->FldCaption(), $this->username->ReqErrMsg));
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$this->upload_of_credentcial->OldUploadPath = "uploads/";
			$this->upload_of_credentcial->UploadPath = $this->upload_of_credentcial->OldUploadPath;
			$rsnew = array();

			// staff_id
			$this->staff_id->SetDbValueDef($rsnew, $this->staff_id->CurrentValue, 0, $this->staff_id->ReadOnly);

			// last_name
			$this->last_name->SetDbValueDef($rsnew, $this->last_name->CurrentValue, NULL, $this->last_name->ReadOnly);

			// first_name
			$this->first_name->SetDbValueDef($rsnew, $this->first_name->CurrentValue, NULL, $this->first_name->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", $this->_email->ReadOnly);

			// gender
			$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, NULL, $this->gender->ReadOnly);

			// marital_status
			$this->marital_status->SetDbValueDef($rsnew, $this->marital_status->CurrentValue, NULL, $this->marital_status->ReadOnly);

			// date_of_birth
			$this->date_of_birth->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_of_birth->CurrentValue, 7), ew_CurrentDate(), $this->date_of_birth->ReadOnly);

			// username
			$this->username->SetDbValueDef($rsnew, $this->username->CurrentValue, NULL, $this->username->ReadOnly);

			// mobile
			$this->mobile->SetDbValueDef($rsnew, $this->mobile->CurrentValue, "", $this->mobile->ReadOnly);

			// company
			$this->company->SetDbValueDef($rsnew, $this->company->CurrentValue, NULL, $this->company->ReadOnly);

			// department
			$this->department->SetDbValueDef($rsnew, $this->department->CurrentValue, NULL, $this->department->ReadOnly);

			// home_address
			$this->home_address->SetDbValueDef($rsnew, $this->home_address->CurrentValue, NULL, $this->home_address->ReadOnly);

			// town_city
			$this->town_city->SetDbValueDef($rsnew, $this->town_city->CurrentValue, NULL, $this->town_city->ReadOnly);

			// state_origin
			$this->state_origin->SetDbValueDef($rsnew, $this->state_origin->CurrentValue, NULL, $this->state_origin->ReadOnly);

			// local_gra
			$this->local_gra->SetDbValueDef($rsnew, $this->local_gra->CurrentValue, NULL, $this->local_gra->ReadOnly);

			// next_kin
			$this->next_kin->SetDbValueDef($rsnew, $this->next_kin->CurrentValue, NULL, $this->next_kin->ReadOnly);

			// resident_nxt_kin
			$this->resident_nxt_kin->SetDbValueDef($rsnew, $this->resident_nxt_kin->CurrentValue, NULL, $this->resident_nxt_kin->ReadOnly);

			// nearest_bus_stop
			$this->nearest_bus_stop->SetDbValueDef($rsnew, $this->nearest_bus_stop->CurrentValue, NULL, $this->nearest_bus_stop->ReadOnly);

			// town_city_nxt_kin
			$this->town_city_nxt_kin->SetDbValueDef($rsnew, $this->town_city_nxt_kin->CurrentValue, NULL, $this->town_city_nxt_kin->ReadOnly);

			// email_nxt_kin
			$this->email_nxt_kin->SetDbValueDef($rsnew, $this->email_nxt_kin->CurrentValue, NULL, $this->email_nxt_kin->ReadOnly);

			// phone_nxt_kin
			$this->phone_nxt_kin->SetDbValueDef($rsnew, $this->phone_nxt_kin->CurrentValue, NULL, $this->phone_nxt_kin->ReadOnly);

			// qualification_level
			$this->qualification_level->SetDbValueDef($rsnew, $this->qualification_level->CurrentValue, NULL, $this->qualification_level->ReadOnly);

			// qualification_grade
			$this->qualification_grade->SetDbValueDef($rsnew, $this->qualification_grade->CurrentValue, NULL, $this->qualification_grade->ReadOnly);

			// upload_of_credentcial
			if ($this->upload_of_credentcial->Visible && !$this->upload_of_credentcial->ReadOnly && !$this->upload_of_credentcial->Upload->KeepFile) {
				$this->upload_of_credentcial->Upload->DbValue = $rsold['upload_of_credentcial']; // Get original value
				if ($this->upload_of_credentcial->Upload->FileName == "") {
					$rsnew['upload_of_credentcial'] = NULL;
				} else {
					$rsnew['upload_of_credentcial'] = $this->upload_of_credentcial->Upload->FileName;
				}
				$this->upload_of_credentcial->ImageWidth = 1000; // Resize width
				$this->upload_of_credentcial->ImageHeight = 0; // Resize height
			}

			// password
			$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", $this->password->ReadOnly || (EW_ENCRYPTED_PASSWORD && $rs->fields('password') == $this->password->CurrentValue));

			// accesslevel
			if ($Security->CanAdmin()) { // System admin
			$this->accesslevel->SetDbValueDef($rsnew, $this->accesslevel->CurrentValue, 0, $this->accesslevel->ReadOnly);
			}

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, $this->status->ReadOnly);

			// profile
			$this->profile->SetDbValueDef($rsnew, $this->profile->CurrentValue, NULL, $this->profile->ReadOnly);
			if ($this->upload_of_credentcial->Visible && !$this->upload_of_credentcial->Upload->KeepFile) {
				$this->upload_of_credentcial->UploadPath = "uploads/";
				$OldFiles = ew_Empty($this->upload_of_credentcial->Upload->DbValue) ? array() : array($this->upload_of_credentcial->Upload->DbValue);
				if (!ew_Empty($this->upload_of_credentcial->Upload->FileName)) {
					$NewFiles = array($this->upload_of_credentcial->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->upload_of_credentcial->Upload->Index < 0) ? $this->upload_of_credentcial->FldVar : substr($this->upload_of_credentcial->FldVar, 0, 1) . $this->upload_of_credentcial->Upload->Index . substr($this->upload_of_credentcial->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->upload_of_credentcial->TblVar) . $file)) {
								$file1 = ew_UploadFileNameEx($this->upload_of_credentcial->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->upload_of_credentcial->TblVar) . $file1) || file_exists($this->upload_of_credentcial->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->upload_of_credentcial->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->upload_of_credentcial->TblVar) . $file, ew_UploadTempPath($fldvar, $this->upload_of_credentcial->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->upload_of_credentcial->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->upload_of_credentcial->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->upload_of_credentcial->SetDbValueDef($rsnew, $this->upload_of_credentcial->Upload->FileName, NULL, $this->upload_of_credentcial->ReadOnly);
				}
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
					if ($this->upload_of_credentcial->Visible && !$this->upload_of_credentcial->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->upload_of_credentcial->Upload->DbValue) ? array() : array($this->upload_of_credentcial->Upload->DbValue);
						if (!ew_Empty($this->upload_of_credentcial->Upload->FileName)) {
							$NewFiles = array($this->upload_of_credentcial->Upload->FileName);
							$NewFiles2 = array($rsnew['upload_of_credentcial']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->upload_of_credentcial->Upload->Index < 0) ? $this->upload_of_credentcial->FldVar : substr($this->upload_of_credentcial->FldVar, 0, 1) . $this->upload_of_credentcial->Upload->Index . substr($this->upload_of_credentcial->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->upload_of_credentcial->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->upload_of_credentcial->Upload->ResizeAndSaveToFile($this->upload_of_credentcial->ImageWidth, $this->upload_of_credentcial->ImageHeight, EW_THUMBNAIL_DEFAULT_QUALITY, $NewFiles[$i], TRUE, $i)) {
											$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$NewFiles = array();
						}
					}
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// upload_of_credentcial
		ew_CleanUploadTempPath($this->upload_of_credentcial, $this->upload_of_credentcial->Upload->Index);
		return $EditRow;
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
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Set up multi pages
	function SetupMultiPages() {
		$pages = new cSubPages();
		$pages->Style = "tabs";
		$pages->Add(0);
		$pages->Add(1);
		$pages->Add(2);
		$pages->Add(3);
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
if (!isset($user_profile_edit)) $user_profile_edit = new cuser_profile_edit();

// Page init
$user_profile_edit->Page_Init();

// Page main
$user_profile_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$user_profile_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fuser_profileedit = new ew_Form("fuser_profileedit", "edit");

// Validate form
fuser_profileedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user_profile->username->FldCaption(), $user_profile->username->ReqErrMsg)) ?>");
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
fuser_profileedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fuser_profileedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Multi-Page
fuser_profileedit.MultiPage = new ew_MultiPage("fuser_profileedit");

// Dynamic selection lists
fuser_profileedit.Lists["x_gender"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profileedit.Lists["x_gender"].Options = <?php echo json_encode($user_profile_edit->gender->Options()) ?>;
fuser_profileedit.Lists["x_marital_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profileedit.Lists["x_marital_status"].Options = <?php echo json_encode($user_profile_edit->marital_status->Options()) ?>;
fuser_profileedit.Lists["x_company"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":["x_department"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fuser_profileedit.Lists["x_company"].Data = "<?php echo $user_profile_edit->company->LookupFilterQuery(FALSE, "edit") ?>";
fuser_profileedit.Lists["x_department"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":["x_company"],"ChildFields":[],"FilterFields":["x_company_id"],"Options":[],"Template":"","LinkTable":"department"};
fuser_profileedit.Lists["x_department"].Data = "<?php echo $user_profile_edit->department->LookupFilterQuery(FALSE, "edit") ?>";
fuser_profileedit.Lists["x_town_city"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_state_descriptions","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"states_table"};
fuser_profileedit.Lists["x_town_city"].Data = "<?php echo $user_profile_edit->town_city->LookupFilterQuery(FALSE, "edit") ?>";
fuser_profileedit.Lists["x_state_origin"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_state_descriptions","","",""],"ParentFields":[],"ChildFields":["x_local_gra"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"states_table"};
fuser_profileedit.Lists["x_state_origin"].Data = "<?php echo $user_profile_edit->state_origin->LookupFilterQuery(FALSE, "edit") ?>";
fuser_profileedit.Lists["x_local_gra"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_lga_descriptions","","",""],"ParentFields":["x_state_origin"],"ChildFields":[],"FilterFields":["x_state_code"],"Options":[],"Template":"","LinkTable":"lga_states"};
fuser_profileedit.Lists["x_local_gra"].Data = "<?php echo $user_profile_edit->local_gra->LookupFilterQuery(FALSE, "edit") ?>";
fuser_profileedit.Lists["x_qualification_level"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profileedit.Lists["x_qualification_level"].Options = <?php echo json_encode($user_profile_edit->qualification_level->Options()) ?>;
fuser_profileedit.Lists["x_qualification_grade"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profileedit.Lists["x_qualification_grade"].Options = <?php echo json_encode($user_profile_edit->qualification_grade->Options()) ?>;
fuser_profileedit.Lists["x_accesslevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};
fuser_profileedit.Lists["x_accesslevel"].Data = "<?php echo $user_profile_edit->accesslevel->LookupFilterQuery(FALSE, "edit") ?>";
fuser_profileedit.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuser_profileedit.Lists["x_status"].Options = <?php echo json_encode($user_profile_edit->status->Options()) ?>;

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
<?php $user_profile_edit->ShowPageHeader(); ?>
<?php
$user_profile_edit->ShowMessage();
?>
<form name="fuser_profileedit" id="fuser_profileedit" class="<?php echo $user_profile_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($user_profile_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $user_profile_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="user_profile">
<?php if ($user_profile->CurrentAction == "F") { // Confirm page ?>
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="a_confirm" id="a_confirm" value="F">
<?php } else { ?>
<input type="hidden" name="a_edit" id="a_edit" value="F">
<?php } ?>
<input type="hidden" name="modal" value="<?php echo intval($user_profile_edit->IsModal) ?>">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div class="ewMultiPage"><!-- multi-page -->
<div class="nav-tabs-custom" id="user_profile_edit"><!-- multi-page .nav-tabs-custom -->
	<ul class="nav<?php echo $user_profile_edit->MultiPages->NavStyle() ?>">
		<li<?php echo $user_profile_edit->MultiPages->TabStyle("1") ?>><a href="#tab_user_profile1" data-toggle="tab"><?php echo $user_profile->PageCaption(1) ?></a></li>
		<li<?php echo $user_profile_edit->MultiPages->TabStyle("2") ?>><a href="#tab_user_profile2" data-toggle="tab"><?php echo $user_profile->PageCaption(2) ?></a></li>
		<li<?php echo $user_profile_edit->MultiPages->TabStyle("3") ?>><a href="#tab_user_profile3" data-toggle="tab"><?php echo $user_profile->PageCaption(3) ?></a></li>
	</ul>
	<div class="tab-content"><!-- multi-page .nav-tabs-custom .tab-content -->
		<div class="tab-pane<?php echo $user_profile_edit->MultiPages->PageStyle("1") ?>" id="tab_user_profile1"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($user_profile->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_user_profile_id" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->id->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->id->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_id">
<span<?php echo $user_profile->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_id" data-page="1" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($user_profile->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_user_profile_id">
<span<?php echo $user_profile->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_id" data-page="1" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($user_profile->id->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->staff_id->Visible) { // staff_id ?>
	<div id="r_staff_id" class="form-group">
		<label id="elh_user_profile_staff_id" for="x_staff_id" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->staff_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->staff_id->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$user_profile->UserIDAllow("edit")) { // Non system admin ?>
<span id="el_user_profile_staff_id">
<span<?php echo $user_profile->staff_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->staff_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_staff_id" data-page="1" name="x_staff_id" id="x_staff_id" value="<?php echo ew_HtmlEncode($user_profile->staff_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_user_profile_staff_id">
<input type="text" data-table="user_profile" data-field="x_staff_id" data-page="1" name="x_staff_id" id="x_staff_id" placeholder="<?php echo ew_HtmlEncode($user_profile->staff_id->getPlaceHolder()) ?>" value="<?php echo $user_profile->staff_id->EditValue ?>"<?php echo $user_profile->staff_id->EditAttributes() ?>>
</span>
<?php } ?>
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
		<label id="elh_user_profile_last_name" for="x_last_name" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->last_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->last_name->CellAttributes() ?>>
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
		<label id="elh_user_profile_first_name" for="x_first_name" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->first_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->first_name->CellAttributes() ?>>
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
		<label id="elh_user_profile__email" for="x__email" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->_email->CellAttributes() ?>>
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
		<label id="elh_user_profile_gender" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->gender->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->gender->CellAttributes() ?>>
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
		<label id="elh_user_profile_marital_status" for="x_marital_status" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->marital_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->marital_status->CellAttributes() ?>>
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
		<label id="elh_user_profile_date_of_birth" for="x_date_of_birth" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->date_of_birth->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->date_of_birth->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_date_of_birth">
<input type="text" data-table="user_profile" data-field="x_date_of_birth" data-page="1" data-format="7" name="x_date_of_birth" id="x_date_of_birth" size="10" placeholder="<?php echo ew_HtmlEncode($user_profile->date_of_birth->getPlaceHolder()) ?>" value="<?php echo $user_profile->date_of_birth->EditValue ?>"<?php echo $user_profile->date_of_birth->EditAttributes() ?>>
<?php if (!$user_profile->date_of_birth->ReadOnly && !$user_profile->date_of_birth->Disabled && !isset($user_profile->date_of_birth->EditAttrs["readonly"]) && !isset($user_profile->date_of_birth->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fuser_profileedit", "x_date_of_birth", {"ignoreReadonly":true,"useCurrent":false,"format":7});
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
		<label id="elh_user_profile_username" for="x_username" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->username->CellAttributes() ?>>
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
		<label id="elh_user_profile_mobile" for="x_mobile" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->mobile->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->mobile->CellAttributes() ?>>
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
		<label id="elh_user_profile_company" for="x_company" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->company->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->company->CellAttributes() ?>>
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
		<label id="elh_user_profile_department" for="x_department" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->department->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->department->CellAttributes() ?>>
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
		<label id="elh_user_profile_home_address" for="x_home_address" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->home_address->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->home_address->CellAttributes() ?>>
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
		<label id="elh_user_profile_town_city" for="x_town_city" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->town_city->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->town_city->CellAttributes() ?>>
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
		<label id="elh_user_profile_state_origin" for="x_state_origin" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->state_origin->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->state_origin->CellAttributes() ?>>
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
		<label id="elh_user_profile_local_gra" for="x_local_gra" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->local_gra->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->local_gra->CellAttributes() ?>>
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
		<div class="tab-pane<?php echo $user_profile_edit->MultiPages->PageStyle("2") ?>" id="tab_user_profile2"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($user_profile->next_kin->Visible) { // next_kin ?>
	<div id="r_next_kin" class="form-group">
		<label id="elh_user_profile_next_kin" for="x_next_kin" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->next_kin->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->next_kin->CellAttributes() ?>>
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
		<label id="elh_user_profile_resident_nxt_kin" for="x_resident_nxt_kin" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->resident_nxt_kin->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->resident_nxt_kin->CellAttributes() ?>>
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
		<label id="elh_user_profile_nearest_bus_stop" for="x_nearest_bus_stop" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->nearest_bus_stop->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->nearest_bus_stop->CellAttributes() ?>>
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
		<label id="elh_user_profile_town_city_nxt_kin" for="x_town_city_nxt_kin" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->town_city_nxt_kin->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->town_city_nxt_kin->CellAttributes() ?>>
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
		<label id="elh_user_profile_email_nxt_kin" for="x_email_nxt_kin" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->email_nxt_kin->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->email_nxt_kin->CellAttributes() ?>>
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
		<label id="elh_user_profile_phone_nxt_kin" for="x_phone_nxt_kin" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->phone_nxt_kin->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->phone_nxt_kin->CellAttributes() ?>>
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
		<label id="elh_user_profile_qualification_level" for="x_qualification_level" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->qualification_level->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->qualification_level->CellAttributes() ?>>
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
		<label id="elh_user_profile_qualification_grade" for="x_qualification_grade" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->qualification_grade->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->qualification_grade->CellAttributes() ?>>
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
<?php if ($user_profile->upload_of_credentcial->Visible) { // upload_of_credentcial ?>
	<div id="r_upload_of_credentcial" class="form-group">
		<label id="elh_user_profile_upload_of_credentcial" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->upload_of_credentcial->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->upload_of_credentcial->CellAttributes() ?>>
<span id="el_user_profile_upload_of_credentcial">
<div id="fd_x_upload_of_credentcial">
<span title="<?php echo $user_profile->upload_of_credentcial->FldTitle() ? $user_profile->upload_of_credentcial->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($user_profile->upload_of_credentcial->ReadOnly || $user_profile->upload_of_credentcial->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="user_profile" data-field="x_upload_of_credentcial" data-page="2" name="x_upload_of_credentcial" id="x_upload_of_credentcial"<?php echo $user_profile->upload_of_credentcial->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_upload_of_credentcial" id= "fn_x_upload_of_credentcial" value="<?php echo $user_profile->upload_of_credentcial->Upload->FileName ?>">
<?php if (@$_POST["fa_x_upload_of_credentcial"] == "0") { ?>
<input type="hidden" name="fa_x_upload_of_credentcial" id= "fa_x_upload_of_credentcial" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_upload_of_credentcial" id= "fa_x_upload_of_credentcial" value="1">
<?php } ?>
<input type="hidden" name="fs_x_upload_of_credentcial" id= "fs_x_upload_of_credentcial" value="225">
<input type="hidden" name="fx_x_upload_of_credentcial" id= "fx_x_upload_of_credentcial" value="<?php echo $user_profile->upload_of_credentcial->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_upload_of_credentcial" id= "fm_x_upload_of_credentcial" value="<?php echo $user_profile->upload_of_credentcial->UploadMaxFileSize ?>">
</div>
<table id="ft_x_upload_of_credentcial" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $user_profile->upload_of_credentcial->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->password->Visible) { // password ?>
	<div id="r_password" class="form-group">
		<label id="elh_user_profile_password" for="x_password" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->password->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_password">
<div class="input-group" id="ig_password">
<input type="password" data-password-generated="pgt_password" data-table="user_profile" data-field="x_password" data-page="2" name="x_password" id="x_password" value="<?php echo $user_profile->password->EditValue ?>" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($user_profile->password->getPlaceHolder()) ?>"<?php echo $user_profile->password->EditAttributes() ?>>
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
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
		<div class="tab-pane<?php echo $user_profile_edit->MultiPages->PageStyle("3") ?>" id="tab_user_profile3"><!-- multi-page .tab-pane -->
<div class="ewEditDiv"><!-- page* -->
<?php if ($user_profile->accesslevel->Visible) { // accesslevel ?>
	<div id="r_accesslevel" class="form-group">
		<label id="elh_user_profile_accesslevel" for="x_accesslevel" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->accesslevel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->accesslevel->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_user_profile_accesslevel">
<p class="form-control-static"><?php echo $user_profile->accesslevel->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_user_profile_accesslevel">
<select data-table="user_profile" data-field="x_accesslevel" data-page="3" data-value-separator="<?php echo $user_profile->accesslevel->DisplayValueSeparatorAttribute() ?>" id="x_accesslevel" name="x_accesslevel"<?php echo $user_profile->accesslevel->EditAttributes() ?>>
<?php echo $user_profile->accesslevel->SelectOptionListHtml("x_accesslevel") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el_user_profile_accesslevel">
<span<?php echo $user_profile->accesslevel->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->accesslevel->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_accesslevel" data-page="3" name="x_accesslevel" id="x_accesslevel" value="<?php echo ew_HtmlEncode($user_profile->accesslevel->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->accesslevel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_user_profile_status" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->status->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->status->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="user_profile" data-field="x_status" data-page="3" data-value-separator="<?php echo $user_profile->status->DisplayValueSeparatorAttribute() ?>" name="x_status" id="x_status" value="{value}"<?php echo $user_profile->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $user_profile->status->RadioButtonListHtml(FALSE, "x_status", 3) ?>
</div></div>
</span>
<?php } else { ?>
<span id="el_user_profile_status">
<span<?php echo $user_profile->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_status" data-page="3" name="x_status" id="x_status" value="<?php echo ew_HtmlEncode($user_profile->status->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user_profile->profile->Visible) { // profile ?>
	<div id="r_profile" class="form-group">
		<label id="elh_user_profile_profile" for="x_profile" class="<?php echo $user_profile_edit->LeftColumnClass ?>"><?php echo $user_profile->profile->FldCaption() ?></label>
		<div class="<?php echo $user_profile_edit->RightColumnClass ?>"><div<?php echo $user_profile->profile->CellAttributes() ?>>
<?php if ($user_profile->CurrentAction <> "F") { ?>
<span id="el_user_profile_profile">
<textarea data-table="user_profile" data-field="x_profile" data-page="3" name="x_profile" id="x_profile" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($user_profile->profile->getPlaceHolder()) ?>"<?php echo $user_profile->profile->EditAttributes() ?>><?php echo $user_profile->profile->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el_user_profile_profile">
<span<?php echo $user_profile->profile->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $user_profile->profile->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="user_profile" data-field="x_profile" data-page="3" name="x_profile" id="x_profile" value="<?php echo ew_HtmlEncode($user_profile->profile->FormValue) ?>">
<?php } ?>
<?php echo $user_profile->profile->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
		</div><!-- /multi-page .tab-pane -->
	</div><!-- /multi-page .nav-tabs-custom .tab-content -->
</div><!-- /multi-page .nav-tabs-custom -->
</div><!-- /multi-page -->
<?php if (!$user_profile_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $user_profile_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($user_profile->CurrentAction <> "F") { // Confirm page ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit" onclick="this.form.a_edit.value='F';"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $user_profile_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="submit" onclick="this.form.a_edit.value='X';"><?php echo $Language->Phrase("CancelBtn") ?></button>
<?php } ?>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fuser_profileedit.Init();
</script>
<?php
$user_profile_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$user_profile_edit->Page_Terminate();
?>
