(function($) {
  
    
   $("ul.subcategory--tabs li").click(function() {
   	$("ul.subcategory--tabs li a").removeClass('active-tab');
   	$(this).find("a").addClass('active-tab');
   	 var tab_clicked = $(this).find("a").attr('id');
   	$(".tabs-content").slideUp();
   	$(".tabs-content").removeClass('.active-content');

   	 
   	 $('#' + tab_clicked + '-content').slideDown(1000);
   });

	
})(jQuery);


