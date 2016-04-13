<?php
//Include Common Files @1-C77F1635
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "fotos.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @44-F4B187EF
include_once(RelativePath . "/admin/Header.php");
//End Include Page implementation

class clsRecordgaleria_fotosSearch { //galeria_fotosSearch Class @2-BCECDF3C

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

//Class_Initialize Event @2-A646C9AC
    function clsRecordgaleria_fotosSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record galeria_fotosSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "galeria_fotosSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_Titulo = new clsControl(ccsTextBox, "s_Titulo", "s_Titulo", ccsText, "", CCGetRequestParam("s_Titulo", $Method, NULL), $this);
            $this->s_Galeria = new clsControl(ccsListBox, "s_Galeria", "s_Galeria", ccsText, "", CCGetRequestParam("s_Galeria", $Method, NULL), $this);
            $this->s_Galeria->DSType = dsTable;
            $this->s_Galeria->DataSource = new clsDBluisnova();
            $this->s_Galeria->ds = & $this->s_Galeria->DataSource;
            $this->s_Galeria->DataSource->SQL = "SELECT * \n" .
"FROM galeria_galerias {SQL_Where} {SQL_OrderBy}";
            list($this->s_Galeria->BoundColumn, $this->s_Galeria->TextColumn, $this->s_Galeria->DBFormat) = array("Galeria", "Galeria", "");
            $this->s_Categorias = new clsControl(ccsListBox, "s_Categorias", "s_Categorias", ccsText, "", CCGetRequestParam("s_Categorias", $Method, NULL), $this);
            $this->s_Categorias->DSType = dsTable;
            $this->s_Categorias->DataSource = new clsDBluisnova();
            $this->s_Categorias->ds = & $this->s_Categorias->DataSource;
            $this->s_Categorias->DataSource->SQL = "SELECT * \n" .
"FROM galeria_categorias {SQL_Where} {SQL_OrderBy}";
            list($this->s_Categorias->BoundColumn, $this->s_Categorias->TextColumn, $this->s_Categorias->DBFormat) = array("Categoria", "Categoria", "");
            $this->s_Categorias->HTML = true;
            $this->ClearParameters = new clsControl(ccsLink, "ClearParameters", "ClearParameters", ccsText, "", CCGetRequestParam("ClearParameters", $Method, NULL), $this);
            $this->ClearParameters->Parameters = CCGetQueryString("QueryString", array("s_Foto", "s_Titulo", "s_Descripcion", "s_Galeria", "s_Categorias", "ccsForm"));
            $this->ClearParameters->Page = "fotos.php";
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @2-D81337AB
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_Titulo->Validate() && $Validation);
        $Validation = ($this->s_Galeria->Validate() && $Validation);
        $Validation = ($this->s_Categorias->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_Titulo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_Galeria->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_Categorias->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-3E8ADF05
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_Titulo->Errors->Count());
        $errors = ($errors || $this->s_Galeria->Errors->Count());
        $errors = ($errors || $this->s_Categorias->Errors->Count());
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

//Operation Method @2-902EE006
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
        $Redirect = "fotos.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "fotos.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @2-C22F83FC
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

        $this->s_Galeria->Prepare();
        $this->s_Categorias->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_Titulo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_Galeria->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_Categorias->Errors->ToString());
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

        $this->s_Titulo->Show();
        $this->s_Galeria->Show();
        $this->s_Categorias->Show();
        $this->ClearParameters->Show();
        $this->Button_DoSearch->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End galeria_fotosSearch Class @2-FCB6E20C

