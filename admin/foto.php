<?php
//Include Common Files @1-11949B8B
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "foto.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @15-F4B187EF
include_once(RelativePath . "/admin/Header.php");
//End Include Page implementation

class clsRecordgaleria_fotos { //galeria_fotos Class @2-EAD31D68

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

//Class_Initialize Event @2-6A865A5E
    function clsRecordgaleria_fotos($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record galeria_fotos/Error";
        $this->DataSource = new clsgaleria_fotosDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "galeria_fotos";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "multipart/form-data";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->RutaFoto = new clsFileUpload("RutaFoto", "RutaFoto", "../galeria/temp/", "../galeria/fotos/", "*.jpg; *.png; *.gif", "", 2000000, $this);
            $this->Titulo = new clsControl(ccsTextBox, "Titulo", "Titulo", ccsText, "", CCGetRequestParam("Titulo", $Method, NULL), $this);
            $this->Titulo->Required = true;
            $this->Galeria = new clsControl(ccsTextBox, "Galeria", "Galeria", ccsText, "", CCGetRequestParam("Galeria", $Method, NULL), $this);
            $this->Galeria->Required = true;
            $this->Categorias = new clsControl(ccsListBox, "Categorias", "Categorias", ccsText, "", CCGetRequestParam("Categorias", $Method, NULL), $this);
            $this->Categorias->DSType = dsTable;
            $this->Categorias->DataSource = new clsDBluisnova();
            $this->Categorias->ds = & $this->Categorias->DataSource;
            $this->Categorias->DataSource->SQL = "SELECT * \n" .
"FROM galeria_categorias {SQL_Where} {SQL_OrderBy}";
            list($this->Categorias->BoundColumn, $this->Categorias->TextColumn, $this->Categorias->DBFormat) = array("Categoria", "Categoria", "");
            $this->Categorias->HTML = true;
            $this->Fecha = new clsControl(ccsTextBox, "Fecha", "Fecha", ccsDate, array("ShortDate"), CCGetRequestParam("Fecha", $Method, NULL), $this);
            $this->DatePicker_Fecha = new clsDatePicker("DatePicker_Fecha", "galeria_fotos", "Fecha", $this);
            $this->Publicar = new clsControl(ccsCheckBox, "Publicar", "Publicar", ccsInteger, "", CCGetRequestParam("Publicar", $Method, NULL), $this);
            $this->Publicar->CheckedValue = $this->Publicar->GetParsedValue(1);
            $this->Publicar->UncheckedValue = $this->Publicar->GetParsedValue(0);
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Orden = new clsControl(ccsTextBox, "Orden", "Orden de la foto", ccsInteger, "", CCGetRequestParam("Orden", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->Galeria->Value) && !strlen($this->Galeria->Value) && $this->Galeria->Value !== false)
                    $this->Galeria->SetText("Luis Nova");
                if(!is_array($this->Fecha->Value) && !strlen($this->Fecha->Value) && $this->Fecha->Value !== false)
                    $this->Fecha->SetValue(time());
                if(!is_array($this->Publicar->Value) && !strlen($this->Publicar->Value) && $this->Publicar->Value !== false)
                    $this->Publicar->SetValue(false);
                if(!is_array($this->Orden->Value) && !strlen($this->Orden->Value) && $this->Orden->Value !== false)
                    $this->Orden->SetText(0);
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

//Validate Method @2-AC4D1DF5
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->RutaFoto->Validate() && $Validation);
        $Validation = ($this->Titulo->Validate() && $Validation);
        $Validation = ($this->Galeria->Validate() && $Validation);
        $Validation = ($this->Categorias->Validate() && $Validation);
        $Validation = ($this->Fecha->Validate() && $Validation);
        $Validation = ($this->Publicar->Validate() && $Validation);
        $Validation = ($this->Orden->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->RutaFoto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Titulo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Galeria->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Categorias->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Fecha->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Publicar->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Orden->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-696B19B7
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->RutaFoto->Errors->Count());
        $errors = ($errors || $this->Titulo->Errors->Count());
        $errors = ($errors || $this->Galeria->Errors->Count());
        $errors = ($errors || $this->Categorias->Errors->Count());
        $errors = ($errors || $this->Fecha->Errors->Count());
        $errors = ($errors || $this->DatePicker_Fecha->Errors->Count());
        $errors = ($errors || $this->Publicar->Errors->Count());
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

//Operation Method @2-A594902F
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

