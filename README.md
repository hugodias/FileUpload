# JqueryFileUpload - CakePHP v 0.1
---
Using the jQueryFileUpload from blueimp in CakePHP 2.1.x

You can find the documentation [here][fileupload]
[fileupload]: https://github.com/blueimp/jQuery-File-Upload


#### [Demo][]
[Demo]: http://blueimp.github.com/jQuery-File-Upload/


## Quick start

- Create a table named `uploads` in your database with the following structure:

<pre>CREATE TABLE uploads (
id int(11) NOT NULL AUTO_INCREMENT,
name varchar(255) NOT NULL,
size int(11) NOT NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
</pre>

- Include the plugin in your `app/Config/bootstrap.php` file

<pre>CakePlugin::load('FileUpload');</pre>

- Start upload files at `http://yourapp.com/file_upload`


