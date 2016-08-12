/**
 * @description : Main file for Framework inputs / media api / widgets
 * @version : 1.0
 * @author Abhin Sharma [WPioas]
 */

var DEBUGMODE = true;
var  ioa_msg , utils = {

	debug : function(message) {

   			 if (window.console && window.console.log  && DEBUGMODE )
      			 window.console.log('~~ IOA Debug Mode: ' + message);
  		}
}

var mediaFrame = null , hmedia = {

		init : function(title){
			

	  			mediaFrame = wp.media({
						
						title:  title,
				 		multiple : true,
						library:   {
						type: 'image'
						}
						
						});

	  		

		},

	    open : function(title,button_label,callback) {
	    	hmedia.init(title);
	    	mediaFrame.on( 'toolbar:render:select', function( view ) {
				view.set({
					select: {
						style: 'primary',
						text:  button_label,

						click: function() {
							
							var attachment = mediaFrame.state().get('selection'),
							models = attachment.models , images = [];
							
							jQuery(models).each(function(i){ 
							
				
				 			images[i] = this.attributes;
							
					  
							
							});
							
							mediaFrame.close();
							callback(images);
						}
					}
				});
			});
			mediaFrame.setState('library').open();

	    }	
	};


var zipFrame = null , zmedia = {

		init : function(title){
			

	  			zipFrame = wp.media({
						
						title:  title,
				 		multiple : true,
						library:   {
						type: 'application/zip'
						}
						
						});

	  		

		},

	    open : function(title,button_label,callback) {
	    	zmedia.init(title);
	    	zipFrame.on( 'toolbar:render:select', function( view ) {
				view.set({
					select: {
						style: 'primary',
						text:  button_label,

						click: function() {
							
							var attachment = zipFrame.state().get('selection'),
							models = attachment.models , zips = [];
							
							jQuery(models).each(function(i){ 
							
				
				 			zips[i] = this.attributes;
							
					  
							
							});
							
							zipFrame.close();
							callback(zips);
						}
					}
				});
			});
			zipFrame.setState('library').open();

	    }	
	};

var videoFrame = null , vmedia = {

		init : function(title){
			

	  			videoFrame = wp.media({
						
						title:  title,
				 		multiple : true,
						library:   {
						type: 'video'
						}
						
						});

	  		

		},

	    open : function(title,button_label,callback) {
	    	vmedia.init(title);
	    	videoFrame.on( 'toolbar:render:select', function( view ) {
				view.set({
					select: {
						style: 'primary',
						text:  button_label,

						click: function() {
							
							var attachment = videoFrame.state().get('selection'),
							models = attachment.models , videos = [];
							
							jQuery(models).each(function(i){ 
							
				
				 			videos[i] = this.attributes;
							
					  
							
							});
							
							videoFrame.close();
							callback(videos);
						}
					}
				});
			});
			videoFrame.setState('library').open();

	    }	
	};

String.prototype.replaceAll = function(token, newToken, ignoreCase) {
    var str, i = -1, _token;
    if((str = this.toString()) && typeof token === "string") {
        _token = ignoreCase === true? token.toLowerCase() : undefined;
        while((i = (
            _token !== undefined? 
                str.toLowerCase().indexOf(
                            _token, 
                            i >= 0? i + newToken.length : 0
                ) : str.indexOf(
                            token,
                            i >= 0? i + newToken.length : 0
                )
        )) !== -1 ) {
            str = str.substring(0, i)
                    .concat(newToken)
                    .concat(str.substring(i + token.length));
        }
    }
return str;
};


jQuery.fn.extend({
insertAtCaret: function(myValue){
  return this.each(function(i) {
    if (document.selection) {
      //For browsers like Internet Explorer
      this.focus();
      sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();
    }
    else if (this.selectionStart || this.selectionStart == '0') {
      //For browsers like Firefox and Webkit based
      var startPos = this.selectionStart;
      var endPos = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;
    } else {
      this.value += myValue;
      this.focus();
    }
  })
}
});


jQuery(document).ready(function(){

var doc = jQuery(document) , ioa_wrap = jQuery('.ioa_wrap '), thumb;
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

};


ioa_msg = {
 	msg_block : jQuery(".ioa-message"),
 	icon : jQuery(".ioa-message i"),
 	setMessage : function(title){
		ioa_msg.msg_block.css('display','none');
		ioa_msg.msg_block.find('div.ioa-message-body h3').html(title);
		ioa_msg.msg_block.find('div.ioa-message-body p').html('');
	},
	setMessage : function(title,message){
		ioa_msg.msg_block.css('display','none');
		ioa_msg.msg_block.find('div.ioa-message-body h3').html(title);
		ioa_msg.msg_block.find('div.ioa-message-body p').html(message);
	},
	setMessage : function(title,message,type){
		
		ioa_msg.msg_block.removeClass('ioa-error ioa-warning ioa-information ioa-success').addClass("ioa-"+type);
		switch(type)
		{
			case 'success' : ioa_msg.icon.removeClass().addClass('ioa-front-icon checkicon-'); break;
			case 'information' : ioa_msg.icon.removeClass().addClass('ioa-front-icon  infoicon-'); break;
			case 'error' : ioa_msg.icon.removeClass().addClass('ioa-front-icon  cancel-circled-2icon-'); break;
			case 'warning' : ioa_msg.icon.removeClass().addClass('ioa-front-icon  attention-3icon-'); break;
			case 'custom' : ioa_msg.icon.removeClass().addClass('ioa-front-icon '+type); break;
			default : ioa_msg.icon.removeClass().addClass('ioa-front-icon checkicon-'); 
		}
		ioa_msg.msg_block.css('display','none');
		ioa_msg.msg_block.find('div.ioa-message-body h3').html(title);
		ioa_msg.msg_block.find('div.ioa-message-body p').html(message);

	},
	setIconMessage : function(title,message,icon){
		
		ioa_msg.msg_block.removeClass('error warning information success').addClass("ioa-"+type);
		ioa_msg.icon.removeClass().addClass('ioa-front-icon '+icon);
		ioa_msg.msg_block.css('display','none');
		ioa_msg.msg_block.find('div.ioa-message-body h3').html(title);
		ioa_msg.msg_block.find('div.ioa-message-body p').html(message);

	},
	show : function(){
		ioa_msg.msg_block.hide();
		ioa_msg.msg_block.fadeIn('normal');
        		setTimeout(function(){ ioa_msg.msg_block.fadeOut('fast'); },3000);

	},

	showStatic : function(){
		ioa_msg.msg_block.hide();
		ioa_msg.msg_block.fadeIn('normal');
	},

	hide : function(){
		 ioa_msg.msg_block.fadeOut('fast'); 
	}

	};

jQuery('.clear-switch').click(function(){ jQuery(this).prev().val(''); });	
	
if( jQuery('#concave_editor').length > 0 )
var myCodeMirror = CodeMirror.fromTextArea(jQuery('#concave_editor')[0],{
	lineNumbers : true
});

win.width = win.obj.width();
win.height = win.obj.height();
/**
 * Codes to be executed first
 */

win.obj.ready(function(){

	jQuery('.en_gloss').fadeOut('fast');
});

jQuery('.ioa-title-lightbox-tabs ,.ioa-page-lightbox-tabs , .ioa-tabs, .ioa-custom_post-lightbox-tabs').tabs();


function setupIOAStage()
{
	jQuery('.ioa_sidenav_wrap,#option-panel-tabs').css( "min-height" , ( win.height-120)+"px" );
}
	

if( jQuery('.fullscreen').length > 0 )
{
	setupIOAStage();
}
win.obj.resize(function(){
	
	win.width = win.obj.width();
	win.height = win.obj.height();

	setupIOAStage();
});

jQuery('.rad-publish-post-trigger').click(function(e){
	e.preventDefault();

	jQuery('#publish').trigger('click');
});
/**
 * Personalization Code
 */

function increase_brightness(hex, percent){
    var r = parseInt(hex.substr(1, 2), 16),
        g = parseInt(hex.substr(3, 2), 16),
        b = parseInt(hex.substr(5, 2), 16);

   return '#' +
       ((0|(1<<8) + r * (100 - percent) / 100).toString(16)).substr(1) +
       ((0|(1<<8) + g * (100 - percent) / 100).toString(16)).substr(1) +
       ((0|(1<<8) + b * (100 - percent) / 100).toString(16)).substr(1);
}

if( jQuery('.portfolio_override').val() == "true" ) jQuery('.pt-filter').show();
jQuery('.portfolio_override').change(function(){

	if( jQuery(this).val() == "true" ) jQuery('.pt-filter').show();
	else jQuery('.pt-filter').hide();

});


if( jQuery('.blog_override').val() == "true" ) jQuery('.bt-filter').show();

jQuery('.blog_override').change(function(){

	if( jQuery(this).val() == "true" ) jQuery('.bt-filter').show();
	else jQuery('.bt-filter').hide();

});

/**
 * Enigma API
 */
var boxed_area = jQuery('#eni_boxed');

boxed_area.find('.box-bg-listener').hide();

switch( jQuery('.boxed_background_opts').val() )
{
  case 'bg-color' : boxed_area.find('.bg-color').show(); break;
  case 'bg-image' : boxed_area.find('.bg-image').show(); break;
  case 'bg-gr' : boxed_area.find('.bg-gradient').show(); break;
  case 'bg-video' : boxed_area.find('.bg-video').show(); break;
  case 'bg-texture' : boxed_area.find('.bg-texture').show(); break;
  case 'custom'  : boxed_area.find('.box-bg-listener').show();  
                   boxed_area.find('.bg-gradient').hide(); break;
}

doc.on('change','.boxed_background_opts',function(){
	boxed_area.find('.box-bg-listener').hide();

    switch( jQuery(this).val() )
    {
      case 'bg-color' : boxed_area.find('.bg-color').show(); break;
      case 'bg-image' : boxed_area.find('.bg-image').show(); break;
      case 'bg-gr' : boxed_area.find('.bg-gradient').show(); break;
      case 'bg-video' : boxed_area.find('.bg-video').show(); break;
      case 'bg-texture' : boxed_area.find('.bg-texture').show(); break;
      case 'custom'  : boxed_area.find('.box-bg-listener').show();  
                       boxed_area.find('.bg-gradient').hide(); break;
    }
});

var title_area = jQuery('#eni_title_tab');

title_area.find('.title-bg-listener').hide();

switch( jQuery('.title_background_opts').val() )
{
  case 'bg-color' : title_area.find('.bg-color').show(); break;
  case 'bg-image' : title_area.find('.bg-image').show(); break;
  case 'bg-gr' : title_area.find('.bg-gradient').show(); break;
  case 'bg-video' : title_area.find('.bg-video').show(); break;
  case 'bg-texture' : title_area.find('.bg-texture').show(); break;
  case 'custom'  : title_area.find('.title-bg-listener').show();  
                   title_area.find('.bg-gradient').hide(); break;
}

doc.on('change','.title_background_opts',function(){
	title_area.find('.title-bg-listener').hide();

    switch( jQuery(this).val() )
    {
      case 'bg-color' : title_area.find('.bg-color').show(); break;
      case 'bg-image' : title_area.find('.bg-image').show(); break;
      case 'bg-gr' : title_area.find('.bg-gradient').show(); break;
      case 'bg-video' : title_area.find('.bg-video').show(); break;
      case 'bg-texture' : title_area.find('.bg-texture').show(); break;
      case 'custom'  : title_area.find('.title-bg-listener').show();  
                       title_area.find('.bg-gradient').hide(); break;
    }
});

jQuery('.customize-settings-body , #eni_boxed .subpanel').tabs();

jQuery('.export-skin-toggle').click(function(e){
	e.preventDefault();
	jQuery('.export-skin-panel').slideToggle('normal');
});

jQuery('.export-scheme-toggle').click(function(e){
	e.preventDefault();
	jQuery('.export-scheme-panel').slideToggle('normal');
});

jQuery('.import-skin-toggle').click(function(e){
	e.preventDefault();
	jQuery('.import-skin-panel').slideToggle('normal');
});

var exb;
jQuery('.export-skin').click(function(e){
	e.preventDefault();
	
	exb = jQuery(this);

	var s = [];
	jQuery('.customize-list li').each(function(i){
			s[i] = { name : jQuery(this).find('.minicolors-input').attr('name') , value : jQuery(this).find('.minicolors-input').val() };
	});


	jQuery.post(  jQuery('#backend_link').attr('href') , {  	
		title : jQuery('.skin_export_title').val(),
		type:"skin_export", 
		palette : s , 
		skin : jQuery('.sk_ex_skin_v').val(),
		action: 'ioalistener' ,
		},
			  function(data){

			  	window.location.href = exb.attr('href')+"&export_skin=true";
			  	
		});

});

jQuery('.import-skin').click(function(e){
	obj = jQuery(this);
	e.preventDefault();
	jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"skin_import", code : jQuery('.skin_import_code').val() ,   action: 'ioalistener'} , function(data){

		loader.hide();
				ioa_msg.setMessage('Skin Imported','Refreshing the page.','information');
				ioa_msg.show();
		setTimeout(function(){
			window.location.href = obj.attr('href');
		},500);		

		});		 

	}); 


