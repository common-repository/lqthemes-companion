jQuery(document).ready(function($) {
	
	/* woocommerce */

	$('#grid').click(function() {
		$(this).addClass('active');
		$('#list').removeClass('active');
		$.cookie('gridcookie','grid', { path: '/' });
		$('.archive .post-wrap ul.products').fadeOut(300, function() {
			$(this).addClass('grid').removeClass('list').fadeIn(300);
		});
		return false;
	});

	$('#list').click(function() {
		$(this).addClass('active');
		$('#grid').removeClass('active');
		$.cookie('gridcookie','list', { path: '/' });
		$('.archive .post-wrap ul.products').fadeOut(300, function() {
			$(this).removeClass('grid').addClass('list').fadeIn(300);
		});
		return false;
	});

	if ($.cookie('gridcookie')) {
        $('.archive .post-wrap ul.products, #gridlist-toggle').addClass(jQuery.cookie('gridcookie'));
    }

    if ($.cookie('gridcookie') == 'grid') {
        $('.gridlist-toggle #grid').addClass('active');
        $('.gridlist-toggle #list').removeClass('active');
    }

    if ($.cookie('gridcookie') == 'list') {
        $('.gridlist-toggle #list').addClass('active');
        $('.gridlist-toggle #grid').removeClass('active');
    }

	$('#gridlist-toggle a').click(function(event) {
	    event.preventDefault();
	});
	
	$(".cactus-e-testimonial-carousel").owlCarousel({
                items: 1
            });
	$(".owl-carousel-1").owlCarousel({
                items: 6
            })
	
	var lqSlider = function (){
		if($('.lq-widget-slider').length){
		
		$('.lq-widget-slider').each(function(index, element) {
			var slider_options = $(this).data('options');
            $(this).owlCarousel(slider_options);
        });
		
		}
	}	
	
	lqSlider();
	
	//countdown
	$(function(){
		$(".lq-widget-countdown").each(function(index, element) {
            $(this).countDown({
			  startTimeStr: $(this).data('now'),
			  endTimeStr: $(this).data('date'),
			  daySelector:".lq-countdown-days",
			  hourSelector:".lq-countdown-hours",
			  minSelector:".lq-countdown-minutes",
			  secSelector:".lq-countdown-seconds"
			  });
        });
		
	})


});

// countdown
(function($){var intervalDate;var day,hour,min,sec;$.fn.extend({countDown:function(options){var opts=$.extend({},defaults,options);this.each(function(){var $this=$(this);var nowTime=new Date().getTime();var startTime=new Date(opts.startTimeStr).getTime();var endTime=new Date(opts.endTimeStr).getTime();endTime=endTime>startTime?endTime:startTime;startTime=endTime>startTime?startTime:endTime;intervalDate=setInterval(function(){nowTime=new Date().getTime();if(startTime>=nowTime){$this.beforeAction(opts);clearInterval(intervalDate);}else if(endTime>=nowTime){var t=endTime-nowTime;day=Math.floor(t/1000/60/60/24);hour=Math.floor(t/1000/60/60%24);min=Math.floor(t/1000/60%60);sec=Math.floor(t/1000%60);$(opts.daySelector).html($this.doubleNum(day));$(opts.hourSelector).html($this.doubleNum(hour));$(opts.minSelector).html($this.doubleNum(min));$(opts.secSelector).html($this.doubleNum(sec));}else{$this.afterAction(opts);clearInterval(intervalDate);}},1000);});},doubleNum:function(num){if(num<10){return "0"+num;}else{return num+"";}},beforeAction:function(options){$(options.daySelector).parent().html();},afterAction:function(options){$(options.daySelector).parent().html();}});var defaults={startTimeStr:"2018/01/10 00:00:00",endTimeStr:"2018/01/17 23:59:59",daySelector:".day",hourSelector:".hour",minSelector:".min",secSelector:".sec"}})(jQuery)