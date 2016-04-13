<?php
//Include Common Files @1-37E50506
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "usuarios.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @41-F4B187EF
include_once(RelativePath . "/admin/Header.php");
//End Include Page implementation

class clsRecordusuariosSearch { //usuariosSearch Class @2-479B4C56

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

//Class_Initialize Event @2-5094BD10
    function clsRecordusuariosSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record usuariosSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "usuariosSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_Login = new clsControl(ccsTextBox, "s_Login", "s_Login", ccsText, "", CCGetRequestParam("s_Login", $Method, NULL), $this);
            $this->s_NombreCompleto = new clsControl(ccsTextBox, "s_NombreCompleto", "s_NombreCompleto", ccsText, "", CCGetRequestParam("s_NombreCompleto", $Method, NULL), $this);
            $this->s_EMail = new clsControl(ccsTextBox, "s_EMail", "s_EMail", ccsText, "", CCGetRequestParam("s_EMail", $Method, NULL), $this);
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @2-1A91E726
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_Login->Validate() && $Validation);
        $Validation = ($this->s_NombreCompleto->Validate() && $Validation);
        $Validation = ($this->s_EMail->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_Login->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_NombreCompleto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_EMail->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-24DB896C
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_Login->Errors->Count());
        $errors = ($errors || $this->s_NombreCompleto->Errors->Count());
        $errors = ($errors || $this->s_EMail->Errors->Count());
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

//Operation Method @2-E687E127
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
        $Redirect = "usuarios.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "usuarios.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @2-24C02A33
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
            $Error = ComposeStrings($Error, $this->s_Login->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_NombreCompleto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_EMail->Errors->ToString());
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

        $this->s_Login->Show();
        $this->s_NombreCompleto->Show();
        $this->s_EMail->Show();
        $this->Button_DoSearch->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End usuariosSearch Class @2-FCB6E20C