jQuery('.reset-skin').click(function(e){
	e.preventDefault();
	jQuery('.customize-list li').each(function(){

			jQuery(this).find('.minicolors-input').minicolors('value',jQuery(this).find('.minicolors-input').data('default'));

	});
});

var v;
jQuery('.predefined-schemes ul li').click(function(e){
	e.preventDefault();
    temp = jQuery(this);
    
	jQuery('.customize-list li').each(function(){
			v = jQuery(this).find('input').attr('name');
			v = temp.find('.'+v).val();
			jQuery(this).find('.minicolors-input').minicolors('value',v);

	});

});

jQuery('.inbuilt-styles-body .skin-item').hover(function(){
	jQuery(this).find('.hover').fadeIn('fast');
},function(){
	jQuery(this).find('.hover').stop(true,true).fadeOut('fast');
});

jQuery('.inbuilt-styles-body .skin-item').click(function(){
	jQuery('.inbuilt-styles-body .skin-item').removeClass('active');
	jQuery('.inbuilt-styles-body .skin-item .skin-tick').hide();
	jQuery(this).find('.skin-tick').css({ opacity:0 , scale: 0 , display:'block' }).transition({ opacity: 1 , scale :1  },300,'easeOutBack');
	jQuery(this).addClass('active');
	jQuery('.c-skin-label').html( jQuery(this).data('skin') );

	scheme_childs.hide();
	scheme_childs.filter('li.sch-sk-'+jQuery(this).data('skin')).show();

});

var cl = jQuery('.skin-item.active').data('skin'), scheme_childs = jQuery('.predefined-schemes').find('li');

scheme_childs.hide();
scheme_childs.filter('li.sch-sk-'+cl).show();


jQuery('.reset-visual-settings').click(function(e){
	e.preventDefault();
	loader.show();

	jQuery('.typo-form .ioa_input').each(function(i){

		 temp = jQuery(this).find('input[type=text],textarea,select,input[type=checkbox]');
     	 
     	 if( temp.is('select') )
      {
         selectOptionByText(temp,temp.data('default'));
      }
      else if(temp.is(':checkbox'))
      {
        temp.removeAttr('checked');
      }  
      else
      {

        if(temp.hasClass('ioa-minicolors'))
        {
          temp.minicolors("value",temp.data('default')).trigger('click');
        }
        else  
          temp.val(temp.data('default'));
      }

      if( jQuery(this).find('.ioa_slider').length > 0 )
        {
           jQuery(this).find('.ioa_slider').slider( "value", temp.data('default') );
        } 

	});

	setTimeout(function(){

			loader.hide();

				ioa_msg.setMessage('Typography Settings Resetted','Original Settings resorted !','warning');
				ioa_msg.show();

	},2000);
});

jQuery('i.delete-scheme').click(function(e){
	 e.preventDefault();
	 e.stopImmediatePropagation();
	 loader.show();
	 temp = jQuery(this).parent();
	jQuery.post(  jQuery('#backend_link').attr('href') , {  	

		type:"eni_delete_scheme", 
		id : temp.data('id') , 
		action: 'ioalistener' ,
		},
			  function(data){

			  	loader.hide();
				ioa_msg.setMessage('Scheme Deleted','Your scheme has been deleted !','warning');
				ioa_msg.show();
				temp.remove();
			  	
		});


	});

jQuery('.scheme-override-save').click(function(e){
	 e.preventDefault();
	 if(jQuery('.scheme_s_override').val()=="") return;
	 loader.show();
	 var palette = [];

	jQuery('.customize-list li').each(function(i){
		palette[i] = { name : jQuery(this).find('input').attr('name'), value : jQuery(this).find('input').val() }
	});

	jQuery.post(  jQuery('#backend_link').attr('href') , {  	
		title : jQuery('.scheme_s_override').val(),
		type:"eni_save_as_scheme", 
		skin : jQuery('.skin-item.active').data('skin'),
		palette : encodeURIComponent(JSON.stringify(palette)) , 
		action: 'ioalistener' ,
		},
			  function(data){

			  	loader.hide();
				ioa_msg.setMessage('Scheme Saved','new settings to scheme has been saved !','success');
				ioa_msg.show();
			  	
		});


	});

jQuery('.save-as-scheme').click(function(e){
	 e.preventDefault();
	 loader.show();
	 var palette = [];

	jQuery('.customize-list li').each(function(i){
		palette[i] = { name : jQuery(this).find('input').attr('name'), value : jQuery(this).find('input').val() }
	});

	jQuery.post(  jQuery('#backend_link').attr('href') , {  	
		title : jQuery('.scheme_export_title').val(),
		skin : jQuery('.ex_skin_v').val(),
		type:"eni_save_as_scheme", 
		palette : encodeURIComponent(JSON.stringify(palette)) , 
		action: 'ioalistener' ,
		},
			  function(data){

			  	loader.hide();
				ioa_msg.setMessage('Scheme Saved','Your scheme has been saved !','success');
				ioa_msg.show();
				jQuery('.export-scheme-panel').slideToggle('normal');
			  	
		});


	});

jQuery('.save-visual-settings').click(function(e){

	loader.show();

	var palette = [];
	var boxed_data = [];
	var title_data = [];

	jQuery('.customize-list li').each(function(i){
		palette[i] = { name : jQuery(this).find('input').attr('name'), value : jQuery(this).find('input').val() }
	});
	var custom_typo_list = [];

	jQuery('.custom-typo-list').children().each(function(i){
		custom_typo_list[i] =  {  name : jQuery(this).find('.label').val() , selector : jQuery(this).find('.selector').val()  }
	});

	jQuery('.box-bg-vals .ioa_input').each(function(i){
		boxed_data[i] = { name : jQuery(this).find('input,select').attr('name'), value : jQuery(this).find('input,select').val() }
	});

	jQuery('.title-bg-vals .ioa_input').each(function(i){
		title_data[i] = { name : jQuery(this).find('input,select').attr('name'), value : jQuery(this).find('input,select').val() }
	});


	var typopanel = [];
	jQuery('.typo-form .ioa_input').each(function(i){

		 inp = jQuery(this).find('input[type=text],textarea,select,input[type=checkbox]');
     	 val = inp.val();

	      if( inp.is(':checkbox') )
	      {
	        str = [];
	        var check = jQuery(this).find('input[type=checkbox]');

	        check.each(function(j){

	            if( jQuery(this).is(':checked') )
	            {
	            	 str.push(jQuery(this).val());
	          	}
	            	
	        });
	        val = str.join();
	      }

	      typopanel[i] = { name : inp.attr('name') , value :val };
	});


	jQuery.post(  jQuery('#backend_link').attr('href') , {  	

		type:"eni_data", 
		palette : encodeURIComponent(JSON.stringify(palette)) , 
		activeskin : jQuery('.skin-item.active').data('skin') , 
		action: 'ioalistener' ,
		typography : typopanel ,
		ceditor : encodeURIComponent( myCodeMirror.getValue() ),
		font_deck_id : jQuery('#IOAR_font_deck_project_id').val(),
		font_deck_name : jQuery('#IOAR_font_deck_name').val(),
		toggle_scheme : jQuery('#toggle_color_scheme').val(),
		box_val : boxed_data,
		title_val : title_data,
		custom_typo : custom_typo_list
		},
			  function(data){

			  	loader.hide();

				ioa_msg.setMessage('Settings Updated','Visual Settings were successfully updated !','success');
				ioa_msg.show();
			  	
		});


	e.preventDefault();
});

jQuery('.predefined-schemes h4   a.adv-opts').click(function(e){
	e.preventDefault();
	jQuery('div.scheme-override').slideToggle('normal');
});

var ff_bl = jQuery('.fontface-item.hide');

doc.on('click','.fontface-item .ioa-front-icon', function(e){
	e.preventDefault();

	loader.show();
	temp = jQuery(this).parent();
	obj = temp.find('span').html();
	jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"eni_fontface_del",  attachment_id : temp.find('input').val() , action: 'ioalistener'  },
			  function(data){

			  	temp.fadeOut('normal');
			  	loader.hide();

				ioa_msg.setMessage('Font Remove',obj+' font has been removed.','warning');
				ioa_msg.show();
			  	
		});
});

jQuery('a.google-advance-settings').click(function(e){
	e.preventDefault();
	jQuery(this).next().slideToggle('normal');

});

var custom_typo = jQuery('.hide .custom-typo-item').clone();


jQuery('.add-new-typo').click(function(e){
	e.preventDefault();
	temp = custom_typo.clone();
	
	temp.find('h4').html( jQuery('#element_name').val() );
	temp.find('.label').val( jQuery('#element_name').val() );
	temp.find('.selector').val( jQuery('#element_selector').val() );

	jQuery('.custom-typo-list').append(temp);

});

jQuery('.enig-font-slab').each(function(){

	parent = jQuery(this);

	parent.find('.enig-typo-filter').hide();
	parent.find('.enig-typo-filter.'+jQuery(this).find('.enig_font_selector select').val()).show();

});



jQuery('.enig_font_selector select').change(function(){

	parent = jQuery(this).parents('.enig-font-body');

	parent.find('.enig-typo-filter').hide();
	parent.find('.enig-typo-filter.'+jQuery(this).val()).show();

});

jQuery('.eni_font_face_in').change(function(){
		temp = jQuery(this);

		loader.show();
		temp.parents('.ioa_input').prev().slideDown('normal');

		jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"eni_fontface",  attachment_id : temp.val() , action: 'ioalistener'  },
			  function(data){
				
				loader.hide();
				if(data != "0")
				{
					ioa_msg.setMessage('Yay','New Font Face font has been added.','success');
					

					obj = ff_bl.clone().removeClass('hide');
					obj.find('span').html(data);
					obj.find('input').val(temp.val());
					jQuery('.fontface-list').append(obj);
					temp.val('');

				}	
				else
					ioa_msg.setMessage('Oops','Fonts cannot be created !','error');

				ioa_msg.show();

				setTimeout(function(){
					temp.parents('.ioa_input').prev().slideUp('slow');
				},2000);
					 
                     
				  }
			  );

});


/**
 * Header Builder Code
 */

var header_array = [] , current_head_element ='';
var widget_settings = [];

if( jQuery('.hcon-widgets').length > 0 ) {


jQuery('.hcon-widgets .hcon-widget').draggable({ helper: "clone" });
jQuery('.placeholder').sortable();

jQuery('.inner-holder .placeholder').droppable({
	 hoverClass: "hcon-container-dropping",
	 greedy :true,
	  drop: function( event, ui ) {

	  	if( jQuery(this).has(ui.draggable).length ) return;


	  	if( ! ui.draggable.hasClass('in-placeholder') ) {

	  		var el = ui.draggable.clone();
	  		el.addClass('in-placeholder');
	  		jQuery(this).append(el);
	  		
	  	}
	  	else if(  ui.draggable.hasClass('in-placeholder') )
	  	{
	  		var el = ui.draggable.clone();
	  		jQuery(this).append(el);
	  		mapHconSettings(el,ui.draggable);
	  		ui.draggable.remove();
	  		el.removeAttr('style');
	  		el.removeClass('ui-draggable-dragging');


	  	}

	  }

});

jQuery('.hcon-template').click(function(e){
	e.preventDefault();
	jQuery( '#hcon-template-panel' ).slideToggle('normal');
});

jQuery('.hcon-import-template').click(function(e){
	e.preventDefault();
	jQuery( '#hcon-import-panel' ).slideToggle('normal');
});
jQuery('.hcon-export-template').click(function(e){
	e.preventDefault();
	jQuery( '#hcon-export-panel' ).slideToggle('normal');
});

jQuery('.import-hcon-template').click(function(e){
	e.preventDefault();
	window.location.href = jQuery(this).attr('href')+"hcon_id="+jQuery('.i_head_templates').val();
});

jQuery('.delete-hcon-template').click(function(e){
	e.preventDefault();
	window.location.href = jQuery(this).attr('href')+"hcon_delete_id="+jQuery('.i_head_templates').val();
});


jQuery('.export-hcon-template').click(function(e){
	e.preventDefault();
	window.location.href = jQuery(this).attr('href')+"exhcon_id="+jQuery('.head_templates').val();
});

jQuery('.import-hcon-code').click(function(e){
	obj = jQuery(this);
	e.preventDefault();
	jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"headercons-import-code", code : jQuery('.import_head_temp_code').val() ,   action: 'ioalistener'} , function(data){

		loader.hide();
				ioa_msg.setMessage('Template Imported','Refreshing the page.','information');
				ioa_msg.show();
		setTimeout(function(){
			window.location.href = obj.attr('href');
		},500);				 

	}); 
//	window.location.href = jQuery(this).attr('href');
});


