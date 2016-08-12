jQuery.noConflict();
/**
 * Main Javascript all plugins and theme code declared here.
 */


/*!
 * jQuery Cookie Plugin v1.4.0
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */

 var IE = (function () {
    "use strict";

    var ret, isTheBrowser,
        actualVersion,
        jscriptMap, jscriptVersion;

    isTheBrowser = false;
    jscriptMap = {
        "5.5": "5.5",
        "5.6": "6",
        "5.7": "7",
        "5.8": "8",
        "9": "9",
        "10": "10"
    };
    jscriptVersion = new Function("/*@cc_on return @_jscript_version; @*/")();

    if (jscriptVersion !== undefined) {
        isTheBrowser = true;
        actualVersion = jscriptMap[jscriptVersion];
    }

    ret = {
        isTheBrowser: isTheBrowser,
        actualVersion: actualVersion
    };

    return ret;
}());

(function (factory) {
        if (typeof define === 'function' && define.amd) {
                // AMD. Register as anonymous module.
                define(['jquery'], factory);
        } else {
                // Browser globals.
                factory(jQuery);
        }
}(function ($) {

        var pluses = /\+/g;

        function encode(s) {
                return config.raw ? s : encodeURIComponent(s);
        }

        function decode(s) {
                return config.raw ? s : decodeURIComponent(s);
        }

        function stringifyCookieValue(value) {
                return encode(config.json ? JSON.stringify(value) : String(value));
        }

        function parseCookieValue(s) {
                if (s.indexOf('"') === 0) {
                        // This is a quoted cookie as according to RFC2068, unescape...
                        s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
                }

                try {
                        // Replace server-side written pluses with spaces.
                        // If we can't decode the cookie, ignore it, it's unusable.
                        // If we can't parse the cookie, ignore it, it's unusable.
                        s = decodeURIComponent(s.replace(pluses, ' '));
                        return config.json ? JSON.parse(s) : s;
                } catch(e) {}
        }

        function read(s, converter) {
                var value = config.raw ? s : parseCookieValue(s);
                return $.isFunction(converter) ? converter(value) : value;
        }

        var config = $.cookie = function (key, value, options) {

                // Write

                if (value !== undefined && !$.isFunction(value)) {
                        options = $.extend({}, config.defaults, options);

                        if (typeof options.expires === 'number') {
                                var days = options.expires, t = options.expires = new Date();
                                t.setTime(+t + days * 864e+5);
                        }

                        return (document.cookie = [
                                encode(key), '=', stringifyCookieValue(value),
                                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                                options.path    ? '; path=' + options.path : '',
                                options.domain  ? '; domain=' + options.domain : '',
                                options.secure  ? '; secure' : ''
                        ].join(''));
                }

                // Read

                var result = key ? undefined : {};

                // To prevent the for loop in the first place assign an empty array
                // in case there are no cookies at all. Also prevents odd result when
                // calling $.cookie().
                var cookies = document.cookie ? document.cookie.split('; ') : [];

                for (var i = 0, l = cookies.length; i < l; i++) {
                        var parts = cookies[i].split('=');
                        var name = decode(parts.shift());
                        var cookie = parts.join('=');

                        if (key && key === name) {
                                // If second argument (value) is a function it's a converter...
                                result = read(cookie, value);
                                break;
                        }

                        // Prevent storing a cookie that we couldn't decode.
                        if (!key && (cookie = read(cookie)) !== undefined) {
                                result[name] = cookie;
                        }
                }

                return result;
        };

        config.defaults = {};

        $.removeCookie = function (key, options) {
                if ($.cookie(key) === undefined) {
                        return false;
                }

                // Must not alter options, thus extending a fresh object...
                $.cookie(key, '', $.extend({}, options, { expires: -1 }));
                return !$.cookie(key);
        };

}));

if (!jQuery.support.transition) {
    jQuery.fn.transition = jQuery.fn.animate;
}

/**
 * Code that needs to be executed at first.
 */

jQuery(document).ready(function () {
"use strict";
     
     

    if(IE.isTheBrowser)
    {
        jQuery('body').addClass('ie-'+IE.actualVersion);
    } 

    var isIE11 = !!navigator.userAgent.match(/Trident.*rv\:11\./);

    if(isIE11) jQuery('body').addClass('ie-11');

    jQuery('div.metro-blog-wrapper').width( jQuery(window).width() - 290 );
    jQuery(".format-video, .video, .ioa-video ").fitVids();

    var icon = 'angle-righticon-'; 
    if(jQuery('body').hasClass('rtl')) icon = 'angle-lefticon-';

    jQuery(".sidebar-wrap.widget_recent_entries ul li,.sidebar-wrap.widget_archive ul li, .sidebar-wrap.widget_categories ul li, .sidebar-wrap.widget_meta ul li, .sidebar-wrap.widget_recent_comments ul li ").append('<i class="ioa-front-icon  '+icon+' w-pin"></i>');
    
    jQuery("a[data-rel]").each(function(){ 
        jQuery(this).attr("rel",jQuery(this).data('rel'));
    });

    jQuery('.gallery').each(function(){
        jQuery(this).find('a').attr('rel','prettyphoto['+jQuery(this).attr('id')+']');
    });
     
    if( jQuery('.header-cons-area').length > 0 ) {  

    var m = jQuery('.mobile-menu-list') ,mitems = '' , an,can;
    
    jQuery('.main-menu-wrap .menu').children('li').each(function(){
        an = jQuery(this).children('a');
        mitems += '<li class="clearfix"><a href="'+an.attr('href')+'">'+an.html()+'</a>';

           if( jQuery(this).children('ul.sub-menu').length > 0 )
           {
              mitems += '<span class="ioa-front-icon plus-2icon- sub-menu-toggle"></span><ul class="sub-mobile-menu">';

              jQuery(this).children('.sub-menu').children('li').each(function(){
                  can = jQuery(this).children('a');
                  mitems += '<li class="clearfix"><a href="'+can.attr('href')+'">'+can.html()+'</a>';

                        if( jQuery(this).children('.sub-menu').length > 0 )
                         {
                            mitems += '<span class="ioa-front-icon plus-2icon- sub-menu-toggle"></span><ul class="sub-mobile-menu">';

                            jQuery(this).children('.sub-menu').children('li').each(function(){
                                can = jQuery(this).children('a');
                                mitems += '<li class="clearfix"><a href="'+can.attr('href')+'">'+can.html()+'</a>';


                                 if( jQuery(this).children('.sub-menu').length > 0 )
                                  {
                                      mitems += '<span class="ioa-front-icon plus-2icon- sub-menu-toggle"></span><ul class="sub-mobile-menu">';

                                      jQuery(this).children('.sub-menu').children('li').each(function(){
                                          can = jQuery(this).children('a');
                                          mitems += '<li class="clearfix"><a href="'+can.attr('href')+'">'+can.html()+'</a>';

                                          mitems += '</li>';
                                      });  

                                      mitems += '</ul>';
                                   }

                                mitems += '</li>';
                            });  

                            mitems += '</ul>';
                         }

                  mitems += '</li>';
              });  

              mitems += '</ul>';
           }
           else if( jQuery(this).children('div.sub-menu').length > 0 )
           {

              mitems += '<span class="ioa-front-icon plus-2icon- sub-menu-toggle"></span><ul class="sub-mobile-menu">';

              jQuery(this).children('div.sub-menu').children('div').each(function(){

                    if( jQuery(this).find('h6').length > 0 )
                           mitems += '<li class="clearfix"><h6>'+jQuery(this).find('h6').html()+'</h6>';
                       
                    jQuery(this).find('.sub-menu').children('li').each(function(){
                        can = jQuery(this).children('a');


                           mitems += '<li class="clearfix"><a href="'+can.attr('href')+'">'+can.html()+'</a>';

                        mitems += '</li>';
                    });  



              });

              
              mitems += '</ul>';

           }

        mitems += '</li>';

    });  

    m.html(mitems);
   
    }
    else
    {
      jQuery('.mobile-menu').remove();
    }

if( (window.retina || window.devicePixelRatio > 1) )
{
    var logo = jQuery('#logo img,#mlogo img');

    if( typeof logo.data('retina') != "undefined" && logo.data('retina')!="" )
        logo.attr('src',logo.data('retina'));
}


});


/**
 * Main Code Starts From Here
 */
function main_code(){
 "use strict";



/**
 * Basic Variables Declaration
 */

var DEBUGMODE = false;
var obj,temp,i,j,k,parent,str='',super_wrapper = jQuery('.super-wrapper') , doc = jQuery(document);

/**
 * Window Dimensions Here
 */


var win = {
    obj : jQuery(window),
    width : null,
    height : null

},
responsive = {

    ratio : 1 ,
    width : 1060,
    height : 600 ,
    platform : 'web',
    getPlatform : function()
    {

    }

},
 utils = {

    debug : function(message) {

                if (window.console && window.console.log  && DEBUGMODE )
                   window.console.log('~~ IOA Debug Mode: ' + message);
          },
      elCenter : function(obj){
          
          obj.width(obj.width()+2).css('display','block'); 
        
      },
      exists : function(cl)
      {
          if(bowser.msie && bowser.version < 8)  if(getElementsByClassName(document.body,cl).length > 0 ) return true; else return false;
          

          if(bowser.msie && bowser.version <= 8)
              if(document.querySelectorAll('.'+cl).length > 0 ) return true; else return false;
          else    
              if(  typeof super_wrapper[0] !="undefined" && super_wrapper[0].getElementsByClassName(cl).length > 0 ) return true; else return false;
      },
      existsP : function(cl,parent)
      {
          if(bowser.msie && bowser.version < 8)  if(getElementsByClassName(parent,cl).length > 0 ) return true; else return false;
          

          if(bowser.msie && bowser.version <= 8)
              if(document.querySelectorAll('.'+cl).length > 0 ) return true; else return false;
          else
              if( parent.getElementsByClassName(cl).length > 0 ) return true; else return false;
      }
};

win.width = win.obj.width();
win.height = win.obj.height();

responsive.ratio = jQuery('.skeleton').width()/1060;
responsive.width = win.width;
responsive.height = win.height ;


jQuery('a.rad-ajax-load-more').click(function(e){
    e.preventDefault();
    temp =  jQuery(this);

    temp.find('.progress').transition({ width:"60%" },40000);
    temp.find('.button-content').html(ioa_localize.rad_ajax_loading);

    jQuery.post(ioa_listener_url, { type:'rad-list-widget' , action: 'ioalistener', query :  temp.data('query') , offset : temp.parents('.rad-widget').find('.rad-posts-list li').length },function(data){
          data = jQuery(data);
          
          if(data.hasClass('ioa-end'))
          {
            temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,function(){
              temp.find('.button-content').html(ioa_localize.no_posts);
              temp.delay(2000).slideUp('normal');
            });
            
            return;
          }

          temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,'',function(){
               temp.find('.progress').transition({'opacity':0},300,'',function(){ jQuery(this).css({ width:0 , opacity:1 }); });
               data.css({ 'opacity':0 , scale:0 });
               temp.parents('.rad-widget').find('.rad-posts-list').append(data);
               data.each(function(i){ jQuery(this).delay(i*150).transition({'opacity':1 , scale:1 },300); });
               temp.find('.button-content').html(ioa_localize.load_more);
          });

    });

});


