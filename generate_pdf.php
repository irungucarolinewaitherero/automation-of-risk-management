<?php
// Include TCPDF library (adjust the path as needed)
require_once 'vendor/autoload.php';

$servername = "localhost";
$username = "root";  // Your DB username
$password = "";      // Your DB password
$dbname = "risk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Query to fetch the risk data
$sql = "SELECT * FROM risk_register"; 
$result = $conn->query($sql);

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, 'Risk List', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Risk List PDF');
$pdf->SetSubject('Generated PDF from table');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Define the HTML for the table with consideration for long words
$html = '<style>
    th, td {
        border: 1px solid #000;
        padding: 6px;
        text-align: left;
        word-wrap: break-word; /* Ensure long words are wrapped */
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
<h2>Risk List</h2>
<table>
    <thead>
        <tr>
            <th>Risk Name</th>
            <th>Description</th>
            <th>Inherent Impact</th>
            <th>Inherent Likelihood</th>
            <th>Inherent Risk</th>
            <th>Controls</th>
            <th>Impact</th>
            <th>Likelihood</th>
            <th>Residual Risk</th>
            <th>Status</th>
            <th>Owner</th>
        </tr>
    </thead>
    <tbody>';

// Check if there are any rows returned
if ($result && $result->num_rows > 0) {
    // Fetch each row as an associative array and build the HTML
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>'.$row["risk_name"].'</td>
                    <td>'.$row["risk_description"].'</td>
                    <td>'.$row["Inherent_Impact"].'</td>
                    <td>'.$row["inherent_Likelihood"].'</td>
                    <td>'.$row["Inherent_Risk"].'</td>
                    <td>'.$row["Controls"].'</td>
                    <td>'.$row["risk_impact"].'</td>
                    <td>'.$row["risk_likelihood"].'</td>
                    <td>'.$row["risk_score"].'</td>
                    <td>'.$row["status"].'</td>
                    <td>'.$row["Owner"].'</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="11">No records found.</td></tr>';
}

$html .= '</tbody></table>';

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('risk_list.pdf', 'I');

// Close the database connection
$conn->close();
?>