jQuery('.new-hcon-template').click(function(e){
	e.preventDefault();
loader.show();
	jQuery('.hcon-holder').each(function(i){
		temp = jQuery(this);
		var data = [] ;

		temp.find('.placeholder').each(function(j){
			
			var widgets = [] ;

			jQuery(this).find('.hcon-widget').each(function(k){
				widget_settings = [];
				jQuery(this).children('.save-data').children().each(function(m){
		            widget_settings[m] = { name : jQuery(this).attr('class') , value : jQuery(this).val() };
		          });

				widgets[k] = { id : jQuery(this).data('id') , inputs : widget_settings }
			});

			data[j] = { 'placeholder' : jQuery(this).data('position') , widgets : widgets  };
		});

		header_array[i] = { 'visibility' :  temp.find('.holder_visibility').val() ,data :data , "id" : temp.data('id') };

	});

	jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"headercons-template",  data: JSON.stringify(header_array), head_layout : jQuery('.head_layout').val(), head_style : jQuery('.head_style').val(),   action: 'ioalistener' , hcon_title : jQuery('.new-template').val()  },
			  function(data){
				loader.hide();
				ioa_msg.setMessage('Template Created','Head Builder changes were saved successfully.','information');
				ioa_msg.show();
					 
                     
				  }
			  );
		


});

}

jQuery('.header-save-settings').click(function(e){
	e.preventDefault();
loader.show();
	jQuery('.hcon-holder').each(function(i){
		temp = jQuery(this);
		var data = [] ;

		temp.find('.placeholder').each(function(j){
			
			var widgets = [] ;

			jQuery(this).find('.hcon-widget').each(function(k){
				widget_settings = [];
				jQuery(this).children('.save-data').children().each(function(m){
		            widget_settings[m] = { name : jQuery(this).attr('class') , value : jQuery(this).val() };
		          });

				widgets[k] = { id : jQuery(this).data('id') , inputs : widget_settings }
			});

			data[j] = { 'placeholder' : jQuery(this).data('position') , widgets : widgets  };
		});

		header_array[i] = { 'visibility' :  temp.find('.holder_visibility').val() ,data :data , "id" : temp.data('id') };

	});

	jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"headercons",  data: JSON.stringify(header_array), head_layout : jQuery('.head_layout').val(), head_style : jQuery('.head_style').val(),   action: 'ioalistener'  },
			  function(data){
				loader.hide();
				ioa_msg.setMessage('Changes Saved','Head Builder changes were saved successfully.','success');
				ioa_msg.show();
					 
                     
				  }
			  );
		


});

doc.on('click','.edit-hcon-widget',function(e){
	e.preventDefault();
	current_head_element = jQuery(this).parents('.hcon-widget');
	
	maptoHconLightbox( jQuery('.hcon-lightbox.'+current_head_element.data('id')) , current_head_element );
});

doc.on('click','.clone-hcon-widget',function(e){
	e.preventDefault();
	temp  = jQuery(this).parents('.hcon-widget');
	obj = temp.clone();
	temp.after(obj);
	mapHconSettings(obj,temp);
	
});

jQuery('a.close-hcon').click(function(e){
	e.preventDefault();
	jQuery(this).parents('.hcon-lightbox').fadeOut('normal');
	maptoHconObj(current_head_element , jQuery('.hcon-lightbox.'+current_head_element.data('id')));
});

doc.on('click','.delete-hcon-widget',function(e){
	e.preventDefault();

	jQuery(this).parents('.hcon-widget').remove();

})

/**
 * Page Builder Code
 */

if( jQuery('#ioa_template_mode').length > 0 )
{
	temp = jQuery('#ioa_template_mode').val();

	if( temp == "wp-editor")
	{
		jQuery('#postdivrich').show();
		jQuery('#rad_backend_builder').hide();
		jQuery('.ioa-page-builder-trigger').html('Switch To Page Builder');
	}
	else
	{
		jQuery('#postdivrich').hide();
		jQuery('#rad_backend_builder').show();
		jQuery('.ioa-page-builder-trigger').html('Switch To Default Editor');
	}
}

jQuery('.ioa-desc-tooltip').hover(function(){

	jQuery(this).children('div').css({ display : 'block' , opacity : 0, bottom:36 }).transition({ opacity : 1 , bottom:26 },300);

},function(){

	jQuery(this).children('div').transition({ opacity : 0 , bottom:36 },300,'',function(){
		jQuery(this).hide();
	});

});

/**
 * Title Area API
 */

var title_bg_watch = jQuery('#ioa_background_opts') , titlebg_panel = jQuery('.ioa-title-lightbox-tabs') ; 

titlebg_panel.find('.ioa-title-filter').hide();
titlebg_panel.find('.ioa-title-filter.'+title_bg_watch.val()+"").show(); 

title_bg_watch.change(function(){
	
		titlebg_panel.find('.ioa-title-filter').hide();
		titlebg_panel.find('.ioa-title-filter.'+title_bg_watch.val()+"").show(); 

});


/**
 * Featured Media API
 */

var featured_media_watch = jQuery('#featured_media_type') , featured_panel = jQuery('#ioa_featured_media') ; 

featured_panel.find('.ioa-media-filterable').hide();
featured_panel.find('.ioa-media-filterable.'+featured_media_watch.val()+"").show(); 

featured_media_watch.change(function(){

		featured_panel.find('.ioa-media-filterable').hide();
		featured_panel.find('.ioa-media-filterable.'+featured_media_watch.val()+"").show(); 

});

/**
 * Page Title API
 */

var title_lightbox = jQuery('.ioa-title-lightbox,.ioa-title-overlay');

jQuery('.ioa-title-lightbox-head .ioa-front-icon').click(function(e){
	e.preventDefault();
	title_lightbox.fadeOut('fast');
});

jQuery('.ioa-title-settings-trigger').click(function(e){
	e.preventDefault();
	title_lightbox.fadeIn('normal');
});

var ptitle = jQuery('#title'), title_tip = jQuery('.ioa-title-edit-wrap .ioa-tooltip');
ptitle.focusin(function(){
	title_tip.fadeIn('normal');
});
ptitle.focusout(function(){
	title_tip.fadeOut('normal');
});

jQuery('.ioa-title-settings-trigger').hover(function(){
	title_tip.fadeIn('normal');
},function(){
	title_tip.fadeOut('normal');
});


/**
 * Page  API
 */

var page_lightbox = jQuery('.ioa-page-lightbox,.ioa-page-overlay');

jQuery('.ioa-page-lightbox-head .ioa-front-icon').click(function(e){
	e.preventDefault();
	page_lightbox.fadeOut('fast');
});

jQuery('.ioa-page-settings').click(function(e){
	e.preventDefault();
	page_lightbox.fadeIn('normal');
});

var ppage = jQuery('#page'), page_tip = jQuery('.ioa-page-edit-wrap .ioa-tooltip');
ppage.focusin(function(){
	page_tip.fadeIn('normal');
});
ppage.focusout(function(){
	page_tip.fadeOut('normal');
});


/**
 * Custom Post  API
 */

var custom_post_lightbox = jQuery('.ioa-custom_post-lightbox,.ioa-custom_post-overlay');

jQuery('.ioa-custom_post-lightbox-head .ioa-front-icon').click(function(e){
	e.preventDefault();
	custom_post_lightbox.fadeOut('fast');
});
var cpin = -1 , post_tabs = jQuery('.ioa-custom_post-lightbox-tabs'), template_selector = jQuery('#ioa-page-template');

if( template_selector.length > 0 ) {


if( template_selector.val().indexOf('shop') >= 0 || template_selector.val().indexOf('blog') >= 0 || template_selector.val().indexOf('portfolio') >= 0 ||  template_selector.val().indexOf('custom-post') >= 0  ||  template_selector.val().indexOf('contact') >= 0 )
{
	jQuery('.set-template-settings-wrap').show();
}
else
	jQuery('.set-template-settings-wrap').hide();

jQuery('.set-template-settings').click(function(e){
	e.preventDefault();
	
	post_tabs.find('ul.ui-tabs-nav li').addClass('ui-state-disabled');	

	if( template_selector.val().indexOf('blog') >= 0 )
	{
		cpin =1; 
	}
	else if( template_selector.val().indexOf('portfolio') >= 0 )
	{
		cpin =0; 
	}
	else if( template_selector.val().indexOf('custom-post') >= 0 )
	{
		cpin =2; 
	}
	else if( template_selector.val().indexOf('contact') >= 0 )
	{
		cpin =3; 
	}
	else if( template_selector.val().indexOf('shop') >= 0 )
	{
		cpin =4; 
	}

	post_tabs.find('ul.ui-tabs-nav li').eq(cpin).removeClass('ui-state-disabled');	
	post_tabs.tabs( "option", "active", cpin  );

	custom_post_lightbox.fadeIn('normal');
});

template_selector.change(function(){

	if( template_selector.val().indexOf('shop') >= 0 || template_selector.val().indexOf('blog') >= 0 || template_selector.val().indexOf('portfolio') >= 0 ||  template_selector.val().indexOf('custom-post') >= 0  ||  template_selector.val().indexOf('contact') >= 0  )
	{
		jQuery('.set-template-settings-wrap').show();
	}
	else
		jQuery('.set-template-settings-wrap').hide();

});

var pcustom_post = jQuery('#custom_post'), custom_post_tip = jQuery('.ioa-custom_post-edit-wrap .ioa-tooltip');
pcustom_post.focusin(function(){
	custom_post_tip.fadeIn('normal');
});
pcustom_post.focusout(function(){
	custom_post_tip.fadeOut('normal');
});

}
/**
 * LightBox code
 */

var rad_lightbox = jQuery('div.rad-lightbox');

if(rad_lightbox.length > 0) {

	rad_lightbox.draggable({ handle : '.rad-l-head' });
	
	rad_lightbox.children('.rad-l-body').height( win.height - 260 );
	win.obj.resize(function(){
		rad_lightbox.children('.rad-l-body').height( win.height - 260 );
	});

	var rl = {
		show : function(msg) {
			jQuery('#save-l-data').show();
			jQuery('#shortcode-l-data').hide();

			rad_lightbox.css('opacity',1).fadeIn('slow');
			rad_lightbox.find('div.rad-l-head h4').html(msg);
		},
		hide: function() {
			rad_lightbox.fadeOut('fast');
		},
		set : function(html,key)
		{
			rad_lightbox.data("mode",'');
			rad_lightbox.find('div.rad-l-body div.component-opts').html(html);
			rad_lightbox.find('div.rad-l-body').data('key',key);

			if(key == "hcon")
			{
				var id = '';
				rad_lightbox.find('input[type=checkbox]').each(function(){
					id = jQuery(this).attr("id");
					jQuery(this).attr("id", id+"_rad" );
					jQuery(this).next().attr("for", id+"_rad")
				});
			}


		},
		map: function(current)
		{
			var name,temp;
			current.find('div.ioa_input').each(function(){
				temp = jQuery(this);
				name = temp.find('input,select,textarea').attr('name');
				
				if(temp.find('input[type=text]').length > 0)
					{
						temp.find('.'+name).val(rad_lightbox.find('input[name='+name+']').val());
						console.log(rad_lightbox.find('input[name='+name+']').val());
					}
				else if(temp.find('textarea').length > 0)
					{
						temp.find('.'+name).val(rad_lightbox.find('textarea[name='+name+']').val());
						console.log(rad_lightbox.find('textarea[name='+name+']').val());
					}	
			});
		}
	};

	doc.on('keyup',rad_lightbox, function(e) {
		
	  if (e.keyCode == 27) { rl.hide(); } 
	});

jQuery('#close-l').click(function(e){  e.preventDefault(); rl.hide(); });
}
/* ============================================ */

	


	var loader = {
	obj  : jQuery('span.waiting'),
	show : function() { loader.obj.fadeIn('normal');  },
	hide : function() { loader.obj.stop(true,true).fadeOut('fast');  }
}



var hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 

//Function to convert hex format to a rgb color
function rgb2hex(rgb) {
 
if(  rgb =="transparent" || jQuery.trim(rgb) == "" || !rgb ) return "";

 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

 if(!rgb) return 'transparent';
 return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
 }
	var obj,temp,i,j;
    var version = parseFloat(jQuery('#wp_version').attr('href')) , query_engine, sicon_engine ,panes = [];
    var SN = jQuery('#option-panel-tabs').data('shortname');
    var icon_canvas = '',icon_opts,icon_wrap='',icon_tabs;
    var image_canvas, image_opts,image_wrap, rad_image_obj;
    var icon_obj;
    var options_panel = jQuery( ".option-panel-tabs" ) , inputs = options_panel.find('.ioa_input');

    jQuery('#options-search').focusin(function(){
	
	jQuery('body').addClass('ioa-panel-search-start');

	jQuery('.ioa-search-icon').hide();
	options_panel.tabs( "destroy" );	

	jQuery('div.ioa_options div.subpanel').tabs( "destroy" );

	options_panel.addClass('ioa-search-mode');
	
	jQuery('.search-close-wrap').fadeIn('normal');
	inputs.hide();

});

jQuery('.head_layout').change(function(){
		if( jQuery(this).val().indexOf('efault') > 0 ) return;
		window.location.href = jQuery('.export-hcon-template').attr('href')+"clayout="+jQuery(this).val();
});    

jQuery('.ioa-admin-menu-wrap').hover(function(){
	jQuery(this).find('ul').stop(true,true).fadeIn('fast');
},function(){
	jQuery(this).find('ul').fadeOut('fast');
});

jQuery('.close-ioa-import-lightbox').click(function(e){
	e.preventDefault();
	jQuery('.ioa-import-lightbox').fadeOut('fast');
});

