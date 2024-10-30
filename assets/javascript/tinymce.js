function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertFAQcode() {

	var tagtext;
	var category_ddb = document.getElementById('faq_categories');
	var category = category_ddb.value;
        var filters = document.getElementById('faq_filters').checked;
        
	if( category == "" )
            return;

        else{
            
        if( filters == true ){
            tagtext = "[imasters-wp-faq cat='" + category + "' filters='yes'";
        }
        else{
            tagtext = "[imasters-wp-faq cat='" + category + "' filters='no'";
        }
	window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext+']');
	tinyMCEPopup.editor.execCommand('mceRepaint');
	tinyMCEPopup.close();
	return;
   }
}
