<?php

namespace Classes;

use Dompdf\Dompdf;

class PDF
{

    public static function generarComprobante($pago, $consumo, $contribuyente, $predio, $usuario)
    {
        ob_start();
        include __DIR__ . '/../views/pdf/comprobante.php';
        $html = ob_get_clean();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Obtener el PDF en una variable
        $pdfContent = $dompdf->output();

        // Definir ruta y nombre del archivo en el servidor
        $filename = "comprobante_{$pago->numero_comprobante}.pdf";
        $ruta = __DIR__ . "/../public/documents/" . $filename;

        // Guardar el archivo
        file_put_contents($ruta, $pdfContent);

        // Retornar solo el nombre del archivo (para construir URL pública)
        return $filename;
    }
}