jQuery('.ioa-import-lightbox-trigger').click(function(e){
	e.preventDefault();
	jQuery('.ioa-import-lightbox').fadeIn('fast');
});


jQuery('.close-options-search').click(function(e){
	e.preventDefault();
	inputs.show();
	
	
	options_panel.removeClass('ioa-search-mode');
	
	jQuery('div.ioa_options div.subpanel').tabs();
	options_panel.tabs();


	jQuery('.search-close-wrap').fadeOut('normal',function(){
		jQuery('.ioa-search-icon').show();
		jQuery('#options-search').val('');
	});

	jQuery('body').removeClass('ioa-panel-search-start');

});

var query , qlen , test ,qar , fn ;
    jQuery('#options-search').keyup(function(e){
     	query = jQuery(this).val().toLowerCase();
     	qar = query.split(' ');
     	qlen = 	qar[0].length;

     	inputs.hide();
   		
   		if(qlen >= 2)
    	{
    			
	    		inputs.each(function(){
	    			test = []; temp = jQuery(this); fn = true;
	    			for(var i=0;i<qar.length;i++) {

	    				if( typeof temp.data('label') !='undefined' &&  temp.data('label').indexOf(qar[i]) != -1 )
	    					test[i] = true;
	    				else
	    					test[i] = false;

	    			}
	    			
	    			for(var i=0;i<test.length;i++) 	fn = fn && test[i];

	    			if(fn === true) jQuery(this).show();

	    		});

    		
    	}
    	else
    	{
    		inputs.hide();
    	}

    });	



	function initCustomInputs()
	{
		/**
	 * Colorpicker for the framework with RGBA support
	 */
	jQuery('.ioa-minicolors').each(function(){
		obool = jQuery(this).data('opacity');
		
		jQuery(this).minicolors({
			textfield : true,

			opacity: false,
			change: function(hex, opacity) {
                     
                     jQuery(this).parent().next().val(opacity);    
                     jQuery(this).trigger('change');
                        
                    },
            hide: function(hex, opacity) {
                     
                     jQuery(this).trigger('mini-hidden');
                        
                    },        

		});

	});

	/**
	 * Slider Input Support for the framework
	 */
	

	jQuery( ".ioa_input .ioa_slider" ).each(function(){
		temp = jQuery(this),obj  =temp.parent().find("input");
		temp1 = obj.val();
		if(jQuery.trim(temp1) == "") temp1 = 0;
		//console.log(temp1+"test");
		temp.slider({
				value: parseInt(temp1),
				min: 0, range: "min",
				max:  parseInt(obj.data('max')),
				step : parseInt(obj.data('steps')),
				slide: function( event, ui ) {
					jQuery(this).parent().find("input").val(ui.value);
				}
			});
		
		});
	}
	 initCustomInputs();
	/**
	 * Add custom sidebar
	 */

	
	


	/**
	 * Framework MEDIA Api
	 */
	
	
	 doc.on('click','.input-val-delete',function(e){
		e.preventDefault();
		jQuery(this).parents('.ioa_input').find('input,textarea').val(' ');
		
		if( jQuery(this).parents('.ioa_input').find('.ioa_slider').length > 0  )
			 jQuery(this).parents('.ioa_input').find( ".ioa_slider" ).slider( "value",0 );
		
		});
	


	doc.on('click','a.picker-delete',function(e){
		e.preventDefault();
		jQuery(this).parent().find('.ioa-minicolors').minicolors('value',' ');
		jQuery(this).parent().find('span.minicolors-swatch >span').css('background','transparent');
		jQuery(this).parent().find('input').trigger('pickertrans');
		
		});
 	
	if( jQuery('div.ioa-image-area').length > 0 )
 	jQuery('div.ioa-image-area').sortable({

 		stop: function( event, ui ) {

 			var gl = '';
			var srcs = '';
			
			parent  = jQuery(this).parents('.postbox');

			parent.find('div.ioa-image-area').children().each(function()
			{
				
				srcs +=  jQuery(this).data('img')+"[ioabre]"+jQuery(this).data('thumbnail')+"[ioabre]"+jQuery(this).data('alt')+"[ioabre]"+jQuery(this).data('title')+"[ioabre]"+jQuery(this).data('description')+";";
			
 			});

 			if( parent.attr('id') == 'ioa_portfolio_images' )
 			jQuery('.ioa_portfolio_data').val(srcs);
 		else if( parent.attr('id') == 'ioa_thumbnail_management' )
 			jQuery('.ioa_thumbnail_data').val(srcs);
 		else	
 			jQuery('#ioa_gallery_data').val(srcs);

		}

 	});
  	var parent;
  	doc.on('click','div.ioa-gallery-item a',function(e){
  		e.preventDefault();
  		
  		parent  = jQuery(this).parents('.postbox');

  		jQuery(this).parent().transition({ opacity: 0 , scale:0}, 300 ,'', function(){ 
  			
  			jQuery(this).remove() ;	
  			
  			var gl = '';
			var srcs = '';
			
			parent.find('div.ioa-image-area').children().each(function()
			{
				
				srcs +=  jQuery(this).data('img')+"[ioabre]"+jQuery(this).data('thumbnail')+"[ioabre]"+jQuery(this).data('alt')+"[ioabre]"+jQuery(this).data('title')+"[ioabre]"+jQuery(this).data('description')+";";
			
 			});
 		
 		if( parent.attr('id') == 'ioa_portfolio_images' )
 			jQuery('.ioa_portfolio_data').val(srcs);
 		else if( parent.attr('id') == 'ioa_thumbnail_management' )
 			jQuery('.ioa_thumbnail_data').val(srcs);
 		else	
 			jQuery('#ioa_gallery_data').val(srcs);

 		});
  	});

  	doc.on('mouseover','.ioa-gallery-item',function(){
  		jQuery(this).children('a').fadeIn('fast');
  	});

  	doc.on('mouseleave','.ioa-gallery-item',function(){
  		jQuery(this).children('a').stop(true,true).fadeOut('fast');
  	});

 	jQuery('a.post-ioa-images-generator').click(function(e){
 		e.preventDefault();
		temp =	jQuery(this);

		hmedia.open(temp.data('title'),temp.data('label'),function(images){ 
			

			var gl = '';
			var srcs = jQuery('#ioa_gallery_data').val();
			for(var i=0;i<images.length;i++)
			{

				thumb = images[i].sizes.full.url;
				if( typeof images[i].sizes.thumbnail != 'undefined' )
					thumb = images[i].sizes.thumbnail.url;
				

				gl += "<div class='ioa-gallery-item' data-img='"+images[i].url+"' data-thumbnail='"+thumb+"' data-alt='"+images[i].alt+"' data-title='"+images[i].title+"' data-description='"+images[i].description+"' ><img src='"+thumb+"' /> <a class='close  ioa-front-icon cancel-3icon-' href=''></a></div>";
				srcs +=  images[i].url+"[ioabre]"+thumb+"[ioabre]"+images[i].alt+"[ioabre]"+images[i].title+"[ioabre]"+images[i].description+";";
			}
			temp.parent().find('.ioa-image-area').append(gl); 
			jQuery('#ioa_gallery_data').val(srcs);


		});


 	});

 	jQuery('a.portfolio-ioa-images-generator').click(function(e){
 		e.preventDefault();
		temp =	jQuery(this);

		hmedia.open(temp.data('title'),temp.data('label'),function(images){ 
		

			var gl = '';
			var srcs = jQuery('.ioa_portfolio_data').val();
			for(var i=0;i<images.length;i++)
			{
				thumb = images[i].sizes.full.url;
				if( typeof images[i].sizes.thumbnail != 'undefined' )
					thumb = images[i].sizes.thumbnail.url;

				gl += "<div class='ioa-gallery-item' data-img='"+images[i].url+"' data-thumbnail='"+thumb+"' data-alt='"+images[i].alt+"' data-title='"+images[i].title+"' data-description='"+images[i].description+"' ><img src='"+thumb+"' /> <a class='close  ioa-front-icon cancel-3icon-' href=''></a></div>";
				srcs +=  images[i].url+"[ioabre]"+thumb+"[ioabre]"+images[i].alt+"[ioabre]"+images[i].title+"[ioabre]"+images[i].description+";";
			}
			temp.parent().find('.ioa-image-area').append(gl); 
			jQuery('.ioa_portfolio_data').val(srcs);


		});


 	});


 	jQuery('a.thumbnail-ioa-images-generator').click(function(e){
 		e.preventDefault();
		temp =	jQuery(this);

		hmedia.open(temp.data('title'),temp.data('label'),function(images){ 
		

			var gl = '';
			var srcs = jQuery('.ioa_thumbnail_data').val();
			for(var i=0;i<images.length;i++)
			{
				thumb = images[i].sizes.full.url;
				if( typeof images[i].sizes.thumbnail != 'undefined' )
					thumb = images[i].sizes.thumbnail.url;

				gl += "<div class='ioa-gallery-item' data-img='"+images[i].url+"' data-thumbnail='"+thumb+"' data-alt='"+images[i].alt+"' data-title='"+images[i].title+"' data-description='"+images[i].description+"' ><img src='"+thumb+"' /> <a class='close  ioa-front-icon cancel-3icon-' href=''></a></div>";
				srcs +=  images[i].url+"[ioabre]"+thumb+"[ioabre]"+images[i].alt+"[ioabre]"+images[i].title+"[ioabre]"+images[i].description+";";
			}
			temp.parent().find('.ioa-image-area').append(gl); 
			jQuery('.ioa_thumbnail_data').val(srcs);


		});


 	});

	doc.on('click','.image_upload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		hmedia.open(temp.data('title'),temp.data('label'),function(images){ 
		

			temp.next().val(images[0].url); 
			
			if(jQuery('.mediamanager').length > 0)
			{
				thumb = images[0].sizes.full.url;
				if( typeof images[0].sizes.thumbnail != 'undefined' )
					thumb = images[0].sizes.thumbnail.url;

				temp.parents('.inner-body-wrap').find('.thumbnail').val(thumb);
				temp.parents('.media-slide').find('img').attr("src",thumb);
			}
			obj = temp.parent().parent().find('div.input-image-preview').show().find('img');	
			obj.attr('src',images[0].url);
			temp.next().trigger('change');

			if(temp.next().attr('id')== SN+"_logo")
			{
			  jQuery("."+SN+'_logo_width').val(images[0].width);
			  jQuery("."+SN+'_logo_height').val(images[0].height);
			}

			temp.parents('.ex-shortcode-mods').find('._width').val(images[0].width);
			temp.parents('.ex-shortcode-mods').find('._height').val(images[0].height);

			


		});

		
	});

	doc.on('click','.image_iupload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		hmedia.open('Add Image Icon','Add',function(images){ 

			temp.parents('.ioa_input').find('input').val(images[0].url).trigger('change'); 
		});

		
	});



	doc.on('click','.zip_upload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		zmedia.open(temp.data('title'),temp.data('label'),function(zips){ 
		
			console.log(zips[0]);
			temp.next().val(zips[0].id); 
			temp.next().trigger('change');


		});

		
	});


	doc.on('click','.video_upload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		vmedia.open(temp.data('title'),temp.data('label'),function(video){ 
		
			temp.next().val(video[0].url); 
			temp.next().trigger('change');

		});

		
	}); 

if( jQuery('.mediamanager .slides').length > 0 )
jQuery('.mediamanager .slides').sortable();

doc.on('click','div.post-meta-panel a',function(e){
	e.preventDefault();
	temp = jQuery(this).parent().data('syntax');
	
	if(  jQuery(this).parent().children('select').length > 0 )
	{
			val = jQuery(this).parent().children('select').val();
			regex = new RegExp("format='(.*?)'","g");
			temp = temp.replace(regex, "format='"+val+"'");
	}

	jQuery(this).parents('.ioa_input').find('input,textarea').insertAtCaret(temp);
	jQuery(this).parents('.ioa_input').find('input,textarea').trigger('keyup');
});
	

doc.on('click','.shortcode-extra-insert', function(e){
	e.preventDefault();
	jQuery(this).parents('.ioa_input').find('div.post-meta-panel').slideToggle('normal');
});

	



	jQuery('div.input-image-preview span.himage-remove').click(function(){
		jQuery(this).parent().hide();
		jQuery(this).parent().find('img').attr('src','');
		jQuery(this).parent().prev().find('input').val('');
	});

	
  
	/**
	 * Theme Options Panel Code
	 */
	
	jQuery( ".option-panel-tabs" ).tabs({
  beforeActivate: function( event, ui ) {   }
});	
	jQuery('div.ioa_options div.subpanel').tabs({
  beforeActivate: function( event, ui ) {  }
});


