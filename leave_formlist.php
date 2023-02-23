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

$leave_form_list = NULL; // Initialize page object first

class cleave_form_list extends cleave_form {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'leave_form';

	// Page object name
	var $PageObjName = 'leave_form_list';

	// Grid form hidden field names
	var $FormName = 'fleave_formlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "leave_formadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "leave_formdelete.php";
		$this->MultiUpdateUrl = "leave_formupdate.php";

		// Table object (user_profile)
		if (!isset($GLOBALS['user_profile'])) $GLOBALS['user_profile'] = new cuser_profile();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fleave_formlistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->leave_id->SetVisibility();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 10;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $HashValue; // Hash value
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetupDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 10; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetupDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 10; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server" && isset($UserProfile))
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fleave_formlistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->leave_id->AdvancedSearch->ToJson(), ","); // Field leave_id
		$sFilterList = ew_Concat($sFilterList, $this->date_created->AdvancedSearch->ToJson(), ","); // Field date_created
		$sFilterList = ew_Concat($sFilterList, $this->time->AdvancedSearch->ToJson(), ","); // Field time
		$sFilterList = ew_Concat($sFilterList, $this->staff_id->AdvancedSearch->ToJson(), ","); // Field staff_id
		$sFilterList = ew_Concat($sFilterList, $this->staff_name->AdvancedSearch->ToJson(), ","); // Field staff_name
		$sFilterList = ew_Concat($sFilterList, $this->company->AdvancedSearch->ToJson(), ","); // Field company
		$sFilterList = ew_Concat($sFilterList, $this->department->AdvancedSearch->ToJson(), ","); // Field department
		$sFilterList = ew_Concat($sFilterList, $this->leave_type->AdvancedSearch->ToJson(), ","); // Field leave_type
		$sFilterList = ew_Concat($sFilterList, $this->start_date->AdvancedSearch->ToJson(), ","); // Field start_date
		$sFilterList = ew_Concat($sFilterList, $this->end_date->AdvancedSearch->ToJson(), ","); // Field end_date
		$sFilterList = ew_Concat($sFilterList, $this->no_of_days->AdvancedSearch->ToJson(), ","); // Field no_of_days
		$sFilterList = ew_Concat($sFilterList, $this->resumption_date->AdvancedSearch->ToJson(), ","); // Field resumption_date
		$sFilterList = ew_Concat($sFilterList, $this->replacement_assign_staff->AdvancedSearch->ToJson(), ","); // Field replacement_assign_staff
		$sFilterList = ew_Concat($sFilterList, $this->purpose_of_leave->AdvancedSearch->ToJson(), ","); // Field purpose_of_leave
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJson(), ","); // Field status
		$sFilterList = ew_Concat($sFilterList, $this->initiator_action->AdvancedSearch->ToJson(), ","); // Field initiator_action
		$sFilterList = ew_Concat($sFilterList, $this->initiator_comments->AdvancedSearch->ToJson(), ","); // Field initiator_comments
		$sFilterList = ew_Concat($sFilterList, $this->verified_staff->AdvancedSearch->ToJson(), ","); // Field verified_staff
		$sFilterList = ew_Concat($sFilterList, $this->verified_replacement_staff->AdvancedSearch->ToJson(), ","); // Field verified_replacement_staff
		$sFilterList = ew_Concat($sFilterList, $this->recommender_action->AdvancedSearch->ToJson(), ","); // Field recommender_action
		$sFilterList = ew_Concat($sFilterList, $this->recommender_comments->AdvancedSearch->ToJson(), ","); // Field recommender_comments
		$sFilterList = ew_Concat($sFilterList, $this->approver_action->AdvancedSearch->ToJson(), ","); // Field approver_action
		$sFilterList = ew_Concat($sFilterList, $this->approver_comments->AdvancedSearch->ToJson(), ","); // Field approver_comments
		$sFilterList = ew_Concat($sFilterList, $this->last_updated_date->AdvancedSearch->ToJson(), ","); // Field last_updated_date
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fleave_formlistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field leave_id
		$this->leave_id->AdvancedSearch->SearchValue = @$filter["x_leave_id"];
		$this->leave_id->AdvancedSearch->SearchOperator = @$filter["z_leave_id"];
		$this->leave_id->AdvancedSearch->SearchCondition = @$filter["v_leave_id"];
		$this->leave_id->AdvancedSearch->SearchValue2 = @$filter["y_leave_id"];
		$this->leave_id->AdvancedSearch->SearchOperator2 = @$filter["w_leave_id"];
		$this->leave_id->AdvancedSearch->Save();

		// Field date_created
		$this->date_created->AdvancedSearch->SearchValue = @$filter["x_date_created"];
		$this->date_created->AdvancedSearch->SearchOperator = @$filter["z_date_created"];
		$this->date_created->AdvancedSearch->SearchCondition = @$filter["v_date_created"];
		$this->date_created->AdvancedSearch->SearchValue2 = @$filter["y_date_created"];
		$this->date_created->AdvancedSearch->SearchOperator2 = @$filter["w_date_created"];
		$this->date_created->AdvancedSearch->Save();

		// Field time
		$this->time->AdvancedSearch->SearchValue = @$filter["x_time"];
		$this->time->AdvancedSearch->SearchOperator = @$filter["z_time"];
		$this->time->AdvancedSearch->SearchCondition = @$filter["v_time"];
		$this->time->AdvancedSearch->SearchValue2 = @$filter["y_time"];
		$this->time->AdvancedSearch->SearchOperator2 = @$filter["w_time"];
		$this->time->AdvancedSearch->Save();

		// Field staff_id
		$this->staff_id->AdvancedSearch->SearchValue = @$filter["x_staff_id"];
		$this->staff_id->AdvancedSearch->SearchOperator = @$filter["z_staff_id"];
		$this->staff_id->AdvancedSearch->SearchCondition = @$filter["v_staff_id"];
		$this->staff_id->AdvancedSearch->SearchValue2 = @$filter["y_staff_id"];
		$this->staff_id->AdvancedSearch->SearchOperator2 = @$filter["w_staff_id"];
		$this->staff_id->AdvancedSearch->Save();

		// Field staff_name
		$this->staff_name->AdvancedSearch->SearchValue = @$filter["x_staff_name"];
		$this->staff_name->AdvancedSearch->SearchOperator = @$filter["z_staff_name"];
		$this->staff_name->AdvancedSearch->SearchCondition = @$filter["v_staff_name"];
		$this->staff_name->AdvancedSearch->SearchValue2 = @$filter["y_staff_name"];
		$this->staff_name->AdvancedSearch->SearchOperator2 = @$filter["w_staff_name"];
		$this->staff_name->AdvancedSearch->Save();

		// Field company
		$this->company->AdvancedSearch->SearchValue = @$filter["x_company"];
		$this->company->AdvancedSearch->SearchOperator = @$filter["z_company"];
		$this->company->AdvancedSearch->SearchCondition = @$filter["v_company"];
		$this->company->AdvancedSearch->SearchValue2 = @$filter["y_company"];
		$this->company->AdvancedSearch->SearchOperator2 = @$filter["w_company"];
		$this->company->AdvancedSearch->Save();

		// Field department
		$this->department->AdvancedSearch->SearchValue = @$filter["x_department"];
		$this->department->AdvancedSearch->SearchOperator = @$filter["z_department"];
		$this->department->AdvancedSearch->SearchCondition = @$filter["v_department"];
		$this->department->AdvancedSearch->SearchValue2 = @$filter["y_department"];
		$this->department->AdvancedSearch->SearchOperator2 = @$filter["w_department"];
		$this->department->AdvancedSearch->Save();

		// Field leave_type
		$this->leave_type->AdvancedSearch->SearchValue = @$filter["x_leave_type"];
		$this->leave_type->AdvancedSearch->SearchOperator = @$filter["z_leave_type"];
		$this->leave_type->AdvancedSearch->SearchCondition = @$filter["v_leave_type"];
		$this->leave_type->AdvancedSearch->SearchValue2 = @$filter["y_leave_type"];
		$this->leave_type->AdvancedSearch->SearchOperator2 = @$filter["w_leave_type"];
		$this->leave_type->AdvancedSearch->Save();

		// Field start_date
		$this->start_date->AdvancedSearch->SearchValue = @$filter["x_start_date"];
		$this->start_date->AdvancedSearch->SearchOperator = @$filter["z_start_date"];
		$this->start_date->AdvancedSearch->SearchCondition = @$filter["v_start_date"];
		$this->start_date->AdvancedSearch->SearchValue2 = @$filter["y_start_date"];
		$this->start_date->AdvancedSearch->SearchOperator2 = @$filter["w_start_date"];
		$this->start_date->AdvancedSearch->Save();

		// Field end_date
		$this->end_date->AdvancedSearch->SearchValue = @$filter["x_end_date"];
		$this->end_date->AdvancedSearch->SearchOperator = @$filter["z_end_date"];
		$this->end_date->AdvancedSearch->SearchCondition = @$filter["v_end_date"];
		$this->end_date->AdvancedSearch->SearchValue2 = @$filter["y_end_date"];
		$this->end_date->AdvancedSearch->SearchOperator2 = @$filter["w_end_date"];
		$this->end_date->AdvancedSearch->Save();

		// Field no_of_days
		$this->no_of_days->AdvancedSearch->SearchValue = @$filter["x_no_of_days"];
		$this->no_of_days->AdvancedSearch->SearchOperator = @$filter["z_no_of_days"];
		$this->no_of_days->AdvancedSearch->SearchCondition = @$filter["v_no_of_days"];
		$this->no_of_days->AdvancedSearch->SearchValue2 = @$filter["y_no_of_days"];
		$this->no_of_days->AdvancedSearch->SearchOperator2 = @$filter["w_no_of_days"];
		$this->no_of_days->AdvancedSearch->Save();

		// Field resumption_date
		$this->resumption_date->AdvancedSearch->SearchValue = @$filter["x_resumption_date"];
		$this->resumption_date->AdvancedSearch->SearchOperator = @$filter["z_resumption_date"];
		$this->resumption_date->AdvancedSearch->SearchCondition = @$filter["v_resumption_date"];
		$this->resumption_date->AdvancedSearch->SearchValue2 = @$filter["y_resumption_date"];
		$this->resumption_date->AdvancedSearch->SearchOperator2 = @$filter["w_resumption_date"];
		$this->resumption_date->AdvancedSearch->Save();

		// Field replacement_assign_staff
		$this->replacement_assign_staff->AdvancedSearch->SearchValue = @$filter["x_replacement_assign_staff"];
		$this->replacement_assign_staff->AdvancedSearch->SearchOperator = @$filter["z_replacement_assign_staff"];
		$this->replacement_assign_staff->AdvancedSearch->SearchCondition = @$filter["v_replacement_assign_staff"];
		$this->replacement_assign_staff->AdvancedSearch->SearchValue2 = @$filter["y_replacement_assign_staff"];
		$this->replacement_assign_staff->AdvancedSearch->SearchOperator2 = @$filter["w_replacement_assign_staff"];
		$this->replacement_assign_staff->AdvancedSearch->Save();

		// Field purpose_of_leave
		$this->purpose_of_leave->AdvancedSearch->SearchValue = @$filter["x_purpose_of_leave"];
		$this->purpose_of_leave->AdvancedSearch->SearchOperator = @$filter["z_purpose_of_leave"];
		$this->purpose_of_leave->AdvancedSearch->SearchCondition = @$filter["v_purpose_of_leave"];
		$this->purpose_of_leave->AdvancedSearch->SearchValue2 = @$filter["y_purpose_of_leave"];
		$this->purpose_of_leave->AdvancedSearch->SearchOperator2 = @$filter["w_purpose_of_leave"];
		$this->purpose_of_leave->AdvancedSearch->Save();

		// Field status
		$this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
		$this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
		$this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
		$this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
		$this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
		$this->status->AdvancedSearch->Save();

		// Field initiator_action
		$this->initiator_action->AdvancedSearch->SearchValue = @$filter["x_initiator_action"];
		$this->initiator_action->AdvancedSearch->SearchOperator = @$filter["z_initiator_action"];
		$this->initiator_action->AdvancedSearch->SearchCondition = @$filter["v_initiator_action"];
		$this->initiator_action->AdvancedSearch->SearchValue2 = @$filter["y_initiator_action"];
		$this->initiator_action->AdvancedSearch->SearchOperator2 = @$filter["w_initiator_action"];
		$this->initiator_action->AdvancedSearch->Save();

		// Field initiator_comments
		$this->initiator_comments->AdvancedSearch->SearchValue = @$filter["x_initiator_comments"];
		$this->initiator_comments->AdvancedSearch->SearchOperator = @$filter["z_initiator_comments"];
		$this->initiator_comments->AdvancedSearch->SearchCondition = @$filter["v_initiator_comments"];
		$this->initiator_comments->AdvancedSearch->SearchValue2 = @$filter["y_initiator_comments"];
		$this->initiator_comments->AdvancedSearch->SearchOperator2 = @$filter["w_initiator_comments"];
		$this->initiator_comments->AdvancedSearch->Save();

		// Field verified_staff
		$this->verified_staff->AdvancedSearch->SearchValue = @$filter["x_verified_staff"];
		$this->verified_staff->AdvancedSearch->SearchOperator = @$filter["z_verified_staff"];
		$this->verified_staff->AdvancedSearch->SearchCondition = @$filter["v_verified_staff"];
		$this->verified_staff->AdvancedSearch->SearchValue2 = @$filter["y_verified_staff"];
		$this->verified_staff->AdvancedSearch->SearchOperator2 = @$filter["w_verified_staff"];
		$this->verified_staff->AdvancedSearch->Save();

		// Field verified_replacement_staff
		$this->verified_replacement_staff->AdvancedSearch->SearchValue = @$filter["x_verified_replacement_staff"];
		$this->verified_replacement_staff->AdvancedSearch->SearchOperator = @$filter["z_verified_replacement_staff"];
		$this->verified_replacement_staff->AdvancedSearch->SearchCondition = @$filter["v_verified_replacement_staff"];
		$this->verified_replacement_staff->AdvancedSearch->SearchValue2 = @$filter["y_verified_replacement_staff"];
		$this->verified_replacement_staff->AdvancedSearch->SearchOperator2 = @$filter["w_verified_replacement_staff"];
		$this->verified_replacement_staff->AdvancedSearch->Save();

		// Field recommender_action
		$this->recommender_action->AdvancedSearch->SearchValue = @$filter["x_recommender_action"];
		$this->recommender_action->AdvancedSearch->SearchOperator = @$filter["z_recommender_action"];
		$this->recommender_action->AdvancedSearch->SearchCondition = @$filter["v_recommender_action"];
		$this->recommender_action->AdvancedSearch->SearchValue2 = @$filter["y_recommender_action"];
		$this->recommender_action->AdvancedSearch->SearchOperator2 = @$filter["w_recommender_action"];
		$this->recommender_action->AdvancedSearch->Save();

		// Field recommender_comments
		$this->recommender_comments->AdvancedSearch->SearchValue = @$filter["x_recommender_comments"];
		$this->recommender_comments->AdvancedSearch->SearchOperator = @$filter["z_recommender_comments"];
		$this->recommender_comments->AdvancedSearch->SearchCondition = @$filter["v_recommender_comments"];
		$this->recommender_comments->AdvancedSearch->SearchValue2 = @$filter["y_recommender_comments"];
		$this->recommender_comments->AdvancedSearch->SearchOperator2 = @$filter["w_recommender_comments"];
		$this->recommender_comments->AdvancedSearch->Save();

		// Field approver_action
		$this->approver_action->AdvancedSearch->SearchValue = @$filter["x_approver_action"];
		$this->approver_action->AdvancedSearch->SearchOperator = @$filter["z_approver_action"];
		$this->approver_action->AdvancedSearch->SearchCondition = @$filter["v_approver_action"];
		$this->approver_action->AdvancedSearch->SearchValue2 = @$filter["y_approver_action"];
		$this->approver_action->AdvancedSearch->SearchOperator2 = @$filter["w_approver_action"];
		$this->approver_action->AdvancedSearch->Save();

		// Field approver_comments
		$this->approver_comments->AdvancedSearch->SearchValue = @$filter["x_approver_comments"];
		$this->approver_comments->AdvancedSearch->SearchOperator = @$filter["z_approver_comments"];
		$this->approver_comments->AdvancedSearch->SearchCondition = @$filter["v_approver_comments"];
		$this->approver_comments->AdvancedSearch->SearchValue2 = @$filter["y_approver_comments"];
		$this->approver_comments->AdvancedSearch->SearchOperator2 = @$filter["w_approver_comments"];
		$this->approver_comments->AdvancedSearch->Save();

		// Field last_updated_date
		$this->last_updated_date->AdvancedSearch->SearchValue = @$filter["x_last_updated_date"];
		$this->last_updated_date->AdvancedSearch->SearchOperator = @$filter["z_last_updated_date"];
		$this->last_updated_date->AdvancedSearch->SearchCondition = @$filter["v_last_updated_date"];
		$this->last_updated_date->AdvancedSearch->SearchValue2 = @$filter["y_last_updated_date"];
		$this->last_updated_date->AdvancedSearch->SearchOperator2 = @$filter["w_last_updated_date"];
		$this->last_updated_date->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->staff_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->company, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->replacement_assign_staff, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->purpose_of_leave, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->initiator_comments, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->approver_comments, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id); // id
			$this->UpdateSort($this->leave_id); // leave_id
			$this->UpdateSort($this->time); // time
			$this->UpdateSort($this->staff_id); // staff_id
			$this->UpdateSort($this->staff_name); // staff_name
			$this->UpdateSort($this->company); // company
			$this->UpdateSort($this->department); // department
			$this->UpdateSort($this->leave_type); // leave_type
			$this->UpdateSort($this->start_date); // start_date
			$this->UpdateSort($this->end_date); // end_date
			$this->UpdateSort($this->no_of_days); // no_of_days
			$this->UpdateSort($this->resumption_date); // resumption_date
			$this->UpdateSort($this->replacement_assign_staff); // replacement_assign_staff
			$this->UpdateSort($this->purpose_of_leave); // purpose_of_leave
			$this->UpdateSort($this->status); // status
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->leave_id->setSort("");
				$this->time->setSort("");
				$this->staff_id->setSort("");
				$this->staff_name->setSort("");
				$this->company->setSort("");
				$this->department->setSort("");
				$this->leave_type->setSort("");
				$this->start_date->setSort("");
				$this->end_date->setSort("");
				$this->no_of_days->setSort("");
				$this->resumption_date->setSort("");
				$this->replacement_assign_staff->setSort("");
				$this->purpose_of_leave->setSort("");
				$this->status->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fleave_formlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fleave_formlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fleave_formlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fleave_formlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_leave_form\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_leave_form',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fleave_formlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

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

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetupStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
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
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
		$_SESSION['Leave_ID'] = get_unique_id();
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($leave_form_list)) $leave_form_list = new cleave_form_list();

