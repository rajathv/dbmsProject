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

$result_add = NULL; // Initialize page object first

class cresult_add extends cresult {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{7dac28fc-e6ee-49d2-b722-398a2b30146f}';

	// Table name
	var $TableName = 'result';

	// Page object name
	var $PageObjName = 'result_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanAdd()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "resultview.php")
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
			if (@$_GET["rid"] != "") {
				$this->rid->setQueryStringValue($_GET["rid"]);
				$this->setKey("rid", $this->rid->CurrentValue); // Set up key
			} else {
				$this->setKey("rid", ""); // Clear key
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
					$this->Page_Terminate("resultlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "resultlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "resultview.php")
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
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

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
		$this->rid->CurrentValue = NULL;
		$this->rid->OldValue = $this->rid->CurrentValue;
		$this->usn->CurrentValue = NULL;
		$this->usn->OldValue = $this->usn->CurrentValue;
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->sc1->CurrentValue = NULL;
		$this->sc1->OldValue = $this->sc1->CurrentValue;
		$this->s1->CurrentValue = NULL;
		$this->s1->OldValue = $this->s1->CurrentValue;
		$this->sc2->CurrentValue = NULL;
		$this->sc2->OldValue = $this->sc2->CurrentValue;
		$this->s2->CurrentValue = NULL;
		$this->s2->OldValue = $this->s2->CurrentValue;
		$this->sc3->CurrentValue = NULL;
		$this->sc3->OldValue = $this->sc3->CurrentValue;
		$this->s3->CurrentValue = NULL;
		$this->s3->OldValue = $this->s3->CurrentValue;
		$this->sc4->CurrentValue = NULL;
		$this->sc4->OldValue = $this->sc4->CurrentValue;
		$this->s4->CurrentValue = NULL;
		$this->s4->OldValue = $this->s4->CurrentValue;
		$this->sc5->CurrentValue = NULL;
		$this->sc5->OldValue = $this->sc5->CurrentValue;
		$this->s5->CurrentValue = NULL;
		$this->s5->OldValue = $this->s5->CurrentValue;
		$this->sc6->CurrentValue = NULL;
		$this->sc6->OldValue = $this->sc6->CurrentValue;
		$this->s6->CurrentValue = NULL;
		$this->s6->OldValue = $this->s6->CurrentValue;
		$this->sc7->CurrentValue = NULL;
		$this->sc7->OldValue = $this->sc7->CurrentValue;
		$this->s7->CurrentValue = NULL;
		$this->s7->OldValue = $this->s7->CurrentValue;
		$this->sc8->CurrentValue = NULL;
		$this->sc8->OldValue = $this->sc8->CurrentValue;
		$this->s8->CurrentValue = NULL;
		$this->s8->OldValue = $this->s8->CurrentValue;
		$this->total->CurrentValue = NULL;
		$this->total->OldValue = $this->total->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->usn->FldIsDetailKey) {
			$this->usn->setFormValue($objForm->GetValue("x_usn"));
		}
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->sc1->FldIsDetailKey) {
			$this->sc1->setFormValue($objForm->GetValue("x_sc1"));
		}
		if (!$this->s1->FldIsDetailKey) {
			$this->s1->setFormValue($objForm->GetValue("x_s1"));
		}
		if (!$this->sc2->FldIsDetailKey) {
			$this->sc2->setFormValue($objForm->GetValue("x_sc2"));
		}
		if (!$this->s2->FldIsDetailKey) {
			$this->s2->setFormValue($objForm->GetValue("x_s2"));
		}
		if (!$this->sc3->FldIsDetailKey) {
			$this->sc3->setFormValue($objForm->GetValue("x_sc3"));
		}
		if (!$this->s3->FldIsDetailKey) {
			$this->s3->setFormValue($objForm->GetValue("x_s3"));
		}
		if (!$this->sc4->FldIsDetailKey) {
			$this->sc4->setFormValue($objForm->GetValue("x_sc4"));
		}
		if (!$this->s4->FldIsDetailKey) {
			$this->s4->setFormValue($objForm->GetValue("x_s4"));
		}
		if (!$this->sc5->FldIsDetailKey) {
			$this->sc5->setFormValue($objForm->GetValue("x_sc5"));
		}
		if (!$this->s5->FldIsDetailKey) {
			$this->s5->setFormValue($objForm->GetValue("x_s5"));
		}
		if (!$this->sc6->FldIsDetailKey) {
			$this->sc6->setFormValue($objForm->GetValue("x_sc6"));
		}
		if (!$this->s6->FldIsDetailKey) {
			$this->s6->setFormValue($objForm->GetValue("x_s6"));
		}
		if (!$this->sc7->FldIsDetailKey) {
			$this->sc7->setFormValue($objForm->GetValue("x_sc7"));
		}
		if (!$this->s7->FldIsDetailKey) {
			$this->s7->setFormValue($objForm->GetValue("x_s7"));
		}
		if (!$this->sc8->FldIsDetailKey) {
			$this->sc8->setFormValue($objForm->GetValue("x_sc8"));
		}
		if (!$this->s8->FldIsDetailKey) {
			$this->s8->setFormValue($objForm->GetValue("x_s8"));
		}
		if (!$this->total->FldIsDetailKey) {
			$this->total->setFormValue($objForm->GetValue("x_total"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->usn->CurrentValue = $this->usn->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->sc1->CurrentValue = $this->sc1->FormValue;
		$this->s1->CurrentValue = $this->s1->FormValue;
		$this->sc2->CurrentValue = $this->sc2->FormValue;
		$this->s2->CurrentValue = $this->s2->FormValue;
		$this->sc3->CurrentValue = $this->sc3->FormValue;
		$this->s3->CurrentValue = $this->s3->FormValue;
		$this->sc4->CurrentValue = $this->sc4->FormValue;
		$this->s4->CurrentValue = $this->s4->FormValue;
		$this->sc5->CurrentValue = $this->sc5->FormValue;
		$this->s5->CurrentValue = $this->s5->FormValue;
		$this->sc6->CurrentValue = $this->sc6->FormValue;
		$this->s6->CurrentValue = $this->s6->FormValue;
		$this->sc7->CurrentValue = $this->sc7->FormValue;
		$this->s7->CurrentValue = $this->s7->FormValue;
		$this->sc8->CurrentValue = $this->sc8->FormValue;
		$this->s8->CurrentValue = $this->s8->FormValue;
		$this->total->CurrentValue = $this->total->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['rid'] = $this->rid->CurrentValue;
		$row['usn'] = $this->usn->CurrentValue;
		$row['name'] = $this->name->CurrentValue;
		$row['sc1'] = $this->sc1->CurrentValue;
		$row['s1'] = $this->s1->CurrentValue;
		$row['sc2'] = $this->sc2->CurrentValue;
		$row['s2'] = $this->s2->CurrentValue;
		$row['sc3'] = $this->sc3->CurrentValue;
		$row['s3'] = $this->s3->CurrentValue;
		$row['sc4'] = $this->sc4->CurrentValue;
		$row['s4'] = $this->s4->CurrentValue;
		$row['sc5'] = $this->sc5->CurrentValue;
		$row['s5'] = $this->s5->CurrentValue;
		$row['sc6'] = $this->sc6->CurrentValue;
		$row['s6'] = $this->s6->CurrentValue;
		$row['sc7'] = $this->sc7->CurrentValue;
		$row['s7'] = $this->s7->CurrentValue;
		$row['sc8'] = $this->sc8->CurrentValue;
		$row['s8'] = $this->s8->CurrentValue;
		$row['total'] = $this->total->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("rid")) <> "")
			$this->rid->CurrentValue = $this->getKey("rid"); // rid
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// usn
			$this->usn->EditAttrs["class"] = "form-control";
			$this->usn->EditCustomAttributes = "";
			$this->usn->EditValue = ew_HtmlEncode($this->usn->CurrentValue);
			$this->usn->PlaceHolder = ew_RemoveHtml($this->usn->FldCaption());

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// sc1
			$this->sc1->EditAttrs["class"] = "form-control";
			$this->sc1->EditCustomAttributes = "";
			$this->sc1->EditValue = ew_HtmlEncode($this->sc1->CurrentValue);
			$this->sc1->PlaceHolder = ew_RemoveHtml($this->sc1->FldCaption());

			// s1
			$this->s1->EditAttrs["class"] = "form-control";
			$this->s1->EditCustomAttributes = "";
			$this->s1->EditValue = ew_HtmlEncode($this->s1->CurrentValue);
			$this->s1->PlaceHolder = ew_RemoveHtml($this->s1->FldCaption());

			// sc2
			$this->sc2->EditAttrs["class"] = "form-control";
			$this->sc2->EditCustomAttributes = "";
			$this->sc2->EditValue = ew_HtmlEncode($this->sc2->CurrentValue);
			$this->sc2->PlaceHolder = ew_RemoveHtml($this->sc2->FldCaption());

			// s2
			$this->s2->EditAttrs["class"] = "form-control";
			$this->s2->EditCustomAttributes = "";
			$this->s2->EditValue = ew_HtmlEncode($this->s2->CurrentValue);
			$this->s2->PlaceHolder = ew_RemoveHtml($this->s2->FldCaption());

			// sc3
			$this->sc3->EditAttrs["class"] = "form-control";
			$this->sc3->EditCustomAttributes = "";
			$this->sc3->EditValue = ew_HtmlEncode($this->sc3->CurrentValue);
			$this->sc3->PlaceHolder = ew_RemoveHtml($this->sc3->FldCaption());

			// s3
			$this->s3->EditAttrs["class"] = "form-control";
			$this->s3->EditCustomAttributes = "";
			$this->s3->EditValue = ew_HtmlEncode($this->s3->CurrentValue);
			$this->s3->PlaceHolder = ew_RemoveHtml($this->s3->FldCaption());

			// sc4
			$this->sc4->EditAttrs["class"] = "form-control";
			$this->sc4->EditCustomAttributes = "";
			$this->sc4->EditValue = ew_HtmlEncode($this->sc4->CurrentValue);
			$this->sc4->PlaceHolder = ew_RemoveHtml($this->sc4->FldCaption());

			// s4
			$this->s4->EditAttrs["class"] = "form-control";
			$this->s4->EditCustomAttributes = "";
			$this->s4->EditValue = ew_HtmlEncode($this->s4->CurrentValue);
			$this->s4->PlaceHolder = ew_RemoveHtml($this->s4->FldCaption());

			// sc5
			$this->sc5->EditAttrs["class"] = "form-control";
			$this->sc5->EditCustomAttributes = "";
			$this->sc5->EditValue = ew_HtmlEncode($this->sc5->CurrentValue);
			$this->sc5->PlaceHolder = ew_RemoveHtml($this->sc5->FldCaption());

			// s5
			$this->s5->EditAttrs["class"] = "form-control";
			$this->s5->EditCustomAttributes = "";
			$this->s5->EditValue = ew_HtmlEncode($this->s5->CurrentValue);
			$this->s5->PlaceHolder = ew_RemoveHtml($this->s5->FldCaption());

			// sc6
			$this->sc6->EditAttrs["class"] = "form-control";
			$this->sc6->EditCustomAttributes = "";
			$this->sc6->EditValue = ew_HtmlEncode($this->sc6->CurrentValue);
			$this->sc6->PlaceHolder = ew_RemoveHtml($this->sc6->FldCaption());

			// s6
			$this->s6->EditAttrs["class"] = "form-control";
			$this->s6->EditCustomAttributes = "";
			$this->s6->EditValue = ew_HtmlEncode($this->s6->CurrentValue);
			$this->s6->PlaceHolder = ew_RemoveHtml($this->s6->FldCaption());

			// sc7
			$this->sc7->EditAttrs["class"] = "form-control";
			$this->sc7->EditCustomAttributes = "";
			$this->sc7->EditValue = ew_HtmlEncode($this->sc7->CurrentValue);
			$this->sc7->PlaceHolder = ew_RemoveHtml($this->sc7->FldCaption());

			// s7
			$this->s7->EditAttrs["class"] = "form-control";
			$this->s7->EditCustomAttributes = "";
			$this->s7->EditValue = ew_HtmlEncode($this->s7->CurrentValue);
			$this->s7->PlaceHolder = ew_RemoveHtml($this->s7->FldCaption());

			// sc8
			$this->sc8->EditAttrs["class"] = "form-control";
			$this->sc8->EditCustomAttributes = "";
			$this->sc8->EditValue = ew_HtmlEncode($this->sc8->CurrentValue);
			$this->sc8->PlaceHolder = ew_RemoveHtml($this->sc8->FldCaption());

			// s8
			$this->s8->EditAttrs["class"] = "form-control";
			$this->s8->EditCustomAttributes = "";
			$this->s8->EditValue = ew_HtmlEncode($this->s8->CurrentValue);
			$this->s8->PlaceHolder = ew_RemoveHtml($this->s8->FldCaption());

			// total
			$this->total->EditAttrs["class"] = "form-control";
			$this->total->EditCustomAttributes = "";
			$this->total->EditValue = ew_HtmlEncode($this->total->CurrentValue);
			$this->total->PlaceHolder = ew_RemoveHtml($this->total->FldCaption());

			// Add refer script
			// usn

			$this->usn->LinkCustomAttributes = "";
			$this->usn->HrefValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";

			// sc1
			$this->sc1->LinkCustomAttributes = "";
			$this->sc1->HrefValue = "";

			// s1
			$this->s1->LinkCustomAttributes = "";
			$this->s1->HrefValue = "";

			// sc2
			$this->sc2->LinkCustomAttributes = "";
			$this->sc2->HrefValue = "";

			// s2
			$this->s2->LinkCustomAttributes = "";
			$this->s2->HrefValue = "";

			// sc3
			$this->sc3->LinkCustomAttributes = "";
			$this->sc3->HrefValue = "";

			// s3
			$this->s3->LinkCustomAttributes = "";
			$this->s3->HrefValue = "";

			// sc4
			$this->sc4->LinkCustomAttributes = "";
			$this->sc4->HrefValue = "";

			// s4
			$this->s4->LinkCustomAttributes = "";
			$this->s4->HrefValue = "";

			// sc5
			$this->sc5->LinkCustomAttributes = "";
			$this->sc5->HrefValue = "";

			// s5
			$this->s5->LinkCustomAttributes = "";
			$this->s5->HrefValue = "";

			// sc6
			$this->sc6->LinkCustomAttributes = "";
			$this->sc6->HrefValue = "";

			// s6
			$this->s6->LinkCustomAttributes = "";
			$this->s6->HrefValue = "";

			// sc7
			$this->sc7->LinkCustomAttributes = "";
			$this->sc7->HrefValue = "";

			// s7
			$this->s7->LinkCustomAttributes = "";
			$this->s7->HrefValue = "";

			// sc8
			$this->sc8->LinkCustomAttributes = "";
			$this->sc8->HrefValue = "";

			// s8
			$this->s8->LinkCustomAttributes = "";
			$this->s8->HrefValue = "";

			// total
			$this->total->LinkCustomAttributes = "";
			$this->total->HrefValue = "";
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
		if (!$this->usn->FldIsDetailKey && !is_null($this->usn->FormValue) && $this->usn->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->usn->FldCaption(), $this->usn->ReqErrMsg));
		}
		if (!$this->name->FldIsDetailKey && !is_null($this->name->FormValue) && $this->name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->name->FldCaption(), $this->name->ReqErrMsg));
		}
		if (!$this->sc1->FldIsDetailKey && !is_null($this->sc1->FormValue) && $this->sc1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sc1->FldCaption(), $this->sc1->ReqErrMsg));
		}
		if (!$this->s1->FldIsDetailKey && !is_null($this->s1->FormValue) && $this->s1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s1->FldCaption(), $this->s1->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->s1->FormValue)) {
			ew_AddMessage($gsFormError, $this->s1->FldErrMsg());
		}
		if (!$this->sc2->FldIsDetailKey && !is_null($this->sc2->FormValue) && $this->sc2->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sc2->FldCaption(), $this->sc2->ReqErrMsg));
		}
		if (!$this->s2->FldIsDetailKey && !is_null($this->s2->FormValue) && $this->s2->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s2->FldCaption(), $this->s2->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->s2->FormValue)) {
			ew_AddMessage($gsFormError, $this->s2->FldErrMsg());
		}
		if (!$this->sc3->FldIsDetailKey && !is_null($this->sc3->FormValue) && $this->sc3->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sc3->FldCaption(), $this->sc3->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sc3->FormValue)) {
			ew_AddMessage($gsFormError, $this->sc3->FldErrMsg());
		}
		if (!$this->s3->FldIsDetailKey && !is_null($this->s3->FormValue) && $this->s3->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s3->FldCaption(), $this->s3->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->s3->FormValue)) {
			ew_AddMessage($gsFormError, $this->s3->FldErrMsg());
		}
		if (!$this->sc4->FldIsDetailKey && !is_null($this->sc4->FormValue) && $this->sc4->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sc4->FldCaption(), $this->sc4->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sc4->FormValue)) {
			ew_AddMessage($gsFormError, $this->sc4->FldErrMsg());
		}
		if (!$this->s4->FldIsDetailKey && !is_null($this->s4->FormValue) && $this->s4->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s4->FldCaption(), $this->s4->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->s4->FormValue)) {
			ew_AddMessage($gsFormError, $this->s4->FldErrMsg());
		}
		if (!$this->sc5->FldIsDetailKey && !is_null($this->sc5->FormValue) && $this->sc5->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sc5->FldCaption(), $this->sc5->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sc5->FormValue)) {
			ew_AddMessage($gsFormError, $this->sc5->FldErrMsg());
		}
		if (!$this->s5->FldIsDetailKey && !is_null($this->s5->FormValue) && $this->s5->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s5->FldCaption(), $this->s5->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->s5->FormValue)) {
			ew_AddMessage($gsFormError, $this->s5->FldErrMsg());
		}
		if (!$this->sc6->FldIsDetailKey && !is_null($this->sc6->FormValue) && $this->sc6->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sc6->FldCaption(), $this->sc6->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sc6->FormValue)) {
			ew_AddMessage($gsFormError, $this->sc6->FldErrMsg());
		}
		if (!$this->s6->FldIsDetailKey && !is_null($this->s6->FormValue) && $this->s6->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s6->FldCaption(), $this->s6->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->s6->FormValue)) {
			ew_AddMessage($gsFormError, $this->s6->FldErrMsg());
		}
		if (!$this->sc7->FldIsDetailKey && !is_null($this->sc7->FormValue) && $this->sc7->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sc7->FldCaption(), $this->sc7->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sc7->FormValue)) {
			ew_AddMessage($gsFormError, $this->sc7->FldErrMsg());
		}
		if (!$this->s7->FldIsDetailKey && !is_null($this->s7->FormValue) && $this->s7->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s7->FldCaption(), $this->s7->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->s7->FormValue)) {
			ew_AddMessage($gsFormError, $this->s7->FldErrMsg());
		}
		if (!$this->sc8->FldIsDetailKey && !is_null($this->sc8->FormValue) && $this->sc8->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sc8->FldCaption(), $this->sc8->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sc8->FormValue)) {
			ew_AddMessage($gsFormError, $this->sc8->FldErrMsg());
		}
		if (!$this->s8->FldIsDetailKey && !is_null($this->s8->FormValue) && $this->s8->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->s8->FldCaption(), $this->s8->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->s8->FormValue)) {
			ew_AddMessage($gsFormError, $this->s8->FldErrMsg());
		}
		if (!$this->total->FldIsDetailKey && !is_null($this->total->FormValue) && $this->total->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->total->FldCaption(), $this->total->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->total->FormValue)) {
			ew_AddMessage($gsFormError, $this->total->FldErrMsg());
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

		// usn
		$this->usn->SetDbValueDef($rsnew, $this->usn->CurrentValue, "", FALSE);

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, "", FALSE);

		// sc1
		$this->sc1->SetDbValueDef($rsnew, $this->sc1->CurrentValue, "", FALSE);

		// s1
		$this->s1->SetDbValueDef($rsnew, $this->s1->CurrentValue, 0, FALSE);

		// sc2
		$this->sc2->SetDbValueDef($rsnew, $this->sc2->CurrentValue, "", FALSE);

		// s2
		$this->s2->SetDbValueDef($rsnew, $this->s2->CurrentValue, 0, FALSE);

		// sc3
		$this->sc3->SetDbValueDef($rsnew, $this->sc3->CurrentValue, 0, FALSE);

		// s3
		$this->s3->SetDbValueDef($rsnew, $this->s3->CurrentValue, 0, FALSE);

		// sc4
		$this->sc4->SetDbValueDef($rsnew, $this->sc4->CurrentValue, 0, FALSE);

		// s4
		$this->s4->SetDbValueDef($rsnew, $this->s4->CurrentValue, 0, FALSE);

		// sc5
		$this->sc5->SetDbValueDef($rsnew, $this->sc5->CurrentValue, 0, FALSE);

		// s5
		$this->s5->SetDbValueDef($rsnew, $this->s5->CurrentValue, 0, FALSE);

		// sc6
		$this->sc6->SetDbValueDef($rsnew, $this->sc6->CurrentValue, 0, FALSE);

		// s6
		$this->s6->SetDbValueDef($rsnew, $this->s6->CurrentValue, 0, FALSE);

		// sc7
		$this->sc7->SetDbValueDef($rsnew, $this->sc7->CurrentValue, 0, FALSE);

		// s7
		$this->s7->SetDbValueDef($rsnew, $this->s7->CurrentValue, 0, FALSE);

		// sc8
		$this->sc8->SetDbValueDef($rsnew, $this->sc8->CurrentValue, 0, FALSE);

		// s8
		$this->s8->SetDbValueDef($rsnew, $this->s8->CurrentValue, 0, FALSE);

		// total
		$this->total->SetDbValueDef($rsnew, $this->total->CurrentValue, 0, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("resultlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($result_add)) $result_add = new cresult_add();

// Page init
$result_add->Page_Init();

// Page main
$result_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$result_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fresultadd = new ew_Form("fresultadd", "add");

// Validate form
fresultadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_usn");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->usn->FldCaption(), $result->usn->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->name->FldCaption(), $result->name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sc1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->sc1->FldCaption(), $result->sc1->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->s1->FldCaption(), $result->s1->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s1");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->s1->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sc2");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->sc2->FldCaption(), $result->sc2->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s2");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->s2->FldCaption(), $result->s2->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s2");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->s2->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sc3");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->sc3->FldCaption(), $result->sc3->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sc3");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->sc3->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_s3");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->s3->FldCaption(), $result->s3->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s3");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->s3->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sc4");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->sc4->FldCaption(), $result->sc4->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sc4");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->sc4->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_s4");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->s4->FldCaption(), $result->s4->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s4");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->s4->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sc5");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->sc5->FldCaption(), $result->sc5->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sc5");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->sc5->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_s5");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->s5->FldCaption(), $result->s5->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s5");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->s5->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sc6");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->sc6->FldCaption(), $result->sc6->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sc6");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->sc6->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_s6");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->s6->FldCaption(), $result->s6->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s6");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->s6->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sc7");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->sc7->FldCaption(), $result->sc7->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sc7");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->sc7->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_s7");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->s7->FldCaption(), $result->s7->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s7");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->s7->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sc8");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->sc8->FldCaption(), $result->sc8->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sc8");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->sc8->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_s8");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->s8->FldCaption(), $result->s8->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s8");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->s8->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $result->total->FldCaption(), $result->total->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_total");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($result->total->FldErrMsg()) ?>");

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
fresultadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fresultadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $result_add->ShowPageHeader(); ?>
<?php
$result_add->ShowMessage();
?>
<form name="fresultadd" id="fresultadd" class="<?php echo $result_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($result_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $result_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="result">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($result_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($result->usn->Visible) { // usn ?>
	<div id="r_usn" class="form-group">
		<label id="elh_result_usn" for="x_usn" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->usn->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->usn->CellAttributes() ?>>
