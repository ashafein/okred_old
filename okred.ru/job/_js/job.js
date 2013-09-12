//fancybox lang
$("div#tbl-lang a").click(function(){
    $("div#tbl-lang a.selected").removeClass("selected");
	if($("div#tbl-lvl a.selected").length > 0){
		$("div#tbl-lang-selected a").remove();
		$(this).clone().appendTo("div#tbl-lang-selected");
		$("div#tbl-lvl a.selected").clone().removeClass("selected").appendTo("div#tbl-lang-selected");
		$("div#tbl-lang-selected span").removeClass().addClass("tbl-minus");
	}
	$(this).addClass("selected");
});

$("div#tbl-lvl a").click(function(){
	$("div#tbl-lvl a.selected").removeClass("selected");
	if($("div#tbl-lang a.selected").length > 0){
		$("div#tbl-lang-selected a").remove();
		$("div#tbl-lang a.selected").clone().removeClass("selected").appendTo("div#tbl-lang-selected");
		$(this).clone().appendTo("div#tbl-lang-selected");
		$("div#tbl-lang-selected span").removeClass().addClass("tbl-minus");
	}
	$(this).addClass("selected");
});

$("div#tbl-lang-selected a").live('click', function(){
	$("div#tbl-lvl a.selected").removeClass("selected");
	$("div#tbl-lang a.selected").removeClass("selected");
	$("div#tbl-lang-selected a").remove();
});

$("a#a-lang-close").click(function(){
	if($("div#tbl-lang-selected a").length > 0){
		$("input#add-lang").val($("div#tbl-lang a.selected").id);
		$("input#add-lang-lvl").val($("div#tbl-lvl a.selected").id);
		$("div#dom-lang").html($("div#tbl-lang-selected a").text());
	}else{
		$("input#add-lang").val("");
		$("input#add-lang-lvl").val("");
		$("div#dom-lang").html("Не выбранно");
	}
    $.fancybox.close();
});
//fancybox prof
$("div#tbl-area-prof a").click(function(){
    var id_get = this.id;
	//Ajax
    $.ajax({
        url:     "/_php/query.php", 
        type:     "GET", 
        dataType: "html",
        data: ({opt : "prof", id : id_get}),
        success: function(html){
            $("div#tbl-prof").html(html);
			//selected
			$("div#tbl-prof a").each(function(index, element) {
        		if($("div#tbl-selected a").is("#"+element.id))
					$(element).addClass("selected");
			});
		}
    });
	//add
    $("div#tbl-area-prof a.selected").removeClass("selected");
    $(this).addClass("selected");
});

$("div#tbl-prof a").live('click', function(){
	if((!$(this).hasClass("selected"))&&($("div#tbl-selected a").length <7)){
   		$(this).clone().appendTo("div#tbl-selected");
    	$("div#tbl-selected span.tbl-plus").addClass("tbl-minus").removeClass("tbl-plus");
    	$(this).addClass("selected");
	}
});

$("div#tbl-selected a").live('click', function(){
    var id_get = this.id;
    $("div#tbl-prof a#"+id_get).removeClass("selected");
    $(this).remove();
});

$("a#a-prof-close").click(function(){
	var prof_id = "";
	var prof_name = "";
	$("div#tbl-selected a").each(function(index, element) {
		prof_id += ","+element.id;
		prof_name += $(this).text()+"<br />";
    });
	$("input#add-prof").val(prof_id);
	$("div#dom-prof").html(prof_name);
    $.fancybox.close();
});
//fancybox city
$("div#tbl-region a").click(function(){
    var id_get = this.id;
	//Ajax
    $.ajax({
        url:     "/_php/query.php", 
        type:     "GET", 
        dataType: "html",
        data: ({opt : "city", id : id_get}),
        success: function(html){
            $("div#tbl-city").html(html);
			//selected
			$("div#tbl-city a").each(function(index, element) {
        		if($("div#tbl-city-selected a").is("#"+element.id))
					$(element).addClass("selected");
			});
		}
    });
	//add
    $("div#tbl-region a.selected").removeClass("selected");
    $(this).addClass("selected");
});

$("div#tbl-city a").live('click', function(){
	if((!$(this).hasClass("selected"))&&($("div#tbl-city-selected a").length < 1)){
   		$(this).clone().appendTo("div#tbl-city-selected");
    	$("div#tbl-city-selected span.tbl-plus").addClass("tbl-minus").removeClass("tbl-plus");
    	$(this).addClass("selected");
	}
});

$("div#tbl-city-selected a").live('click', function(){
    var id_get = this.id;
    $("div#tbl-city a#"+id_get).removeClass("selected");
    $(this).remove();
});

$("a#a-city-close").click(function(){
	var city_id = "";
	var city_name = "";
	$("div#tbl-city-selected a").each(function(index, element) {
		city_id += element.id;
		city_name += $(element).text();
    });
	$("input#add-city").val(city_id);
	$("div#dom-city").html(city_name);
    $.fancybox.close();
});