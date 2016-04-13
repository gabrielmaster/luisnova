<?php
//Include Common Files @1-4B6CDF1C
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "galeria.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @15-F4B187EF
include_once(RelativePath . "/admin/Header.php");
//End Include Page implementation

class clsRecordgaleria_galerias { //galeria_galerias Class @2-E3C8CE9E

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

//Class_Initialize Event @2-E73ED287
    function clsRecordgaleria_galerias($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record galeria_galerias/Error";
        $this->DataSource = new clsgaleria_galeriasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "galeria_galerias";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "multipart/form-data";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Galeria = new clsControl(ccsTextBox, "Galeria", "Galeria", ccsText, "", CCGetRequestParam("Galeria", $Method, NULL), $this);
            $this->Galeria->Required = true;
            $this->FileUpload1 = new clsFileUpload("FileUpload1", "FileUpload1", "temp/", "galerias/", "*.jpg; *.gif; *.png", "", 1000000, $this);
            $this->RutaFotos = new clsControl(ccsTextBox, "RutaFotos", "Ruta Fotos", ccsText, "", CCGetRequestParam("RutaFotos", $Method, NULL), $this);
            $this->Descripcion = new clsControl(ccsTextBox, "Descripcion", "Descripcion", ccsText, "", CCGetRequestParam("Descripcion", $Method, NULL), $this);
            $this->Descripcion->Required = true;
            $this->Publicado = new clsControl(ccsCheckBox, "Publicado", "Publicado", ccsInteger, "", CCGetRequestParam("Publicado", $Method, NULL), $this);
            $this->Publicado->CheckedValue = $this->Publicado->GetParsedValue(1);
            $this->Publicado->UncheckedValue = $this->Publicado->GetParsedValue(0);
            $this->Fecha = new clsControl(ccsTextBox, "Fecha", "Fecha", ccsDate, $DefaultDateFormat, CCGetRequestParam("Fecha", $Method, NULL), $this);
            $this->Fecha->Required = true;
            $this->DatePicker_Fecha = new clsDatePicker("DatePicker_Fecha", "galeria_galerias", "Fecha", $this);
            $this->Orden = new clsControl(ccsTextBox, "Orden", "Orden", ccsInteger, "", CCGetRequestParam("Orden", $Method, NULL), $this);
            $this->Orden->Required = true;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @2-2832F4DC
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid"] = CCGetFromGet("id", NULL);
    }
//End Initialize Method

//Validate Method @2-46218164
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->Galeria->Validate() && $Validation);
        $Validation = ($this->FileUpload1->Validate() && $Validation);
        $Validation = ($this->RutaFotos->Validate() && $Validation);
        $Validation = ($this->Descripcion->Validate() && $Validation);
        $Validation = ($this->Publicado->Validate() && $Validation);
        $Validation = ($this->Fecha->Validate() && $Validation);
        $Validation = ($this->Orden->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->Galeria->Errors->Count() == 0);
        $Validation =  $Validation && ($this->FileUpload1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RutaFotos->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Descripcion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Publicado->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Fecha->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Orden->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-13F7465C
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Galeria->Errors->Count());
        $errors = ($errors || $this->FileUpload1->Errors->Count());
        $errors = ($errors || $this->RutaFotos->Errors->Count());
        $errors = ($errors || $this->Descripcion->Errors->Count());
        $errors = ($errors || $this->Publicado->Errors->Count());
        $errors = ($errors || $this->Fecha->Errors->Count());
        $errors = ($errors || $this->DatePicker_Fecha->Errors->Count());
        $errors = ($errors || $this->Orden->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
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

//Operation Method @2-A68BB95E
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        $this->FileUpload1->Upload();

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            }
        }
        $Redirect = "galerias.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @2-1D12EFF9
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->Galeria->SetValue($this->Galeria->GetValue(true));
        $this->DataSource->FileUpload1->SetValue($this->FileUpload1->GetValue(true));
        $this->DataSource->RutaFotos->SetValue($this->RutaFotos->GetValue(true));
        $this->DataSource->Descripcion->SetValue($this->Descripcion->GetValue(true));
        $this->DataSource->Publicado->SetValue($this->Publicado->GetValue(true));
        $this->DataSource->Fecha->SetValue($this->Fecha->GetValue(true));
        $this->DataSource->Orden->SetValue($this->Orden->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Move();
        }
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-3F3BAAB3
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->Galeria->SetValue($this->Galeria->GetValue(true));
        $this->DataSource->FileUpload1->SetValue($this->FileUpload1->GetValue(true));
        $this->DataSource->RutaFotos->SetValue($this->RutaFotos->GetValue(true));
        $this->DataSource->Descripcion->SetValue($this->Descripcion->GetValue(true));
        $this->DataSource->Publicado->SetValue($this->Publicado->GetValue(true));
        $this->DataSource->Fecha->SetValue($this->Fecha->GetValue(true));
        $this->DataSource->Orden->SetValue($this->Orden->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Move();
        }
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @2-2B077D44
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->FileUpload1->Delete();
        }
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @2-A53487B4
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
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->Galeria->SetValue($this->DataSource->Galeria->GetValue());
                    $this->FileUpload1->SetValue($this->DataSource->FileUpload1->GetValue());
                    $this->RutaFotos->SetValue($this->DataSource->RutaFotos->GetValue());
                    $this->Descripcion->SetValue($this->DataSource->Descripcion->GetValue());
                    $this->Publicado->SetValue($this->DataSource->Publicado->GetValue());
                    $this->Fecha->SetValue($this->DataSource->Fecha->GetValue());
                    $this->Orden->SetValue($this->DataSource->Orden->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->Galeria->Errors->ToString());
            $Error = ComposeStrings($Error, $this->FileUpload1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RutaFotos->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Descripcion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Publicado->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Fecha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_Fecha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Orden->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Galeria->Show();
        $this->FileUpload1->Show();
        $this->RutaFotos->Show();
        $this->Descripcion->Show();
        $this->Publicado->Show();
        $this->Fecha->Show();
        $this->DatePicker_Fecha->Show();
        $this->Orden->Show();
        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End galeria_galerias Class @2-FCB6E20C

class clsgaleria_galeriasDataSource extends clsDBluisnova {  //galeria_galeriasDataSource Class @2-3459EA40

//DataSource Variables @2-4C41D877
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $Galeria;
    public $FileUpload1;
    public $RutaFotos;
    public $Descripcion;
    public $Publicado;
    public $Fecha;
    public $Orden;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-562C075A
    function clsgaleria_galeriasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record galeria_galerias/Error";
        $this->Initialize();
        $this->Galeria = new clsField("Galeria", ccsText, "");
        
        $this->FileUpload1 = new clsField("FileUpload1", ccsText, "");
        
        $this->RutaFotos = new clsField("RutaFotos", ccsText, "");
        
        $this->Descripcion = new clsField("Descripcion", ccsText, "");
        
        $this->Publicado = new clsField("Publicado", ccsInteger, "");
        
        $this->Fecha = new clsField("Fecha", ccsDate, $this->DateFormat);
        
        $this->Orden = new clsField("Orden", ccsInteger, "");
        

        $this->InsertFields["Galeria"] = array("Name" => "Galeria", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["Imagen"] = array("Name" => "Imagen", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["RutaFotos"] = array("Name" => "RutaFotos", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["Descripcion"] = array("Name" => "Descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["Publicado"] = array("Name" => "Publicado", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["Fecha"] = array("Name" => "Fecha", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["Orden"] = array("Name" => "Orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["Galeria"] = array("Name" => "Galeria", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["Imagen"] = array("Name" => "Imagen", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["RutaFotos"] = array("Name" => "RutaFotos", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["Descripcion"] = array("Name" => "Descripcion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["Publicado"] = array("Name" => "Publicado", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["Fecha"] = array("Name" => "Fecha", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["Orden"] = array("Name" => "Orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @2-35B33087
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid", ccsInteger, "", "", $this->Parameters["urlid"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-90DEEF60
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM galeria_galerias {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-B219CEAC
    function SetValues()
    {
        $this->Galeria->SetDBValue($this->f("Galeria"));
        $this->FileUpload1->SetDBValue($this->f("Imagen"));
        $this->RutaFotos->SetDBValue($this->f("RutaFotos"));
        $this->Descripcion->SetDBValue($this->f("Descripcion"));
        $this->Publicado->SetDBValue(trim($this->f("Publicado")));
        $this->Fecha->SetDBValue(trim($this->f("Fecha")));
        $this->Orden->SetDBValue(trim($this->f("Orden")));
    }
//End SetValues Method

//Insert Method @2-28A68852
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["Galeria"]["Value"] = $this->Galeria->GetDBValue(true);
        $this->InsertFields["Imagen"]["Value"] = $this->FileUpload1->GetDBValue(true);
        $this->InsertFields["RutaFotos"]["Value"] = $this->RutaFotos->GetDBValue(true);
        $this->InsertFields["Descripcion"]["Value"] = $this->Descripcion->GetDBValue(true);
        $this->InsertFields["Publicado"]["Value"] = $this->Publicado->GetDBValue(true);
        $this->InsertFields["Fecha"]["Value"] = $this->Fecha->GetDBValue(true);
        $this->InsertFields["Orden"]["Value"] = $this->Orden->GetDBValue(true);
        $this->SQL = CCBuildInsert("galeria_galerias", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-2DDD996C
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["Galeria"]["Value"] = $this->Galeria->GetDBValue(true);
        $this->UpdateFields["Imagen"]["Value"] = $this->FileUpload1->GetDBValue(true);
        $this->UpdateFields["RutaFotos"]["Value"] = $this->RutaFotos->GetDBValue(true);
        $this->UpdateFields["Descripcion"]["Value"] = $this->Descripcion->GetDBValue(true);
        $this->UpdateFields["Publicado"]["Value"] = $this->Publicado->GetDBValue(true);
        $this->UpdateFields["Fecha"]["Value"] = $this->Fecha->GetDBValue(true);
        $this->UpdateFields["Orden"]["Value"] = $this->Orden->GetDBValue(true);
        $this->SQL = CCBuildUpdate("galeria_galerias", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @2-18E3ACBB
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM galeria_galerias";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End galeria_galeriasDataSource Class @2-FCB6E20C

//Include Page implementation @16-91B8C9D0
include_once(RelativePath . "/admin/Footer.php");
//End Include Page implementation

//Initialize Page @1-7CC120F6
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
$TemplateFileName = "galeria.html";
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

//Initialize Objects @1-04F584C9
$DBluisnova = new clsDBluisnova();
$MainPage->Connections["luisnova"] = & $DBluisnova;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Header = new clsHeader("", "Header", $MainPage);
$Header->Initialize();
$galeria_galerias = new clsRecordgaleria_galerias("", $MainPage);
$Footer = new clsFooter("", "Footer", $MainPage);
$Footer->Initialize();
$MainPage->Header = & $Header;
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

//Execute Components @1-F867F7F8
$Header->Operations();
$galeria_galerias->Operation();
$Footer->Operations();
//End Execute Components

//Go to destination page @1-EB8E3D14
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBluisnova->close();
    header("Location: " . $Redirect);
    $Header->Class_Terminate();
    unset($Header);
    unset($galeria_galerias);
    $Footer->Class_Terminate();
    unset($Footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-456EC3BE
$Header->Show();
$galeria_galerias->Show();
$Footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);

$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-BE4AB537
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBluisnova->close();
$Header->Class_Terminate();
unset($Header);
unset($galeria_galerias);
$Footer->Class_Terminate();
unset($Footer);
unset($Tpl);
//End Unload Page


?>
