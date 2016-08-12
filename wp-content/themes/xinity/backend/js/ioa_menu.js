// JavaScript Document


var loc = jQuery('#shortcode_link').attr('href');

(function() {
       
        tinymce.create('tinymce.plugins.button', {
                /**
                 * Initializes the plugin, this will be executed after the plugin has been created.
                 * This call is done before the editor instance has finished it's initialization so use the onInit event
                 * of the editor instance to intercept that event.
                 *
                 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
                 * @param {string} url Absolute URL to where the plugin is located.
                 */
                init : function(ed, url) {
                        // Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
                       

                        var rad_lightbox = jQuery('div.rad-lightbox'),settings_lightbox ;

                            var rl = {
                                show : function(msg) {

                                    jQuery('#save-l-data').hide();
                                    jQuery('#shortcode-l-data').show();

                                    rad_lightbox.css('opacity',1).fadeIn('slow');
                                    rad_lightbox.find('div.rad-l-head h4').html(msg);
                                },
                                hide: function() {
                                    rad_lightbox.fadeOut('fast');
                                },
                                set : function(html,key)
                                {
                                    
                                    rad_lightbox.find('div.rad-l-body div.component-opts').html(html);
                                    rad_lightbox.find('div.rad-l-body').data('key',key);

                                }
                            };

                        function showRADBox(key)
                        {
                          settings_lightbox.find('.save-settings').hide();
                          settings_lightbox.find('.save-shortcode-settings').show();

                          settings_lightbox.find('.inner-settings-body').children().hide();
                          settings_lightbox.fadeIn('fast');
                          settings_lightbox.find('.'+key).fadeIn('fast');
                          settings_lightbox.data('sid',key);

                        }


                        // Register example button
                        ed.addButton('ioabutton', {
                                text : 'Shortcodes',
                                type: 'menubutton',
                                menu: [

                                    {
                                      text: 'Icons',
                                      value: 'icon',
                                      onclick: function() {
                                          
                                          rad_lightbox.data("mode","shortcode")

                                          rl.show('Select Icon');
                                          jQuery.post(jQuery('#backend_link').attr('href'),{ type:'icons', action: 'ioalistener' , 'current_icon' : '' },function(data){
                                              rl.set(data,'icons');
                                              rad_lightbox.find('.sc-icon-list-wrap').height(rad_lightbox.height());
                                              rad_lightbox.trigger('iconbind');
                                          });

                                      }
                                    },

                                    {
                                      text: 'Columns',
                                      value: 'Columns',
                                      onclick: function() {
                                          
                                          
                                              rad_lightbox.data("mode","shortcode")

                                              rl.show('Create Layout');
                                              jQuery.post(jQuery('#backend_link').attr('href'),{ type:'shortcode_columns', action: 'ioalistener' , 'current_icon' : '' },function(data){
                                                  rl.set(data,'shortcode_columns');
                                              });

                                      }
                                    },


                                     {
                                      text: 'Typography',
                                      value: 'Typography',
                                      onclick: function() {},
                                      menu : [ 

                                               {
                                                  text: 'Drop Caps',
                                                  value: 'Drop Caps',
                                                  onclick: function() {
                                                      
                                                    tinyMCE.activeEditor.selection.setContent('[drop_cap]'+tinyMCE.activeEditor.selection.getContent()+"[/drop_cap]");

                                                  }
                                                },

                                                {
                                                  text: 'Highlight',
                                                  value: 'Highlight',
                                                  onclick: function() {
                                                      
                                                   tinyMCE.activeEditor.selection.setContent('[highlight]'+tinyMCE.activeEditor.selection.getContent()+"[/highlight]");

                                                  }
                                                },

                                                {
                                                  text: 'Highlight',
                                                  value: 'Highlight',
                                                  onclick: function() {
                                                      
                                                   tinyMCE.activeEditor.selection.setContent('[highlight_dark]'+tinyMCE.activeEditor.selection.getContent()+"[/highlight_dark]");
                                                  }
                                                },

                                                {
                                                  text: 'Quotes',
                                                  value: 'Quotes',
                                                  onclick: function() {
                                                      
                                                   tinyMCE.activeEditor.selection.setContent('[quotes]'+tinyMCE.activeEditor.selection.getContent()+"[/quotes]");
                                                  }
                                                },

                                                 {
                                                  text: 'Quotes Left',
                                                  value: 'Quotes Left',
                                                  onclick: function() {
                                                      
                                                   tinyMCE.activeEditor.selection.setContent('[quotes_left]'+tinyMCE.activeEditor.selection.getContent()+"[/quotes_left]");
                                                  }
                                                },

                                                 {
                                                  text: 'Quotes Right',
                                                  value: 'Quotes Right',
                                                  onclick: function() {
                                                      
                                                   tinyMCE.activeEditor.selection.setContent('[quotes_right]'+tinyMCE.activeEditor.selection.getContent()+"[/quotes_right]");
                                                  }
                                                },

                                                 {
                                                  text: 'PRE',
                                                  value: 'PRE',
                                                  onclick: function() {
                                                      
                                                  tinyMCE.activeEditor.selection.setContent('[pre]'+tinyMCE.activeEditor.selection.getContent()+"[/pre]");
                                                  }
                                               },


                                       ]
                                    },

                                      {
                                            text: 'Toggles',
                                            value: 'Toggles',
                                            onclick: function() {
                                                
                                           tinyMCE.activeEditor.selection.setContent('[toggle title="Your Title" collapse="collapse"]'+tinyMCE.activeEditor.selection.getContent()+"[/toggle]");
                                            }
                                          },
                                           {
                                            text: 'Video',
                                            value: 'Video',
                                            onclick: function() {
                                                
                                           tinyMCE.activeEditor.selection.setContent('[ioa_video width="300" height="300"]https://www.youtube.com/watch?v=JNcLKbJs3xk[/ioa_video]');
                                            }
                                          }, 
                                          {
                                            text: 'Button',
                                            value: 'Button',
                                            onclick: function() {
                                                
                                           tinyMCE.activeEditor.selection.setContent('[button size="large" color="" "background="" radius="3px" type="default" link="#" newwindow="true" icon=""]Button[/button]');
                                            }
                                          },   


                                 ]
                        });

                        // Add a node change handler, selects the button in the UI when a image is selected
                        ed.onNodeChange.add(function(ed, cm, n) {
                                cm.setActive('example', n.nodeName == 'IMG');
                        });
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
                createControl : function(n, cm) {


                        return null;
                },

            
        });

        // Register plugin
        tinymce.PluginManager.add('button', tinymce.plugins.button);
})();