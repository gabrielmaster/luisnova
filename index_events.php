<?php
//BindEvents Method @1-FB59376C
function BindEvents()
{
    global $galeria_fotos;
    global $CCSEvents;
    $galeria_fotos->Foto->CCSEvents["BeforeShow"] = "galeria_fotos_Foto_BeforeShow";
    $galeria_fotos->CCSEvents["BeforeShowRow"] = "galeria_fotos_BeforeShowRow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//galeria_fotos_Foto_BeforeShow @8-486F12AD
function galeria_fotos_Foto_BeforeShow(& $sender)
{
    $galeria_fotos_Foto_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $galeria_fotos; //Compatibility
//End galeria_fotos_Foto_BeforeShow

//Gallery Layout @9-6715D311
    $NumberOfColumns = $Component->Attributes->GetText("numberOfColumns");
    if (isset($Component->RowOpenTag))
        $Component->RowOpenTag->Visible = ($Component->RowNumber % $NumberOfColumns) == 1;
    if (isset($Component->AltRowOpenTag))
        $Component->AltRowOpenTag->Visible = ($Component->RowNumber % $NumberOfColumns) == 1;
    if (isset($Component->RowCloseTag))
        $Component->RowCloseTag->Visible = (($Component->RowNumber % $NumberOfColumns) == 0);
    if (isset($Component->AltRowCloseTag))
        $Component->AltRowCloseTag->Visible = (($Component->RowNumber % $NumberOfColumns) == 0);
    if (isset($Component->RowComponents))
        $Component->RowComponents->Visible = !$Component->ForceIteration;
    if (isset($Component->AltRowComponents))
        $Component->AltRowComponents->Visible = !$Component->ForceIteration;
    $Component->ForceIteration = (($Component->RowNumber >= $Component->PageSize) || !$Component->DataSource->has_next_record()) && ($Component->RowNumber % $NumberOfColumns);
//End Gallery Layout

//Close galeria_fotos_Foto_BeforeShow @8-117E79F5
    return $galeria_fotos_Foto_BeforeShow;
}
//End Close galeria_fotos_Foto_BeforeShow

//galeria_fotos_BeforeShowRow @5-09E5CC0E
function galeria_fotos_BeforeShowRow(& $sender)
{
    $galeria_fotos_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $galeria_fotos; //Compatibility
//End galeria_fotos_BeforeShowRow

//Gallery Layout @14-6715D311
    $NumberOfColumns = $Component->Attributes->GetText("numberOfColumns");
    if (isset($Component->RowOpenTag))
        $Component->RowOpenTag->Visible = ($Component->RowNumber % $NumberOfColumns) == 1;
    if (isset($Component->AltRowOpenTag))
        $Component->AltRowOpenTag->Visible = ($Component->RowNumber % $NumberOfColumns) == 1;
    if (isset($Component->RowCloseTag))
        $Component->RowCloseTag->Visible = (($Component->RowNumber % $NumberOfColumns) == 0);
    if (isset($Component->AltRowCloseTag))
        $Component->AltRowCloseTag->Visible = (($Component->RowNumber % $NumberOfColumns) == 0);
    if (isset($Component->RowComponents))
        $Component->RowComponents->Visible = !$Component->ForceIteration;
    if (isset($Component->AltRowComponents))
        $Component->AltRowComponents->Visible = !$Component->ForceIteration;
    $Component->ForceIteration = (($Component->RowNumber >= $Component->PageSize) || !$Component->DataSource->has_next_record()) && ($Component->RowNumber % $NumberOfColumns);
//End Gallery Layout

//Close galeria_fotos_BeforeShowRow @5-8936855D
    return $galeria_fotos_BeforeShowRow;
}
//End Close galeria_fotos_BeforeShowRow
/*if($_SERVER['DOCUMENT_ROOT'] != '/home/www/luisnova.com'){
  exit;
}*/
//Page_BeforeShow @1-4CD7DBED
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $index; //Compatibility
//End Page_BeforeShow

//Declare Variable @4-8F636E8F
    global $CatID;
    $CatID = $_REQUEST["categoria"];
//End Declare Variable

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>