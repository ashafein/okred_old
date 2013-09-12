// JavaScript Document
//head

$(function() {
	$( "#tabs" ).tabs();
	if($.fn.tipsy)
	{
		$.fn.tipsy.defaults = {
			delayIn: 0,      // delay before showing tooltip (ms)
			delayOut: 100,     // delay before hiding tooltip (ms)
			fade: true,     // fade tooltips in/out?
			fallback: '',    // fallback text to use when no tooltip text
			gravity: 'w',    // gravity
			html: false,     // is tooltip content HTML?
			live: false,     // use live event support?
			offset: 2,       // pixel offset of tooltip from element
			opacity: 1,    // opacity of tooltip
			title: 'title',  // attribute/callback containing tooltip text
			trigger: 'hover' // how tooltip is triggered - hover | focus | manual
		};
		$( ".ztooltip-w").tipsy({gravity: 'w',fade: true});
		$( ".ztooltip-e").tipsy({gravity: 'e',fade: true});
		$( ".ztooltip-n").tipsy({gravity: 'n',fade: true});
		$( ".ztooltip-s").tipsy({gravity: 's',fade: true});
	}
});	
// Auth	
$(".topbar-authblock-link").click(function(){
	if($(".mail-widget").css('display') == "none")
	$(".mail-widget").css('display', "block")
	else
	$(".mail-widget").css('display', "none");
});

$(".mailbox-widget-ok-button").click(function(){
	var login = $("#b-domik-username").val();
	var pass = $("#b-domik-password").val();
	$.ajax({ 
		url:     "/_php/auth.php", //Адрес подгружаемой страницы 
		type:     "POST", //Тип запроса 
		dataType: "html", //Тип данных 
		data: ({login : login, pass : pass }),  
		success: function(html){
			$(".mail-widget").empty();
			$(".mail-widget").append(html);
		}
	});
});

if($(".maxexpand-a").fancybox)
{
	$(".maxexpand-a").fancybox({
		padding: 20,
		openEffect : 'elastic',
		openSpeed  : 300,	
		openOpacity : true,
		closeEffect : 'elastic',
		closeSpeed  : 150,
		closeClick : true,
		helpers : {
			overlay : {
				css : {
					'background' : 'rgba(0,0,0,0.46)'
				}
			}
		}
	});
}


(function($){
	$(window).load(function(){
		$(".widget-text-content").mCustomScrollbar({
			set_width:true, 
			set_height:false, 
			horizontalScroll:false, 
			scrollInertia:550, 
			scrollEasing:"easeOutCirc", 
			mouseWheel:"auto", 
			autoDraggerLength:false, 
			scrollButtons:{ 
				enable:true, 
				scrollType:"continuous", 
				scrollSpeed:20, 
				scrollAmount:40 
			},
			advanced:{
				updateOnBrowserResize:true, 
				updateOnContentResize:true, 
				autoExpandHorizontalScroll:false, 
				autoScrollOnFocus:true 
			},
			callbacks:{
				onScrollStart:function(){}, 
				onScroll:function(){}, 
				onTotalScroll:function(){}, 
				onTotalScrollBack:function(){}, 
				onTotalScrollOffset:0, 
				whileScrolling:false, 
				whileScrollingInterval:30 
			}
		});
		//demo fn
		$("a[rel='show-content']").click(function(e){
			e.preventDefault();
			$(".widget-text-content").mCustomScrollbar("update");
		});
		$("#").click(function(e){
			e.preventDefault();
			$(".widget-text-content").mCustomScrollbar("update");
		});
	});
})(jQuery);

$(function(){
	$("#drag1").draggable({cursor: "move"});
	$("#drag2").draggable({cursor: "move"});
	$("#drag3").draggable({cursor: "move"});
	$("#drag4").draggable({cursor: "move"});
	$("#drag5").draggable({cursor: "move"});
	$("#drag6").draggable({cursor: "move"});
	$("#drag7").draggable({cursor: "move"});
	$("#drag8").draggable({cursor: "move"});
	$("#drag9").draggable({cursor: "move"});
});

//footer

//$(document).ready(function() {
//	if($('#maxsearch-input').val() != '') {
//      $('#maxsearch-label').hide();
//    }else{$('#maxsearch-label').hide();}
//});

$(document).ready(function() {
	$('#drag').click(function(){
		$('div.max').css('z-index', "999");
		$('div.max').css('cursor', "move");
		$('div.max').css('background', "#e46261");
	});
});

$(document).ready(function() {
	$('#del').click(function(){
		var c=$.cookie('drag1').split(':');
		$("#drag1").animate({
			left: c[0],
			top: c[1]
		}, 500 );
	});
});

$(document).ready(function() {
	$('#save').click(function(){
		$.cookie("drag1", $('#drag1').offset().left+':'+$('#drag1').offset().top);	
	});
});

//Style search
$(function() {
	var cssLink = document.createElement("link") 
	cssLink.href = "http://okred.ru/css/search.css"; 
	cssLink.rel = "stylesheet"; 
	cssLink.type = "text/css"; 
	$("iframe")[0].document.body.appendChild(cssLink);
	
	$("iframe").css('width', "600px");
	
	$('.fmenu-center').click(function(){
		$("iframe")[0].css('width', "600px");
	});
});

$(document).ready(function() {
    $(".various").fancybox({
        maxWidth	: 800,
        maxHeight	: 600,
        fitToView	: false,
        width		: '70%',
        height		: '70%',
        autoSize	: false,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none'
	});
});

//job