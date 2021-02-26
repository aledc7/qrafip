# QR AFIP

![aledc.tk](https://github.com/aledc7/qrafip/blob/main/recursos/qrafip.png?raw=true "aledc.tk")

## Generación del Código QR para AFIP Argentina  


[![aledc.com](https://github.com/aledc7/Scrum-Certification/blob/master/recursos/aledc.com.svg)](https://aledc.tk)
[![License](https://github.com/aledc7/Scrum-Certification/blob/master/recursos/mit-license.svg)](https://aledc.tk)
[![GitHub release](https://github.com/aledc7/Scrum-Certification/blob/master/recursos/release.svg)](https://aledc.tk)
[![Dependencies](https://github.com/aledc7/Scrum-Certification/blob/master/recursos/dependencias-none.svg)](https://aledc.tk)





La Administración Federal de Ingresos Públicos dispuso la implementación obligatoria de un código de respuesta rápida “QR” en los comprobantes electrónicos. El código “QR” podrá ser escaneado por una cámara estándar de un dispositivo celular, tablet o similar con acceso a internet y brindará información sobre el comprobante y el emisor del mismo.

Esta medida alcanza a todos los contribuyentes y/o responsables cuya autorización de emisión de comprobantes electrónicos, se haya tramitado en los términos del “Régimen de Emisión de Comprobantes Electrónicos” establecido por la Resolución General N° 4.291.




## Ejemplo funcionando en PHP para integrar a sus Sistemas.   


_________________________________________________________________    


__Requisitos:__

- [x] Composer

__Instrucciones:__

1. - Crear una nueva carpeta y con tu editor de código favorito

2. - Dentro de la Carpeta recién creada correr este comando
```php
composer require endroid/qr-code
```
3. -  Crear un archivo index.php y pegar el siguiente código:
```php
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

```



