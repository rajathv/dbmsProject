<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "studentinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$student_add = NULL; // Initialize page object first

class cstudent_add extends cstudent {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{7dac28fc-e6ee-49d2-b722-398a2b30146f}';

	// Table name
	var $TableName = 'student';

	// Page object name
	var $PageObjName = 'student_add';

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

		// Table object (student)
		if (!isset($GLOBALS["student"]) || get_class($GLOBALS["student"]) == "cstudent") {
			$GLOBALS["student"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["student"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'student', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("studentlist.php"));
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
		$this->sem->SetVisibility();
		$this->_email->SetVisibility();
		$this->gender->SetVisibility();
		$this->backlogs->SetVisibility();
		$this->fid->SetVisibility();

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
		global $EW_EXPORT, $student;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($student);
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
					if ($pageName == "studentview.php")
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
			if (@$_GET["usn"] != "") {
				$this->usn->setQueryStringValue($_GET["usn"]);
				$this->setKey("usn", $this->usn->CurrentValue); // Set up key
			} else {
				$this->setKey("usn", ""); // Clear key
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
					$this->Page_Terminate("studentlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "studentlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "studentview.php")
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
		$this->usn->CurrentValue = NULL;
		$this->usn->OldValue = $this->usn->CurrentValue;
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->sem->CurrentValue = NULL;
		$this->sem->OldValue = $this->sem->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->gender->CurrentValue = NULL;
		$this->gender->OldValue = $this->gender->CurrentValue;
		$this->backlogs->CurrentValue = NULL;
		$this->backlogs->OldValue = $this->backlogs->CurrentValue;
		$this->fid->CurrentValue = NULL;
		$this->fid->OldValue = $this->fid->CurrentValue;
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
		if (!$this->sem->FldIsDetailKey) {
			$this->sem->setFormValue($objForm->GetValue("x_sem"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		if (!$this->backlogs->FldIsDetailKey) {
			$this->backlogs->setFormValue($objForm->GetValue("x_backlogs"));
		}
		if (!$this->fid->FldIsDetailKey) {
			$this->fid->setFormValue($objForm->GetValue("x_fid"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->usn->CurrentValue = $this->usn->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->sem->CurrentValue = $this->sem->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->backlogs->CurrentValue = $this->backlogs->FormValue;
		$this->fid->CurrentValue = $this->fid->FormValue;
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
		$this->usn->setDbValue($row['usn']);
		$this->name->setDbValue($row['name']);
		$this->sem->setDbValue($row['sem']);
		$this->_email->setDbValue($row['email']);
		$this->gender->setDbValue($row['gender']);
		$this->backlogs->setDbValue($row['backlogs']);
		$this->fid->setDbValue($row['fid']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['usn'] = $this->usn->CurrentValue;
		$row['name'] = $this->name->CurrentValue;
		$row['sem'] = $this->sem->CurrentValue;
		$row['email'] = $this->_email->CurrentValue;
		$row['gender'] = $this->gender->CurrentValue;
		$row['backlogs'] = $this->backlogs->CurrentValue;
		$row['fid'] = $this->fid->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->usn->DbValue = $row['usn'];
		$this->name->DbValue = $row['name'];
		$this->sem->DbValue = $row['sem'];
		$this->_email->DbValue = $row['email'];
		$this->gender->DbValue = $row['gender'];
		$this->backlogs->DbValue = $row['backlogs'];
		$this->fid->DbValue = $row['fid'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("usn")) <> "")
			$this->usn->CurrentValue = $this->getKey("usn"); // usn
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
		// usn
		// name
		// sem
		// email
		// gender
		// backlogs
		// fid

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// usn
		$this->usn->ViewValue = $this->usn->CurrentValue;
		$this->usn->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// sem
		$this->sem->ViewValue = $this->sem->CurrentValue;
		$this->sem->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// gender
		$this->gender->ViewValue = $this->gender->CurrentValue;
		$this->gender->ViewCustomAttributes = "";

		// backlogs
		$this->backlogs->ViewValue = $this->backlogs->CurrentValue;
		$this->backlogs->ViewCustomAttributes = "";

		// fid
		$this->fid->ViewValue = $this->fid->CurrentValue;
		$this->fid->ViewCustomAttributes = "";

			// usn
			$this->usn->LinkCustomAttributes = "";
			$this->usn->HrefValue = "";
			$this->usn->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// sem
			$this->sem->LinkCustomAttributes = "";
			$this->sem->HrefValue = "";
			$this->sem->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";
			$this->gender->TooltipValue = "";

			// backlogs
			$this->backlogs->LinkCustomAttributes = "";
			$this->backlogs->HrefValue = "";
			$this->backlogs->TooltipValue = "";

			// fid
			$this->fid->LinkCustomAttributes = "";
			$this->fid->HrefValue = "";
			$this->fid->TooltipValue = "";
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

			// sem
			$this->sem->EditAttrs["class"] = "form-control";
			$this->sem->EditCustomAttributes = "";
			$this->sem->EditValue = ew_HtmlEncode($this->sem->CurrentValue);
			$this->sem->PlaceHolder = ew_RemoveHtml($this->sem->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// gender
			$this->gender->EditAttrs["class"] = "form-control";
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = ew_HtmlEncode($this->gender->CurrentValue);
			$this->gender->PlaceHolder = ew_RemoveHtml($this->gender->FldCaption());

			// backlogs
			$this->backlogs->EditAttrs["class"] = "form-control";
			$this->backlogs->EditCustomAttributes = "";
			$this->backlogs->EditValue = ew_HtmlEncode($this->backlogs->CurrentValue);
			$this->backlogs->PlaceHolder = ew_RemoveHtml($this->backlogs->FldCaption());

			// fid
			$this->fid->EditAttrs["class"] = "form-control";
			$this->fid->EditCustomAttributes = "";
			$this->fid->EditValue = ew_HtmlEncode($this->fid->CurrentValue);
			$this->fid->PlaceHolder = ew_RemoveHtml($this->fid->FldCaption());

			// Add refer script
			// usn

			$this->usn->LinkCustomAttributes = "";
			$this->usn->HrefValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";

			// sem
			$this->sem->LinkCustomAttributes = "";
			$this->sem->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";

			// backlogs
			$this->backlogs->LinkCustomAttributes = "";
			$this->backlogs->HrefValue = "";

			// fid
			$this->fid->LinkCustomAttributes = "";
			$this->fid->HrefValue = "";
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
		if (!$this->sem->FldIsDetailKey && !is_null($this->sem->FormValue) && $this->sem->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sem->FldCaption(), $this->sem->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sem->FormValue)) {
			ew_AddMessage($gsFormError, $this->sem->FldErrMsg());
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_email->FldCaption(), $this->_email->ReqErrMsg));
		}
		if (!$this->gender->FldIsDetailKey && !is_null($this->gender->FormValue) && $this->gender->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->gender->FldCaption(), $this->gender->ReqErrMsg));
		}
		if (!$this->backlogs->FldIsDetailKey && !is_null($this->backlogs->FormValue) && $this->backlogs->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->backlogs->FldCaption(), $this->backlogs->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->backlogs->FormValue)) {
			ew_AddMessage($gsFormError, $this->backlogs->FldErrMsg());
		}
		if (!$this->fid->FldIsDetailKey && !is_null($this->fid->FormValue) && $this->fid->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->fid->FldCaption(), $this->fid->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->fid->FormValue)) {
			ew_AddMessage($gsFormError, $this->fid->FldErrMsg());
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

		// sem
		$this->sem->SetDbValueDef($rsnew, $this->sem->CurrentValue, 0, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", FALSE);

		// gender
		$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, "", FALSE);

		// backlogs
		$this->backlogs->SetDbValueDef($rsnew, $this->backlogs->CurrentValue, 0, FALSE);

		// fid
		$this->fid->SetDbValueDef($rsnew, $this->fid->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['usn']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("studentlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($student_add)) $student_add = new cstudent_add();

// Page init
$student_add->Page_Init();

// Page main
$student_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$student_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fstudentadd = new ew_Form("fstudentadd", "add");

// Validate form
fstudentadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $student->usn->FldCaption(), $student->usn->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $student->name->FldCaption(), $student->name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sem");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $student->sem->FldCaption(), $student->sem->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sem");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($student->sem->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $student->_email->FldCaption(), $student->_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_gender");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $student->gender->FldCaption(), $student->gender->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_backlogs");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $student->backlogs->FldCaption(), $student->backlogs->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_backlogs");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($student->backlogs->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $student->fid->FldCaption(), $student->fid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($student->fid->FldErrMsg()) ?>");

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
fstudentadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fstudentadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $student_add->ShowPageHeader(); ?>
<?php
$student_add->ShowMessage();
?>
<form name="fstudentadd" id="fstudentadd" class="<?php echo $student_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($student_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $student_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="student">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($student_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($student->usn->Visible) { // usn ?>
	<div id="r_usn" class="form-group">
		<label id="elh_student_usn" for="x_usn" class="<?php echo $student_add->LeftColumnClass ?>"><?php echo $student->usn->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $student_add->RightColumnClass ?>"><div<?php echo $student->usn->CellAttributes() ?>>
<span id="el_student_usn">
<input type="text" data-table="student" data-field="x_usn" name="x_usn" id="x_usn" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($student->usn->getPlaceHolder()) ?>" value="<?php echo $student->usn->EditValue ?>"<?php echo $student->usn->EditAttributes() ?>>
</span>
<?php echo $student->usn->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($student->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_student_name" for="x_name" class="<?php echo $student_add->LeftColumnClass ?>"><?php echo $student->name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $student_add->RightColumnClass ?>"><div<?php echo $student->name->CellAttributes() ?>>
<span id="el_student_name">
<input type="text" data-table="student" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($student->name->getPlaceHolder()) ?>" value="<?php echo $student->name->EditValue ?>"<?php echo $student->name->EditAttributes() ?>>
</span>
<?php echo $student->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($student->sem->Visible) { // sem ?>
	<div id="r_sem" class="form-group">
		<label id="elh_student_sem" for="x_sem" class="<?php echo $student_add->LeftColumnClass ?>"><?php echo $student->sem->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $student_add->RightColumnClass ?>"><div<?php echo $student->sem->CellAttributes() ?>>
<span id="el_student_sem">
<input type="text" data-table="student" data-field="x_sem" name="x_sem" id="x_sem" size="30" placeholder="<?php echo ew_HtmlEncode($student->sem->getPlaceHolder()) ?>" value="<?php echo $student->sem->EditValue ?>"<?php echo $student->sem->EditAttributes() ?>>
</span>
<?php echo $student->sem->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($student->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_student__email" for="x__email" class="<?php echo $student_add->LeftColumnClass ?>"><?php echo $student->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $student_add->RightColumnClass ?>"><div<?php echo $student->_email->CellAttributes() ?>>
<span id="el_student__email">
<input type="text" data-table="student" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($student->_email->getPlaceHolder()) ?>" value="<?php echo $student->_email->EditValue ?>"<?php echo $student->_email->EditAttributes() ?>>
</span>
<?php echo $student->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($student->gender->Visible) { // gender ?>
	<div id="r_gender" class="form-group">
		<label id="elh_student_gender" for="x_gender" class="<?php echo $student_add->LeftColumnClass ?>"><?php echo $student->gender->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $student_add->RightColumnClass ?>"><div<?php echo $student->gender->CellAttributes() ?>>
<span id="el_student_gender">
<input type="text" data-table="student" data-field="x_gender" name="x_gender" id="x_gender" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($student->gender->getPlaceHolder()) ?>" value="<?php echo $student->gender->EditValue ?>"<?php echo $student->gender->EditAttributes() ?>>
</span>
<?php echo $student->gender->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($student->backlogs->Visible) { // backlogs ?>
	<div id="r_backlogs" class="form-group">
		<label id="elh_student_backlogs" for="x_backlogs" class="<?php echo $student_add->LeftColumnClass ?>"><?php echo $student->backlogs->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $student_add->RightColumnClass ?>"><div<?php echo $student->backlogs->CellAttributes() ?>>
<span id="el_student_backlogs">
<input type="text" data-table="student" data-field="x_backlogs" name="x_backlogs" id="x_backlogs" size="30" placeholder="<?php echo ew_HtmlEncode($student->backlogs->getPlaceHolder()) ?>" value="<?php echo $student->backlogs->EditValue ?>"<?php echo $student->backlogs->EditAttributes() ?>>
</span>
<?php echo $student->backlogs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($student->fid->Visible) { // fid ?>
	<div id="r_fid" class="form-group">
		<label id="elh_student_fid" for="x_fid" class="<?php echo $student_add->LeftColumnClass ?>"><?php echo $student->fid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $student_add->RightColumnClass ?>"><div<?php echo $student->fid->CellAttributes() ?>>
<span id="el_student_fid">
<input type="text" data-table="student" data-field="x_fid" name="x_fid" id="x_fid" size="30" placeholder="<?php echo ew_HtmlEncode($student->fid->getPlaceHolder()) ?>" value="<?php echo $student->fid->EditValue ?>"<?php echo $student->fid->EditAttributes() ?>>
</span>
<?php echo $student->fid->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$student_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $student_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $student_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fstudentadd.Init();
</script>
<?php
$student_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$student_add->Page_Terminate();
?>
