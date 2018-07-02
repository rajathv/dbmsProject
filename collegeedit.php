<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "collegeinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$college_edit = NULL; // Initialize page object first

class ccollege_edit extends ccollege {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{7dac28fc-e6ee-49d2-b722-398a2b30146f}';

	// Table name
	var $TableName = 'college';

	// Page object name
	var $PageObjName = 'college_edit';

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

		// Table object (college)
		if (!isset($GLOBALS["college"]) || get_class($GLOBALS["college"]) == "ccollege") {
			$GLOBALS["college"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["college"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'college', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("collegelist.php"));
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
		$this->cid->SetVisibility();
		$this->cid->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->cname->SetVisibility();
		$this->cregion->SetVisibility();
		$this->ccode->SetVisibility();
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
		global $EW_EXPORT, $college;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($college);
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
					if ($pageName == "collegeview.php")
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_cid")) {
				$this->cid->setFormValue($objForm->GetValue("x_cid"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["cid"])) {
				$this->cid->setQueryStringValue($_GET["cid"]);
				$loadByQuery = TRUE;
			} else {
				$this->cid->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("collegelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "collegelist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->cid->FldIsDetailKey)
			$this->cid->setFormValue($objForm->GetValue("x_cid"));
		if (!$this->cname->FldIsDetailKey) {
			$this->cname->setFormValue($objForm->GetValue("x_cname"));
		}
		if (!$this->cregion->FldIsDetailKey) {
			$this->cregion->setFormValue($objForm->GetValue("x_cregion"));
		}
		if (!$this->ccode->FldIsDetailKey) {
			$this->ccode->setFormValue($objForm->GetValue("x_ccode"));
		}
		if (!$this->fid->FldIsDetailKey) {
			$this->fid->setFormValue($objForm->GetValue("x_fid"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->cid->CurrentValue = $this->cid->FormValue;
		$this->cname->CurrentValue = $this->cname->FormValue;
		$this->cregion->CurrentValue = $this->cregion->FormValue;
		$this->ccode->CurrentValue = $this->ccode->FormValue;
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
		$this->cid->setDbValue($row['cid']);
		$this->cname->setDbValue($row['cname']);
		$this->cregion->setDbValue($row['cregion']);
		$this->ccode->setDbValue($row['ccode']);
		$this->fid->setDbValue($row['fid']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['cid'] = NULL;
		$row['cname'] = NULL;
		$row['cregion'] = NULL;
		$row['ccode'] = NULL;
		$row['fid'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->cid->DbValue = $row['cid'];
		$this->cname->DbValue = $row['cname'];
		$this->cregion->DbValue = $row['cregion'];
		$this->ccode->DbValue = $row['ccode'];
		$this->fid->DbValue = $row['fid'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("cid")) <> "")
			$this->cid->CurrentValue = $this->getKey("cid"); // cid
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
		// cid
		// cname
		// cregion
		// ccode
		// fid

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// cid
		$this->cid->ViewValue = $this->cid->CurrentValue;
		$this->cid->ViewCustomAttributes = "";

		// cname
		$this->cname->ViewValue = $this->cname->CurrentValue;
		$this->cname->ViewCustomAttributes = "";

		// cregion
		$this->cregion->ViewValue = $this->cregion->CurrentValue;
		$this->cregion->ViewCustomAttributes = "";

		// ccode
		$this->ccode->ViewValue = $this->ccode->CurrentValue;
		$this->ccode->ViewCustomAttributes = "";

		// fid
		$this->fid->ViewValue = $this->fid->CurrentValue;
		$this->fid->ViewCustomAttributes = "";

			// cid
			$this->cid->LinkCustomAttributes = "";
			$this->cid->HrefValue = "";
			$this->cid->TooltipValue = "";

			// cname
			$this->cname->LinkCustomAttributes = "";
			$this->cname->HrefValue = "";
			$this->cname->TooltipValue = "";

			// cregion
			$this->cregion->LinkCustomAttributes = "";
			$this->cregion->HrefValue = "";
			$this->cregion->TooltipValue = "";

			// ccode
			$this->ccode->LinkCustomAttributes = "";
			$this->ccode->HrefValue = "";
			$this->ccode->TooltipValue = "";

			// fid
			$this->fid->LinkCustomAttributes = "";
			$this->fid->HrefValue = "";
			$this->fid->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// cid
			$this->cid->EditAttrs["class"] = "form-control";
			$this->cid->EditCustomAttributes = "";
			$this->cid->EditValue = $this->cid->CurrentValue;
			$this->cid->ViewCustomAttributes = "";

			// cname
			$this->cname->EditAttrs["class"] = "form-control";
			$this->cname->EditCustomAttributes = "";
			$this->cname->EditValue = ew_HtmlEncode($this->cname->CurrentValue);
			$this->cname->PlaceHolder = ew_RemoveHtml($this->cname->FldCaption());

			// cregion
			$this->cregion->EditAttrs["class"] = "form-control";
			$this->cregion->EditCustomAttributes = "";
			$this->cregion->EditValue = ew_HtmlEncode($this->cregion->CurrentValue);
			$this->cregion->PlaceHolder = ew_RemoveHtml($this->cregion->FldCaption());

			// ccode
			$this->ccode->EditAttrs["class"] = "form-control";
			$this->ccode->EditCustomAttributes = "";
			$this->ccode->EditValue = ew_HtmlEncode($this->ccode->CurrentValue);
			$this->ccode->PlaceHolder = ew_RemoveHtml($this->ccode->FldCaption());

			// fid
			$this->fid->EditAttrs["class"] = "form-control";
			$this->fid->EditCustomAttributes = "";
			$this->fid->EditValue = ew_HtmlEncode($this->fid->CurrentValue);
			$this->fid->PlaceHolder = ew_RemoveHtml($this->fid->FldCaption());

			// Edit refer script
			// cid

			$this->cid->LinkCustomAttributes = "";
			$this->cid->HrefValue = "";

			// cname
			$this->cname->LinkCustomAttributes = "";
			$this->cname->HrefValue = "";

			// cregion
			$this->cregion->LinkCustomAttributes = "";
			$this->cregion->HrefValue = "";

			// ccode
			$this->ccode->LinkCustomAttributes = "";
			$this->ccode->HrefValue = "";

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
		if (!$this->cname->FldIsDetailKey && !is_null($this->cname->FormValue) && $this->cname->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cname->FldCaption(), $this->cname->ReqErrMsg));
		}
		if (!$this->cregion->FldIsDetailKey && !is_null($this->cregion->FormValue) && $this->cregion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cregion->FldCaption(), $this->cregion->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->cregion->FormValue)) {
			ew_AddMessage($gsFormError, $this->cregion->FldErrMsg());
		}
		if (!$this->ccode->FldIsDetailKey && !is_null($this->ccode->FormValue) && $this->ccode->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ccode->FldCaption(), $this->ccode->ReqErrMsg));
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// cname
			$this->cname->SetDbValueDef($rsnew, $this->cname->CurrentValue, "", $this->cname->ReadOnly);

			// cregion
			$this->cregion->SetDbValueDef($rsnew, $this->cregion->CurrentValue, 0, $this->cregion->ReadOnly);

			// ccode
			$this->ccode->SetDbValueDef($rsnew, $this->ccode->CurrentValue, "", $this->ccode->ReadOnly);

			// fid
			$this->fid->SetDbValueDef($rsnew, $this->fid->CurrentValue, 0, $this->fid->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("collegelist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($college_edit)) $college_edit = new ccollege_edit();

// Page init
$college_edit->Page_Init();

// Page main
$college_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$college_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fcollegeedit = new ew_Form("fcollegeedit", "edit");

// Validate form
fcollegeedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_cname");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $college->cname->FldCaption(), $college->cname->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cregion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $college->cregion->FldCaption(), $college->cregion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cregion");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($college->cregion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_ccode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $college->ccode->FldCaption(), $college->ccode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $college->fid->FldCaption(), $college->fid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($college->fid->FldErrMsg()) ?>");

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
fcollegeedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcollegeedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $college_edit->ShowPageHeader(); ?>
<?php
$college_edit->ShowMessage();
?>
<form name="fcollegeedit" id="fcollegeedit" class="<?php echo $college_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($college_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $college_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="college">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($college_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($college->cid->Visible) { // cid ?>
	<div id="r_cid" class="form-group">
		<label id="elh_college_cid" class="<?php echo $college_edit->LeftColumnClass ?>"><?php echo $college->cid->FldCaption() ?></label>
		<div class="<?php echo $college_edit->RightColumnClass ?>"><div<?php echo $college->cid->CellAttributes() ?>>
<span id="el_college_cid">
<span<?php echo $college->cid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $college->cid->EditValue ?></p></span>
</span>
<input type="hidden" data-table="college" data-field="x_cid" name="x_cid" id="x_cid" value="<?php echo ew_HtmlEncode($college->cid->CurrentValue) ?>">
<?php echo $college->cid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($college->cname->Visible) { // cname ?>
	<div id="r_cname" class="form-group">
		<label id="elh_college_cname" for="x_cname" class="<?php echo $college_edit->LeftColumnClass ?>"><?php echo $college->cname->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $college_edit->RightColumnClass ?>"><div<?php echo $college->cname->CellAttributes() ?>>
<span id="el_college_cname">
<input type="text" data-table="college" data-field="x_cname" name="x_cname" id="x_cname" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($college->cname->getPlaceHolder()) ?>" value="<?php echo $college->cname->EditValue ?>"<?php echo $college->cname->EditAttributes() ?>>
</span>
<?php echo $college->cname->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($college->cregion->Visible) { // cregion ?>
	<div id="r_cregion" class="form-group">
		<label id="elh_college_cregion" for="x_cregion" class="<?php echo $college_edit->LeftColumnClass ?>"><?php echo $college->cregion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $college_edit->RightColumnClass ?>"><div<?php echo $college->cregion->CellAttributes() ?>>
<span id="el_college_cregion">
<input type="text" data-table="college" data-field="x_cregion" name="x_cregion" id="x_cregion" size="30" placeholder="<?php echo ew_HtmlEncode($college->cregion->getPlaceHolder()) ?>" value="<?php echo $college->cregion->EditValue ?>"<?php echo $college->cregion->EditAttributes() ?>>
</span>
<?php echo $college->cregion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($college->ccode->Visible) { // ccode ?>
	<div id="r_ccode" class="form-group">
		<label id="elh_college_ccode" for="x_ccode" class="<?php echo $college_edit->LeftColumnClass ?>"><?php echo $college->ccode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $college_edit->RightColumnClass ?>"><div<?php echo $college->ccode->CellAttributes() ?>>
<span id="el_college_ccode">
<input type="text" data-table="college" data-field="x_ccode" name="x_ccode" id="x_ccode" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($college->ccode->getPlaceHolder()) ?>" value="<?php echo $college->ccode->EditValue ?>"<?php echo $college->ccode->EditAttributes() ?>>
</span>
<?php echo $college->ccode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($college->fid->Visible) { // fid ?>
	<div id="r_fid" class="form-group">
		<label id="elh_college_fid" for="x_fid" class="<?php echo $college_edit->LeftColumnClass ?>"><?php echo $college->fid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $college_edit->RightColumnClass ?>"><div<?php echo $college->fid->CellAttributes() ?>>
<span id="el_college_fid">
<input type="text" data-table="college" data-field="x_fid" name="x_fid" id="x_fid" size="30" placeholder="<?php echo ew_HtmlEncode($college->fid->getPlaceHolder()) ?>" value="<?php echo $college->fid->EditValue ?>"<?php echo $college->fid->EditAttributes() ?>>
</span>
<?php echo $college->fid->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$college_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $college_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $college_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcollegeedit.Init();
</script>
<?php
$college_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$college_edit->Page_Terminate();
?>