ioapreloader( jQuery('.post_masonry-container'),function(images){
    images.each(function(i){ jQuery(this).delay(i*150).transition({ opacity:1 ,top:0  },300); });
})

jQuery('a.masonry-ajax-load-more').click(function(e){
    e.preventDefault();
    temp =  jQuery(this);

    temp.find('.progress').transition({ width:"60%" },40000);
    temp.find('.button-content').html(ioa_localize.rad_ajax_loading);

    jQuery.post(ioa_listener_url, { type:'rad-masonry-widget' , action: 'ioalistener', query :  temp.data('query') , offset : temp.parents('.rad-widget').find('.post_masonry-container li.hover-item').length },function(data){
          data = jQuery(data);
          
          if(data.hasClass('ioa-end'))
          {
            temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,function(){
              temp.find('.button-content').html(ioa_localize.no_posts);
              temp.delay(2000).slideUp('normal');
            });
            
            return;
          }

          temp.parents('.rad-widget').find('.post_masonry-container').append(data);

          ioapreloader(data,function(){
               
                 temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,'',function(){
                 temp.find('.progress').transition({'opacity':0},300,'',function(){ jQuery(this).css({ width:0 , opacity:1 }); });
                 
                  temp.parents('.rad-widget').find('.post_masonry-container').isotope( 'appended',data  );

                     data.each(function(i){ 
                        jQuery(this).find('img').delay(i*150).transition({'opacity':1, top : 0 },300); 
                        });
                       makeCanvasEffect(data);

                  }); 

                 temp.find('.button-content').html(ioa_localize.load_more);
                 
                 setTimeout(function(){ temp.parents('.rad-widget').find('.post_masonry-container').isotope('layout')  },500);

               });  

    });

});


jQuery('.zoomable').each(function(){
     jQuery(this).zoom({url: jQuery(this).data('src') , duration:300 ,
      onZoomIn : function() { jQuery(this).parent().find('i').fadeOut('normal'); } ,
      onZoomOut : function() { jQuery(this).parent().find('i').fadeIn('normal'); } 
      });
});

/**
 * Background Videos for RAD builder
 */



var video_bg_mod = {

    videos : []

};


if( utils.exists('video-bg')  )
jQuery('.video-bg').each(function(i){

     
        video_bg_mod.videos[i] = { el : new MediaElement(jQuery(this).find('video').attr('id'),
                    { 
                      loop:true, 
                      features : [] , 
                      videoWidth: -1,
                      videoHeight: -1,
                      
                      enableAutosize: false,
                      success: function(mediaElement, domObject) {
                      
                      mediaElement.addEventListener('ended', function(e) {
             
                           mediaElement.play();
                           
                      }, false);

                          mediaElement.pause();
                   }
                  }) , id : jQuery(this).find('video').attr('id') };
       if(bowser.msie && bowser.version > 8 ) 
        jQuery(this).find('video,object').remove();
    });
//jQuery('.lightbox-vid').find('video').attr( 'height' , responsive.height * ( (responsive.width * 0.8)/responsive.width ) + 60 );

jQuery('.self-host-trigger').click(function(e){
    e.preventDefault();

    setTimeout(function(){

      temp =  jQuery('.pp_inline video').mediaelementplayer({
            defaultVideoWidth: 480,
            defaultVideoHeight: 270,
            videoWidth: -1,
            videoHeight: -1,
            audioWidth: 400,
            audioHeight: 30,
            startVolume: 0.8,
            loop: false,
            enableAutosize: true,
            features: ['playpause','progress','current','duration','tracks','volume','fullscreen'],
            alwaysShowControls: false,
            iPadUseNativeControls: false,
            iPhoneUseNativeControls: false, 
            AndroidUseNativeControls: false,
            alwaysShowHours: false,
            showTimecodeFrameCount: false,
            framesPerSecond: 25,
            enableKeyboard: true,
            pauseOtherPlayers: true,
            keyActions: []
         
        });
      setTimeout(function(){ temp[0].play(); },300);
    },500)


});




if(! (bowser.msie && bowser.version > 8) ) 
   jQuery('.video-bg').waypoint(function(){

       

       jQuery('.video-bg').transition({ opacity:1 },300,'',function(){

             for (var i = 0; i<video_bg_mod.videos.length ; i++) {
            
               if(video_bg_mod.videos[i].id ==  jQuery(this).find('video').attr('id'))
               {
                  video_bg_mod.videos[i].el.play();
               }

            };

       });


       

    },{ offset: '70%' , triggerOnce : true });




if(win.width<=767)
    responsive.ratio = (win.obj.width() * 0.7)/1060;

jQuery('a.wpml-lang-selector').click(function(e){
    e.preventDefault();
    var l = jQuery(this).next();

    if(l.is(':hidden'))
    {
        l.css({ opacity:0, marginTop:-10 , display:"block" }).transition({ opacity:1 , marginTop : 0 },400);
    }
    else
    {
        l.transition({ opacity:0 , marginTop : 0 },400,'',function(){
            l.hide();
        });
        
    }
});


jQuery('.live_search').focusin(function(){
    if( jQuery(this).val() == "" || jQuery(this).val() == 'Type something..' ) jQuery(this).val('');
});

jQuery('.live_search').focusout(function(){
    if( jQuery(this).val()=="" ) jQuery(this).val(ioa_localize.search_placeholder);
});


jQuery('.like-icon').each(function(){
   temp = jQuery(this);
   


    if( jQuery.cookie( 'ioa-liked'+temp.data('id')) && typeof jQuery.cookie( 'ioa-liked'+temp.data('id')) !="undefined" ) 
    {
      temp.addClass('liked');
    }
});

/**
 * Mobile Menu
 */


doc.on('click','.mobile-menu',function(e){
e.preventDefault();
  jQuery('.mobile-menu-list').slideToggle('normal');

})

doc.on('click','.sub-menu-toggle',function(){
   jQuery(this).toggleClass('plus-2icon- minus-2icon-');
  jQuery(this).next().slideToggle('normal');

})

/**
 * Like Alogrithm for portfolio items
 */
doc.on('click','.like-icon',function(){
    temp = jQuery(this);
    if(temp.hasClass('liked')) return;
    jQuery.post(ioa_listener_url, { type:'like-portfolio' , action: 'ioalistener', id :  jQuery(this).data('id') },function(data){
           temp.parent().find('.p-counter').html(data); 
           jQuery.cookie( 'ioa-liked'+temp.data('id'),'true');
            temp.addClass('liked');
    });

});

jQuery(".ioa-text-column.iconed-alt").hover(function(){ 
     
     jQuery(this).stop(true,true).find('.front-view').transition({ scale : 0 , opacity : 0 },300);
     jQuery(this).stop(true,true).find('.alt-desc').css({ transform: 'scale(0)' , display : 'block' , opacity : 0 }).transition({ scale : 1 , opacity : 1 },300);
    },function(){ 
     
     jQuery(this).find('.front-view').transition({ scale : 1 , opacity : 1 },300);
     jQuery(this).find('.alt-desc').transition({ scale : 0 , opacity:0 },300,'',function(){
        jQuery(this).hide();
     });
     
    });

  /**
 * Scrollable Code
 */
    var st,sn,sminx,mp=null,swipers = [];
     jQuery('.swiper-container').each(function(i){

         t = jQuery(this).width();
         n = jQuery(this).find('.swiper-slide').width();
         minx = Math.ceil(t/n);
         if( jQuery(this).data('items') &&  jQuery(this).data('items') ) minx = jQuery(this).data('items');
      
        if(responsive.width < 767 && responsive.width > 479)   minx =  2;   
        if(responsive.width < 479)  minx =  1;   



         if( jQuery(this).hasClass('modelie-container') )  
           {
            mp = jQuery(this).swiper({
                mode:'horizontal',
                loop: false,
                slidesPerView: minx,
                grabCursor: true,
                calculateHeight : true,
                scrollbar: {
                                container : '.modelie-scrollbar',
                                draggable : true,
                                hide: false,
                                snapOnRelease: true
                            },
                onImagesReady : function(swiper){
                     jQuery(swiper.container).css({ 'visibility' : 'visible' }).transition({ opacity:1 , height : jQuery(swiper.container).find('img').first().height()-2 },300);
                }
                
            });
             swipers[i] = { el :  mp , obj : jQuery(this) }  ;
           }
           else
           {
              swipers[i] = { el :  jQuery(this).swiper({
                mode:'horizontal',
                loop: true,
                slidesPerView: minx,
                grabCursor: true,
                calculateHeight : true,
                onImagesReady : function(swiper){
                     jQuery(swiper.container).css({ 'visibility' : 'visible' }).transition({ opacity:1 , height : jQuery(swiper.container).find('img').first().height()-2 },300);
                }
              }) , obj : jQuery(this) }  ;
           }

 });



/**
 * Modelie Add More
 */
var current_loader,modelie_list = jQuery('.modelie-posts-wrapper')
doc.on('click','a.add-more-modelie-items',function(e){
        e.preventDefault()
        current_loader = jQuery(this);
        current_loader.html( current_loader.data('loading') );

        jQuery.post(ioa_listener_url,{ type:'portfolio_modelie' , action: 'ioalistener', width : responsive.width , id : current_loader.data('id'), offset : modelie_list.children('div.swiper-slide').length  },function(data){

        

        var test = jQuery(jQuery.trim(data)), newSlide = [];

        if(test.hasClass('no-posts-found'))
        {
           current_loader.html(ioa_localize.no_posts);
           current_loader.delay(1500).fadeOut('fast');
           return;
        }

        test.each(function(i){
          if( jQuery.trim(jQuery(this).html())!="" )
           {
             newSlide[i] = mp.createSlide(jQuery(this).html(),jQuery(this).attr('class'));
             newSlide[i].append() ;

           }

        });

          mp.swipeNext();

         ioapreloader(jQuery(data),function(){

                 makeCanvasEffect(modelie_list);
               
             });
        
        current_loader.html( current_loader.data('load') );
                     

        });

    });
 

