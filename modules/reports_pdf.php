<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('reports.view');
require dirname(__DIR__) . '/includes/reporting.php';
require dirname(__DIR__) . '/includes/fpdf/fpdf.php';

$filters = spa_report_filters();
$data = spa_report_data($filters);
$logoPath = dirname(__DIR__) . '/assets/img/eden_skin_logo.jpg';

function spa_pdf_text($text): string {
    $text = trim((string)$text);
    if ($text === '') return '-';
    $converted = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
    return $converted !== false ? $converted : $text;
}
function spa_pdf_short($text, int $length = 35): string {
    $text = trim((string)$text);
    if ($text === '') return '-';
    return strlen($text) > $length ? substr($text, 0, $length - 3) . '...' : $text;
}

class EdenSkinReportPdf extends FPDF {
    public string $logoPath = '';
    public function Header(): void {
        if ($this->logoPath && is_file($this->logoPath)) {
            $this->Image($this->logoPath, 15, 8, 24, 24);
        }
        $this->SetFont('Arial','B',15);
        $this->Cell(0,7,spa_pdf_text('Eden Skin - Sales Report'),0,1,'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0,5,spa_pdf_text('Skin Beauty Aesthetics'),0,1,'C');
        $this->Cell(0,5,spa_pdf_text('Generated: '.date('d M Y H:i')),0,1,'C');
        $this->Ln(8);
        $this->SetDrawColor(180,180,180);
        $this->Line(15,38,195,38);
        $this->Ln(6);
    }
    public function Footer(): void {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,spa_pdf_text('Page '.$this->PageNo().'/{nb}'),0,0,'C');
    }
    public function NeedsPageBreak($height): bool {
        return ($this->GetY() + $height > 280);
    }
}

$pdf = new EdenSkinReportPdf('P','mm','A4');
$pdf->logoPath = $logoPath;
$pdf->AliasNbPages();
$pdf->SetMargins(15, 15, 15);
$pdf->AddPage();

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(240,240,240);
$pdf->Cell(0,7,spa_pdf_text('Filter Summary'),1,1,'L',true);
$pdf->SetFont('Arial','',9);
$filterText = 'From: '.($filters['from_date'] ?: 'All').'   To: '.($filters['to_date'] ?: 'All').'   View: '.ucfirst($filters['group_by']).'   Limit: '.$filters['limit'];
$pdf->MultiCell(0,6,spa_pdf_text($filterText),1);
$pdf->Ln(4);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,8,spa_pdf_text('Revenue'),1,0,'C',true);
$pdf->Cell(45,8,spa_pdf_text('Paid'),1,0,'C',true);
$pdf->Cell(45,8,spa_pdf_text('Expenses'),1,0,'C',true);
$pdf->Cell(45,8,spa_pdf_text('Profit'),1,1,'C',true);
$pdf->SetFont('Arial','',10);
$pdf->Cell(45,8,number_format((float)$data['totals']['revenue'],2),1,0,'R');
$pdf->Cell(45,8,number_format((float)$data['totals']['paid'],2),1,0,'R');
$pdf->Cell(45,8,number_format((float)$data['totals']['expenses'],2),1,0,'R');
$pdf->Cell(45,8,number_format((float)$data['totals']['profit'],2),1,1,'R');
$pdf->Ln(6);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,7,spa_pdf_text('Sales List'),0,1,'L');
$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(230,230,230);
$pdf->Cell(15,7,'ID',1,0,'C',true);
$pdf->Cell(28,7,'Invoice',1,0,'C',true);
$pdf->Cell(30,7,'Date',1,0,'C',true);
$pdf->Cell(40,7,'Customer',1,0,'C',true);
$pdf->Cell(27,7,'Branch',1,0,'C',true);
$pdf->Cell(22,7,'Total',1,0,'C',true);
$pdf->Cell(18,7,'Status',1,1,'C',true);
$pdf->SetFont('Arial','',8);
$grand = 0;
foreach ($data['sales'] as $row) {
    if ($pdf->NeedsPageBreak(8)) {
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',8);
        $pdf->SetFillColor(230,230,230);
        $pdf->Cell(15,7,'ID',1,0,'C',true);
        $pdf->Cell(28,7,'Invoice',1,0,'C',true);
        $pdf->Cell(30,7,'Date',1,0,'C',true);
        $pdf->Cell(40,7,'Customer',1,0,'C',true);
        $pdf->Cell(27,7,'Branch',1,0,'C',true);
        $pdf->Cell(22,7,'Total',1,0,'C',true);
        $pdf->Cell(18,7,'Status',1,1,'C',true);
        $pdf->SetFont('Arial','',8);
    }
    $grand += (float)$row['total_amount'];
    $pdf->Cell(15,7,'#'.$row['id'],1,0,'C');
    $pdf->Cell(28,7,spa_pdf_text(spa_pdf_short($row['invoice_no'],16)),1,0,'L');
    $pdf->Cell(30,7,spa_pdf_text(substr((string)$row['sale_date'],0,16)),1,0,'L');
    $pdf->Cell(40,7,spa_pdf_text(spa_pdf_short($row['customer'],24)),1,0,'L');
    $pdf->Cell(27,7,spa_pdf_text(spa_pdf_short($row['branch'],15)),1,0,'L');
    $pdf->Cell(22,7,number_format((float)$row['total_amount'],2),1,0,'R');
    $pdf->Cell(18,7,spa_pdf_text($row['status']),1,1,'C');
}
$pdf->SetFont('Arial','B',8);
$pdf->Cell(140,7,spa_pdf_text('Grand Total'),1,0,'R',true);
$pdf->Cell(22,7,number_format($grand,2),1,0,'R',true);
$pdf->Cell(18,7,'',1,1,'C',true);
$pdf->Ln(6);

