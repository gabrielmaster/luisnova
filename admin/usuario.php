<?php
//Include Common Files @1-8414EC1B
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "usuario.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @18-F4B187EF
include_once(RelativePath . "/admin/Header.php");
//End Include Page implementation

class clsRecordusuarios { //usuarios Class @2-E7FA739F

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

//Class_Initialize Event @2-6596ECF8
    function clsRecordusuarios($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record usuarios/Error";
        $this->DataSource = new clsusuariosDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "usuarios";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Login = new clsControl(ccsTextBox, "Login", "Login", ccsText, "", CCGetRequestParam("Login", $Method, NULL), $this);
            $this->Login->Required = true;
            $this->Password = new clsControl(ccsTextBox, "Password", "Password", ccsText, "", CCGetRequestParam("Password", $Method, NULL), $this);
            $this->Password->Required = true;
            $this->Nivel = new clsControl(ccsListBox, "Nivel", "Nivel", ccsInteger, "", CCGetRequestParam("Nivel", $Method, NULL), $this);
            $this->Nivel->Required = true;
            $this->NombreCompleto = new clsControl(ccsTextBox, "NombreCompleto", "Nombre Completo", ccsText, "", CCGetRequestParam("NombreCompleto", $Method, NULL), $this);
            $this->NombreCompleto->Required = true;
            $this->EMail = new clsControl(ccsTextBox, "EMail", "EMail", ccsText, "", CCGetRequestParam("EMail", $Method, NULL), $this);
            $this->EMail->Required = true;
            $this->FechaRegistro = new clsControl(ccsTextBox, "FechaRegistro", "Fecha Registro", ccsDate, $DefaultDateFormat, CCGetRequestParam("FechaRegistro", $Method, NULL), $this);
            $this->FechaRegistro->Required = true;
            $this->DatePicker_FechaRegistro = new clsDatePicker("DatePicker_FechaRegistro", "usuarios", "FechaRegistro", $this);
            $this->UltimoAcceso = new clsControl(ccsTextBox, "UltimoAcceso", "Ultimo Acceso", ccsDate, $DefaultDateFormat, CCGetRequestParam("UltimoAcceso", $Method, NULL), $this);
            $this->Habilitado = new clsControl(ccsCheckBox, "Habilitado", "Habilitado", ccsInteger, "", CCGetRequestParam("Habilitado", $Method, NULL), $this);
            $this->Habilitado->CheckedValue = $this->Habilitado->GetParsedValue(1);
            $this->Habilitado->UncheckedValue = $this->Habilitado->GetParsedValue(0);
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->Habilitado->Value) && !strlen($this->Habilitado->Value) && $this->Habilitado->Value !== false)
                    $this->Habilitado->SetValue(true);
            }
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

//Validate Method @2-4875A43B
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->Login->Validate() && $Validation);
        $Validation = ($this->Password->Validate() && $Validation);
        $Validation = ($this->Nivel->Validate() && $Validation);
        $Validation = ($this->NombreCompleto->Validate() && $Validation);
        $Validation = ($this->EMail->Validate() && $Validation);
        $Validation = ($this->FechaRegistro->Validate() && $Validation);
        $Validation = ($this->UltimoAcceso->Validate() && $Validation);
        $Validation = ($this->Habilitado->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->Login->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Password->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Nivel->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NombreCompleto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->EMail->Errors->Count() == 0);
        $Validation =  $Validation && ($this->FechaRegistro->Errors->Count() == 0);
        $Validation =  $Validation && ($this->UltimoAcceso->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Habilitado->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-DF6080AF
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Login->Errors->Count());
        $errors = ($errors || $this->Password->Errors->Count());
        $errors = ($errors || $this->Nivel->Errors->Count());
        $errors = ($errors || $this->NombreCompleto->Errors->Count());
        $errors = ($errors || $this->EMail->Errors->Count());
        $errors = ($errors || $this->FechaRegistro->Errors->Count());
        $errors = ($errors || $this->DatePicker_FechaRegistro->Errors->Count());
        $errors = ($errors || $this->UltimoAcceso->Errors->Count());
        $errors = ($errors || $this->Habilitado->Errors->Count());
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

//Operation Method @2-AD5B2D28
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
        $Redirect = "usuarios.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
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

