(function ($){

	var method = {
		collectionInfo: function (t){
			return {
				page: t.attr('id')
			}
		},
		draftingQuery: function (i){
			var str = '';
			for(var key in i){
				if(key !== 'page') str += '&';
				str += key+'='+i[key];
			}
			return str;
		},
		ajaxSend: function (p, s){
			alert(p.typeAjax);
			alert(p.urlAjax);
			alert(s);
			$.ajax({
				type: p.typeAjax,
				url: p.urlAjax,
				data: s,
				success: function(html){
					history.pushState(null, null, 'music');
					$('body').html(html);
				}
			})
		}
	};

	$.fn.uploadPage = function (opt){
		var params = $.extend({
			typeAjax: 'post',
			urlAjax: 'http://music.okred.ru/music/index.php'
		},opt);
		$(this).on('click', function (){
			var info = method.collectionInfo($(this));
			strQuery = method.draftingQuery(info);
			method.ajaxSend(params, strQuery);
			return false;
		});
	}
})($)