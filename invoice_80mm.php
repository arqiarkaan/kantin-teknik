<?php
//call the FPDF library
require('fpdf/fpdf.php');
include_once 'connectdb.php';


$id=$_GET['id'];
$select=$pdo->prepare("select * from tbl_invoice where invoice_id=$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

//create pdf object
$pdf = new FPDF('P','mm',array(80,200));

//add new page
$pdf->AddPage();

//set font to arial, bold, 16pt
$pdf->SetFont('Arial','B',16);
//Cell(width , height , text , border , end line , [align] )
$pdf->Cell(60,8,'PT Darren Sejahtera',1,1,'C');

$pdf->SetFont('Arial','B',8);

$pdf->Cell(60,5,'Alamat : Margonda Terbaik , Depok - Indonesia',0,1,'C');
$pdf->Cell(60,5, 'Nomor Telfon: 0812129912',0,1,'C');
$pdf->Cell(60,5,'E-mail Address : darrenarkaan@gmail.com',0,1,'C');
$pdf->Cell(60,5,'Website : www.masakandarren.com',0,1,'C');

//Line(x1,y1,x2,y2);
$pdf->Line(7,38,72,38);

$pdf->Ln(1); // line 

$pdf->SetFont('Arial','BI',8);
$pdf->Cell(20,4,'Bill To :',0,0,'');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(40,4,$row->customer_name,0,1,'');

$pdf->SetFont('Arial','BI',8);
$pdf->Cell(20,4,'Invoice no :',0,0,'');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(40,4,$row->invoice_id,0,1,'');

$pdf->SetFont('Arial','BI',8);
$pdf->Cell(20,4,'Date :',0,0,'');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(40,4,$row->order_date,0,1,'');

/////////

$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);

$pdf->Cell(34,5,'PRODUCT',1,0,'C');
$pdf->Cell(11,5,'QTY',1,0,'C');
$pdf->Cell(8,5,'HRG',1,0,'C');
$pdf->Cell(12,5,'TOTAL',1,1,'C');


$select=$pdo->prepare("select * from tbl_invoice_details where invoice_id=$id");
$select->execute();

while($item=$select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetX(7);
  $pdf->SetFont('Helvetica','B',8);
$pdf->Cell(34,5,$item->product_name,1,0,'L');   
$pdf->Cell(11,5,$item->qty,1,0,'C');
$pdf->Cell(8, 5,$item->price,1,0,'C');
$pdf->Cell(12,5,$item->price*$item->qty,1,1,'C');  
    
}


/////////


$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(25,5,'SUBTOTAL',1,0,'C');
$pdf->Cell(20,5,$row->subtotal,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(25,5,'PAJAK(5%)',1,0,'C');
$pdf->Cell(20,5,$row->tax,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(25,5,'DISKON',1,0,'C');
$pdf->Cell(20,5,$row->discount,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B',10);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(25,5,'GRAND TOTAL',1,0,'C');
$pdf->Cell(20,5,$row->total,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(25,5,'BAYAR',1,0,'C');
$pdf->Cell(20,5,$row->paid,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(25,5,'LEBIH/KURANG',1,0,'C');
$pdf->Cell(20,5,$row->due,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B',8);
$pdf->Cell(20,5,'',0,0,'L');   //190
//$pdf->Cell(20,5,'',0,0,'C');
$pdf->Cell(25,5,'TIPE PEMBAYARAN',1,0,'C');
$pdf->Cell(20,5,$row->payment_type,1,1,'C');

$pdf->Cell(20,5,'',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Courier','B',8);
$pdf->Cell(25,5,'Perhatian :',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','',5);
$pdf->Cell(75,5, 'Jika anda tidak suka makanan atau minuman kami, ',0,2,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','',5);
$pdf->Cell(75,5, 'berarti lidah anda bermasalah dan anda tidak bisa mendapatkan uang kembali.',0,1,'');

$pdf->Output();
?>