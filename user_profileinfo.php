<?php

// Global variable for table object
$user_profile = NULL;

//
// Table class for user_profile
//
class cuser_profile extends cTable {
	var $id;
	var $staff_id;
	var $last_name;
	var $first_name;
	var $_email;
	var $gender;
	var $marital_status;
	var $date_of_birth;
	var $username;
	var $mobile;
	var $company;
	var $department;
	var $home_address;
	var $town_city;
	var $state_origin;
	var $local_gra;
	var $next_kin;
	var $resident_nxt_kin;
	var $nearest_bus_stop;
	var $town_city_nxt_kin;
	var $email_nxt_kin;
	var $phone_nxt_kin;
	var $qualification_level;
	var $qualification_grade;
	var $upload_of_credentcial;
	var $password;
	var $accesslevel;
	var $status;
	var $profile;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'user_profile';
		$this->TableName = 'user_profile';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`user_profile`";
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
		$this->id = new cField('user_profile', 'user_profile', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// staff_id
		$this->staff_id = new cField('user_profile', 'user_profile', 'x_staff_id', 'staff_id', '`staff_id`', '`staff_id`', 16, -1, FALSE, '`staff_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->staff_id->Sortable = TRUE; // Allow sort
		$this->staff_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['staff_id'] = &$this->staff_id;

		// last_name
		$this->last_name = new cField('user_profile', 'user_profile', 'x_last_name', 'last_name', '`last_name`', '`last_name`', 200, -1, FALSE, '`last_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_name->Sortable = TRUE; // Allow sort
		$this->fields['last_name'] = &$this->last_name;

		// first_name
		$this->first_name = new cField('user_profile', 'user_profile', 'x_first_name', 'first_name', '`first_name`', '`first_name`', 200, -1, FALSE, '`first_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->first_name->Sortable = TRUE; // Allow sort
		$this->fields['first_name'] = &$this->first_name;

		// email
		$this->_email = new cField('user_profile', 'user_profile', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_email->Sortable = TRUE; // Allow sort
		$this->fields['email'] = &$this->_email;

		// gender
		$this->gender = new cField('user_profile', 'user_profile', 'x_gender', 'gender', '`gender`', '`gender`', 200, -1, FALSE, '`gender`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->gender->Sortable = TRUE; // Allow sort
		$this->gender->OptionCount = 2;
		$this->fields['gender'] = &$this->gender;

		// marital_status
		$this->marital_status = new cField('user_profile', 'user_profile', 'x_marital_status', 'marital_status', '`marital_status`', '`marital_status`', 200, -1, FALSE, '`marital_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->marital_status->Sortable = TRUE; // Allow sort
		$this->marital_status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->marital_status->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->marital_status->OptionCount = 5;
		$this->fields['marital_status'] = &$this->marital_status;

		// date_of_birth
		$this->date_of_birth = new cField('user_profile', 'user_profile', 'x_date_of_birth', 'date_of_birth', '`date_of_birth`', ew_CastDateFieldForLike('`date_of_birth`', 7, "DB"), 133, 7, FALSE, '`date_of_birth`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->date_of_birth->Sortable = TRUE; // Allow sort
		$this->date_of_birth->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['date_of_birth'] = &$this->date_of_birth;

		// username
		$this->username = new cField('user_profile', 'user_profile', 'x_username', 'username', '`username`', '`username`', 200, -1, FALSE, '`username`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->username->Sortable = TRUE; // Allow sort
		$this->fields['username'] = &$this->username;

		// mobile
		$this->mobile = new cField('user_profile', 'user_profile', 'x_mobile', 'mobile', '`mobile`', '`mobile`', 200, -1, FALSE, '`mobile`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->mobile->Sortable = TRUE; // Allow sort
		$this->fields['mobile'] = &$this->mobile;

		// company
		$this->company = new cField('user_profile', 'user_profile', 'x_company', 'company', '`company`', '`company`', 200, -1, FALSE, '`company`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->company->Sortable = TRUE; // Allow sort
		$this->company->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->company->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->company->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['company'] = &$this->company;

		// department
		$this->department = new cField('user_profile', 'user_profile', 'x_department', 'department', '`department`', '`department`', 200, -1, FALSE, '`department`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->department->Sortable = TRUE; // Allow sort
		$this->department->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->department->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->department->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['department'] = &$this->department;

		// home_address
		$this->home_address = new cField('user_profile', 'user_profile', 'x_home_address', 'home_address', '`home_address`', '`home_address`', 200, -1, FALSE, '`home_address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->home_address->Sortable = TRUE; // Allow sort
		$this->fields['home_address'] = &$this->home_address;

		// town_city
		$this->town_city = new cField('user_profile', 'user_profile', 'x_town_city', 'town_city', '`town_city`', '`town_city`', 200, -1, FALSE, '`town_city`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->town_city->Sortable = TRUE; // Allow sort
		$this->town_city->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->town_city->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['town_city'] = &$this->town_city;

		// state_origin
		$this->state_origin = new cField('user_profile', 'user_profile', 'x_state_origin', 'state_origin', '`state_origin`', '`state_origin`', 200, -1, FALSE, '`state_origin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->state_origin->Sortable = TRUE; // Allow sort
		$this->state_origin->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->state_origin->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['state_origin'] = &$this->state_origin;

		// local_gra
		$this->local_gra = new cField('user_profile', 'user_profile', 'x_local_gra', 'local_gra', '`local_gra`', '`local_gra`', 200, -1, FALSE, '`local_gra`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->local_gra->Sortable = TRUE; // Allow sort
		$this->local_gra->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->local_gra->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['local_gra'] = &$this->local_gra;

		// next_kin
		$this->next_kin = new cField('user_profile', 'user_profile', 'x_next_kin', 'next_kin', '`next_kin`', '`next_kin`', 200, -1, FALSE, '`next_kin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->next_kin->Sortable = TRUE; // Allow sort
		$this->fields['next_kin'] = &$this->next_kin;

		// resident_nxt_kin
		$this->resident_nxt_kin = new cField('user_profile', 'user_profile', 'x_resident_nxt_kin', 'resident_nxt_kin', '`resident_nxt_kin`', '`resident_nxt_kin`', 200, -1, FALSE, '`resident_nxt_kin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->resident_nxt_kin->Sortable = TRUE; // Allow sort
		$this->fields['resident_nxt_kin'] = &$this->resident_nxt_kin;

		// nearest_bus_stop
		$this->nearest_bus_stop = new cField('user_profile', 'user_profile', 'x_nearest_bus_stop', 'nearest_bus_stop', '`nearest_bus_stop`', '`nearest_bus_stop`', 200, -1, FALSE, '`nearest_bus_stop`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nearest_bus_stop->Sortable = TRUE; // Allow sort
		$this->fields['nearest_bus_stop'] = &$this->nearest_bus_stop;

		// town_city_nxt_kin
		$this->town_city_nxt_kin = new cField('user_profile', 'user_profile', 'x_town_city_nxt_kin', 'town_city_nxt_kin', '`town_city_nxt_kin`', '`town_city_nxt_kin`', 200, -1, FALSE, '`town_city_nxt_kin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->town_city_nxt_kin->Sortable = TRUE; // Allow sort
		$this->fields['town_city_nxt_kin'] = &$this->town_city_nxt_kin;

		// email_nxt_kin
		$this->email_nxt_kin = new cField('user_profile', 'user_profile', 'x_email_nxt_kin', 'email_nxt_kin', '`email_nxt_kin`', '`email_nxt_kin`', 200, -1, FALSE, '`email_nxt_kin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->email_nxt_kin->Sortable = TRUE; // Allow sort
		$this->fields['email_nxt_kin'] = &$this->email_nxt_kin;

		// phone_nxt_kin
		$this->phone_nxt_kin = new cField('user_profile', 'user_profile', 'x_phone_nxt_kin', 'phone_nxt_kin', '`phone_nxt_kin`', '`phone_nxt_kin`', 200, -1, FALSE, '`phone_nxt_kin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->phone_nxt_kin->Sortable = TRUE; // Allow sort
		$this->fields['phone_nxt_kin'] = &$this->phone_nxt_kin;

		// qualification_level
		$this->qualification_level = new cField('user_profile', 'user_profile', 'x_qualification_level', 'qualification_level', '`qualification_level`', '`qualification_level`', 200, -1, FALSE, '`qualification_level`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->qualification_level->Sortable = TRUE; // Allow sort
		$this->qualification_level->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->qualification_level->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->qualification_level->OptionCount = 11;
		$this->fields['qualification_level'] = &$this->qualification_level;

		// qualification_grade
		$this->qualification_grade = new cField('user_profile', 'user_profile', 'x_qualification_grade', 'qualification_grade', '`qualification_grade`', '`qualification_grade`', 200, -1, FALSE, '`qualification_grade`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->qualification_grade->Sortable = TRUE; // Allow sort
		$this->qualification_grade->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->qualification_grade->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->qualification_grade->OptionCount = 10;
		$this->fields['qualification_grade'] = &$this->qualification_grade;

		// upload_of_credentcial
		$this->upload_of_credentcial = new cField('user_profile', 'user_profile', 'x_upload_of_credentcial', 'upload_of_credentcial', '`upload_of_credentcial`', '`upload_of_credentcial`', 200, -1, TRUE, '`upload_of_credentcial`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->upload_of_credentcial->Sortable = TRUE; // Allow sort
		$this->fields['upload_of_credentcial'] = &$this->upload_of_credentcial;

		// password
		$this->password = new cField('user_profile', 'user_profile', 'x_password', 'password', '`password`', '`password`', 200, -1, FALSE, '`password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'PASSWORD');
		$this->password->Sortable = TRUE; // Allow sort
		$this->fields['password'] = &$this->password;

		// accesslevel
		$this->accesslevel = new cField('user_profile', 'user_profile', 'x_accesslevel', 'accesslevel', '`accesslevel`', '`accesslevel`', 3, -1, FALSE, '`accesslevel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->accesslevel->Sortable = TRUE; // Allow sort
		$this->accesslevel->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->accesslevel->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->accesslevel->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['accesslevel'] = &$this->accesslevel;

		// status
		$this->status = new cField('user_profile', 'user_profile', 'x_status', 'status', '`status`', '`status`', 3, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->OptionCount = 2;
		$this->status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status'] = &$this->status;

		// profile
		$this->profile = new cField('user_profile', 'user_profile', 'x_profile', 'profile', '`profile`', '`profile`', 201, -1, FALSE, '`profile`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->profile->Sortable = TRUE; // Allow sort
		$this->fields['profile'] = &$this->profile;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`user_profile`";
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
		global $Security;

		// Add User ID filter
		if ($Security->CurrentUserID() <> "" && !$Security->IsAdmin()) { // Non system admin
			$sFilter = $this->AddUserIDFilter($sFilter);
		}
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = $this->UserIDAllowSecurity;
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'password')
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'password') {
				if ($value == $this->fields[$name]->OldValue) // No need to update hashed password if not changed
					continue;
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
			}
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
			return "user_profilelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "user_profileview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "user_profileedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "user_profileadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "user_profilelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("user_profileview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("user_profileview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "user_profileadd.php?" . $this->UrlParm($parm);
		else
			$url = "user_profileadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("user_profileedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("user_profileadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("user_profiledelete.php", $this->UrlParm());
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
		$this->staff_id->setDbValue($rs->fields('staff_id'));
		$this->last_name->setDbValue($rs->fields('last_name'));
		$this->first_name->setDbValue($rs->fields('first_name'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->marital_status->setDbValue($rs->fields('marital_status'));
		$this->date_of_birth->setDbValue($rs->fields('date_of_birth'));
		$this->username->setDbValue($rs->fields('username'));
		$this->mobile->setDbValue($rs->fields('mobile'));
		$this->company->setDbValue($rs->fields('company'));
		$this->department->setDbValue($rs->fields('department'));
		$this->home_address->setDbValue($rs->fields('home_address'));
		$this->town_city->setDbValue($rs->fields('town_city'));
		$this->state_origin->setDbValue($rs->fields('state_origin'));
		$this->local_gra->setDbValue($rs->fields('local_gra'));
		$this->next_kin->setDbValue($rs->fields('next_kin'));
		$this->resident_nxt_kin->setDbValue($rs->fields('resident_nxt_kin'));
		$this->nearest_bus_stop->setDbValue($rs->fields('nearest_bus_stop'));
		$this->town_city_nxt_kin->setDbValue($rs->fields('town_city_nxt_kin'));
		$this->email_nxt_kin->setDbValue($rs->fields('email_nxt_kin'));
		$this->phone_nxt_kin->setDbValue($rs->fields('phone_nxt_kin'));
		$this->qualification_level->setDbValue($rs->fields('qualification_level'));
		$this->qualification_grade->setDbValue($rs->fields('qualification_grade'));
		$this->upload_of_credentcial->Upload->DbValue = $rs->fields('upload_of_credentcial');
		$this->password->setDbValue($rs->fields('password'));
		$this->accesslevel->setDbValue($rs->fields('accesslevel'));
		$this->status->setDbValue($rs->fields('status'));
		$this->profile->setDbValue($rs->fields('profile'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
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

		// staff_id
		$this->staff_id->EditAttrs["class"] = "form-control";
		$this->staff_id->EditCustomAttributes = "";
		if (!$Security->IsAdmin() && $Security->IsLoggedIn() && !$this->UserIDAllow("info")) { // Non system admin
			$this->staff_id->CurrentValue = CurrentUserID();
		$this->staff_id->EditValue = $this->staff_id->CurrentValue;
		$this->staff_id->ViewCustomAttributes = "";
		} else {
		$this->staff_id->EditValue = $this->staff_id->CurrentValue;
		$this->staff_id->PlaceHolder = ew_RemoveHtml($this->staff_id->FldCaption());
		}

		// last_name
		$this->last_name->EditAttrs["class"] = "form-control";
		$this->last_name->EditCustomAttributes = "";
		$this->last_name->EditValue = $this->last_name->CurrentValue;
		$this->last_name->PlaceHolder = ew_RemoveHtml($this->last_name->FldCaption());

		// first_name
		$this->first_name->EditAttrs["class"] = "form-control";
		$this->first_name->EditCustomAttributes = "";
		$this->first_name->EditValue = $this->first_name->CurrentValue;
		$this->first_name->PlaceHolder = ew_RemoveHtml($this->first_name->FldCaption());

		// email
		$this->_email->EditAttrs["class"] = "form-control";
		$this->_email->EditCustomAttributes = "";
		$this->_email->EditValue = $this->_email->CurrentValue;
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
		$this->date_of_birth->EditValue = ew_FormatDateTime($this->date_of_birth->CurrentValue, 7);
		$this->date_of_birth->PlaceHolder = ew_RemoveHtml($this->date_of_birth->FldCaption());

		// username
		$this->username->EditAttrs["class"] = "form-control";
		$this->username->EditCustomAttributes = "";
		$this->username->EditValue = $this->username->CurrentValue;
		$this->username->PlaceHolder = ew_RemoveHtml($this->username->FldCaption());

		// mobile
		$this->mobile->EditAttrs["class"] = "form-control";
		$this->mobile->EditCustomAttributes = "";
		$this->mobile->EditValue = $this->mobile->CurrentValue;
		$this->mobile->PlaceHolder = ew_RemoveHtml($this->mobile->FldCaption());

		// company
		$this->company->EditAttrs["class"] = "form-control";
		$this->company->EditCustomAttributes = "";

		// department
		$this->department->EditAttrs["class"] = "form-control";
		$this->department->EditCustomAttributes = "";

		// home_address
		$this->home_address->EditAttrs["class"] = "form-control";
		$this->home_address->EditCustomAttributes = "";
		$this->home_address->EditValue = $this->home_address->CurrentValue;
		$this->home_address->PlaceHolder = ew_RemoveHtml($this->home_address->FldCaption());

		// town_city
		$this->town_city->EditAttrs["class"] = "form-control";
		$this->town_city->EditCustomAttributes = "";

		// state_origin
		$this->state_origin->EditAttrs["class"] = "form-control";
		$this->state_origin->EditCustomAttributes = "";

		// local_gra
		$this->local_gra->EditAttrs["class"] = "form-control";
		$this->local_gra->EditCustomAttributes = "";

		// next_kin
		$this->next_kin->EditAttrs["class"] = "form-control";
		$this->next_kin->EditCustomAttributes = "";
		$this->next_kin->EditValue = $this->next_kin->CurrentValue;
		$this->next_kin->PlaceHolder = ew_RemoveHtml($this->next_kin->FldCaption());

		// resident_nxt_kin
		$this->resident_nxt_kin->EditAttrs["class"] = "form-control";
		$this->resident_nxt_kin->EditCustomAttributes = "";
		$this->resident_nxt_kin->EditValue = $this->resident_nxt_kin->CurrentValue;
		$this->resident_nxt_kin->PlaceHolder = ew_RemoveHtml($this->resident_nxt_kin->FldCaption());

		// nearest_bus_stop
		$this->nearest_bus_stop->EditAttrs["class"] = "form-control";
		$this->nearest_bus_stop->EditCustomAttributes = "";
		$this->nearest_bus_stop->EditValue = $this->nearest_bus_stop->CurrentValue;
		$this->nearest_bus_stop->PlaceHolder = ew_RemoveHtml($this->nearest_bus_stop->FldCaption());

		// town_city_nxt_kin
		$this->town_city_nxt_kin->EditAttrs["class"] = "form-control";
		$this->town_city_nxt_kin->EditCustomAttributes = "";
		$this->town_city_nxt_kin->EditValue = $this->town_city_nxt_kin->CurrentValue;
		$this->town_city_nxt_kin->PlaceHolder = ew_RemoveHtml($this->town_city_nxt_kin->FldCaption());

		// email_nxt_kin
		$this->email_nxt_kin->EditAttrs["class"] = "form-control";
		$this->email_nxt_kin->EditCustomAttributes = "";
		$this->email_nxt_kin->EditValue = $this->email_nxt_kin->CurrentValue;
		$this->email_nxt_kin->PlaceHolder = ew_RemoveHtml($this->email_nxt_kin->FldCaption());

		// phone_nxt_kin
		$this->phone_nxt_kin->EditAttrs["class"] = "form-control";
		$this->phone_nxt_kin->EditCustomAttributes = "";
		$this->phone_nxt_kin->EditValue = $this->phone_nxt_kin->CurrentValue;
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

		// password
		$this->password->EditAttrs["class"] = "form-control";
		$this->password->EditCustomAttributes = "";
		$this->password->EditValue = $this->password->CurrentValue;
		$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

		// accesslevel
		$this->accesslevel->EditAttrs["class"] = "form-control";
		$this->accesslevel->EditCustomAttributes = "";
		if (!$Security->CanAdmin()) { // System admin
			$this->accesslevel->EditValue = $Language->Phrase("PasswordMask");
		} else {
		}

		// status
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->Options(FALSE);

		// profile
		$this->profile->EditAttrs["class"] = "form-control";
		$this->profile->EditCustomAttributes = "";
		$this->profile->EditValue = $this->profile->CurrentValue;
		$this->profile->PlaceHolder = ew_RemoveHtml($this->profile->FldCaption());

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
					if ($this->staff_id->Exportable) $Doc->ExportCaption($this->staff_id);
					if ($this->last_name->Exportable) $Doc->ExportCaption($this->last_name);
					if ($this->first_name->Exportable) $Doc->ExportCaption($this->first_name);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
					if ($this->marital_status->Exportable) $Doc->ExportCaption($this->marital_status);
					if ($this->date_of_birth->Exportable) $Doc->ExportCaption($this->date_of_birth);
					if ($this->username->Exportable) $Doc->ExportCaption($this->username);
					if ($this->mobile->Exportable) $Doc->ExportCaption($this->mobile);
					if ($this->company->Exportable) $Doc->ExportCaption($this->company);
					if ($this->department->Exportable) $Doc->ExportCaption($this->department);
					if ($this->home_address->Exportable) $Doc->ExportCaption($this->home_address);
					if ($this->town_city->Exportable) $Doc->ExportCaption($this->town_city);
					if ($this->state_origin->Exportable) $Doc->ExportCaption($this->state_origin);
					if ($this->local_gra->Exportable) $Doc->ExportCaption($this->local_gra);
					if ($this->next_kin->Exportable) $Doc->ExportCaption($this->next_kin);
					if ($this->resident_nxt_kin->Exportable) $Doc->ExportCaption($this->resident_nxt_kin);
					if ($this->nearest_bus_stop->Exportable) $Doc->ExportCaption($this->nearest_bus_stop);
					if ($this->town_city_nxt_kin->Exportable) $Doc->ExportCaption($this->town_city_nxt_kin);
					if ($this->email_nxt_kin->Exportable) $Doc->ExportCaption($this->email_nxt_kin);
					if ($this->phone_nxt_kin->Exportable) $Doc->ExportCaption($this->phone_nxt_kin);
					if ($this->qualification_level->Exportable) $Doc->ExportCaption($this->qualification_level);
					if ($this->qualification_grade->Exportable) $Doc->ExportCaption($this->qualification_grade);
					if ($this->upload_of_credentcial->Exportable) $Doc->ExportCaption($this->upload_of_credentcial);
					if ($this->password->Exportable) $Doc->ExportCaption($this->password);
					if ($this->accesslevel->Exportable) $Doc->ExportCaption($this->accesslevel);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->profile->Exportable) $Doc->ExportCaption($this->profile);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->staff_id->Exportable) $Doc->ExportCaption($this->staff_id);
					if ($this->last_name->Exportable) $Doc->ExportCaption($this->last_name);
					if ($this->first_name->Exportable) $Doc->ExportCaption($this->first_name);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
					if ($this->marital_status->Exportable) $Doc->ExportCaption($this->marital_status);
					if ($this->date_of_birth->Exportable) $Doc->ExportCaption($this->date_of_birth);
					if ($this->username->Exportable) $Doc->ExportCaption($this->username);
					if ($this->mobile->Exportable) $Doc->ExportCaption($this->mobile);
					if ($this->company->Exportable) $Doc->ExportCaption($this->company);
					if ($this->department->Exportable) $Doc->ExportCaption($this->department);
					if ($this->home_address->Exportable) $Doc->ExportCaption($this->home_address);
					if ($this->town_city->Exportable) $Doc->ExportCaption($this->town_city);
					if ($this->state_origin->Exportable) $Doc->ExportCaption($this->state_origin);
					if ($this->local_gra->Exportable) $Doc->ExportCaption($this->local_gra);
					if ($this->next_kin->Exportable) $Doc->ExportCaption($this->next_kin);
					if ($this->resident_nxt_kin->Exportable) $Doc->ExportCaption($this->resident_nxt_kin);
					if ($this->nearest_bus_stop->Exportable) $Doc->ExportCaption($this->nearest_bus_stop);
					if ($this->town_city_nxt_kin->Exportable) $Doc->ExportCaption($this->town_city_nxt_kin);
					if ($this->email_nxt_kin->Exportable) $Doc->ExportCaption($this->email_nxt_kin);
					if ($this->phone_nxt_kin->Exportable) $Doc->ExportCaption($this->phone_nxt_kin);
					if ($this->qualification_level->Exportable) $Doc->ExportCaption($this->qualification_level);
					if ($this->qualification_grade->Exportable) $Doc->ExportCaption($this->qualification_grade);
					if ($this->upload_of_credentcial->Exportable) $Doc->ExportCaption($this->upload_of_credentcial);
					if ($this->password->Exportable) $Doc->ExportCaption($this->password);
					if ($this->accesslevel->Exportable) $Doc->ExportCaption($this->accesslevel);
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
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->staff_id->Exportable) $Doc->ExportField($this->staff_id);
						if ($this->last_name->Exportable) $Doc->ExportField($this->last_name);
						if ($this->first_name->Exportable) $Doc->ExportField($this->first_name);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->gender->Exportable) $Doc->ExportField($this->gender);
						if ($this->marital_status->Exportable) $Doc->ExportField($this->marital_status);
						if ($this->date_of_birth->Exportable) $Doc->ExportField($this->date_of_birth);
						if ($this->username->Exportable) $Doc->ExportField($this->username);
						if ($this->mobile->Exportable) $Doc->ExportField($this->mobile);
						if ($this->company->Exportable) $Doc->ExportField($this->company);
						if ($this->department->Exportable) $Doc->ExportField($this->department);
						if ($this->home_address->Exportable) $Doc->ExportField($this->home_address);
						if ($this->town_city->Exportable) $Doc->ExportField($this->town_city);
						if ($this->state_origin->Exportable) $Doc->ExportField($this->state_origin);
						if ($this->local_gra->Exportable) $Doc->ExportField($this->local_gra);
						if ($this->next_kin->Exportable) $Doc->ExportField($this->next_kin);
						if ($this->resident_nxt_kin->Exportable) $Doc->ExportField($this->resident_nxt_kin);
						if ($this->nearest_bus_stop->Exportable) $Doc->ExportField($this->nearest_bus_stop);
						if ($this->town_city_nxt_kin->Exportable) $Doc->ExportField($this->town_city_nxt_kin);
						if ($this->email_nxt_kin->Exportable) $Doc->ExportField($this->email_nxt_kin);
						if ($this->phone_nxt_kin->Exportable) $Doc->ExportField($this->phone_nxt_kin);
						if ($this->qualification_level->Exportable) $Doc->ExportField($this->qualification_level);
						if ($this->qualification_grade->Exportable) $Doc->ExportField($this->qualification_grade);
						if ($this->upload_of_credentcial->Exportable) $Doc->ExportField($this->upload_of_credentcial);
						if ($this->password->Exportable) $Doc->ExportField($this->password);
						if ($this->accesslevel->Exportable) $Doc->ExportField($this->accesslevel);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->profile->Exportable) $Doc->ExportField($this->profile);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->staff_id->Exportable) $Doc->ExportField($this->staff_id);
						if ($this->last_name->Exportable) $Doc->ExportField($this->last_name);
						if ($this->first_name->Exportable) $Doc->ExportField($this->first_name);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->gender->Exportable) $Doc->ExportField($this->gender);
						if ($this->marital_status->Exportable) $Doc->ExportField($this->marital_status);
						if ($this->date_of_birth->Exportable) $Doc->ExportField($this->date_of_birth);
						if ($this->username->Exportable) $Doc->ExportField($this->username);
						if ($this->mobile->Exportable) $Doc->ExportField($this->mobile);
						if ($this->company->Exportable) $Doc->ExportField($this->company);
						if ($this->department->Exportable) $Doc->ExportField($this->department);
						if ($this->home_address->Exportable) $Doc->ExportField($this->home_address);
						if ($this->town_city->Exportable) $Doc->ExportField($this->town_city);
						if ($this->state_origin->Exportable) $Doc->ExportField($this->state_origin);
						if ($this->local_gra->Exportable) $Doc->ExportField($this->local_gra);
						if ($this->next_kin->Exportable) $Doc->ExportField($this->next_kin);
						if ($this->resident_nxt_kin->Exportable) $Doc->ExportField($this->resident_nxt_kin);
						if ($this->nearest_bus_stop->Exportable) $Doc->ExportField($this->nearest_bus_stop);
						if ($this->town_city_nxt_kin->Exportable) $Doc->ExportField($this->town_city_nxt_kin);
						if ($this->email_nxt_kin->Exportable) $Doc->ExportField($this->email_nxt_kin);
						if ($this->phone_nxt_kin->Exportable) $Doc->ExportField($this->phone_nxt_kin);
						if ($this->qualification_level->Exportable) $Doc->ExportField($this->qualification_level);
						if ($this->qualification_grade->Exportable) $Doc->ExportField($this->qualification_grade);
						if ($this->upload_of_credentcial->Exportable) $Doc->ExportField($this->upload_of_credentcial);
						if ($this->password->Exportable) $Doc->ExportField($this->password);
						if ($this->accesslevel->Exportable) $Doc->ExportField($this->accesslevel);
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

	// User ID filter
	function UserIDFilter($userid) {
		$sUserIDFilter = '`staff_id` = ' . ew_QuotedValue($userid, EW_DATATYPE_NUMBER, EW_USER_TABLE_DBID);
		return $sUserIDFilter;
	}

	// Add User ID filter
	function AddUserIDFilter($sFilter) {
		global $Security;
		$sFilterWrk = "";
		$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->UserIDAllow($id) && !$Security->IsAdmin()) {
			$sFilterWrk = $Security->UserIDList();
			if ($sFilterWrk <> "")
				$sFilterWrk = '`staff_id` IN (' . $sFilterWrk . ')';
		}

		// Call User ID Filtering event
		$this->UserID_Filtering($sFilterWrk);
		ew_AddFilter($sFilter, $sFilterWrk);
		return $sFilter;
	}

	// User ID subquery
	function GetUserIDSubquery(&$fld, &$masterfld) {
		global $UserTableConn;
		$sWrk = "";
		$sSql = "SELECT " . $masterfld->FldExpression . " FROM `user_profile`";
		$sFilter = $this->AddUserIDFilter("");
		if ($sFilter <> "") $sSql .= " WHERE " . $sFilter;

		// Use subquery
		if (EW_USE_SUBQUERY_FOR_MASTER_USER_ID) {
			$sWrk = $sSql;
		} else {

			// List all values
			if ($rs = $UserTableConn->Execute($sSql)) {
				while (!$rs->EOF) {
					if ($sWrk <> "") $sWrk .= ",";
					$sWrk .= ew_QuotedValue($rs->fields[0], $masterfld->FldDataType, EW_USER_TABLE_DBID);
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if ($sWrk <> "") {
			$sWrk = $fld->FldExpression . " IN (" . $sWrk . ")";
		}
		return $sWrk;
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

	// Send register email
	function SendRegisterEmail($row) {
		$Email = $this->PrepareRegisterEmail($row);
		$Args = array();
		$Args["rs"] = $row;
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $Args)) // NOTE: use Email_Sending server event of user table
			$bEmailSent = $Email->Send();
		return $bEmailSent;
	}

	// Prepare register email
	function PrepareRegisterEmail($row = NULL, $langid = "") {
		$Email = new cEmail;
		$Email->Load(EW_EMAIL_REGISTER_TEMPLATE, $langid);
		$sReceiverEmail = ($row == NULL) ? $this->_email->CurrentValue : $row['email'];
		if ($sReceiverEmail == "") { // Send to recipient directly
			$sReceiverEmail = EW_RECIPIENT_EMAIL;
			$sBccEmail = "";
		} else { // Bcc recipient
			$sBccEmail = EW_RECIPIENT_EMAIL;
		}
		$Email->ReplaceSender(EW_SENDER_EMAIL); // Replace Sender
		$Email->ReplaceRecipient($sReceiverEmail); // Replace Recipient
		if ($sBccEmail <> "") $Email->AddBcc($sBccEmail); // Add Bcc
		$Email->ReplaceContent('<!--FieldCaption_staff_id-->', $this->staff_id->FldCaption());
		$Email->ReplaceContent('<!--staff_id-->', ($row == NULL) ? strval($this->staff_id->FormValue) : $row['staff_id']);
		$Email->ReplaceContent('<!--FieldCaption_last_name-->', $this->last_name->FldCaption());
		$Email->ReplaceContent('<!--last_name-->', ($row == NULL) ? strval($this->last_name->FormValue) : $row['last_name']);
		$Email->ReplaceContent('<!--FieldCaption_first_name-->', $this->first_name->FldCaption());
		$Email->ReplaceContent('<!--first_name-->', ($row == NULL) ? strval($this->first_name->FormValue) : $row['first_name']);
		$Email->ReplaceContent('<!--FieldCaption_email-->', $this->_email->FldCaption());
		$Email->ReplaceContent('<!--email-->', ($row == NULL) ? strval($this->_email->FormValue) : $row['email']);
		$Email->ReplaceContent('<!--FieldCaption_gender-->', $this->gender->FldCaption());
		$Email->ReplaceContent('<!--gender-->', ($row == NULL) ? strval($this->gender->FormValue) : $row['gender']);
		$Email->ReplaceContent('<!--FieldCaption_marital_status-->', $this->marital_status->FldCaption());
		$Email->ReplaceContent('<!--marital_status-->', ($row == NULL) ? strval($this->marital_status->FormValue) : $row['marital_status']);
		$Email->ReplaceContent('<!--FieldCaption_date_of_birth-->', $this->date_of_birth->FldCaption());
		$Email->ReplaceContent('<!--date_of_birth-->', ($row == NULL) ? strval($this->date_of_birth->FormValue) : $row['date_of_birth']);
		$Email->ReplaceContent('<!--FieldCaption_username-->', $this->username->FldCaption());
		$Email->ReplaceContent('<!--username-->', ($row == NULL) ? strval($this->username->FormValue) : $row['username']);
		$Email->ReplaceContent('<!--FieldCaption_mobile-->', $this->mobile->FldCaption());
		$Email->ReplaceContent('<!--mobile-->', ($row == NULL) ? strval($this->mobile->FormValue) : $row['mobile']);
		$Email->ReplaceContent('<!--FieldCaption_company-->', $this->company->FldCaption());
		$Email->ReplaceContent('<!--company-->', ($row == NULL) ? strval($this->company->FormValue) : $row['company']);
		$Email->ReplaceContent('<!--FieldCaption_department-->', $this->department->FldCaption());
		$Email->ReplaceContent('<!--department-->', ($row == NULL) ? strval($this->department->FormValue) : $row['department']);
		$Email->ReplaceContent('<!--FieldCaption_home_address-->', $this->home_address->FldCaption());
		$Email->ReplaceContent('<!--home_address-->', ($row == NULL) ? strval($this->home_address->FormValue) : $row['home_address']);
		$Email->ReplaceContent('<!--FieldCaption_town_city-->', $this->town_city->FldCaption());
		$Email->ReplaceContent('<!--town_city-->', ($row == NULL) ? strval($this->town_city->FormValue) : $row['town_city']);
		$Email->ReplaceContent('<!--FieldCaption_state_origin-->', $this->state_origin->FldCaption());
		$Email->ReplaceContent('<!--state_origin-->', ($row == NULL) ? strval($this->state_origin->FormValue) : $row['state_origin']);
		$Email->ReplaceContent('<!--FieldCaption_local_gra-->', $this->local_gra->FldCaption());
		$Email->ReplaceContent('<!--local_gra-->', ($row == NULL) ? strval($this->local_gra->FormValue) : $row['local_gra']);
		$Email->ReplaceContent('<!--FieldCaption_next_kin-->', $this->next_kin->FldCaption());
		$Email->ReplaceContent('<!--next_kin-->', ($row == NULL) ? strval($this->next_kin->FormValue) : $row['next_kin']);
		$Email->ReplaceContent('<!--FieldCaption_resident_nxt_kin-->', $this->resident_nxt_kin->FldCaption());
		$Email->ReplaceContent('<!--resident_nxt_kin-->', ($row == NULL) ? strval($this->resident_nxt_kin->FormValue) : $row['resident_nxt_kin']);
		$Email->ReplaceContent('<!--FieldCaption_nearest_bus_stop-->', $this->nearest_bus_stop->FldCaption());
		$Email->ReplaceContent('<!--nearest_bus_stop-->', ($row == NULL) ? strval($this->nearest_bus_stop->FormValue) : $row['nearest_bus_stop']);
		$Email->ReplaceContent('<!--FieldCaption_town_city_nxt_kin-->', $this->town_city_nxt_kin->FldCaption());
		$Email->ReplaceContent('<!--town_city_nxt_kin-->', ($row == NULL) ? strval($this->town_city_nxt_kin->FormValue) : $row['town_city_nxt_kin']);
		$Email->ReplaceContent('<!--FieldCaption_email_nxt_kin-->', $this->email_nxt_kin->FldCaption());
		$Email->ReplaceContent('<!--email_nxt_kin-->', ($row == NULL) ? strval($this->email_nxt_kin->FormValue) : $row['email_nxt_kin']);
		$Email->ReplaceContent('<!--FieldCaption_phone_nxt_kin-->', $this->phone_nxt_kin->FldCaption());
		$Email->ReplaceContent('<!--phone_nxt_kin-->', ($row == NULL) ? strval($this->phone_nxt_kin->FormValue) : $row['phone_nxt_kin']);
		$Email->ReplaceContent('<!--FieldCaption_qualification_level-->', $this->qualification_level->FldCaption());
		$Email->ReplaceContent('<!--qualification_level-->', ($row == NULL) ? strval($this->qualification_level->FormValue) : $row['qualification_level']);
		$Email->ReplaceContent('<!--FieldCaption_qualification_grade-->', $this->qualification_grade->FldCaption());
		$Email->ReplaceContent('<!--qualification_grade-->', ($row == NULL) ? strval($this->qualification_grade->FormValue) : $row['qualification_grade']);
		$Email->ReplaceContent('<!--FieldCaption_password-->', $this->password->FldCaption());
		$Email->ReplaceContent('<!--password-->', ($row == NULL) ? strval($this->password->FormValue) : $row['password']);
		$sLoginID = ($row == NULL) ? $this->username->CurrentValue : $row['username'];
		$sPassword = ($row == NULL) ? $this->password->FormValue : $row['password'];
		$sActivateLink = ew_FullUrl("register.php", "activate") . "?action=confirm";
		$sActivateLink .= "&email=" . $sReceiverEmail;
		$sToken = ew_Encrypt($sReceiverEmail) . "," . ew_Encrypt($sLoginID) . "," . ew_Encrypt($sPassword);
		$sActivateLink .= "&token=" . $sToken;
		$Email->ReplaceContent("<!--ActivateLink-->", $sActivateLink);
		$Email->Content = preg_replace('/<!--\s*register_activate_link[\s\S]*?-->/i', '', $Email->Content); // Remove comments
		return $Email;
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