/**
 * Maerya
 */

if(utils.exists('portfolio-maerya-list')) 
{

   var Maerya = jQuery('.portfolio-maerya-list'), Maerya_p = Maerya.parent() ,m_childs = Maerya.children(), current_obj , dynamic = jQuery('div.dynamic-content') , close_section = jQuery('.portfolio-maerya-wrap .close-section') , s_w = Maerya_p.width() / m_childs.length ;

   m_childs.width(s_w);
   m_childs.each(function(i){

        jQuery(this).css({ display:'block' , opacity :0 }).delay(i*100).transition({ opacity:1 , top:0 },300);

   });
   Maerya.css("width","2000em");

   dynamic.parent().css("min-height",Maerya.height()+"px");

   m_childs.find('.proxy,.stub').width(s_w);

   m_childs.click(function(e){
      
      if(responsive.width <= 767) return;

      e.preventDefault();
      
      current_obj = jQuery(this);

      current_obj.find('.hover,.stub').fadeOut('fast');

      m_childs.not(current_obj).transition({ width : 0 },500);
      current_obj.transition({ width : Maerya_p.width() },500,'',function(){
          
          current_obj.find('.button').css({ display:'block' , opacity :0, scale: 0 }).delay(i*100).transition({ opacity:1 , scale:1 },200);

      });

      dynamic.hide();
      dynamic.html( current_obj.find('.meta-info').html() );

      dynamic.css({ top: -Maerya.height() , opacity:0 , display:'block' });

      jQuery('.maerya-portfolio-content').transition({ opacity:0 , height:Maerya.height() },300);
      dynamic.transition({ opacity:1 , top:0 },300);

      close_section.fadeIn('fast');

   });
  
  m_childs.hover(function(){

    jQuery(this).find('.hover').transition({ opacity:0.9 , width:s_w },300);

  },function(){

    jQuery(this).find('.hover').transition({ opacity:0, width:0 },300);

  });  

  close_section.click(function(e){
        e.preventDefault(); 

        current_obj.find('.hover,.stub').fadeIn('fast');
        current_obj.find('.button').fadeOut('fast');
        m_childs.transition({ width : Maerya_p.width() / m_childs.length },500);

        dynamic.transition({ opacity:0 , top:Maerya_p.height() },300,'',function(){
           jQuery(this).hide();
        });
        jQuery('.maerya-portfolio-content').transition({ opacity:1 , top:0 },300);
         close_section.fadeOut('fast');


      });

}



/**
 * Header Constructor Code Begins Here
 */


var compact_menu = jQuery('div.compact-bar ul.menu'), compact_bar = jQuery('div.compact-bar'), themeheader = jQuery('.header-cons-area').outerHeight() + jQuery('#bottom_bar_area').height() + 50;
var menus = jQuery('.menu-wrapper');


/**
 * Menu Layout / Effects Builder 
 */

var Menu_builder = {

    center : function(menu)
            {
                var childs = menu.children('li'), width =0;
                childs.each(function(){
    
                    width += jQuery(this).outerWidth()+4+parseInt(jQuery(this).css('margin-right'));
                    });    
                setTimeout(function(){ 
                    
                    if(menu.hasClass('menu'))    
                        {
                            var fz = parseInt(childs.children('a').css('font-size'));
                            menu.parents('.menu-wrapper').width(width+2+(fz*2)).animate({ opacity:1 },'normal'); 
                        }
                    else
                        {
                            menu.width(width+2); menu.animate({ opacity:1 },'normal'); 
                        }


                },30);
            },

    appendMenuTail : function(menu)
            {
                var arrow = '';

                menu.find('li').each(function(){

                    if( jQuery(this).children('.sub-menu').length > 0 )
                    {
                        if(jQuery(this).is(menu.children() )) 
                        {
                            arrow = '<span class="menu-arrow ioa-front-icon down-diricon-"></span>';
                        }
                        else
                        {
                            arrow = '<span class="menu-arrow ioa-front-icon right-diricon-"></span>';
                        }

                        
                         if( jQuery(this).children('div.sub-menu').length > 0 ) 
                           jQuery(this).children('a').append('<span class="menu-tail"><i class="ioa-front-icon up-dir-1icon-"></i></span>'+arrow);
                        else  
                          {
                             jQuery(this).children('a').append('<span class="menu-tail"><i class="ioa-front-icon up-dir-1icon-"></i></span>'+arrow);
                             jQuery(this).children('.sub-menu').children('li').last().addClass('last-child');
                          }
                         

                        if( jQuery(this).children('ul.sub-menu').length > 0 )
                        {
                            jQuery(this).addClass('hasDropDown relative');
                        }
                        else
                        {
                            jQuery(this).addClass('hasDropDown');
                        }

                        jQuery(this).children('.sub-menu').append('<span class="faux-holder"></span>');

                        
                    }
                            
                });



            },

    registerMenuHover : function(menu)
        {
            
            var effect = jQuery('body').data('effect') , sense;
            
            menu.find('li').hover(function(){
                temp = jQuery(this);
                temp.removeClass('forceRightChain');
                
                if(temp.children('.sub-menu').length >0  )
                    sense = ( responsive.width - ( temp.offset().left + temp.width()) - ( 220  ) );        
                  
                
                 if(sense < 0 ) {
                    temp.addClass('forceRightChain');
                    temp.children('ul.sub-menu').find('.menu-arrow').addClass('left-diricon-').removeClass('right-diricon-');
                 }
                 else
                 {
                     temp.children('ul.sub-menu').find('.menu-arrow').addClass('right-diricon-').removeClass('left-diricon-');
                 }


                if( utils.existsP('sub-menu',this)  )
                  {
                        switch(effect)
                        {
                                case 'None' : temp.children('.sub-menu').stop(true,true).show(); break;
                                
                                case 'Fade' : temp.children('.sub-menu').stop(true,true).fadeIn('normal'); break;
                                case 'Fade Shift Down' : 
                                        
                                        temp.children('.sub-menu').css({ 'opacity' : 0 , 'display' : 'block' , marginTop:-10 });
                                        temp.children('.sub-menu').stop(true,true).animate({ opacity:1 , marginTop:0 },300);

                                        break;
                                case 'Fade Shift Right' : 
                                        
                                        temp.children('.sub-menu').css({ 'opacity' : 0 , 'display' : 'block' , marginLeft:-10 });
                                        temp.children('.sub-menu').stop(true,true).transition({ opacity:1 , marginLeft:0 },300);

                                        break;
                                case 'Scale In Fade' : 
                                        
                                        temp.children('.sub-menu').css({ 'opacity' : 0 , 'display' : 'block' , scale:1.2 });
                                        temp.children('.sub-menu').stop(true,true).transition({ opacity: 1 , scale:1});      

                                        break;
                                case 'Scale Out Fade' : 
                                        
                                        temp.children('.sub-menu').css({ 'opacity' : 0 , 'display' : 'block' , scale:0.8 });
                                        temp.children('.sub-menu').stop(true,true).transition({ opacity: 1 , scale:1});      

                                        break;
                                case 'Grow' : temp.children('.sub-menu').stop(true,true).show('normal'); break;
                                case 'Slide' : temp.children('.sub-menu').stop(true,true).slideDown('fast'); break;    
                                default: temp.children('.sub-menu').stop(true,true).fadeIn('normal'); break;                            
                        }
                         temp.find('.menu-tail').fadeIn('normal');
                          
                  }

            },function(){
                if( utils.existsP('sub-menu',this)  )
                  {
                       temp = jQuery(this);
                       switch(effect)
                        {
                                case 'None' : temp.children('.sub-menu').stop(true,true).hide(); break;
                                
                                case 'Fade' : temp.children('.sub-menu').stop(true,true).fadeOut('normal'); break;
                                case 'Fade Shift Down' : 
                                        temp.children('.sub-menu').stop(true,true).transition({ opacity:0 , marginTop:-10 },300, function(){ jQuery(this).hide() });
                                    break;
                            case 'Fade Shift Right' : 
                                        temp.children('.sub-menu').stop(true,true).transition({ opacity:0 , marginLeft:-10 },300, function(){ jQuery(this).hide() });
                                    break;        
                            case 'Scale In Fade' : 
                                        temp.children('.sub-menu').stop(true,true).transition({ opacity: 0, scale:1.2}, 200 ,'', function(){ jQuery(this).hide() });      
                                    break;    
                            case 'Scale Out Fade' : 
                                        temp.children('.sub-menu').stop(true,true).transition({ opacity: 0, scale:0.8}, 200 ,'', function(){ jQuery(this).hide() });      
                                    break;    
                            case 'Grow' : temp.children('.sub-menu').stop(true,true).hide('normal'); break;    
                            case 'Slide' : temp.children('.sub-menu').stop(true,true).slideUp('normal'); break;    
                            default: temp.children('.sub-menu').stop(true,true).fadeOut('normal'); break;                     
                        }
                         temp.find('.menu-tail').stop(true,true).fadeOut('normal');
                        
                      
                              
                  }        

            });
        }                        

}

/**
 * Menu Effects & Stuff
 */


Menu_builder.appendMenuTail(compact_menu);
Menu_builder.registerMenuHover(compact_menu);

if(bowser.msie && bowser.version <= 7 ) jQuery('.icon').removeClass('icon');

Menu_builder.appendMenuTail(jQuery('.theme-header .menu'));
Menu_builder.registerMenuHover(jQuery('.theme-header .menu , div.sidebar-wrap ul.menu'));