$sections = [
    ['title' => ucfirst($filters['group_by']).' Sales Summary', 'headers' => ['Period','Count','Amount'], 'rows' => $data['summary'], 'map' => fn($r) => [$r['period'], number_format((int)$r['sales_count']), number_format((float)$r['amount'],2)]],
    ['title' => 'Best Selling Services & Packages', 'headers' => ['Service / Package','Qty','Revenue'], 'rows' => $data['top_services'], 'map' => fn($r) => [spa_pdf_short($r['name'],45), number_format((float)$r['qty'],2), number_format((float)$r['revenue'],2)]],
    ['title' => 'Best Selling Products', 'headers' => ['Product','Qty','Revenue'], 'rows' => $data['top_products'], 'map' => fn($r) => [spa_pdf_short($r['name'],45), number_format((float)$r['qty'],2), number_format((float)$r['revenue'],2)]],
    ['title' => 'Sales by Branch', 'headers' => ['Branch','Count','Total'], 'rows' => $data['sales_by_branch'], 'map' => fn($r) => [spa_pdf_short($r['name'],45), number_format((int)$r['sales_count']), number_format((float)$r['total_sales'],2)]],
];
foreach ($sections as $section) {
    if ($pdf->NeedsPageBreak(32)) $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,7,spa_pdf_text($section['title']),0,1,'L');
    $pdf->SetFont('Arial','B',8);
    $pdf->SetFillColor(230,230,230);
    $pdf->Cell(90,7,spa_pdf_text($section['headers'][0]),1,0,'L',true);
    $pdf->Cell(35,7,spa_pdf_text($section['headers'][1]),1,0,'C',true);
    $pdf->Cell(55,7,spa_pdf_text($section['headers'][2]),1,1,'R',true);
    $pdf->SetFont('Arial','',8);
    if (!$section['rows']) {
        $pdf->Cell(180,7,spa_pdf_text('No data found.'),1,1,'C');
    } else {
        foreach ($section['rows'] as $r) {
            if ($pdf->NeedsPageBreak(8)) $pdf->AddPage();
            [$a,$b,$c] = $section['map']($r);
            $pdf->Cell(90,7,spa_pdf_text($a),1,0,'L');
            $pdf->Cell(35,7,spa_pdf_text($b),1,0,'C');
            $pdf->Cell(55,7,spa_pdf_text($c),1,1,'R');
        }
    }
    $pdf->Ln(4);
}

$pdf->Output('I', 'eden_skin_sales_report.pdf');
exit;
