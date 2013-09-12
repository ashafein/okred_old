// JavaScript Document
$(function() {
//Hide label when focus on input
  $('#maxsearch-input').on('input', function() {
      $('#maxsearch-label[for="' + $(this)[0].id + '"]').text('');
  }).blur(function() {
    if($(this).val() == '') {
      $('#maxsearch-label[for="' + $(this)[0].id + '"]').text('');
    }
  }).click(function() {
      $('#maxsearch-label[for="' + $(this)[0].id + '"]').text('');
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

$(function() {
//steps functionality
    $('#add-resume-step1').click(function() {
        $('div#add-resume-step1-panel').show(1000);
        $('div#add-resume-step2-panel').hide(1000);
        $('div#add-resume-step3-panel').hide(1000);
        $('a#add-resume-step1').addClass("step-active");
        $('a#add-resume-step2').removeClass("step-active");
        $('a#add-resume-step3').removeClass("step-active");
        $('html, body').animate({ scrollTop: $("a.logo").offset().top }, 800);

    });
    $('#add-resume-step2').click(function() {
        $('div#add-resume-step1-panel').hide(1000);
        $('div#add-resume-step2-panel').show(1000);
        $('div#add-resume-step3-panel').hide(1000);
        $('a#add-resume-step1').removeClass("step-active");
        $('a#add-resume-step2').addClass("step-active");
        $('a#add-resume-step3').removeClass("step-active");
        $('html, body').animate({ scrollTop: $("a.logo").offset().top }, 800);
    });
    $('#add-resume-step3').click(function() {
        $('div#add-resume-step1-panel').hide(1000);
        $('div#add-resume-step2-panel').hide(1000);
        $('div#add-resume-step3-panel').show(1000);
        $('a#add-resume-step1').removeClass("step-active");
        $('a#add-resume-step2').removeClass("step-active");
        $('a#add-resume-step3').addClass("step-active");
        $('html, body').animate({ scrollTop: $("a.logo").offset().top }, 800);
    });
    $('#add-resume-step1b').click(function() {
        $('div#add-resume-step1-panel').show(1000);
        $('div#add-resume-step2-panel').hide(1000);
        $('div#add-resume-step3-panel').hide(1000);
        $('a#add-resume-step1').addClass("step-active");
        $('a#add-resume-step2').removeClass("step-active");
        $('a#add-resume-step3').removeClass("step-active");
        $('html, body').animate({ scrollTop: $("a.logo").offset().top }, 800);
    });
    $('#add-resume-step2b').click(function() {
        $('div#add-resume-step1-panel').hide(1000);
        $('div#add-resume-step2-panel').show(1000);
        $('div#add-resume-step3-panel').hide(1000);
        $('a#add-resume-step1').removeClass("step-active");
        $('a#add-resume-step2').addClass("step-active");
        $('a#add-resume-step3').removeClass("step-active");
        $('html, body').animate({ scrollTop: $("a.logo").offset().top }, 800);
    });
    $('#add-resume-step22b').click(function() {
        $('div#add-resume-step1-panel').hide(1000);
        $('div#add-resume-step2-panel').show(1000);
        $('div#add-resume-step3-panel').hide(1000);
        $('a#add-resume-step1').removeClass("step-active");
        $('a#add-resume-step2').addClass("step-active");
        $('a#add-resume-step3').removeClass("step-active");
        $('html, body').animate({ scrollTop: $("a.logo").offset().top }, 800);
    });
    $('#add-resume-step3b').click(function() {
        $('div#add-resume-step1-panel').hide(1000);
        $('div#add-resume-step2-panel').hide(1000);
        $('div#add-resume-step3-panel').show(1000);
        $('a#add-resume-step1').removeClass("step-active");
        $('a#add-resume-step2').removeClass("step-active");
        $('a#add-resume-step3').addClass("step-active");
        $('html, body').animate({ scrollTop: $("a.logo").offset().top }, 800);
    });

});
