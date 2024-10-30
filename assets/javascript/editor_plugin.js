// Docu : http://wiki.moxiecode.com/index.php/TinyMCE:Create_plugin/3.x#Creating_your_own_plugins

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('faq');
	 
	tinymce.create('tinymce.plugins.faq', {
		
		init : function(ed, url) {
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');

			ed.addCommand('faq', function() {
				ed.windowManager.open({
					file : url + '../../../window.php',
					width : 400,
					height : 110,
					inline : 1
				}, {
					plugin_url : url // Plugin absolute URL
				});
			});

			// Register example button
			ed.addButton('faq', {
				title : 'FAQ',
				cmd : 'faq',
				image : url + '../../images/faq_img.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('faq', n.nodeName == 'IMG');
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
					longname  : 'faq',
					author 	  : 'Apiki Open Source',
					authorurl : 'http://www.apiki.com',
					infourl   : 'http://www.apiki.com',
					version   : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('faq', tinymce.plugins.faq);
})();