// Page init
$leave_form_list->Page_Init();

// Page main
$leave_form_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$leave_form_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($leave_form->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fleave_formlist = new ew_Form("fleave_formlist", "list");
fleave_formlist.FormKeyCountName = '<?php echo $leave_form_list->FormKeyCountName ?>';

// Form_CustomValidate event
fleave_formlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fleave_formlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fleave_formlist.Lists["x_company"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":["x_department","x_replacement_assign_staff"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"company"};
fleave_formlist.Lists["x_company"].Data = "<?php echo $leave_form_list->company->LookupFilterQuery(FALSE, "list") ?>";
fleave_formlist.Lists["x_department"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"department"};
fleave_formlist.Lists["x_department"].Data = "<?php echo $leave_form_list->department->LookupFilterQuery(FALSE, "list") ?>";
fleave_formlist.Lists["x_leave_type"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"leave_type"};
fleave_formlist.Lists["x_leave_type"].Data = "<?php echo $leave_form_list->leave_type->LookupFilterQuery(FALSE, "list") ?>";
fleave_formlist.Lists["x_replacement_assign_staff"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_first_name","x_last_name","x_mobile",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"user_profile"};
fleave_formlist.Lists["x_replacement_assign_staff"].Data = "<?php echo $leave_form_list->replacement_assign_staff->LookupFilterQuery(FALSE, "list") ?>";
fleave_formlist.Lists["x_status"] = {"LinkField":"x_code","Ajax":true,"AutoFill":false,"DisplayFields":["x_description","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"status"};
fleave_formlist.Lists["x_status"].Data = "<?php echo $leave_form_list->status->LookupFilterQuery(FALSE, "list") ?>";
fleave_formlist.AutoSuggests["x_status"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $leave_form_list->status->LookupFilterQuery(TRUE, "list"))) ?>;

// Form object for search
var CurrentSearchForm = fleave_formlistsrch = new ew_Form("fleave_formlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($leave_form->Export == "") { ?>
<div class="ewToolbar">
<?php if ($leave_form_list->TotalRecs > 0 && $leave_form_list->ExportOptions->Visible()) { ?>
<?php $leave_form_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($leave_form_list->SearchOptions->Visible()) { ?>
<?php $leave_form_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($leave_form_list->FilterOptions->Visible()) { ?>
<?php $leave_form_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $leave_form_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($leave_form_list->TotalRecs <= 0)
			$leave_form_list->TotalRecs = $leave_form->ListRecordCount();
	} else {
		if (!$leave_form_list->Recordset && ($leave_form_list->Recordset = $leave_form_list->LoadRecordset()))
			$leave_form_list->TotalRecs = $leave_form_list->Recordset->RecordCount();
	}
	$leave_form_list->StartRec = 1;
	if ($leave_form_list->DisplayRecs <= 0 || ($leave_form->Export <> "" && $leave_form->ExportAll)) // Display all records
		$leave_form_list->DisplayRecs = $leave_form_list->TotalRecs;
	if (!($leave_form->Export <> "" && $leave_form->ExportAll))
		$leave_form_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$leave_form_list->Recordset = $leave_form_list->LoadRecordset($leave_form_list->StartRec-1, $leave_form_list->DisplayRecs);

	// Set no record found message
	if ($leave_form->CurrentAction == "" && $leave_form_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$leave_form_list->setWarningMessage(ew_DeniedMsg());
		if ($leave_form_list->SearchWhere == "0=101")
			$leave_form_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$leave_form_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$leave_form_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($leave_form->Export == "" && $leave_form->CurrentAction == "") { ?>
<form name="fleave_formlistsrch" id="fleave_formlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($leave_form_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fleave_formlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="leave_form">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($leave_form_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($leave_form_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $leave_form_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($leave_form_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($leave_form_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($leave_form_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($leave_form_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $leave_form_list->ShowPageHeader(); ?>
<?php
$leave_form_list->ShowMessage();
?>
<?php if ($leave_form_list->TotalRecs > 0 || $leave_form->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($leave_form_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> leave_form">
<?php if ($leave_form->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($leave_form->CurrentAction <> "gridadd" && $leave_form->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($leave_form_list->Pager)) $leave_form_list->Pager = new cPrevNextPager($leave_form_list->StartRec, $leave_form_list->DisplayRecs, $leave_form_list->TotalRecs, $leave_form_list->AutoHidePager) ?>
<?php if ($leave_form_list->Pager->RecordCount > 0 && $leave_form_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($leave_form_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $leave_form_list->PageUrl() ?>start=<?php echo $leave_form_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($leave_form_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $leave_form_list->PageUrl() ?>start=<?php echo $leave_form_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $leave_form_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($leave_form_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $leave_form_list->PageUrl() ?>start=<?php echo $leave_form_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($leave_form_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $leave_form_list->PageUrl() ?>start=<?php echo $leave_form_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $leave_form_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($leave_form_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $leave_form_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $leave_form_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $leave_form_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($leave_form_list->TotalRecs > 0 && (!$leave_form_list->AutoHidePageSizeSelector || $leave_form_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="leave_form">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($leave_form_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($leave_form_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($leave_form_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($leave_form_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($leave_form->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($leave_form_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fleave_formlist" id="fleave_formlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($leave_form_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $leave_form_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="leave_form">
<div id="gmp_leave_form" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($leave_form_list->TotalRecs > 0 || $leave_form->CurrentAction == "gridedit") { ?>
<table id="tbl_leave_formlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$leave_form_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$leave_form_list->RenderListOptions();

// Render list options (header, left)
$leave_form_list->ListOptions->Render("header", "left");
?>
<?php if ($leave_form->id->Visible) { // id ?>
	<?php if ($leave_form->SortUrl($leave_form->id) == "") { ?>
		<th data-name="id" class="<?php echo $leave_form->id->HeaderCellClass() ?>"><div id="elh_leave_form_id" class="leave_form_id"><div class="ewTableHeaderCaption"><?php echo $leave_form->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $leave_form->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->id) ?>',1);"><div id="elh_leave_form_id" class="leave_form_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->leave_id->Visible) { // leave_id ?>
	<?php if ($leave_form->SortUrl($leave_form->leave_id) == "") { ?>
		<th data-name="leave_id" class="<?php echo $leave_form->leave_id->HeaderCellClass() ?>"><div id="elh_leave_form_leave_id" class="leave_form_leave_id"><div class="ewTableHeaderCaption"><?php echo $leave_form->leave_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="leave_id" class="<?php echo $leave_form->leave_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->leave_id) ?>',1);"><div id="elh_leave_form_leave_id" class="leave_form_leave_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->leave_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->leave_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->leave_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->time->Visible) { // time ?>
	<?php if ($leave_form->SortUrl($leave_form->time) == "") { ?>
		<th data-name="time" class="<?php echo $leave_form->time->HeaderCellClass() ?>"><div id="elh_leave_form_time" class="leave_form_time"><div class="ewTableHeaderCaption"><?php echo $leave_form->time->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="time" class="<?php echo $leave_form->time->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->time) ?>',1);"><div id="elh_leave_form_time" class="leave_form_time">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->time->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->time->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->time->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->staff_id->Visible) { // staff_id ?>
	<?php if ($leave_form->SortUrl($leave_form->staff_id) == "") { ?>
		<th data-name="staff_id" class="<?php echo $leave_form->staff_id->HeaderCellClass() ?>"><div id="elh_leave_form_staff_id" class="leave_form_staff_id"><div class="ewTableHeaderCaption"><?php echo $leave_form->staff_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="staff_id" class="<?php echo $leave_form->staff_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->staff_id) ?>',1);"><div id="elh_leave_form_staff_id" class="leave_form_staff_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->staff_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->staff_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->staff_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->staff_name->Visible) { // staff_name ?>
	<?php if ($leave_form->SortUrl($leave_form->staff_name) == "") { ?>
		<th data-name="staff_name" class="<?php echo $leave_form->staff_name->HeaderCellClass() ?>"><div id="elh_leave_form_staff_name" class="leave_form_staff_name"><div class="ewTableHeaderCaption"><?php echo $leave_form->staff_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="staff_name" class="<?php echo $leave_form->staff_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->staff_name) ?>',1);"><div id="elh_leave_form_staff_name" class="leave_form_staff_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->staff_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->staff_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->staff_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->company->Visible) { // company ?>
	<?php if ($leave_form->SortUrl($leave_form->company) == "") { ?>
		<th data-name="company" class="<?php echo $leave_form->company->HeaderCellClass() ?>"><div id="elh_leave_form_company" class="leave_form_company"><div class="ewTableHeaderCaption"><?php echo $leave_form->company->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="company" class="<?php echo $leave_form->company->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->company) ?>',1);"><div id="elh_leave_form_company" class="leave_form_company">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->company->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->company->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->company->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->department->Visible) { // department ?>
	<?php if ($leave_form->SortUrl($leave_form->department) == "") { ?>
		<th data-name="department" class="<?php echo $leave_form->department->HeaderCellClass() ?>"><div id="elh_leave_form_department" class="leave_form_department"><div class="ewTableHeaderCaption"><?php echo $leave_form->department->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="department" class="<?php echo $leave_form->department->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->department) ?>',1);"><div id="elh_leave_form_department" class="leave_form_department">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->department->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->department->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->department->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->leave_type->Visible) { // leave_type ?>
	<?php if ($leave_form->SortUrl($leave_form->leave_type) == "") { ?>
		<th data-name="leave_type" class="<?php echo $leave_form->leave_type->HeaderCellClass() ?>"><div id="elh_leave_form_leave_type" class="leave_form_leave_type"><div class="ewTableHeaderCaption"><?php echo $leave_form->leave_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="leave_type" class="<?php echo $leave_form->leave_type->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->leave_type) ?>',1);"><div id="elh_leave_form_leave_type" class="leave_form_leave_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->leave_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->leave_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->leave_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->start_date->Visible) { // start_date ?>
	<?php if ($leave_form->SortUrl($leave_form->start_date) == "") { ?>
		<th data-name="start_date" class="<?php echo $leave_form->start_date->HeaderCellClass() ?>"><div id="elh_leave_form_start_date" class="leave_form_start_date"><div class="ewTableHeaderCaption"><?php echo $leave_form->start_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="start_date" class="<?php echo $leave_form->start_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->start_date) ?>',1);"><div id="elh_leave_form_start_date" class="leave_form_start_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->start_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->start_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->start_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->end_date->Visible) { // end_date ?>
	<?php if ($leave_form->SortUrl($leave_form->end_date) == "") { ?>
		<th data-name="end_date" class="<?php echo $leave_form->end_date->HeaderCellClass() ?>"><div id="elh_leave_form_end_date" class="leave_form_end_date"><div class="ewTableHeaderCaption"><?php echo $leave_form->end_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="end_date" class="<?php echo $leave_form->end_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->end_date) ?>',1);"><div id="elh_leave_form_end_date" class="leave_form_end_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->end_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->end_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->end_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->no_of_days->Visible) { // no_of_days ?>
	<?php if ($leave_form->SortUrl($leave_form->no_of_days) == "") { ?>
		<th data-name="no_of_days" class="<?php echo $leave_form->no_of_days->HeaderCellClass() ?>"><div id="elh_leave_form_no_of_days" class="leave_form_no_of_days"><div class="ewTableHeaderCaption"><?php echo $leave_form->no_of_days->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_of_days" class="<?php echo $leave_form->no_of_days->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->no_of_days) ?>',1);"><div id="elh_leave_form_no_of_days" class="leave_form_no_of_days">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->no_of_days->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->no_of_days->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->no_of_days->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->resumption_date->Visible) { // resumption_date ?>
	<?php if ($leave_form->SortUrl($leave_form->resumption_date) == "") { ?>
		<th data-name="resumption_date" class="<?php echo $leave_form->resumption_date->HeaderCellClass() ?>"><div id="elh_leave_form_resumption_date" class="leave_form_resumption_date"><div class="ewTableHeaderCaption"><?php echo $leave_form->resumption_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="resumption_date" class="<?php echo $leave_form->resumption_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->resumption_date) ?>',1);"><div id="elh_leave_form_resumption_date" class="leave_form_resumption_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->resumption_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->resumption_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->resumption_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->replacement_assign_staff->Visible) { // replacement_assign_staff ?>
	<?php if ($leave_form->SortUrl($leave_form->replacement_assign_staff) == "") { ?>
		<th data-name="replacement_assign_staff" class="<?php echo $leave_form->replacement_assign_staff->HeaderCellClass() ?>"><div id="elh_leave_form_replacement_assign_staff" class="leave_form_replacement_assign_staff"><div class="ewTableHeaderCaption"><?php echo $leave_form->replacement_assign_staff->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="replacement_assign_staff" class="<?php echo $leave_form->replacement_assign_staff->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->replacement_assign_staff) ?>',1);"><div id="elh_leave_form_replacement_assign_staff" class="leave_form_replacement_assign_staff">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->replacement_assign_staff->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->replacement_assign_staff->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->replacement_assign_staff->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->purpose_of_leave->Visible) { // purpose_of_leave ?>
	<?php if ($leave_form->SortUrl($leave_form->purpose_of_leave) == "") { ?>
		<th data-name="purpose_of_leave" class="<?php echo $leave_form->purpose_of_leave->HeaderCellClass() ?>"><div id="elh_leave_form_purpose_of_leave" class="leave_form_purpose_of_leave"><div class="ewTableHeaderCaption"><?php echo $leave_form->purpose_of_leave->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="purpose_of_leave" class="<?php echo $leave_form->purpose_of_leave->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->purpose_of_leave) ?>',1);"><div id="elh_leave_form_purpose_of_leave" class="leave_form_purpose_of_leave">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->purpose_of_leave->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->purpose_of_leave->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->purpose_of_leave->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($leave_form->status->Visible) { // status ?>
	<?php if ($leave_form->SortUrl($leave_form->status) == "") { ?>
		<th data-name="status" class="<?php echo $leave_form->status->HeaderCellClass() ?>"><div id="elh_leave_form_status" class="leave_form_status"><div class="ewTableHeaderCaption"><?php echo $leave_form->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $leave_form->status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $leave_form->SortUrl($leave_form->status) ?>',1);"><div id="elh_leave_form_status" class="leave_form_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $leave_form->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($leave_form->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($leave_form->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$leave_form_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($leave_form->ExportAll && $leave_form->Export <> "") {
	$leave_form_list->StopRec = $leave_form_list->TotalRecs;
} else {

	// Set the last record to display
	if ($leave_form_list->TotalRecs > $leave_form_list->StartRec + $leave_form_list->DisplayRecs - 1)
		$leave_form_list->StopRec = $leave_form_list->StartRec + $leave_form_list->DisplayRecs - 1;
	else
		$leave_form_list->StopRec = $leave_form_list->TotalRecs;
}
$leave_form_list->RecCnt = $leave_form_list->StartRec - 1;
if ($leave_form_list->Recordset && !$leave_form_list->Recordset->EOF) {
	$leave_form_list->Recordset->MoveFirst();
	$bSelectLimit = $leave_form_list->UseSelectLimit;
	if (!$bSelectLimit && $leave_form_list->StartRec > 1)
		$leave_form_list->Recordset->Move($leave_form_list->StartRec - 1);
} elseif (!$leave_form->AllowAddDeleteRow && $leave_form_list->StopRec == 0) {
	$leave_form_list->StopRec = $leave_form->GridAddRowCount;
}

// Initialize aggregate
$leave_form->RowType = EW_ROWTYPE_AGGREGATEINIT;
$leave_form->ResetAttrs();
$leave_form_list->RenderRow();
while ($leave_form_list->RecCnt < $leave_form_list->StopRec) {
	$leave_form_list->RecCnt++;
	if (intval($leave_form_list->RecCnt) >= intval($leave_form_list->StartRec)) {
		$leave_form_list->RowCnt++;

		// Set up key count
		$leave_form_list->KeyCount = $leave_form_list->RowIndex;

		// Init row class and style
		$leave_form->ResetAttrs();
		$leave_form->CssClass = "";
		if ($leave_form->CurrentAction == "gridadd") {
		} else {
			$leave_form_list->LoadRowValues($leave_form_list->Recordset); // Load row values
		}
		$leave_form->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$leave_form->RowAttrs = array_merge($leave_form->RowAttrs, array('data-rowindex'=>$leave_form_list->RowCnt, 'id'=>'r' . $leave_form_list->RowCnt . '_leave_form', 'data-rowtype'=>$leave_form->RowType));

		// Render row
		$leave_form_list->RenderRow();

		// Render list options
		$leave_form_list->RenderListOptions();
?>
	<tr<?php echo $leave_form->RowAttributes() ?>>
<?php

// Render list options (body, left)
$leave_form_list->ListOptions->Render("body", "left", $leave_form_list->RowCnt);
?>
	<?php if ($leave_form->id->Visible) { // id ?>
		<td data-name="id"<?php echo $leave_form->id->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_id" class="leave_form_id">
<span<?php echo $leave_form->id->ViewAttributes() ?>>
<?php echo $leave_form->id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->leave_id->Visible) { // leave_id ?>
		<td data-name="leave_id"<?php echo $leave_form->leave_id->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_leave_id" class="leave_form_leave_id">
<span<?php echo $leave_form->leave_id->ViewAttributes() ?>>
<?php echo $leave_form->leave_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->time->Visible) { // time ?>
		<td data-name="time"<?php echo $leave_form->time->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_time" class="leave_form_time">
<span<?php echo $leave_form->time->ViewAttributes() ?>>
<?php echo $leave_form->time->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->staff_id->Visible) { // staff_id ?>
		<td data-name="staff_id"<?php echo $leave_form->staff_id->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_staff_id" class="leave_form_staff_id">
<span<?php echo $leave_form->staff_id->ViewAttributes() ?>>
<?php echo $leave_form->staff_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->staff_name->Visible) { // staff_name ?>
		<td data-name="staff_name"<?php echo $leave_form->staff_name->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_staff_name" class="leave_form_staff_name">
<span<?php echo $leave_form->staff_name->ViewAttributes() ?>>
<?php echo $leave_form->staff_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->company->Visible) { // company ?>
		<td data-name="company"<?php echo $leave_form->company->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_company" class="leave_form_company">
<span<?php echo $leave_form->company->ViewAttributes() ?>>
<?php echo $leave_form->company->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->department->Visible) { // department ?>
		<td data-name="department"<?php echo $leave_form->department->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_department" class="leave_form_department">
<span<?php echo $leave_form->department->ViewAttributes() ?>>
<?php echo $leave_form->department->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->leave_type->Visible) { // leave_type ?>
		<td data-name="leave_type"<?php echo $leave_form->leave_type->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_leave_type" class="leave_form_leave_type">
<span<?php echo $leave_form->leave_type->ViewAttributes() ?>>
<?php echo $leave_form->leave_type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->start_date->Visible) { // start_date ?>
		<td data-name="start_date"<?php echo $leave_form->start_date->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_start_date" class="leave_form_start_date">
<span<?php echo $leave_form->start_date->ViewAttributes() ?>>
<?php echo $leave_form->start_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->end_date->Visible) { // end_date ?>
		<td data-name="end_date"<?php echo $leave_form->end_date->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_end_date" class="leave_form_end_date">
<span<?php echo $leave_form->end_date->ViewAttributes() ?>>
<?php echo $leave_form->end_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->no_of_days->Visible) { // no_of_days ?>
		<td data-name="no_of_days"<?php echo $leave_form->no_of_days->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_no_of_days" class="leave_form_no_of_days">
<span<?php echo $leave_form->no_of_days->ViewAttributes() ?>>
<?php echo $leave_form->no_of_days->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->resumption_date->Visible) { // resumption_date ?>
		<td data-name="resumption_date"<?php echo $leave_form->resumption_date->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_resumption_date" class="leave_form_resumption_date">
<span<?php echo $leave_form->resumption_date->ViewAttributes() ?>>
<?php echo $leave_form->resumption_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->replacement_assign_staff->Visible) { // replacement_assign_staff ?>
		<td data-name="replacement_assign_staff"<?php echo $leave_form->replacement_assign_staff->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_replacement_assign_staff" class="leave_form_replacement_assign_staff">
<span<?php echo $leave_form->replacement_assign_staff->ViewAttributes() ?>>
<?php echo $leave_form->replacement_assign_staff->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->purpose_of_leave->Visible) { // purpose_of_leave ?>
		<td data-name="purpose_of_leave"<?php echo $leave_form->purpose_of_leave->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_purpose_of_leave" class="leave_form_purpose_of_leave">
<span<?php echo $leave_form->purpose_of_leave->ViewAttributes() ?>>
<?php echo $leave_form->purpose_of_leave->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($leave_form->status->Visible) { // status ?>
		<td data-name="status"<?php echo $leave_form->status->CellAttributes() ?>>
<span id="el<?php echo $leave_form_list->RowCnt ?>_leave_form_status" class="leave_form_status">
<span<?php echo $leave_form->status->ViewAttributes() ?>>
<?php echo $leave_form->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$leave_form_list->ListOptions->Render("body", "right", $leave_form_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($leave_form->CurrentAction <> "gridadd")
		$leave_form_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($leave_form->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($leave_form_list->Recordset)
	$leave_form_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($leave_form_list->TotalRecs == 0 && $leave_form->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($leave_form_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($leave_form->Export == "") { ?>
<script type="text/javascript">
fleave_formlistsrch.FilterList = <?php echo $leave_form_list->GetFilterList() ?>;
fleave_formlistsrch.Init();
fleave_formlist.Init();
</script>
<?php } ?>
<?php
$leave_form_list->ShowPageFooter();
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
$leave_form_list->Page_Terminate();
?>
