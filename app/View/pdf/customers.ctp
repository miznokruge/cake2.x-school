<?php
App::import('Vendor', 'xtcpdf');
set_time_limit(300000);
$pdf = new XTCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
//---------------------------------------------------------- config start ---------------------------------------------------------------------------
$pdf->namaorg = $this->Info->application('company_name');
$pdf->telp = $this->Info->application('company_phone');
$pdf->fax = $this->Info->application('company_fax');
$pdf->nama_aplikasi = $this->Info->application('app_name');
$pdf->alamat = $this->Info->application('company_address');
$pdf->email = $this->Info->application('company_email');
$pdf->website = $this->Info->application('company_website');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mizno Kruge');
$pdf->SetTitle('TCPDF Example 048');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
//$pdf->SetHeaderData($logo,20, '','');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
#$pdf->SetDisplayMode($zoom='fullpage', $layout='TwoColumnRight', $mode='UseNone');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 28, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 8);
$label = array(array('l' => 'id', 'w' => 50), array('l' => 'name', 'w' => 150), array('l' => 'phone', 'w' => 130), array('l' => 'phone_alt', 'w' => 130), array('l' => 'email', 'w' => 200));
//---------------------------------------------------------- config end ---------------------------------------------------------------------------
$title = 'Customer Report';
$html = '<center><h1>' . $title . '</h1></center>';
$html.= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
$html.= '<tr>';
foreach ($label as $x => $l) {
    $html.= '<td width="' . $l['w'] . '">' . $l['l'] . '</td>';
}
$html.= '</tr>';
foreach ($customers as $customer) {
    $html.= '<tr>';
    for ($i = 0; $i < count($label); $i++) {
        $html.= '<td>' . $customer['Customer'][$label[$i]['l']] . '</td>';
    }
    $html.= '</tr>';
}
$html.= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');
//$pdf->lastPage();
$pdf->Output($title . '.pdf', 'I');
die();