<span id="el_result_usn">
<input type="text" data-table="result" data-field="x_usn" name="x_usn" id="x_usn" size="30" maxlength="11" placeholder="<?php echo ew_HtmlEncode($result->usn->getPlaceHolder()) ?>" value="<?php echo $result->usn->EditValue ?>"<?php echo $result->usn->EditAttributes() ?>>
</span>
<?php echo $result->usn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_result_name" for="x_name" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->name->CellAttributes() ?>>
<span id="el_result_name">
<input type="text" data-table="result" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($result->name->getPlaceHolder()) ?>" value="<?php echo $result->name->EditValue ?>"<?php echo $result->name->EditAttributes() ?>>
</span>
<?php echo $result->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->sc1->Visible) { // sc1 ?>
	<div id="r_sc1" class="form-group">
		<label id="elh_result_sc1" for="x_sc1" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->sc1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->sc1->CellAttributes() ?>>
<span id="el_result_sc1">
<input type="text" data-table="result" data-field="x_sc1" name="x_sc1" id="x_sc1" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($result->sc1->getPlaceHolder()) ?>" value="<?php echo $result->sc1->EditValue ?>"<?php echo $result->sc1->EditAttributes() ?>>
</span>
<?php echo $result->sc1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->s1->Visible) { // s1 ?>
	<div id="r_s1" class="form-group">
		<label id="elh_result_s1" for="x_s1" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->s1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->s1->CellAttributes() ?>>
<span id="el_result_s1">
<input type="text" data-table="result" data-field="x_s1" name="x_s1" id="x_s1" size="30" placeholder="<?php echo ew_HtmlEncode($result->s1->getPlaceHolder()) ?>" value="<?php echo $result->s1->EditValue ?>"<?php echo $result->s1->EditAttributes() ?>>
</span>
<?php echo $result->s1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->sc2->Visible) { // sc2 ?>
	<div id="r_sc2" class="form-group">
		<label id="elh_result_sc2" for="x_sc2" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->sc2->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->sc2->CellAttributes() ?>>
<span id="el_result_sc2">
<input type="text" data-table="result" data-field="x_sc2" name="x_sc2" id="x_sc2" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($result->sc2->getPlaceHolder()) ?>" value="<?php echo $result->sc2->EditValue ?>"<?php echo $result->sc2->EditAttributes() ?>>
</span>
<?php echo $result->sc2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->s2->Visible) { // s2 ?>
	<div id="r_s2" class="form-group">
		<label id="elh_result_s2" for="x_s2" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->s2->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->s2->CellAttributes() ?>>
<span id="el_result_s2">
<input type="text" data-table="result" data-field="x_s2" name="x_s2" id="x_s2" size="30" placeholder="<?php echo ew_HtmlEncode($result->s2->getPlaceHolder()) ?>" value="<?php echo $result->s2->EditValue ?>"<?php echo $result->s2->EditAttributes() ?>>
</span>
<?php echo $result->s2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->sc3->Visible) { // sc3 ?>
	<div id="r_sc3" class="form-group">
		<label id="elh_result_sc3" for="x_sc3" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->sc3->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->sc3->CellAttributes() ?>>
<span id="el_result_sc3">
<input type="text" data-table="result" data-field="x_sc3" name="x_sc3" id="x_sc3" size="30" placeholder="<?php echo ew_HtmlEncode($result->sc3->getPlaceHolder()) ?>" value="<?php echo $result->sc3->EditValue ?>"<?php echo $result->sc3->EditAttributes() ?>>
</span>
<?php echo $result->sc3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->s3->Visible) { // s3 ?>
	<div id="r_s3" class="form-group">
		<label id="elh_result_s3" for="x_s3" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->s3->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->s3->CellAttributes() ?>>
<span id="el_result_s3">
<input type="text" data-table="result" data-field="x_s3" name="x_s3" id="x_s3" size="30" placeholder="<?php echo ew_HtmlEncode($result->s3->getPlaceHolder()) ?>" value="<?php echo $result->s3->EditValue ?>"<?php echo $result->s3->EditAttributes() ?>>
</span>
<?php echo $result->s3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->sc4->Visible) { // sc4 ?>
	<div id="r_sc4" class="form-group">
		<label id="elh_result_sc4" for="x_sc4" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->sc4->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->sc4->CellAttributes() ?>>
<span id="el_result_sc4">
<input type="text" data-table="result" data-field="x_sc4" name="x_sc4" id="x_sc4" size="30" placeholder="<?php echo ew_HtmlEncode($result->sc4->getPlaceHolder()) ?>" value="<?php echo $result->sc4->EditValue ?>"<?php echo $result->sc4->EditAttributes() ?>>
</span>
<?php echo $result->sc4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->s4->Visible) { // s4 ?>
	<div id="r_s4" class="form-group">
		<label id="elh_result_s4" for="x_s4" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->s4->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->s4->CellAttributes() ?>>
<span id="el_result_s4">
<input type="text" data-table="result" data-field="x_s4" name="x_s4" id="x_s4" size="30" placeholder="<?php echo ew_HtmlEncode($result->s4->getPlaceHolder()) ?>" value="<?php echo $result->s4->EditValue ?>"<?php echo $result->s4->EditAttributes() ?>>
</span>
<?php echo $result->s4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->sc5->Visible) { // sc5 ?>
	<div id="r_sc5" class="form-group">
		<label id="elh_result_sc5" for="x_sc5" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->sc5->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->sc5->CellAttributes() ?>>
<span id="el_result_sc5">
<input type="text" data-table="result" data-field="x_sc5" name="x_sc5" id="x_sc5" size="30" placeholder="<?php echo ew_HtmlEncode($result->sc5->getPlaceHolder()) ?>" value="<?php echo $result->sc5->EditValue ?>"<?php echo $result->sc5->EditAttributes() ?>>
</span>
<?php echo $result->sc5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->s5->Visible) { // s5 ?>
	<div id="r_s5" class="form-group">
		<label id="elh_result_s5" for="x_s5" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->s5->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->s5->CellAttributes() ?>>
<span id="el_result_s5">
<input type="text" data-table="result" data-field="x_s5" name="x_s5" id="x_s5" size="30" placeholder="<?php echo ew_HtmlEncode($result->s5->getPlaceHolder()) ?>" value="<?php echo $result->s5->EditValue ?>"<?php echo $result->s5->EditAttributes() ?>>
</span>
<?php echo $result->s5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->sc6->Visible) { // sc6 ?>
	<div id="r_sc6" class="form-group">
		<label id="elh_result_sc6" for="x_sc6" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->sc6->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->sc6->CellAttributes() ?>>
<span id="el_result_sc6">
<input type="text" data-table="result" data-field="x_sc6" name="x_sc6" id="x_sc6" size="30" placeholder="<?php echo ew_HtmlEncode($result->sc6->getPlaceHolder()) ?>" value="<?php echo $result->sc6->EditValue ?>"<?php echo $result->sc6->EditAttributes() ?>>
</span>
<?php echo $result->sc6->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->s6->Visible) { // s6 ?>
	<div id="r_s6" class="form-group">
		<label id="elh_result_s6" for="x_s6" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->s6->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->s6->CellAttributes() ?>>
<span id="el_result_s6">
<input type="text" data-table="result" data-field="x_s6" name="x_s6" id="x_s6" size="30" placeholder="<?php echo ew_HtmlEncode($result->s6->getPlaceHolder()) ?>" value="<?php echo $result->s6->EditValue ?>"<?php echo $result->s6->EditAttributes() ?>>
</span>
<?php echo $result->s6->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->sc7->Visible) { // sc7 ?>
	<div id="r_sc7" class="form-group">
		<label id="elh_result_sc7" for="x_sc7" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->sc7->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->sc7->CellAttributes() ?>>
<span id="el_result_sc7">
<input type="text" data-table="result" data-field="x_sc7" name="x_sc7" id="x_sc7" size="30" placeholder="<?php echo ew_HtmlEncode($result->sc7->getPlaceHolder()) ?>" value="<?php echo $result->sc7->EditValue ?>"<?php echo $result->sc7->EditAttributes() ?>>
</span>
<?php echo $result->sc7->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->s7->Visible) { // s7 ?>
	<div id="r_s7" class="form-group">
		<label id="elh_result_s7" for="x_s7" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->s7->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->s7->CellAttributes() ?>>
<span id="el_result_s7">
<input type="text" data-table="result" data-field="x_s7" name="x_s7" id="x_s7" size="30" placeholder="<?php echo ew_HtmlEncode($result->s7->getPlaceHolder()) ?>" value="<?php echo $result->s7->EditValue ?>"<?php echo $result->s7->EditAttributes() ?>>
</span>
<?php echo $result->s7->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->sc8->Visible) { // sc8 ?>
	<div id="r_sc8" class="form-group">
		<label id="elh_result_sc8" for="x_sc8" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->sc8->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->sc8->CellAttributes() ?>>
<span id="el_result_sc8">
<input type="text" data-table="result" data-field="x_sc8" name="x_sc8" id="x_sc8" size="30" placeholder="<?php echo ew_HtmlEncode($result->sc8->getPlaceHolder()) ?>" value="<?php echo $result->sc8->EditValue ?>"<?php echo $result->sc8->EditAttributes() ?>>
</span>
<?php echo $result->sc8->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->s8->Visible) { // s8 ?>
	<div id="r_s8" class="form-group">
		<label id="elh_result_s8" for="x_s8" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->s8->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->s8->CellAttributes() ?>>
<span id="el_result_s8">
<input type="text" data-table="result" data-field="x_s8" name="x_s8" id="x_s8" size="30" placeholder="<?php echo ew_HtmlEncode($result->s8->getPlaceHolder()) ?>" value="<?php echo $result->s8->EditValue ?>"<?php echo $result->s8->EditAttributes() ?>>
</span>
<?php echo $result->s8->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($result->total->Visible) { // total ?>
	<div id="r_total" class="form-group">
		<label id="elh_result_total" for="x_total" class="<?php echo $result_add->LeftColumnClass ?>"><?php echo $result->total->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $result_add->RightColumnClass ?>"><div<?php echo $result->total->CellAttributes() ?>>
<span id="el_result_total">
<input type="text" data-table="result" data-field="x_total" name="x_total" id="x_total" size="30" placeholder="<?php echo ew_HtmlEncode($result->total->getPlaceHolder()) ?>" value="<?php echo $result->total->EditValue ?>"<?php echo $result->total->EditAttributes() ?>>
</span>
<?php echo $result->total->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$result_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $result_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $result_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fresultadd.Init();
</script>
<?php
$result_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$result_add->Page_Terminate();
?>
