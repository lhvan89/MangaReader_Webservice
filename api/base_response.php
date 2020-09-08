<?php
header('Content-Type: application/json');

class BaseResponse {
  public $Title;
  public $Result;
  public $Status;
}

class Status {
  public $Code;
  public $Desc;
}

$status = new Status();
$status->Code = 200;
$status->Desc = "";

$response = new BaseResponse();
$response->Title  = "";
$response->Status = $status;

?>