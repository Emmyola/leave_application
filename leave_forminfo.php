<?php

// Global variable for table object
$leave_form = NULL;

//
// Table class for leave_form
//
class cleave_form extends cTable {
	var $id;
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
	var $initiator_action;
	var $initiator_comments;
	var $verified_staff;
	var $verified_replacement_staff;
	var $recommender_action;
	var $recommender_comments;
	var $approver_action;
	var $approver_comments;
	var $last_updated_date;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'leave_form';
		$this->TableName = 'leave_form';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`leave_form`";
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

		// id
		$this->id = new cField('leave_form', 'leave_form', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// leave_id
		$this->leave_id = new cField('leave_form', 'leave_form', 'x_leave_id', 'leave_id', '`leave_id`', '`leave_id`', 200, -1, FALSE, '`leave_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->leave_id->Sortable = TRUE; // Allow sort
		$this->fields['leave_id'] = &$this->leave_id;

		// date_created
		$this->date_created = new cField('leave_form', 'leave_form', 'x_date_created', 'date_created', '`date_created`', ew_CastDateFieldForLike('`date_created`', 7, "DB"), 133, 7, FALSE, '`date_created`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->date_created->Sortable = TRUE; // Allow sort
		$this->fields['date_created'] = &$this->date_created;

		// time
		$this->time = new cField('leave_form', 'leave_form', 'x_time', 'time', '`time`', ew_CastDateFieldForLike('`time`', 3, "DB"), 134, 3, FALSE, '`time`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->time->Sortable = TRUE; // Allow sort
		$this->fields['time'] = &$this->time;

		// staff_id
		$this->staff_id = new cField('leave_form', 'leave_form', 'x_staff_id', 'staff_id', '`staff_id`', '`staff_id`', 200, -1, FALSE, '`staff_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->staff_id->Sortable = TRUE; // Allow sort
		$this->fields['staff_id'] = &$this->staff_id;

		// staff_name
		$this->staff_name = new cField('leave_form', 'leave_form', 'x_staff_name', 'staff_name', '`staff_name`', '`staff_name`', 200, -1, FALSE, '`staff_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->staff_name->Sortable = TRUE; // Allow sort
		$this->fields['staff_name'] = &$this->staff_name;

		// company
		$this->company = new cField('leave_form', 'leave_form', 'x_company', 'company', '`company`', '`company`', 200, -1, FALSE, '`company`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->company->Sortable = TRUE; // Allow sort
		$this->company->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->company->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['company'] = &$this->company;

		// department
		$this->department = new cField('leave_form', 'leave_form', 'x_department', 'department', '`department`', '`department`', 3, -1, FALSE, '`department`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->department->Sortable = TRUE; // Allow sort
		$this->department->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->department->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->department->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['department'] = &$this->department;

		// leave_type
		$this->leave_type = new cField('leave_form', 'leave_form', 'x_leave_type', 'leave_type', '`leave_type`', '`leave_type`', 3, -1, FALSE, '`leave_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->leave_type->Sortable = TRUE; // Allow sort
		$this->leave_type->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->leave_type->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->leave_type->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['leave_type'] = &$this->leave_type;

		// start_date
		$this->start_date = new cField('leave_form', 'leave_form', 'x_start_date', 'start_date', '`start_date`', ew_CastDateFieldForLike('`start_date`', 14, "DB"), 133, 14, FALSE, '`start_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->start_date->Sortable = TRUE; // Allow sort
		$this->start_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectShortDateDMY"));
		$this->fields['start_date'] = &$this->start_date;

		// end_date
		$this->end_date = new cField('leave_form', 'leave_form', 'x_end_date', 'end_date', '`end_date`', ew_CastDateFieldForLike('`end_date`', 14, "DB"), 133, 14, FALSE, '`end_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->end_date->Sortable = TRUE; // Allow sort
		$this->end_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectShortDateDMY"));
		$this->fields['end_date'] = &$this->end_date;

		// no_of_days
		$this->no_of_days = new cField('leave_form', 'leave_form', 'x_no_of_days', 'no_of_days', '`no_of_days`', '`no_of_days`', 3, -1, FALSE, '`no_of_days`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_of_days->Sortable = TRUE; // Allow sort
		$this->no_of_days->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['no_of_days'] = &$this->no_of_days;

		// resumption_date
		$this->resumption_date = new cField('leave_form', 'leave_form', 'x_resumption_date', 'resumption_date', '`resumption_date`', ew_CastDateFieldForLike('`resumption_date`', 14, "DB"), 133, 14, FALSE, '`resumption_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->resumption_date->Sortable = TRUE; // Allow sort
		$this->resumption_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectShortDateDMY"));
		$this->fields['resumption_date'] = &$this->resumption_date;

		// replacement_assign_staff
		$this->replacement_assign_staff = new cField('leave_form', 'leave_form', 'x_replacement_assign_staff', 'replacement_assign_staff', '`replacement_assign_staff`', '`replacement_assign_staff`', 200, -1, FALSE, '`replacement_assign_staff`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->replacement_assign_staff->Sortable = TRUE; // Allow sort
		$this->replacement_assign_staff->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->replacement_assign_staff->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['replacement_assign_staff'] = &$this->replacement_assign_staff;

		// purpose_of_leave
		$this->purpose_of_leave = new cField('leave_form', 'leave_form', 'x_purpose_of_leave', 'purpose_of_leave', '`purpose_of_leave`', '`purpose_of_leave`', 200, -1, FALSE, '`purpose_of_leave`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->purpose_of_leave->Sortable = TRUE; // Allow sort
		$this->fields['purpose_of_leave'] = &$this->purpose_of_leave;

		// status
		$this->status = new cField('leave_form', 'leave_form', 'x_status', 'status', '`status`', '`status`', 3, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status'] = &$this->status;

		// initiator_action
		$this->initiator_action = new cField('leave_form', 'leave_form', 'x_initiator_action', 'initiator_action', '`initiator_action`', '`initiator_action`', 3, -1, FALSE, '`initiator_action`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->initiator_action->Sortable = TRUE; // Allow sort
		$this->initiator_action->OptionCount = 2;
		$this->initiator_action->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['initiator_action'] = &$this->initiator_action;

		// initiator_comments
		$this->initiator_comments = new cField('leave_form', 'leave_form', 'x_initiator_comments', 'initiator_comments', '`initiator_comments`', '`initiator_comments`', 200, -1, FALSE, '`initiator_comments`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->initiator_comments->Sortable = TRUE; // Allow sort
		$this->fields['initiator_comments'] = &$this->initiator_comments;

		// verified_staff
		$this->verified_staff = new cField('leave_form', 'leave_form', 'x_verified_staff', 'verified_staff', '`verified_staff`', '`verified_staff`', 3, -1, FALSE, '`verified_staff`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->verified_staff->Sortable = TRUE; // Allow sort
		$this->verified_staff->OptionCount = 2;
		$this->verified_staff->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['verified_staff'] = &$this->verified_staff;

		// verified_replacement_staff
		$this->verified_replacement_staff = new cField('leave_form', 'leave_form', 'x_verified_replacement_staff', 'verified_replacement_staff', '`verified_replacement_staff`', '`verified_replacement_staff`', 3, -1, FALSE, '`verified_replacement_staff`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->verified_replacement_staff->Sortable = TRUE; // Allow sort
		$this->verified_replacement_staff->OptionCount = 2;
		$this->verified_replacement_staff->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['verified_replacement_staff'] = &$this->verified_replacement_staff;

		// recommender_action
		$this->recommender_action = new cField('leave_form', 'leave_form', 'x_recommender_action', 'recommender_action', '`recommender_action`', '`recommender_action`', 3, -1, FALSE, '`recommender_action`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->recommender_action->Sortable = TRUE; // Allow sort
		$this->recommender_action->OptionCount = 2;
		$this->recommender_action->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['recommender_action'] = &$this->recommender_action;

		// recommender_comments
		$this->recommender_comments = new cField('leave_form', 'leave_form', 'x_recommender_comments', 'recommender_comments', '`recommender_comments`', '`recommender_comments`', 200, -1, FALSE, '`recommender_comments`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->recommender_comments->Sortable = TRUE; // Allow sort
		$this->fields['recommender_comments'] = &$this->recommender_comments;

		// approver_action
		$this->approver_action = new cField('leave_form', 'leave_form', 'x_approver_action', 'approver_action', '`approver_action`', '`approver_action`', 3, -1, FALSE, '`approver_action`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->approver_action->Sortable = TRUE; // Allow sort
		$this->approver_action->OptionCount = 2;
		$this->approver_action->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['approver_action'] = &$this->approver_action;

		// approver_comments
		$this->approver_comments = new cField('leave_form', 'leave_form', 'x_approver_comments', 'approver_comments', '`approver_comments`', '`approver_comments`', 200, -1, FALSE, '`approver_comments`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->approver_comments->Sortable = TRUE; // Allow sort
		$this->fields['approver_comments'] = &$this->approver_comments;

		// last_updated_date
		$this->last_updated_date = new cField('leave_form', 'leave_form', 'x_last_updated_date', 'last_updated_date', '`last_updated_date`', ew_CastDateFieldForLike('`last_updated_date`', 7, "DB"), 135, 7, FALSE, '`last_updated_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_updated_date->Sortable = TRUE; // Allow sort
		$this->fields['last_updated_date'] = &$this->last_updated_date;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`leave_form`";
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

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
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
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
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
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "leave_formlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "leave_formview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "leave_formedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "leave_formadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "leave_formlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("leave_formview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("leave_formview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "leave_formadd.php?" . $this->UrlParm($parm);
		else
			$url = "leave_formadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("leave_formedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("leave_formadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("leave_formdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
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
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
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
			$this->id->CurrentValue = $key;
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
		$this->id->setDbValue($rs->fields('id'));
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
		$this->initiator_action->setDbValue($rs->fields('initiator_action'));
		$this->initiator_comments->setDbValue($rs->fields('initiator_comments'));
		$this->verified_staff->setDbValue($rs->fields('verified_staff'));
		$this->verified_replacement_staff->setDbValue($rs->fields('verified_replacement_staff'));
		$this->recommender_action->setDbValue($rs->fields('recommender_action'));
		$this->recommender_comments->setDbValue($rs->fields('recommender_comments'));
		$this->approver_action->setDbValue($rs->fields('approver_action'));
		$this->approver_comments->setDbValue($rs->fields('approver_comments'));
		$this->last_updated_date->setDbValue($rs->fields('last_updated_date'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
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

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// leave_id
		$this->leave_id->EditAttrs["class"] = "form-control";
		$this->leave_id->EditCustomAttributes = "";
		$this->leave_id->EditValue = $this->leave_id->CurrentValue;
		$this->leave_id->PlaceHolder = ew_RemoveHtml($this->leave_id->FldCaption());

		// date_created
		$this->date_created->EditAttrs["class"] = "form-control";
		$this->date_created->EditCustomAttributes = "";
		$this->date_created->EditValue = ew_FormatDateTime($this->date_created->CurrentValue, 7);
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

		// department
		$this->department->EditAttrs["class"] = "form-control";
		$this->department->EditCustomAttributes = "";

		// leave_type
		$this->leave_type->EditAttrs["class"] = "form-control";
		$this->leave_type->EditCustomAttributes = "";

		// start_date
		$this->start_date->EditAttrs["class"] = "form-control";
		$this->start_date->EditCustomAttributes = "";
		$this->start_date->EditValue = ew_FormatDateTime($this->start_date->CurrentValue, 14);
		$this->start_date->PlaceHolder = ew_RemoveHtml($this->start_date->FldCaption());

		// end_date
		$this->end_date->EditAttrs["class"] = "form-control";
		$this->end_date->EditCustomAttributes = "";
		$this->end_date->EditValue = ew_FormatDateTime($this->end_date->CurrentValue, 14);
		$this->end_date->PlaceHolder = ew_RemoveHtml($this->end_date->FldCaption());

		// no_of_days
		$this->no_of_days->EditAttrs["class"] = "form-control";
		$this->no_of_days->EditCustomAttributes = "";
		$this->no_of_days->EditValue = $this->no_of_days->CurrentValue;
		$this->no_of_days->PlaceHolder = ew_RemoveHtml($this->no_of_days->FldCaption());

		// resumption_date
		$this->resumption_date->EditAttrs["class"] = "form-control";
		$this->resumption_date->EditCustomAttributes = "";
		$this->resumption_date->EditValue = ew_FormatDateTime($this->resumption_date->CurrentValue, 14);
		$this->resumption_date->PlaceHolder = ew_RemoveHtml($this->resumption_date->FldCaption());

		// replacement_assign_staff
		$this->replacement_assign_staff->EditAttrs["class"] = "form-control";
		$this->replacement_assign_staff->EditCustomAttributes = "";

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

		// initiator_action
		$this->initiator_action->EditCustomAttributes = "";
		$this->initiator_action->EditValue = $this->initiator_action->Options(FALSE);

		// initiator_comments
		$this->initiator_comments->EditAttrs["class"] = "form-control";
		$this->initiator_comments->EditCustomAttributes = "";
		$this->initiator_comments->EditValue = $this->initiator_comments->CurrentValue;
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
		$this->recommender_comments->EditValue = $this->recommender_comments->CurrentValue;
		$this->recommender_comments->PlaceHolder = ew_RemoveHtml($this->recommender_comments->FldCaption());

		// approver_action
		$this->approver_action->EditCustomAttributes = "";
		$this->approver_action->EditValue = $this->approver_action->Options(FALSE);

		// approver_comments
		$this->approver_comments->EditAttrs["class"] = "form-control";
		$this->approver_comments->EditCustomAttributes = "";
		$this->approver_comments->EditValue = $this->approver_comments->CurrentValue;
		$this->approver_comments->PlaceHolder = ew_RemoveHtml($this->approver_comments->FldCaption());

		// last_updated_date
		$this->last_updated_date->EditAttrs["class"] = "form-control";
		$this->last_updated_date->EditCustomAttributes = "";
		$this->last_updated_date->EditValue = ew_FormatDateTime($this->last_updated_date->CurrentValue, 7);
		$this->last_updated_date->PlaceHolder = ew_RemoveHtml($this->last_updated_date->FldCaption());

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
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
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
					if ($this->initiator_action->Exportable) $Doc->ExportCaption($this->initiator_action);
					if ($this->initiator_comments->Exportable) $Doc->ExportCaption($this->initiator_comments);
					if ($this->verified_staff->Exportable) $Doc->ExportCaption($this->verified_staff);
					if ($this->verified_replacement_staff->Exportable) $Doc->ExportCaption($this->verified_replacement_staff);
					if ($this->recommender_action->Exportable) $Doc->ExportCaption($this->recommender_action);
					if ($this->recommender_comments->Exportable) $Doc->ExportCaption($this->recommender_comments);
					if ($this->approver_action->Exportable) $Doc->ExportCaption($this->approver_action);
					if ($this->approver_comments->Exportable) $Doc->ExportCaption($this->approver_comments);
					if ($this->last_updated_date->Exportable) $Doc->ExportCaption($this->last_updated_date);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
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
					if ($this->initiator_action->Exportable) $Doc->ExportCaption($this->initiator_action);
					if ($this->initiator_comments->Exportable) $Doc->ExportCaption($this->initiator_comments);
					if ($this->verified_staff->Exportable) $Doc->ExportCaption($this->verified_staff);
					if ($this->verified_replacement_staff->Exportable) $Doc->ExportCaption($this->verified_replacement_staff);
					if ($this->recommender_action->Exportable) $Doc->ExportCaption($this->recommender_action);
					if ($this->recommender_comments->Exportable) $Doc->ExportCaption($this->recommender_comments);
					if ($this->approver_action->Exportable) $Doc->ExportCaption($this->approver_action);
					if ($this->approver_comments->Exportable) $Doc->ExportCaption($this->approver_comments);
					if ($this->last_updated_date->Exportable) $Doc->ExportCaption($this->last_updated_date);
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
						if ($this->id->Exportable) $Doc->ExportField($this->id);
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
						if ($this->initiator_action->Exportable) $Doc->ExportField($this->initiator_action);
						if ($this->initiator_comments->Exportable) $Doc->ExportField($this->initiator_comments);
						if ($this->verified_staff->Exportable) $Doc->ExportField($this->verified_staff);
						if ($this->verified_replacement_staff->Exportable) $Doc->ExportField($this->verified_replacement_staff);
						if ($this->recommender_action->Exportable) $Doc->ExportField($this->recommender_action);
						if ($this->recommender_comments->Exportable) $Doc->ExportField($this->recommender_comments);
						if ($this->approver_action->Exportable) $Doc->ExportField($this->approver_action);
						if ($this->approver_comments->Exportable) $Doc->ExportField($this->approver_comments);
						if ($this->last_updated_date->Exportable) $Doc->ExportField($this->last_updated_date);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
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
						if ($this->initiator_action->Exportable) $Doc->ExportField($this->initiator_action);
						if ($this->initiator_comments->Exportable) $Doc->ExportField($this->initiator_comments);
						if ($this->verified_staff->Exportable) $Doc->ExportField($this->verified_staff);
						if ($this->verified_replacement_staff->Exportable) $Doc->ExportField($this->verified_replacement_staff);
						if ($this->recommender_action->Exportable) $Doc->ExportField($this->recommender_action);
						if ($this->recommender_comments->Exportable) $Doc->ExportField($this->recommender_comments);
						if ($this->approver_action->Exportable) $Doc->ExportField($this->approver_action);
						if ($this->approver_comments->Exportable) $Doc->ExportField($this->approver_comments);
						if ($this->last_updated_date->Exportable) $Doc->ExportField($this->last_updated_date);
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
		if (CurrentUserLevel() == 1) {
			ew_AddFilter($filter, "`status` in (0,1,2) AND `staff_id` = '".$_SESSION['Staff_ID']."' AND `company` = '".$_SESSION['Company']."'");
		}
		if (CurrentUserLevel() == 2) {
			ew_AddFilter($filter, "`status` in (2,3,5)");
		}
		if (CurrentUserLevel() == 3) {
			ew_AddFilter($filter, "`status` in (4)");
		}
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
		//
		// Initiator Only

		if (CurrentPageID() == "add" && CurrentUserLevel() == 1) {

			// Save and forward
			if ($this->initiator_action->CurrentValue == 1) {
				$rsnew["status"] = 3;
				$rsnew["initiator_action"] = 1;
				$rsnew["recommender_action"] = NULL;
				$rsnew["recommender_comments"] = NULL;
				$rsnew["approver_action"] = NULL;
				$rsnew["approver_comments"] = NULL;	
				$this->setSuccessMessage("&#x25C9; Record sent for Recommedation Action by (Dept. Suppervisor) &#x2714;"); 					
			}

			// Saved only
			if ($this->initiator_action->CurrentValue == 0) {
				$rsnew["status"] = 0;			
				$rsnew["initiator_action"] = 0; 
				$this->setSuccessMessage("&#x25C9; Record has been saved &#x2714;");
			}			
		}			
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
		//$rsnew["last_updated_date"] = ew_CurrentDateTime();
		// Initiator Only

		if (CurrentPageID() == "edit" && CurrentUserLevel() == 1) {

			// Save and forward
			if ($this->initiator_action->CurrentValue == 1) {
				$rsnew["last_updated_date"] = ew_CurrentDateTime();
				$rsnew["status"] = 3;
				$rsnew["initiator_action"] = 1;

				//$rsnew["recommender_action"] = NULL;
				//$rsnew["recommender_comments"] = NULL;
				//$rsnew["approver_action"] = NULL;
				//$rsnew["approver_comments"] = NULL;				

				$this->setSuccessMessage("&#x25C9; Record sent for Recommedation Action by (Dept. Supervisor) &#x2714;"); 					
			}

			// Saved only
			if ($this->initiator_action->CurrentValue == 0) {
				$rsnew["status"] = 0;			
				$rsnew["initiator_action"] = 0; 
				$this->setSuccessMessage("&#x25C9; Record has been saved &#x2714;");
			}			
		}

		// Recommender Only
		if (CurrentPageID() == "edit" && CurrentUserLevel() == 2){
		   if ($this->recommender_action->CurrentValue == 1) {
		   		$rsnew["last_updated_date"] = ew_CurrentDateTime();
				$rsnew["status"] = 1;
				$rsnew["recommender_action"] = 1;

				//$rsnew["recommender_action"] = NULL;
				//$rsnew["recommender_comments"] = NULL;

				$rsnew["approver_action"] = NULL;
				$rsnew["approver_comments"] = NULL;				
				$this->setSuccessMessage("&#x25C9; Record sent back for Rework &#x2714;"); 					
			}
			if ($this->recommender_action->CurrentValue == 2) {
				$rsnew["last_updated_date"] = ew_CurrentDateTime();
				$rsnew["status"] = 4;
				$rsnew["recommender_action"] = 2;

				//$rsnew["recommender_action"] = NULL;
				//$rsnew["recommender_comments"] = NULL;

				$rsnew["approver_action"] = NULL;
				$rsnew["approver_comments"] = NULL;				
				$this->setSuccessMessage("&#x25C9; Record Have been sent For Approver &#x2714;"); 					
			}
		}

		// Approver Only
		if (CurrentPageID() == "edit" && CurrentUserLevel() == 3){
		   if ($this->approver_action->CurrentValue == 0) {
		   		$rsnew["last_updated_date"] = ew_CurrentDateTime();
				$rsnew["status"] = 2;
				$rsnew["approver_action"] = 0;

				//$rsnew["recommender_action"] = NULL;
				//$rsnew["recommender_comments"] = NULL;
				//$rsnew["approver_action"] = NULL;
				//$rsnew["approver_comments"] = NULL;				

				$this->setSuccessMessage("&#x25C9; Record Has been Decline &#x2714;"); 					
			}
			if ($this->approver_action->CurrentValue == 1) {
				$rsnew["last_updated_date"] = ew_CurrentDateTime();
				$rsnew["status"] = 5;
				$rsnew["approver_action"] = 1;

				//$rsnew["recommender_action"] = NULL;
				//$rsnew["recommender_comments"] = NULL;
				//$rsnew["approver_action"] = NULL;
				//$rsnew["approver_comments"] = NULL;				

				$this->setSuccessMessage("&#x25C9; Record  Have been Approved Successfully &#x2714;"); 					
			}
		}
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
		//$this->date->ReadOnly = TRUE;
		//$this->time->ReadOnly = TRUE;
		// CurrentUserName(),CurrentUserID(),CurrentParentUserID(),CurrentUserLevel(),
		// ew_CurrentUserIP(),ew_CurrentDate(),ew_CurrentTime(),ew_CurrentDateTime()
			//date("d/m/Y"); ew_FormatDateTime(ew_CurrentDate(), 7);
			//$this->tran_date->EditValue = $this->tran_date->CurrentValue;
			//$this->tran_time->CurrentValue = ftime(date("H:i:s"),12);

		if ((CurrentPageID() == "add" && (CurrentUserLevel() == 1)) || (CurrentPageID() == "add" && (CurrentUserLevel() == 2)) || (CurrentPageID() == "add" && (CurrentUserLevel() == 3))){
			date_default_timezone_set('Africa/Lagos');
			$now = new DateTime();

			//$this->datetime_initiated->CurrentValue = $now->Format('Y-m-d H:i:s');
			//$this->datetime_initiated->EditValue = $this->datetime_initiated->CurrentValue;

			$this->date_created->CurrentValue = $now->Format('Y-m-d H:i:s');
			$this->date_created->EditValue = $this->date_created->CurrentValue;

			//$this->last_updated_date->CurrentValue = $now->Format('Y-m-d H:i:s');
			//$this->last_updated_date->EditValue = $this->last_updated_date->CurrentValue;

			$this->time->CurrentValue = ew_FormatDateTime(ew_CurrentTime(), 3);
			$this->time->EditValue = $this->time->CurrentValue;

			//$this->time->CurrentValue = $now->Format('Y-m-d H:i:s');
			//$this->time->EditValue = $this->time->CurrentValue;

			$this->leave_id->CurrentValue = $_SESSION['Leave_ID'];
			$this->leave_id->EditValue = $this->leave_id->CurrentValue;
			$this->staff_id->CurrentValue = $_SESSION['Staff_ID'];
			$this->staff_id->EditValue = $this->staff_id->CurrentValue;
			$this->staff_name->CurrentValue = $_SESSION['Staff_Name'];
			$this->staff_name->EditValue = $this->staff_name->CurrentValue;
			$this->company->CurrentValue = $_SESSION['Company'];
			$this->company->EditValue = $this->company->CurrentValue;
			$this->department->CurrentValue = $_SESSION['Department'];
			$this->department->EditValue = $this->department->CurrentValue;
		}
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

		if (CurrentPageID() == "add" && CurrentUserLevel() == 1) {
				$this->leave_id->ReadOnly = TRUE;
				$this->date_created->ReadOnly = TRUE;
				$this->time->ReadOnly = TRUE;
				$this->staff_id->ReadOnly = TRUE;
				$this->staff_name->ReadOnly = TRUE;
				$this->company->ReadOnly = TRUE;
				$this->department->ReadOnly = TRUE;
				$this->leave_type->Visible = TRUE;
				$this->start_date->Visible = TRUE;
				$this->end_date->Visible = TRUE;
				$this->no_of_days->ReadOnly = TRUE;
				$this->resumption_date->Visible = TRUE;
				$this->replacement_assign_staff->Visible = TRUE;
				$this->purpose_of_leave->Visible = TRUE;
				$this->status->Visible = FALSE;
				$this->verified_staff->Visible = FALSE;
				$this->verified_replacement_staff->Visible = FALSE;
				$this->recommender_action->Visible = FALSE;
				$this->recommender_comments->Visible = FALSE;
				$this->approver_action->Visible = FALSE;
				$this->approver_comments->Visible = FALSE;
				$this->last_updated_date->Visible = FALSE;
		}
		if (CurrentPageID() == "edit") {
			if (CurrentUserLevel() == 1) {
				$this->leave_id->ReadOnly = TRUE;
				$this->date_created->ReadOnly = TRUE;
				$this->time->ReadOnly = TRUE;
				$this->staff_id->ReadOnly = TRUE;
				$this->staff_name->ReadOnly = TRUE;
				$this->company->ReadOnly = TRUE;
				$this->department->ReadOnly = TRUE;
				$this->leave_type->Visible = TRUE;
				$this->start_date->Visible = TRUE;
				$this->end_date->Visible = TRUE;
				$this->no_of_days->ReadOnly = TRUE;
				$this->resumption_date->Visible = TRUE;
				$this->replacement_assign_staff->Visible = TRUE;
				$this->purpose_of_leave->Visible = TRUE;
				$this->status->Visible = FALSE;
				$this->verified_staff->Visible = FALSE;
				$this->verified_replacement_staff->Visible = FALSE;
				$this->recommender_action->Visible = FALSE;
				$this->recommender_comments->Visible = FALSE;
				$this->approver_action->Visible = FALSE;
				$this->approver_comments->Visible = FALSE;
				$this->last_updated_date->Visible = FALSE;
			}
			if (CurrentUserLevel() == 2 && $this->company->CurrentValue == $_SESSION['Company']) {
				$this->leave_id->ReadOnly = TRUE;
				$this->date_created->ReadOnly = TRUE;
				$this->time->ReadOnly = TRUE;
				$this->staff_id->ReadOnly = TRUE;
				$this->staff_name->ReadOnly = TRUE;
				$this->company->ReadOnly = TRUE;
				$this->department->ReadOnly = TRUE;
				$this->leave_type->ReadOnly = TRUE;
				$this->start_date->ReadOnly = TRUE;
				$this->end_date->ReadOnly = TRUE;
				$this->no_of_days->ReadOnly = TRUE;
				$this->resumption_date->ReadOnly = TRUE;
				$this->replacement_assign_staff->ReadOnly = TRUE;
				$this->purpose_of_leave->ReadOnly = TRUE;
				$this->verified_staff->Visible = TRUE;
				$this->verified_replacement_staff->Visible = TRUE;
				$this->status->ReadOnly = TRUE;
				$this->initiator_action->ReadOnly = TRUE;
				$this->initiator_comments->ReadOnly = TRUE;
				$this->approver_action->Visible = FALSE;
				$this->approver_comments->Visible = FALSE;
				$this->last_updated_date->Visible = FALSE;
			}
			if (CurrentUserLevel() == 3) {
				$this->leave_id->ReadOnly = TRUE;
				$this->date_created->ReadOnly = TRUE;
				$this->time->ReadOnly = TRUE;
				$this->staff_id->ReadOnly = TRUE;
				$this->staff_name->ReadOnly = TRUE;
				$this->company->ReadOnly = TRUE;
				$this->department->ReadOnly = TRUE;
				$this->leave_type->ReadOnly = TRUE;
				$this->start_date->ReadOnly = TRUE;
				$this->end_date->ReadOnly = TRUE;
				$this->no_of_days->ReadOnly = TRUE;
				$this->resumption_date->ReadOnly = TRUE;
				$this->replacement_assign_staff->ReadOnly = TRUE;
				$this->purpose_of_leave->ReadOnly = TRUE;
				$this->verified_staff->ReadOnly = TRUE;
				$this->verified_replacement_staff->ReadOnly = TRUE;
				$this->status->ReadOnly = TRUE;
				$this->initiator_action->ReadOnly = TRUE;
				$this->initiator_comments->ReadOnly = TRUE;
				$this->recommender_action->ReadOnly = TRUE;
				$this->recommender_comments->ReadOnly = TRUE;
				$this->last_updated_date->Visible = FALSE;
			}
		}

		// Highligh rows in color based on the status
		if (CurrentPageID() == "list") {	

			//$this->branch_code->Visible = FALSE;
			// Status on saveonly color is blue

			if ($this->status->CurrentValue == 0) {
				$this->date_created->CellCssStyle = "color: blue; text-align: left;";
				$this->time->CellCssStyle = "color: blue; text-align: left;";
				$this->leave_id->CellCssStyle = "color: blue; text-align: left;";
				$this->staff_id->CellCssStyle = "color: blue; text-align: left;";
				$this->staff_name->CellCssStyle = "color: blue; text-align: left;";
				$this->company->CellCssStyle = "color: blue; text-align: left;";
				$this->department->CellCssStyle = "color: blue; text-align: left;";
				$this->leave_type->CellCssStyle = "color: blue; text-align: left;";
				$this->start_date->CellCssStyle = "color: blue; text-align: left;";
				$this->end_date->CellCssStyle = "color: blue; text-align: left;";
				$this->no_of_days->CellCssStyle = "color: blue; text-align: left;";
				$this->replacement_assign_staff->CellCssStyle = "color: blue; text-align: left;";
				$this->resumption_date->CellCssStyle = "color: blue; text-align: left;";
				$this->purpose_of_leave->CellCssStyle = "color: blue; text-align: left;";
				$this->status->CellCssStyle = "color: blue; text-align: left;";
			}

			// Status on Return for Rework color is red
			if ($this->status->CurrentValue == 1 || $this->status->CurrentValue == 2) {
				$this->date_created->CellCssStyle = "color: red; text-align: left;";
				$this->time->CellCssStyle = "color: red; text-align: left;";
				$this->leave_id->CellCssStyle = "color: red; text-align: left;";
				$this->staff_id->CellCssStyle = "color: red; text-align: left;";
				$this->staff_name->CellCssStyle = "color: red; text-align: left;";
				$this->company->CellCssStyle = "color: red; text-align: left;";
				$this->department->CellCssStyle = "color: red; text-align: left;";
				$this->leave_type->CellCssStyle = "color: red; text-align: left;";
				$this->start_date->CellCssStyle = "color: red; text-align: left;";
				$this->end_date->CellCssStyle = "color: red; text-align: left;";
				$this->no_of_days->CellCssStyle = "color: red; text-align: left;";
				$this->replacement_assign_staff->CellCssStyle = "color: red; text-align: left;";
				$this->resumption_date->CellCssStyle = "color: red; text-align: left;";
				$this->purpose_of_leave->CellCssStyle = "color: red; text-align: left;";
				$this->status->CellCssStyle = "color: red; text-align: left;";
			}

			// Status on Forward for Recommendation color is orange
			if ($this->status->CurrentValue == 3) {
				$this->date_created->CellCssStyle = "color: orange; text-align: left;";
				$this->time->CellCssStyle = "color: orange; text-align: left;";
				$this->leave_id->CellCssStyle = "color: orange; text-align: left;";
				$this->staff_id->CellCssStyle = "color: orange; text-align: left;";
				$this->staff_name->CellCssStyle = "color: orange; text-align: left;";
				$this->company->CellCssStyle = "color: orange; text-align: left;";
				$this->department->CellCssStyle = "color: orange; text-align: left;";
				$this->leave_type->CellCssStyle = "color: orange; text-align: left;";
				$this->start_date->CellCssStyle = "color: orange; text-align: left;";
				$this->end_date->CellCssStyle = "color: orange; text-align: left;";
				$this->no_of_days->CellCssStyle = "color: orange; text-align: left;";
				$this->replacement_assign_staff->CellCssStyle = "color: orange; text-align: left;";
				$this->resumption_date->CellCssStyle = "color: orange; text-align: left;";
				$this->purpose_of_leave->CellCssStyle = "color: orange; text-align: left;";
				$this->status->CellCssStyle = "color: orange; text-align: left;";
			}

			// Status on Awaiting Approver color is green
			if ($this->status->CurrentValue == 4) {
				$this->date_created->CellCssStyle = "color: green; text-align: left;";
				$this->time->CellCssStyle = "color: green; text-align: left;";
				$this->leave_id->CellCssStyle = "color: green; text-align: left;";
				$this->staff_id->CellCssStyle = "color: green; text-align: left;";
				$this->staff_name->CellCssStyle = "color: green; text-align: left;";
				$this->company->CellCssStyle = "color: green; text-align: left;";
				$this->department->CellCssStyle = "color: green; text-align: left;";
				$this->leave_type->CellCssStyle = "color: green; text-align: left;";
				$this->start_date->CellCssStyle = "color: green; text-align: left;";
				$this->end_date->CellCssStyle = "color: green; text-align: left;";
				$this->no_of_days->CellCssStyle = "color: green; text-align: left;";
				$this->replacement_assign_staff->CellCssStyle = "color: green; text-align: left;";
				$this->resumption_date->CellCssStyle = "color: green; text-align: left;";
				$this->purpose_of_leave->CellCssStyle = "color: green; text-align: left;";
				$this->status->CellCssStyle = "color: green; text-align: left;";
			}
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
