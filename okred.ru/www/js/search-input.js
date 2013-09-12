// JavaScript Document
$(function() {
//Hide label when focus on input
  $('#maxsearch-input').on('input', function() {
      $('#maxsearch-label[for="' + $(this)[0].id + '"]').hide();
  }).blur(function() {
    if($(this).val() == '') {
      $('#maxsearch-label[for="' + $(this)[0].id + '"]').show();
    }
  }).click(function() {
      $('#maxsearch-label[for="' + $(this)[0].id + '"]').hide();
  });
});

$(function() {
//Clear search input on X click
  $('#maxsearch-clear').click(function() {
      $('#maxsearch-input').val('');
	  $('#maxsearch-input').focus();
  });
});

$(function() {
//Show cogs-panel on click
  $('#searchbox-d-cogs').click(function() {
	  $('#searchbox-d-cogs-panel').show();
	  //$('#searchbox-d-cogs-panel-focusholder').focus();
  });
});
/*
$(function() {
//Close cogs-panel on loosing focus
  $('#searchbox-d-cogs-panel-focusholder').blur(function() {
	  $('#searchbox-d-cogs-panel').hide();
  });
});
*/
$(function() {
//Close cogs-panel on X click
  $('#searchbox-d-cogs-panel-close').click(function() {
	  $('#searchbox-d-cogs-panel').hide();  
  });
});

$(function() {
	$('#gsearch-logo').click(function() {
		$("#searchbox-d-cogs-panel").hide();
		$.ajax({
			url: "/_html/g_f.html", 
			type: "GET", 
			data: "", 
			success: function(html){ $("#search_f").html(html);}
			});
		$.cookie("search", "g");
	});
});

$(function() {
	$('#yasearch-logo').click(function() {
		$("#searchbox-d-cogs-panel").hide();
		$.ajax({
			url: "/_html/y_f.html", 
			type: "GET", 
			data: "", 
			success: function(html){ $("#search_f").html(html);}
			});
		$.cookie("search", "y");
	});
});