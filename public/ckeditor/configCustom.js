/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
    config.language = 'ja';
    //config.uiColor = '#e7e7e7';
    config.height = '45em';
    config.enterMode = CKEDITOR.ENTER_BR; //<p>改行を外す
    //config.skin = 'moono'; //moono bootstrapck
    
    //ソース表示時にタグが消えないようにする。削除するフィルターがかかるらしい。
    //config.allowedContent = true;
    //http://cms.al-design.jp/phpbb/viewtopic.php?f=11&t=2569
    
    //config.bodyClass = 'con';
    //config.fontSize_sizes = "1em";
    //config.editor.dataProcessor.writer.indentationChars = ''; //インデントなしにする
    
    //config.extraPlugins = 'debug_css'; //css２つ読み込み用
    config.contentsCss = ['/css/app.css','/css/style.css'];
    
    //if(! location.pathname.indexOf('jobs') > 0) {
    //config.extraPlugins = 'drugimg';
    config.extraPlugins = 'colorbutton,panelbutton,drugimg'; //myCustom 複数ある場合は複数指定で カンマの後にスペースを入れるとダメ
        
    //config.extraPlugins = 'colorbutton'; //set font color
    //config.extraPlugins = 'panelbutton'; //colorbuttonに必要らしい
    //}
    //console.log(location.pathname.indexOf('jobs'));
    
    
    config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'undo', 'clipboard' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'colors', groups: [ 'colors' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Subscript,Superscript,About,Scayt,Anchor,SpecialChar,Styles,Image'; //Imageどうするか
    
    /*
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];
	*/
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	//config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};

/*
CKEDITOR.on('instanceReady', function(ev) {
    ev.editor.dataProcessor.writer.indentationChars = ''; //インデントなし
});
*/


