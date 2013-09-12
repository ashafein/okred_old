// JavaScript Document
function y(){
	(function(w,d,c){
		var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;
		(' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1&&(e.className+=' ya-page_js_yes');
		s.type='text/javascript';
		s.async=true;
		s.charset='utf-8';
		s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';
		h.parentNode.insertBefore(s,h);
		(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})
	})
	(window,document,'yandex_site_callbacks');
}

function g(){
	var googleSearchIframeName = "cse-search-results";
	var googleSearchFormName = "cse-search-box";
	var googleSearchFrameWidth = 800;
 	var googleSearchDomain = "www.google.com";
	var googleSearchPath = "/cse";	
	include("http://www.google.com/afsonline/show_afs_search.js");
}

function f(){
	if($.cookie("form", "y")){
		include("/_html/y_f.html");
	}else if($.cookie("form", "g")){
		include("/_html/g_f.html");
	}else{
		
	}
}