class clsGridusuarios { //usuarios class @8-D798D5ED

//Variables @8-9FAFDD20

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
    public $Sorter_Login;
    public $Sorter_Nivel;
    public $Sorter_NombreCompleto;
    public $Sorter_EMail;
    public $Sorter_FechaRegistro;
    public $Sorter_UltimoAcceso;
    public $Sorter_Habilitado;
//End Variables

//Class_Initialize Event @8-16FF3755
    function clsGridusuarios($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "usuarios";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid usuarios";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsusuariosDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("usuariosOrder", "");
        $this->SorterDirection = CCGetParam("usuariosDir", "");

        $this->id = new clsControl(ccsLink, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet, NULL), $this);
        $this->id->Page = "usuario.php";
        $this->Login = new clsControl(ccsLabel, "Login", "Login", ccsText, "", CCGetRequestParam("Login", ccsGet, NULL), $this);
        $this->Nivel = new clsControl(ccsLabel, "Nivel", "Nivel", ccsInteger, "", CCGetRequestParam("Nivel", ccsGet, NULL), $this);
        $this->NombreCompleto = new clsControl(ccsLabel, "NombreCompleto", "NombreCompleto", ccsText, "", CCGetRequestParam("NombreCompleto", ccsGet, NULL), $this);
        $this->EMail = new clsControl(ccsLabel, "EMail", "EMail", ccsText, "", CCGetRequestParam("EMail", ccsGet, NULL), $this);
        $this->FechaRegistro = new clsControl(ccsLabel, "FechaRegistro", "FechaRegistro", ccsDate, $DefaultDateFormat, CCGetRequestParam("FechaRegistro", ccsGet, NULL), $this);
        $this->UltimoAcceso = new clsControl(ccsLabel, "UltimoAcceso", "UltimoAcceso", ccsDate, $DefaultDateFormat, CCGetRequestParam("UltimoAcceso", ccsGet, NULL), $this);
        $this->Habilitado = new clsControl(ccsCheckBox, "Habilitado", "Habilitado", ccsInteger, "", CCGetRequestParam("Habilitado", ccsGet, NULL), $this);
        $this->Habilitado->CheckedValue = $this->Habilitado->GetParsedValue(1);
        $this->Habilitado->UncheckedValue = $this->Habilitado->GetParsedValue(0);
        $this->Sorter_id = new clsSorter($this->ComponentName, "Sorter_id", $FileName, $this);
        $this->Sorter_Login = new clsSorter($this->ComponentName, "Sorter_Login", $FileName, $this);
        $this->Sorter_Nivel = new clsSorter($this->ComponentName, "Sorter_Nivel", $FileName, $this);
        $this->Sorter_NombreCompleto = new clsSorter($this->ComponentName, "Sorter_NombreCompleto", $FileName, $this);
        $this->Sorter_EMail = new clsSorter($this->ComponentName, "Sorter_EMail", $FileName, $this);
        $this->Sorter_FechaRegistro = new clsSorter($this->ComponentName, "Sorter_FechaRegistro", $FileName, $this);
        $this->Sorter_UltimoAcceso = new clsSorter($this->ComponentName, "Sorter_UltimoAcceso", $FileName, $this);
        $this->Sorter_Habilitado = new clsSorter($this->ComponentName, "Sorter_Habilitado", $FileName, $this);
        $this->usuarios_Insert = new clsControl(ccsLink, "usuarios_Insert", "usuarios_Insert", ccsText, "", CCGetRequestParam("usuarios_Insert", ccsGet, NULL), $this);
        $this->usuarios_Insert->Parameters = CCGetQueryString("QueryString", array("id", "ccsForm"));
        $this->usuarios_Insert->Page = "usuario.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @8-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @8-521F7013
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_Login"] = CCGetFromGet("s_Login", NULL);
        $this->DataSource->Parameters["urls_NombreCompleto"] = CCGetFromGet("s_NombreCompleto", NULL);
        $this->DataSource->Parameters["urls_EMail"] = CCGetFromGet("s_EMail", NULL);

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
            $this->ControlsVisible["Login"] = $this->Login->Visible;
            $this->ControlsVisible["Nivel"] = $this->Nivel->Visible;
            $this->ControlsVisible["NombreCompleto"] = $this->NombreCompleto->Visible;
            $this->ControlsVisible["EMail"] = $this->EMail->Visible;
            $this->ControlsVisible["FechaRegistro"] = $this->FechaRegistro->Visible;
            $this->ControlsVisible["UltimoAcceso"] = $this->UltimoAcceso->Visible;
            $this->ControlsVisible["Habilitado"] = $this->Habilitado->Visible;
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
                $this->Login->SetValue($this->DataSource->Login->GetValue());
                $this->Nivel->SetValue($this->DataSource->Nivel->GetValue());
                $this->NombreCompleto->SetValue($this->DataSource->NombreCompleto->GetValue());
                $this->EMail->SetValue($this->DataSource->EMail->GetValue());
                $this->FechaRegistro->SetValue($this->DataSource->FechaRegistro->GetValue());
                $this->UltimoAcceso->SetValue($this->DataSource->UltimoAcceso->GetValue());
                $this->Habilitado->SetValue($this->DataSource->Habilitado->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id->Show();
                $this->Login->Show();
                $this->Nivel->Show();
                $this->NombreCompleto->Show();
                $this->EMail->Show();
                $this->FechaRegistro->Show();
                $this->UltimoAcceso->Show();
                $this->Habilitado->Show();
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
        $this->Sorter_Login->Show();
        $this->Sorter_Nivel->Show();
        $this->Sorter_NombreCompleto->Show();
        $this->Sorter_EMail->Show();
        $this->Sorter_FechaRegistro->Show();
        $this->Sorter_UltimoAcceso->Show();
        $this->Sorter_Habilitado->Show();
        $this->usuarios_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @8-523BDA9A
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Login->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Nivel->Errors->ToString());
        $errors = ComposeStrings($errors, $this->NombreCompleto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->EMail->Errors->ToString());
        $errors = ComposeStrings($errors, $this->FechaRegistro->Errors->ToString());
        $errors = ComposeStrings($errors, $this->UltimoAcceso->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Habilitado->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End usuarios Class @8-FCB6E20C

class clsusuariosDataSource extends clsDBluisnova {  //usuariosDataSource Class @8-6C8B0D8A

//DataSource Variables @8-2A3103BB
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id;
    public $Login;
    public $Nivel;
    public $NombreCompleto;
    public $EMail;
    public $FechaRegistro;
    public $UltimoAcceso;
    public $Habilitado;
//End DataSource Variables

//DataSourceClass_Initialize Event @8-6877AE1F
    function clsusuariosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid usuarios";
        $this->Initialize();
        $this->id = new clsField("id", ccsInteger, "");
        
        $this->Login = new clsField("Login", ccsText, "");
        
        $this->Nivel = new clsField("Nivel", ccsInteger, "");
        
        $this->NombreCompleto = new clsField("NombreCompleto", ccsText, "");
        
        $this->EMail = new clsField("EMail", ccsText, "");
        
        $this->FechaRegistro = new clsField("FechaRegistro", ccsDate, $this->DateFormat);
        
        $this->UltimoAcceso = new clsField("UltimoAcceso", ccsDate, $this->DateFormat);
        
        $this->Habilitado = new clsField("Habilitado", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @8-1CB5D7C7
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_id" => array("id", ""), 
            "Sorter_Login" => array("Login", ""), 
            "Sorter_Nivel" => array("Nivel", ""), 
            "Sorter_NombreCompleto" => array("NombreCompleto", ""), 
            "Sorter_EMail" => array("EMail", ""), 
            "Sorter_FechaRegistro" => array("FechaRegistro", ""), 
            "Sorter_UltimoAcceso" => array("UltimoAcceso", ""), 
            "Sorter_Habilitado" => array("Habilitado", "")));
    }
//End SetOrder Method

//Prepare Method @8-5585F8C9
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_Login", ccsText, "", "", $this->Parameters["urls_Login"], "", false);
        $this->wp->AddParameter("2", "urls_NombreCompleto", ccsText, "", "", $this->Parameters["urls_NombreCompleto"], "", false);
        $this->wp->AddParameter("3", "urls_EMail", ccsText, "", "", $this->Parameters["urls_EMail"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "Login", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "NombreCompleto", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "EMail", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @8-AF854A8A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM usuarios";
        $this->SQL = "SELECT id, Login, Nivel, NombreCompleto, EMail, FechaRegistro, UltimoAcceso, Habilitado \n\n" .
        "FROM usuarios {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @8-224DDE60
    function SetValues()
    {
        $this->id->SetDBValue(trim($this->f("id")));
        $this->Login->SetDBValue($this->f("Login"));
        $this->Nivel->SetDBValue(trim($this->f("Nivel")));
        $this->NombreCompleto->SetDBValue($this->f("NombreCompleto"));
        $this->EMail->SetDBValue($this->f("EMail"));
        $this->FechaRegistro->SetDBValue(trim($this->f("FechaRegistro")));
        $this->UltimoAcceso->SetDBValue(trim($this->f("UltimoAcceso")));
        $this->Habilitado->SetDBValue(trim($this->f("Habilitado")));
    }
//End SetValues Method

} //End usuariosDataSource Class @8-FCB6E20C

//Include Page implementation @42-91B8C9D0
include_once(RelativePath . "/admin/Footer.php");
//End Include Page implementation

//Initialize Page @1-108FDF0B
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
$TemplateFileName = "usuarios.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Authenticate User @1-CD666656
CCSecurityRedirect("95", "");
//End Authenticate User

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-8B8FA8F4
$DBluisnova = new clsDBluisnova();
$MainPage->Connections["luisnova"] = & $DBluisnova;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Header = new clsHeader("", "Header", $MainPage);
$Header->Initialize();
$usuariosSearch = new clsRecordusuariosSearch("", $MainPage);
$usuarios = new clsGridusuarios("", $MainPage);
$Footer = new clsFooter("", "Footer", $MainPage);
$Footer->Initialize();
$MainPage->Header = & $Header;
$MainPage->usuariosSearch = & $usuariosSearch;
$MainPage->usuarios = & $usuarios;
$MainPage->Footer = & $Footer;
$usuarios->Initialize();

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

//Execute Components @1-384859AF
$Header->Operations();
$usuariosSearch->Operation();
$Footer->Operations();
//End Execute Components

//Go to destination page @1-B833CB1A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBluisnova->close();
    header("Location: " . $Redirect);
    $Header->Class_Terminate();
    unset($Header);
    unset($usuariosSearch);
    unset($usuarios);
    $Footer->Class_Terminate();
    unset($Footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D1AAA16C
$Header->Show();
$usuariosSearch->Show();
$usuarios->Show();
$Footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);

$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-EE841A89
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBluisnova->close();
$Header->Class_Terminate();
unset($Header);
unset($usuariosSearch);
unset($usuarios);
$Footer->Class_Terminate();
unset($Footer);
unset($Tpl);
//End Unload Page


?>
