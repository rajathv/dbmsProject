<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "resultinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$result_delete = NULL; // Initialize page object first

class cresult_delete extends cresult {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{7dac28fc-e6ee-49d2-b722-398a2b30146f}';

	// Table name
	var $TableName = 'result';

	// Page object name
	var $PageObjName = 'result_delete';

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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (result)
		if (!isset($GLOBALS["result"]) || get_class($GLOBALS["result"]) == "cresult") {
			$GLOBALS["result"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["result"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'result', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);
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
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("resultlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->rid->SetVisibility();
		$this->rid->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->usn->SetVisibility();
		$this->name->SetVisibility();
		$this->sc1->SetVisibility();
		$this->s1->SetVisibility();
		$this->sc2->SetVisibility();
		$this->s2->SetVisibility();
		$this->sc3->SetVisibility();
		$this->s3->SetVisibility();
		$this->sc4->SetVisibility();
		$this->s4->SetVisibility();
		$this->sc5->SetVisibility();
		$this->s5->SetVisibility();
		$this->sc6->SetVisibility();
		$this->s6->SetVisibility();
		$this->sc7->SetVisibility();
		$this->s7->SetVisibility();
		$this->sc8->SetVisibility();
		$this->s8->SetVisibility();
		$this->total->SetVisibility();

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
		global $EW_EXPORT, $result;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($result);
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("resultlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in result class, resultinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("resultlist.php"); // Return to list
			}
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
		$this->rid->setDbValue($row['rid']);
		$this->usn->setDbValue($row['usn']);
		$this->name->setDbValue($row['name']);
		$this->sc1->setDbValue($row['sc1']);
		$this->s1->setDbValue($row['s1']);
		$this->sc2->setDbValue($row['sc2']);
		$this->s2->setDbValue($row['s2']);
		$this->sc3->setDbValue($row['sc3']);
		$this->s3->setDbValue($row['s3']);
		$this->sc4->setDbValue($row['sc4']);
		$this->s4->setDbValue($row['s4']);
		$this->sc5->setDbValue($row['sc5']);
		$this->s5->setDbValue($row['s5']);
		$this->sc6->setDbValue($row['sc6']);
		$this->s6->setDbValue($row['s6']);
		$this->sc7->setDbValue($row['sc7']);
		$this->s7->setDbValue($row['s7']);
		$this->sc8->setDbValue($row['sc8']);
		$this->s8->setDbValue($row['s8']);
		$this->total->setDbValue($row['total']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['rid'] = NULL;
		$row['usn'] = NULL;
		$row['name'] = NULL;
		$row['sc1'] = NULL;
		$row['s1'] = NULL;
		$row['sc2'] = NULL;
		$row['s2'] = NULL;
		$row['sc3'] = NULL;
		$row['s3'] = NULL;
		$row['sc4'] = NULL;
		$row['s4'] = NULL;
		$row['sc5'] = NULL;
		$row['s5'] = NULL;
		$row['sc6'] = NULL;
		$row['s6'] = NULL;
		$row['sc7'] = NULL;
		$row['s7'] = NULL;
		$row['sc8'] = NULL;
		$row['s8'] = NULL;
		$row['total'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->rid->DbValue = $row['rid'];
		$this->usn->DbValue = $row['usn'];
		$this->name->DbValue = $row['name'];
		$this->sc1->DbValue = $row['sc1'];
		$this->s1->DbValue = $row['s1'];
		$this->sc2->DbValue = $row['sc2'];
		$this->s2->DbValue = $row['s2'];
		$this->sc3->DbValue = $row['sc3'];
		$this->s3->DbValue = $row['s3'];
		$this->sc4->DbValue = $row['sc4'];
		$this->s4->DbValue = $row['s4'];
		$this->sc5->DbValue = $row['sc5'];
		$this->s5->DbValue = $row['s5'];
		$this->sc6->DbValue = $row['sc6'];
		$this->s6->DbValue = $row['s6'];
		$this->sc7->DbValue = $row['sc7'];
		$this->s7->DbValue = $row['s7'];
		$this->sc8->DbValue = $row['sc8'];
		$this->s8->DbValue = $row['s8'];
		$this->total->DbValue = $row['total'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['rid'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("resultlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($result_delete)) $result_delete = new cresult_delete();

// Page init
$result_delete->Page_Init();

// Page main
$result_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$result_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fresultdelete = new ew_Form("fresultdelete", "delete");

// Form_CustomValidate event
fresultdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fresultdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $result_delete->ShowPageHeader(); ?>
<?php
$result_delete->ShowMessage();
?>
<form name="fresultdelete" id="fresultdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($result_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $result_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="result">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($result_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($result->rid->Visible) { // rid ?>
		<th class="<?php echo $result->rid->HeaderCellClass() ?>"><span id="elh_result_rid" class="result_rid"><?php echo $result->rid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->usn->Visible) { // usn ?>
		<th class="<?php echo $result->usn->HeaderCellClass() ?>"><span id="elh_result_usn" class="result_usn"><?php echo $result->usn->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->name->Visible) { // name ?>
		<th class="<?php echo $result->name->HeaderCellClass() ?>"><span id="elh_result_name" class="result_name"><?php echo $result->name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->sc1->Visible) { // sc1 ?>
		<th class="<?php echo $result->sc1->HeaderCellClass() ?>"><span id="elh_result_sc1" class="result_sc1"><?php echo $result->sc1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->s1->Visible) { // s1 ?>
		<th class="<?php echo $result->s1->HeaderCellClass() ?>"><span id="elh_result_s1" class="result_s1"><?php echo $result->s1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->sc2->Visible) { // sc2 ?>
		<th class="<?php echo $result->sc2->HeaderCellClass() ?>"><span id="elh_result_sc2" class="result_sc2"><?php echo $result->sc2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->s2->Visible) { // s2 ?>
		<th class="<?php echo $result->s2->HeaderCellClass() ?>"><span id="elh_result_s2" class="result_s2"><?php echo $result->s2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->sc3->Visible) { // sc3 ?>
		<th class="<?php echo $result->sc3->HeaderCellClass() ?>"><span id="elh_result_sc3" class="result_sc3"><?php echo $result->sc3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->s3->Visible) { // s3 ?>
		<th class="<?php echo $result->s3->HeaderCellClass() ?>"><span id="elh_result_s3" class="result_s3"><?php echo $result->s3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->sc4->Visible) { // sc4 ?>
		<th class="<?php echo $result->sc4->HeaderCellClass() ?>"><span id="elh_result_sc4" class="result_sc4"><?php echo $result->sc4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->s4->Visible) { // s4 ?>
		<th class="<?php echo $result->s4->HeaderCellClass() ?>"><span id="elh_result_s4" class="result_s4"><?php echo $result->s4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->sc5->Visible) { // sc5 ?>
		<th class="<?php echo $result->sc5->HeaderCellClass() ?>"><span id="elh_result_sc5" class="result_sc5"><?php echo $result->sc5->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->s5->Visible) { // s5 ?>
		<th class="<?php echo $result->s5->HeaderCellClass() ?>"><span id="elh_result_s5" class="result_s5"><?php echo $result->s5->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->sc6->Visible) { // sc6 ?>
		<th class="<?php echo $result->sc6->HeaderCellClass() ?>"><span id="elh_result_sc6" class="result_sc6"><?php echo $result->sc6->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->s6->Visible) { // s6 ?>
		<th class="<?php echo $result->s6->HeaderCellClass() ?>"><span id="elh_result_s6" class="result_s6"><?php echo $result->s6->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->sc7->Visible) { // sc7 ?>
		<th class="<?php echo $result->sc7->HeaderCellClass() ?>"><span id="elh_result_sc7" class="result_sc7"><?php echo $result->sc7->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->s7->Visible) { // s7 ?>
		<th class="<?php echo $result->s7->HeaderCellClass() ?>"><span id="elh_result_s7" class="result_s7"><?php echo $result->s7->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->sc8->Visible) { // sc8 ?>
		<th class="<?php echo $result->sc8->HeaderCellClass() ?>"><span id="elh_result_sc8" class="result_sc8"><?php echo $result->sc8->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->s8->Visible) { // s8 ?>
		<th class="<?php echo $result->s8->HeaderCellClass() ?>"><span id="elh_result_s8" class="result_s8"><?php echo $result->s8->FldCaption() ?></span></th>
<?php } ?>
<?php if ($result->total->Visible) { // total ?>
		<th class="<?php echo $result->total->HeaderCellClass() ?>"><span id="elh_result_total" class="result_total"><?php echo $result->total->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$result_delete->RecCnt = 0;
$i = 0;
while (!$result_delete->Recordset->EOF) {
	$result_delete->RecCnt++;
	$result_delete->RowCnt++;

	// Set row properties
	$result->ResetAttrs();
	$result->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$result_delete->LoadRowValues($result_delete->Recordset);

	// Render row
	$result_delete->RenderRow();
?>
	<tr<?php echo $result->RowAttributes() ?>>
<?php if ($result->rid->Visible) { // rid ?>
		<td<?php echo $result->rid->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_rid" class="result_rid">
<span<?php echo $result->rid->ViewAttributes() ?>>
<?php echo $result->rid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->usn->Visible) { // usn ?>
		<td<?php echo $result->usn->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_usn" class="result_usn">
<span<?php echo $result->usn->ViewAttributes() ?>>
<?php echo $result->usn->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->name->Visible) { // name ?>
		<td<?php echo $result->name->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_name" class="result_name">
<span<?php echo $result->name->ViewAttributes() ?>>
<?php echo $result->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->sc1->Visible) { // sc1 ?>
		<td<?php echo $result->sc1->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_sc1" class="result_sc1">
<span<?php echo $result->sc1->ViewAttributes() ?>>
<?php echo $result->sc1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->s1->Visible) { // s1 ?>
		<td<?php echo $result->s1->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_s1" class="result_s1">
<span<?php echo $result->s1->ViewAttributes() ?>>
<?php echo $result->s1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->sc2->Visible) { // sc2 ?>
		<td<?php echo $result->sc2->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_sc2" class="result_sc2">
<span<?php echo $result->sc2->ViewAttributes() ?>>
<?php echo $result->sc2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->s2->Visible) { // s2 ?>
		<td<?php echo $result->s2->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_s2" class="result_s2">
<span<?php echo $result->s2->ViewAttributes() ?>>
<?php echo $result->s2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->sc3->Visible) { // sc3 ?>
		<td<?php echo $result->sc3->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_sc3" class="result_sc3">
<span<?php echo $result->sc3->ViewAttributes() ?>>
<?php echo $result->sc3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->s3->Visible) { // s3 ?>
		<td<?php echo $result->s3->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_s3" class="result_s3">
<span<?php echo $result->s3->ViewAttributes() ?>>
<?php echo $result->s3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->sc4->Visible) { // sc4 ?>
		<td<?php echo $result->sc4->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_sc4" class="result_sc4">
<span<?php echo $result->sc4->ViewAttributes() ?>>
<?php echo $result->sc4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->s4->Visible) { // s4 ?>
		<td<?php echo $result->s4->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_s4" class="result_s4">
<span<?php echo $result->s4->ViewAttributes() ?>>
<?php echo $result->s4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->sc5->Visible) { // sc5 ?>
		<td<?php echo $result->sc5->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_sc5" class="result_sc5">
<span<?php echo $result->sc5->ViewAttributes() ?>>
<?php echo $result->sc5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->s5->Visible) { // s5 ?>
		<td<?php echo $result->s5->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_s5" class="result_s5">
<span<?php echo $result->s5->ViewAttributes() ?>>
<?php echo $result->s5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->sc6->Visible) { // sc6 ?>
		<td<?php echo $result->sc6->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_sc6" class="result_sc6">
<span<?php echo $result->sc6->ViewAttributes() ?>>
<?php echo $result->sc6->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->s6->Visible) { // s6 ?>
		<td<?php echo $result->s6->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_s6" class="result_s6">
<span<?php echo $result->s6->ViewAttributes() ?>>
<?php echo $result->s6->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->sc7->Visible) { // sc7 ?>
		<td<?php echo $result->sc7->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_sc7" class="result_sc7">
<span<?php echo $result->sc7->ViewAttributes() ?>>
<?php echo $result->sc7->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->s7->Visible) { // s7 ?>
		<td<?php echo $result->s7->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_s7" class="result_s7">
<span<?php echo $result->s7->ViewAttributes() ?>>
<?php echo $result->s7->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->sc8->Visible) { // sc8 ?>
		<td<?php echo $result->sc8->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_sc8" class="result_sc8">
<span<?php echo $result->sc8->ViewAttributes() ?>>
<?php echo $result->sc8->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->s8->Visible) { // s8 ?>
		<td<?php echo $result->s8->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_s8" class="result_s8">
<span<?php echo $result->s8->ViewAttributes() ?>>
<?php echo $result->s8->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($result->total->Visible) { // total ?>
		<td<?php echo $result->total->CellAttributes() ?>>
<span id="el<?php echo $result_delete->RowCnt ?>_result_total" class="result_total">
<span<?php echo $result->total->ViewAttributes() ?>>
<?php echo $result->total->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$result_delete->Recordset->MoveNext();
}
$result_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $result_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fresultdelete.Init();
</script>
<?php
$result_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$result_delete->Page_Terminate();
?>