        $this->RutaFoto->Upload();

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
        $Redirect = "fotos.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
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

//InsertRow Method @2-169700CE
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->RutaFoto->SetValue($this->RutaFoto->GetValue(true));
        $this->DataSource->Titulo->SetValue($this->Titulo->GetValue(true));
        $this->DataSource->Galeria->SetValue($this->Galeria->GetValue(true));
        $this->DataSource->Categorias->SetValue($this->Categorias->GetValue(true));
        $this->DataSource->Fecha->SetValue($this->Fecha->GetValue(true));
        $this->DataSource->Publicar->SetValue($this->Publicar->GetValue(true));
        $this->DataSource->Orden->SetValue($this->Orden->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->RutaFoto->Move();
        }
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @2-A5DD9649
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->RutaFoto->SetValue($this->RutaFoto->GetValue(true));
        $this->DataSource->Titulo->SetValue($this->Titulo->GetValue(true));
        $this->DataSource->Galeria->SetValue($this->Galeria->GetValue(true));
        $this->DataSource->Categorias->SetValue($this->Categorias->GetValue(true));
        $this->DataSource->Fecha->SetValue($this->Fecha->GetValue(true));
        $this->DataSource->Publicar->SetValue($this->Publicar->GetValue(true));
        $this->DataSource->Orden->SetValue($this->Orden->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->RutaFoto->Move();
        }
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @2-636AF974
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        if($this->DataSource->Errors->Count() == 0) {
            $this->RutaFoto->Delete();
        }
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @2-AC2D5858
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

        $this->Categorias->Prepare();

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
                    $this->RutaFoto->SetValue($this->DataSource->RutaFoto->GetValue());
                    $this->Titulo->SetValue($this->DataSource->Titulo->GetValue());
                    $this->Galeria->SetValue($this->DataSource->Galeria->GetValue());
                    $this->Categorias->SetValue($this->DataSource->Categorias->GetValue());
                    $this->Fecha->SetValue($this->DataSource->Fecha->GetValue());
                    $this->Publicar->SetValue($this->DataSource->Publicar->GetValue());
                    $this->Orden->SetValue($this->DataSource->Orden->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->RutaFoto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Titulo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Galeria->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Categorias->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Fecha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_Fecha->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Publicar->Errors->ToString());
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

        $this->RutaFoto->Show();
        $this->Titulo->Show();
        $this->Galeria->Show();
        $this->Categorias->Show();
        $this->Fecha->Show();
        $this->DatePicker_Fecha->Show();
        $this->Publicar->Show();
        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Orden->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End galeria_fotos Class @2-FCB6E20C

class clsgaleria_fotosDataSource extends clsDBluisnova {  //galeria_fotosDataSource Class @2-168B520D

//DataSource Variables @2-5F064B8C
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
    public $RutaFoto;
    public $Titulo;
    public $Galeria;
    public $Categorias;
    public $Fecha;
    public $Publicar;
    public $Orden;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-EB514959
    function clsgaleria_fotosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record galeria_fotos/Error";
        $this->Initialize();
        $this->RutaFoto = new clsField("RutaFoto", ccsText, "");
        
        $this->Titulo = new clsField("Titulo", ccsText, "");
        
        $this->Galeria = new clsField("Galeria", ccsText, "");
        
        $this->Categorias = new clsField("Categorias", ccsText, "");
        
