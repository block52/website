/* # +------------------------------------------------------------------------+ */
/* # | Artlantis CMS Solutions                                                | */
/* # +------------------------------------------------------------------------+ */
/* # | Caledonian PHP Event Calendar                                          | */
/* # | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       | */
/* # | File Version  2.0                                                      | */
/* # | Last modified 30.06.15                                                 | */
/* # | Email         developer@artlantis.net                                  | */
/* # | Developer     http://www.artlantis.net                                 | */
/* # +------------------------------------------------------------------------+ */

parseInt('08', 10); //equals 8
parseInt('09', 10); //equals 9

$(document).ready(function(){
	
	// Fancybox
	$(".fancybox").fancybox();
	
	if ($.fn.iCheck) {
		// iCheck
		$(".iCheck").iCheck({
			checkboxClass: 'icheckbox_flat-red',
			radioClass: 'iradio_flat-red'
		});
	}
	
	// Remove Confirmation
	$(".delConf").click(function(e){
		
		e.preventDefault();
		var redir = $(this).data('redir');
		if(!$(this).data('calert')){
			$(this).data('calert','Are you sure to delete this record?')
		}
		
		if(confirm($(this).data('calert'))){
			if(redir){
				location.href = $(this).attr('href');
			}else{
				$(this).attr('checked',true);
			}
		}else{
			if(redir){
				return false;
			}else{
				$(this).attr('checked',false);
			}
		}
		
	});
	
	// Remove Confirmation iCheck
	if ($.fn.iCheck) {
		$('.iCheckDel').iCheck({
			checkboxClass: 'icheckbox_flat-red',
			radioClass: 'iradio_flat-red',
			check:function(){
				
			}
		});
	}
	$('.iCheckDel').on('ifClicked', function(e){
		
		var redir = $(this).data('redir');
		if(!$(this).data('calert')){
			$(this).data('calert','Are you sure to delete this record?')
		}
		

			if(confirm($(this).data('calert'))){
				$(e).iCheck('check');return false;
			}else{
				$(e).iCheck('uncheck');return false;
			}

		
	});
	
	/* Sidera Helper Opener */
	$(".shd-mh").bind('click',function(){
		var shd_key = $(this).data("shd-key");
		var sidera_helper_uri = '//poin.tips/p/artlantis/';
		$.fancybox({
						 autoSize   : true,
						 type       : "iframe",
						 href       : sidera_helper_uri + shd_key
						 });
	});
	
	  /* Toggle Opener */
	  $(".toggler").click(function(){
			var spanClass = $(this).find("span");
			$($(this).data("target")).slideToggle();
			
			if($(this).attr('data-target-focus')){
				formScrollTo($($(this).data("target-focus")));
			}
			
			if(spanClass.hasClass("glyphicon-chevron-down")){$(this).find("span.glyphicon-chevron-down").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");}
			else{$(this).find("span.glyphicon-chevron-up").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");}

	  });
	  
	  /* Close Fanxybox */
	  $(".closeModal").click(function(){
		  parent.$.fancybox.close();
	  });
	  
	/* Checkbox Selector */
	$('#checkAll').on('ifClicked', function(event){
	  if(!$(this).is(":checked")){
		  $(".checkRow").each(function(){
			$(".checkRow").iCheck('check');
		  }); 
	  }else{
		  $(".checkRow").each(function(){
			$(".checkRow").iCheck('uncheck');
		  }); 
	  }
	});
	
	/* Remove All Selector */
	$('.checkRow').on('ifChanged', function(event){
		if(!$(this).is(":checked")){
			$('#checkAll').iCheck('uncheck');
		}
	});
	
});

/* Hex String */
function generateHexString(length) {
  var ret = "";
  while (ret.length < length) {
    ret += Math.random().toString(16).substring(2);
  }
  return ret.substring(0,length);
}

/* Generate Key */
function genKey(sel){
	$(sel).val(generateHexString(26));
}

/* Custom Scroll */
function mcsb(sel){
	if($.fn.mCustomScrollbar !== undefined) {
		$(sel).mCustomScrollbar({
			scrollButtons:{
			  enable:true
			},
			theme:"dark-3"
		});
	}
}

/* Page Head Mod */
function pgTitleMod(t){
	$(document).find('title').prepend(t+' - ');
	$(".pg-head").html(t).addClass("text-magenta");
}

/* GET Ajax */
function getAjax(div,url,text){
	$(div).html(text);
	$.ajax({
	type: 'GET',
	url: url,
	success: function(data){
			$(div).html(data);
		},
	error: function(data){
		$(div).html('Error Occured!');
	}
	});
}

/* Scroll UP */
function formScrollTo(elem){
	$('html, body').animate({
		scrollTop: $(elem).offset().top
	}, 1000);
}