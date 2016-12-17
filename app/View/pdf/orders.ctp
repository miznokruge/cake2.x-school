<?php
App::import('Vendor', 'xtcpdf');
set_time_limit(300000);
$pdf = new XTCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$doc_name = 'Sales Report';
$filename = time() . '.pdf';
//---------------------------------------------------------- config start ---------------------------------------------------------------------------
$pdf->namaorg = $this->Info->application('company_name');
$pdf->telp = $this->Info->application('company_phone');
$pdf->fax = $this->Info->application('company_fax');
$pdf->nama_aplikasi = $this->Info->application('app_name');
$pdf->alamat = $this->Info->application('company_address');
$pdf->email = $this->Info->application('company_email');
$pdf->website = $this->Info->application('company_website');
$pdf->logo = '../webroot/img/logo/' . $this->Info->application('logo');
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
$pdf->SetFont('helvetica', '', 7);
//---------------------------------------------------------- config end ---------------------------------------------------------------------------
$html = '<center><h1>Order Report</h1></center>';
$html.= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
$html.= '<tr>';
$html.= '<td width="50">Order Id</td>';
$html.= '<td width="100">Customer</td>';
$html.= '<td width="100">Tanggal</td>';
$html.= '<td>Total Order</td>';
$html.= '<td>User</td>';
$html.= '<td>Status</td>';
$html.= '</tr>';
foreach ($orders as $order) {
    $html.= '<tr>';
    $html.= '<td>' . $order['Order']['id'] . '</td>';
    $html.= '<td>' . $order['Customer']['name'] . '</td>';
    $html.= '<td>' . $order['Order']['created'] . '</td>';
    $html.= '<td>' . $order['Order']['total_sell_price'] . '</td>';
    $html.= '<td>' . $order['User']['username'] . '</td>';
    $html.= '<td>' . $order['State']['label'] . '</td>';
    $html.= '</tr>';
}
$html.= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');
//$pdf->lastPage();
$pdf->Output("../webroot/files/pdf/" . $filename, 'I');
die();
