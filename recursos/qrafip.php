<?php

// NOTA:  Este es un ejemplo para generar el código QR para las facturas de AFIP Argentina
// que se solicita en la nueva normativa del 2021.
// Solo resta integrarlo en el sistema que vos tengas.

// Para consultas profesionales podes contactarme en ing.alejandrodecastro@gmail.com


header("content-type: image/png");

require "vendor/autoload.php";

use Endroid\QrCode\QrCode;

// genero los datos para AFIP
$url = 'https://www.afip.gob.ar/fe/qr/'; // URL que pide AFIP que se ponga en el QR. 
$datos_cmp_base_64 = json_encode([ 
    "ver" => 1,                         // Numérico 1 digito -  OBLIGATORIO – versión del formato de los datos del comprobante	1
    "fecha" => "2020-10-13",            // full-date (RFC3339) - OBLIGATORIO – Fecha de emisión del comprobante
    "cuit" => (int) 30000000007,        // Numérico 11 dígitos -  OBLIGATORIO – Cuit del Emisor del comprobante  
    "ptoVta" => (int) 10,               // Numérico hasta 5 digitos - OBLIGATORIO – Punto de venta utilizado para emitir el comprobante
    "tipoCmp" => (int) 1,               // Numérico hasta 3 dígitos - OBLIGATORIO – tipo de comprobante (según Tablas del sistema. Ver abajo )
    "nroCmp" => (int) 94,               // Numérico hasta 8 dígitos - OBLIGATORIO – Número del comprobante
    "importe" => (float) 12100,         // Decimal hasta 13 enteros y 2 decimales - OBLIGATORIO – Importe Total del comprobante (en la moneda en la que fue emitido)
    "moneda" => "PES",                  // 3 caracteres - OBLIGATORIO – Moneda del comprobante (según Tablas del sistema. Ver Abajo )
    "ctz" => (float) 1,                 // Decimal hasta 13 enteros y 6 decimales - OBLIGATORIO – Cotización en pesos argentinos de la moneda utilizada (1 cuando la moneda sea pesos)
    "tipoDocRec" =>  80 ,               // Numérico hasta 2 dígitos - DE CORRESPONDER – Código del Tipo de documento del receptor (según Tablas del sistema )
    "nroDocRec" =>  20000000001,        // Numérico hasta 20 dígitos - DE CORRESPONDER – Número de documento del receptor correspondiente al tipo de documento indicado
    "tipoCodAut" => "E",                // string - OBLIGATORIO – “A” para comprobante autorizado por CAEA, “E” para comprobante autorizado por CAE
    "codAut" => (int) 70417054367476    // Numérico 14 dígitos -  OBLIGATORIO – Código de autorización otorgado por AFIP para el comprobante
]); 

$datos_cmp_base_64 = base64_encode($datos_cmp_base_64); 
$to_qr = $url.'?p='.$datos_cmp_base_64;




$qrcode = new QrCode($to_qr);

echo $qrcode->writeString();

die();




?>