jQuery('a.export-options-panel-settings').click(function(e){
	window.location.href = jQuery(this).attr('href')+"&ioa_export=true";
	e.preventDefault();
});	

	/**
	 *	Options Panel Code
	 * 
	 */
	var path = jQuery('#ioa_option_form').attr('action');

	jQuery(".button-save.options-panel-save").click(function(e){
		loader.show();
		
		jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"options_save",  values: jQuery("#ioa_option_form").serializeArray(), action: 'ioalistener'  },
			  function(data){
				loader.hide();
				ioa_msg.setMessage('Changes Saved','Options Panel changes were saved successfully.','success');
				ioa_msg.show();
					 
                     
				  }
			  );
		
	
	return false;
	});


	jQuery(".import-options-panel-settings").click(function(e){
		e.preventDefault();

		loader.show();
		if( jQuery("#import_ioa_settings").val() === "" )
		{
			ioa_msg.setMessage('Empty Field !','Export Textbox cannot be empty !','warning');
			ioa_msg.show();
			loader.hide();
			return;
		}
		jQuery.post(  jQuery('#backend_link').attr('href') , {  type:"options_import",  data: jQuery("#import_ioa_settings").val(), action: 'ioalistener'  },
			  function(data){
				loader.hide();
				ioa_msg.setMessage('Settings Restored','Refreshing the page...','success');
				ioa_msg.show();
				
				setTimeout(function(){ location.reload(true); },2000);	 
                     	
				  }
			  );
		
	
	return false;
	});
	
	/**
	 * Typo Live preview code
	 */
	var font='',source = jQuery("#gfont-frame").attr("src");
	jQuery('#font_selector').change(function(){
		var font = jQuery.trim(jQuery(this).val());
		jQuery("#gfont-frame").attr("src",source+font+"&fontsize=12");
	});

	/**
	 * Footer Code 
	 */
	
	var footer_layout = jQuery("#ioa_footer_layout").val();
	if(footer_layout=="")
	footer_layout = "two-col";
	
	jQuery(".footer-layout").find("."+footer_layout).addClass('active');
	jQuery(".footer-layout li a").click(function(e){
	jQuery(".footer-layout li").removeClass('active');
	jQuery("#ioa_footer_layout").val(jQuery(this).parent().attr('class'));
	jQuery(this).parent().addClass('active'); 
	
	e.preventDefault();
	});

	/**
	 * Default Layout selection
	 */
	
	var post_layout = jQuery("#"+SN+"_post_layout").val();
    var page_layout = jQuery("#"+SN+"_page_layout").val();
    
	if(post_layout=="")
		post_layout = ".post-layout .full";
	else
   		post_layout = ".post-layout ."+post_layout;
    
     
    
	jQuery(post_layout).addClass('active');
   
     
	if(page_layout=="")
		page_layout = ".page-layout .full";
	else
   		page_layout = ".page-layout ."+page_layout;
    
	jQuery(page_layout).addClass('active');

	jQuery(".post-layout li,.page-layout li").click(function(e){
	
    jQuery(this).parents('div.ioa_input').find('ul li').removeClass('active');
	
    jQuery(this).parents('div.ioa_input').find('input[type=hidden]').val(jQuery(this).attr('class'));
	jQuery(this).addClass('active'); 
	
	e.preventDefault();
	
	});


	/**
	 * Custom Sidebar Code
	 */
	
	function addSidebarBlock(val)
	{

		temp = sidebar_block.clone();
 		temp.children('span').html(val);
	 	temp.css({ scale:0 , opacity : 0 });
 	
	 	jQuery('div.custom-sidebar-area').append(temp);

 		temp.transition({ opacity: 1 , scale:1}, 500 ,'easeOutBack');

 		var ss = jQuery('.custom-sidebars');
 		ss.val(ss.val()+","+jQuery.trim(val));
 		

	}
	
	/**
	 * Add custom sidebar
	 */
	 var sidebar_block = jQuery("<div class='sidebar-tag'><span></span><i  class='ioa-front-icon cancel-circled-2icon- remove-c-sidebar'></i></div>");
	 jQuery('#add-sidebar').click(function(e){

	 	var s = jQuery(this).parent().find('input');
	 	console.log(s.val().indexOf(','));
	 	if( s.val().indexOf(',') > 0 )
	 	{
	 		sidebars = s.val().split(',');
	 		for (var i = 0; i < sidebars.length; i++) {
	 			if(sidebars[i]!="")
	 			addSidebarBlock(sidebars[i]);
	 		};
	 	}
	 	else
	 	{
	 		addSidebarBlock(s.val());
	 	}

	 	s.val('');	
	 	e.preventDefault();
	 });

	 doc.on('click','i.remove-c-sidebar',function(e){
		e.preventDefault();

		var ss = jQuery('.custom-sidebars'),s='';
	 	
	 	jQuery(this).parent().transition({ opacity: 0 , scale:0}, 500 ,'easeInBack',function(){
			jQuery(this).remove();
			jQuery('div.custom-sidebar-area').children().each(function(){
	 		s = s + jQuery.trim(jQuery(this).find('span').html())+",";
	 		});
	 		ss.val(s);
	 		
	 	});

	 });


	 /**
	  *  ============= Header Constructor Code ===========================================================================
	  */
  
  doc.on('click','#shortcode-l-data',function(e){
  		e.preventDefault();


  		if(rad_lightbox.find('div.rad-l-body').data('key')=="icons")
		{
			var query ='[ioa_icon ';
			var du = icon_canvas.find('i').clone();
			du.removeClass('none ioa-front-icon border-style border-style-circ background-style background-style-circ longshadow-style longshadow-style-circ');
				
			switch(jQuery('.icn_style').val())
			{
				case 'none' :  query += ' icon_type="default" icon_class="'+du.attr('class') +'"  color="'+rad_lightbox.find('.color').val()+'"  '; break;
				case 'border-style' :  query += ' icon_type="border-style" icon_class="'+du.attr('class') +'" border_color="'+rad_lightbox.find('.border_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;
				case 'border-style-circ' :  query += ' icon_type="border-style-circ" icon_class="'+du.attr('class') +'"  border_color="'+rad_lightbox.find('.border_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;

				case 'background-style' :  query += ' icon_type="background-style" icon_class="'+du.attr('class') +'"  background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;
				case 'background-style-circ' :  query += ' icon_type="background-style-circ" icon_class="'+du.attr('class') +'"  background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;

				case 'longshadow-style' :  query += ' icon_type="longshadow-style" icon_class="'+du.attr('class') +'"   background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;
				case 'longshadow-style-circ' :  query += ' icon_type="longshadow-style-circ" icon_class="'+du.attr('class') +'"  background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'"'; break;
			}	
			
			query += ' /]';

			tinyMCE.activeEditor.selection.setContent(query);

			

		}
		else if(rad_lightbox.find('div.rad-l-body').data('key')=="shortcode_columns")
		{

			var data = jQuery('div.column-maker-area').clone();
	
			data.find('i').remove();

			if( jQuery('#content').is(':visible') ) {
					    jQuery('#content').insertAtCaret("<div class='clearfix'>"+jQuery.trim(data.html())+"</div> &nbsp;");
			} else {
			    tinyMCE.activeEditor.selection.setContent("<div class='clearfix'>"+jQuery.trim(data.html())+"</div> &nbsp;");    
			}	
			jQuery('div.column-maker-area').html('');

		}

		rl.hide();

  }) ;	

 
  doc.on('click','#save-l-data',function(e){
		e.preventDefault();
		
		if( typeof rad_lightbox.data("mode") != "undefined" && rad_lightbox.data("mode") == "shortcode" ) return;

		if(rad_lightbox.find('div.rad-l-body').data('key')=="query_engine")
		{
			var query = '';
			var c = '';
			jQuery('input[name=select_post_cats]').each(function(){
	 			if( jQuery(this).is(':checked') ) c = c +jQuery(this).val()+",";
			});
			if(c!="," && c!="")
			query = query+"category_name="+c+"&";
			var t = '';
			jQuery('input[name=select_post_tags]').each(function(){
	 			if( jQuery(this).is(':checked') ) t = t +jQuery(this).val()+",";
			});

			if(t!="," && t!="")
			query = query+"tag_id="+t+"&";

			var a = '';
			jQuery('input[name=select_post_auhtors]').each(function(){
	 			if( jQuery(this).is(':checked') ) a = a +jQuery(this).val()+",";
			});

			if(a!="," && a!="")
			query = query+"author="+a+"&";

			var tax= '';

			rad_lightbox.find('div.custom-tax').each(function(){
				
				
				var a = '';
				jQuery(this).find('input[type=checkbox]').each(function(){
	 				if( jQuery(this).is(':checked') ) a = a +jQuery(this).val()+",";
				});

				if(a!=","&&a!=""  )
					 {
					 	tax += jQuery(this).find('.taxonomy').val();
						tax += "|"+a;
					 }

				
			})	

			if(tax!="," && tax!="")
			query = query+"tax_query="+tax+"&";

			query = query+"order="+rad_lightbox.find('#order').val()+"&";
			query = query+"orderby="+rad_lightbox.find('#orderby').val()+"&";

			if(rad_lightbox.find('#year').val()!="")
			query = query+"year="+rad_lightbox.find('#year').val()+"&";
			
			if(rad_lightbox.find('#month').val()!="")
			query = query+"monthnum="+rad_lightbox.find('#month').val()+"&";

	 		query_engine.parent().find('input[type=text]').val(query);
	 		query_engine.parent().find('input[type=text]').trigger('keyup');

		}
		else if(rad_lightbox.find('div.rad-l-body').data('key')=="simple_icons")
		{
			var icon = jQuery('ul.sicon-list li.active').clone();
			sicon_engine.parent().find('input[type=text]').val(icon.children('i').removeClass('icon').attr('class'));
	 		sicon_engine.parent().find('input[type=text]').trigger('keyup');
		}
		else if(rad_lightbox.find('div.rad-l-body').data('key')=="icons")
		{
			var query ='[ioa_icon ';
			var du = icon_canvas.find('i').clone();
			du.removeClass('none ioa-front-icon border-style border-style-circ background-style background-style-circ longshadow-style longshadow-style-circ');
				
			switch(jQuery('.icn_style').val())
			{
				case 'none' :  query += ' icon_type="default" icon_class="'+du.attr('class') +'"  color="'+rad_lightbox.find('.color').val()+'"  '; break;
				case 'border-style' :  query += ' icon_type="border-style" icon_class="'+du.attr('class') +'" border_color="'+rad_lightbox.find('.border_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;
				case 'border-style-circ' :  query += ' icon_type="border-style-circ" icon_class="'+du.attr('class') +'"  border_color="'+rad_lightbox.find('.border_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;

				case 'background-style' :  query += ' icon_type="background-style" icon_class="'+du.attr('class') +'"  background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;
				case 'background-style-circ' :  query += ' icon_type="background-style-circ" icon_class="'+du.attr('class') +'"  background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;

				case 'longshadow-style' :  query += ' icon_type="longshadow-style" icon_class="'+du.attr('class') +'"   background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'" '; break;
				case 'longshadow-style-circ' :  query += ' icon_type="longshadow-style-circ" icon_class="'+du.attr('class') +'"  background_color="'+rad_lightbox.find('.bg_color').val()+'" color="'+rad_lightbox.find('.color').val()+'"'; break;
			}	
			
			query += ' /]';

			icon_obj.parents('div.ioa_input').find('input,textarea').val(jQuery.trim(query));
			icon_obj.parents('div.ioa_input').find('input,textarea').trigger('change');
			icon_obj.parents('div.ioa_input').find('input,textarea').trigger('keyup');
			
			icon_obj.parents('.ui-tabs-panel').find('.icon_hidden').val(icon_canvas.html());

			

		}
		
		else if(rad_lightbox.find('div.rad-l-body').data('key')=="titan_media")
		{
			var query = '[titan_media]<sc>'+image_wrap.find('img.preview-image').attr('src')+'<sc>';
			jQuery('div.image-opts').find('div.ioa_input').each(function(i){

				query += ""+jQuery(this).data('element')+";"+jQuery(this).data('attr')+";"+jQuery(this).find('input,select').val()+"<lb>";

			});
			query += "<sc>[/titan_media]";
			//bg_rad.parents('div.component-body').find('.bg_data').val(query);
			rad_image_obj.parent().find('input').val(query);
			
		}
		else if(rad_lightbox.find('div.rad-l-body').data('key')=="hcon")
		{
			
		  	hcon_parent.data('align',rad_lightbox.find('.hcon_w_align').val());

		    var mr =  rad_lightbox.find('.hcon_w_tm').val()+":"+rad_lightbox.find('.hcon_w_rm').val()+":"+rad_lightbox.find('.hcon_w_bm').val()+":"+rad_lightbox.find('.hcon_w_lm').val();
			

			hcon_parent.data('margin',mr);
			hcon_parent.data('text',rad_lightbox.find('.hcon_w_txt').val());
        
			if( hcon_parent.data('val') == "social" )
			{
				var s_query = '';
				rad_lightbox.find('input[type=checkbox]').each(function(){

					if( jQuery(this).is(':checked') )
					{
						s_query += jQuery(this).val() + "<vc>" + rad_lightbox.find(".hcon_"+jQuery(this).val()).val()+"<sc>";
					}

				

				}); 	hcon_parent.data('text',s_query);
			}

		}

		rl.hide();
		rad_lightbox.find('.rad-l-body .component-opts').html('');
		
	});


  /**
 * Icon API =====================================================================================================
 */

var icon_canvas = '',icon_opts,icon_wrap='',icon_tabs;
   
doc.on('click','a.add-rad-icon',function(e){
		e.preventDefault();

		icon_obj = jQuery(this);

		rl.show('Select Icon');
		jQuery.post(jQuery('#backend_link').attr('href'),{ type:'icons', action: 'ioalistener' , 'current_icon' : icon_obj.parent().find('input').val() },function(data){

			rl.set(data,'icons');
			
			rad_lightbox.find('.sc-icon-list-wrap').height(rad_lightbox.height());

			parent = jQuery('.scourge');
			icon_canvas = parent.find('div.icon-preview-pane');
			icon_opts = parent.find('.sc-icon-list-wrap');

			setupIconPickers();

			jQuery('.sc-icon-listener.'+jQuery('.icn_style').val()).show();
			
		});
	});	

/**
 * Shortcode Event Listener
 */

var query,settings_lightbox,t;
doc.on('click','.save-shortcode-settings',function(e){
	e.preventDefault();
	query = '';
	settings_lightbox = jQuery('.settings-lightbox');
	switch(  settings_lightbox.data('sid') )
	{
		case 'rad-sidebar-widget' :
			query = "[sidebar ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]"
		break;

		case 'rad-button-widget' :
			query = "[button "; var l;
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!='label')
					query += inp.attr('name')+'="'+inp.val()+'" ';
				else
					l = inp.val();
			});
			query += "]"+l+"[/button]";
		break;

		case 'rad-gallery-widget' :
			query = "[ioa_gallery ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!="gallery_images")
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "]";

			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad_gallery_thumbs li").each(function(){
				query += "[ioa_gallery_item title='"+jQuery(this).data('title')+"' description='"+jQuery(this).data('description')+"' alt='"+jQuery(this).data('alt')+"' thumbnail='"+jQuery(this).data('thumbnail')+"' image='"+jQuery(this).data('image')+"' /] ";
			});

			query += "[/ioa_gallery]";

		break;
		case 'rad-tabs-widget' :
			query = "[tabs ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" #General_Fields").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!="rad_tab")
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "]";

			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .module_list .ioa_module").each(function(){
				query += "[tab title='"+jQuery(this).find('.tab_title').val()+"' icon='"+jQuery(this).find('.tab_icon').val()+"']"+jQuery(this).find('.tab_text').val()+"[/tab] ";
			});

			query += "[/tabs]";

		break;
		case 'rad-progressbar-widget' :
			query = "[progressbar_set ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" #General_Fields").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!="rad_tab")
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "]";

			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .module_list .ioa_module").each(function(){
				query += "[progress_bar pr_color='"+jQuery(this).find('.pr_color').val()+"' pr_label='"+jQuery(this).find('.pr_label').val()+"' pr_value='"+jQuery(this).find('.pr_value').val()+"' /] ";
			});

			query += "[/progressbar_set]";

		break;
		case 'rad-pricing-widget' : 

		query = "[pricing_table ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" #General_Fields").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!="rad_tab")
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "]";

			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .module_list .ioa_module").each(function(){
				query += "[pricing_column ";

				jQuery(this).find('.ioa_input').each(function(){
					inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
					query += inp.attr('name')+'="'+inp.val()+'" ';
				});
				query += "/]";

			});

			query += "[/pricing_table]";


		break;
		case 'rad-accordion-widget' :
			query = "[accordion ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" #General_Fields").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!="rad_tab")
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "]";

			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .module_list .ioa_module").each(function(){
				query += "[section title='"+jQuery(this).find('.tab_title').val()+"']"+jQuery(this).find('.tab_text').val()+"[/section] ";
			});

			query += "[/accordion]";

		break;
		case 'rad-toggle-widget' :
			query = "[toggle_set ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" #General_Fields").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!="rad_tab")
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "]";

			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .module_list .ioa_module").each(function(){
				query += "[toggle_item tab_state='"+jQuery(this).find('.tab_state').val()+"' title='"+jQuery(this).find('.tab_title').val()+"']"+jQuery(this).find('.tab_text').val()+"[/toggle_item] ";
			});

			query += "[/toggle_set]";

		break;
		case 'rad-logo-widget' :
			query = "[logo_area ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" #General_Fields").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!="rad_tab")
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "]";

			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .module_list .ioa_module").each(function(){
				query += "[logo_item logo_link='"+jQuery(this).find('.logo_link').val()+"' logo_label='"+jQuery(this).find('.logo_label').val()+"' logo_icon='"+jQuery(this).find('.logo_icon').val()+"' /] ";
			});

			query += "[/logo_area]";

		break;
		case 'rad-iconsets-widget' :
			query = "[icon_sets]";

			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .module_list .ioa_module").each(function(){
				query += "[icon_item social_link='"+jQuery(this).find('.social_link').val()+"' social_icon='"+jQuery(this).find('.social_icon').val()+"' social_label='"+jQuery(this).find('.social_label').val()+"' social_color='"+jQuery(this).find('.social_color').val()+"' /] ";
			});

			query += "[/icon_sets]";

		break;
		case 'rad-magic-widget' :
			query = "[magic_list ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" #General_Fields").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!="rad_tab")
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "]";

			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .module_list .ioa_module").each(function(){
				query += "[magic_list_item title='"+jQuery(this).find('.tab_title').val()+"' icon='"+jQuery(this).find('.tab_icon').val()+"']"+jQuery(this).find('.tab_text').val()+"[/magic_list_item] ";
			});

			query += "[/magic_list]";

		break;

		case 'rad-post-slider-widget' :
		query = "[post_slider ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break; 
		case 'rad-post-feature-widget': 

			query = "[post_featured ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break; 
		case 'rad-scrollable-widget' : 

			query = "[scrollable ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
					
					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break;
		case 'rad-testimonials-widget' : 

			query = "[testimonials ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
					
					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break;
		case 'rad-testimonial-widget' : 

			query = "[testimonial ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
					
					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break;
		case 'rad-image-widget' : 

			query = "[ioa_image ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
					
					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break;
		case 'rad-video-widget' : 

			query = "[ioa_video ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
					
					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break;
		case 'rad-divider-widget' : 

			query = "[ioa_divider ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
					
					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break;
		case 'rad-post-list-widget' : 

			query = "[post_list ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

				if(inp.attr('name')=='meta_value')
				{
					t = inp.val().replaceAll("]","5D");
					t = t.replaceAll("\'","3D");
					t = t.replaceAll("[","2D");
					query += inp.attr('name')+'="'+t+'" ';
				}
				else	
					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break; 

		case 'rad-post-masonry-widget' : query = "[post_masonry ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break; 
		case 'rad-cta-widget' : query = "[cta ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break; 
		case 'rad-intro-widget' : query = "[intro_text ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break; 
		case 'rad-radial-widget' : query = "[radial ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break;
		case 'rad-teamwidget-widget' :
			query = "[person ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" #General_Fields").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
				if(inp.attr('name')!="rad_tab")
				query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "]";

			
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .module_list .ioa_module").each(function(){
				query += "[icon_item social_link='"+jQuery(this).find('.social_link').val()+"' social_icon='"+jQuery(this).find('.social_icon').val()+"' social_label='"+jQuery(this).find('.social_label').val()+"' social_color='"+jQuery(this).find('.social_color').val()+"' /] ";
			});
			
			 query += "[/person]";

		break;

		case 'rad-counter-widget' : query = "[counter ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break;

		case 'rad-notification-widget' : query = "[notification ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]";

		break;



		case 'rad-post-grid-widget' :

			query = "[post_grid ";
			settings_lightbox.find('.'+settings_lightbox.data('sid')+" .rad-widget-settings").find('.ioa_input').each(function(){
				inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');

				if(inp.attr('name')=='meta_value')
				{
					t = inp.val().replaceAll("]","5D");
					t = t.replaceAll("\'","3D");
					t = t.replaceAll("[","2D");
					query += inp.attr('name')+'="'+t+'" ';
				}	
				else	
					query += inp.attr('name')+'="'+inp.val()+'" ';
			});
			query += "/]"; 

		break;
	}

	if( jQuery('#content').is(':visible') ) {
			    jQuery('#content').insertAtCaret(query);
	} else {
	    tinyMCE.getInstanceById('content').selection.setContent(query);
	}

	settings_lightbox.hide();
});