class clsGridgaleria_fotos { //galeria_fotos class @10-95D4C1A3

//Variables @10-D18D90B3

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
    public $Sorter_Foto1;
    public $Sorter_Foto;
    public $Sorter_Titulo;
    public $Sorter_Galeria;
    public $Sorter_Categorias;
    public $Sorter_Fecha;
    public $Sorter_Publicar;
//End Variables

//Class_Initialize Event @10-F9A02FEC
    function clsGridgaleria_fotos($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "galeria_fotos";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid galeria_fotos";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsgaleria_fotosDataSource($this);
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
        $this->SorterName = CCGetParam("galeria_fotosOrder", "");
        $this->SorterDirection = CCGetParam("galeria_fotosDir", "");

        $this->id = new clsControl(ccsLink, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet, NULL), $this);
        $this->id->Page = "foto.php";
        $this->Foto1 = new clsControl(ccsImage, "Foto1", "Foto1", ccsText, "", CCGetRequestParam("Foto1", ccsGet, NULL), $this);
        $this->Foto = new clsControl(ccsLabel, "Foto", "Foto", ccsText, "", CCGetRequestParam("Foto", ccsGet, NULL), $this);
        $this->Titulo = new clsControl(ccsLabel, "Titulo", "Titulo", ccsText, "", CCGetRequestParam("Titulo", ccsGet, NULL), $this);
        $this->Galeria = new clsControl(ccsLabel, "Galeria", "Galeria", ccsText, "", CCGetRequestParam("Galeria", ccsGet, NULL), $this);
        $this->Categorias = new clsControl(ccsLabel, "Categorias", "Categorias", ccsText, "", CCGetRequestParam("Categorias", ccsGet, NULL), $this);
        $this->Fecha = new clsControl(ccsLabel, "Fecha", "Fecha", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("Fecha", ccsGet, NULL), $this);
        $this->Publicar = new clsControl(ccsCheckBox, "Publicar", "Publicar", ccsInteger, "", CCGetRequestParam("Publicar", ccsGet, NULL), $this);
        $this->Publicar->CheckedValue = $this->Publicar->GetParsedValue(1);
        $this->Publicar->UncheckedValue = $this->Publicar->GetParsedValue(0);
        $this->Orden = new clsControl(ccsLabel, "Orden", "Orden", ccsText, "", CCGetRequestParam("Orden", ccsGet, NULL), $this);
        $this->Sorter_id = new clsSorter($this->ComponentName, "Sorter_id", $FileName, $this);
        $this->Sorter_Foto1 = new clsSorter($this->ComponentName, "Sorter_Foto1", $FileName, $this);
        $this->Sorter_Foto = new clsSorter($this->ComponentName, "Sorter_Foto", $FileName, $this);
        $this->Sorter_Titulo = new clsSorter($this->ComponentName, "Sorter_Titulo", $FileName, $this);
        $this->Sorter_Galeria = new clsSorter($this->ComponentName, "Sorter_Galeria", $FileName, $this);
        $this->Sorter_Categorias = new clsSorter($this->ComponentName, "Sorter_Categorias", $FileName, $this);
        $this->Sorter_Fecha = new clsSorter($this->ComponentName, "Sorter_Fecha", $FileName, $this);
        $this->Sorter_Publicar = new clsSorter($this->ComponentName, "Sorter_Publicar", $FileName, $this);
        $this->galeria_fotos_Insert = new clsControl(ccsLink, "galeria_fotos_Insert", "galeria_fotos_Insert", ccsText, "", CCGetRequestParam("galeria_fotos_Insert", ccsGet, NULL), $this);
        $this->galeria_fotos_Insert->Parameters = CCGetQueryString("QueryString", array("id", "ccsForm"));
        $this->galeria_fotos_Insert->Page = "foto.php";
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

//Show Method @10-2071B0C1
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_Foto"] = CCGetFromGet("s_Foto", NULL);
        $this->DataSource->Parameters["urls_Titulo"] = CCGetFromGet("s_Titulo", NULL);
        $this->DataSource->Parameters["urls_Descripcion"] = CCGetFromGet("s_Descripcion", NULL);
        $this->DataSource->Parameters["urls_Galeria"] = CCGetFromGet("s_Galeria", NULL);
        $this->DataSource->Parameters["urls_Categorias"] = CCGetFromGet("s_Categorias", NULL);

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
            $this->ControlsVisible["Foto1"] = $this->Foto1->Visible;
            $this->ControlsVisible["Foto"] = $this->Foto->Visible;
            $this->ControlsVisible["Titulo"] = $this->Titulo->Visible;
            $this->ControlsVisible["Galeria"] = $this->Galeria->Visible;
            $this->ControlsVisible["Categorias"] = $this->Categorias->Visible;
            $this->ControlsVisible["Fecha"] = $this->Fecha->Visible;
            $this->ControlsVisible["Publicar"] = $this->Publicar->Visible;
            $this->ControlsVisible["Orden"] = $this->Orden->Visible;
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
                $this->Foto1->SetValue($this->DataSource->Foto1->GetValue());
                $this->Foto->SetValue($this->DataSource->Foto->GetValue());
                $this->Titulo->SetValue($this->DataSource->Titulo->GetValue());
                $this->Galeria->SetValue($this->DataSource->Galeria->GetValue());
                $this->Categorias->SetValue($this->DataSource->Categorias->GetValue());
                $this->Fecha->SetValue($this->DataSource->Fecha->GetValue());
                $this->Publicar->SetValue($this->DataSource->Publicar->GetValue());
                $this->Orden->SetValue($this->DataSource->Orden->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id->Show();
                $this->Foto1->Show();
                $this->Foto->Show();
                $this->Titulo->Show();
                $this->Galeria->Show();
                $this->Categorias->Show();
                $this->Fecha->Show();
                $this->Publicar->Show();
                $this->Orden->Show();
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
        $this->Sorter_Foto1->Show();
        $this->Sorter_Foto->Show();
        $this->Sorter_Titulo->Show();
        $this->Sorter_Galeria->Show();
        $this->Sorter_Categorias->Show();
        $this->Sorter_Fecha->Show();
        $this->Sorter_Publicar->Show();
        $this->galeria_fotos_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @10-E2A627CE
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Foto1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Foto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Titulo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Galeria->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Categorias->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Fecha->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Publicar->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Orden->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End galeria_fotos Class @10-FCB6E20C

class clsgaleria_fotosDataSource extends clsDBluisnova {  //galeria_fotosDataSource Class @10-168B520D

//DataSource Variables @10-724AD52A
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id;
    public $Foto1;
    public $Foto;
    public $Titulo;
    public $Galeria;
    public $Categorias;
    public $Fecha;
    public $Publicar;
    public $Orden;
//End DataSource Variables

//DataSourceClass_Initialize Event @10-DC00543D
    function clsgaleria_fotosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid galeria_fotos";
        $this->Initialize();
        $this->id = new clsField("id", ccsInteger, "");
        
        $this->Foto1 = new clsField("Foto1", ccsText, "");
        
        $this->Foto = new clsField("Foto", ccsText, "");
        
        $this->Titulo = new clsField("Titulo", ccsText, "");
        
        $this->Galeria = new clsField("Galeria", ccsText, "");
        
        $this->Categorias = new clsField("Categorias", ccsText, "");
        
        $this->Fecha = new clsField("Fecha", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->Publicar = new clsField("Publicar", ccsInteger, "");
        
        $this->Orden = new clsField("Orden", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @10-4EDF9386
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "Orden";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_id" => array("id", ""), 
            "Sorter_Foto1" => array("Foto", ""), 
            "Sorter_Foto" => array("Foto", ""), 
            "Sorter_Titulo" => array("Titulo", ""), 
            "Sorter_Galeria" => array("Galeria", ""), 
            "Sorter_Categorias" => array("Categorias", ""), 
            "Sorter_Fecha" => array("Fecha", ""), 
            "Sorter_Publicar" => array("Publicar", "")));
    }
//End SetOrder Method

//Prepare Method @10-276A67B7
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_Foto", ccsText, "", "", $this->Parameters["urls_Foto"], "", false);
        $this->wp->AddParameter("2", "urls_Titulo", ccsText, "", "", $this->Parameters["urls_Titulo"], "", false);
        $this->wp->AddParameter("3", "urls_Descripcion", ccsText, "", "", $this->Parameters["urls_Descripcion"], "", false);
        $this->wp->AddParameter("4", "urls_Galeria", ccsText, "", "", $this->Parameters["urls_Galeria"], "", false);
        $this->wp->AddParameter("5", "urls_Categorias", ccsText, "", "", $this->Parameters["urls_Categorias"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "Foto", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "Titulo", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "Descripcion", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "Galeria", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opContains, "Categorias", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]), 
             $this->wp->Criterion[5]);
    }
