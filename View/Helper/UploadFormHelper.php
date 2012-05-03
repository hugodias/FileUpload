<?php  
App::uses('AppHelper', 'View/Helper');

/**
* Helper to load the upload form
*
* NOTE: If you want to use it out of this plugin you NEED to include the CSS files in your Application.
* The files are loaded in `app/Plugins/FileUpload/View/Layouts/default.ctp` starting at line 16
*
*/
class UploadFormHelper extends AppHelper {

	/**
	*	Load the form
	* 	@access public
	*	@param String $url url for the data handler
	*   @param Boolean $loadExternal load external JS files needed
	* 	@return void
	*/
	public function load( $url = '/file_upload/handler', $loadExternal = true )
	{
		// Remove the first `/` if it exists.
	    if( $url[0] == '/' )
	    {
	        $url = substr($url, 1);
	    }

		$this->_loadScripts();

		$this->_loadTemplate( $url );

		if( $loadExternal )
		{
			$this->_loadExternalJsFiles();	
		}
		
	}

	/**
	*	Load the scripts needed.
	* 	@access private
	* 	@return void
	*/
	private function _loadScripts()
	{
		echo '<script id="template-upload" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-upload fade">
		        <td class="preview"><span class="fade"></span></td>
		        <td class="name"><span>{%=file.name%}</span></td>
		        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
		        {% if (file.error) { %}
		            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
		        {% } else if (o.files.valid && !i) { %}
		            <td>
		                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
		            </td>
		            <td class="start">{% if (!o.options.autoUpload) { %}
		                <button class="btn btn-primary">
		                    <i class="icon-upload icon-white"></i>
		                    <span>{%=locale.fileupload.start%}</span>
		                </button>
		            {% } %}</td>
		        {% } else { %}
		            <td colspan="2"></td>
		        {% } %}
		        <td class="cancel">{% if (!i) { %}
		            <button class="btn btn-warning">
		                <i class="icon-ban-circle icon-white"></i>
		                <span>{%=locale.fileupload.cancel%}</span>
		            </button>
		        {% } %}</td>
		    </tr>
		{% } %}
		</script>
		<script id="template-download" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-download fade">
		        {% if (file.error) { %}
		            <td></td>
		            <td class="name"><span>{%=file.name%}</span></td>
		            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
		            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
		        {% } else { %}
		            <td class="preview">{% if (file.thumbnail_url) { %}
		                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
		            {% } %}</td>
		            <td class="name">
		                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&\'gallery\'%}" download="{%=file.name%}">{%=file.name%}</a>
		            </td>
		            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
		            <td colspan="2"></td>
		        {% } %}
		        <td class="delete">
		            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
		                <i class="icon-trash icon-white"></i>
		                <span>{%=locale.fileupload.destroy%}</span>
		            </button>
		            <input type="checkbox" name="delete" value="1">
		        </td>
		    </tr>
		{% } %}
		</script>';

	}

	/**
	*	Load the entire form structure.
	* 	@access private
	* 	@return void
	*/
	private function _loadTemplate( $url = null )
	{
		echo '<div class="container">
		<form id="fileupload" action="'.Router::url('/', true).$url.'" method="POST" enctype="multipart/form-data">
	        <div class="row fileupload-buttonbar">
	            <div class="span7">
	                <span class="btn btn-success fileinput-button">
	                    <i class="icon-plus icon-white"></i>
	                    <span>Add files...</span>
	                    <input type="file" name="files[]" multiple>
	                </span>
	                <button type="submit" class="btn btn-primary start">
	                    <i class="icon-upload icon-white"></i>
	                    <span>Start upload</span>
	                </button>
	                <button type="reset" class="btn btn-warning cancel">
	                    <i class="icon-ban-circle icon-white"></i>
	                    <span>Cancel upload</span>
	                </button>
	                <button type="button" class="btn btn-danger delete">
	                    <i class="icon-trash icon-white"></i>
	                    <span>Delete</span>
	                </button>
	                <input type="checkbox" class="toggle">
	            </div>
	            <div class="span5">
	                <div class="progress progress-success progress-striped active fade">
	                    <div class="bar" style="width:0%;"></div>
	                </div>
	            </div>
	        </div>
	        <div class="fileupload-loading"></div>
	        <br>
	        <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
	    </form>
	</div>
	<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd">
	    <div class="modal-header">
	        <a class="close" data-dismiss="modal">&times;</a>
	        <h3 class="modal-title"></h3>
	    </div>
	    <div class="modal-body"><div class="modal-image"></div></div>
	    <div class="modal-footer">
	        <a class="btn modal-download" target="_blank">
	            <i class="icon-download"></i>
	            <span>Download</span>
	        </a>
	        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
	            <i class="icon-play icon-white"></i>
	            <span>Slideshow</span>
	        </a>
	        <a class="btn btn-info modal-prev">
	            <i class="icon-arrow-left icon-white"></i>
	            <span>Previous</span>
	        </a>
	        <a class="btn btn-primary modal-next">
	            <span>Next</span>
	            <i class="icon-arrow-right icon-white"></i>
	        </a>
	    </div>
	</div>
	';		
	}

	/**
	*	Load external JS files needed.
	* 	@access private
	* 	@return void
	*/
	private function _loadExternalJsFiles()
	{
		echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/vendor/jquery.ui.widget.js"></script>
		<script src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
		<script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
		<script src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js"></script>
		<script src="http://blueimp.github.com/cdn/js/bootstrap.min.js"></script>
		<script src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
		<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/jquery.iframe-transport.js"></script>
		<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/jquery.fileupload.js"></script>
		<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/jquery.fileupload-fp.js"></script>
		<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/jquery.fileupload-ui.js"></script>
		<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/locale.js"></script>
		<script type="text/javascript" src="'.Router::url('/', true).'file_upload/js/main.js"></script>';	
	}

}
?>