setTimeout(function(){
           
                 menus.each(function(){
                    var temp = jQuery(this),posi = jQuery(this).position().left + 2, childs;
                    temp.find('.menu').children('li').each(function(){ 

                         if( jQuery(this).find('div.sub-menu').length > 0 )
                          {
                                childs = jQuery(this).find('div.sub-menu').children('.menu-item');

                                //switch()
                               switch(childs.length)
                               {
                                 case 1 : childs.addClass('m_full'); break;
                                 case 2 : childs.addClass('m_one_half'); break;
                                 case 3 : childs.addClass('m_one_third'); break;
                                 case 4 : childs.addClass('m_one_fourth'); break;
                                 case 5 : childs.addClass('m_one_fifth'); break;
                               }
                                jQuery(this).find('div.sub-menu').css({  
                                     // "width": (childs.width()+1) * childs.length  ,  
                                      "left":-( posi + jQuery(this).position().left )+"px" });
                               //jQuery(this).find('div.sub-menu').children().height( jQuery(this).find('div.sub-menu').height() );

                         }
                     });
            });
            

            if( win.obj.scrollTop() > (themeheader)  )
            {
                jQuery('a.back-to-top').stop(true,true).fadeIn('normal')
                compact_bar.stop(true,true).fadeIn('normal');
            }

            

},80);


if( compact_bar.length > 0 )
{

  ioapreloader( jQuery('#clogo'),function(images){
      var h = compact_bar.height();
      jQuery('#clogo').css('marginTop' , ( h - jQuery('#clogo img').height() )/2+"px" );
       compact_bar.css({ 'display' : 'none' , 'visibility' : 'visible' });
  });



}

win.obj.scroll(function(){
    
    if( win.obj.scrollTop() > (themeheader)  )
    {
        if(compact_bar.is(':hidden'))
        compact_bar.fadeIn('normal');
      jQuery('a.back-to-top').stop(true,true).fadeIn('normal')
    }
    
    if( win.obj.scrollTop() < (themeheader)  )
    {
        if(compact_bar.is(':visible'))
        compact_bar.fadeOut('fast');
      jQuery('a.back-to-top').stop(true,true).fadeOut('normal')
    }

});



/**
 * Ajax Search Code
 */

var search_parent = jQuery('.ajax-search') ,search_loader =  search_parent.find('span.search-loader');

jQuery('.ajax-search-pane input[type=text]').keyup(function(e){
    var val = jQuery(this).val().length;
    
      if (e.keyCode == 27) {  jQuery('a.ajax-search-trigger').trigger('click'); return; } 

    if(val >= 2)
    {
        
        search_loader.fadeIn('fast');
        jQuery.post(search_parent.data('url'), { type:'search' , action: 'ioalistener', query :  jQuery(this).val() },function(data){
            if( jQuery.trim(data) == "" ) return;

            
                search_parent.find('.no-results').fadeOut('fast');
                search_parent.find('.search-results ul').html(data);
                search_parent.find('div.search-results').stop(true,true).fadeIn('fast',function(){ search_loader.fadeOut('fast'); });
            
        });

    }
    else
    {
        search_parent.find('div.search-results').hide();
        search_parent.find('.search-results ul').html('');
        
    }

});


jQuery('a.ajax-search-trigger').click(function(e){
     e.preventDefault();
    temp = jQuery(this).parent().find('div.ajax-search-pane');

    if( temp.is(":hidden") ) { 
        temp.css({ 'opacity' : 0 , 'display' : 'block' , marginTop:-20 });
        temp.stop(true,true).transition({ opacity: 1 , marginTop:0});     
        jQuery('a.ajax-search-trigger').addClass('active');
    }
    else
    {
        temp.stop(true,true).transition({ opacity: 0 , marginTop:-20}, 200 ,'', function(){ jQuery(this).hide() });
        jQuery('a.ajax-search-trigger').removeClass('active');
    }
});

jQuery('a.ajax-search-close').click(function(e){
     e.preventDefault(); 
     jQuery(this).parent().stop(true,true).transition({ opacity: 0 ,  marginTop:-20}, 200 ,'', function(){ jQuery(this).hide() });
     jQuery('a.ajax-search-trigger').removeClass('active');
});


if( jQuery('.video-player').length > 0 )
jQuery('.video-player video').mediaelementplayer({  features : ['playpause','progress','current','duration','tracks','volume','fullscreen'] });

/**
 * Title Effects & Intro
 */


var title_area = jQuery('div.title-wrap') ;
var effect_builder = {

    animate : function(el){ 
            
        switch(el.data('effect'))
        {
            case 'fade' : el.animate({ opacity :1 },400); break;
            case 'fade-left' :
            case 'fade-right' : el.transition({ margin: '0px', opacity: 1 , duration: 500 }); break;

            case 'rotate-left' :  el.css({ rotate : '-40deg' }).transition({  opacity : 1 , rotate: '0deg'  },400); break;
            case 'rotate-right' : el.css({ rotate : '40deg' }).transition({  opacity : 1 , rotate: '0deg'  },400); break;

            case 'scale-in' :  el.css({ scale : 1.6 }).transition({  opacity : 1 , scale: 1  },400); break;
            case 'scale-out' : el.css({ scale : 0.3 }).transition({  opacity : 1 , scale: 1  },400); break;


        }    
            
    }

}

jQuery('.social-toggle').mouseover(function(){

    jQuery(this).parents('.top-social-area-wrap ').find('ul.next-level-si').fadeIn('normal');

 });
var st = setTimeout(function(){});
jQuery('.top-social-area-wrap').mouseleave(function(){
    jQuery(this).find('ul.next-level-si').fadeOut('normal');
 });

if( title_area.length > 0 )
{
    jQuery(window).load(function(){     

      effect_builder.animate(jQuery('.title-block'));

    }); 
}    

/**
 * Shortcodes Coding Starts Here ===================================
 */


jQuery('.cta_button').hover(function(){
  
  if(jQuery(this).find('.cta-icon').length == 0 || responsive.width < 767 ) return;

   jQuery(this).find('.cta-icon').css({ display : 'block' , opacity : 0, right:0 }).transition({ opacity : 1 , right:17 },300);
   jQuery(this).find('.cta-button-label').transition({ left : -17  },300);
},function(){
   jQuery(this).find('.cta-icon').transition({  opacity : 0 , right: 0 },300,'',function(){
     jQuery(this).hide();
   });
   jQuery(this).find('.cta-button-label').transition({ left : 0  },300);
});


jQuery('div.posts_slider div.slide').hover(function(){
     
     jQuery(this).children('div.desc').fadeIn('normal');
 
},function(){

    jQuery(this).children('div.desc').fadeOut('normal');
});


/**
 * Tabs Shortcode
 */

jQuery('div.ioa_box a.close').click(function(e){
    e.preventDefault();
    jQuery(this).parent().parent().slideUp('normal',function(){ jQuery(this).remove(); })
});

if( utils.exists('ioa_tabs') ) { 

jQuery( ".ioa_tabs" ).each(function(){
    temp = jQuery(this);
    temp.tabs({ show : { effect: "fadeIn", duration: 300 } })

    if( utils.exists('tabs-align-left') || utils.exists('tabs-align-right') )
    temp.css( "min-height" ,  ( (temp.find('ul li').outerHeight()) *  temp.find('ul li').length)+"px" );
});

 }
if( utils.exists('ioa_accordion') ) { jQuery( ".ioa_accordion" ).accordion({
     create: function( event, ui ) { ui.header.find('i').addClass('minus-2icon-').removeClass('plus-2icon-') },
     beforeActivate: function( event, ui ) { 
         ui.newHeader.find('i').removeClass('plus-2icon-').addClass('minus-2icon-');
         ui.oldHeader.find('i').addClass('plus-2icon-').removeClass('minus-2icon-');
      },
     heightStyle: "content"
}); }


function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return "rgba("+parseInt(result[1], 16)+","+parseInt(result[2], 16)+","+parseInt(result[3], 16)+",0.6)";
   
}



win.obj.load(function(){

    jQuery('.top-layered-slider').css('min-height','0');
    registerHoverEffect();   


});

jQuery('.social-set li').hover(function(){
   obj = jQuery(this);
    obj.find('.social-tooltip').css({ scale :0.5 , display : "block" , opacity: 0 }).transition({ opacity:1 , scale :1 },200);
    
    obj.find('.visible-block').stop(true,true).transition({ marginTop: - obj.find('a').height() },300);
},function(){
   obj = jQuery(this);
    
    obj.find('.social-tooltip').transition({ opacity:0 ,scale :0.5 },200,'',function(){
       jQuery(this).hide();
    });

    obj.find('.visible-block').stop(true,true).transition({ marginTop: 0 },300);

});

win.obj.load(function(){
    var max = 0;
    jQuery('.logo-area').each(function(){

        max = 0;
        jQuery(this).find('li').each(function(){
            if( jQuery(this).height() > max ) max = jQuery(this).height();
        });
        jQuery(this).find('li .inner-logo-item').css({ "min-height":max+"px" ,"opacity" : 1  });

    }); 

});

jQuery('.logo-area  li , .logo-scrollable div.slide ').hover(function(){
   obj = jQuery(this);
    obj.find('.logo-tooltip').css({ marginTop : -15 , display : "block" , opacity: 0 }).transition({ opacity:1 , marginTop : 0 },200);
    obj.find('img').stop(true,true).transition({ opacity:0.7  },300);

},function(){
   obj = jQuery(this);
    obj.find('.logo-tooltip').transition({ opacity:0 , marginTop : -15 },200,'',function(){
       jQuery(this).hide();
    });
    obj.find('img').stop(true,true).transition({ opacity:1  },300);

});



if( utils.exists('toggle-title') ) { 

    jQuery('a.toggle-title').click(function(e){
        e.preventDefault();
        if( jQuery(this).next().is(':hidden') )
        {
           jQuery(this).addClass('title-active');
           jQuery(this).children('i').addClass('minus-squaredicon-').removeClass('plus-squaredicon-');
           jQuery(this).next().slideToggle('normal');
        }
        else
        {
           
            jQuery(this).children('i').removeClass('minus-squaredicon-').addClass('plus-squaredicon-');   
            jQuery(this).next().slideToggle('normal');
            jQuery(this).removeClass('title-active');

        }

    });

 }

jQuery('a.ioa-button').hover(function(){
    jQuery(this).children('span.underlay').stop(true,true).fadeIn('normal');
},function(){
    jQuery(this).children('span.underlay').stop(true,true).fadeOut('normal');
});


/**
 * Gallery
 */

if(  utils.exists('ioa-gallery') ) 
{
    jQuery('.ioa-gallery').seleneGallery({ domMapping : true });
}
 

/**
 * Slider
 */



