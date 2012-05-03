<?php  
App::uses('AppHelper', 'View/Helper');

class UploadFormHelper extends AppHelper {

	/**
	*	Load the form
	*	@param String url for the data handler
	*/
	public function load( $url = '/file_upload/handler' )
	{
		// Remove the first `/` if it exists.
	    if( $url[0] == '/' )
	    {
	        $url = substr($url, 1);
	    }

		$this->_loadScripts();
		$this->_loadTemplate( $url );
	}


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


	private function _loadTemplate( $url = null )
	{
		echo '<div class="container">
		<form id="fileupload" action="'.$this->request->webroot.$url.'" method="POST" enctype="multipart/form-data">
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

}
?>