jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.tweetable_plugin', {
    
        init : function(ed, url) {
               
                ed.addCommand('tweetable_insert_shortcode', function() {
                    selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        content =  '[tweetable alt=""]'+selected+'[/tweetable]';
                        tinymce.execCommand('mceInsertContent', false, content);
                    }else{
                        alert('Tweetable : Select some text !')
                    }

                    
                });
          
            ed.addButton('tweetable_button', {title : 'Tweetable selected text', cmd : 'tweetable_insert_shortcode', image: url + '/tweetable.png' });
        
        },   
    });

    tinymce.PluginManager.add('tweetable_button', tinymce.plugins.tweetable_plugin);
    
});