if(  utils.exists('ioaslider') ) 
{
     jQuery('.ioaslider').quartzSlider({ domMapping : true });
}

if(  utils.exists('quantumslider') ) 
{
     jQuery('.quantumslider').quantumSlider({ domMapping : true });
}

/**
 * One Page Template System
 */ 

var rf = 0;

if(utils.exists('compact_bar')) rf = 50;
var one_page_menu = jQuery('.rad-one-page-menu li') , scroll_v = true;
one_page_menu.first().addClass('active');
jQuery('.rad-one-page-menu li a').click(function(e){
    if( jQuery(this).parent().hasClass('one-external') ) return;
    e.preventDefault();

    scroll_v = false;
    one_page_menu.removeClass('active');
    jQuery(this).parent().addClass('active');
    jQuery('html,body').animate({ scrollTop : jQuery( jQuery(this).attr('href') ).offset().top - (55+rf) },{ duration:400 , easing : 'easeInQuad' , complete: function(){ scroll_v = true;  } });

});

jQuery('.one-page-select-wrap select').change(function(e){
    e.preventDefault();

     if( jQuery(this).val().indexOf('rps') > 0 )
     {



    scroll_v = false;
    one_page_menu.removeClass('active');
    jQuery('html,body').animate({ scrollTop : jQuery( jQuery(this).val() ).offset().top - (55+rf) },{ duration:400 , easing : 'easeInQuad' , complete: function(){ scroll_v = true;  } });
    }
    else
    {
       window.location.href = jQuery(this).val();
    }

});


    jQuery('.rad-holder').children('p').remove(); 

if( jQuery(".rad-one-page-menu-wrap").length > 0 )
{
   
   jQuery('.compact-bar').remove();
   jQuery('.page-section').waypoint(function(){

    if( scroll_v == true ) {
      one_page_menu.removeClass('active');
      one_page_menu.filter('.one-'+jQuery(this).attr('id')).addClass('active');
    }

    },{ offset: '0%'  });

    

}

if( jQuery('.variations select').length > 0 )
{

  win.obj.load(function(){


          var pr_attr = jQuery('.variations_form').data('product_variations');

          jQuery('.single-image').data('dimg', jQuery('.single-image img').attr('src') );
          

            temp = jQuery('.variations select').val();

              if(temp=='')
              {
                    jQuery('.single-image img').attr('src' ,    jQuery('.single-image').data('dimg') );
                  return;
              }

            jQuery.each(pr_attr,function(d,obj){

                 if(temp == obj.attributes.attribute_fs)
                 {
                          jQuery('.single-image img').attr('src',obj.image_link);
                 }

            });

          jQuery('.variations select').change(function(){
                  temp = jQuery(this).val();

                  if(temp=='')
                  {
                        jQuery('.single-image img').attr('src' ,    jQuery('.single-image').data('dimg') );
                      return;
                  }

                jQuery.each(pr_attr,function(d,obj){

                     if(temp == obj.attributes.attribute_fs)
                     {
                              jQuery('.single-image img').attr('src',obj.image_link);
                     }

                })

           });  
            

  });


}


if(jQuery('#wpadminbar').length >0) rf = 32;

jQuery(".rad-one-page-menu-wrap").sticky({topSpacing:0+rf});


jQuery('div.sticky-contact a.trigger').click(function(e){
        e.preventDefault();

        if( jQuery('div.sticky-contact').offset().left > responsive.width -50 )
        {
            jQuery('div.sticky-contact').transition({ right:0 },400);
        }    
        else
        {
            jQuery('div.sticky-contact').transition({ right:-301 },400);
            jQuery('div.sticky-contact').parent().find('.error-note').transition({ opacity:0 },300,'',function(){
                    jQuery(this).css('visibility','hidden');
                });

        }

    });
 
/**
 * Scrollable
 */
var bxsliders = [];

if(  utils.exists('scrollable') ) 
{
    var t,n,minx,m;
     jQuery('.scrollable').each(function(i){
         m = 20;

         if(typeof jQuery(this).data('margin') != "undefined") m = jQuery(this).data('margin');
         
         t = jQuery(this).parent().width();
         n = jQuery(this).children().outerWidth()+20;
         minx = Math.ceil(t/n);
        bxsliders[i] = jQuery(this).bxSlider({
        slideWidth: n,
        maxSlides:minx,
        moveSlides : minx,
        infiniteLoop : false,
        slideMargin:  m,
        pager : false
        }).css({ "overflow":"visible", "opacity":1 });

     });
}

jQuery(document).on('mouseenter','.bx-wrapper',function(){
        
        jQuery(this).find('.bx-controls ').stop(true,true).transition({opacity:1},400);
        
    });
jQuery(document).on('mouseleave','.bx-wrapper',function(){

        
        jQuery(this).find('.bx-controls ').stop(true,true).transition({opacity:0},400);
        
    });

/**
 * Magic Lists
 */

if(utils.exists('magic-list-wrapper'))
{
    var hf = 0,line;
    win.obj.load(function(){

        jQuery('.magic-list-wrapper').each(function(){
            hf = 0;
            line = jQuery(this).children('.line');
            jQuery(this).find('li').each(function(i){

                if( jQuery(this).next().length > 0 ) hf += jQuery(this).outerHeight(true); 

                temp =jQuery(this).children('div.icon-area');
                temp.delay(i*200).transition({ opacity:1 , scale: 1 , backgroundColor : temp.data('color') },500);
            });

        });

    });
}    


/**
 * Testimonials 
 */


if( utils.exists('rad-testimonials-list')  )
{
     

     jQuery('ul.rad-testimonials-list').bxSlider({
        mode : 'fade',
        adaptiveHeight : true,
           
           pager : true, auto : true , controls:false
        });

}


/**
 * Easy Chart
 */
var w;
if( utils.exists('radial-chart') )
{
    
    jQuery('.radial-chart').each(function(){
        w = jQuery(this).data('width');
        if( w > jQuery(this).parent().width() ) w = jQuery(this).parent().width() - 20;
        
        if(jQuery(this).data('bar_color') != "")
          temp = jQuery(this).data('bar_color');
        else
          temp = jQuery(this).css('color');

        jQuery(this).easyPieChart({
            size : w ,
            lineWidth : jQuery(this).data('size'),
            barColor : temp,
            trackColor :  "rgba(0,0,0,0.05)",
            scaleColor : false,
            lineCap : "butt",
            animate : 2000
        }).data('easyPieChart').update(0);

    });

    jQuery('.radial-chart').waypoint(function(){

        jQuery(this).data('easyPieChart').update(jQuery(this).data('start_percent'));

    },{ offset: '70%' , triggerOnce : true });

}

/**
 * Counter
 */


if( utils.exists('counter') )
{
    
    jQuery('.counter').waypoint(function(){

       jQuery(this).numinate({
              from: jQuery(this).data('start'),
              to: jQuery(this).data('end'),
              runningInterval: jQuery(this).data('time'),
              stepUnit: jQuery(this).data('step'),
              onStop: function(elem) {
               
                
              },
              onComplete: function(elem) {
                
              }
            });

    },{ offset: '70%' , triggerOnce : true });

}


/**
 * Progress Bar
 */

if( utils.exists('progress-bar-group') )
{
        
        

        win.obj.load(function(){
        
        jQuery('.progress-bar-group').waypoint(function(){

        jQuery(this).find('div.progress-bar').each(function(i){
            
                jQuery(this).find('div.filler').delay(i*100).transition({ opacity:1 , width :  parseInt(jQuery(this).find('div.filler').data('fill'))+"%"  },1500,'easeInOutQuint',function(){

                    jQuery(this).children('span').css({ opacity : 0 , scale : 0 , display : "block" }).transition({ opacity : 1 , scale : 1 },400);
                });
            });

            },{ offset: '70%' , triggerOnce : true });

            
        });
}

/**
 * Single Portfolio & Post Relative Switcher
 */
jQuery('div.related-menu .related-list>li').click(function(){
    jQuery('div.related-menu .related-list>li').removeClass('active');
    jQuery(this).addClass('active');

    temp = jQuery(this).data('val');
    
    jQuery('div.related-posts-wrap ul.single-related-posts').not("."+temp).transition({ opacity:0 , scale: 0 },300,'',function(){  jQuery(this).css({ visibility : "hidden" , opacity:0 }) });
    jQuery("div.related-posts-wrap ul.single-related-posts."+temp).css({ visibility : "visible" , opacity:0 , scale:0 }).transition({ opacity:1 , scale: 1 },300);
});


/**
 * Blog Formats Coding
 */
var iso_posts;

jQuery('.ioa-menu ul li.has-filter').click(function(){
    temp = jQuery(this).data('cat');
      jQuery(this).parents('div.ioa-menu').find('li').removeClass('active');
    jQuery(this).addClass('active');
    iso_posts = jQuery(this).parents('.iso-parent').find('.isotope');
    if( iso_posts.length > 0 )
    {
        if(temp == "all")
        {
            iso_posts.isotope({  filter : "*"  });
        }
        else
        {
            iso_posts.isotope({  filter : ".category-"+temp  }); 
        }

       setTimeout(function(){ iso_posts.isotope('layout'); },400);
        return; 
    }
    
});

win.obj.load(function(){
     
     

     if(  location.href .indexOf('portfoliocat')  )
     {
             temp = location.href.split('portfoliocat='); 
             jQuery('.ioa-menu').find('.'+temp[1]).trigger('click');
     } 

     if(responsive.width > 767 )
     {

        var iso_opts,gutter; 

       jQuery('.isotope').each(function(){
          gutter = jQuery(this).data('gutter');
          if(gutter == "50" && responsive.width <=1024 ) gutter = 30;
          
          iso_opts = {  itemSelector :'.isotope li.iso-item ' , layoutMode : 'cellsByRow', cellsByRow : { gutter:gutter  } };
          
          
          if( jQuery(this).data('layout') && jQuery(this).data('layout') =='masonry' )
             iso_opts = {  itemSelector :'.isotope li.iso-item ' , layoutMode : 'masonry' , masonry : { gutter:gutter  } };

          jQuery(this).isotope(iso_opts);
          jQuery(this).data('iso',true);

       });    

       setTimeout(function(){

         jQuery('.isotope').each(function(){
          jQuery(this).isotope('layout');
         });

       },500);
     } 
    
    
     if(bowser.msie && bowser.version <= 8) 
       jQuery('div.portfolio-columns ul li.iso-item .inner-item-wrap').css({ opacity:1 ,top:0  });
     else 
       jQuery('div.portfolio-columns ul li.iso-item').each(function(i){
           jQuery(this).find('.inner-item-wrap').delay(i*150).transition({ opacity:1 ,top:0  },300);
       }); 

});