doc.on('click','.text-save-shortcode-settings',function(e){
		e.preventDefault();

		var query = "[ioa_column ",inp,text,inputs = jQuery('.text-settings-lightbox').find('.rad-widget-settings').find('.ioa_input');
		
		inputs.each(function(){
  			
  			inp = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
	        
  			if(inp.attr('name')!='text_data' && inp.attr('name')!='icon' && inp.attr('name')!='icon_hidden' && inp.attr('name')!='top_image' && inp.attr('name')!='button_label' && inp.attr('name')!='icon_margin' && inp.attr('name') !='col_link' && inp.attr('name') !='custom_link' )
  				query += inp.attr('name')+"='"+inp.val()+"' ";
  			else if(inp.attr('name')=='top_image' )
  				query += "image='"+inp.val()+"' ";
  			else if(inp.attr('name')=='button_label' )
  				query += "link_label='"+inp.val()+"' ";
  			else if(inp.attr('name')=='icon_margin' )
  				query += "icon_css='margin-top:"+inp.val()+"' ";
  			else if(inp.attr('name')=='col_link')
  			{
  				if(inp.val()!='none')
  				{
  					if(inp.val()=="custom") 
  						query += "link='"+inputs.find('.custom_link').val()+"' ";
					else 
						query += "link='"+inp.val()+"' ";
  				}
  			}

  			else if( jQuery(this).children('.ioa_input_holder').hasClass('editor') )
        	{

            	if( jQuery(this).find('.wp-editor-wrap').hasClass('html-active')) {
            	  text = inp.val();
           		} else {
              	  text = 	tinyMCE.getInstanceById(inp.attr('id')).getContent();
            	}
        	}



		});
			query += "icon='"+inputs.find('.icon_hidden').val()+"' ";
  			query += "]";
  			query += text+"[/ioa_column]";

  			tinyMCE.getInstanceById('content').selection.setContent(query);
  			jQuery('.text-settings-lightbox').hide();

})

doc.on('iconbind','.rad-lightbox',function(){

			parent = rad_lightbox.find('.scourge');
			icon_canvas = parent.find('div.icon-preview-pane');
			icon_opts = parent.find('.sc-icon-list-wrap');

			setupIconPickers();


})


doc.on('click', '#s-column-maker .top-bar a' , function(e){
	e.preventDefault();
	var col = jQuery(this).attr('href');
	var last ='' ;
	 col+= ' col';
	if(jQuery(this).hasClass('last')) last = 'last';
	temp = "<div class='"+col+" "+last+"  clearfix'><p>Content</p> <i class='ioa-front-icon cancel-circled-1icon-'></i></div>";

	if(jQuery(this).hasClass('last') || jQuery(this).attr('href') == 'full' ) temp += "<div class='clearfix'> &nbsp; </div> ";

	jQuery('div.column-maker-area').append(temp);

});

doc.on('click','div.column-maker-area i',  function(e){
	
	jQuery(this).parent().remove();
});


function setupIconPickers()
	{
		jQuery('.scourge .ioa-minicolors').each(function(){

		jQuery(this).minicolors({
			textfield : true,
			opacity: false,
			hide: function(hex, opacity) { 

				icon_canvas.find('i').css( jQuery(this).parents('.ioa_input').data('attr') , jQuery(this).val() )
				if(  jQuery(this).attr('id') == 'bg_color' && (jQuery('.icn_style').val() == 'longshadow-style' || jQuery('.icn_style').val() == 'longshadow-style-circ' ) )
				{
					obj = increase_brightness( jQuery(this).val(),50);
					icon_canvas.find('i').css( 'text-shadow' ,  ""+obj+" 1px 1px,"+obj+" 2px 2px,"+obj+" 3px 3px,"+obj+" 4px 4px,"+obj+" 5px 5px, "+obj+" 6px 6px,"+obj+" 7px 7px,"+obj+" 8px 8px,"+obj+" 9px 9px,"+obj+" 10px 10px,"+obj+" 11px 11px,"+obj+" 12px 12px,"+obj+" 13px 13px,"+obj+" 14px 14px,"+obj+" 15px 15px,"+obj+" 16px 16px,"+obj+" 17px 17px,"+obj+" 18px 18px,"+obj+" 19px 19px,"+obj+" 20px 20px,"+obj+" 21px 21px");
				}

			  }

			});

		});
	}
doc.on('change','.icn_style',function(){
	icon_canvas.find('i').removeClass('none default border-style border-style-circ background-style background-style-circ longshadow-style longshadow-style-circ');
	icon_canvas.find('i').addClass(jQuery(this).val());

	jQuery('.sc-icon-listener').hide();
	jQuery('.sc-icon-listener.'+jQuery(this).val()).show();

	icon_canvas.find('i').removeAttr('style');

	

});

