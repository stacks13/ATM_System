<?php

use Clegginabox\PDFMerger\PDFMerger;

include 'include/PDFMerger.php';
$amount = (int)$_POST['amount'];
$pdf = new PDFMerger;
for ($i=0; $i<$amount/100; $i++){
    $pdf->addPDF('include/note.pdf', 'all');
}
$pdf->merge('download', 'Notes.pdf', 'L');