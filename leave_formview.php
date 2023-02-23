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

$leave_form_view = NULL; // Initialize page object first

class cleave_form_view extends cleave_form {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'leave_form';

	// Page object name
	var $PageObjName = 'leave_form_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (user_profile)
		if (!isset($GLOBALS['user_profile'])) $GLOBALS['user_profile'] = new cuser_profile();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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
		// Get export parameters

		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} elseif (@$_GET["cmd"] == "json") {
			$this->Export = $_GET["cmd"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= $_GET["id"];
		}

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Setup export options
		$this->SetupExportOptions();
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "leave_formlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "leave_formlist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "leave_formlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$row = array();
		$row['id'] = NULL;
		$row['leave_id'] = NULL;
		$row['date_created'] = NULL;
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
		$row['replacement_assign_staff'] = NULL;
		$row['purpose_of_leave'] = NULL;
		$row['status'] = NULL;
		$row['initiator_action'] = NULL;
		$row['initiator_comments'] = NULL;
		$row['verified_staff'] = NULL;
		$row['verified_replacement_staff'] = NULL;
		$row['recommender_action'] = NULL;
		$row['recommender_comments'] = NULL;
		$row['approver_action'] = NULL;
		$row['approver_comments'] = NULL;
		$row['last_updated_date'] = NULL;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_leave_form\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_leave_form',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fleave_formview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->ListRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetupStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("leave_formlist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($leave_form_view)) $leave_form_view = new cleave_form_view();

// Page init
$leave_form_view->Page_Init();

// Page main
$leave_form_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$leave_form_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($leave_form->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fleave_formview = new ew_Form("fleave_formview", "view");

// Form_CustomValidate event
fleave_formview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fleave_formview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fleave_formview.Lists["x_company"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":["x_department","x_replacement_assign_staff"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fleave_formview.Lists["x_company"].Data = "<?php echo $leave_form_view->company->LookupFilterQuery(FALSE, "view") ?>";
fleave_formview.Lists["x_department"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"department"};
fleave_formview.Lists["x_department"].Data = "<?php echo $leave_form_view->department->LookupFilterQuery(FALSE, "view") ?>";
fleave_formview.Lists["x_leave_type"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"leave_type"};
fleave_formview.Lists["x_leave_type"].Data = "<?php echo $leave_form_view->leave_type->LookupFilterQuery(FALSE, "view") ?>";
fleave_formview.Lists["x_replacement_assign_staff"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_first_name","x_last_name","x_mobile",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"user_profile"};
fleave_formview.Lists["x_replacement_assign_staff"].Data = "<?php echo $leave_form_view->replacement_assign_staff->LookupFilterQuery(FALSE, "view") ?>";
fleave_formview.Lists["x_status"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"status"};
fleave_formview.Lists["x_status"].Data = "<?php echo $leave_form_view->status->LookupFilterQuery(FALSE, "view") ?>";
fleave_formview.AutoSuggests["x_status"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $leave_form_view->status->LookupFilterQuery(TRUE, "view"))) ?>;
fleave_formview.Lists["x_initiator_action"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formview.Lists["x_initiator_action"].Options = <?php echo json_encode($leave_form_view->initiator_action->Options()) ?>;
fleave_formview.Lists["x_verified_staff"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formview.Lists["x_verified_staff"].Options = <?php echo json_encode($leave_form_view->verified_staff->Options()) ?>;
fleave_formview.Lists["x_verified_replacement_staff"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formview.Lists["x_verified_replacement_staff"].Options = <?php echo json_encode($leave_form_view->verified_replacement_staff->Options()) ?>;
fleave_formview.Lists["x_recommender_action"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formview.Lists["x_recommender_action"].Options = <?php echo json_encode($leave_form_view->recommender_action->Options()) ?>;
fleave_formview.Lists["x_approver_action"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fleave_formview.Lists["x_approver_action"].Options = <?php echo json_encode($leave_form_view->approver_action->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($leave_form->Export == "") { ?>
<div class="ewToolbar">
<?php $leave_form_view->ExportOptions->Render("body") ?>
<?php
	foreach ($leave_form_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $leave_form_view->ShowPageHeader(); ?>
<?php
$leave_form_view->ShowMessage();
?>
<form name="fleave_formview" id="fleave_formview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($leave_form_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $leave_form_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="leave_form">
<input type="hidden" name="modal" value="<?php echo intval($leave_form_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($leave_form->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="col-sm-2"><span id="elh_leave_form_id"><?php echo $leave_form->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $leave_form->id->CellAttributes() ?>>
<span id="el_leave_form_id">
<span<?php echo $leave_form->id->ViewAttributes() ?>>
<?php echo $leave_form->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->leave_id->Visible) { // leave_id ?>
	<tr id="r_leave_id">
		<td class="col-sm-2"><span id="elh_leave_form_leave_id"><?php echo $leave_form->leave_id->FldCaption() ?></span></td>
		<td data-name="leave_id"<?php echo $leave_form->leave_id->CellAttributes() ?>>
<span id="el_leave_form_leave_id">
<span<?php echo $leave_form->leave_id->ViewAttributes() ?>>
<?php echo $leave_form->leave_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->date_created->Visible) { // date_created ?>
	<tr id="r_date_created">
		<td class="col-sm-2"><span id="elh_leave_form_date_created"><?php echo $leave_form->date_created->FldCaption() ?></span></td>
		<td data-name="date_created"<?php echo $leave_form->date_created->CellAttributes() ?>>
<span id="el_leave_form_date_created">
<span<?php echo $leave_form->date_created->ViewAttributes() ?>>
<?php echo $leave_form->date_created->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->time->Visible) { // time ?>
	<tr id="r_time">
		<td class="col-sm-2"><span id="elh_leave_form_time"><?php echo $leave_form->time->FldCaption() ?></span></td>
		<td data-name="time"<?php echo $leave_form->time->CellAttributes() ?>>
<span id="el_leave_form_time">
<span<?php echo $leave_form->time->ViewAttributes() ?>>
<?php echo $leave_form->time->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->staff_id->Visible) { // staff_id ?>
	<tr id="r_staff_id">
		<td class="col-sm-2"><span id="elh_leave_form_staff_id"><?php echo $leave_form->staff_id->FldCaption() ?></span></td>
		<td data-name="staff_id"<?php echo $leave_form->staff_id->CellAttributes() ?>>
<span id="el_leave_form_staff_id">
<span<?php echo $leave_form->staff_id->ViewAttributes() ?>>
<?php echo $leave_form->staff_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->staff_name->Visible) { // staff_name ?>
	<tr id="r_staff_name">
		<td class="col-sm-2"><span id="elh_leave_form_staff_name"><?php echo $leave_form->staff_name->FldCaption() ?></span></td>
		<td data-name="staff_name"<?php echo $leave_form->staff_name->CellAttributes() ?>>
<span id="el_leave_form_staff_name">
<span<?php echo $leave_form->staff_name->ViewAttributes() ?>>
<?php echo $leave_form->staff_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->company->Visible) { // company ?>
	<tr id="r_company">
		<td class="col-sm-2"><span id="elh_leave_form_company"><?php echo $leave_form->company->FldCaption() ?></span></td>
		<td data-name="company"<?php echo $leave_form->company->CellAttributes() ?>>
<span id="el_leave_form_company">
<span<?php echo $leave_form->company->ViewAttributes() ?>>
<?php echo $leave_form->company->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->department->Visible) { // department ?>
	<tr id="r_department">
		<td class="col-sm-2"><span id="elh_leave_form_department"><?php echo $leave_form->department->FldCaption() ?></span></td>
		<td data-name="department"<?php echo $leave_form->department->CellAttributes() ?>>
<span id="el_leave_form_department">
<span<?php echo $leave_form->department->ViewAttributes() ?>>
<?php echo $leave_form->department->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->leave_type->Visible) { // leave_type ?>
	<tr id="r_leave_type">
		<td class="col-sm-2"><span id="elh_leave_form_leave_type"><?php echo $leave_form->leave_type->FldCaption() ?></span></td>
		<td data-name="leave_type"<?php echo $leave_form->leave_type->CellAttributes() ?>>
<span id="el_leave_form_leave_type">
<span<?php echo $leave_form->leave_type->ViewAttributes() ?>>
<?php echo $leave_form->leave_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->start_date->Visible) { // start_date ?>
	<tr id="r_start_date">
		<td class="col-sm-2"><span id="elh_leave_form_start_date"><?php echo $leave_form->start_date->FldCaption() ?></span></td>
		<td data-name="start_date"<?php echo $leave_form->start_date->CellAttributes() ?>>
<span id="el_leave_form_start_date">
<span<?php echo $leave_form->start_date->ViewAttributes() ?>>
<?php echo $leave_form->start_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->end_date->Visible) { // end_date ?>
	<tr id="r_end_date">
		<td class="col-sm-2"><span id="elh_leave_form_end_date"><?php echo $leave_form->end_date->FldCaption() ?></span></td>
		<td data-name="end_date"<?php echo $leave_form->end_date->CellAttributes() ?>>
<span id="el_leave_form_end_date">
<span<?php echo $leave_form->end_date->ViewAttributes() ?>>
<?php echo $leave_form->end_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->no_of_days->Visible) { // no_of_days ?>
	<tr id="r_no_of_days">
		<td class="col-sm-2"><span id="elh_leave_form_no_of_days"><?php echo $leave_form->no_of_days->FldCaption() ?></span></td>
		<td data-name="no_of_days"<?php echo $leave_form->no_of_days->CellAttributes() ?>>
<span id="el_leave_form_no_of_days">
<span<?php echo $leave_form->no_of_days->ViewAttributes() ?>>
<?php echo $leave_form->no_of_days->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->resumption_date->Visible) { // resumption_date ?>
	<tr id="r_resumption_date">
		<td class="col-sm-2"><span id="elh_leave_form_resumption_date"><?php echo $leave_form->resumption_date->FldCaption() ?></span></td>
		<td data-name="resumption_date"<?php echo $leave_form->resumption_date->CellAttributes() ?>>
<span id="el_leave_form_resumption_date">
<span<?php echo $leave_form->resumption_date->ViewAttributes() ?>>
<?php echo $leave_form->resumption_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->replacement_assign_staff->Visible) { // replacement_assign_staff ?>
	<tr id="r_replacement_assign_staff">
		<td class="col-sm-2"><span id="elh_leave_form_replacement_assign_staff"><?php echo $leave_form->replacement_assign_staff->FldCaption() ?></span></td>
		<td data-name="replacement_assign_staff"<?php echo $leave_form->replacement_assign_staff->CellAttributes() ?>>
<span id="el_leave_form_replacement_assign_staff">
<span<?php echo $leave_form->replacement_assign_staff->ViewAttributes() ?>>
<?php echo $leave_form->replacement_assign_staff->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->purpose_of_leave->Visible) { // purpose_of_leave ?>
	<tr id="r_purpose_of_leave">
		<td class="col-sm-2"><span id="elh_leave_form_purpose_of_leave"><?php echo $leave_form->purpose_of_leave->FldCaption() ?></span></td>
		<td data-name="purpose_of_leave"<?php echo $leave_form->purpose_of_leave->CellAttributes() ?>>
<span id="el_leave_form_purpose_of_leave">
<span<?php echo $leave_form->purpose_of_leave->ViewAttributes() ?>>
<?php echo $leave_form->purpose_of_leave->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->status->Visible) { // status ?>
	<tr id="r_status">
		<td class="col-sm-2"><span id="elh_leave_form_status"><?php echo $leave_form->status->FldCaption() ?></span></td>
		<td data-name="status"<?php echo $leave_form->status->CellAttributes() ?>>
<span id="el_leave_form_status">
<span<?php echo $leave_form->status->ViewAttributes() ?>>
<?php echo $leave_form->status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->initiator_action->Visible) { // initiator_action ?>
	<tr id="r_initiator_action">
		<td class="col-sm-2"><span id="elh_leave_form_initiator_action"><?php echo $leave_form->initiator_action->FldCaption() ?></span></td>
		<td data-name="initiator_action"<?php echo $leave_form->initiator_action->CellAttributes() ?>>
<span id="el_leave_form_initiator_action">
<span<?php echo $leave_form->initiator_action->ViewAttributes() ?>>
<?php echo $leave_form->initiator_action->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->initiator_comments->Visible) { // initiator_comments ?>
	<tr id="r_initiator_comments">
		<td class="col-sm-2"><span id="elh_leave_form_initiator_comments"><?php echo $leave_form->initiator_comments->FldCaption() ?></span></td>
		<td data-name="initiator_comments"<?php echo $leave_form->initiator_comments->CellAttributes() ?>>
<span id="el_leave_form_initiator_comments">
<span<?php echo $leave_form->initiator_comments->ViewAttributes() ?>>
<?php echo $leave_form->initiator_comments->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->verified_staff->Visible) { // verified_staff ?>
	<tr id="r_verified_staff">
		<td class="col-sm-2"><span id="elh_leave_form_verified_staff"><?php echo $leave_form->verified_staff->FldCaption() ?></span></td>
		<td data-name="verified_staff"<?php echo $leave_form->verified_staff->CellAttributes() ?>>
<span id="el_leave_form_verified_staff">
<span<?php echo $leave_form->verified_staff->ViewAttributes() ?>>
<?php echo $leave_form->verified_staff->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->verified_replacement_staff->Visible) { // verified_replacement_staff ?>
	<tr id="r_verified_replacement_staff">
		<td class="col-sm-2"><span id="elh_leave_form_verified_replacement_staff"><?php echo $leave_form->verified_replacement_staff->FldCaption() ?></span></td>
		<td data-name="verified_replacement_staff"<?php echo $leave_form->verified_replacement_staff->CellAttributes() ?>>
<span id="el_leave_form_verified_replacement_staff">
<span<?php echo $leave_form->verified_replacement_staff->ViewAttributes() ?>>
<?php echo $leave_form->verified_replacement_staff->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->recommender_action->Visible) { // recommender_action ?>
	<tr id="r_recommender_action">
		<td class="col-sm-2"><span id="elh_leave_form_recommender_action"><?php echo $leave_form->recommender_action->FldCaption() ?></span></td>
		<td data-name="recommender_action"<?php echo $leave_form->recommender_action->CellAttributes() ?>>
<span id="el_leave_form_recommender_action">
<span<?php echo $leave_form->recommender_action->ViewAttributes() ?>>
<?php echo $leave_form->recommender_action->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->recommender_comments->Visible) { // recommender_comments ?>
	<tr id="r_recommender_comments">
		<td class="col-sm-2"><span id="elh_leave_form_recommender_comments"><?php echo $leave_form->recommender_comments->FldCaption() ?></span></td>
		<td data-name="recommender_comments"<?php echo $leave_form->recommender_comments->CellAttributes() ?>>
<span id="el_leave_form_recommender_comments">
<span<?php echo $leave_form->recommender_comments->ViewAttributes() ?>>
<?php echo $leave_form->recommender_comments->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->approver_action->Visible) { // approver_action ?>
	<tr id="r_approver_action">
		<td class="col-sm-2"><span id="elh_leave_form_approver_action"><?php echo $leave_form->approver_action->FldCaption() ?></span></td>
		<td data-name="approver_action"<?php echo $leave_form->approver_action->CellAttributes() ?>>
<span id="el_leave_form_approver_action">
<span<?php echo $leave_form->approver_action->ViewAttributes() ?>>
<?php echo $leave_form->approver_action->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->approver_comments->Visible) { // approver_comments ?>
	<tr id="r_approver_comments">
		<td class="col-sm-2"><span id="elh_leave_form_approver_comments"><?php echo $leave_form->approver_comments->FldCaption() ?></span></td>
		<td data-name="approver_comments"<?php echo $leave_form->approver_comments->CellAttributes() ?>>
<span id="el_leave_form_approver_comments">
<span<?php echo $leave_form->approver_comments->ViewAttributes() ?>>
<?php echo $leave_form->approver_comments->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($leave_form->last_updated_date->Visible) { // last_updated_date ?>
	<tr id="r_last_updated_date">
		<td class="col-sm-2"><span id="elh_leave_form_last_updated_date"><?php echo $leave_form->last_updated_date->FldCaption() ?></span></td>
		<td data-name="last_updated_date"<?php echo $leave_form->last_updated_date->CellAttributes() ?>>
<span id="el_leave_form_last_updated_date">
<span<?php echo $leave_form->last_updated_date->ViewAttributes() ?>>
<?php echo $leave_form->last_updated_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php if ($leave_form->Export == "") { ?>
<script type="text/javascript">
fleave_formview.Init();
</script>
<?php } ?>
<?php
$leave_form_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($leave_form->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$leave_form_view->Page_Terminate();
?>
