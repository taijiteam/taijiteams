<?php
namespace Home\Controller;
use Think\Controller;
class MessageController extends Controller {

    public function index(){
      Vendor('phpSDK.OpenApiClient');
      $client = new \OpenApiClient ();
      
      $this->display();
    }
}