doc.on('click','.sc-icon-list-wrap li',function(){
		temp = jQuery(this);
		var t = icon_canvas.find('i').attr('style');

		icon_canvas.html( temp.html() );
		icon_canvas.find('i').addClass(jQuery('.icn_style').val());
		icon_canvas.find('i').attr('style',t);	
		});

	doc.on('change','div.scourge input',function(){

		temp = jQuery(this).parents('div.ioa_input');
		var attr = temp.data('attr') ;
		var el = temp.data('element');

	});



	doc.on('click','#sc-icon-import',function(e){
		e.preventDefault();
		sc_oc =	jQuery(this);
		
		hmedia.open(sc_oc.data('title'),sc_oc.data('label'),function(images){ 
		

			icon_canvas.find('img').attr('src', images[0].url);
			

		});

		
	}); 

	/**
	 * Custom Panel , Layout settings
	 */
	
	if(jQuery('.page_layout').val()!="")
	jQuery('.layout-list').find('.'+jQuery('.page_layout').val()).addClass('active');
	
	jQuery('.layout-list  li').click(function(e){
		e.preventDefault();
		jQuery('.layout-list  li').removeClass('active');
		parent = jQuery(this).addClass('active');

		jQuery('.page_layout').val(parent.data('val'));

	});



doc.on('click','a.query-maker',function(e){
    	e.preventDefault();
    	query_engine = jQuery(this);
	var pt = query_engine.parents('div.inner-body-wrap,div.ioa-query-box,.ex-shortcode-mods , .ui-tabs-panel').find('.post_type,.shortcodes_val_holder,.custom_post_type').val();
	
	if(pt=="" || typeof pt == "undefined") pt ="post";
	console.log(pt);
	rl.show('Query Engine');
	jQuery.post(jQuery('#backend_link').attr('href'),{ type:'query_engine', action: 'ioalistener' , post_type : pt },function(data){
		rl.set(data,'query_engine');
	});

    });


doc.on('click','a.icon-maker',function(e){
    	e.preventDefault();
    	sicon_engine = jQuery(this);
  
	rl.show('Icons');
	jQuery.post(jQuery('#backend_link').attr('href'),{ type:'simple_icons', action: 'ioalistener' },function(data){
		rl.set(data,'simple_icons');
		
	});

    });

var sclist = '';
 doc.on('keyup','.sicon-search-input',function(e){
     	query = jQuery(this).val().toLowerCase();
     	qar = query.split(' ');
     	qlen = 	qar[0].length;

     	if(rad_lightbox.find('div.rad-l-body').data('key') == 'simple_icons')
     		sclist = rad_lightbox.find('.sicon-list li');
     	else
     		sclist = rad_lightbox.find('.sc-icon-list li');


     	sclist.hide();
   		
   		if(qlen >= 2)
    	{
    			
	    		sclist.each(function(){
	    			test = []; temp = jQuery(this); fn = true;
	    			for(var i=0;i<qar.length;i++) {

	    				if( temp.children('i').attr('class').indexOf(qar[i]) != -1 )
	    					test[i] = true;
	    				else
	    					test[i] = false;

	    			}
	    			
	    			for(var i=0;i<test.length;i++) 	fn = fn && test[i];

	    			if(fn === true) jQuery(this).show();

	    		});

    		
    	}
    	else
    	{
    		sclist.show();
    	}

    });	

/**
 * Media Manager Code
 */


var current_media_item = null,mediamanager = jQuery('div.mediamanager') , mtemp ;
var options_tab = mediamanager.find('#slider_options');
var sl, mlist=  jQuery('div.slides'), mslide= jQuery('div.hide div.media-slide') , slides_tab = mediamanager.find('#slider_slides');

jQuery('.inner-slide-body-wrap').tabs();

doc.on('focusout','.mm-filter .text_title',function(){
	 jQuery(this).parents('.media-slide').find('.media-slide-head h6').html( jQuery(this).val() ); 
});

options_tab.find('.so-opts').hide();
options_tab.find('.so-opts.so-'+jQuery('.slider_type').val()).show();

jQuery('.slider_type').change(function(){

	options_tab.find('.so-opts').hide();
	options_tab.find('.so-opts.so-'+jQuery(this).val()).show();

});

mlist.children('div.media-slide').each(function(){
	
	parent = jQuery(this);
	//temp = parent.find('.slide_type').val();
	obj =  parent.find('.background_opts').val();
	mtemp = parent.find('.caption_position').val();

	if( options_tab.find('.slider_type').val() == "quantum_slider" )
	{
		parent.find('.mm-filter.full-image').hide();
	}
	else
		parent.find('.mm-filter.full-image').show();

	if(obj!="")
    parent.find('.mm-bg-listener.'+obj).show();

    parent.find('.slide-pos-grid').children().removeClass('active');

    if(mtemp!="")
    parent.find('.slide-pos-grid').children('.'+mtemp).addClass('active');

});

var mm_grids = jQuery('.slide-pos-grid').children();
doc.on('click','.slide-pos-grid>div',function(){
	temp = jQuery(this);
	
	temp.parent().children().removeClass('active');
	temp.parents('.inner-body-wrap').find('.caption_position').val(temp.attr('class'));
	
	temp.addClass('active');

});

doc.on('change',  'div.media-slide .background_opts',  function(){
   parent = jQuery(this).parents('.inner-body-wrap');
   parent.find('.mm-bg-listener').hide();

   if( jQuery(this).val()!="" )
   parent.find('.mm-bg-listener.'+jQuery(this).val()).show();


});

doc.on('change',  'div.media-slide .slide_type',  function(){
	
	parent = jQuery(this).parents('.inner-body-wrap');

	parent.find('.mm-filter').hide();
  
   if( jQuery(this).val()!="" )
	parent.find('.mm-filter.'+jQuery(this).val()).show();

});


var murl = jQuery('.ioa_panel_wrap').data('url');
jQuery('a.create_slider_button').click(function(e){
	e.preventDefault();
	loader.show();
	sl = jQuery('.create-slider-section input[type=text]').val();
	jQuery.post(murl,{ type:"create", action: 'ioalistener', key :  "ioamediamanager" , value : sl },function(data){

		loader.hide();
		ioa_msg.setMessage('Slider Added','Slider '+sl+' successfully added !','information');
		ioa_msg.show();

		jQuery('div.slider-list').append( data );

	});

});




doc.on('click','a.close-media-body',function(e){
	e.preventDefault() 
	jQuery(this).parent().parent().fadeOut('fast');
});



doc.on('click','a.mslide-edit',function(e){
	e.preventDefault();
	var body = jQuery(this).parent().next();
		body.slideToggle('normal');
		

});

doc.on('click','a.mslide-delete',function(e){
	e.preventDefault();
	jQuery(this).parents('div.media-slide').hide('normal',function(){ jQuery(this).remove() });



});

jQuery('#add_media_quantum').click(function(e){

	e.preventDefault();
	temp =	jQuery(this);

	var tslide = mslide.clone();
	
	mlist.append(tslide);
	tslide.find('.ioa-minicolors').minicolors('destroy');
	tslide.find('.slider-component-tab').tabs();
	tslide.find('.ioa-minicolors').minicolors({
		textfield : true,
		opacity: false,
		change: function(hex, opacity) {
         
      	   jQuery(this).parent().next().val(opacity);    
       	   jQuery(this).trigger('change');
            
        }

	});

});

var targetOption;
jQuery('#add_media_slides').click(function(e){
	e.preventDefault();
	temp =	jQuery(this);
		
		hmedia.open("Add Media Slides","Add",function(images){ 
		
			for(var i=0;i<images.length;i++)
			{
				var tslide = mslide.clone();

				thumb = images[i].sizes.full.url;
				if( typeof images[i].sizes.thumbnail != 'undefined' )
					thumb = images[i].sizes.thumbnail.url;

				tslide.find('.alt_text').val(images[i].alt);
				tslide.find('.image').val(images[i].url); 
				tslide.find('.thumbnail').val(thumb);

				tslide.find('.text_title').val(images[i].title);
				tslide.find('.text_desc').val(images[i].description);
				tslide.find('div.media-slide-head').append("<h6>"+images[i].title+"</h6>");
				tslide.find('div.media-slide-head img').attr('src',thumb);
				mlist.append(tslide);
				tslide.find('.ioa-minicolors').minicolors('destroy');
				tslide.find('.slider-component-tab').tabs();
				tslide.find('.ioa-minicolors').minicolors({
					textfield : true,
					opacity: false,
					change: function(hex, opacity) {
                     
                  	   jQuery(this).parent().next().val(opacity);    
                   	   jQuery(this).trigger('change');
                        
                    }

				});

			}

			

		});

});



jQuery('.save_media_slides').click(function(e){
	e.preventDefault();
	loader.show();
	var input, val ,options = [] , slides = [];

	options_tab.find('div.ioa_input').each(function(i){

		input = jQuery(this).find('input,textarea,select');
		val = input.val();
		options[i] = { name : input.attr('name') , value : val  }

	});

	

	mlist.children('div.media-slide').each(function(j){

		var data = [];
		

		jQuery(this).find('div.ioa_input').each(function(k){

		input = jQuery(this).find('input,textarea,select');
		val = input.val();
		data[k] = { name : input.attr('name') , value : val  }

		});

		slides[j] = data;

	});

	jQuery.post(murl , { options : options, action: 'ioalistener' , slides : slides , key :  "ioamediamanager" , id : mlist.data('id') , type : 'update' } , function(data){
		loader.hide();
		ioa_msg.setMessage('Changes Saved','Slider Settings Saved successfully !','success');
		ioa_msg.show();


	});

});



doc.on('click','.slider-item a.cancel-circled-2icon-', function(e){
	e.preventDefault();
	loader.show();
	temp = jQuery(this);
	jQuery.post(cpurl,{ type:"delete", action: 'ioalistener', key :  "ioamediamanager" , id : temp.attr('href') },function(data){

		loader.hide();
		ioa_msg.setMessage('Slider Deleted !','Slider '+temp.parent().find('h6').html()+' has been deleted !','warning' );
		ioa_msg.show();

		temp.parent().transition({ opacity: 0 , scale:0}, 500 ,'', function(){ jQuery(this).remove() });	
	});

});

doc.on('mouseenter','div.media-slide',function(e){
	e.preventDefault();
	jQuery(this).find('div.media-slide-head>a.edit-icon').stop(true,true).fadeIn('normal');

});
doc.on('mouseleave','div.media-slide',function(e){
	e.preventDefault();
	jQuery(this).find('div.media-slide-head>a.edit-icon').stop(true,true).fadeOut('normal');

});



/**
 * Custom posts Manager code
 */


var ct = '',cpurl = jQuery('.ioa_panel_wrap').data('url')  , cpitem = jQuery('#cp_slides').find('div.hide div.cp-item');
jQuery('a.create_cp_button').click(function(e){
	e.preventDefault();
	loader.show();
	ct = jQuery('.create-cp-section input[type=text]').val();
	jQuery.post(cpurl,{ type:"create", action: 'ioalistener', key :  "custompostsmanager" , value : ct },function(data){

		loader.hide();
		ioa_msg.setMessage('New Post Type Added','Custom Post with name '+ct+' has been created.','information');
		ioa_msg.show();

		jQuery('div.cp-list').append( data );
	});

});
var cp_button = null;
doc.on('click','.cp-item a.cancel-circled-2icon-', function(e){
	e.preventDefault();
	loader.show();
	cp_button = jQuery(this);
	jQuery('.post_type_label').html(cp_button.prev().html());
	jQuery('div.ioac-delete-message').slideDown('fast');

});

jQuery('div.ioac-delete-message a').click(function(e){
	e.preventDefault();

	if( jQuery(this).attr('href') =="yes" )
	{
		jQuery.post(cpurl,{ type:"delete", action: 'ioalistener', key :  "custompostsmanager" , id : cp_button.attr('href') },function(data){

			loader.hide();
			ioa_msg.setMessage('Post Type Deleted !','Custom Post '+cp_button.parent().find('h6').html()+' has been deleted !' ,'warning' );
			ioa_msg.show();
			jQuery('div.ioac-delete-message').slideUp('fast');

			
			cp_button.parent().transition({ opacity: 0 , scale:0}, 500 ,'', function(){ jQuery(this).remove() });	
		
		});
	}
	else
	{
		loader.hide();
		jQuery('div.ioac-delete-message').slideUp('fast');

	}

});

 

jQuery('.save_cp_slides').click(function(e){
	e.preventDefault();
	loader.show();
	var input, val ,options = [] , mb = [];

	jQuery('#cp_slides').find('div.ioa_input').each(function(i){

		input = jQuery(this).find('input,textarea,select');
		val = input.val();
		options[i] = { name : input.attr('name') , value : val  }

	});

	jQuery('div.metaboxes-list').children('div.cp-slide').each(function(j){
		var opts = [];

		 jQuery(this).find('div.ioa_input').each(function(i){

		 		input = jQuery(this).find('input,textarea,select');
				val = input.val();
				opts[i] = { name : input.attr('name') , value : val  }

		 });

		 mb[j] = opts;
	});

	ct = jQuery('#cp_slides').find('.post_type').val();
	jQuery.post(murl , { title : ct, action: 'ioalistener',  options : options , metaboxes : mb , key :  "custompostsmanager" , id : jQuery('.metaboxes-list').data('id') , type : 'update' } , function(data){
		loader.hide();
		ioa_msg.setMessage('Changes Saved','Settings to Post Type '+ct+' has been successfully saved !','success');
		ioa_msg.show();
	});
	

});



