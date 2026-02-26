<?php


namespace App\Service;
use Dompdf\Dompdf;

class generarPDF
{
    public function generarPDF($html, $nombreArchivo)
    {
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);



        $dompdf->render();

        $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    }
}