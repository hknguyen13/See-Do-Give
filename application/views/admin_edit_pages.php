<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Page</title>
<link rel="stylesheet" href="<?php echo base_url();?>css/ui.all.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url();?>css/innerpages.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		//mode : "textareas",
		mode : "exact",
		elements: "elm1",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		//theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons2 : "link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		//theme_advanced_statusbar_location : "bottom",
		//theme_advanced_resizing : true,
		//theme_advanced_resizing : false,

		// Example content CSS (should be your site CSS)
		//content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		//external_link_list_url : "lists/link_list.js",
		//external_image_list_url : "lists/image_list.js",
		//media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
	
function getText()
{
var y =  tinyMCE.get('elm1').getContent();
alert(y);
}

</script>
<?php if($_REQUEST['submit'])
{
	$sql_ret=mysql_query("update adminpages set PageName='".addslashes($_REQUEST['pagename'])."',PageTitle='".addslashes($_REQUEST['pagetitle'])."',PageMetaTitle='".addslashes($_REQUEST['metatitle'])."',PageMetaKeywords='".addslashes($_REQUEST['metakeywords'])."',PageMetaDescription='".addslashes($_REQUEST['metadescription'])."' where PageId=".$_REQUEST['pageId']);
	
	$sql_ret1=mysql_query("update pagecontent set PageContent='".addslashes($_REQUEST['elm1'])."' where PageContentPageId=".$_REQUEST['pageId']);
	
	
	redirect(base_url()."index.php/admin/getpage");
}?>
</head>

<body>
<div id="container">
<div id="header">
	 <?php include("menu.php"); ?>
	  <div id="formlineTwo">
<div id="stylized" class="myform" style="width:800px;  margin-left:64px;">
<form id="form" name="form" method="post" action="" enctype="multipart/form-data">
<h1>Edit Page</h1>
<p><?php
if($error) { echo "<span style='color:red; font-family:13px;'>".$error."</span><br/>"; }
if($success) { echo $success; }
?></p>
<?php //print_r($pageItems); exit;?>
<table class="product_table">
          <tr>
            <td width="100px;">Page Name</td>
            <td><input type="text" id="pagename" name="pagename" size="80" value="<?php echo $pageItems['PageName'];?>"></td>
          </tr>
          <tr>
            <td>Page Content</td>
            <td><textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 95%"><?php echo $pageItems['PageContent'];?></textarea></td>
          </tr>
          
          <tr>
            <td><input type="hidden" id="edit" name="edit" value="<?=$this->uri->segment(2);?>" />
            <input type="hidden" id="pageId" name="pageId" value="<?=$this->uri->segment(3);?>"/></td>
            <td><input type="submit" id="submit" name="submit" value="Save" style="background:#666666; width:125px; color:#FFFFFF;"> &nbsp; <input type="button" id="back" name="back" value="Back" onClick="location.href='<?=base_url();?>index.php/admin/getpage'" style="background:#666666; width:125px; color:#FFFFFF;">
             </td>
          </tr>
        </table>

<div class="spacer"></div>
</form>
</div>
</div>
<div id="images"></div>
<div class="clear"></div>
</div>
</div>
<div id="footer">
<div id="footercontainer">
	<div class="menu"><a href="#" title="Home">Home</a> | <a href="#" title="How It Works">How It Works</a> | <a href="#" title="Blog">Blog</a>| <a href="#" title="Advertise">Advertise</a> | <a href="#" title="Contact Us">Contact Us</a></div>
	<div class="copyRights">© <?php echo date("Y");?>, SeeDoGive. All Rights Reserved.</div>
	<div class="clear"></div>
  </div>
</div>
</body>
</html>
