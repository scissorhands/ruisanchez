// JavaScript Document


var loc = jQuery('#shortcode_link').attr('href');

var img_loc = loc+"/css/i/shortcode_icon.png";


tinymce.create('tinymce.plugins.button', {
    createControl: function(n, cm) 
                {
                    switch (n) {
            case 'ioabutton':
                var c = cm.createMenuButton('Shortcodes', {
   title : 'Shortcode Menu',
    image : img_loc
});


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

c.onRenderMenu.add(function(c, m) {
    m.add({title : 'Shortcodes', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
    
    // == Layout Maker ===========================================
    
     m.add({title : 'Icons', onclick : function() { 
            
            rad_lightbox.data("mode","shortcode")

            rl.show('Select Icon');
            jQuery.post(jQuery('#backend_link').attr('href'),{ type:'icons', action: 'ioalistener' , 'current_icon' : '' },function(data){
                rl.set(data,'icons');
                rad_lightbox.find('.sc-icon-list-wrap').height(rad_lightbox.height());
                rad_lightbox.trigger('iconbind');
            });
                    
      }}); 

      m.add({title : 'Columns', onclick : function() { 
            
            

            rad_lightbox.data("mode","shortcode")

            rl.show('Create Layout');
            jQuery.post(jQuery('#backend_link').attr('href'),{ type:'shortcode_columns', action: 'ioalistener' , 'current_icon' : '' },function(data){
                rl.set(data,'shortcode_columns');
            });
                    
      }});
      
      var key = '';

     /*
      m.add({title : 'Widget Area', onclick : function() { 
            key = 'rad-sidebar-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});
      */



      var textmenu = m.addMenu({title : 'Typography', onclick : function() {   }});

      textmenu.add({title : 'Text Column', onclick : function() {


            settings_lightbox =   jQuery('.text-settings-lightbox');

            jQuery('.settings-lightbox,.text-settings-lightbox').find('.inner-settings-body').children().hide();
            jQuery('.text-settings-lightbox,.rad-text-widget').show();

             settings_lightbox.find('.save-settings').hide();
            settings_lightbox.find('.save-shortcode-settings').show();

                    
      }}); 

       textmenu.add({title : 'Drop Caps', onclick : function() { 
            
           tinyMCE.activeEditor.selection.setContent('[drop_cap]'+tinyMCE.activeEditor.selection.getContent()+"[/drop_cap]");
                    
      }}); 


       textmenu.add({title : 'Quotes', onclick : function() { tinyMCE.activeEditor.selection.setContent('[quotes]'+tinyMCE.activeEditor.selection.getContent()+"[/quotes]");  }});
  textmenu.add({title : 'Quotes Left', onclick : function() { tinyMCE.activeEditor.selection.setContent('[quotes_left]'+tinyMCE.activeEditor.selection.getContent()+"[/quotes_left]");  }});
  textmenu.add({title : 'Quotes Right', onclick : function() { tinyMCE.activeEditor.selection.setContent('[quotes_right]'+tinyMCE.activeEditor.selection.getContent()+"[/quotes_right]");  }});
    textmenu.add({title : 'PRE', onclick : function() { tinyMCE.activeEditor.selection.setContent('[pre]'+tinyMCE.activeEditor.selection.getContent()+"[/pre]");  }});

      textmenu.add({title : 'Intro Text', onclick : function() { 
            key =  'rad-intro-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       textmenu.add({title : 'CTA', onclick : function() { 
            key =  'rad-cta-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }}); 


      



      var compmenu = m.addMenu({title : 'Components', onclick : function() {   }});

      compmenu.add({title : 'Gallery', onclick : function() { 
            key =  'rad-gallery-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       compmenu.add({title : 'Tabs', onclick : function() { 
            key =  'rad-tabs-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       compmenu.add({title : 'Accordion', onclick : function() { 
            key =  'rad-accordion-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       compmenu.add({title : 'Toggles', onclick : function() { 
            key =  'rad-toggle-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       compmenu.add({title : 'Icon Set', onclick : function() { 
            key =  'rad-iconsets-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       compmenu.add({title : 'Logo Area', onclick : function() { 
            key =  'rad-logo-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       compmenu.add({title : 'Scrollable', onclick : function() { 
            key =  'rad-scrollable-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});


       compmenu.add({title : 'Testimonials', onclick : function() { 
            key =  'rad-testimonials-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       compmenu.add({title : 'Testimonial', onclick : function() { 
            key =  'rad-testimonial-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       compmenu.add({title : 'Pricing Table', onclick : function() { 
            key =  'rad-pricing-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

       


       

       compmenu.add({title : 'Magic List', onclick : function() { 
            key =  'rad-magic-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

        var widgetm = m.addMenu({title : 'UI Items', onclick : function() {   }});

        widgetm.add({title : 'Image', onclick : function() { 
            key =  'rad-image-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
         }});

         widgetm.add({title : 'Button', onclick : function() { 
            key =  'rad-button-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
         }});

        widgetm.add({title : 'Divider', onclick : function() { 
            key =  'rad-divider-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
         }});

        widgetm.add({title : 'Video', onclick : function() { 
            key =  'rad-video-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
         }});

        widgetm.add({title : 'Progress Bars', onclick : function() { 
            key =  'rad-progressbar-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
         }});

        widgetm.add({title : 'Radial Chart', onclick : function() { 
            key =  'rad-radial-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
         }});

        widgetm.add({title : 'Counter', onclick : function() { 
            key =  'rad-counter-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
         }});

        widgetm.add({title : 'Person', onclick : function() { 
            key =  'rad-teamwidget-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
         }});

         widgetm.add({title : 'Notification', onclick : function() { 
            key =  'rad-notification-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
         }});




      var wpposts = m.addMenu({title : 'Posts Widgets', onclick : function() {   }});

      wpposts.add({title : 'Post List', onclick : function() { 
            key =  'rad-post-list-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }});

      wpposts.add({title : 'Post Featured', onclick : function() { 
            key =  'rad-post-feature-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }}); 

      wpposts.add({title : 'Post Slider', onclick : function() { 
            key =  'rad-post-slider-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }}); 

      wpposts.add({title : 'Post Grid', onclick : function() { 
            key =  'rad-post-grid-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }}); 

      wpposts.add({title : 'Post Masonry', onclick : function() { 
            key =  'rad-post-masonry-widget';
            settings_lightbox =   jQuery('.settings-lightbox');
            showRADBox(key);
      }}); 


      

      
      
    
     
     
});


                // Return the new splitbutton instance
                return c;
        }

            
                    return null;
                }
});

// Register plugin
tinymce.PluginManager.add('button', tinymce.plugins.button);