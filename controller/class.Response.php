<?php


class Response{

  public $response;
  public $request;

  function __construct($request = []){
    $this->setParams();
  }


  private function setParams($status = false, $msg = 'General Error', $data = []){
    $this->response = [
      'request' => $this->request,
      'status' => $status,
      'msg' => $msg,
      'data' => $data,
      'code' => ($status) ? 1 : 0 
    ];
  }


  public function success($msg = '', $data = []){
    $this->setParams(true, $msg, $data);
    echo json_encode($this->response);
    exit();
  }


  public function error($msg, $data = []){
    $this->setParams(false, $msg, $data);
    echo json_encode($this->response);
    exit();
  }


}



?>
