<?php

require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$name = $_POST['name'];
$quantity = $_POST['quantity'];

/**
 * Set the Dompdf options
 */
$options = new Options();
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);

/**
 * Set the paper size and orientation
 */
$dompdf->setPaper("A4", "landscape");

// $html = "<h1>Example</h1>";
// $html .= "<p>hello <em>$name</em></p><br>";
// $html .= "<img src='images.jpeg' width=100 height=100><br><br>";
// $html .= "Quantity: $quantity"; 

/**
 * Load the HTML and replace placeholders with values from the form
 */
$html = file_get_contents("template.html");

$html = str_replace(["{{ name }}", "{{ quantity }}"], [$name, $quantity], $html);

$dompdf->loadHtml($html);
//$dompdf->loadHtmlFile("template.html");

/**
 * Create the PDF and set attributes
 */
$dompdf->render();

$dompdf->addInfo("Title", "An Example Pdf");

/**
 * Send the PDF to the browser
 */
$dompdf->stream('mypdf.pdf', ['Attachment' => 0]);

/**
 * Save the PDF file locally
 */
$output = $dompdf->output();
file_put_contents("file.pdf", $output);