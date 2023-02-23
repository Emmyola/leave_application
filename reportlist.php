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

$report_list = NULL; // Initialize page object first

class creport_list extends creport {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}';

	// Table name
	var $TableName = 'report';

	// Page object name
	var $PageObjName = 'report_list';

	// Grid form hidden field names
	var $FormName = 'freportlist';
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

		// Table object (report)
		if (!isset($GLOBALS["report"]) || get_class($GLOBALS["report"]) == "creport") {
			$GLOBALS["report"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["report"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "reportadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "reportdelete.php";
		$this->MultiUpdateUrl = "reportupdate.php";

		// Table object (user_profile)
		if (!isset($GLOBALS['user_profile'])) $GLOBALS['user_profile'] = new cuser_profile();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption freportlistsrch";

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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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
		if ($sFilter == "") {
			$sFilter = "0=101";
			$this->SearchWhere = $sFilter;
		}

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
		if (count($arrKeyFlds) >= 0) {
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "freportlistsrch");
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "freportlistsrch", $filters);

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
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->leave_id, $Default, FALSE); // leave_id
		$this->BuildSearchSql($sWhere, $this->date_created, $Default, FALSE); // date_created
		$this->BuildSearchSql($sWhere, $this->time, $Default, FALSE); // time
		$this->BuildSearchSql($sWhere, $this->staff_id, $Default, FALSE); // staff_id
		$this->BuildSearchSql($sWhere, $this->staff_name, $Default, FALSE); // staff_name
		$this->BuildSearchSql($sWhere, $this->company, $Default, FALSE); // company
		$this->BuildSearchSql($sWhere, $this->department, $Default, FALSE); // department
		$this->BuildSearchSql($sWhere, $this->leave_type, $Default, FALSE); // leave_type
		$this->BuildSearchSql($sWhere, $this->start_date, $Default, FALSE); // start_date
		$this->BuildSearchSql($sWhere, $this->end_date, $Default, FALSE); // end_date
		$this->BuildSearchSql($sWhere, $this->no_of_days, $Default, FALSE); // no_of_days
		$this->BuildSearchSql($sWhere, $this->resumption_date, $Default, FALSE); // resumption_date
		$this->BuildSearchSql($sWhere, $this->replacement_assign_staff, $Default, FALSE); // replacement_assign_staff
		$this->BuildSearchSql($sWhere, $this->purpose_of_leave, $Default, FALSE); // purpose_of_leave
		$this->BuildSearchSql($sWhere, $this->status, $Default, FALSE); // status

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->leave_id->AdvancedSearch->Save(); // leave_id
			$this->date_created->AdvancedSearch->Save(); // date_created
			$this->time->AdvancedSearch->Save(); // time
			$this->staff_id->AdvancedSearch->Save(); // staff_id
			$this->staff_name->AdvancedSearch->Save(); // staff_name
			$this->company->AdvancedSearch->Save(); // company
			$this->department->AdvancedSearch->Save(); // department
			$this->leave_type->AdvancedSearch->Save(); // leave_type
			$this->start_date->AdvancedSearch->Save(); // start_date
			$this->end_date->AdvancedSearch->Save(); // end_date
			$this->no_of_days->AdvancedSearch->Save(); // no_of_days
			$this->resumption_date->AdvancedSearch->Save(); // resumption_date
			$this->replacement_assign_staff->AdvancedSearch->Save(); // replacement_assign_staff
			$this->purpose_of_leave->AdvancedSearch->Save(); // purpose_of_leave
			$this->status->AdvancedSearch->Save(); // status
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = $Fld->FldParm();
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->leave_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->staff_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->staff_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->company, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->replacement_assign_staff, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->purpose_of_leave, $arKeywords, $type);
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
		if ($this->leave_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->date_created->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->time->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->staff_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->staff_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->company->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->department->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->leave_type->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->start_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->end_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->no_of_days->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->resumption_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->replacement_assign_staff->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->purpose_of_leave->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->status->AdvancedSearch->IssetSession())
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

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->leave_id->AdvancedSearch->UnsetSession();
		$this->date_created->AdvancedSearch->UnsetSession();
		$this->time->AdvancedSearch->UnsetSession();
		$this->staff_id->AdvancedSearch->UnsetSession();
		$this->staff_name->AdvancedSearch->UnsetSession();
		$this->company->AdvancedSearch->UnsetSession();
		$this->department->AdvancedSearch->UnsetSession();
		$this->leave_type->AdvancedSearch->UnsetSession();
		$this->start_date->AdvancedSearch->UnsetSession();
		$this->end_date->AdvancedSearch->UnsetSession();
		$this->no_of_days->AdvancedSearch->UnsetSession();
		$this->resumption_date->AdvancedSearch->UnsetSession();
		$this->replacement_assign_staff->AdvancedSearch->UnsetSession();
		$this->purpose_of_leave->AdvancedSearch->UnsetSession();
		$this->status->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
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

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->leave_id); // leave_id
			$this->UpdateSort($this->date_created); // date_created
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
				$this->leave_id->setSort("");
				$this->date_created->setSort("");
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
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"freportlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"freportlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.freportlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"freportlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ResetSearch") . "\" data-caption=\"" . $Language->Phrase("ResetSearch") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ResetSearchBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"reportsrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// leave_id

		$this->leave_id->AdvancedSearch->SearchValue = @$_GET["x_leave_id"];
		if ($this->leave_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->leave_id->AdvancedSearch->SearchOperator = @$_GET["z_leave_id"];

		// date_created
		$this->date_created->AdvancedSearch->SearchValue = @$_GET["x_date_created"];
		if ($this->date_created->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->date_created->AdvancedSearch->SearchOperator = @$_GET["z_date_created"];

		// time
		$this->time->AdvancedSearch->SearchValue = @$_GET["x_time"];
		if ($this->time->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->time->AdvancedSearch->SearchOperator = @$_GET["z_time"];

		// staff_id
		$this->staff_id->AdvancedSearch->SearchValue = @$_GET["x_staff_id"];
		if ($this->staff_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->staff_id->AdvancedSearch->SearchOperator = @$_GET["z_staff_id"];

		// staff_name
		$this->staff_name->AdvancedSearch->SearchValue = @$_GET["x_staff_name"];
		if ($this->staff_name->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->staff_name->AdvancedSearch->SearchOperator = @$_GET["z_staff_name"];

		// company
		$this->company->AdvancedSearch->SearchValue = @$_GET["x_company"];
		if ($this->company->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->company->AdvancedSearch->SearchOperator = @$_GET["z_company"];

		// department
		$this->department->AdvancedSearch->SearchValue = @$_GET["x_department"];
		if ($this->department->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->department->AdvancedSearch->SearchOperator = @$_GET["z_department"];

		// leave_type
		$this->leave_type->AdvancedSearch->SearchValue = @$_GET["x_leave_type"];
		if ($this->leave_type->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->leave_type->AdvancedSearch->SearchOperator = @$_GET["z_leave_type"];

		// start_date
		$this->start_date->AdvancedSearch->SearchValue = @$_GET["x_start_date"];
		if ($this->start_date->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->start_date->AdvancedSearch->SearchOperator = @$_GET["z_start_date"];

		// end_date
		$this->end_date->AdvancedSearch->SearchValue = @$_GET["x_end_date"];
		if ($this->end_date->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->end_date->AdvancedSearch->SearchOperator = @$_GET["z_end_date"];

		// no_of_days
		$this->no_of_days->AdvancedSearch->SearchValue = @$_GET["x_no_of_days"];
		if ($this->no_of_days->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->no_of_days->AdvancedSearch->SearchOperator = @$_GET["z_no_of_days"];

		// resumption_date
		$this->resumption_date->AdvancedSearch->SearchValue = @$_GET["x_resumption_date"];
		if ($this->resumption_date->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->resumption_date->AdvancedSearch->SearchOperator = @$_GET["z_resumption_date"];

		// replacement_assign_staff
		$this->replacement_assign_staff->AdvancedSearch->SearchValue = @$_GET["x_replacement_assign_staff"];
		if ($this->replacement_assign_staff->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->replacement_assign_staff->AdvancedSearch->SearchOperator = @$_GET["z_replacement_assign_staff"];

		// purpose_of_leave
		$this->purpose_of_leave->AdvancedSearch->SearchValue = @$_GET["x_purpose_of_leave"];
		if ($this->purpose_of_leave->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->purpose_of_leave->AdvancedSearch->SearchOperator = @$_GET["z_purpose_of_leave"];

		// status
		$this->status->AdvancedSearch->SearchValue = @$_GET["x_status"];
		if ($this->status->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->status->AdvancedSearch->SearchOperator = @$_GET["z_status"];
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
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
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
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
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
	}

	// Load old record
	function LoadOldRecord() {
		return FALSE;
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
		}

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
		$item->Body = "<button id=\"emf_report\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_report',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.freportlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($report_list)) $report_list = new creport_list();

// Page init
$report_list->Page_Init();

// Page main
$report_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$report_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($report->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = freportlist = new ew_Form("freportlist", "list");
freportlist.FormKeyCountName = '<?php echo $report_list->FormKeyCountName ?>';

// Form_CustomValidate event
freportlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
freportlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = freportlistsrch = new ew_Form("freportlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($report->Export == "") { ?>
<div class="ewToolbar">
<?php if ($report_list->TotalRecs > 0 && $report_list->ExportOptions->Visible()) { ?>
<?php $report_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($report_list->SearchOptions->Visible()) { ?>
<?php $report_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($report_list->FilterOptions->Visible()) { ?>
<?php $report_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $report_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($report_list->TotalRecs <= 0)
			$report_list->TotalRecs = $report->ListRecordCount();
	} else {
		if (!$report_list->Recordset && ($report_list->Recordset = $report_list->LoadRecordset()))
			$report_list->TotalRecs = $report_list->Recordset->RecordCount();
	}
	$report_list->StartRec = 1;
	if ($report_list->DisplayRecs <= 0 || ($report->Export <> "" && $report->ExportAll)) // Display all records
		$report_list->DisplayRecs = $report_list->TotalRecs;
	if (!($report->Export <> "" && $report->ExportAll))
		$report_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$report_list->Recordset = $report_list->LoadRecordset($report_list->StartRec-1, $report_list->DisplayRecs);

	// Set no record found message
	if ($report->CurrentAction == "" && $report_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$report_list->setWarningMessage(ew_DeniedMsg());
		if ($report_list->SearchWhere == "0=101")
			$report_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$report_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$report_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($report->Export == "" && $report->CurrentAction == "") { ?>
<form name="freportlistsrch" id="freportlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($report_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="freportlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="report">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($report_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($report_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $report_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($report_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($report_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($report_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($report_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $report_list->ShowPageHeader(); ?>
<?php
$report_list->ShowMessage();
?>
<?php if ($report_list->TotalRecs > 0 || $report->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($report_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> report">
<?php if ($report->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($report->CurrentAction <> "gridadd" && $report->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($report_list->Pager)) $report_list->Pager = new cPrevNextPager($report_list->StartRec, $report_list->DisplayRecs, $report_list->TotalRecs, $report_list->AutoHidePager) ?>
<?php if ($report_list->Pager->RecordCount > 0 && $report_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($report_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $report_list->PageUrl() ?>start=<?php echo $report_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($report_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $report_list->PageUrl() ?>start=<?php echo $report_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $report_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($report_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $report_list->PageUrl() ?>start=<?php echo $report_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($report_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $report_list->PageUrl() ?>start=<?php echo $report_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $report_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($report_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $report_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $report_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $report_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($report_list->TotalRecs > 0 && (!$report_list->AutoHidePageSizeSelector || $report_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="report">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($report_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($report_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($report_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($report_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($report->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($report_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="freportlist" id="freportlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($report_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $report_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="report">
<div id="gmp_report" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($report_list->TotalRecs > 0 || $report->CurrentAction == "gridedit") { ?>
<table id="tbl_reportlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$report_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$report_list->RenderListOptions();

// Render list options (header, left)
$report_list->ListOptions->Render("header", "left");
?>
<?php if ($report->leave_id->Visible) { // leave_id ?>
	<?php if ($report->SortUrl($report->leave_id) == "") { ?>
		<th data-name="leave_id" class="<?php echo $report->leave_id->HeaderCellClass() ?>"><div id="elh_report_leave_id" class="report_leave_id"><div class="ewTableHeaderCaption"><?php echo $report->leave_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="leave_id" class="<?php echo $report->leave_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->leave_id) ?>',1);"><div id="elh_report_leave_id" class="report_leave_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->leave_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($report->leave_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->leave_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->date_created->Visible) { // date_created ?>
	<?php if ($report->SortUrl($report->date_created) == "") { ?>
		<th data-name="date_created" class="<?php echo $report->date_created->HeaderCellClass() ?>"><div id="elh_report_date_created" class="report_date_created"><div class="ewTableHeaderCaption"><?php echo $report->date_created->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date_created" class="<?php echo $report->date_created->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->date_created) ?>',1);"><div id="elh_report_date_created" class="report_date_created">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->date_created->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($report->date_created->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->date_created->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->time->Visible) { // time ?>
	<?php if ($report->SortUrl($report->time) == "") { ?>
		<th data-name="time" class="<?php echo $report->time->HeaderCellClass() ?>"><div id="elh_report_time" class="report_time"><div class="ewTableHeaderCaption"><?php echo $report->time->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="time" class="<?php echo $report->time->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->time) ?>',1);"><div id="elh_report_time" class="report_time">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->time->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($report->time->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->time->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->staff_id->Visible) { // staff_id ?>
	<?php if ($report->SortUrl($report->staff_id) == "") { ?>
		<th data-name="staff_id" class="<?php echo $report->staff_id->HeaderCellClass() ?>"><div id="elh_report_staff_id" class="report_staff_id"><div class="ewTableHeaderCaption"><?php echo $report->staff_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="staff_id" class="<?php echo $report->staff_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->staff_id) ?>',1);"><div id="elh_report_staff_id" class="report_staff_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->staff_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($report->staff_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->staff_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->staff_name->Visible) { // staff_name ?>
	<?php if ($report->SortUrl($report->staff_name) == "") { ?>
		<th data-name="staff_name" class="<?php echo $report->staff_name->HeaderCellClass() ?>"><div id="elh_report_staff_name" class="report_staff_name"><div class="ewTableHeaderCaption"><?php echo $report->staff_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="staff_name" class="<?php echo $report->staff_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->staff_name) ?>',1);"><div id="elh_report_staff_name" class="report_staff_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->staff_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($report->staff_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->staff_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->company->Visible) { // company ?>
	<?php if ($report->SortUrl($report->company) == "") { ?>
		<th data-name="company" class="<?php echo $report->company->HeaderCellClass() ?>"><div id="elh_report_company" class="report_company"><div class="ewTableHeaderCaption"><?php echo $report->company->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="company" class="<?php echo $report->company->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->company) ?>',1);"><div id="elh_report_company" class="report_company">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->company->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($report->company->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->company->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->department->Visible) { // department ?>
	<?php if ($report->SortUrl($report->department) == "") { ?>
		<th data-name="department" class="<?php echo $report->department->HeaderCellClass() ?>"><div id="elh_report_department" class="report_department"><div class="ewTableHeaderCaption"><?php echo $report->department->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="department" class="<?php echo $report->department->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->department) ?>',1);"><div id="elh_report_department" class="report_department">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->department->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($report->department->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->department->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->leave_type->Visible) { // leave_type ?>
	<?php if ($report->SortUrl($report->leave_type) == "") { ?>
		<th data-name="leave_type" class="<?php echo $report->leave_type->HeaderCellClass() ?>"><div id="elh_report_leave_type" class="report_leave_type"><div class="ewTableHeaderCaption"><?php echo $report->leave_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="leave_type" class="<?php echo $report->leave_type->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->leave_type) ?>',1);"><div id="elh_report_leave_type" class="report_leave_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->leave_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($report->leave_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->leave_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->start_date->Visible) { // start_date ?>
	<?php if ($report->SortUrl($report->start_date) == "") { ?>
		<th data-name="start_date" class="<?php echo $report->start_date->HeaderCellClass() ?>"><div id="elh_report_start_date" class="report_start_date"><div class="ewTableHeaderCaption"><?php echo $report->start_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="start_date" class="<?php echo $report->start_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->start_date) ?>',1);"><div id="elh_report_start_date" class="report_start_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->start_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($report->start_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->start_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->end_date->Visible) { // end_date ?>
	<?php if ($report->SortUrl($report->end_date) == "") { ?>
		<th data-name="end_date" class="<?php echo $report->end_date->HeaderCellClass() ?>"><div id="elh_report_end_date" class="report_end_date"><div class="ewTableHeaderCaption"><?php echo $report->end_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="end_date" class="<?php echo $report->end_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->end_date) ?>',1);"><div id="elh_report_end_date" class="report_end_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->end_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($report->end_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->end_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->no_of_days->Visible) { // no_of_days ?>
	<?php if ($report->SortUrl($report->no_of_days) == "") { ?>
		<th data-name="no_of_days" class="<?php echo $report->no_of_days->HeaderCellClass() ?>"><div id="elh_report_no_of_days" class="report_no_of_days"><div class="ewTableHeaderCaption"><?php echo $report->no_of_days->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_of_days" class="<?php echo $report->no_of_days->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->no_of_days) ?>',1);"><div id="elh_report_no_of_days" class="report_no_of_days">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->no_of_days->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($report->no_of_days->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->no_of_days->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->resumption_date->Visible) { // resumption_date ?>
	<?php if ($report->SortUrl($report->resumption_date) == "") { ?>
		<th data-name="resumption_date" class="<?php echo $report->resumption_date->HeaderCellClass() ?>"><div id="elh_report_resumption_date" class="report_resumption_date"><div class="ewTableHeaderCaption"><?php echo $report->resumption_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="resumption_date" class="<?php echo $report->resumption_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->resumption_date) ?>',1);"><div id="elh_report_resumption_date" class="report_resumption_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->resumption_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($report->resumption_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->resumption_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->replacement_assign_staff->Visible) { // replacement_assign_staff ?>
	<?php if ($report->SortUrl($report->replacement_assign_staff) == "") { ?>
		<th data-name="replacement_assign_staff" class="<?php echo $report->replacement_assign_staff->HeaderCellClass() ?>"><div id="elh_report_replacement_assign_staff" class="report_replacement_assign_staff"><div class="ewTableHeaderCaption"><?php echo $report->replacement_assign_staff->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="replacement_assign_staff" class="<?php echo $report->replacement_assign_staff->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->replacement_assign_staff) ?>',1);"><div id="elh_report_replacement_assign_staff" class="report_replacement_assign_staff">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->replacement_assign_staff->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($report->replacement_assign_staff->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->replacement_assign_staff->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->purpose_of_leave->Visible) { // purpose_of_leave ?>
	<?php if ($report->SortUrl($report->purpose_of_leave) == "") { ?>
		<th data-name="purpose_of_leave" class="<?php echo $report->purpose_of_leave->HeaderCellClass() ?>"><div id="elh_report_purpose_of_leave" class="report_purpose_of_leave"><div class="ewTableHeaderCaption"><?php echo $report->purpose_of_leave->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="purpose_of_leave" class="<?php echo $report->purpose_of_leave->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->purpose_of_leave) ?>',1);"><div id="elh_report_purpose_of_leave" class="report_purpose_of_leave">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->purpose_of_leave->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($report->purpose_of_leave->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->purpose_of_leave->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($report->status->Visible) { // status ?>
	<?php if ($report->SortUrl($report->status) == "") { ?>
		<th data-name="status" class="<?php echo $report->status->HeaderCellClass() ?>"><div id="elh_report_status" class="report_status"><div class="ewTableHeaderCaption"><?php echo $report->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $report->status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $report->SortUrl($report->status) ?>',1);"><div id="elh_report_status" class="report_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $report->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($report->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($report->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$report_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($report->ExportAll && $report->Export <> "") {
	$report_list->StopRec = $report_list->TotalRecs;
} else {

	// Set the last record to display
	if ($report_list->TotalRecs > $report_list->StartRec + $report_list->DisplayRecs - 1)
		$report_list->StopRec = $report_list->StartRec + $report_list->DisplayRecs - 1;
	else
		$report_list->StopRec = $report_list->TotalRecs;
}
$report_list->RecCnt = $report_list->StartRec - 1;
if ($report_list->Recordset && !$report_list->Recordset->EOF) {
	$report_list->Recordset->MoveFirst();
	$bSelectLimit = $report_list->UseSelectLimit;
	if (!$bSelectLimit && $report_list->StartRec > 1)
		$report_list->Recordset->Move($report_list->StartRec - 1);
} elseif (!$report->AllowAddDeleteRow && $report_list->StopRec == 0) {
	$report_list->StopRec = $report->GridAddRowCount;
}

// Initialize aggregate
$report->RowType = EW_ROWTYPE_AGGREGATEINIT;
$report->ResetAttrs();
$report_list->RenderRow();
while ($report_list->RecCnt < $report_list->StopRec) {
	$report_list->RecCnt++;
	if (intval($report_list->RecCnt) >= intval($report_list->StartRec)) {
		$report_list->RowCnt++;

		// Set up key count
		$report_list->KeyCount = $report_list->RowIndex;

		// Init row class and style
		$report->ResetAttrs();
		$report->CssClass = "";
		if ($report->CurrentAction == "gridadd") {
		} else {
			$report_list->LoadRowValues($report_list->Recordset); // Load row values
		}
		$report->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$report->RowAttrs = array_merge($report->RowAttrs, array('data-rowindex'=>$report_list->RowCnt, 'id'=>'r' . $report_list->RowCnt . '_report', 'data-rowtype'=>$report->RowType));

		// Render row
		$report_list->RenderRow();

		// Render list options
		$report_list->RenderListOptions();
?>
	<tr<?php echo $report->RowAttributes() ?>>
<?php

// Render list options (body, left)
$report_list->ListOptions->Render("body", "left", $report_list->RowCnt);
?>
	<?php if ($report->leave_id->Visible) { // leave_id ?>
		<td data-name="leave_id"<?php echo $report->leave_id->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_leave_id" class="report_leave_id">
<span<?php echo $report->leave_id->ViewAttributes() ?>>
<?php echo $report->leave_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->date_created->Visible) { // date_created ?>
		<td data-name="date_created"<?php echo $report->date_created->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_date_created" class="report_date_created">
<span<?php echo $report->date_created->ViewAttributes() ?>>
<?php echo $report->date_created->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->time->Visible) { // time ?>
		<td data-name="time"<?php echo $report->time->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_time" class="report_time">
<span<?php echo $report->time->ViewAttributes() ?>>
<?php echo $report->time->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->staff_id->Visible) { // staff_id ?>
		<td data-name="staff_id"<?php echo $report->staff_id->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_staff_id" class="report_staff_id">
<span<?php echo $report->staff_id->ViewAttributes() ?>>
<?php echo $report->staff_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->staff_name->Visible) { // staff_name ?>
		<td data-name="staff_name"<?php echo $report->staff_name->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_staff_name" class="report_staff_name">
<span<?php echo $report->staff_name->ViewAttributes() ?>>
<?php echo $report->staff_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->company->Visible) { // company ?>
		<td data-name="company"<?php echo $report->company->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_company" class="report_company">
<span<?php echo $report->company->ViewAttributes() ?>>
<?php echo $report->company->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->department->Visible) { // department ?>
		<td data-name="department"<?php echo $report->department->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_department" class="report_department">
<span<?php echo $report->department->ViewAttributes() ?>>
<?php echo $report->department->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->leave_type->Visible) { // leave_type ?>
		<td data-name="leave_type"<?php echo $report->leave_type->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_leave_type" class="report_leave_type">
<span<?php echo $report->leave_type->ViewAttributes() ?>>
<?php echo $report->leave_type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->start_date->Visible) { // start_date ?>
		<td data-name="start_date"<?php echo $report->start_date->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_start_date" class="report_start_date">
<span<?php echo $report->start_date->ViewAttributes() ?>>
<?php echo $report->start_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->end_date->Visible) { // end_date ?>
		<td data-name="end_date"<?php echo $report->end_date->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_end_date" class="report_end_date">
<span<?php echo $report->end_date->ViewAttributes() ?>>
<?php echo $report->end_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->no_of_days->Visible) { // no_of_days ?>
		<td data-name="no_of_days"<?php echo $report->no_of_days->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_no_of_days" class="report_no_of_days">
<span<?php echo $report->no_of_days->ViewAttributes() ?>>
<?php echo $report->no_of_days->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->resumption_date->Visible) { // resumption_date ?>
		<td data-name="resumption_date"<?php echo $report->resumption_date->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_resumption_date" class="report_resumption_date">
<span<?php echo $report->resumption_date->ViewAttributes() ?>>
<?php echo $report->resumption_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->replacement_assign_staff->Visible) { // replacement_assign_staff ?>
		<td data-name="replacement_assign_staff"<?php echo $report->replacement_assign_staff->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_replacement_assign_staff" class="report_replacement_assign_staff">
<span<?php echo $report->replacement_assign_staff->ViewAttributes() ?>>
<?php echo $report->replacement_assign_staff->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->purpose_of_leave->Visible) { // purpose_of_leave ?>
		<td data-name="purpose_of_leave"<?php echo $report->purpose_of_leave->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_purpose_of_leave" class="report_purpose_of_leave">
<span<?php echo $report->purpose_of_leave->ViewAttributes() ?>>
<?php echo $report->purpose_of_leave->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($report->status->Visible) { // status ?>
		<td data-name="status"<?php echo $report->status->CellAttributes() ?>>
<span id="el<?php echo $report_list->RowCnt ?>_report_status" class="report_status">
<span<?php echo $report->status->ViewAttributes() ?>>
<?php echo $report->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$report_list->ListOptions->Render("body", "right", $report_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($report->CurrentAction <> "gridadd")
		$report_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($report->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($report_list->Recordset)
	$report_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($report_list->TotalRecs == 0 && $report->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($report_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($report->Export == "") { ?>
<script type="text/javascript">
freportlistsrch.FilterList = <?php echo $report_list->GetFilterList() ?>;
freportlistsrch.Init();
freportlist.Init();
</script>
<?php } ?>
<?php
$report_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($report->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$report_list->Page_Terminate();
?>
