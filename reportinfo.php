<?php

// Global variable for table object
$report = NULL;

//
// Table class for report
//
class creport extends cTable {
	var $leave_id;
	var $date_created;
	var $time;
	var $staff_id;
	var $staff_name;
	var $company;
	var $department;
	var $leave_type;
	var $start_date;
	var $end_date;
	var $no_of_days;
	var $resumption_date;
	var $replacement_assign_staff;
	var $purpose_of_leave;
	var $status;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'report';
		$this->TableName = 'report';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`report`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// leave_id
		$this->leave_id = new cField('report', 'report', 'x_leave_id', 'leave_id', '`leave_id`', '`leave_id`', 200, -1, FALSE, '`leave_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->leave_id->Sortable = TRUE; // Allow sort
		$this->fields['leave_id'] = &$this->leave_id;

		// date_created
		$this->date_created = new cField('report', 'report', 'x_date_created', 'date_created', '`date_created`', ew_CastDateFieldForLike('`date_created`', 0, "DB"), 133, 0, FALSE, '`date_created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->date_created->Sortable = TRUE; // Allow sort
		$this->date_created->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['date_created'] = &$this->date_created;

		// time
		$this->time = new cField('report', 'report', 'x_time', 'time', '`time`', ew_CastDateFieldForLike('`time`', 4, "DB"), 134, 4, FALSE, '`time`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->time->Sortable = TRUE; // Allow sort
		$this->time->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_TIME_SEPARATOR"], $Language->Phrase("IncorrectTime"));
		$this->fields['time'] = &$this->time;

		// staff_id
		$this->staff_id = new cField('report', 'report', 'x_staff_id', 'staff_id', '`staff_id`', '`staff_id`', 200, -1, FALSE, '`staff_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->staff_id->Sortable = TRUE; // Allow sort
		$this->fields['staff_id'] = &$this->staff_id;

		// staff_name
		$this->staff_name = new cField('report', 'report', 'x_staff_name', 'staff_name', '`staff_name`', '`staff_name`', 200, -1, FALSE, '`staff_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->staff_name->Sortable = TRUE; // Allow sort
		$this->fields['staff_name'] = &$this->staff_name;

		// company
		$this->company = new cField('report', 'report', 'x_company', 'company', '`company`', '`company`', 200, -1, FALSE, '`company`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->company->Sortable = TRUE; // Allow sort
		$this->fields['company'] = &$this->company;

		// department
		$this->department = new cField('report', 'report', 'x_department', 'department', '`department`', '`department`', 3, -1, FALSE, '`department`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->department->Sortable = TRUE; // Allow sort
		$this->department->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['department'] = &$this->department;

		// leave_type
		$this->leave_type = new cField('report', 'report', 'x_leave_type', 'leave_type', '`leave_type`', '`leave_type`', 3, -1, FALSE, '`leave_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->leave_type->Sortable = TRUE; // Allow sort
		$this->leave_type->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['leave_type'] = &$this->leave_type;

		// start_date
		$this->start_date = new cField('report', 'report', 'x_start_date', 'start_date', '`start_date`', ew_CastDateFieldForLike('`start_date`', 0, "DB"), 133, 0, FALSE, '`start_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->start_date->Sortable = TRUE; // Allow sort
		$this->start_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['start_date'] = &$this->start_date;

		// end_date
		$this->end_date = new cField('report', 'report', 'x_end_date', 'end_date', '`end_date`', ew_CastDateFieldForLike('`end_date`', 0, "DB"), 133, 0, FALSE, '`end_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->end_date->Sortable = TRUE; // Allow sort
		$this->end_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['end_date'] = &$this->end_date;

		// no_of_days
		$this->no_of_days = new cField('report', 'report', 'x_no_of_days', 'no_of_days', '`no_of_days`', '`no_of_days`', 3, -1, FALSE, '`no_of_days`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_of_days->Sortable = TRUE; // Allow sort
		$this->no_of_days->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['no_of_days'] = &$this->no_of_days;

		// resumption_date
		$this->resumption_date = new cField('report', 'report', 'x_resumption_date', 'resumption_date', '`resumption_date`', ew_CastDateFieldForLike('`resumption_date`', 0, "DB"), 133, 0, FALSE, '`resumption_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->resumption_date->Sortable = TRUE; // Allow sort
		$this->resumption_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['resumption_date'] = &$this->resumption_date;

		// replacement_assign_staff
		$this->replacement_assign_staff = new cField('report', 'report', 'x_replacement_assign_staff', 'replacement_assign_staff', '`replacement_assign_staff`', '`replacement_assign_staff`', 200, -1, FALSE, '`replacement_assign_staff`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->replacement_assign_staff->Sortable = TRUE; // Allow sort
		$this->fields['replacement_assign_staff'] = &$this->replacement_assign_staff;

		// purpose_of_leave
		$this->purpose_of_leave = new cField('report', 'report', 'x_purpose_of_leave', 'purpose_of_leave', '`purpose_of_leave`', '`purpose_of_leave`', 200, -1, FALSE, '`purpose_of_leave`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->purpose_of_leave->Sortable = TRUE; // Allow sort
		$this->fields['purpose_of_leave'] = &$this->purpose_of_leave;

		// status
		$this->status = new cField('report', 'report', 'x_status', 'status', '`status`', '`status`', 3, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status'] = &$this->status;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`report`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "reportlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "reportview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "reportedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "reportadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "reportlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("reportview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("reportview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "reportadd.php?" . $this->UrlParm($parm);
		else
			$url = "reportadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("reportedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("reportadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("reportdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->leave_id->setDbValue($rs->fields('leave_id'));
		$this->date_created->setDbValue($rs->fields('date_created'));
		$this->time->setDbValue($rs->fields('time'));
		$this->staff_id->setDbValue($rs->fields('staff_id'));
		$this->staff_name->setDbValue($rs->fields('staff_name'));
		$this->company->setDbValue($rs->fields('company'));
		$this->department->setDbValue($rs->fields('department'));
		$this->leave_type->setDbValue($rs->fields('leave_type'));
		$this->start_date->setDbValue($rs->fields('start_date'));
		$this->end_date->setDbValue($rs->fields('end_date'));
		$this->no_of_days->setDbValue($rs->fields('no_of_days'));
		$this->resumption_date->setDbValue($rs->fields('resumption_date'));
		$this->replacement_assign_staff->setDbValue($rs->fields('replacement_assign_staff'));
		$this->purpose_of_leave->setDbValue($rs->fields('purpose_of_leave'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
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

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// leave_id
		$this->leave_id->EditAttrs["class"] = "form-control";
		$this->leave_id->EditCustomAttributes = "";
		$this->leave_id->EditValue = $this->leave_id->CurrentValue;
		$this->leave_id->PlaceHolder = ew_RemoveHtml($this->leave_id->FldCaption());

		// date_created
		$this->date_created->EditAttrs["class"] = "form-control";
		$this->date_created->EditCustomAttributes = "";
		$this->date_created->EditValue = ew_FormatDateTime($this->date_created->CurrentValue, 8);
		$this->date_created->PlaceHolder = ew_RemoveHtml($this->date_created->FldCaption());

		// time
		$this->time->EditAttrs["class"] = "form-control";
		$this->time->EditCustomAttributes = "";
		$this->time->EditValue = $this->time->CurrentValue;
		$this->time->PlaceHolder = ew_RemoveHtml($this->time->FldCaption());

		// staff_id
		$this->staff_id->EditAttrs["class"] = "form-control";
		$this->staff_id->EditCustomAttributes = "";
		$this->staff_id->EditValue = $this->staff_id->CurrentValue;
		$this->staff_id->PlaceHolder = ew_RemoveHtml($this->staff_id->FldCaption());

		// staff_name
		$this->staff_name->EditAttrs["class"] = "form-control";
		$this->staff_name->EditCustomAttributes = "";
		$this->staff_name->EditValue = $this->staff_name->CurrentValue;
		$this->staff_name->PlaceHolder = ew_RemoveHtml($this->staff_name->FldCaption());

		// company
		$this->company->EditAttrs["class"] = "form-control";
		$this->company->EditCustomAttributes = "";
		$this->company->EditValue = $this->company->CurrentValue;
		$this->company->PlaceHolder = ew_RemoveHtml($this->company->FldCaption());

		// department
		$this->department->EditAttrs["class"] = "form-control";
		$this->department->EditCustomAttributes = "";
		$this->department->EditValue = $this->department->CurrentValue;
		$this->department->PlaceHolder = ew_RemoveHtml($this->department->FldCaption());

		// leave_type
		$this->leave_type->EditAttrs["class"] = "form-control";
		$this->leave_type->EditCustomAttributes = "";
		$this->leave_type->EditValue = $this->leave_type->CurrentValue;
		$this->leave_type->PlaceHolder = ew_RemoveHtml($this->leave_type->FldCaption());

		// start_date
		$this->start_date->EditAttrs["class"] = "form-control";
		$this->start_date->EditCustomAttributes = "";
		$this->start_date->EditValue = ew_FormatDateTime($this->start_date->CurrentValue, 8);
		$this->start_date->PlaceHolder = ew_RemoveHtml($this->start_date->FldCaption());

		// end_date
		$this->end_date->EditAttrs["class"] = "form-control";
		$this->end_date->EditCustomAttributes = "";
		$this->end_date->EditValue = ew_FormatDateTime($this->end_date->CurrentValue, 8);
		$this->end_date->PlaceHolder = ew_RemoveHtml($this->end_date->FldCaption());

		// no_of_days
		$this->no_of_days->EditAttrs["class"] = "form-control";
		$this->no_of_days->EditCustomAttributes = "";
		$this->no_of_days->EditValue = $this->no_of_days->CurrentValue;
		$this->no_of_days->PlaceHolder = ew_RemoveHtml($this->no_of_days->FldCaption());

		// resumption_date
		$this->resumption_date->EditAttrs["class"] = "form-control";
		$this->resumption_date->EditCustomAttributes = "";
		$this->resumption_date->EditValue = ew_FormatDateTime($this->resumption_date->CurrentValue, 8);
		$this->resumption_date->PlaceHolder = ew_RemoveHtml($this->resumption_date->FldCaption());

		// replacement_assign_staff
		$this->replacement_assign_staff->EditAttrs["class"] = "form-control";
		$this->replacement_assign_staff->EditCustomAttributes = "";
		$this->replacement_assign_staff->EditValue = $this->replacement_assign_staff->CurrentValue;
		$this->replacement_assign_staff->PlaceHolder = ew_RemoveHtml($this->replacement_assign_staff->FldCaption());

		// purpose_of_leave
		$this->purpose_of_leave->EditAttrs["class"] = "form-control";
		$this->purpose_of_leave->EditCustomAttributes = "";
		$this->purpose_of_leave->EditValue = $this->purpose_of_leave->CurrentValue;
		$this->purpose_of_leave->PlaceHolder = ew_RemoveHtml($this->purpose_of_leave->FldCaption());

		// status
		$this->status->EditAttrs["class"] = "form-control";
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->CurrentValue;
		$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->leave_id->Exportable) $Doc->ExportCaption($this->leave_id);
					if ($this->date_created->Exportable) $Doc->ExportCaption($this->date_created);
					if ($this->time->Exportable) $Doc->ExportCaption($this->time);
					if ($this->staff_id->Exportable) $Doc->ExportCaption($this->staff_id);
					if ($this->staff_name->Exportable) $Doc->ExportCaption($this->staff_name);
					if ($this->company->Exportable) $Doc->ExportCaption($this->company);
					if ($this->department->Exportable) $Doc->ExportCaption($this->department);
					if ($this->leave_type->Exportable) $Doc->ExportCaption($this->leave_type);
					if ($this->start_date->Exportable) $Doc->ExportCaption($this->start_date);
					if ($this->end_date->Exportable) $Doc->ExportCaption($this->end_date);
					if ($this->no_of_days->Exportable) $Doc->ExportCaption($this->no_of_days);
					if ($this->resumption_date->Exportable) $Doc->ExportCaption($this->resumption_date);
					if ($this->replacement_assign_staff->Exportable) $Doc->ExportCaption($this->replacement_assign_staff);
					if ($this->purpose_of_leave->Exportable) $Doc->ExportCaption($this->purpose_of_leave);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
				} else {
					if ($this->leave_id->Exportable) $Doc->ExportCaption($this->leave_id);
					if ($this->date_created->Exportable) $Doc->ExportCaption($this->date_created);
					if ($this->time->Exportable) $Doc->ExportCaption($this->time);
					if ($this->staff_id->Exportable) $Doc->ExportCaption($this->staff_id);
					if ($this->staff_name->Exportable) $Doc->ExportCaption($this->staff_name);
					if ($this->company->Exportable) $Doc->ExportCaption($this->company);
					if ($this->department->Exportable) $Doc->ExportCaption($this->department);
					if ($this->leave_type->Exportable) $Doc->ExportCaption($this->leave_type);
					if ($this->start_date->Exportable) $Doc->ExportCaption($this->start_date);
					if ($this->end_date->Exportable) $Doc->ExportCaption($this->end_date);
					if ($this->no_of_days->Exportable) $Doc->ExportCaption($this->no_of_days);
					if ($this->resumption_date->Exportable) $Doc->ExportCaption($this->resumption_date);
					if ($this->replacement_assign_staff->Exportable) $Doc->ExportCaption($this->replacement_assign_staff);
					if ($this->purpose_of_leave->Exportable) $Doc->ExportCaption($this->purpose_of_leave);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->leave_id->Exportable) $Doc->ExportField($this->leave_id);
						if ($this->date_created->Exportable) $Doc->ExportField($this->date_created);
						if ($this->time->Exportable) $Doc->ExportField($this->time);
						if ($this->staff_id->Exportable) $Doc->ExportField($this->staff_id);
						if ($this->staff_name->Exportable) $Doc->ExportField($this->staff_name);
						if ($this->company->Exportable) $Doc->ExportField($this->company);
						if ($this->department->Exportable) $Doc->ExportField($this->department);
						if ($this->leave_type->Exportable) $Doc->ExportField($this->leave_type);
						if ($this->start_date->Exportable) $Doc->ExportField($this->start_date);
						if ($this->end_date->Exportable) $Doc->ExportField($this->end_date);
						if ($this->no_of_days->Exportable) $Doc->ExportField($this->no_of_days);
						if ($this->resumption_date->Exportable) $Doc->ExportField($this->resumption_date);
						if ($this->replacement_assign_staff->Exportable) $Doc->ExportField($this->replacement_assign_staff);
						if ($this->purpose_of_leave->Exportable) $Doc->ExportField($this->purpose_of_leave);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
					} else {
						if ($this->leave_id->Exportable) $Doc->ExportField($this->leave_id);
						if ($this->date_created->Exportable) $Doc->ExportField($this->date_created);
						if ($this->time->Exportable) $Doc->ExportField($this->time);
						if ($this->staff_id->Exportable) $Doc->ExportField($this->staff_id);
						if ($this->staff_name->Exportable) $Doc->ExportField($this->staff_name);
						if ($this->company->Exportable) $Doc->ExportField($this->company);
						if ($this->department->Exportable) $Doc->ExportField($this->department);
						if ($this->leave_type->Exportable) $Doc->ExportField($this->leave_type);
						if ($this->start_date->Exportable) $Doc->ExportField($this->start_date);
						if ($this->end_date->Exportable) $Doc->ExportField($this->end_date);
						if ($this->no_of_days->Exportable) $Doc->ExportField($this->no_of_days);
						if ($this->resumption_date->Exportable) $Doc->ExportField($this->resumption_date);
						if ($this->replacement_assign_staff->Exportable) $Doc->ExportField($this->replacement_assign_staff);
						if ($this->purpose_of_leave->Exportable) $Doc->ExportField($this->purpose_of_leave);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