//InsertRow Method @2-83EBB102
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->Login->SetValue($this->Login->GetValue(true));
        $this->DataSource->Password->SetValue($this->Password->GetValue(true));
        $this->DataSource->Nivel->SetValue($this->Nivel->GetValue(true));
        $this->DataSource->NombreCompleto->SetValue($this->NombreCompleto->GetValue(true));
        $this->DataSource->EMail->SetValue($this->EMail->GetValue(true));
        $this->DataSource->FechaRegistro->SetValue($this->FechaRegistro->GetValue(true));
        $this->DataSource->UltimoAcceso->SetValue($this->UltimoAcceso->GetValue(true));
        $this->DataSource->Habilitado->SetValue($this->Habilitado->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-35F8B17D
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->Login->SetValue($this->Login->GetValue(true));
        $this->DataSource->Password->SetValue($this->Password->GetValue(true));
        $this->DataSource->Nivel->SetValue($this->Nivel->GetValue(true));
        $this->DataSource->NombreCompleto->SetValue($this->NombreCompleto->GetValue(true));
        $this->DataSource->EMail->SetValue($this->EMail->GetValue(true));
        $this->DataSource->FechaRegistro->SetValue($this->FechaRegistro->GetValue(true));
        $this->DataSource->UltimoAcceso->SetValue($this->UltimoAcceso->GetValue(true));
        $this->DataSource->Habilitado->SetValue($this->Habilitado->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @2-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @2-522E1971
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

        $this->Nivel->Prepare();

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
                    $this->Login->SetValue($this->DataSource->Login->GetValue());
                    $this->Password->SetValue($this->DataSource->Password->GetValue());
                    $this->Nivel->SetValue($this->DataSource->Nivel->GetValue());
                    $this->NombreCompleto->SetValue($this->DataSource->NombreCompleto->GetValue());
                    $this->EMail->SetValue($this->DataSource->EMail->GetValue());
                    $this->FechaRegistro->SetValue($this->DataSource->FechaRegistro->GetValue());
                    $this->UltimoAcceso->SetValue($this->DataSource->UltimoAcceso->GetValue());
                    $this->Habilitado->SetValue($this->DataSource->Habilitado->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->Login->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Password->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Nivel->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NombreCompleto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->EMail->Errors->ToString());
            $Error = ComposeStrings($Error, $this->FechaRegistro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_FechaRegistro->Errors->ToString());
            $Error = ComposeStrings($Error, $this->UltimoAcceso->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Habilitado->Errors->ToString());
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

        $this->Login->Show();
        $this->Password->Show();
        $this->Nivel->Show();
        $this->NombreCompleto->Show();
        $this->EMail->Show();
        $this->FechaRegistro->Show();
        $this->DatePicker_FechaRegistro->Show();
        $this->UltimoAcceso->Show();
        $this->Habilitado->Show();
        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End usuarios Class @2-FCB6E20C

class clsusuariosDataSource extends clsDBluisnova {  //usuariosDataSource Class @2-6C8B0D8A

//DataSource Variables @2-038E77C9
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
    public $Login;
    public $Password;
    public $Nivel;
    public $NombreCompleto;
    public $EMail;
    public $FechaRegistro;
    public $UltimoAcceso;
    public $Habilitado;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-53D301EA
    function clsusuariosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record usuarios/Error";
        $this->Initialize();
        $this->Login = new clsField("Login", ccsText, "");
        
        $this->Password = new clsField("Password", ccsText, "");
        
        $this->Nivel = new clsField("Nivel", ccsInteger, "");
        
        $this->NombreCompleto = new clsField("NombreCompleto", ccsText, "");
        
        $this->EMail = new clsField("EMail", ccsText, "");
        
        $this->FechaRegistro = new clsField("FechaRegistro", ccsDate, $this->DateFormat);
        
        $this->UltimoAcceso = new clsField("UltimoAcceso", ccsDate, $this->DateFormat);
        
        $this->Habilitado = new clsField("Habilitado", ccsInteger, "");
        

        $this->InsertFields["Login"] = array("Name" => "Login", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["Password"] = array("Name" => "Password", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["Nivel"] = array("Name" => "Nivel", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["NombreCompleto"] = array("Name" => "NombreCompleto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["EMail"] = array("Name" => "EMail", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["FechaRegistro"] = array("Name" => "FechaRegistro", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["UltimoAcceso"] = array("Name" => "UltimoAcceso", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["Habilitado"] = array("Name" => "Habilitado", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["Login"] = array("Name" => "Login", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["Password"] = array("Name" => "Password", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["Nivel"] = array("Name" => "Nivel", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["NombreCompleto"] = array("Name" => "NombreCompleto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["EMail"] = array("Name" => "EMail", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["FechaRegistro"] = array("Name" => "FechaRegistro", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["UltimoAcceso"] = array("Name" => "UltimoAcceso", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["Habilitado"] = array("Name" => "Habilitado", "Value" => "", "DataType" => ccsInteger);
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

//Open Method @2-A074CE66
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM usuarios {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-CED38C16
    function SetValues()
    {
        $this->Login->SetDBValue($this->f("Login"));
        $this->Password->SetDBValue($this->f("Password"));
        $this->Nivel->SetDBValue(trim($this->f("Nivel")));
        $this->NombreCompleto->SetDBValue($this->f("NombreCompleto"));
        $this->EMail->SetDBValue($this->f("EMail"));
        $this->FechaRegistro->SetDBValue(trim($this->f("FechaRegistro")));
        $this->UltimoAcceso->SetDBValue(trim($this->f("UltimoAcceso")));
        $this->Habilitado->SetDBValue(trim($this->f("Habilitado")));
    }
//End SetValues Method

//Insert Method @2-0BC8A877
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["Login"]["Value"] = $this->Login->GetDBValue(true);
        $this->InsertFields["Password"]["Value"] = $this->Password->GetDBValue(true);
        $this->InsertFields["Nivel"]["Value"] = $this->Nivel->GetDBValue(true);
        $this->InsertFields["NombreCompleto"]["Value"] = $this->NombreCompleto->GetDBValue(true);
        $this->InsertFields["EMail"]["Value"] = $this->EMail->GetDBValue(true);
        $this->InsertFields["FechaRegistro"]["Value"] = $this->FechaRegistro->GetDBValue(true);
        $this->InsertFields["UltimoAcceso"]["Value"] = $this->UltimoAcceso->GetDBValue(true);
        $this->InsertFields["Habilitado"]["Value"] = $this->Habilitado->GetDBValue(true);
        $this->SQL = CCBuildInsert("usuarios", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-9FFB88A8
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["Login"]["Value"] = $this->Login->GetDBValue(true);
        $this->UpdateFields["Password"]["Value"] = $this->Password->GetDBValue(true);
        $this->UpdateFields["Nivel"]["Value"] = $this->Nivel->GetDBValue(true);
        $this->UpdateFields["NombreCompleto"]["Value"] = $this->NombreCompleto->GetDBValue(true);
        $this->UpdateFields["EMail"]["Value"] = $this->EMail->GetDBValue(true);
        $this->UpdateFields["FechaRegistro"]["Value"] = $this->FechaRegistro->GetDBValue(true);
        $this->UpdateFields["UltimoAcceso"]["Value"] = $this->UltimoAcceso->GetDBValue(true);
        $this->UpdateFields["Habilitado"]["Value"] = $this->Habilitado->GetDBValue(true);
        $this->SQL = CCBuildUpdate("usuarios", $this->UpdateFields, $this);
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

//Delete Method @2-C95BBAC3
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM usuarios";
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

} //End usuariosDataSource Class @2-FCB6E20C

//Include Page implementation @19-91B8C9D0
include_once(RelativePath . "/admin/Footer.php");
//End Include Page implementation

//Initialize Page @1-64C5347A
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
$TemplateFileName = "usuario.html";
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

//Initialize Objects @1-7501CC84
$DBluisnova = new clsDBluisnova();
$MainPage->Connections["luisnova"] = & $DBluisnova;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Header = new clsHeader("", "Header", $MainPage);
$Header->Initialize();
$usuarios = new clsRecordusuarios("", $MainPage);
$Footer = new clsFooter("", "Footer", $MainPage);
$Footer->Initialize();
$MainPage->Header = & $Header;
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

//Execute Components @1-17D48695
$Header->Operations();
$usuarios->Operation();
$Footer->Operations();
//End Execute Components

//Go to destination page @1-EB04CCCC
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBluisnova->close();
    header("Location: " . $Redirect);
    $Header->Class_Terminate();
    unset($Header);
    unset($usuarios);
    $Footer->Class_Terminate();
    unset($Footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-BD760A1D
$Header->Show();
$usuarios->Show();
$Footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);

$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-FD2557B3
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBluisnova->close();
$Header->Class_Terminate();
unset($Header);
unset($usuarios);
$Footer->Class_Terminate();
unset($Footer);
unset($Tpl);
//End Unload Page


?>
