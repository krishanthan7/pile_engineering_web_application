
<?php
// Ensure no output is sent before header or PDF generation
ob_start();

require('fpdf/fpdf.php');
include 'dbconfig.php'; // Include database configuration

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Database Summary', 0, 1, 'C');
        $this->Ln(5);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Table with data
    function Table($header, $data)
    {
        // Calculate column widths based on the number of columns
        $numCols = count($header);
        $pageWidth = $this->GetPageWidth() - 20; // 10 mm margin on each side
        $colWidth = $pageWidth / $numCols;

        // Header
        $this->SetFont('Arial', 'B', 10);
        foreach ($header as $col) {
            $this->Cell($colWidth, 7, $col, 1);
        }
        $this->Ln();

        // Data
        $this->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell($colWidth, 6, $col, 1);
            }
            $this->Ln();
        }
    }
}

if (isset($_POST['generateSummary'])) {
    // Create new PDF instance with landscape orientation
    $pdf = new PDF('L', 'mm', 'A4'); // 'L' for landscape orientation
    $pdf->AddPage();

    // Set font for the table header
    $pdf->SetFont('Arial', 'B', 12);

    // Fetch all projects
    $projectQuery = "SELECT * FROM project";
    $projectResult = mysqli_query($connection, $projectQuery);

    while ($project = mysqli_fetch_assoc($projectResult)) {
        // Display project details
        $pdf->Cell(0, 10, 'Project:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'ID: ' . $project['id'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Project Name: ' . $project['project_name'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Cost: ' . $project['cost'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Client: ' . $project['client'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Consultant: ' . $project['consultant'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Duration: ' . $project['duration'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Pile Count: ' . $project['pilecount'], 0, 1, 'L');
        $pdf->Cell(0, 10, 'Assigned PM: ' . $project['assigned_pm'], 0, 1, 'L');
        $pdf->Ln(1);

        // Fetch and display related piles
        $pileQuery = "SELECT id, pile_number, actual_co_North, actual_co_East, date, ground_level, ctl, col FROM pile WHERE fk_project_id = " . $project['id'];
        $pileResult = mysqli_query($connection, $pileQuery);
        if ($pileResult && mysqli_num_rows($pileResult) > 0) {
            $pdf->Cell(0, 10, 'Piles:', 0, 1, 'L');
            $header = array('ID', 'Pile Number', 'Actual Co North', 'Actual Co East', 'Date', 'Ground Level', 'CTL', 'COL');
            $data = array();
            while ($row = mysqli_fetch_assoc($pileResult)) {
                $data[] = $row;
            }
            $pdf->Table($header, $data);
            $pdf->Ln(5);
        }
    }

    // Clear the output buffer
    ob_end_clean();

    // Output PDF to browser
    $pdf->Output();
    exit; // Stop further execution
}
?>