ioapreloader( jQuery('.portfolio-masonry  .portfolio_posts'),function(images){
    jQuery('.portfolio-masonry  .inner-item-wrap').each(function(i){ jQuery(this).delay(i*150).transition({ opacity:1 ,top:0  },300); });
})

jQuery('a.portfolio-masonry-load-more').click(function(e){
    e.preventDefault();
    temp =  jQuery(this);

    temp.find('.progress').transition({ width:"60%" },40000);
    temp.find('.button-content').html(ioa_localize.rad_ajax_loading);

    jQuery.post(ioa_listener_url,{ type:'portfolio_masonry_block' , action: 'ioalistener', id : jQuery(this).data('id'), offset : jQuery('ul.portfolio_posts').children('li').length },function(data){

          data = jQuery(data);
          
          if(data.hasClass('ioa-end'))
          {
            temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,function(){
              temp.find('.button-content').html(ioa_localize.no_posts);
              temp.delay(2000).slideUp('normal');
            });
            
            return;
          }

         
          data.find('.ioaslider').quartzSlider({ domMapping : true });

           data.find("a[data-rel]").each(function(){ 
            jQuery(this).attr("rel",jQuery(this).data('rel'));
         });
         data.find("a[rel^='prettyPhoto']").prettyPhoto({ social_tools:'' , theme: jQuery('body').data('lightbox_theme') });

          ioapreloader(data,function(){
               
                 temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,'',function(){
                 temp.find('.progress').transition({'opacity':0},300,'',function(){ jQuery(this).css({ width:0 , opacity:1 }); });
                 
                 makeCanvasEffect(data);

                 jQuery('ul.portfolio_posts').append(data);
                 jQuery('ul.portfolio_posts').isotope( 'appended',data  );

                 setTimeout(function(){
                     data.each(function(i){ 
                        jQuery(this).find('.inner-item-wrap').delay(i*100).transition({'opacity':1, top : 0 },300); 
                        });


                 },1000);

                 win.obj.trigger('resize');   
                   

                  }); 

                 temp.find('.button-content').html(ioa_localize.load_more);

               });  

    });

});



jQuery('.load-more-button').click(function(e){
    e.preventDefault();

    jQuery.post(ioa_listener_url,{ type:'portfolio_block' , action: 'ioalistener', id : jQuery(this).data('id'), offset : jQuery('ul.portfolio_posts').children('li').length },function(data){

            temp = jQuery(data);

            if(temp.hasClass('ioa-end'))
            {
                jQuery('.load-more-button').html(ioa_localize.no_posts);
                jQuery('.load-more-button').delay(2000).slideUp('normal');
                return;
            }
            
            jQuery('ul.portfolio_posts').append(temp);
           

            ioapreloader(temp,function(){
                 jQuery('ul.portfolio_posts').isotope( 'appended',temp  );
            });  

         });

    });

if( utils.exists('masonry-block') )
{
   var testable = (responsive.width-80) / 5 -  40;

   if( jQuery('.inner-super-wrapper').hasClass('ioa-boxed-layout') )
     testable = (jQuery('.skeleton').width())/4;

   if(responsive.width > 1024 && testable < 300  ) 
   {
       testable = 300 ;
   }

   if(responsive.width <= 1024 && responsive.width > 767  ) 
   {
       testable = (responsive.width-80) / 3 -  40 ;
   }
   if(responsive.width < 767 && responsive.width > 400  ) 
   {
       testable = (responsive.width) / 2 -  40 ;
   }
   if(  responsive.width <= 400  ) testable = responsive.width-20;

    jQuery('ul.blog_posts>li').width(  testable  );

ioapreloader( jQuery('.blog_posts'),function(images){
    jQuery('ul.blog_posts>li').each(function(i){ jQuery(this).find('.inner-post-wrap').delay(i*150).transition({ opacity:1 ,top:0  },300); });
})

jQuery('a.masonry-load-more').click(function(e){
    e.preventDefault();
    temp =  jQuery(this);

    temp.find('.progress').transition({ width:"60%" },40000);
    temp.find('.button-content').html(ioa_localize.rad_ajax_loading);

     jQuery.post(ioa_listener_url,{ type:'masonry_block' , action: 'ioalistener', id : jQuery(this).data('id'), offset : jQuery('ul.blog_posts').children('li').length ,  width :  testable  },function(data){

          data = jQuery(data);
          data.width(testable);
          if(data.hasClass('ioa-end'))
          {
            temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,function(){
              temp.find('.button-content').html(ioa_localize.no_posts);
              temp.delay(2000).slideUp('normal');
            });
            
            return;
          }

         jQuery('ul.blog_posts').append(data);

         data.find("a[data-rel]").each(function(){ 
            jQuery(this).attr("rel",jQuery(this).data('rel'));
         });
         data.find("a[rel^='prettyPhoto']").prettyPhoto({ social_tools:'' , theme: jQuery('body').data('lightbox_theme') });

          ioapreloader(temp,function(){
               
                 temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,'',function(){
                 temp.find('.progress').transition({'opacity':0},300,'',function(){ jQuery(this).css({ width:0 , opacity:1 }); });
                 
                 makeCanvasEffect(data);
                 jQuery('ul.blog_posts').isotope( 'appended',data  );

                 setTimeout(function(){
                     data.each(function(i){ 
                        jQuery(this).find('.inner-post-wrap').delay(i*100).transition({'opacity':1, top : 0 },300); 
                        });

                 },1000);   
                   

                  }); 

                 temp.find('.button-content').html(ioa_localize.load_more);

               });  

    });

});



}

/**
 * All formats common codes
 */


jQuery('div.widget-posts-grid div.image').hover(function(){
   obj = jQuery(this);
    obj.find('h3').css({ bottom : 70 , display : "block" , opacity: 0 }).transition({ opacity:1 , bottom : 60 },200);

},function(){
   obj = jQuery(this);
    obj.find('h3').transition({ opacity:0 , bottom : 70 },200,'',function(){
       jQuery(this).hide();
    });
});

if(utils.exists('way-animated') && responsive.width > 767 )
{
   
    jQuery('.way-animated').waypoint(function(dir) {
      
      if(dir=="down")
      {
          
          var temp = jQuery(this) , effect = temp.data('effect'),delay = 0;
          
          if(typeof  temp.data('delay') != "undefined") delay = parseFloat( temp.data('delay')) * 1000;

          if(bowser.msie && bowser.version <= 8) effect = 'fade';

          switch(effect)
          {
              case 'fade-left' : temp.css({ x : -30  }).delay(delay).transition({  opacity:1, x:0 },400); break;
              case 'fade-right': temp.css({ x : 30  }).delay(delay).transition({  opacity:1, x:0 },400); break;
              case 'fade-top' :temp.css({ y : -30  }).delay(delay).transition({  opacity:1, y:0 },400); break;
              case 'fade-bottom': temp.css({ y : 30  }).delay(delay).transition({  opacity:1, y:0 },400); break;

              case 'big-fade-left' : temp.css({ x : -100  }).delay(delay).transition({  opacity:1, x:0 },700); break;
              case 'big-fade-right': temp.css({ x : 100  }).delay(delay).transition({  opacity:1, x:0 },700); break;
              case 'big-fade-top' :temp.css({ y : -100  }).delay(delay).transition({  opacity:1, y:0 },700); break;
              case 'big-fade-bottom': temp.css({ y : 100  }).delay(delay).transition({  opacity:1, y:0 },700); break;
              
              case 'scale-in' :temp.css({ scale : 1.5  }).delay(delay).transition({  opacity:1, scale:1 },400); break;
              case 'scale-out' :temp.css({ scale : 0.5  }).delay(delay).transition({  opacity:1, scale:1 },400); break;
              case 'icon-animate' :temp.find('i.ioa-front-icon').css({ top : -10 , opacity:0  }).delay(delay).transition({  opacity:1, top:0 },300); break;

              case 'fade' :
              default : temp.delay(delay).transition({  opacity:1 },400);
          }

      }

    },{ offset: '70%' , triggerOnce : true});
}

if(utils.exists('chain-animated'))
{
   
    jQuery('.chain-animated').waypoint(function(dir) {
      
      if(dir=="down")
      {
          
          var effect = jQuery(this).data('chain'),delay = 0;
          
          if(bowser.msie && bowser.version <= 8) 
          {
              jQuery(this).find('.chain-link').css("opacity",1); return;
          }    

          jQuery(this).find('.chain-link').each(function(i){
              delay = i * 100;
              obj = jQuery(this);
              switch(effect)
              {
                  case 'fade-left' : obj.css({ x : -30  }).delay(delay).transition({  opacity:1, x:0 },400); break;
                  case 'fade-right': obj.css({ x : 30  }).delay(delay).transition({  opacity:1, x:0 },400); break;
                  case 'fade-top' :obj.css({ y : -30  }).delay(delay).transition({  opacity:1, y:0 },400); break;
                  case 'fade-bottom': obj.css({ y : 30  }).delay(delay).transition({  opacity:1, y:0 },400); break;

                  case 'big-fade-left' : obj.css({ x : -100  }).delay(delay).transition({  opacity:1, x:0 },700); break;
                  case 'big-fade-right': obj.css({ x : 100  }).delay(delay).transition({  opacity:1, x:0 },700); break;
                  case 'big-fade-top' :obj.css({ y : -100  }).delay(delay).transition({  opacity:1, y:0 },700); break;
                  case 'big-fade-bottom': obj.css({ y : 100  }).delay(delay).transition({  opacity:1, y:0 },700); break;
                  
                  case 'scale-in' :obj.css({ scale : 1.5  }).delay(delay).transition({  opacity:1, scale:1 },400); break;
                  case 'scale-out' :obj.css({ scale : 0.5  }).delay(delay).transition({  opacity:1, scale:1 },400); break;
                  case 'icon-animate' :obj.find('.ioa-icon-area').css({ scale : 0.5  }).delay(delay).transition({  opacity:1, scale:1 },400); break;
                  case 'fade' :
                  default : obj.delay(delay).transition({  opacity:1 },400);
              }

          });

      }

    },{ offset: '80%' , triggerOnce : true});
}