doc.on('click','a.mcp-edit',function(e){
	e.preventDefault();
	var body = jQuery(this).parent().next();
	body.slideToggle('normal');
});


doc.on('click','a.mcp-delete',function(e){
	e.preventDefault();
	jQuery(this).parents('div.cp-slide').transition({ opacity: 0 , scale:0}, 500 ,'', function(){ jQuery(this).remove() });	

});

var cpslide = jQuery('#cp_options').find('.hide .cp-slide').clone();

jQuery('#add-cp-slides').click(function(e){
	e.preventDefault();
	temp =	jQuery(this);
		
		
				var tslide = cpslide.clone();
				
				tslide.find('.meta_name').val("Field "+(jQuery('.metaboxes-list').children().length+1));
				tslide.find('.cp-slide-head span').html("Field "+(jQuery('.metaboxes-list').children().length+1));

				tslide.find('.ioa-minicolors').minicolors('destroy');
				tslide.find('.slider-component-tab').tabs();
				tslide.find('.ioa-minicolors').minicolors({
					textfield : true,
					opacity: false,
					change: function(hex, opacity) {
                     
                  	   jQuery(this).parent().next().val(opacity);    
                   	   jQuery(this).trigger('change');
                        
                    }

				});
				jQuery('.metaboxes-list').find('.information').slideUp('normal');
				jQuery('.metaboxes-list').append(tslide);

				ioa_msg.setMessage('New Metabox Added','New MetaBox has been added, click to edit.','information');
				ioa_msg.show();
		
});






doc.on('click', 'ul.sicon-list li', function(e){
	jQuery('ul.sicon-list li').removeClass('active');
	jQuery(this).addClass('active');
	e.preventDefault();
});



doc.on('click','a.add-ioa-module',function(e){
	 	e.preventDefault();
	 	var mod = jQuery(this).parents('.ioa_module_container').find('div.module_list');
	 	var bl = jQuery(this).parents('.ioa_module_container').find('div.ioa_module.hide');
	 	bl = bl.clone().removeClass('hide');
	 	
	 	mod.append(bl);	
	 	bl.find('.ioa-minicolors').minicolors('destroy');
		bl.find('.ioa-minicolors').minicolors({
					textfield : true,
					opacity: false,
					change: function(hex, opacity) {
                     
                  	   jQuery(this).parent().next().val(opacity);    
                   	   jQuery(this).trigger('change');
                        
                    }

				});
		bl.find('.minicolors.minicolors-theme-default').wrap('<div class="ioa_input_holder"><div class="colorpicker-wrap"></div></div>');
	 	bl.find('.minicolors.minicolors-theme-default').parent().append("<a class='picker-delete' href=''></a>");
	 	mod.sortable({ handle : '.module_head' , stop: function( event, ui ) { computeModuleData( ui.item.parents('div.ioa_module_container')  );  }  });
	 	
	 });



doc.on('click','a.save-ioa-module',function(e){
	e.preventDefault(); 
	computeModuleData( jQuery(this).parents('div.ioa_module_container')  );
	temp = jQuery(this);
	temp.html(temp.data('save'));
	setTimeout(function(){ temp.html(temp.data('restore')); },500)
});

if( jQuery('div.module_list').length > 0 )
jQuery('div.module_list').sortable({ stop: function( event, ui ) { computeModuleData( ui.item.parents('div.ioa_module_container')  );  }  });

	 jQuery(document).on('click','div.module_head a.edit-mod',function(e){
	 	e.preventDefault();

	 	jQuery(this).parent().next().slideToggle('normal');

	 });

	  jQuery(document).on('click','div.module_head a.clone-mod',function(e){
	 	e.preventDefault();

	 	temp = jQuery(this).parents('.ioa_module');
	 	obj = temp.clone();	
	 	temp.after( obj );

	 	obj.find('.ioa-minicolors').minicolors('destroy');
		obj.find('.ioa-minicolors').minicolors({
					textfield : true,
					opacity: false,
					change: function(hex, opacity) {
                     
                  	   jQuery(this).parent().next().val(opacity);    
                   	   jQuery(this).trigger('change');
                        
                    }

				});
		obj.find('.minicolors.minicolors-theme-default').wrap('<div class="colorpicker-wrap"></div>');
		var v;
		obj.find('.ioa_input').each(function(){

			v = jQuery(this).find('input[type=text],textarea,select,input[type=hidden]');
			v.val( temp.find( "."+v.attr('name')).val() );
		});

	 });

 

 jQuery(document).on('click','a.delete-mod',function(e){
	e.preventDefault();
	var p = jQuery(this).parents('div.ioa_module_container');
	jQuery(this).parents('div.ioa_module').remove();
	computeModuleData(p);
 	
 });


jQuery(document).on('click','.feature-column-head',function(e){
	jQuery(this).next().slideToggle('normal');

	});

var pr = jQuery("#s-pricing_table");

doc.on('click','#pricingtable-insert',function(e){
	e.preventDefault();
	var code = '';
 	
 	if( pr.find('.feature_column').val() == "true" )
 	{
 		code += '[feature_column ';

 		pr.find('.feature-col').each(function(){
 			code += jQuery(this).data('value')+"='"+jQuery(this).find('input,textarea').val()+"'";
 		});

 		code += ' /]';
 	}
 	var s,t,cols = jQuery('.pricing_cols').val().split('[ioa_mod]');

 	for(var i=0;i<cols.length;i++)
 	{
 		if(cols[i]!="")
 		{
 			code += "[column ";
	 		t = cols[i].split("[inp]");
	 		
	 		for(var j=0;j<t.length;j++)
	 		{
	 			if(t[j]!="")
	 			{
	 				 s = t[j].split('[ioas]');
 				 	code += s[0]+"='"+s[1]+"' ";
	 			}	
	 		}
	 		
	 		code += "/]";
 		}
 	}
 		
 	if( jQuery('#content').is(':visible') ) {
			    jQuery('#content').insertAtCaret("[pricing_table]"+code+"[/pricing_table]");
	} else {
	    tinyMCE.activeEditor.selection.setContent("[pricing_table]"+code+"[/pricing_table]");    
	}
	
 });

jQuery('#ioa-intro-trigger').click(function(e){
	e.preventDefault();
	
	introJs().start().onchange(function(targetElement) {  
  		
  		if( jQuery(targetElement).hasClass('ui-tabs-anchor') )
  		{
  			jQuery(targetElement).trigger('click');
  		}

	});
	

	});


doc.on('click','.vdelete',function(e){
	jQuery(this).parent().remove();
	e.preventDefault();
})
jQuery('#save_visualizer').click(function(e){
  var data = [],bgs = [];

  jQuery('.vlist-item').each(function(i){
  	data[i] = { key : jQuery(this).find('.key').val() ,  logo : jQuery(this).find('.vlogo').val() , thumb : jQuery(this).find('.vthumb').val()  } ;
  });

  jQuery('.bg-image-area .vimage').each(function(i){
  		bgs[i] = { src : jQuery(this).find('img').attr('src') ,  thumb : jQuery(this).find('img').data('thumb') ,  alt : jQuery(this).find('img').attr('alt') } ;
  });


	jQuery.post( jQuery('#backend_link').attr('href') ,{ type : 'visualizer_save', action: 'ioalistener' , data : data , images : bgs},function(data){
    			ioa_msg.show(); loader.hide(); 
    		});	
    		e.preventDefault();
});


doc.on('click','.v-image-upload',function(e){
		e.preventDefault();
		temp =	jQuery(this);
		
		hmedia.open(temp.data('title'),temp.data('label'),function(images){ 
		

		var str = '';

		for(var i=0;i<images.length;i++)
		{
			thumb = images[i].sizes.full.url;
				if( typeof images[i].sizes.thumbnail != 'undefined' )
					thumb = images[i].sizes.thumbnail.url;

			str += "<div class='vimage'><a class='vdelete' href=''></a><img src='"+images[i].url+"' data-thumb='"+thumb+"' alt='"+images[i].alt+"'  /></div>";
		}
		temp.next().append(str);
		});

		
	}); 


});

 function computeModuleData(parent)
	 {
	 	var code = '',temp;

	 	parent.find('div.module_list').children().each(function(){
	 		code += "[ioa_mod]";

	 		jQuery(this).find('div.ioa_input').each(function(){
	 			temp  = jQuery(this);

	 			code += "[inp]"+temp.find('input,select,textarea').attr('name')+"[ioas]"+temp.find('input,select,textarea').val()+"[ioas]";

	 		});

	 	});

	 	parent.find('.mod_data').find('input').val(code);
	 	parent.find('.mod_data').find('input').trigger('change');
	 }



function maptoHconObj(target,source)
{

   var str,s,te =  target.children('.save-data'),inp,val;
   
   computeModuleData( source.find('div.ioa_module_container')  );

   source.find('.ioa_input').each(function(){
      inp = jQuery(this).find('input[type=text],textarea,select,input[type=checkbox]');
      val = inp.val();

      if( inp.is(':checkbox') )
      {
        str = '';
        jQuery(this).find('input[type=checkbox]').each(function(){

            if( jQuery(this).is(':checked') )
              str += jQuery(this).val()+';';
        });
        val = str;
      }

      if( jQuery(this).children('.ioa_input_holder').hasClass('editor') )
        {

            if( jQuery(this).find('.wp-editor-wrap').hasClass('html-active') ) {
                val  =  inp.val();
            } else {
                 val  = tinyMCE.get('text_data').getContent();
            }


        }

        if( jQuery(this).hasClass('hidden-field') )
        {
          inp = jQuery(this).find('input[type=hidden]');
          val = inp.val(); 

        }

        te.find('.'+inp.attr('name')).val( val );

   });

}

function mapHconSettings(target,source)
{
  var te =  target.children('.save-data'); 
    source.children('.save-data').children().each(function(){
       te.find('.'+jQuery(this).attr('name')).val(jQuery(this).val());
    });
}

function maptoHconLightbox(target,source)
{
  
  jQuery('.hcon-lightbox').hide();
  var val,inp,s,te =  source.children('.save-data');
  target.show();
  
  
  target.find('.ioa_input').each(function(){
       
       inp = jQuery(this).find('input[type=text],textarea,select,input[type=checkbox],input[type=hidden]');

       s = inp.attr('name');
       s = te.find('.'+s).val();

      if( inp.is('select') )
      {
         selectOptionByText(inp,s);
      }
      else if(inp.is(':checkbox'))
      {
        s = s.split(';');
        console.log(s);
        inp.removeAttr('checked');
        for(var i=0;i<s.length;i++)
          jQuery(this).find('input[value="'+s[i]+'"]').attr('checked','checked');
      }
      else
      {

        if(inp.hasClass('ioa-minicolors') && typeof s != "undefined" )
        {
          inp.minicolors("value",s).trigger('click');
        }
        else if( jQuery(this).children('.ioa_input_holder').hasClass('editor') )
        {

             if( jQuery(this).find('.wp-editor-wrap').hasClass('html-active') ) {
              inp.val(s);
            } else {
               tinyMCE.get('text_data').setContent(s);
            }


        }
        else
          inp.val(s);

        if( jQuery(this).find('.ioa_slider').length > 0 )
        {
           jQuery(this).find('.ioa_slider').slider( "value", s );
        }  

      }

      if( jQuery(this).find('.rad_gallery_thumbs').length > 0 )
      {
         var gl = '';
         var srcs = s.split(';'),gls;
         for(var i=0;i<srcs.length;i++)
         {
          if(srcs[i]!="")
          {
            gls = srcs[i].split("<<");
          gl += "<li data-thumbnail='"+gls[1]+"' data-image='"+gls[0]+"' data-alt='"+gls[2]+"' data-title='"+gls[3]+"' data-description='"+gls[4]+"' ><img src='"+gls[1]+"' /> <a class='close' href=''></a></li>";
          
          }
         }

         jQuery(this).find('.rad_gallery_thumbs').html(gl);


      }


     
  });

  target.find('.ioa_module_container').each(function(){

      var tabs = jQuery(this).find('.rad_tab').val().split('[ioa_mod]');
      var list = jQuery(this).find(".module_list");
      var tab,clone,mod =  jQuery(this).find('div.ioa_module.hide').clone().removeClass('hide'); 
      list.html('');
      
      for(var k=0;k<tabs.length;k++)
      {
        
        if(jQuery.trim(tabs[k])!="")
        {
          clone = mod.clone();
          tab = tabs[k];
          tab = tab.split("[ioas]");
          
          if(tab.length==1) tab = tabs[k].split(";");

          list.append(clone);
          
          var h =0;
          while(h<tab.length)
          {
            
            if(tab[h]!="")
            clone.find("."+tab[h].replace("[inp]","")).val(tab[h+1]);
            
            h= h+2;
            
          }
          

        }
      }


  });


  setTimeout(function(){

        target.find('.ioa_module_container').find('.ioa-minicolors').minicolors('destroy');
      target.find('.ioa_module_container').find('.ioa-minicolors').minicolors({
          textfield : true,
          opacity: false,
          change: function(hex, opacity) {
                     
                       jQuery(this).parent().next().val(opacity);    
                       jQuery(this).trigger('change');
                        
                    }

        });

      },100);

}