//End Prepare Method

//Open Method @10-BE1530A1
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM galeria_fotos";
        $this->SQL = "SELECT id, Foto, Titulo, Descripcion, Galeria, Categorias, Fecha, Publicar, Orden \n\n" .
        "FROM galeria_fotos {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @10-8B4A1B23
    function SetValues()
    {
        $this->id->SetDBValue(trim($this->f("id")));
        $this->Foto1->SetDBValue($this->f("Foto"));
        $this->Foto->SetDBValue($this->f("Foto"));
        $this->Titulo->SetDBValue($this->f("Titulo"));
        $this->Galeria->SetDBValue($this->f("Galeria"));
        $this->Categorias->SetDBValue($this->f("Categorias"));
        $this->Fecha->SetDBValue(trim($this->f("Fecha")));
        $this->Publicar->SetDBValue(trim($this->f("Publicar")));
        $this->Orden->SetDBValue($this->f("Orden"));
    }
//End SetValues Method

} //End galeria_fotosDataSource Class @10-FCB6E20C

//Include Page implementation @45-91B8C9D0
include_once(RelativePath . "/admin/Footer.php");
//End Include Page implementation

//Initialize Page @1-08916255
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
$TemplateFileName = "fotos.html";
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

//Initialize Objects @1-AB3F1D24
$DBluisnova = new clsDBluisnova();
$MainPage->Connections["luisnova"] = & $DBluisnova;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$Header = new clsHeader("", "Header", $MainPage);
$Header->Initialize();
$galeria_fotosSearch = new clsRecordgaleria_fotosSearch("", $MainPage);
$galeria_fotos = new clsGridgaleria_fotos("", $MainPage);
$Footer = new clsFooter("", "Footer", $MainPage);
$Footer->Initialize();
$MainPage->Header = & $Header;
$MainPage->galeria_fotosSearch = & $galeria_fotosSearch;
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

//Execute Components @1-B82499B1
$Header->Operations();
$galeria_fotosSearch->Operation();
$Footer->Operations();
//End Execute Components

//Go to destination page @1-6EF5C349
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBluisnova->close();
    header("Location: " . $Redirect);
    $Header->Class_Terminate();
    unset($Header);
    unset($galeria_fotosSearch);
    unset($galeria_fotos);
    $Footer->Class_Terminate();
    unset($Footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-F84B199F
$Header->Show();
$galeria_fotosSearch->Show();
$galeria_fotos->Show();
$Footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);

$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-77A5E9FA
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBluisnova->close();
$Header->Class_Terminate();
unset($Header);
unset($galeria_fotosSearch);
unset($galeria_fotos);
$Footer->Class_Terminate();
unset($Footer);
unset($Tpl);
//End Unload Page


?>
