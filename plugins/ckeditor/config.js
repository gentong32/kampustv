/*
 Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.extraPlugins = 'equation';
	config.pasteFromWordRemoveFontStyles = true;
	config.pasteFromWordRemoveStyles = true;
	config.pasteFromWordPromptCleanup = true;
	
	config.filebrowserBrowseUrl = '/rtf/plugins/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = '/rtf/plugins/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl ='/rtf/plugins/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = '/rtf/plugins/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = '/rtf/plugins/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = '/rtf/plugins/kcfinder/upload.php?type=flash';

	config.toolbar_Full =
		[
			['Source','Save','NewPage','Preview','-','Templates'],
			['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
			['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
			['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
			'/',
			['Bold','Italic','Underline','Strike','-','Subscript','Superscript','equation'],
			['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
			['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
			['BidiLtr', 'BidiRtl' ],
			['Link','Unlink','Anchor'],
			['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
			'/',
			['Styles','Format','Font','FontSize'],
			['TextColor','BGColor'],
			['Maximize', 'ShowBlocks','-']
		];

	config.toolbar_Basic =
		[
			['Source','-','equation', '-', 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
		];
};
