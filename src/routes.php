<?php

use Slim\Http\Request;
use Slim\Http\Response;

//เพิ่ม เมธอท เพื่อ 
//prepare เป็นการเตรียมคำสั่ง sql
//execute เปรียบเหมือนการ query
//fetchAll เปรียบเหมือนการ fetch_array
$app->get('/ShowCustomer',function($request,$response,$args){
    $sth = $this->db->prepare('SELECT * FROM customer');
    $sth->execute();
    $customers=$sth->fetchAll(); // fetchAll คือ การ fetch ทั้งหมดคืนค่าเป็น  array
    return $this->response->withJson($customers); // return ค่าเป็น Json
});

$app->get('/customer/[{id}]',function($request,$response,$args){
    $sth = $this->db->prepare('SELECT * FROM customer WHERE ID_customer=:a'); // หลัง : คือพารามิเตอร์ a คือ พารามิเตอร์
    $sth->bindParam("a",$args['id']); // bindParam คือการใส่ค่า $args['id'] ให้กับพารามิเตอร์ a 
    $sth->execute();
    $customer=$sth->fetchObject(); // fetchObject คือ fetch แค่ค่าเดียว ดึงมาใช้ได้เลยไม่ต้องวน loop
    return $this->response->withJson($customer);
});

//ฟังชั่นค้นหา
$app->get('/ShowCustomer/searching/[{query}]',function($request,$response,$args){
    $sth=$this->db->prepare('SELECT * FROM customer WHERE name_customer LIKE :q');
    $querys="%".$args['query']."%";
    $sth->bindParam("q",$querys);
    $sth->execute();
    $customer=$sth->fetchAll();
    return $this->response->withJson($customer);
});

