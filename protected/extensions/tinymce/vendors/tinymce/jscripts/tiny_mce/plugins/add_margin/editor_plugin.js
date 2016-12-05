(function($) {

$.fn.toggleCss = function(styleName, value) {
/// <summary>
///     Toggles on/off provided attribute for any tag/element 
/// </summary>
/// <param name="attribute" type="object">
///    Name of attribute to add or remove, eg: checked=""
/// </param> 
/// <param name="value" type="object">
///    Value of the attribute to add or remove, eg: ="checked"
/// </param> 
    css = $(this).css(styleName);
	if(css){
        if (css!= value) {
			$(this).css(styleName,value);
		} else {
			$(this).css(styleName, '');
		}
    }
    else{
        $(this).css(styleName, value);
    } 
};
})(jQuery);
(function() {
        // Load plugin specific language pack
        

        tinymce.create('tinymce.plugins.add_marginPlugin', {
                /**
                 * Initializes the plugin, this will be executed after the plugin has been created.
                 * This call is done before the editor instance has finished it's initialization so use the onInit event
                 * of the editor instance to intercept that event.
                 *
                 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
                 * @param {string} url Absolute URL to where the plugin is located.
                 */
                init : function(ed, url) {
                        this.editor = ed;
						this.url = url;
						this.size = '10px';
						// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceadd_margin');
						/*ed.addCommand('mceadd_margin', function() {
                                alert(ed.selection.getNode().style.cssText);
                        });*/

                        // Register add_margin button
                        /*ed.addButton('add_margin', {
                                title : 'add_margin.desc',
                                cmd : 'mceadd_margin',
                                image : url + '/img/add_margin.gif'
                        });*/
						//alert(this.createControl);
                        // Add a node change handler, selects the button in the UI when a image is selected
                        /*ed.onNodeChange.add(function(ed, cm, n) {
                                cm.setActive('add_margin', n.nodeName == 'IMG');
                        });*/
                },

                /**
                 * Creates control instances based in the incomming name. This method is normally not
                 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
                 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
                 * method can be used to create those.
                 *
                 * @param {String} n Name of the control to create.
                 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
                 * @return {tinymce.ui.Control} New control instance or null if no control was created.
                 */
                /*createControl : function(n, cm) {
                        return null;
                },*/
				createControl: function(n, cm) {
					ed=this.editor;
					function MakeIndent(arg){
						$(ed.selection.getNode()).toggleCss('margin-bottom',arg);
					}
					add_margin_plugin = this;
					switch (n) {
						case 'mysplitbutton':
							var c = cm.createSplitButton('mysplitbutton', {
								title : 'My split button',
								image : this.url + '/images/bottom_space.png',
								onclick : function() {
									MakeIndent(add_margin_plugin.size);
								}
							});

							c.onRenderMenu.add(function(c, m) {
								m.add({title : 'Отступ снизу', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
								
								clickFunc = function(size){
									//alert(add_margin_plugin.size);
									add_margin_plugin.size = size+'px';
									MakeIndent(add_margin_plugin.size);
									//alert(add_margin_plugin.size);
								};
								m.add({title : '2px', onclick : function(){
									clickFunc(2);
								}});

								m.add({title : '5px', onclick : function(){
									clickFunc(5);
								}});
								
								m.add({title : '10px', onclick : function(){
									clickFunc(10);
								}});
								
								
								m.add({title : '15px', onclick : function(){
									clickFunc(15);
								}});
							});

						  // Return the new splitbutton instance
						  return c;
					}

					return null;
				},
                /**
                 * Returns information about the plugin as a name/value array.
                 * The current keys are longname, author, authorurl, infourl and version.
                 *
                 * @return {Object} Name/value array containing information about the plugin.
                 */
                getInfo : function() {
                        return {
                                longname : 'add_margin plugin',
                                author : 'Some author',
                                authorurl : 'http://tinymce.moxiecode.com',
                                infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/add_margin',
                                version : "1.0"
                        };
                }
        });

        // Register plugin
        tinymce.PluginManager.add('add_margin', tinymce.plugins.add_marginPlugin);
})();