jQuery('.bx-wrapper .bx-controls-direction a').click(function(e){
    e.preventDefault();
});


jQuery('.hover-col-layout').hover(function(){
    jQuery(this).find('.desc').fadeIn('normal');
},function(){
    jQuery(this).find('.desc').fadeOut('normal');

});


jQuery('div.portfolio-list ul li').waypoint(function() {
  
   var c = jQuery(this).find('div.proxy-datearea');
   var p = jQuery(this).prev();

   c.transition({ height:101 },900);

},{ offset: '70%' , triggerOnce : true });

/**
 * Pagination code
 */

jQuery('div.pagination-dropdown select').change(function(){

    window.location.href = jQuery(this).val();
});


/**
 * Contact Template
 */

jQuery('a.trigger-address').click(function(e){
    e.preventDefault();
    jQuery('.main-address').fadeToggle('normal');
    jQuery(this).toggleClass('minus-2icon- plus-2icon-');

});


var portfolio_posts = super_wrapper.find('.portfolio_posts');

if(win.width <= 1024)
{
    jQuery('.theme-header .menu a').on('click touchend', function(e) {
    var el = jQuery(this);
    var link = el.attr('href');
    if(link==="#" || link==="http://#" || el.parent().children('.sub-menu').length > 0 ) return;
    window.location = link;
    });
}

jQuery('div.ioa-menu ul li').on('touchend', function(e) {
    jQuery(this).trigger('click');
});



/**
 * Contact Full Screen 
 */

if(utils.exists('ioa-template-contact-full-screen-page'))
{
   jQuery('.map-wrapper').css('height', (responsive.height)+"px"  );
}


/**
 * Back to Top Button
 */


jQuery('a.back-to-top').click(function(e){ e.preventDefault(); jQuery('body,html').animate({ scrollTop:0 },'normal');  });

if( jQuery("a[rel^='prettyPhoto']").length > 0  )
jQuery("a[rel^='prettyPhoto'],.lightbox").prettyPhoto({ social_tools:'' , theme: jQuery('body').data('lightbox_theme') });


/**
 * Single Portfolio Coding
 */

if(utils.exists('single-prop-screen-view-pane'))
{

    var fsview_pane = jQuery('div.single-prop-screen-view-pane');
    var calc_height = win.height - ( jQuery('div.header-cons-area').height()) ;
    if(calc_height<200) calc_height = 250;

    jQuery.post(ioa_listener_url,{ type:'single_portfolio_fullscreen', action: 'ioalistener' , id: jQuery('.single-prop-screen-view-pane').data('id') , height : calc_height - 83 , width : win.width },function(data){

        fsview_pane.append(data);
        fsview_pane.find('.ioa-gallery').seleneGallery({ domMapping : true });

    })


}




if( jQuery('.tweets-wrapper.slider ul').length > 0 )
jQuery('.tweets-wrapper.slider ul').bxSlider({
        mode : 'fade',
        adaptiveHeight : true,
           
           pager : true, auto : true , controls :false
        });



win.obj.on("debouncedresize", function( event ) {
   responsive.ratio = jQuery('.skeleton').width()/1060;
    responsive.width = win.obj.width();
    responsive.height = win.obj.height();
    if(responsive.width<767)
        {
            responsive.ratio = (win.obj.width() * 0.7)/1060;
            
        }
    resizable();
});

window.onorientationchange = function(){
    responsive.ratio = jQuery('.skeleton').width()/1060;
    responsive.width = win.obj.width();
    responsive.height = win.obj.height();
    if(responsive.width<767)
        {
            responsive.ratio = (win.obj.width() * 0.7)/1060;
            
        }
    resizable();
    setTimeout(function(){ resizable();  },150);
};



var month , offset = jQuery('div.timeline-post').length , position , tesfl , circle = jQuery('span.circle');
var post_type =  jQuery("span.circle").data('post_type') , line = jQuery('span.line') ;
var offset_line = 0 , distance =0;

if( utils.exists('timeline-post') )
{

     offset = jQuery('div.timeline-post').length;
     offset_line = line.position().left ;
    
    

    circle.waypoint(function(direction) {
       if(direction=="down")
       {

           if( jQuery('.post-end').length>0 ) return;
                   

            circle.transition({ opacity:1 },400);
                month = jQuery('div.posts-timeline').find('h4.month-label').last();
                         
                offset =   jQuery('div.timeline-post').length;
                 jQuery.post(ioa_listener_url,{ type :'posts-timeline', action: 'ioalistener', id : circle.data('id') , post_type : post_type , offset : offset , month:month.data('month')},function(data){
                  
                  jQuery('span.circle').transition({ opacity:0 },400);
                  temp = jQuery(jQuery.trim(data));
                  

                 jQuery('div.posts-timeline').append(temp);

                 temp.find(".lightbox").prettyPhoto({ social_tools:'' , theme: jQuery('body').data('lightbox_theme') });

                 offset =   jQuery('div.timeline-post').length;
                 jQuery.waypoints('refresh');

                 ioapreloader(temp,function(images){
                       makeCanvasEffect( temp );
                  });


                 

                });

       }

    },{ offset: 'bottom-in-view' });

}

if(jQuery('.not-found-teaser').length > 0)
 {
    win.obj.load(function(){

         jQuery('.not-found-teaser span').each(function(i){

              jQuery(this).delay(i*150).css({ scale : 0 }).transition({    scale :1 , opacity:1 },300,'easeOutBack');

         }); 

    });
 }

jQuery('.proxy-search').click(function(e){
  jQuery(this).prev().trigger('click');
  e.preventDefault();
});

/**
 * BBPRESS
 */

 jQuery('.set-status').click(function(e){
    e.preventDefault();
    temp = jQuery(this);
    temp.html('Setting');

    jQuery.post(ioa_listener_url,{ type:'bbpress_setstatus' , action: 'ioalistener', id : jQuery(this).data('id'), status : jQuery(this).prev().val() },function(data){
        temp.html('Done');
        setTimeout(function(){ temp.html('Set Status'); },2000);
    });

 
 });


/**
 * Woo Commerce Code
 */
var button_parent;
jQuery('body').bind('adding_to_cart',function(evt,button){
  
  button_parent = button.parents('.product,.iso-item');
  button.fadeOut('fast');
  button_parent.find('.cart-loader').css({ marginTop : -18 , opacity : 0 , display : 'block' }).transition({ marginTop :0 , opacity: 1 },300,'');
  button_parent.find('.product-data').transition({ opacity:0.6 },400);

})

jQuery('.product .seleneGallery').hover(function(){
   jQuery(this).find('.ioa-lightbox-icon').css({ scale : 0 , opacity : 0 , display : 'block' }).transition({ scale :1 , opacity: 1 },300,'');
},function(){
  jQuery(this).find('.ioa-lightbox-icon').transition({ scale :0 , opacity:0 },300,'');
});

jQuery('.ajax-cart-trigger').click(function(e){
    e.preventDefault();
});

win.obj.load(function(){
   


  jQuery.waypoints('refresh');
  jQuery('.show_review_form').unbind('click');
  jQuery('.show_review_form').click(function(e){
    e.preventDefault();
    jQuery('body').css('overflow','hidden');
    jQuery('#review_form_wrapper').css({ marginTop : -18 , opacity : 0 , display : 'block' }).transition({ marginTop :0 , opacity: 1 },300,'',function(){

         jQuery('.close-review-lightbox').css({ scale : 0 , opacity : 0 , display : 'block' }).transition({ scale :1 , opacity: 1 },300,'');

    });
    

});

});

 jQuery('.close-review-lightbox').click(function(e){
    e.preventDefault();
    jQuery('body').css('overflow','auto');

      jQuery('#review_form_wrapper,.close-review-lightbox').transition({ marginTop :-18 , opacity: 0 },300,'',function(){
         jQuery(this).hide();
      });


 });


jQuery('a.product-masonry-load-more').click(function(e){
    e.preventDefault();
    temp =  jQuery(this);

    temp.find('.progress').transition({ width:"60%" },40000);
    temp.find('.button-content').html(ioa_localize.rad_ajax_loading);

    jQuery.post(ioa_listener_url,{ type:'product_masonry_block' , action: 'ioalistener', id : jQuery(this).data('id'), offset : jQuery('ul.portfolio_posts').children('li').length },function(data){

          data = jQuery(data);
          
          if(data.hasClass('ioa-end'))
          {
            temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,function(){
              temp.find('.button-content').html(ioa_localize.no_posts);
              temp.delay(2000).slideUp('normal');
            });
            
            return;
          }

          data.width( responsive.width/4 );
          data.find('.ioaslider').quartzSlider({ domMapping : true });


          ioapreloader(data,function(){
               
                 temp.find('.progress').stop(true,true).transition({ width:"100%" },1000,'',function(){
                 temp.find('.progress').transition({'opacity':0},300,'',function(){ jQuery(this).css({ width:0 , opacity:1 }); });
                 
                 jQuery('ul.portfolio_posts').append(data);
                 jQuery('ul.portfolio_posts').isotope( 'appended',data  );


                 setTimeout(function(){
                     data.each(function(i){ 
                        jQuery(this).find('.inner-item-wrap').delay(i*100).transition({'opacity':1, top : 0 },300); 
                        });
                     temp.find(".lightbox").prettyPhoto({ social_tools:'' , theme: jQuery('body').data('lightbox_theme') });

                 },1000);

                 win.obj.trigger('resize');   
                   

                  }); 

                 temp.find('.button-content').html(ioa_localize.load_more);

               });  

    });

});


jQuery('.ajax-cart').hover(function(){

    jQuery('.ajax-cart-items').css({ marginTop :15 , opacity : 0 , display : 'block' }).animate({ marginTop :0 , opacity: 1 },300,'');

},function(){

   jQuery('.ajax-cart-items').animate({ opacity:0 , marginTop :15 },200,'',function(){
       jQuery(this).hide();
    })
   
});

jQuery('body').bind('added_to_cart',function(evt,fragments, cart_hash){
  
  button_parent.find('.cart-loader').transition({ marginTop :0, opacity: 0 },300,'');
  button_parent.find('.product-data').transition({ opacity:1 },400);

})

jQuery('.show_review_form').click(function(){
    jQuery('#review_form').slideToggle('normal');
});
 
