<?php
class HandlerController extends FileUploadAppController {

	public $uses = array('FileUpload.Upload');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow("*");
		
	}

	public function index()
	{
		$this->layout = 'none';
		
		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		switch ($_SERVER['REQUEST_METHOD']) {
		    case 'OPTIONS':
		        break;
		    case 'HEAD':
		    case 'GET':
		        $this->Upload->get();
		        break;
		    case 'POST':
		        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
		            $this->Upload->delete();
		        } else {
		            $this->Upload->post();
		        }
		        break;
		    case 'DELETE':
		        $this->Upload->delete();
		        break;
		    default:
		        header('HTTP/1.1 405 Method Not Allowed');
		}			
	}
}
?>