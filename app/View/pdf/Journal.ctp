<?php

App::import('Vendor', 'xtcpdf');
set_time_limit(300000);
$pdf = new XTCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$nama_laporan = 'Journal Voucher';
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
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, 28, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 8);
//---------------------------------------------------------- config end ---------------------------------------------------------------------------
$html = '';
$html.='<table cellpadding="5" cellspacing="0" border="0" width="640">';
$html.='<tr>';
$html.='<td colspan="3" align="center" style="margin-top:3px; margin-bottom:5px;"><h1><u>' . $nama_laporan . '</u></h1></td>';
$html.='</tr>';
$html.='<tr>';
$html.='<td width="640" colspan="3">
	<table width="640" border="0" style="margin-top:10px;" cellpadding="2">
			<tr>
				<td width="100">Voucher No</td>
				<td width="400">: ' . $this->Util->nolnoldidepan($journal['Journal']['id']) . '</td>
			</tr>
               <tr>
				<td width="100">System Ref</td>
				<td width="400">: ' . $journal['Journal']['system_ref'] . '</td>
			</tr>
			<tr>
				<td width="100">Date</td>
				<td width="400">: ' . $journal['Journal']['input_date'] . '</td>
			</tr>
			<tr>
				<td width="100">Periode</td>
				<td width="400">: ' . $journal['Period']['code'] . '</td>
</tr>
<tr>
<td width = "100">Description</td>
<td width = "400">: ' . $journal['Journal']['remark'] . '</td>
</tr>
<tr>
<td width = "100">Total</td>
<td width = "400">: ' . number_format($journal['Journal']['total']) . '</td>
</tr>
</table>
</td>';
$html.='</tr>';
$html.='</table>';
$html.='<table border="0.5" cellpadding="4" cellspacing="1" width="640">
              <thead>
            	<tr>
                	<th width="300"><strong>Account No & Description</strong></th>
                	<th width="150"><strong>Debet</strong></th>
                	<th width="150"><strong>Kredit</strong></th>
                </tr>
                </thead>';
$td = 0;
$tk = 0;
$i = 0;
foreach ($journal['JournalDetail'] as $journalDetail) {
    $html.='<tr>
            	  <td width="300">' . $journalDetail['Account']['account_no'] . '.' . $journalDetail['Account']['account_name'] . '</td>
            	  <td width="150">' . number_format($journalDetail['debit']) . '</td>
            	  <td width="150">' . number_format($journalDetail['credit']) . '</td>
          	    </tr>';
    $td+=$journalDetail['debit'];
    $tk+=$journalDetail['credit'];
}
$html.='<tr>
    <td width="300" align="right"><strong>Total</strong></td>
    <td width="150"><strong>' . number_format($td) . '</strong></td>
    <td width="150"><strong>' . number_format($tk) . '</strong></td>
</tr>
</table>';
$html.='<br>Say : <i>' . $this->Util->say($td) . ' rupiah</i>';
$html.='<br><br><table border=".5" cellpadding="4" cellspacing="1" width="400">
    <tr>
        <td width="150">Created By</td>
        <td width="150">Approved By</td>
        <td width="150">Receiver</td>
    </tr>
    <tr>
        <td width="150"><br><br><br><br>' . $journal['User']['username'] . '</td>
        <td width="150"><br><br><br><br>' . $journal['User']['username'] . '</td>
        <td width="150"><br><br><br><br>' . $journal['User']['username'] . '</td>
    </tr>
</table>';
$pdf->Ln(2);
$pdf->writeHTML($html, true, false, true, false, '');
//$pdf->lastPage();
$pdf->Output($nama_laporan . '.pdf', 'I');