doc.on('mouseenter','.products li , .portfolio_posts li, .posts-grid li,.post_masonry-container li',function(){
 obj = jQuery(this); 
    obj.find('.button').css({ scale : 0 , display : "block" , opacity: 0 }).transition({ opacity:1 , scale : 1 },200);

    if(obj.find('.sec-thumb').length > 0)
    {
      jQuery(this).find('.main-thumb').transition({ scale : 2 , opacity:0 },500);
    }


});

doc.on('mouseleave','.products li , .portfolio_posts li, .posts-grid li,.post_masonry-container li',function(){
 obj = jQuery(this);
    obj.find('.button').transition({ opacity:0 , scale : 0 },200,'',function(){
       jQuery(this).hide();
    });

    if(obj.find('.sec-thumb').length > 0)
    {
      jQuery(this).find('.main-thumb').stop(true,true).transition({    scale :1 , opacity:1 },300);
    }
   
 
});

function resizable()
{
    var t,i,k,obj;
    
    
    if( utils.exists('masonry-block') )
    {
       var testable = (responsive.width-80) / 5 -  40;
       if( jQuery('.inner-super-wrapper').hasClass('ioa-boxed-layout') )
         testable = (jQuery('.skeleton').width())/4;

       if(responsive.width > 1024 && testable < 300  ) 
       {
           testable = 300 ;
       }
        if(responsive.width <= 1024 && responsive.width > 767  ) 
       {
           testable = (responsive.width-80) / 3 -  40 ;
       }
       if(responsive.width < 767 && responsive.width > 400  ) 
       {
           testable = (responsive.width) / 2 -  40 ;
       }
       if(  responsive.width <= 400  ) testable = responsive.width - 20;
       jQuery('ul.blog_posts>li').width(  testable   );
    }   
   

     menus.each(function(){
                    var temp = jQuery(this),posi = jQuery(this).position().left + 2;
                    temp.find('.menu').children('li').each(function(){ 
                        obj = jQuery(this).find('div.sub-menu');
                         if( obj.length > 0 )
                          {
                                obj.children().css('height','auto');
                                obj.css("left",-( posi + jQuery(this).position().left )+"px");
                         }
                     });
            });
    


    for (var i = 0; i < swipers.length ; i++) {
      
      if(responsive.width >= 767)
          swipers[i].el.params.slidesPerView = swipers[i].obj.data('items');
      
      if(responsive.width < 767 && responsive.width > 479)
          swipers[i].el.params.slidesPerView = 2;  
      if(responsive.width < 479)
          swipers[i].el.params.slidesPerView = 1;    
      
      swipers[i].el.reInit();

      swipers[i].obj.css({  height : swipers[i].obj.find('img').first().height()-2 });
      swipers[i].obj.find('.swiper-wrapper,.swiper-slide').css({  height : swipers[i].obj.find('img').first().height()-2 });
    };


  if(responsive.width > 767 )
  {
     var iso_opts,gutter;
    jQuery('.isotope').each(function(){
         gutter = jQuery(this).data('gutter');
        if(gutter == "50" && responsive.width <=1024 ) gutter = 30;

        iso_opts = {  itemSelector :'.isotope li.iso-item ' , layoutMode : 'cellsByRow', cellsByRow : { gutter:gutter  } };
        
        if( jQuery(this).data('layout') && jQuery(this).data('layout') =='masonry' )
           iso_opts = {  itemSelector :'.isotope li.iso-item ' , layoutMode : 'masonry' , masonry : { gutter:gutter  } };

        jQuery(this).isotope(iso_opts);
        jQuery(this).data('iso',true);
        jQuery(this).isotope('layout');

     });
  } 
  else
  {
   
       jQuery('.isotope').each(function(){
         
        if( typeof jQuery(this).data('iso') != "undefined")
        {
          jQuery(this).isotope('destroy');
          jQuery(this).removeData('iso')
         
        }
     
     });
        setTimeout(function(){  jQuery('.isotope').children('li').removeAttr('style');  },500);
    
  }


    

    var max =0;
    if(jQuery('.logo-area').length > 0)
    jQuery('.logo-area').each(function(){
        max = 0;
        jQuery(this).find('img').each(function(){
            if( jQuery(this).height() > max ) max = jQuery(this).height();
        });
        jQuery(this).find('li .inner-logo-item').css({ "min-height":(max+20)+"px"  });

    }); 


    jQuery('.radial-chart').each(function(){
        w = jQuery(this).data('width');
        if( w > jQuery(this).parent().width() ) w = jQuery(this).parent().width() - 20;
        

      
        jQuery(this).css({ width:w , height:w , lineHeight: w+"px"});
        jQuery(this).find('canvas').css({ width:w , height:w });
    });


    if(utils.exists('portfolio-maerya-list')) 
    {

      Maerya = jQuery('.portfolio-maerya-list'); Maerya_p = Maerya.parent() ;m_childs = Maerya.children();  dynamic = jQuery('div.dynamic-content') ; close_section = jQuery('.portfolio-maerya-wrap .close-section') ; s_w = Maerya_p.width() / m_childs.length ;

      if(current_obj && typeof current_obj!="undefined" )
       close_section.trigger('click');
       m_childs.width(s_w);
       Maerya.css("width","2000em");

       dynamic.parent().css("min-height",Maerya.height()+"px");

       m_childs.find('.proxy,.stub').width(s_w);

    }

       

 } // End of Resizable function

// Mobile Menu

if(jQuery('.rad_google_map').length > 0)
google.maps.event.addDomListener(window, 'load', Gmap_intialize);

function registerHoverEffect()
    {
      
      doc.on('mouseenter','.hover-item',  function(){
         
         jQuery(this).find('.hover-overlay').css({ opacity:0 , display:"block"  }).stop(true,true).transition({ opacity: 1 },300);
         jQuery(this).find('canvas').css({ opacity:0 , display:"block"  }).stop(true,true).transition({ scale:1.1, opacity: 1 },300);

         jQuery(this).find('.hover-icons').children().each(function(i){

            jQuery(this).css({ opacity:0 , scale:0.4 , display:"block"  }).delay(i*150).transition({  opacity: 1 ,scale:1 },300,'');
         
         });
      
      });

      doc.on('mouseleave','.hover-item', function(){
         jQuery(this).find('.hover-overlay,canvas').transition({  scale:1,opacity:0  },400,'');
      });
     
     jQuery('.hoverable').each(function(){
         makeCanvasEffect( jQuery(this) );
     });
     

    }

  


}
jQuery(main_code);

function ioapreloader(obj,callback)
{
    var images =[];
    images = jQuery.makeArray(obj.find('img'));
    var limit = images.length , timer,i,index;

    timer = setInterval(function(){

        if(limit<=0)
        {

            callback(obj.find('img'));
            clearInterval(timer);
            return;
        }

        for(i=0;i<images.length;i++)
        {
                if(images[i].complete  || images[i].readyState == 4)
                    {
                        images.splice(i,1);
                          limit--;                     
                       }    

        }

    },200);
    
}

/**
 * IE 7 Class checker ~~ Basic Support
 */
function getElementsByClassName(node, classname) {
    var a = [];
    var re = new RegExp('(^| )'+classname+'( |$)');
    var els = node.getElementsByTagName("*");
    for(var i=0,j=els.length; i<j; i++)
        if(re.test(els[i].className))a.push(els[i]);
    return a;
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

    
 function thisTouchStart(e)
{
    dragFlag = true;
    start = e.touches[0].pageY; 
}

function thisTouchEnd()
{
    dragFlag = false;
}

function thisTouchMove(e)
{
    if ( !dragFlag ) return;
    end = e.touches[0].pageY;
    window.scrollBy( 0,( start - end ) );
}



 function Gmap_intialize() {
   
     var geocoder = [],map = []; 
    jQuery('.rad_google_map').each(function(k){

      geocoder[k] = new google.maps.Geocoder();
    

    var address = jQuery(this).find('textarea').val().split('[r_mp]');

    var mapOptions = {
      scrollwheel:false,

      zoom: jQuery(this).data('zoom') ,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
  }


    };

    if(jQuery(window).width() <= 1024) mapOptions.draggable = false;

    var styles = [
    {
      stylers: [
        { hue: jQuery(this).data('hue') },
        { saturation:0 }
      ]
    },{
      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: 0 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "off" }
      ]
    }
  ];
        

    var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});
    var image = jQuery(this).data('marker');

   

    map[k] = new google.maps.Map(this,  mapOptions);
    map[k].mapTypes.set('map_style', styledMap);
    map[k].setMapTypeId('map_style');

    for(var i=0;i<address.length;i++)
    geocoder[k].geocode( { 'address': address[i]}, function(results, status) {
    
    if (status == google.maps.GeocoderStatus.OK) {
        
      google.maps.visualRefresh = true;

      map[k].setCenter(results[0].geometry.location);

      var marker =  new google.maps.Marker({
            map: map[k],
            position: results[0].geometry.location,
            icon: image
        });

        google.maps.event.addListener(marker, 'click', function() {
          console.log(marker.position);
          window.open(marker.map.mapUrl);
         
        });

      } 

    });


    });

}




function makeCanvasEffect(obj)
{
 
   if(obj.hasClass('no-canvas')) return;

    obj.find("img").each(function(){
      temp = jQuery(this);
             if( jQuery(this).parent().hasClass('slider-item') || jQuery(this).parent().hasClass('gallery-item') ) return;
             
            if( jQuery(this).find('canvas').length == 0 )
            {

              if( temp.attr('src').indexOf('.png') > 0 || temp.attr('src').indexOf('.PNG') > 0 ) return;

               var parent = temp.parent(), obj = jQuery("<canvas width='"+temp.attr('width')+"' height='"+temp.attr('height')+"'  />"),
               arr = [], i =0,  j =0,image;
              
              parent.append(obj);
              image = temp[0];
              
              try {
        
              var canvas = obj[0];
              var context = canvas.getContext('2d');
                 
              context.drawImage(image, 0, 0);
              var grayscale,imageData    = context.getImageData(0,0,canvas.width,canvas.height),
              data        = imageData.data;
                 
              for(var i = 0,z=data.length;i<z;i++){ 
                 data[i] =     data[i];
                 data[++i] =    data[i-1];
                 data[++i] =    data[i-2];
                 data[++i] = 255;
                }
                
                   // Putting the modified imageData back on the canvas.
               context.putImageData(imageData,0,0,0,0,imageData.width,imageData.height);

               } catch(e) {
  
              
              }
             
            }
             
            });
}  