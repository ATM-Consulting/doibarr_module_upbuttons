<?php

	header('Content-Type: application/javascript');
	
	require '../config.php';

	if(empty($user->rights->upbuttons->useit)) exit;

	
?>$(document).ready(function() {
  var $el = $('div.tabsAction').first();
  
  $(document).on("contextmenu",function(e){
        if(e.target.nodeName != "INPUT" && e.target.nodeName != "TEXTAREA") {
          		e.preventDefault();
  		
		var X = e.originalEvent.clientX;
		var Y = e.originalEvent.clientY;

		$ul = $('<ul style="float:left;"></ul>');
	    $('div.tabsAction:first').find('a,#action-clone').each(function(i,item) {
        	$item = $(item);
       		var $a = $item.clone(true, true);
        	$a.addClass('butAction');
      		$li = $('<li />');
      		$li.append($a);
    
       		$ul.append($li);
		});
		
		$ul2 = $('<ul style="float:left;"></ul>');
	    
	    $('div.fiche div.tabs:first>div.tabsElem').find('a,#action-clone').each(function(i,item) {
        	$item = $(item);
       		var $a = $item.clone(true, true);
        	$a.addClass('butAction');
      		$li = $('<li />');
      		$li.append($a);
    
       		$ul2.append($li);
		});
			
		$("#upbuttons-contextmenu").remove();
		$div = $('<div id="upbuttons-contextmenu"></div>');

		if($ul.html()!="") $div.append($ul);
		if($ul2.html()!="") $div.append($ul2);
		$div.append('<div style="clear:both"></div>');
		
		$('body').append($div);
		
		var top = Y - $div.find('ul:first').height()/2;
		var left =  X-$div.width()/2;
		if(top<0) top = 0;
		if(left<0) left = 0;
		
		
		$div.css({
			top:top
			,left:left
			,position:'fixed'
			,'z-index':999
			
		}).mouseleave(function() {
			$(this).remove();
		});
  	}
  
  });
  
  <?php
  	if(!empty($user->rights->upbuttons->UseAllButton)) {
  		echo '$("body").append("'.addslashes('<a href="javascript:;" id="justOneButton" style="display:none;">'.img_picto('','all@upbuttons').'</a>').'");';
  	}
  ?>
  
  
  function scrollButtonsToUp() {
  		 var scrollTop = $(window).scrollTop();
  		 var scrollLeft = $(window).scrollLeft();
	  	 var wHeight  = $( window ).height();
	  	 var wWidth  = $( window ).width();

	  	  if((scrollTop + wHeight < originalElementTop) || (scrollLeft + wWidth < originalElementLeft)) {
	  	  	//console.log("tabsAction not in screen ");
	  	  	
	  	  	$el.css({
	  	  		position:"fixed"
	  	  		,bottom:'-1px'
	  	  		,right:'-1px'
	  	  		,'background-color':'#fff'
	  	  		,padding:'20px 0 5px 20px'
	  	  		,border: '1px solid #e0e0e0'
	  	  		,'border-radius': '10px 0 0 0'
	  	  		,'margin':'0 0 0 0'
	  	  		,'opacity':1
	  	  	});
	  	  	
	  	  	$el.addClass('upbuttonsdiv');

			$('#justOneButton').click(function() {
				
				if($el.is(":visible")) {
					$el.hide();
					$(this).css('bottom', 20);
					
				}
				else {
					$el.show();
					$(this).css('bottom', $el.height() + 10);
					
				}
			});
			
										
	  	  	<?php
  				if(!empty($user->rights->upbuttons->UseAllButton)) {
  					?>
			  	  	$el.hide();
			  	  	$('#justOneButton').css({
			  	  		position:"fixed"
			  	  		,bottom:'20px'
			  	  		,right:'20px'
			  	  		,'margin':'0 0 0 0'
			  	  		,'opacity':0.7
			  	  	}).show();
			  	  	
			  	  	<?php
				}
				else {
					null;		
				}	
			 ?>
	  	  }	
	  	  else{
	  	  	//console.log("tabsAction in screen ");
	  	  	$el.removeAttr('style');
	  	  	$el.removeClass('upbuttonsdiv');
			$el.show();
			$('#justOneButton').hide();
	  	  }
  }
  
  var editline_subtotal = -1; /* .indexOf returns -1 if the value to search for never occurs */
  if (typeof referer !== 'undefined') editline_subtotal  = referer.indexOf('action=editlinetitle');
  
  if (editline_subtotal == -1 && ($el.length == 1 && ($el.find('.button').length>0 || $el.find('.butAction').length>0)))
  {
  		var originalElementTop = $el.offset().top;
		var originalElementLeft = $el.offset().left;
		
		if(originalElementTop <= 0) {
			window.setTimeout(function() { originalElementTop = $el.offset().top;originalElementLeft = $el.offset().left; scrollButtonsToUp(); },100);
		}
		$( window ).resize(function() {      	  
			scrollButtonsToUp();
		});
		
		$(window).on('scroll', function() {
			scrollButtonsToUp();
		});
		
		scrollButtonsToUp();
  }


 });
  