        $this->Fecha = new clsField("Fecha", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->Publicar = new clsField("Publicar", ccsInteger, "");
        
        $this->Orden = new clsField("Orden", ccsInteger, "");
        

        $this->InsertFields["Foto"] = array("Name" => "Foto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["Titulo"] = array("Name" => "Titulo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["Galeria"] = array("Name" => "Galeria", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["Categorias"] = array("Name" => "Categorias", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["Fecha"] = array("Name" => "Fecha", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["Publicar"] = array("Name" => "Publicar", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["Orden"] = array("Name" => "Orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["Foto"] = array("Name" => "Foto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["Titulo"] = array("Name" => "Titulo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["Galeria"] = array("Name" => "Galeria", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["Categorias"] = array("Name" => "Categorias", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["Fecha"] = array("Name" => "Fecha", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["Publicar"] = array("Name" => "Publicar", "Value" => "", "DataType" => ccsInteger);
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

//Open Method @2-BE6D9AE9
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM galeria_fotos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-9E1C1999
    function SetValues()
    {
        $this->RutaFoto->SetDBValue($this->f("Foto"));
        $this->Titulo->SetDBValue($this->f("Titulo"));
        $this->Galeria->SetDBValue($this->f("Galeria"));
        $this->Categorias->SetDBValue($this->f("Categorias"));
        $this->Fecha->SetDBValue(trim($this->f("Fecha")));
        $this->Publicar->SetDBValue(trim($this->f("Publicar")));
        $this->Orden->SetDBValue(trim($this->f("Orden")));
    }
//End SetValues Method

//Insert Method @2-3A042086
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["Foto"]["Value"] = $this->RutaFoto->GetDBValue(true);
        $this->InsertFields["Titulo"]["Value"] = $this->Titulo->GetDBValue(true);
        $this->InsertFields["Galeria"]["Value"] = $this->Galeria->GetDBValue(true);
        $this->InsertFields["Categorias"]["Value"] = $this->Categorias->GetDBValue(true);
        $this->InsertFields["Fecha"]["Value"] = $this->Fecha->GetDBValue(true);
        $this->InsertFields["Publicar"]["Value"] = $this->Publicar->GetDBValue(true);
        $this->InsertFields["Orden"]["Value"] = $this->Orden->GetDBValue(true);
        $this->SQL = CCBuildInsert("galeria_fotos", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @2-44C2DC18
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["Foto"]["Value"] = $this->RutaFoto->GetDBValue(true);
        $this->UpdateFields["Titulo"]["Value"] = $this->Titulo->GetDBValue(true);
        $this->UpdateFields["Galeria"]["Value"] = $this->Galeria->GetDBValue(true);
        $this->UpdateFields["Categorias"]["Value"] = $this->Categorias->GetDBValue(true);
        $this->UpdateFields["Fecha"]["Value"] = $this->Fecha->GetDBValue(true);
        $this->UpdateFields["Publicar"]["Value"] = $this->Publicar->GetDBValue(true);
        $this->UpdateFields["Orden"]["Value"] = $this->Orden->GetDBValue(true);
        $this->SQL = CCBuildUpdate("galeria_fotos", $this->UpdateFields, $this);
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

//Delete Method @2-BBB9B5CA
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM galeria_fotos";
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

} //End galeria_fotosDataSource Class @2-FCB6E20C

//Include Page implementation @16-91B8C9D0
include_once(RelativePath . "/admin/Footer.php");
//End Include Page implementation

//Initialize Page @1-CD3F1DAD
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
$TemplateFileName = "foto.html";
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

//Initialize Objects @1-A1D553CC
$DBluisnova = new clsDBluisnova();
$MainPage->Connections["luisnova"] = & $DBluisnova;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Header = new clsHeader("", "Header", $MainPage);
$Header->Initialize();
$galeria_fotos = new clsRecordgaleria_fotos("", $MainPage);
$Footer = new clsFooter("", "Footer", $MainPage);
$Footer->Initialize();
$MainPage->Header = & $Header;
$MainPage->galeria_fotos = & $galeria_fotos;
$MainPage->Footer = & $Footer;
$galeria_fotos->Initialize();

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

//Execute Components @1-5DD25BFF
$Header->Operations();
$galeria_fotos->Operation();
$Footer->Operations();
//End Execute Components

//Go to destination page @1-8B2171EC
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBluisnova->close();
    header("Location: " . $Redirect);
    $Header->Class_Terminate();
    unset($Header);
    unset($galeria_fotos);
    $Footer->Class_Terminate();
    unset($Footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-FD5FC6DE
$Header->Show();
$galeria_fotos->Show();
$Footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);

$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-4A1EF506
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBluisnova->close();
$Header->Class_Terminate();
unset($Header);
unset($galeria_fotos);
$Footer->Class_Terminate();
unset($Footer);
unset($Tpl);
//End Unload Page


?>
