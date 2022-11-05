<?php
include_once 'includes/connection.php';

if(isset($_GET['itm'])){
   $code =  $_GET['itm'];
    $data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT price,vat,vat_value from product where code = '$code'")) or die( mysqli_connect_error());
     $arr = array('price'=>$data['price'],'vat'=>$data['vat'],'vat_value'=>$data['vat_value']);
     echo json_encode($arr); 

}











?>