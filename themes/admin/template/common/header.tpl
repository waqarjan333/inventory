<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="../themes/admin/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="../themes/admin/javascript/jquery/ui/themes/ui-lightness/ui.all.css" />
<?php foreach ($styles as $style) { ?>
<link rel="stylesheet" type="text/css" href="../themes/admin/stylesheet/<?php echo $style; ?>" />
<?php } ?>
<script type="text/javascript" src="../themes/admin/javascript/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/ui/ui.core.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/superfish/js/superfish.js"></script>
<script type="text/javascript" src="../themes/admin/javascript/jquery/tab.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="../themes/admin/javascript/<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript"> 
function getURLVar(urlVarName) {
	var urlHalves = String(document.location).toLowerCase().split('?');
	var urlVarValue = '';
	
	if (urlHalves[1]) {
		var urlVars = urlHalves[1].split('&');

		for (var i = 0; i <= (urlVars.length); i++) {
			if (urlVars[i]) {
				var urlVarPair = urlVars[i].split('=');
				
				if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
					urlVarValue = urlVarPair[1];
				}
			}
		}
	}
	
	return urlVarValue;
}   
function left_nav(element){
	jQuery(element).each(function(){	
		var currentlistitem;
		currentlistitem = jQuery(this).find(">li"); 
		currentlistitem.each(function() {	
			if (!jQuery(this).find('ul').hasClass('opened')){
			   jQuery(this).find('ul').addClass("closed").css({display:"none"});
			}
		}); 
		currentlistitem.find('a:eq(0)').each(function(){
			jQuery(this).click(function() {	
				if(jQuery(this).next('ul').hasClass('closed')){
					jQuery(this).next('ul').slideDown(200).removeClass("closed");
					return false;
				}else{
					jQuery(this).next('ul').slideUp(200).addClass("closed");	
					return false;
				}
			});	
		});
	});
} 
function top_tab(wrapper, header, content){
	var title = wrapper + " " + header;
	var container_to_hide = wrapper + " " + content;
	var duration = 200; 
	if (jQuery.browser.msie) duration = 10; 
	disable = false; 
    jQuery(title).each(function(i){
		 if (i == 0){
			jQuery(wrapper).prepend("<div class='jquery_tab_container'><a href='/' class='heading_tab advanced_link active tab"+(i+1)+"'>"+jQuery(this).html()+"</a></div>");
		 }else{
			jQuery(".advanced_link:last").after("<a href='/'class='heading_tab advanced_link tab"+(i+1)+"'>"+jQuery(this).html()+"</a>");
		 }
	   }
   ); 
   jQuery(container_to_hide).each(function(i){
	     jQuery(this).addClass("tablist list_"+i); 
			 if(i != 0){
				 jQuery(this).css({display: "none"});
			 }
		 }
   );
   jQuery(".advanced_link").each(function(i){
	      jQuery( this ).bind ("click",function(){
			  if(jQuery(this).hasClass('active')){return false}
														 if(disable == false){disable = true;
														 jQuery(".advanced_link").removeClass("active");
														 jQuery(this).addClass("active");
														 
														 jQuery(container_to_hide+":visible").fadeOut(duration,function(){
																	
																	jQuery(".list_"+i).fadeIn(duration, function(){disable=false; });
																								   });
														 }
														 return false;

														 });
						  }
					  );
}
$(document).ready(function() {
	route = getURLVar('route'); 
	if (!route) {
		$('#dashboard ul:first-child').addClass('current');
		$('#dashboard ul').addClass('opened');
	} else {
		part = route.split('/'); 
		url = part[0]; 
		if (part[1]) {
			url += '/' + part[1];
		}  
		$('a[href$=\'' + url + '\']').parents('li:eq(0)').addClass('current');
		$('a[href$=\'' + url + '\']').parents('ul:eq(0)').addClass('opened');
		//$('a[href*=\'' + url + '\']').parents('li[id]').addClass('current');
	}
	//calling the other functions after the document load
	//jQuery.noConflict();
	left_nav(".nav");   //the left menu sliding divs
	top_tab('#content','.jquery_tab_title','.jquery_tab');  // calling the divs
	
});
</script>
</head>
<body>
<div id="top">
  <div id="head">
       <h1 class="logo"><a href="javascript:void(0);" onclick="location = '<?php echo $home; ?>'"><?php echo $site; ?></a></h1>
       <div class="head_memberinfo">
       <?php if ($logged) { ?>
            <span class='memberinfo_span'>
                <?php echo $logged; ?>
            </span> 
            <span>
                <ul class="topnav right"> 
                <li id="site"><a class="top" href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
              </ul> 
            </span> 
         <?php } ?>
        </div><!--end head_memberinfo-->
  </div><!--end head--> 