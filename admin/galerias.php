<?php
//Include Common Files @1-A94EE896
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "galerias.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @40-F4B187EF
include_once(RelativePath . "/admin/Header.php");
//End Include Page implementation

class clsRecordgaleria_galeriasSearch { //galeria_galeriasSearch Class @2-39BBCBA0

//Variables @2-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @2-FE3F1401
    function clsRecordgaleria_galeriasSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record galeria_galeriasSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "galeria_galeriasSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_Galeria = new clsControl(ccsTextBox, "s_Galeria", "s_Galeria", ccsText, "", CCGetRequestParam("s_Galeria", $Method, NULL), $this);
            $this->s_Descripcion = new clsControl(ccsTextBox, "s_Descripcion", "s_Descripcion", ccsText, "", CCGetRequestParam("s_Descripcion", $Method, NULL), $this);
            $this->s_Publicado = new clsControl(ccsCheckBox, "s_Publicado", "s_Publicado", ccsInteger, "", CCGetRequestParam("s_Publicado", $Method, NULL), $this);
            $this->s_Publicado->CheckedValue = $this->s_Publicado->GetParsedValue(1);
            $this->s_Publicado->UncheckedValue = $this->s_Publicado->GetParsedValue(0);
            $this->ClearParameters = new clsControl(ccsLink, "ClearParameters", "ClearParameters", ccsText, "", CCGetRequestParam("ClearParameters", $Method, NULL), $this);
            $this->ClearParameters->Parameters = CCGetQueryString("QueryString", array("s_Galeria", "s_Descripcion", "s_Fecha", "s_Publicado", "ccsForm"));
            $this->ClearParameters->Page = "galerias.php";
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @2-6174D3C1
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_Galeria->Validate() && $Validation);
        $Validation = ($this->s_Descripcion->Validate() && $Validation);
        $Validation = ($this->s_Publicado->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_Galeria->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_Descripcion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_Publicado->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-6EDB522F
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_Galeria->Errors->Count());
        $errors = ($errors || $this->s_Descripcion->Errors->Count());
        $errors = ($errors || $this->s_Publicado->Errors->Count());
        $errors = ($errors || $this->ClearParameters->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @2-ED598703
function SetPrimaryKeys($keyArray)
{
    $this->PrimaryKeys = $keyArray;
}
function GetPrimaryKeys()
{
    return $this->PrimaryKeys;
}
function GetPrimaryKey($keyName)
{
    return $this->PrimaryKeys[$keyName];
}
//End MasterDetail

//Operation Method @2-73E67894
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = "galerias.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "galerias.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @2-F8F21974
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_Galeria->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_Descripcion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_Publicado->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ClearParameters->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->s_Galeria->Show();
        $this->s_Descripcion->Show();
        $this->s_Publicado->Show();
        $this->ClearParameters->Show();
        $this->Button_DoSearch->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End galeria_galeriasSearch Class @2-FCB6E20C

class clsGridgaleria_galerias { //galeria_galerias class @10-CDDBA8F0

//Variables @10-E3DB9DD9

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
    public $Sorter_id;
    public $Sorter_Galeria;
    public $Sorter_Descripcion;
    public $Sorter_Publicado;
    public $Sorter_Orden;
    public $Sorter_Fecha;
    public $Sorter_Imagen;
//End Variables

//Class_Initialize Event @10-F3914B53
    function clsGridgaleria_galerias($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "galeria_galerias";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid galeria_galerias";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsgaleria_galeriasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("galeria_galeriasOrder", "");
        $this->SorterDirection = CCGetParam("galeria_galeriasDir", "");

        $this->id = new clsControl(ccsLink, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet, NULL), $this);
        $this->id->Page = "galeria.php";
        $this->Galeria = new clsControl(ccsLabel, "Galeria", "Galeria", ccsText, "", CCGetRequestParam("Galeria", ccsGet, NULL), $this);
        $this->Descripcion = new clsControl(ccsLabel, "Descripcion", "Descripcion", ccsText, "", CCGetRequestParam("Descripcion", ccsGet, NULL), $this);
        $this->Publicado = new clsControl(ccsCheckBox, "Publicado", "Publicado", ccsInteger, "", CCGetRequestParam("Publicado", ccsGet, NULL), $this);
        $this->Publicado->CheckedValue = $this->Publicado->GetParsedValue(1);
        $this->Publicado->UncheckedValue = $this->Publicado->GetParsedValue(0);
        $this->Orden = new clsControl(ccsLabel, "Orden", "Orden", ccsInteger, "", CCGetRequestParam("Orden", ccsGet, NULL), $this);
        $this->Fecha = new clsControl(ccsLabel, "Fecha", "Fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("Fecha", ccsGet, NULL), $this);
        $this->Imagen = new clsControl(ccsImage, "Imagen", "Imagen", ccsText, "", CCGetRequestParam("Imagen", ccsGet, NULL), $this);
        $this->Sorter_id = new clsSorter($this->ComponentName, "Sorter_id", $FileName, $this);
        $this->Sorter_Galeria = new clsSorter($this->ComponentName, "Sorter_Galeria", $FileName, $this);
        $this->Sorter_Descripcion = new clsSorter($this->ComponentName, "Sorter_Descripcion", $FileName, $this);
        $this->Sorter_Publicado = new clsSorter($this->ComponentName, "Sorter_Publicado", $FileName, $this);
        $this->Sorter_Orden = new clsSorter($this->ComponentName, "Sorter_Orden", $FileName, $this);
        $this->Sorter_Fecha = new clsSorter($this->ComponentName, "Sorter_Fecha", $FileName, $this);
        $this->Sorter_Imagen = new clsSorter($this->ComponentName, "Sorter_Imagen", $FileName, $this);
        $this->galeria_galerias_Insert = new clsControl(ccsLink, "galeria_galerias_Insert", "galeria_galerias_Insert", ccsText, "", CCGetRequestParam("galeria_galerias_Insert", ccsGet, NULL), $this);
        $this->galeria_galerias_Insert->Parameters = CCGetQueryString("QueryString", array("id", "ccsForm"));
        $this->galeria_galerias_Insert->Page = "galeria.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @10-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @10-1B85BD1E
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_Fecha"] = CCGetFromGet("s_Fecha", NULL);
        $this->DataSource->Parameters["urls_Publicado"] = CCGetFromGet("s_Publicado", NULL);
        $this->DataSource->Parameters["urls_Galeria"] = CCGetFromGet("s_Galeria", NULL);
        $this->DataSource->Parameters["urls_Descripcion"] = CCGetFromGet("s_Descripcion", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["id"] = $this->id->Visible;
            $this->ControlsVisible["Galeria"] = $this->Galeria->Visible;
            $this->ControlsVisible["Descripcion"] = $this->Descripcion->Visible;
            $this->ControlsVisible["Publicado"] = $this->Publicado->Visible;
            $this->ControlsVisible["Orden"] = $this->Orden->Visible;
            $this->ControlsVisible["Fecha"] = $this->Fecha->Visible;
            $this->ControlsVisible["Imagen"] = $this->Imagen->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->id->SetValue($this->DataSource->id->GetValue());
                $this->id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->id->Parameters = CCAddParam($this->id->Parameters, "id", $this->DataSource->f("id"));
                $this->Galeria->SetValue($this->DataSource->Galeria->GetValue());
                $this->Descripcion->SetValue($this->DataSource->Descripcion->GetValue());
                $this->Publicado->SetValue($this->DataSource->Publicado->GetValue());
                $this->Orden->SetValue($this->DataSource->Orden->GetValue());
                $this->Fecha->SetValue($this->DataSource->Fecha->GetValue());
                $this->Imagen->SetValue($this->DataSource->Imagen->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id->Show();
                $this->Galeria->Show();
                $this->Descripcion->Show();
                $this->Publicado->Show();
                $this->Orden->Show();
                $this->Fecha->Show();
                $this->Imagen->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->Sorter_id->Show();
        $this->Sorter_Galeria->Show();
        $this->Sorter_Descripcion->Show();
        $this->Sorter_Publicado->Show();
        $this->Sorter_Orden->Show();
        $this->Sorter_Fecha->Show();
        $this->Sorter_Imagen->Show();
        $this->galeria_galerias_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @10-D90A3D04
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Galeria->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Descripcion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Publicado->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Orden->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Imagen->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End galeria_galerias Class @10-FCB6E20C

class clsgaleria_galeriasDataSource extends clsDBluisnova {  //galeria_galeriasDataSource Class @10-3459EA40

//DataSource Variables @10-BCF7798F
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id;
    public $Galeria;
    public $Descripcion;
    public $Publicado;
    public $Orden;
    public $Fecha;
    public $Imagen;
//End DataSource Variables

//DataSourceClass_Initialize Event @10-3019894A
    function clsgaleria_galeriasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid galeria_galerias";
        $this->Initialize();
        $this->id = new clsField("id", ccsInteger, "");
        
        $this->Galeria = new clsField("Galeria", ccsText, "");
        
        $this->Descripcion = new clsField("Descripcion", ccsText, "");
        
        $this->Publicado = new clsField("Publicado", ccsInteger, "");
        
        $this->Orden = new clsField("Orden", ccsInteger, "");
        
        $this->Fecha = new clsField("Fecha", ccsDate, $this->DateFormat);
        
        $this->Imagen = new clsField("Imagen", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @10-51D97E42
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_id" => array("id", ""), 
            "Sorter_Galeria" => array("Galeria", ""), 
            "Sorter_Descripcion" => array("Descripcion", ""), 
            "Sorter_Publicado" => array("Publicado", ""), 
            "Sorter_Orden" => array("Orden", ""), 
            "Sorter_Fecha" => array("Fecha", ""), 
            "Sorter_Imagen" => array("Imagen", "")));
    }
//End SetOrder Method

//Prepare Method @10-805AD0C6
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_Fecha", ccsDate, $DefaultDateFormat, $this->DateFormat, $this->Parameters["urls_Fecha"], "", false);
        $this->wp->AddParameter("2", "urls_Publicado", ccsInteger, "", "", $this->Parameters["urls_Publicado"], "", false);
        $this->wp->AddParameter("3", "urls_Galeria", ccsText, "", "", $this->Parameters["urls_Galeria"], "", false);
        $this->wp->AddParameter("4", "urls_Descripcion", ccsText, "", "", $this->Parameters["urls_Descripcion"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "Fecha", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsDate),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "Publicado", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "Galeria", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "Descripcion", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]);
    }
//End Prepare Method

//Open Method @10-25B4CD4B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM galeria_galerias";
        $this->SQL = "SELECT id, Galeria, Descripcion, Publicado, Orden, Fecha, Imagen \n\n" .
        "FROM galeria_galerias {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @10-01B443AF
    function SetValues()
    {
        $this->id->SetDBValue(trim($this->f("id")));
        $this->Galeria->SetDBValue($this->f("Galeria"));
        $this->Descripcion->SetDBValue($this->f("Descripcion"));
        $this->Publicado->SetDBValue(trim($this->f("Publicado")));
        $this->Orden->SetDBValue(trim($this->f("Orden")));
        $this->Fecha->SetDBValue(trim($this->f("Fecha")));
        $this->Imagen->SetDBValue($this->f("Imagen"));
    }
//End SetValues Method

} //End galeria_galeriasDataSource Class @10-FCB6E20C

//Include Page implementation @41-91B8C9D0
include_once(RelativePath . "/admin/Footer.php");
//End Include Page implementation

//Initialize Page @1-F4991414
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "galerias.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-1E837DE3
CCSecurityRedirect("15", "");
//End Authenticate User

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-09D5B499
$DBluisnova = new clsDBluisnova();
$MainPage->Connections["luisnova"] = & $DBluisnova;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Header = new clsHeader("", "Header", $MainPage);
$Header->Initialize();
$galeria_galeriasSearch = new clsRecordgaleria_galeriasSearch("", $MainPage);
$galeria_galerias = new clsGridgaleria_galerias("", $MainPage);
$Footer = new clsFooter("", "Footer", $MainPage);
$Footer->Initialize();
$MainPage->Header = & $Header;
$MainPage->galeria_galeriasSearch = & $galeria_galeriasSearch;
$MainPage->galeria_galerias = & $galeria_galerias;
$MainPage->Footer = & $Footer;
$galeria_galerias->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-52F9C312
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "../");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-E5E9FABD
$Header->Operations();
$galeria_galeriasSearch->Operation();
$Footer->Operations();
//End Execute Components

//Go to destination page @1-0159CB40
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBluisnova->close();
    header("Location: " . $Redirect);
    $Header->Class_Terminate();
    unset($Header);
    unset($galeria_galeriasSearch);
    unset($galeria_galerias);
    $Footer->Class_Terminate();
    unset($Footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-9F4BA4B7
$Header->Show();
$galeria_galeriasSearch->Show();
$galeria_galerias->Show();
$Footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);

$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-7C2519C9
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBluisnova->close();
$Header->Class_Terminate();
unset($Header);
unset($galeria_galeriasSearch);
unset($galeria_galerias);
$Footer->Class_Terminate();
unset($Footer);
unset($Tpl);
//End Unload Page


?>
