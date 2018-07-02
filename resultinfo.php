<?php

// Global variable for table object
$result = NULL;

//
// Table class for result
//
class cresult extends cTable {
	var $rid;
	var $usn;
	var $name;
	var $sc1;
	var $s1;
	var $sc2;
	var $s2;
	var $sc3;
	var $s3;
	var $sc4;
	var $s4;
	var $sc5;
	var $s5;
	var $sc6;
	var $s6;
	var $sc7;
	var $s7;
	var $sc8;
	var $s8;
	var $total;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'result';
		$this->TableName = 'result';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`result`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// rid
		$this->rid = new cField('result', 'result', 'x_rid', 'rid', '`rid`', '`rid`', 3, -1, FALSE, '`rid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->rid->Sortable = TRUE; // Allow sort
		$this->rid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['rid'] = &$this->rid;

		// usn
		$this->usn = new cField('result', 'result', 'x_usn', 'usn', '`usn`', '`usn`', 200, -1, FALSE, '`usn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->usn->Sortable = TRUE; // Allow sort
		$this->fields['usn'] = &$this->usn;

		// name
		$this->name = new cField('result', 'result', 'x_name', 'name', '`name`', '`name`', 200, -1, FALSE, '`name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->name->Sortable = TRUE; // Allow sort
		$this->fields['name'] = &$this->name;

		// sc1
		$this->sc1 = new cField('result', 'result', 'x_sc1', 'sc1', '`sc1`', '`sc1`', 200, -1, FALSE, '`sc1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sc1->Sortable = TRUE; // Allow sort
		$this->fields['sc1'] = &$this->sc1;

		// s1
		$this->s1 = new cField('result', 'result', 'x_s1', 's1', '`s1`', '`s1`', 3, -1, FALSE, '`s1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s1->Sortable = TRUE; // Allow sort
		$this->s1->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s1'] = &$this->s1;

		// sc2
		$this->sc2 = new cField('result', 'result', 'x_sc2', 'sc2', '`sc2`', '`sc2`', 200, -1, FALSE, '`sc2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sc2->Sortable = TRUE; // Allow sort
		$this->fields['sc2'] = &$this->sc2;

		// s2
		$this->s2 = new cField('result', 'result', 'x_s2', 's2', '`s2`', '`s2`', 3, -1, FALSE, '`s2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s2->Sortable = TRUE; // Allow sort
		$this->s2->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s2'] = &$this->s2;

		// sc3
		$this->sc3 = new cField('result', 'result', 'x_sc3', 'sc3', '`sc3`', '`sc3`', 3, -1, FALSE, '`sc3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sc3->Sortable = TRUE; // Allow sort
		$this->sc3->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sc3'] = &$this->sc3;

		// s3
		$this->s3 = new cField('result', 'result', 'x_s3', 's3', '`s3`', '`s3`', 3, -1, FALSE, '`s3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s3->Sortable = TRUE; // Allow sort
		$this->s3->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s3'] = &$this->s3;

		// sc4
		$this->sc4 = new cField('result', 'result', 'x_sc4', 'sc4', '`sc4`', '`sc4`', 3, -1, FALSE, '`sc4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sc4->Sortable = TRUE; // Allow sort
		$this->sc4->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sc4'] = &$this->sc4;

		// s4
		$this->s4 = new cField('result', 'result', 'x_s4', 's4', '`s4`', '`s4`', 3, -1, FALSE, '`s4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s4->Sortable = TRUE; // Allow sort
		$this->s4->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s4'] = &$this->s4;

		// sc5
		$this->sc5 = new cField('result', 'result', 'x_sc5', 'sc5', '`sc5`', '`sc5`', 3, -1, FALSE, '`sc5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sc5->Sortable = TRUE; // Allow sort
		$this->sc5->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sc5'] = &$this->sc5;

		// s5
		$this->s5 = new cField('result', 'result', 'x_s5', 's5', '`s5`', '`s5`', 3, -1, FALSE, '`s5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s5->Sortable = TRUE; // Allow sort
		$this->s5->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s5'] = &$this->s5;

		// sc6
		$this->sc6 = new cField('result', 'result', 'x_sc6', 'sc6', '`sc6`', '`sc6`', 3, -1, FALSE, '`sc6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sc6->Sortable = TRUE; // Allow sort
		$this->sc6->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sc6'] = &$this->sc6;

		// s6
		$this->s6 = new cField('result', 'result', 'x_s6', 's6', '`s6`', '`s6`', 3, -1, FALSE, '`s6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s6->Sortable = TRUE; // Allow sort
		$this->s6->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s6'] = &$this->s6;

		// sc7
		$this->sc7 = new cField('result', 'result', 'x_sc7', 'sc7', '`sc7`', '`sc7`', 3, -1, FALSE, '`sc7`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sc7->Sortable = TRUE; // Allow sort
		$this->sc7->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sc7'] = &$this->sc7;

		// s7
		$this->s7 = new cField('result', 'result', 'x_s7', 's7', '`s7`', '`s7`', 3, -1, FALSE, '`s7`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s7->Sortable = TRUE; // Allow sort
		$this->s7->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s7'] = &$this->s7;

		// sc8
		$this->sc8 = new cField('result', 'result', 'x_sc8', 'sc8', '`sc8`', '`sc8`', 3, -1, FALSE, '`sc8`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sc8->Sortable = TRUE; // Allow sort
		$this->sc8->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sc8'] = &$this->sc8;

		// s8
		$this->s8 = new cField('result', 'result', 'x_s8', 's8', '`s8`', '`s8`', 3, -1, FALSE, '`s8`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->s8->Sortable = TRUE; // Allow sort
		$this->s8->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['s8'] = &$this->s8;

		// total
		$this->total = new cField('result', 'result', 'x_total', 'total', '`total`', '`total`', 3, -1, FALSE, '`total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->total->Sortable = TRUE; // Allow sort
		$this->total->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['total'] = &$this->total;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`result`";
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
		$sql = ew_BuildSelectSql("SELECT * FROM " . $this->getSqlFrom(), $this->getSqlWhere(), "", "", "", $this->CurrentFilter, "");
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
		$sql = ew_BuildSelectSql("SELECT * FROM " . $this->getSqlFrom(), $this->getSqlWhere(), "", "", "", $filter, "");
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
			$this->rid->setDbValue($conn->Insert_ID());
			$rs['rid'] = $this->rid->DbValue;
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
			if (array_key_exists('rid', $rs))
				ew_AddFilter($where, ew_QuotedName('rid', $this->DBID) . '=' . ew_QuotedValue($rs['rid'], $this->rid->FldDataType, $this->DBID));
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
		return "`rid` = @rid@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->rid->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->rid->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@rid@", ew_AdjustSql($this->rid->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "resultlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "resultview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "resultedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "resultadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "resultlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("resultview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("resultview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "resultadd.php?" . $this->UrlParm($parm);
		else
			$url = "resultadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("resultedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("resultadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("resultdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "rid:" . ew_VarToJson($this->rid->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->rid->CurrentValue)) {
			$sUrl .= "rid=" . urlencode($this->rid->CurrentValue);
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
			if ($isPost && isset($_POST["rid"]))
				$arKeys[] = $_POST["rid"];
			elseif (isset($_GET["rid"]))
				$arKeys[] = $_GET["rid"];
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
			$this->rid->CurrentValue = $key;
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
		$this->rid->setDbValue($rs->fields('rid'));
		$this->usn->setDbValue($rs->fields('usn'));
		$this->name->setDbValue($rs->fields('name'));
		$this->sc1->setDbValue($rs->fields('sc1'));
		$this->s1->setDbValue($rs->fields('s1'));
		$this->sc2->setDbValue($rs->fields('sc2'));
		$this->s2->setDbValue($rs->fields('s2'));
		$this->sc3->setDbValue($rs->fields('sc3'));
		$this->s3->setDbValue($rs->fields('s3'));
		$this->sc4->setDbValue($rs->fields('sc4'));
		$this->s4->setDbValue($rs->fields('s4'));
		$this->sc5->setDbValue($rs->fields('sc5'));
		$this->s5->setDbValue($rs->fields('s5'));
		$this->sc6->setDbValue($rs->fields('sc6'));
		$this->s6->setDbValue($rs->fields('s6'));
		$this->sc7->setDbValue($rs->fields('sc7'));
		$this->s7->setDbValue($rs->fields('s7'));
		$this->sc8->setDbValue($rs->fields('sc8'));
		$this->s8->setDbValue($rs->fields('s8'));
		$this->total->setDbValue($rs->fields('total'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// rid
		// usn
		// name
		// sc1
		// s1
		// sc2
		// s2
		// sc3
		// s3
		// sc4
		// s4
		// sc5
		// s5
		// sc6
		// s6
		// sc7
		// s7
		// sc8
		// s8
		// total
		// rid

		$this->rid->ViewValue = $this->rid->CurrentValue;
		$this->rid->ViewCustomAttributes = "";

		// usn
		$this->usn->ViewValue = $this->usn->CurrentValue;
		$this->usn->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// sc1
		$this->sc1->ViewValue = $this->sc1->CurrentValue;
		$this->sc1->ViewCustomAttributes = "";

		// s1
		$this->s1->ViewValue = $this->s1->CurrentValue;
		$this->s1->ViewCustomAttributes = "";

		// sc2
		$this->sc2->ViewValue = $this->sc2->CurrentValue;
		$this->sc2->ViewCustomAttributes = "";

		// s2
		$this->s2->ViewValue = $this->s2->CurrentValue;
		$this->s2->ViewCustomAttributes = "";

		// sc3
		$this->sc3->ViewValue = $this->sc3->CurrentValue;
		$this->sc3->ViewCustomAttributes = "";

		// s3
		$this->s3->ViewValue = $this->s3->CurrentValue;
		$this->s3->ViewCustomAttributes = "";

		// sc4
		$this->sc4->ViewValue = $this->sc4->CurrentValue;
		$this->sc4->ViewCustomAttributes = "";

		// s4
		$this->s4->ViewValue = $this->s4->CurrentValue;
		$this->s4->ViewCustomAttributes = "";

		// sc5
		$this->sc5->ViewValue = $this->sc5->CurrentValue;
		$this->sc5->ViewCustomAttributes = "";

		// s5
		$this->s5->ViewValue = $this->s5->CurrentValue;
		$this->s5->ViewCustomAttributes = "";

		// sc6
		$this->sc6->ViewValue = $this->sc6->CurrentValue;
		$this->sc6->ViewCustomAttributes = "";

		// s6
		$this->s6->ViewValue = $this->s6->CurrentValue;
		$this->s6->ViewCustomAttributes = "";

		// sc7
		$this->sc7->ViewValue = $this->sc7->CurrentValue;
		$this->sc7->ViewCustomAttributes = "";

		// s7
		$this->s7->ViewValue = $this->s7->CurrentValue;
		$this->s7->ViewCustomAttributes = "";

		// sc8
		$this->sc8->ViewValue = $this->sc8->CurrentValue;
		$this->sc8->ViewCustomAttributes = "";

		// s8
		$this->s8->ViewValue = $this->s8->CurrentValue;
		$this->s8->ViewCustomAttributes = "";

		// total
		$this->total->ViewValue = $this->total->CurrentValue;
		$this->total->ViewCustomAttributes = "";

		// rid
		$this->rid->LinkCustomAttributes = "";
		$this->rid->HrefValue = "";
		$this->rid->TooltipValue = "";

		// usn
		$this->usn->LinkCustomAttributes = "";
		$this->usn->HrefValue = "";
		$this->usn->TooltipValue = "";

		// name
		$this->name->LinkCustomAttributes = "";
		$this->name->HrefValue = "";
		$this->name->TooltipValue = "";

		// sc1
		$this->sc1->LinkCustomAttributes = "";
		$this->sc1->HrefValue = "";
		$this->sc1->TooltipValue = "";

		// s1
		$this->s1->LinkCustomAttributes = "";
		$this->s1->HrefValue = "";
		$this->s1->TooltipValue = "";

		// sc2
		$this->sc2->LinkCustomAttributes = "";
		$this->sc2->HrefValue = "";
		$this->sc2->TooltipValue = "";

		// s2
		$this->s2->LinkCustomAttributes = "";
		$this->s2->HrefValue = "";
		$this->s2->TooltipValue = "";

		// sc3
		$this->sc3->LinkCustomAttributes = "";
		$this->sc3->HrefValue = "";
		$this->sc3->TooltipValue = "";

		// s3
		$this->s3->LinkCustomAttributes = "";
		$this->s3->HrefValue = "";
		$this->s3->TooltipValue = "";

		// sc4
		$this->sc4->LinkCustomAttributes = "";
		$this->sc4->HrefValue = "";
		$this->sc4->TooltipValue = "";

		// s4
		$this->s4->LinkCustomAttributes = "";
		$this->s4->HrefValue = "";
		$this->s4->TooltipValue = "";

		// sc5
		$this->sc5->LinkCustomAttributes = "";
		$this->sc5->HrefValue = "";
		$this->sc5->TooltipValue = "";

		// s5
		$this->s5->LinkCustomAttributes = "";
		$this->s5->HrefValue = "";
		$this->s5->TooltipValue = "";

		// sc6
		$this->sc6->LinkCustomAttributes = "";
		$this->sc6->HrefValue = "";
		$this->sc6->TooltipValue = "";

		// s6
		$this->s6->LinkCustomAttributes = "";
		$this->s6->HrefValue = "";
		$this->s6->TooltipValue = "";

		// sc7
		$this->sc7->LinkCustomAttributes = "";
		$this->sc7->HrefValue = "";
		$this->sc7->TooltipValue = "";

		// s7
		$this->s7->LinkCustomAttributes = "";
		$this->s7->HrefValue = "";
		$this->s7->TooltipValue = "";

		// sc8
		$this->sc8->LinkCustomAttributes = "";
		$this->sc8->HrefValue = "";
		$this->sc8->TooltipValue = "";

		// s8
		$this->s8->LinkCustomAttributes = "";
		$this->s8->HrefValue = "";
		$this->s8->TooltipValue = "";

		// total
		$this->total->LinkCustomAttributes = "";
		$this->total->HrefValue = "";
		$this->total->TooltipValue = "";

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

		// rid
		$this->rid->EditAttrs["class"] = "form-control";
		$this->rid->EditCustomAttributes = "";
		$this->rid->EditValue = $this->rid->CurrentValue;
		$this->rid->ViewCustomAttributes = "";

		// usn
		$this->usn->EditAttrs["class"] = "form-control";
		$this->usn->EditCustomAttributes = "";
		$this->usn->EditValue = $this->usn->CurrentValue;
		$this->usn->PlaceHolder = ew_RemoveHtml($this->usn->FldCaption());

		// name
		$this->name->EditAttrs["class"] = "form-control";
		$this->name->EditCustomAttributes = "";
		$this->name->EditValue = $this->name->CurrentValue;
		$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

		// sc1
		$this->sc1->EditAttrs["class"] = "form-control";
		$this->sc1->EditCustomAttributes = "";
		$this->sc1->EditValue = $this->sc1->CurrentValue;
		$this->sc1->PlaceHolder = ew_RemoveHtml($this->sc1->FldCaption());

		// s1
		$this->s1->EditAttrs["class"] = "form-control";
		$this->s1->EditCustomAttributes = "";
		$this->s1->EditValue = $this->s1->CurrentValue;
		$this->s1->PlaceHolder = ew_RemoveHtml($this->s1->FldCaption());

		// sc2
		$this->sc2->EditAttrs["class"] = "form-control";
		$this->sc2->EditCustomAttributes = "";
		$this->sc2->EditValue = $this->sc2->CurrentValue;
		$this->sc2->PlaceHolder = ew_RemoveHtml($this->sc2->FldCaption());

		// s2
		$this->s2->EditAttrs["class"] = "form-control";
		$this->s2->EditCustomAttributes = "";
		$this->s2->EditValue = $this->s2->CurrentValue;
		$this->s2->PlaceHolder = ew_RemoveHtml($this->s2->FldCaption());

		// sc3
		$this->sc3->EditAttrs["class"] = "form-control";
		$this->sc3->EditCustomAttributes = "";
		$this->sc3->EditValue = $this->sc3->CurrentValue;
		$this->sc3->PlaceHolder = ew_RemoveHtml($this->sc3->FldCaption());

		// s3
		$this->s3->EditAttrs["class"] = "form-control";
		$this->s3->EditCustomAttributes = "";
		$this->s3->EditValue = $this->s3->CurrentValue;
		$this->s3->PlaceHolder = ew_RemoveHtml($this->s3->FldCaption());

		// sc4
		$this->sc4->EditAttrs["class"] = "form-control";
		$this->sc4->EditCustomAttributes = "";
		$this->sc4->EditValue = $this->sc4->CurrentValue;
		$this->sc4->PlaceHolder = ew_RemoveHtml($this->sc4->FldCaption());

		// s4
		$this->s4->EditAttrs["class"] = "form-control";
		$this->s4->EditCustomAttributes = "";
		$this->s4->EditValue = $this->s4->CurrentValue;
		$this->s4->PlaceHolder = ew_RemoveHtml($this->s4->FldCaption());

		// sc5
		$this->sc5->EditAttrs["class"] = "form-control";
		$this->sc5->EditCustomAttributes = "";
		$this->sc5->EditValue = $this->sc5->CurrentValue;
		$this->sc5->PlaceHolder = ew_RemoveHtml($this->sc5->FldCaption());

		// s5
		$this->s5->EditAttrs["class"] = "form-control";
		$this->s5->EditCustomAttributes = "";
		$this->s5->EditValue = $this->s5->CurrentValue;
		$this->s5->PlaceHolder = ew_RemoveHtml($this->s5->FldCaption());

		// sc6
		$this->sc6->EditAttrs["class"] = "form-control";
		$this->sc6->EditCustomAttributes = "";
		$this->sc6->EditValue = $this->sc6->CurrentValue;
		$this->sc6->PlaceHolder = ew_RemoveHtml($this->sc6->FldCaption());

		// s6
		$this->s6->EditAttrs["class"] = "form-control";
		$this->s6->EditCustomAttributes = "";
		$this->s6->EditValue = $this->s6->CurrentValue;
		$this->s6->PlaceHolder = ew_RemoveHtml($this->s6->FldCaption());

		// sc7
		$this->sc7->EditAttrs["class"] = "form-control";
		$this->sc7->EditCustomAttributes = "";
		$this->sc7->EditValue = $this->sc7->CurrentValue;
		$this->sc7->PlaceHolder = ew_RemoveHtml($this->sc7->FldCaption());

		// s7
		$this->s7->EditAttrs["class"] = "form-control";
		$this->s7->EditCustomAttributes = "";
		$this->s7->EditValue = $this->s7->CurrentValue;
		$this->s7->PlaceHolder = ew_RemoveHtml($this->s7->FldCaption());

		// sc8
		$this->sc8->EditAttrs["class"] = "form-control";
		$this->sc8->EditCustomAttributes = "";
		$this->sc8->EditValue = $this->sc8->CurrentValue;
		$this->sc8->PlaceHolder = ew_RemoveHtml($this->sc8->FldCaption());

		// s8
		$this->s8->EditAttrs["class"] = "form-control";
		$this->s8->EditCustomAttributes = "";
		$this->s8->EditValue = $this->s8->CurrentValue;
		$this->s8->PlaceHolder = ew_RemoveHtml($this->s8->FldCaption());

		// total
		$this->total->EditAttrs["class"] = "form-control";
		$this->total->EditCustomAttributes = "";
		$this->total->EditValue = $this->total->CurrentValue;
		$this->total->PlaceHolder = ew_RemoveHtml($this->total->FldCaption());

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
					if ($this->rid->Exportable) $Doc->ExportCaption($this->rid);
					if ($this->usn->Exportable) $Doc->ExportCaption($this->usn);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->sc1->Exportable) $Doc->ExportCaption($this->sc1);
					if ($this->s1->Exportable) $Doc->ExportCaption($this->s1);
					if ($this->sc2->Exportable) $Doc->ExportCaption($this->sc2);
					if ($this->s2->Exportable) $Doc->ExportCaption($this->s2);
					if ($this->sc3->Exportable) $Doc->ExportCaption($this->sc3);
					if ($this->s3->Exportable) $Doc->ExportCaption($this->s3);
					if ($this->sc4->Exportable) $Doc->ExportCaption($this->sc4);
					if ($this->s4->Exportable) $Doc->ExportCaption($this->s4);
					if ($this->sc5->Exportable) $Doc->ExportCaption($this->sc5);
					if ($this->s5->Exportable) $Doc->ExportCaption($this->s5);
					if ($this->sc6->Exportable) $Doc->ExportCaption($this->sc6);
					if ($this->s6->Exportable) $Doc->ExportCaption($this->s6);
					if ($this->sc7->Exportable) $Doc->ExportCaption($this->sc7);
					if ($this->s7->Exportable) $Doc->ExportCaption($this->s7);
					if ($this->sc8->Exportable) $Doc->ExportCaption($this->sc8);
					if ($this->s8->Exportable) $Doc->ExportCaption($this->s8);
					if ($this->total->Exportable) $Doc->ExportCaption($this->total);
				} else {
					if ($this->rid->Exportable) $Doc->ExportCaption($this->rid);
					if ($this->usn->Exportable) $Doc->ExportCaption($this->usn);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->sc1->Exportable) $Doc->ExportCaption($this->sc1);
					if ($this->s1->Exportable) $Doc->ExportCaption($this->s1);
					if ($this->sc2->Exportable) $Doc->ExportCaption($this->sc2);
					if ($this->s2->Exportable) $Doc->ExportCaption($this->s2);
					if ($this->sc3->Exportable) $Doc->ExportCaption($this->sc3);
					if ($this->s3->Exportable) $Doc->ExportCaption($this->s3);
					if ($this->sc4->Exportable) $Doc->ExportCaption($this->sc4);
					if ($this->s4->Exportable) $Doc->ExportCaption($this->s4);
					if ($this->sc5->Exportable) $Doc->ExportCaption($this->sc5);
					if ($this->s5->Exportable) $Doc->ExportCaption($this->s5);
					if ($this->sc6->Exportable) $Doc->ExportCaption($this->sc6);
					if ($this->s6->Exportable) $Doc->ExportCaption($this->s6);
					if ($this->sc7->Exportable) $Doc->ExportCaption($this->sc7);
					if ($this->s7->Exportable) $Doc->ExportCaption($this->s7);
					if ($this->sc8->Exportable) $Doc->ExportCaption($this->sc8);
					if ($this->s8->Exportable) $Doc->ExportCaption($this->s8);
					if ($this->total->Exportable) $Doc->ExportCaption($this->total);
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
						if ($this->rid->Exportable) $Doc->ExportField($this->rid);
						if ($this->usn->Exportable) $Doc->ExportField($this->usn);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->sc1->Exportable) $Doc->ExportField($this->sc1);
						if ($this->s1->Exportable) $Doc->ExportField($this->s1);
						if ($this->sc2->Exportable) $Doc->ExportField($this->sc2);
						if ($this->s2->Exportable) $Doc->ExportField($this->s2);
						if ($this->sc3->Exportable) $Doc->ExportField($this->sc3);
						if ($this->s3->Exportable) $Doc->ExportField($this->s3);
						if ($this->sc4->Exportable) $Doc->ExportField($this->sc4);
						if ($this->s4->Exportable) $Doc->ExportField($this->s4);
						if ($this->sc5->Exportable) $Doc->ExportField($this->sc5);
						if ($this->s5->Exportable) $Doc->ExportField($this->s5);
						if ($this->sc6->Exportable) $Doc->ExportField($this->sc6);
						if ($this->s6->Exportable) $Doc->ExportField($this->s6);
						if ($this->sc7->Exportable) $Doc->ExportField($this->sc7);
						if ($this->s7->Exportable) $Doc->ExportField($this->s7);
						if ($this->sc8->Exportable) $Doc->ExportField($this->sc8);
						if ($this->s8->Exportable) $Doc->ExportField($this->s8);
						if ($this->total->Exportable) $Doc->ExportField($this->total);
					} else {
						if ($this->rid->Exportable) $Doc->ExportField($this->rid);
						if ($this->usn->Exportable) $Doc->ExportField($this->usn);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->sc1->Exportable) $Doc->ExportField($this->sc1);
						if ($this->s1->Exportable) $Doc->ExportField($this->s1);
						if ($this->sc2->Exportable) $Doc->ExportField($this->sc2);
						if ($this->s2->Exportable) $Doc->ExportField($this->s2);
						if ($this->sc3->Exportable) $Doc->ExportField($this->sc3);
						if ($this->s3->Exportable) $Doc->ExportField($this->s3);
						if ($this->sc4->Exportable) $Doc->ExportField($this->sc4);
						if ($this->s4->Exportable) $Doc->ExportField($this->s4);
						if ($this->sc5->Exportable) $Doc->ExportField($this->sc5);
						if ($this->s5->Exportable) $Doc->ExportField($this->s5);
						if ($this->sc6->Exportable) $Doc->ExportField($this->sc6);
						if ($this->s6->Exportable) $Doc->ExportField($this->s6);
						if ($this->sc7->Exportable) $Doc->ExportField($this->sc7);
						if ($this->s7->Exportable) $Doc->ExportField($this->s7);
						if ($this->sc8->Exportable) $Doc->ExportField($this->sc8);
						if ($this->s8->Exportable) $Doc->ExportField($this->s8);
						if ($this->total->Exportable) $Doc->ExportField($this->total);
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
