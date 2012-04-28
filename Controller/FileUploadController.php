<?php
class FileUploadController extends FileUploadAppController {

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow("*");
	}

	public function index()
	{
		
	}
}

?>