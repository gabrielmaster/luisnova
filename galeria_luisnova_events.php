<?php
//BindEvents Method @1-45AEDFB9
function BindEvents()
{
    global $galeria_fotos;
    $galeria_fotos->Foto->CCSEvents["BeforeShow"] = "galeria_fotos_Foto_BeforeShow";
    $galeria_fotos->CCSEvents["BeforeShowRow"] = "galeria_fotos_BeforeShowRow";
}
//End BindEvents Method

//galeria_fotos_Foto_BeforeShow @11-486F12AD
function galeria_fotos_Foto_BeforeShow(& $sender)
{
    $galeria_fotos_Foto_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $galeria_fotos; //Compatibility
//End galeria_fotos_Foto_BeforeShow

//Gallery Layout @12-6715D311
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

//Close galeria_fotos_Foto_BeforeShow @11-117E79F5
    return $galeria_fotos_Foto_BeforeShow;
}
//End Close galeria_fotos_Foto_BeforeShow

//galeria_fotos_BeforeShowRow @2-09E5CC0E
function galeria_fotos_BeforeShowRow(& $sender)
{
    $galeria_fotos_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $galeria_fotos; //Compatibility
//End galeria_fotos_BeforeShowRow

//Gallery Layout @7-6715D311
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

//Close galeria_fotos_BeforeShowRow @2-8936855D
    return $galeria_fotos_BeforeShowRow;
}
//End Close galeria_fotos_BeforeShowRow


?>
