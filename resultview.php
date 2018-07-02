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

$result_view = NULL; // Initialize page object first

class cresult_view extends cresult {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{7dac28fc-e6ee-49d2-b722-398a2b30146f}';

	// Table name
	var $TableName = 'result';

	// Page object name
	var $PageObjName = 'result_view';

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
		$KeyUrl = "";
		if (@$_GET["rid"] <> "") {
			$this->RecKey["rid"] = $_GET["rid"];
			$KeyUrl .= "&amp;rid=" . urlencode($this->RecKey["rid"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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
		if (@$_GET["rid"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= $_GET["rid"];
		}

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

		// Setup export options
		$this->SetupExportOptions();
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["rid"] <> "") {
				$this->rid->setQueryStringValue($_GET["rid"]);
				$this->RecKey["rid"] = $this->rid->QueryStringValue;
			} elseif (@$_POST["rid"] <> "") {
				$this->rid->setFormValue($_POST["rid"]);
				$this->RecKey["rid"] = $this->rid->FormValue;
			} else {
				$sReturnUrl = "resultlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "resultlist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "resultlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->IsLoggedIn());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->IsLoggedIn());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->IsLoggedIn());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

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
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_result\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_result',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fresultview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

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
		$this->SetupStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
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
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("resultlist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($result_view)) $result_view = new cresult_view();

// Page init
$result_view->Page_Init();

// Page main
$result_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$result_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($result->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fresultview = new ew_Form("fresultview", "view");

// Form_CustomValidate event
fresultview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fresultview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($result->Export == "") { ?>
<div class="ewToolbar">
<?php $result_view->ExportOptions->Render("body") ?>
<?php
	foreach ($result_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $result_view->ShowPageHeader(); ?>
<?php
$result_view->ShowMessage();
?>
<form name="fresultview" id="fresultview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($result_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $result_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="result">
<input type="hidden" name="modal" value="<?php echo intval($result_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($result->rid->Visible) { // rid ?>
	<tr id="r_rid">
		<td class="col-sm-2"><span id="elh_result_rid"><?php echo $result->rid->FldCaption() ?></span></td>
		<td data-name="rid"<?php echo $result->rid->CellAttributes() ?>>
<span id="el_result_rid">
<span<?php echo $result->rid->ViewAttributes() ?>>
<?php echo $result->rid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->usn->Visible) { // usn ?>
	<tr id="r_usn">
		<td class="col-sm-2"><span id="elh_result_usn"><?php echo $result->usn->FldCaption() ?></span></td>
		<td data-name="usn"<?php echo $result->usn->CellAttributes() ?>>
<span id="el_result_usn">
<span<?php echo $result->usn->ViewAttributes() ?>>
<?php echo $result->usn->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->name->Visible) { // name ?>
	<tr id="r_name">
		<td class="col-sm-2"><span id="elh_result_name"><?php echo $result->name->FldCaption() ?></span></td>
		<td data-name="name"<?php echo $result->name->CellAttributes() ?>>
<span id="el_result_name">
<span<?php echo $result->name->ViewAttributes() ?>>
<?php echo $result->name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->sc1->Visible) { // sc1 ?>
	<tr id="r_sc1">
		<td class="col-sm-2"><span id="elh_result_sc1"><?php echo $result->sc1->FldCaption() ?></span></td>
		<td data-name="sc1"<?php echo $result->sc1->CellAttributes() ?>>
<span id="el_result_sc1">
<span<?php echo $result->sc1->ViewAttributes() ?>>
<?php echo $result->sc1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->s1->Visible) { // s1 ?>
	<tr id="r_s1">
		<td class="col-sm-2"><span id="elh_result_s1"><?php echo $result->s1->FldCaption() ?></span></td>
		<td data-name="s1"<?php echo $result->s1->CellAttributes() ?>>
<span id="el_result_s1">
<span<?php echo $result->s1->ViewAttributes() ?>>
<?php echo $result->s1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->sc2->Visible) { // sc2 ?>
	<tr id="r_sc2">
		<td class="col-sm-2"><span id="elh_result_sc2"><?php echo $result->sc2->FldCaption() ?></span></td>
		<td data-name="sc2"<?php echo $result->sc2->CellAttributes() ?>>
<span id="el_result_sc2">
<span<?php echo $result->sc2->ViewAttributes() ?>>
<?php echo $result->sc2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->s2->Visible) { // s2 ?>
	<tr id="r_s2">
		<td class="col-sm-2"><span id="elh_result_s2"><?php echo $result->s2->FldCaption() ?></span></td>
		<td data-name="s2"<?php echo $result->s2->CellAttributes() ?>>
<span id="el_result_s2">
<span<?php echo $result->s2->ViewAttributes() ?>>
<?php echo $result->s2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->sc3->Visible) { // sc3 ?>
	<tr id="r_sc3">
		<td class="col-sm-2"><span id="elh_result_sc3"><?php echo $result->sc3->FldCaption() ?></span></td>
		<td data-name="sc3"<?php echo $result->sc3->CellAttributes() ?>>
<span id="el_result_sc3">
<span<?php echo $result->sc3->ViewAttributes() ?>>
<?php echo $result->sc3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->s3->Visible) { // s3 ?>
	<tr id="r_s3">
		<td class="col-sm-2"><span id="elh_result_s3"><?php echo $result->s3->FldCaption() ?></span></td>
		<td data-name="s3"<?php echo $result->s3->CellAttributes() ?>>
<span id="el_result_s3">
<span<?php echo $result->s3->ViewAttributes() ?>>
<?php echo $result->s3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->sc4->Visible) { // sc4 ?>
	<tr id="r_sc4">
		<td class="col-sm-2"><span id="elh_result_sc4"><?php echo $result->sc4->FldCaption() ?></span></td>
		<td data-name="sc4"<?php echo $result->sc4->CellAttributes() ?>>
<span id="el_result_sc4">
<span<?php echo $result->sc4->ViewAttributes() ?>>
<?php echo $result->sc4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->s4->Visible) { // s4 ?>
	<tr id="r_s4">
		<td class="col-sm-2"><span id="elh_result_s4"><?php echo $result->s4->FldCaption() ?></span></td>
		<td data-name="s4"<?php echo $result->s4->CellAttributes() ?>>
<span id="el_result_s4">
<span<?php echo $result->s4->ViewAttributes() ?>>
<?php echo $result->s4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->sc5->Visible) { // sc5 ?>
	<tr id="r_sc5">
		<td class="col-sm-2"><span id="elh_result_sc5"><?php echo $result->sc5->FldCaption() ?></span></td>
		<td data-name="sc5"<?php echo $result->sc5->CellAttributes() ?>>
<span id="el_result_sc5">
<span<?php echo $result->sc5->ViewAttributes() ?>>
<?php echo $result->sc5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->s5->Visible) { // s5 ?>
	<tr id="r_s5">
		<td class="col-sm-2"><span id="elh_result_s5"><?php echo $result->s5->FldCaption() ?></span></td>
		<td data-name="s5"<?php echo $result->s5->CellAttributes() ?>>
<span id="el_result_s5">
<span<?php echo $result->s5->ViewAttributes() ?>>
<?php echo $result->s5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->sc6->Visible) { // sc6 ?>
	<tr id="r_sc6">
		<td class="col-sm-2"><span id="elh_result_sc6"><?php echo $result->sc6->FldCaption() ?></span></td>
		<td data-name="sc6"<?php echo $result->sc6->CellAttributes() ?>>
<span id="el_result_sc6">
<span<?php echo $result->sc6->ViewAttributes() ?>>
<?php echo $result->sc6->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->s6->Visible) { // s6 ?>
	<tr id="r_s6">
		<td class="col-sm-2"><span id="elh_result_s6"><?php echo $result->s6->FldCaption() ?></span></td>
		<td data-name="s6"<?php echo $result->s6->CellAttributes() ?>>
<span id="el_result_s6">
<span<?php echo $result->s6->ViewAttributes() ?>>
<?php echo $result->s6->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->sc7->Visible) { // sc7 ?>
	<tr id="r_sc7">
		<td class="col-sm-2"><span id="elh_result_sc7"><?php echo $result->sc7->FldCaption() ?></span></td>
		<td data-name="sc7"<?php echo $result->sc7->CellAttributes() ?>>
<span id="el_result_sc7">
<span<?php echo $result->sc7->ViewAttributes() ?>>
<?php echo $result->sc7->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->s7->Visible) { // s7 ?>
	<tr id="r_s7">
		<td class="col-sm-2"><span id="elh_result_s7"><?php echo $result->s7->FldCaption() ?></span></td>
		<td data-name="s7"<?php echo $result->s7->CellAttributes() ?>>
<span id="el_result_s7">
<span<?php echo $result->s7->ViewAttributes() ?>>
<?php echo $result->s7->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->sc8->Visible) { // sc8 ?>
	<tr id="r_sc8">
		<td class="col-sm-2"><span id="elh_result_sc8"><?php echo $result->sc8->FldCaption() ?></span></td>
		<td data-name="sc8"<?php echo $result->sc8->CellAttributes() ?>>
<span id="el_result_sc8">
<span<?php echo $result->sc8->ViewAttributes() ?>>
<?php echo $result->sc8->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->s8->Visible) { // s8 ?>
	<tr id="r_s8">
		<td class="col-sm-2"><span id="elh_result_s8"><?php echo $result->s8->FldCaption() ?></span></td>
		<td data-name="s8"<?php echo $result->s8->CellAttributes() ?>>
<span id="el_result_s8">
<span<?php echo $result->s8->ViewAttributes() ?>>
<?php echo $result->s8->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($result->total->Visible) { // total ?>
	<tr id="r_total">
		<td class="col-sm-2"><span id="elh_result_total"><?php echo $result->total->FldCaption() ?></span></td>
		<td data-name="total"<?php echo $result->total->CellAttributes() ?>>
<span id="el_result_total">
<span<?php echo $result->total->ViewAttributes() ?>>
<?php echo $result->total->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php if ($result->Export == "") { ?>
<script type="text/javascript">
fresultview.Init();
</script>
<?php } ?>
<?php
$result_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($result->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$result_view->Page_Terminate();
?>
