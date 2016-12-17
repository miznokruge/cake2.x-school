<?php

App::import('Vendor', 'PHPExcel', array('file' => 'excel/PHPExcel.php'));
App::import('Vendor', 'PHPExcel_IOFactory', array('file' => 'excel/PHPExcel/IOFactory.php'));
App::import('Vendor', 'PHPExcel_Worksheet_Drawing', array('file' => 'excel/PHPExcel/Worksheet/Drawing.php'));
App::import('Vendor', 'PHPExcel_Reader_CSV', array('file' => 'excel/PHPExcel/Reader/CSV.php'));

/**
 * excel is a wrapper component to use PHPExcel functionality
 *
 * @author Mizno Kruge
 * @since Apr 29, 2012
 * Copyright "PT Tricipta Media Perkasa" all rights reserved
 */
class ExcelComponent extends Component {

    public $controller;
    public $PO_DIR;
    public $QUOTE_DIR;
    public $INVOICE_DIR;
    public $IMG_DIR;
    public $phpExcel;
    public $END_COLUMN;
    public $Base_Dir;
    public $components = array(
        'Arr',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
        )
    );

    function initialize(Controller $controller) {
        $this->controller = $controller;
        $this->Base_Dir = dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'files' . DS;
        $this->PO_DIR = dirname($_SERVER['SCRIPT_FILENAME']) . '/files/po/';
        $this->QUOTE_DIR = dirname($_SERVER['SCRIPT_FILENAME']) . '/files/quote/';
        $this->QUOTE_DIR_IMG = dirname($_SERVER['SCRIPT_FILENAME']) . '/files/quote/imgs';
        $this->OUTPAYMENT_DIR = dirname($_SERVER['SCRIPT_FILENAME']) . '/files/outpayment/';
        $this->INVOICE_DIR = dirname($_SERVER['SCRIPT_FILENAME']) . '/files/invoice/';
        $this->INVOICE_LUNAS_DIR = dirname($_SERVER['SCRIPT_FILENAME']) . '/files/invoicelunas/';
        $this->IMG_DIR = dirname($_SERVER['SCRIPT_FILENAME']) . '/img/';
        $this->END_COLUMN = 'J';
    }

    public function loadExcelFile($filename) {
        $this->PHPExcelReader = new PHPExcel_Reader_CSV();
        $excel = $this->PHPExcelReader->load($filename);
        $data = $excel->getSheet(0)->toArray();
        $i = -1;
        $a = 0;
        $txt = '';
        foreach ($data as $dt) {
            if ($dt[3] != '') {
                $i++;
            }
            $dx[$i]['ket'][] = $dt[1];
        }
        $a++;

        $b = 0;
        foreach ($data as $dt) {
            if ($dt[3] != '') {
                $dx[$b]['date'] = $dt[0];
                $dx[$b]['content'] = $dt[1];
                $dx[$b]['bank_branch_code'] = $dt[2];
                $dx[$b]['amount'] = $dt[3];
                $dx[$b]['code'] = $dt[4];
                $dx[$b]['saldo'] = $dt[5];
                $b++;
            }
        }
        return $dx;
    }

    function generateOutpayment($payInfo, $outpayment) {
        $this->phpExcel = new PHPExcel();
        $this->row = 1;
        if (!$this->isValidOutpaymentInfo($payInfo))
            return false;
        $this->setHeaderImage();
        $this->setPhoneNumber();
        $this->setInvoiceDate();
        // Set Doc Title
        $supplierName = $payInfo[0]['sup']['name'];
        $this->row = 8;
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(18);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Pembayaran Combine ' . $supplierName);

        $this->setOutpaymentTableHeader();
        $this->setOutpaymentList($payInfo);
        $fileName = $this->getOutpayFileName($supplierName, $outpayment);
        if ($fileName) {
            $objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel2007');
            $objWriter->save($this->OUTPAYMENT_DIR . $fileName);
            return $fileName;
        }
        return false;
    }

    function generatePO($poInfo) {
        $this->phpExcel = new PHPExcel();
        $this->row = 1;
        if (!$this->isValidPoInfo($poInfo))
            return false;
        $this->END_COLUMN = 'I';
        $this->setPropertiesPO();
        $this->setHeaderImage();
        $this->setPhoneNumber();
        $this->setDocTitle();

        $this->writePOInfo($poInfo['Supplier'], $poInfo['Customer']);
        //$this->writeSupplier($poInfo['Supplier']);

        $this->writeItems($poInfo['Buy'], strtolower($poInfo['Supplier']['Supplier']['name']));
        $shipping = (isset($poInfo['Shipping'])) ? $poInfo['Shipping'] : null;

        $this->writeShipping($shipping);

        $this->writeExtrainfo($poInfo['extrainfo']);
        $this->writePOExtrainfo();

        //if (strtolower($poInfo['Supplier']['Supplier']['name']) !== 'revino')
        //$this->writeCustomerInfo($poInfo['Customer']);

        $this->writeSignature($poInfo['User']);
        $poId = $this->controller->getNextId();
        $this->setPoNum($poId);
        $fileName = $this->getFileName($poId);
        if ($fileName) {
            $objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel2007');
            $objWriter->save($this->PO_DIR . $fileName);
            return $fileName;
        }
        return false;
    }

    function generateQuote($quoteInfo) {
        $this->phpExcel = new PHPExcel();
        $this->phpExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $this->row = 1;
        $this->setPropertiesQuote();
        $this->setQuoteHeaderImage();
        $this->setQuoteHeaderTitle();
        //$this->setPhoneNumber();
        $this->setQuoteDocTitle();
        $this->setQuoteHeader($quoteInfo['Quote']);
        $this->setQuoteCustomer($quoteInfo['Customer']);
        $this->rnext(2);
        $this->writeQuoteItems($quoteInfo['Quote_items']);
        $this->writeQuoteSummary($quoteInfo['Quote_items'], $quoteInfo['Quote']['additional_disc'], $quoteInfo['Quote']['use_tax'], $quoteInfo['Quote']['biaya_kirim']);
        $this->writeQuoteExtrainfo($quoteInfo['Quote']['quote_term']);
        $this->writeQuoteBankinfo($quoteInfo['Quote']['bank_info']);
        $this->writeQuoteSignature();
        $this->setQuoteImage($quoteInfo['Quote_imgs']);
        $fileName = $this->getFileName($quoteInfo['Quote']['id'], str_replace('/', '-', $quoteInfo['Customer']['name']));
        if ($fileName) {
            $objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel2007');
            $objWriter->save($this->QUOTE_DIR . $fileName);
            return $fileName;
        }
        return false;
    }

    function generateInvoiceLunas($invoiceInfo) {
        $this->phpExcel = new PHPExcel();
        $this->phpExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $this->phpExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $this->phpExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $this->row = 1;
        $this->setPropertiesInvoice();
        $this->setInvoiceHeader();
        $this->setInvoiceDate();
        $this->setInvoiceID($invoiceInfo['invoiceID']);
        if ($invoiceInfo['jatuh_tempo'] != '')
            $this->setInvoiceDue($invoiceInfo['jatuh_tempo']);
        $this->setInvoiceCustomer($invoiceInfo['Customer']);
        $this->setInvoiceTableHeader();

        $totalBuy = $this->setInvoiceItemListLunas($invoiceInfo['SupplierName'], $invoiceInfo['Buy']);

        $this->setInvoiceAllPayments($invoiceInfo['Payment']); //DP
        $this->setInvoiceTotalItemLunas2($totalBuy); //total pembelian
        if ($invoiceInfo['paymentTerm'] == 'transferPT') {
            $this->setInvoiceTax($invoiceInfo['Buy']);
        }

        $totalBuy = $this->getTotalBuy($invoiceInfo['Buy']);
        $totalTax = $this->getTotalTax($invoiceInfo['paymentTerm'], $invoiceInfo['Buy']);
        $totalPayments = $this->getTotalPayments($invoiceInfo['Payment']);
        if ($invoiceInfo['Order']['dp_customer'] > 0) {
            $this->setInvoicePaymentFromTotalLunasDP($invoiceInfo['Order']['dp_customer']);
            $totalPayments+=$invoiceInfo['Order']['dp_customer'];
        }
        $this->setInvoiceShipping($invoiceInfo['totalShipping']);
        $this->setInvoiceTotalLunas($totalBuy + $totalTax + $invoiceInfo['totalShipping'] - $totalPayments);
        $this->setInvoicePayment($invoiceInfo['paymentTerm']);
        $this->rnext();
        $this->writeSignature($invoiceInfo['User']);
        $fileName = $invoiceInfo['invoiceID'];
        if ($fileName) {
            $objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel2007');
            $objWriter->save($this->INVOICE_DIR . $fileName);
            return $fileName;
        }
        return false;
    }

    function generateInvoice($invoiceInfo) {
        $this->phpExcel = new PHPExcel();
        $this->phpExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $this->phpExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $this->phpExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $this->row = 1;
        $this->setPropertiesInvoice();
        $this->setInvoiceHeader();
        $this->setInvoiceDate();
        $invoiceId = $this->controller->getNextId();
        $this->setInvoiceNumber($invoiceId);
        $this->setInvoiceCustomer($invoiceInfo['Customer']);
        $this->setInvoiceTableHeader();
#======================= START FROM HERE ==========================================
        $totalBuy = $this->setInvoiceItemListLunas($invoiceInfo['SupplierName'], $invoiceInfo['Buy']);
        $this->setInvoiceAllPayments2($invoiceInfo['Payment']);
        $this->setInvoiceTotalItemLunas2($totalBuy);
        if ($invoiceInfo['paymentTerm'] == 'transferPT') {
            $this->setInvoiceTax($invoiceInfo['Buy']);
        }
        $totalBuy = $this->getTotalBuy($invoiceInfo['Buy']);
        $totalTax = $this->getTotalTax($invoiceInfo['paymentTerm'], $invoiceInfo['Buy']);
        $totalPayments = $this->getTotalPayments($invoiceInfo['Payment']);
        $this->setInvoiceShipping2($this->Arr->get($invoiceInfo, 'totalShipping', 0));
        $this->setInvoiceTotalLunas2($totalBuy + $totalTax + $this->Arr->get($invoiceInfo, 'totalShipping', 0) - $totalPayments, $invoiceInfo['Order']['dp_customer']);
#======================= START FROM HERE ==========================================
        $this->setInvoicePaymentFromTotal2($invoiceInfo['Order']['dp_customer']);

//        if (isset($invoiceInfo['customItem']) && isset($invoiceInfo['customPrice'])) {
//            $this->setInvoiceCustomMessage($invoiceInfo['customItem'], $invoiceInfo['customPrice']);
//        } else {
//            $this->setInvoiceItemList($invoiceInfo['SupplierName'], $invoiceInfo['Buy']);
//        }
#======================= START FROM HERE ==========================================
        $this->setInvoicePayment($invoiceInfo['paymentTerm']);
        $this->rnext();
        $this->writeSignature($invoiceInfo['User']);
        $fileName = $this->getFileName($invoiceId);
        if ($fileName) {
            $objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel2007');
            $objWriter->save($this->INVOICE_DIR . $fileName);
            return $fileName;
        }
        return false;
    }

    function isValidPoInfo($poInfo) {
        return is_array($poInfo['Buy']) && is_array($poInfo['Customer']) && is_array($poInfo['Supplier']);
    }

    function isValidOutpaymentInfo($payInfo) {
        if (count($payInfo) < 1) {
            return false;
        }
        foreach ($payInfo as $p) {
            if (!isset($p['Po']) || !isset($p['os']) || !isset($p['sup'])) {
                return false;
            }
        }
        return true;
    }

    function setDocTitle() {
        $this->row = 2;
        $this->phpExcel->getActiveSheet()->mergeCells('F' . $this->row . ':I' . $this->row);
        $this->phpExcel->getActiveSheet()->getStyle('F' . $this->row)->getFont()->setSize(18);
        $this->phpExcel->getActiveSheet()->getStyle('F' . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle('F' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->phpExcel->getActiveSheet()->getStyle('F' . $this->row . ':I' . $this->row)->applyFromArray(array(
            'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THICK))
        ));

        $this->phpExcel->getActiveSheet()->setCellValue('F' . $this->row, 'PURCHASE ORDER');
    }

    function setQuoteDocTitle() {
        $this->row = 8;
        $this->phpExcel->getActiveSheet()->mergeCells('A' . $this->row . ':I' . $this->row);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(16);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'PENAWARAN HARGA');
    }

    function writePOInfo(array $orderTo, array $shipTo) {
        $this->row = 5;
        $this->phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(2);
        $supp = $orderTo['Supplier'];
        $this->phpExcel->getActiveSheet()->mergeCells('A5:D5');

        $this->phpExcel->getActiveSheet()->getStyle('A5:A10')->applyFromArray(array(
            'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray(array(
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('A10:D10')->applyFromArray(array(
            'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('D5:D10')->applyFromArray(array(
            'borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        //$this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(12);
        $this->phpExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->setCellValue('A5', 'ORDER KEPADA');
        $this->phpExcel->getActiveSheet()->setCellValue('A6', 'Nama: ' . $supp['name']);
        $this->phpExcel->getActiveSheet()->setCellValue('A7', 'Fax: ' . $supp['fax']);

        if (isset($supplier['Salesman']) && isset($supplier['Salesman'][0])) {
            $this->phpExcel->getActiveSheet()->setCellValue('A8', 'Attn: ' . $supplier['Salesman']['name']);
        }

        //ShipTo
        $this->phpExcel->getActiveSheet()->mergeCells('F5:I5');

        $this->phpExcel->getActiveSheet()->getStyle('F5:F10')->applyFromArray(array(
            'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('F5:I6')->applyFromArray(array(
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('F10:I10')->applyFromArray(array(
            'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('I5:I10')->applyFromArray(array(
            'borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        //$this->phpExcel->getActiveSheet()->getStyle('F' . $this->row)->getFont()->setSize(12);
        $this->phpExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->setCellValue('F5', 'KIRIM KEPADA ');
        $this->phpExcel->getActiveSheet()->setCellValue('F6', 'Nama: ' . $shipTo['name']);

        $ship_address = str_split($shipTo['address'], 43);
        $address_line = count($ship_address);

        if (isset($shipTo['company'])) {
            $this->phpExcel->getActiveSheet()->setCellValue('F7', 'Perusahaan: ' . $shipTo['company']);

            $row = 8;
            $this->phpExcel->getActiveSheet()->setCellValue('F8', 'Alamat: ' . $ship_address[0]);
        } else {
            $row = 7;
            $this->phpExcel->getActiveSheet()->setCellValue('F' . $row, 'Alamat: ' . $ship_address[0]);
        }

        for ($iloop = 1; $iloop <= $address_line; $iloop++) {
            $row++;
            $this->phpExcel->getActiveSheet()->setCellValue('F' . $row, '        ' . $ship_address[$iloop]);
        }

        $this->phpExcel->getActiveSheet()->setCellValue('F10', 'Phone: ' . $shipTo['phone']);

        $this->row = 11;
    }

    function writeSupplier($supplier) {
        $supp = $supplier['Supplier'];
        $this->phpExcel->getActiveSheet()->setCellValue('A12', date('j F Y'));
        $this->phpExcel->getActiveSheet()->setCellValue('A13', 'Kepada:' . $supp['name']);
        if (isset($supplier['Salesman']) && isset($supplier['Salesman'][0])) {
            $this->phpExcel->getActiveSheet()->setCellValue('A14', $supplier['Salesman'][0]['name']);
        }
        $this->phpExcel->getActiveSheet()->setCellValue('A15', 'Fax: ' . $supp['fax']);
    }

    function writeItems($buys, $sname) {
        $this->rnext();

        $border_style = array('borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
        )));

        $this->columnStyle('NO', 'A', $this->row, PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->phpExcel->getActiveSheet()->mergeCells('B' . $this->row . ':G' . $this->row);

        $this->columnStyle('NAMA PRODUK', 'B', $this->row);

        $this->phpExcel->getActiveSheet()->getStyle('B12:G12')->applyFromArray(array(
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->columnStyle('QTY', 'H', $this->row);

        $this->columnStyle('UNIT PRICE', 'I', $this->row);
        $this->setPOItemList($buys, $sname);
    }

    protected function columnStyle($title, $col, $row, $alignment = PHPExcel_Style_Alignment::HORIZONTAL_CENTER) {
        $border_style = array('borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
        )));

        $this->phpExcel->getActiveSheet()->getStyle($col . $row)->applyFromArray($border_style);
        $this->phpExcel->getActiveSheet()->getStyle($col . $row)
                ->getAlignment()->setHorizontal($alignment);

        //$this->phpExcel->getActiveSheet()->getStyle($col . $row)->getFont()->setSize(12);
        $this->phpExcel->getActiveSheet()->getStyle($col . $row)->getFont()->setBold(True);
        $this->phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $this->phpExcel->getActiveSheet()->setCellValue($col . $row, $title);
    }

    function writeQuoteItems($buys) {
        //$this->phpExcel->getActiveSheet()->setCellValue('A17', 'Pesanan:');
        $this->row = 17;
        $this->setQuoteTableHeader();
        $this->setQuoteItemList($buys);
    }

    function writeShipping($shipping) {
        $this->rnext();

        $this->writePOItemCol(0, '');
        $this->writePOItemCol(1, 'Biaya Pengiriman');
        $this->writePOItemCol(2, '');
        if ($shipping) {
            $shippingCost = $shipping['buy_price'];
        } else {
            $shippingCost = 0;
        }
        $this->writePOItemCol(3, 'Rp ' . number_format($shippingCost), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
    }

    function writeExtrainfo($extrainfo) {
        $this->rnext();
        if (!empty($extrainfo)) {
            $lines = explode("\n", $extrainfo);
            foreach ($lines as $line) {
                $this->row++;
                if (strpos($line, 'PPN') !== false) {
                    $styleArray = array('font' => array('italic' => true, 'bold' => true, 'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE));
                    $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->applyFromArray($styleArray);
                    $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(11);
                    $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $line);
                } else {
                    $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setBold(true);
                    $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $line);
                }
            }
            $this->rnext();
        }
    }

    function writePOExtrainfo() {
        $this->rnext();
        //$this->rnext();

        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setBold(true)->setSize(12);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "INFO");
        $this->rnext();

        $tmp = $this->row + 5;
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':I' . $tmp)->applyFromArray(array(
            'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':I' . $this->row)->applyFromArray(array(
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('A' . $tmp . ':I' . $tmp)->applyFromArray(array(
            'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':I' . $tmp)->applyFromArray(array(
            'borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "1. Harap pricelist diperiksa.");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "2. Pricelist dianggap benar apabila pabrik mengirimkan barang sesuai PO ini.");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "3. Pihak BeliFurniture.com tidak bertanggung jawab atas kesalahan harga");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "setelah PO ini diproses oleh pabrik.");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "4. Invoice yang akan dibayar ke pihak pabrik harus mengacu pada PO ini.");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "5. Mohon agar barang pengiriman selalu menggunakan sepatu ketika mengirimkan barang.");
    }

    function writeWarninginfo() {
        $this->rnext();
        $this->rnext();

        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setBold(true)->setSize(13);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "INFO");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "1. Harap pricelist diperiksa.");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "2. Pricelist dianggap benar apabila pabrik mengirimkan barang sesuai PO ini.");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "3. Pihak BeliFurniture.com tidak bertanggung jawab atas kesalahan harga");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "4. setelah PO ini diproses oleh pabrik.");
        $this->rnext();

        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "5. Invoice yang akan dibayar ke pihak pabrik harus mengacu pada PO ini.");
    }

    function writeQuoteExtrainfo($extrainfo) {
        $this->rnext(2);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Persyaratan:');

        if (!empty($extrainfo)) {
            $lines = explode("\n", $extrainfo);
            //unset($lines[ count($lines) - 1 ]);

            $i = 1;

            foreach ($lines as $line) {
                $this->row++;
                $this->phpExcel->getActiveSheet()->mergeCells('B' . $this->row . ':I' . $this->row);
                //$this->phpExcel->getActiveSheet()->getStyle('B' . $this->row)->getAlignment()->setWrapText(true);
                $this->phpExcel->getActiveSheet()->getRowDimension($this->row)->setRowHeight(-1);
                if (strpos($line, '(persetujuan') !== false) {
                    $this->phpExcel->getActiveSheet()->setCellValue('B' . $this->row, rtrim($line));
                    $this->phpExcel->getActiveSheet()->getStyle('B' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $this->rnext();
                    continue;
                }
                if (strpos($line, "Acc:") !== false) {
                    $this->rnext();
                    $linep = explode("Acc:", $line);
                    if (count($linep) >= 2) {
                        $this->phpExcel->getActiveSheet()->setCellValue('B' . $this->row, $linep[0]);
                        $this->phpExcel->getActiveSheet()->getStyle('B' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $this->rnext();
                        $this->phpExcel->getActiveSheet()->setCellValue('B' . $this->row, '     Acc:' . $linep[1]);
                        $this->phpExcel->getActiveSheet()->getStyle('B' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    }
                } else {
                    $this->phpExcel->getActiveSheet()->setCellValue('B' . $this->row, $i . '.' . rtrim($line));
                    $this->phpExcel->getActiveSheet()->getStyle('B' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                }
                $i++;
            }
        }
    }

    function writeQuoteBankinfo($extrainfo) {
//$this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Persyaratan:');
        if (!empty($extrainfo)) {
            $lines = explode("\n", $extrainfo);
            foreach ($lines as $line) {
                $this->row++;
                $this->phpExcel->getActiveSheet()->mergeCells('B' . $this->row . ':I' . $this->row);
//$this->phpExcel->getActiveSheet()->getStyle('B' . $this->row)->getAlignment()->setWrapText(true);
                $this->phpExcel->getActiveSheet()->getRowDimension($this->row)->setRowHeight(-1);
//$this->rnext();
                $linep = explode("Acc:", $line);
                if (count($linep) >= 2) {
                    $this->phpExcel->getActiveSheet()->setCellValue('B' . $this->row, $linep[0]);
                    $this->phpExcel->getActiveSheet()->getStyle('B' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $this->rnext();
                    $this->phpExcel->getActiveSheet()->setCellValue('B' . $this->row, '     Acc:' . $linep[1]);
                    $this->phpExcel->getActiveSheet()->getStyle('B' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                }
            }
        }
    }

    function writeCustomerInfo($customer) {
        $this->rnext(3);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Barang harap dikirim ke:');
        $this->rnext();
        $this->rnext();
        $name = $customer['name'];
        if (isset($customer['company'])) {
            $name .= ' (Company: ' . $customer['company'] . ')';
        }
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $name);
        $this->rnext();
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $customer['address']);
        $this->rnext();
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $customer['city']);
        $this->rnext();
        $this->rnext();
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Untuk informasi alamat hubungi 021-32133195 (BeliFurniture)');
        $this->rnext();
    }

    function writeSignature($user = false) {
        $this->rnext(2);
        $first_row = $this->row;

        $name = '';
        if ($user) {
            $name = $user['username'];
            if (isset($name)) {
                $this->phpExcel->getActiveSheet()->mergeCells('A' . $this->row . ':B' . $this->row);
                $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Dibuat Oleh : ');

                $this->rnext(5);
                $this->phpExcel->getActiveSheet()->mergeCells('A' . $this->row . ':B' . $this->row);
                $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, ucfirst($name));

                $this->rnext();
                $this->phpExcel->getActiveSheet()->mergeCells('A' . $this->row . ':B' . $this->row);
                $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Sales');
            }
        }

        $this->phpExcel->getActiveSheet()->mergeCells('D' . $first_row . ':F' . $first_row);
        $this->phpExcel->getActiveSheet()->getStyle('D' . $first_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->phpExcel->getActiveSheet()->setCellValue('D' . $first_row, 'Disetujui Oleh : ');

        $tmp = $first_row + 5;
        $this->phpExcel->getActiveSheet()->mergeCells('D' . $tmp . ':F' . $tmp);
        $this->phpExcel->getActiveSheet()->getStyle('D' . $tmp)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->phpExcel->getActiveSheet()->setCellValue('D' . $tmp, 'Bertha');

        $tmp = $first_row + 6;
        $this->phpExcel->getActiveSheet()->mergeCells('D' . $tmp . ':F' . $tmp);
        $this->phpExcel->getActiveSheet()->getStyle('D' . $tmp)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->phpExcel->getActiveSheet()->setCellValue('D' . $tmp, 'Asisten Manager');

        $this->phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(3);
        $this->phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

        //bordering
        $this->phpExcel->getActiveSheet()->getStyle('A' . $first_row . ':B' . $tmp)->applyFromArray(array(
            'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));
        $this->phpExcel->getActiveSheet()->getStyle('D' . $first_row . ':F' . $tmp)->applyFromArray(array(
            'borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('A' . $first_row . ':B' . $first_row)->applyFromArray(array(
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));
        $this->phpExcel->getActiveSheet()->getStyle('D' . $first_row . ':F' . $first_row)->applyFromArray(array(
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('A' . $tmp . ':B' . $tmp)->applyFromArray(array(
            'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));
        $this->phpExcel->getActiveSheet()->getStyle('D' . $tmp . ':F' . $tmp)->applyFromArray(array(
            'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $this->phpExcel->getActiveSheet()->getStyle('A' . $first_row . ':B' . $tmp)->applyFromArray(array(
            'borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));
        $this->phpExcel->getActiveSheet()->getStyle('D' . $first_row . ':F' . $tmp)->applyFromArray(array(
            'borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN))
        ));

        $tmp = $tmp + 2;
        $this->phpExcel->getActiveSheet()->getStyle('A' . $tmp)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $tmp, 'Untuk Keluhan dan saran silahkan email ke direksi@belifurniture.com');
    }

    function writeQuoteSignature($user = false) {
        $this->rnext(2);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Diterima Oleh,');
        $this->rnext(5);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Nama :');
        $this->rnext();
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'Jabatan :');
    }

    function rnext($step = 1) {
        $this->row += $step;
    }

    function setPropertiesPO() {
        $userName = $this->UserAuth->user('username');
        $this->phpExcel->getProperties()->setCreator($userName)
                ->setLastModifiedBy($userName)
                ->setTitle("PO Pinera Home Office")
                ->setSubject("PO Pinera Home Office")
                ->setDescription("Pinera Purchase Order generated using PHP classes.")
                ->setKeywords("office 2007 openxml PO php")
                ->setCategory("Pinera PO file");
    }

    function setPropertiesQuote() {
        $userName = $this->UserAuth->user('username');
        $this->phpExcel->getProperties()->setCreator($userName)
                ->setLastModifiedBy($userName)
                ->setTitle("Quote Pinera Home Office")
                ->setSubject("Quote Pinera Home Office")
                ->setDescription("Pinera Quote generated using PHP classes.")
                ->setKeywords("office 2007 openxml Quote php")
                ->setCategory("Pinera Quote file");
    }

    function setPropertiesInvoice() {
        $userName = $this->UserAuth->user('username');
        $this->phpExcel->getProperties()->setCreator($userName)
                ->setLastModifiedBy($userName)
                ->setTitle("Invoice Pinera Home Office")
                ->setSubject("Invoice Pinera Home Office")
                ->setDescription("Pinera Invoice Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php pinera invoice")
                ->setCategory("Pinera invoice file");
    }

    function setHeaderImage() {
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Belifurniture.com Logo');
        $objDrawing->setPath($this->IMG_DIR . 'belifurniturelogo.png');
        $objDrawing->setOffsetY(10);
        $objDrawing->setHeight(35);
        $objDrawing->setWorksheet($this->phpExcel->getActiveSheet());
    }

    function setQuoteHeaderImage() {
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Belifurniture.com Logo');
        $objDrawing->setPath($this->IMG_DIR . 'belifurniturelogo-big.png');
        $objDrawing->setHeight(100);
        $objDrawing->setWidth(300);
        $objDrawing->setOffsetX(10);
        $objDrawing->setOffsetY(35);
        $objDrawing->setWorksheet($this->phpExcel->getActiveSheet());
    }

    function setQuoteHeaderTitle() {
        $this->row = 2;
        $this->phpExcel->getActiveSheet()->getStyle('F' . $this->row)->getFont()->setSize(14)->setBold(true);
        $this->phpExcel->getActiveSheet()->mergeCells('F' . $this->row . ':I' . $this->row);
        $this->phpExcel->getActiveSheet()->getStyle('F' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->setCellValue('F' . $this->row, "PT Tricipta Media Perkasa");
        $this->row = 3;
        $this->phpExcel->getActiveSheet()->mergeCells('F' . $this->row . ':I' . $this->row);
        $this->phpExcel->getActiveSheet()->getStyle('F' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->setCellValue('F' . $this->row, "Jl.Taman Permata no 226 Ruko New Asia");
        $this->row = 4;
        $this->phpExcel->getActiveSheet()->mergeCells('F' . $this->row . ':I' . $this->row);
        $this->phpExcel->getActiveSheet()->getStyle('F' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->setCellValue('F' . $this->row, "Lippo Karawaci,Tangerang 15810");
        $phoneNumber = '021-5949 2244';
        $faxNumber = '021-598 7620';
        $this->row = 5;
        $this->phpExcel->getActiveSheet()->mergeCells('F' . $this->row . ':I' . $this->row);
        $this->phpExcel->getActiveSheet()->getStyle('F' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->setCellValue('F' . $this->row, 'P:' . $phoneNumber . ' | F:' . $faxNumber);
        $border_style = array('borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FFaaaaaa'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':I' . $this->row)->
                applyFromArray($border_style);
    }

    function setPhoneNumber() {
        $phoneNumber = '021-5949 2244';
        $faxNumber = '021-598 7620';
        $this->row = 3;
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, 'P:' . $phoneNumber . ' | F:' . $faxNumber);
        $this->phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    }

    function setInvoiceHeader() {
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Belifurniture.com Logo');
        $objDrawing->setPath($this->IMG_DIR . 'belifurniturelogo.png');
        $objDrawing->setHeight(59);
        $objDrawing->setWorksheet($this->phpExcel->getActiveSheet());
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setSize(12);
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->setCellValue($this->END_COLUMN . $this->row, 'PT Tricipta Media Perkasa');
        $this->phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $this->phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $this->writeInvoiceAddress('Jl. Taman Permata 226, Ruko New Asia');
        $this->writeInvoiceAddress('Lippo Karawaci, Tangerang 15810');
        $this->writeInvoiceAddress('p. (021) 59492244 f. (021) 5987620');
        $border_style = array('borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FFaaaaaa'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':' . $this->END_COLUMN . $this->row)->
                applyFromArray($border_style);
    }

    private function writeInvoiceAddress($content) {
        $this->rnext();
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setSize(10);
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->getColor()->setARGB('FF666666');
        $this->phpExcel->getActiveSheet()->setCellValue($this->END_COLUMN . $this->row, $content);
    }

    function setInvoiceDate() {
        $this->rnext(2);
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($this->END_COLUMN . $this->row, date('j F Y'));
    }

    function setInvoiceID($invoiceID) {
        $this->rnext(2);
        $realID = str_replace('.xlsx', '', $invoiceID);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $invoiceNum = 'INVOICE No: INV-' . $realID;
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $invoiceNum);
    }

    function setInvoiceNumber($invoiceId) {
        $this->rnext(2);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $invoiceNum = 'INVOICE No: INV-' . $invoiceId . '-' . date('F') . '-' . date('Y');
        $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $invoiceNum);
    }

    function setInvoiceDue($content) {
        if (!empty($content)) {
            $this->rnext();
            $this->phpExcel->getActiveSheet()->mergeCells('A' . $this->row . ':I' . $this->row);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(11);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->getColor()->setARGB('FF000000');
            $cx = "JATUH TEMPO: " . $content;
            $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $cx);
        }
    }

    function setInvoiceCustomer($customer) {
        $this->rnext();
        $this->writeInvoiceCustomerInfo('Kepada Yth,');
        $this->writeInvoiceCustomerInfo($customer['name']);
        $this->writeInvoiceCustomerInfo($customer['company']);
        $this->writeInvoiceCustomerInfo($customer['address']);
        $this->writeInvoiceCustomerInfo($customer['city']);
    }

    function setQuoteCustomer($customer) {
        $this->rnext();
        $this->writeInvoiceCustomerInfo('Kepada Yth,');
        $this->writeInvoiceCustomerInfo($customer['name']);
        if ($customer['phone'] != '-')
            $this->writeInvoiceCustomerInfo($customer['phone']);
        $this->writeInvoiceCustomerInfo($customer['company']);
        $this->writeInvoiceCustomerInfo($customer['address']);
        $this->writeInvoiceCustomerInfo($customer['city']);
        $this->rnext();
    }

    function setQuoteHeader($info) {
        $this->rnext();
        $tanggal = date("d/m/Y", strtotime($info['quote_date']));
        $this->writeQuoteInfo('Tanggal', $tanggal);
        $this->writeQuoteInfo('NO', $info['quote_no']);
    }

    private function writeInvoiceCustomerInfo($content) {
        if (!empty($content)) {
            $this->rnext();
            $this->phpExcel->getActiveSheet()->mergeCells('A' . $this->row . ':I' . $this->row);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(11);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->getColor()->setARGB('FF000000');
            $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $content);
        }
    }

    private function writeDownPayment($content) {
        if (!empty($content)) {
            $this->rnext(2);
            $this->phpExcel->getActiveSheet()->mergeCells('A' . $this->row . ':H' . $this->row);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(12);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setBold(true);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->getColor()->setARGB('FF000000');
            $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, "Down Payment");
            $this->phpExcel->getActiveSheet()->mergeCells('I' . $this->row . ':J' . $this->row);
            $this->phpExcel->getActiveSheet()->getStyle('I' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setBold(true);
            $this->phpExcel->getActiveSheet()->setCellValue('I' . $this->row, "Rp " . number_format($content));
        }
    }

    private function writeQuoteInfo($a, $content) {
        if (!empty($content)) {
            $this->rnext();
            $this->phpExcel->getActiveSheet()->mergeCells('A' . $this->row . ':B' . $this->row);
            $this->phpExcel->getActiveSheet()->mergeCells('C' . $this->row . ':I' . $this->row);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->setSize(11);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row)->getFont()->getColor()->setARGB('FF000000');
            $this->phpExcel->getActiveSheet()->setCellValue('A' . $this->row, $a);
            $this->phpExcel->getActiveSheet()->setCellValue('C' . $this->row, ": " . $content);
        }
    }

    private function setInvoiceTableHeader() {
        $this->rnext(3);
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->setCellValue('E' . $this->row, 'INVOICE');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':' . $this->END_COLUMN . $this->row)->
                applyFromArray($border_style);
        $this->rnext();
        $headers = array('No', 'ITEM', 'Qty', 'Harga (Rp)');
        for ($i = 0; $i < 4; $i++) {
            $this->phpExcel->getActiveSheet()->getStyle($this->invCol($i, $this->row, true))->
                    applyFromArray($border_style);
            $invCol = $this->invCol($i, $this->row, false);
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setBold(true);
            $this->phpExcel->getActiveSheet()->setCellValue($invCol, $headers[$i]);
        }
    }

    private function setPOTableHeader() {
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->setCellValue('E' . $this->row, 'Purchase Order (Mohon pricelist di check)');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':' . $this->END_COLUMN . $this->row)->
                applyFromArray($border_style);
        $this->rnext();
        $headers = array('No', 'ITEM', 'Qty', 'Pricelist / Unit');
        for ($i = 0; $i < count($headers); $i++) {
            $this->phpExcel->getActiveSheet()->getStyle($this->invCol($i, $this->row, true))->
                    applyFromArray($border_style);
            $invCol = $this->invCol($i, $this->row, false);
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setBold(true);
            $this->phpExcel->getActiveSheet()->setCellValue($invCol, $headers[$i]);
        }
    }

    private function setQuoteTableHeader() {
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->rnext();
        $headers = array('No', 'Jenis Barang', 'Item', 'Qty', 'Harga Satuan', 'Subtotal(Rp)', 'Disc(%)', "Total(Rp)");
        $sheet = $this->phpExcel->getActiveSheet();
        for ($i = 0; $i < count($headers); $i++) {
            $col = $this->quoteCol($i, $this->row, true);

            $sheet->getStyle($col)->
                    applyFromArray($border_style);
            $invCol = $this->quoteCol($i, $this->row, false);
            $sheet->getStyle($invCol)->getFont()->setSize(11);
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);

            $sheet->getStyle($invCol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
            $sheet->getStyle($invCol)->getFont()->setBold(true);
            $sheet->setCellValue($invCol, $headers[$i]);
        }
    }

    private function setOutpaymentTableHeader() {
        $this->rnext(3);
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->getStyle('E' . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->setCellValue('E' . $this->row, 'PAYMENT COMBINE');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':' . $this->END_COLUMN . $this->row)->
                applyFromArray($border_style);
        $this->rnext();
        $headers = array('INVOICE DARI PABRIK', 'PO PINERA', 'NOMINAL (Rp)');
        for ($i = 0; $i < 3; $i++) {
            $this->phpExcel->getActiveSheet()->getStyle($this->outpayCol($i, $this->row, true))->
                    applyFromArray($border_style);
            $invCol = $this->outpayCol($i, $this->row, false);
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
            $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setBold(true);
            $this->phpExcel->getActiveSheet()->setCellValue($invCol, $headers[$i]);
        }
    }

    private function outpayCol($num, $row, $whole = false) {
        $colString = '';
        switch ($num) {
            case 0: $colString = 'A' . $row;
                if ($whole)
                    $colString .= ':C' . $row;
                break;
            case 1: $colString = 'D' . $row;
                if ($whole)
                    $colString .= ':G' . $row;
                break;
            case 2: $colString = 'H' . $row;
                if ($whole)
                    $colString .= ':J' . $row;
                break;
            case 3: $colString = 'K' . $row;
                if ($whole)
                    $colString .= ':' . $this->END_COLUMN . $row;
                break;
        }
        return $colString;
    }

    private function invCol($num, $row, $whole = false) {
        $colString = '';
        switch ($num) {
            case 0: $colString = 'A' . $row;
                break;
            case 1: $colString = 'B' . $row;
                if ($whole)
                    $colString .= ':G' . $row;
                break;
            case 2: $colString = 'H' . $row;
                break;
            case 3: $colString = 'I' . $row;
                if ($whole)
                    $colString .= ':' . $this->END_COLUMN . $row;
                break;
        }
        return $colString;
    }

    //Purchse Order Column
    private function poCol($num, $row, $whole = false) {
        $colString = '';
        switch ($num) {
            case 0: $colString = 'A' . $row;
                break;
            case 1: $colString = 'B' . $row;
                if ($whole)
                    $colString .= ':G' . $row;
                break;
            case 2: $colString = 'H' . $row;
                break;
            case 3: $colString = 'I' . $row;
                //if ($whole)
                //$colString .= ':' . $this->END_COLUMN . $row;
                break;
        }
        return $colString;
    }

    private function quoteCol($num, $row, $whole = false) {
        $colString = '';
        switch ($num) {
            case 0: $colString = 'A' . $row;
                break;
            case 1: $colString = 'B' . $row;
                break;
            case 2: $colString = 'C' . $row;
                if ($whole)
                    $colString .= ':D' . $row;
                break;
            case 3: $colString = 'E' . $row;
                break;
            case 4: $colString = 'F' . $row;
                break;
            case 5: $colString = 'G' . $row;
                break;
            case 6: $colString = 'H' . $row;
                break;
            case 7: $colString = 'I' . $row;
                if ($whole)
                    $colString = 'I' . $row;
//$colString .= ':' . $this->END_COLUMN . $row;
                break;
        }
        return $colString;
    }

    function setInvoiceCustomMessage($message, $price) {
        $totalBuy = $price;
// Print custom message to invoice
        $count = 1;
        $this->rnext();
        $this->writeItemCol(0, $count);
        $this->writeItemCol(1, $message);
        $this->writeItemCol(2, 1);
        $this->writeItemCol(3, number_format($price));

        $this->setInvoiceTotal($totalBuy);
    }

    function getTotalBuy($items) {
        $totalBuy = 0.0;
// Count the total sell price
        for ($i = 0; $i < count($items); $i++) {
            $sellPrice = $items[$i]['sell_price'];
            $quantity = $items[$i]['qty'];
            $totalBuy += $quantity * $sellPrice;
            ;
        }
        return $totalBuy;
    }

    function getTotalTax($paymentTerms, $buys) {
        if ($paymentTerms === 'transferPT') {
            return 0.1 * $this->getTotalBuy($buys);
        } else {
            return 0.0;
        }
    }

    function setInvoiceItemList($supplier, $items) {
        $totalBuy = 0.0;
// Count the total sell price
        for ($i = 0; $i < count($items); $i++) {
            $sellPrice = $items[$i]['sell_price'];
            $quantity = $items[$i]['qty'];
            $items[$i]['total_sell_price'] = $quantity * $sellPrice;
            $totalBuy += $items[$i]['total_sell_price'];
        }
        $this->writeDownPayment($totalBuy);
#$this->setInvoiceTotal($totalBuy);
    }

    function setPOItemList($items, $sname) {
        // Printing list price to invoice
        $count = 1;
        foreach ($items as $item) {
            $this->rnext();
            $this->writePOItemCol(0, $count);
            $fullItemName = $item['name'] . ' (' . $item['bahan'] . ')';
            $this->writePOItemCol(1, $fullItemName);
            $this->writePOItemCol(2, $item['qty'], PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            if ($item['list_price'] > 0 && $sname != 'revino' && strpos(strtolower($item['name']), 'revino') !== 0) {
                $this->writePOItemCol(3, 'Rp ' . number_format($item['list_price']), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
            } else {
                $this->writePOItemCol(3, '-', PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
            }
            $count++;
        }
    }

    function setQuoteItemList($items) {
        //Printing list price to invoice
        $count = 1;
        foreach ($items as $item) {
            $this->rnext();
            $supplier_name = isset($item['supplier_name']) ? $item['supplier_name'] : '';
            $this->writeQuoteItemCol(0, $count);
            $this->writeQuoteItemCol(1, $item['bahan']);  //item
            $this->writeQuoteItemCol(2, $supplier_name . ' ' . $item['item']);  //item
            $this->writeQuoteItemCol(3, $item['qty'], PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //qty
            $this->writeQuoteItemCol(4, $item['price'], PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); //harga satuan
            $this->writeQuoteItemCol(5, ($item['qty'] * $item['price']), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); //subtotal
            $this->writeQuoteItemCol(6, $this->calculateTotalDiscount($item['disc']) . '%', PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); //diskon %
            $total = ($item['qty'] * $item['price']) - ($item['qty'] * $item['price'] * $this->calculateTotalDiscount($item['disc']) / 100);  //TOTAL COUNT
            $this->writeQuoteItemCol(7, $total, PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, "I");
            //writeQuoteItemCol($colNum, $content, $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT, $customCol = null)
            $count++;
        }
    }

    function setQuoteImage($imgs) {

        $o = 0;
        $data = array_chunk($imgs, 4);
        $off = array("B", "D", "G", "I");
        foreach ($data as $d) {
            if ($o <= 3) {
                $i = 0;
                foreach ($d as $img) {
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setPath($this->QUOTE_DIR_IMG . '/' . $img['src']);
                    $objDrawing->setName("cell :" . $off[$o]);
                    $objDrawing->setHeight(100);
                    $objDrawing->setOffsetX(0);
                    $objDrawing->setCoordinates("" . $off[$o] . "" . (45 + $i));
                    $objDrawing->setWorksheet(
                            $this->phpExcel->getActiveSheet()->setCellValue("" . $off[$o] . "" . (45 + $i + 6), $img['nama'])
                    );
                    $i+=10;
                }
                $o++;
            }
        }
    }

    function WriteSumQuoteItemList($items) {
// Printing list price to invoice
        $count = 1;
        foreach ($items as $item) {
            $this->rnext();
            $this->writeQuoteItemCol(0, $count);
            $this->writeQuoteItemCol(1, $item['item']);  //item
            $this->writeQuoteItemCol(2, $item['qty'], PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //qty
            $this->writeQuoteItemCol(3, number_format($item['price']), PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //harga satuan
            $this->writeQuoteItemCol(4, number_format($item['qty'] * $item['price']), PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //subtotal
            $this->writeQuoteItemCol(5, $item['disc'] . '%', PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //diskon %
            $total = ($item['qty'] * $item['price']) - ($item['qty'] * $item['price'] * $item['disc'] / 100);  //TOTAL COUNT
            $this->writeQuoteItemCol(6, number_format($total), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
            $count++;
        }
    }

    function setOutpaymentList($items) {
        $totalOutpayment = 0.0;
        foreach ($items as $item) {
            $totalOutpayment += ($item['os']['buy_price'] - $item['os']['dp']);
        }

// Printing items
        $count = 1;
        foreach ($items as $item) {
            $this->rnext();
            $this->writeOutpayCol(0, $item['Po']['supplier_invoice']);
            $this->writeOutpayCol(1, str_replace('.xlsx', '', $item['Po']['path']));
            $this->writeOutpayCol(2, ($item['os']['buy_price'] - $item['os']['dp']), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
            $count++;
        }
        $this->setOutpaymentTotal($totalOutpayment);
    }

    function setInvoiceItemListLunas($supplier, $items) {
        $totalBuy = 0.0;
// Count the total sell price
        for ($i = 0; $i < count($items); $i++) {
            $sellPrice = $items[$i]['sell_price'];
            $quantity = $items[$i]['qty'];
            $items[$i]['total_sell_price'] = $quantity * $sellPrice;
            $totalBuy += $items[$i]['total_sell_price'];
        }

// Printing sell price to invoice
        $count = 1;
        foreach ($items as $item) {
            $this->rnext();
            $this->writeItemCol(0, $count);
            $fullItemName = $this->filterSupplier(($supplier[$item['supplier_id']] == "BFS" ? '' : $supplier[$item['supplier_id']])) . ' ' . str_replace(',', '-', str_replace('(BeliFurniture)', '', $item['name'])) . ' (' . $item['bahan'] . ')';
            $this->writeItemCol(1, $fullItemName);
            $this->writeItemCol(2, $item['qty'], PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->writeItemCol(3, number_format($item['total_sell_price']), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
            $count++;
        }

        return $totalBuy;
    }

    function setInvoiceAllPayments($payments) {
        $counter = 1;
        foreach ($payments as $payment) {
            $this->setInvoicePaymentFromTotal('DP#' . $counter, $payment['amount']);
            $counter++;
        }
    }

    function setInvoiceAllPayments2($payments) {
        $counter = 1;
        foreach ($payments as $payment) {
            $this->setInvoicePaymentFromTotal2('DP#' . $counter, $payment['amount']);
            $counter++;
        }
    }

    function getTotalPayments($payments) {
        $totalPayments = 0.0;
        foreach ($payments as $payment) {
            $totalPayments += $payment['amount'];
        }
        return $totalPayments;
    }

    function setOutpaymentTotal($totalBuy) {
        $this->rnext();
        $this->writeOutpayCol(0, '');
        $invCol = $this->outpayCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($invCol, 'Total');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':G' . $this->row)->applyFromArray($border_style);
        $this->writeOutpayCol(2, number_format($totalBuy, 2, ',', '.'), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->outpayCol(2, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->getStartColor()->setARGB('FFdddddd');
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setBold(true);
        $double_top = array('borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':' . $this->END_COLUMN . $this->row)->
                applyFromArray($double_top);
    }

    function setInvoiceTotal($totalBuy) {
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($invCol, 'Total');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':H' . $this->row)->
                applyFromArray($border_style);
        $this->writeItemCol(3, 'Rp ' . number_format($totalBuy), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        ;
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->getStartColor()->setARGB('FFdddddd');
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setBold(true);

        $double_top = array('borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':' . $this->END_COLUMN . $this->row)->
                applyFromArray($double_top);
    }

    function setInvoiceTotalItemLunas($totalBuy) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'Total Pembelian');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->
                applyFromArray($border_style);
        $this->writeItemCol(3, 'Rp ' . number_format($totalBuy), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        ;
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->getStartColor()->setARGB('FFdddddd');
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setBold(true);
    }

    function setInvoiceTotalItemLunas2($totalBuy) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'Total Pembelian');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->
                applyFromArray($border_style);
        $this->writeItemCol(3, 'Rp ' . number_format($totalBuy), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        ;
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->getStartColor()->setARGB('FFdddddd');
//$this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setBold(true);
    }

    function setInvoiceShipping($totalShipping) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'Total Pengiriman');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->
                applyFromArray($border_style);
        $this->writeItemCol(3, 'Rp ' . number_format($totalShipping), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        ;
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->getStartColor()->setARGB('FFdddddd');
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setBold(true);
    }

    function setInvoiceShipping2($totalShipping) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'Total Pengiriman');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->
                applyFromArray($border_style);
        $this->writeItemCol(3, 'Rp ' . number_format($totalShipping), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        ;
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->getStartColor()->setARGB('FFdddddd');
//$this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setBold(true);
    }

    function setInvoiceTotalLunas($totalLunas) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'Grand Total');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->
                applyFromArray($border_style);
        $this->writeItemCol(3, 'Rp ' . number_format($totalLunas), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        ;
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->getStartColor()->setARGB('FFdddddd');
        $this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setBold(true);

        $double_top = array('borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':' . $this->END_COLUMN . $this->row)->
                applyFromArray($double_top);
    }

    function setInvoiceTotalLunas2($totalLunas) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
//$this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'Grand Total');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->
                applyFromArray($border_style);
        $this->writeItemCol(3, 'Rp ' . number_format($totalLunas), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        ;
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->getStartColor()->setARGB('FFdddddd');
//$this->phpExcel->getActiveSheet()->getStyle($this->END_COLUMN . $this->row)->getFont()->setBold(true);

        $double_top = array('borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle('A' . $this->row . ':' . $this->END_COLUMN . $this->row)->
                applyFromArray($double_top);
    }

    function setInvoicePaymentFromTotal($message, $payment) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, $message);
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->
                applyFromArray($border_style);
        $this->writeItemCol(3, '(Rp ' . number_format($payment) . ')', PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        ;
    }

    function setInvoicePaymentFromTotalLunas($payment) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'Down Payment');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->applyFromArray($border_style);
        $this->writeItemColBold(3, 'Rp ' . number_format($payment) . '', PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    }

    function setInvoicePaymentFromTotal2($payment) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'Down Payment');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->applyFromArray($border_style);
        $this->writeItemColBold(3, 'Rp ' . number_format($payment) . '', PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    }

    function setInvoicePaymentFromTotalLunasDP($payment) {
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setBold(false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'DP#1');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->applyFromArray($border_style);
        $this->writeItemColBold(3, '(Rp ' . number_format($payment) . ')', PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    }

    function setInvoiceTax($buys) {
        $totalBuys = $this->getTotalBuy($buys);
        $tax = 0.1 * $totalBuys;
        $lastCol = 'H';
        $this->rnext();
        $this->writeItemCol(0, '');
        $invCol = $this->invCol(1, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->getStyle($lastCol . $this->row)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($lastCol . $this->row, 'PPN(10%)');
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $lastCol . $this->row)->
                applyFromArray($border_style);
        $this->writeItemCol(3, 'Rp ' . number_format($tax), PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, $this->END_COLUMN);
        $invCol = $this->invCol(3, $this->row, false);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':' . $this->END_COLUMN . $this->row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        ;
    }

    function writePOItemCol($colNum, $content, $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT, $customCol = null) {
// Print the borders
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($this->poCol($colNum, $this->row, true))->
                applyFromArray($border_style);
// Print the actual content
        if ($customCol) {
            $invCol = $customCol . $this->row;
        } else {
            $invCol = $this->invCol($colNum, $this->row, false);
        }

        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal($align);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($invCol, $content);
    }

    function writeItemCol($colNum, $content, $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT, $customCol = null) {
// Print the borders
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($this->invCol($colNum, $this->row, true))->
                applyFromArray($border_style);
// Print the actual content
        if ($customCol) {
            $invCol = $customCol . $this->row;
        } else {
            $invCol = $this->invCol($colNum, $this->row, false);
        }
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal($align);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($invCol, $content);
    }

    function writeItemColBold($colNum, $content, $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT, $customCol = null) {
// Print the borders

        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($this->invCol($colNum, $this->row, true))->applyFromArray($border_style);
// Print the actual content
        if ($customCol) {
            $invCol = $customCol . $this->row;
        } else {
            $invCol = $this->invCol($colNum, $this->row, false);
        }
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal($align);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($invCol, $content);
    }

    function writeQuoteItemCol($colNum, $content, $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT, $customCol = null) {
// Print the borders
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($this->quoteCol($colNum, $this->row, true))->
                applyFromArray($border_style);
// Print the actual content
        if ($customCol) {
            $invCol = $customCol . $this->row;
        } else {
            $invCol = $this->quoteCol($colNum, $this->row, false);
        }
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal($align);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $this->phpExcel->getActiveSheet()->setCellValue($invCol, $content);
    }

    function writeOutpayCol($colNum, $content, $align = PHPExcel_Style_Alignment::HORIZONTAL_LEFT, $customCol = null) {
// Print the borders
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->phpExcel->getActiveSheet()->getStyle($this->outpayCol($colNum, $this->row, true))->
                applyFromArray($border_style);
// Print the actual content
        if ($customCol) {
            $invCol = $customCol . $this->row;
        } else {
            $invCol = $this->outpayCol($colNum, $this->row, false);
        }
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->setSize(11);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getAlignment()->setHorizontal($align);
        $this->phpExcel->getActiveSheet()->getStyle($invCol)->getFont()->getColor()->setARGB('FF000000');
        $this->phpExcel->getActiveSheet()->setCellValue($invCol, $content);
    }

    function setInvoicePayment($paymentTerm) {
        switch ($paymentTerm) {
            case 'cashOnDelivery':
                $this->cashOnDelivery();
                break;
            case 'transferStandard':
                $this->transferStandard();
                break;
            case 'transferPT':
                $this->transferPT();
                break;
        }
    }

    function cashOnDelivery() {
        $this->rnext(2);
        $this->writeInvoiceCustomerInfo('Pembayaran Cash On Delivery');
    }

    function downPaymentText($amount) {
        $this->rnext(2);
        $this->writeInvoiceCustomerInfo('Pembayaran Cash On Delivery');
    }

    function transferStandard() {
        $this->rnext(2);
        $this->writeInvoiceCustomerInfo('Pembayaran ke rekening:');
        $this->rnext();
        $this->writeInvoiceCustomerInfo('BCA cabang Supermall Karawaci');
        $this->writeInvoiceCustomerInfo('ACC: 761-073-2725');
        $this->writeInvoiceCustomerInfo('A/N: Ronny Hartanto');
        $this->rnext();
        $this->writeInvoiceCustomerInfo('Mandiri cabang Tangerang Pinangsia');
        $this->writeInvoiceCustomerInfo('ACC: 155-0007-3272-50');
        $this->writeInvoiceCustomerInfo('A/N: Ronny Hartanto');
    }

    function transferPT() {
        $this->rnext(2);
        $this->writeInvoiceCustomerInfo('Pembayaran ke rekening:');
        $this->rnext();
        $this->writeInvoiceCustomerInfo('BCA cabang Supermall Karawaci');
        $this->writeInvoiceCustomerInfo('ACC: 761-064-8830');
        $this->writeInvoiceCustomerInfo('A/N: PT. Tricipta Media Perkasa');
    }

    function setPoNum($poId) {
        $month = date('F');
        $year = date('Y');
        $poNum = $poId . '/' . $month . '/' . $year;
        $this->phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

        $this->phpExcel->getActiveSheet()->mergeCells('F3:G3');
        $this->phpExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->setCellValue('F3', 'No PO : ' . $poNum);

        $this->phpExcel->getActiveSheet()->mergeCells('H3:I3');
        $this->phpExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
        $this->phpExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $this->phpExcel->getActiveSheet()->setCellValue('H3', 'Tanggal : ' . date('d-m-Y'));
    }

    function getFileName($poId, $customer_name = null) {
        $month = date('F');
        $year = date('Y');
        if ($customer_name) {
            $fileName = $poId . '-' . str_replace(' ', '_', $customer_name) . '-' . strtolower($month) . '-' . $year . '.xlsx';
        } else {
            $fileName = $poId . '-' . strtolower($month) . '-' . $year . '.xlsx';
        }
        return $fileName;
    }

    function getOutpayFileName($supplierName, $outpayment) {
        $paidUnix = strtotime($outpayment['Outpayment']['paid']);
        $date = date('j', $paidUnix);
        $month = date('F', $paidUnix);
        $year = date('Y', $paidUnix);
        $fileName = $supplierName . '-' . $date . '-' . $month . '-' . $year . '-' . $outpayment['Outpayment']['id'] . '.xlsx';
        return $fileName;
    }

    function getPoDir() {
        return $this->PO_DIR;
    }

    private function filterSupplier($supplier) {
        $sArray = explode("@", $supplier);
        if (count($sArray) >= 2) {
            return $sArray[0];
        } else {
            return $supplier;
        }
    }

    function writeQuoteSummary($items, $diskon_plus, $ppn, $biaya_kirim) {
        $subtotal = $this->getTotalQuote($items);
        $display_diskon = false;
        $display_ppn = false;
        $display_biaya_kirim = false;
        if (intval($diskon_plus) != 0) {
            $diskon_plus_v = $subtotal * $diskon_plus / 100;
            $diskon_plus_txt = $diskon_plus;
            $display_diskon = true;
        } else {
            $diskon_plus_v = 0;
            $diskon_plus_txt = '-';
        }
        $_after_diskon_plus = $subtotal - $diskon_plus_v;
        if ($ppn == '1') {
            $ppnv = number_format(0.1 * $_after_diskon_plus, 2, ',', '.');
            $ppn = 0.1 * $_after_diskon_plus;
            $display_ppn = true;
        } else {
            $ppnv = '-';
            $ppn = 0;
        }
        if (intval($biaya_kirim) != 0) {
            $biaya_kirim;
            $display_biaya_kirim = true;
        } else {
            $biaya_kirim = 0;
        }
        //$total=$subtotal-$diskon_plus_v;
        $grand_total = $_after_diskon_plus + $ppn + $biaya_kirim;

        $this->rnext();
        $this->writeQuoteInfoLabel('Subtotal');
        $this->writeQuoteInfoContent($subtotal);
        $this->rnext();
        if ($display_diskon) {
            $this->writeQuoteInfoLabel("Diskon+");
            $this->writeQuoteInfoContent($diskon_plus . '%');
            $this->rnext();
        }
        if ($display_ppn) {
            $this->writeQuoteInfoLabel("PPn (10%)");
            $this->writeQuoteInfoContent($ppnv);
            $this->rnext();
        }
        if ($display_biaya_kirim) {
            $this->writeQuoteInfoLabel("Biaya Kirim");
            $this->writeQuoteInfoContent($biaya_kirim);
            $this->rnext();
        }
        $this->writeQuoteInfoLabel("Grand Total");
        $this->writeQuoteInfoContent($grand_total);
    }

    function setQuoteTotal($totalBuy) {
        $border_style = array('borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
        )));
        $this->rnext();
        $this->writeQuoteInfo2(number_format($totalBuy, 2, ',', '.'));
        $invCol = $this->quoteCol(4, $this->row, true);
        $this->phpExcel->getActiveSheet()->getStyle($invCol . ':I' . $this->row)->applyFromArray($border_style);
    }

    private function writeQuoteInfoContent($content) {
        if (!empty($content)) {
            $border_style = array('borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
            )));
            $this->phpExcel->getActiveSheet()->getStyle('I' . $this->row)->getFont()->setSize(11);
            $this->phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
            $this->phpExcel->getActiveSheet()->getStyle('I' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $this->phpExcel->getActiveSheet()->getStyle('I' . $this->row)->getFont()->getColor()->setARGB('FF000000');
            $this->phpExcel->getActiveSheet()->getStyle('I' . $this->row)->applyFromArray($border_style);
            $this->phpExcel->getActiveSheet()->setCellValue('I' . $this->row, $content);
        }
    }

    private function writeQuoteInfoLabel($content) {
        if (!empty($content)) {
            $border_style = array('borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
            )));
            $this->phpExcel->getActiveSheet()->mergeCells('G' . $this->row . ':H' . $this->row);
            $this->phpExcel->getActiveSheet()->getStyle('G' . $this->row)->getFont()->setSize(11);
            $this->phpExcel->getActiveSheet()->getStyle('G' . $this->row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->phpExcel->getActiveSheet()->getStyle('G' . $this->row)->getFont()->getColor()->setARGB('FF000000');
            $this->phpExcel->getActiveSheet()->getStyle('G' . $this->row)->applyFromArray($border_style);
            $this->phpExcel->getActiveSheet()->getStyle('H' . $this->row)->applyFromArray($border_style);
            $this->phpExcel->getActiveSheet()->setCellValue('G' . $this->row, $content);
        }
    }

    private function getTotalQuote($items) {
        $total = 0.0;
        $diskon = 0.0;
        foreach ($items as $item) {
            $total += $item['qty'] * $item['price'];
            $diskon+= $item['qty'] * $item['price'] * $this->calculateTotalDiscount($item['disc']) / 100;
        }
        $total = $total - $diskon;
        return $total;
    }

    function calculateTotalDiscount($discount) {
        $p = explode('+', $discount);
        $nominalDiscount = 0;
        if (count($p) == 1) {
            $textDiscount = str_replace(',', '.', $p[0]);
            $textDiscount = str_replace(' ', '', $textDiscount);
            $nominalDiscount = (double) $textDiscount;
        } else {
            foreach ($p as $d) {
                $nominalDiscount += ($d) * (1 - $nominalDiscount / 100);
            }
        }
        return $nominalDiscount;
    }

//exports Jurnals
    public function exportJurnals(array $jurnals, $filename) {
        $this->phpExcel = new PHPExcel();
        $this->row = 1;
        $sheet = $this->phpExcel->getActiveSheet();

//set header column name
        $sheet->setCellValue('A1', 'Tangal Transaksi');
        $sheet->setCellValue('B1', 'Nama Transaksi/Keterangan');
        $sheet->setCellValue('C1', 'Nomor Voucher');
        $sheet->setCellValue('D1', 'Code Akun');
        $sheet->setCellValue('E1', 'Nama Akun');
        $sheet->setCellValue('F1', 'Kredit');
        $sheet->setCellValue('G1', 'Debet');

        $i = 2;
        foreach ($jurnals as $idx => $jd) {
            $jurnal_date = date('d-F-Y', strtotime($jd['Jurnal']['tanggal_entry']));
            $sheet->setCellValue('A' . $i, $jurnal_date);
            $sheet->setCellValue('B' . $i, $jd['Jurnal']['nama_transaksi']);
            $sheet->setCellValue('C' . $i, $jd['Jurnal']['voucher_number']);

            foreach ($jd['JurnalDetail'] as $j) {
                $sheet->setCellValue('D' . $i, $j['Coa']['code']);
                $sheet->setCellValue('E' . $i, $j['Coa']['name']);

                $kredit = ($j['kredit'] == '0') ? '' : 'Rp ' . number_format($j['kredit']);
                $debet = ($j['debit'] == '0') ? '' : 'Rp ' . number_format($j['debit']);
                $sheet->setCellValue('F' . $i, $kredit);
                $sheet->setCellValue('G' . $i, $debet);
                $i++;
            }
            $i++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel2007');
        $objWriter->save($this->Base_Dir . $filename . '.xlsx');
    }

}
