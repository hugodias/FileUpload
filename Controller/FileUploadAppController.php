<?php
class FileUploadAppController extends AppController {
	public $components = array(
		'FileUpload.Upload' // By Default your files will be stored in `app/webroot/files` . Check the docs in upload component for options
	);
}
?>