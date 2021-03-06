<style>
.toggle{
    position: relative;
    padding: 5px 10px;
    margin: 0 0 -5px -1px;
    border: 1px solid #c9c9c9;
    cursor: pointer;
    width: 120px;
    height: 25px;
    float: left;
    z-index: 1000;
}
#yandex{
    border-bottom: 1px solid #ffffff;
    background: url('_images/bg_yandex.png') no-repeat;
    background-position: center;
}
#google{
    background: url('_images/bg_google_grey.png') no-repeat;
    background-position: center;
}
#google:hover{
    background-image: url('_images/bg_google.png');
}
#yandex:hover{
    background-image: url('_images/bg_yandex.png');
}
.toggle:hover{
    background: #d4303b;
    color: #fff;
}

.results{
    display: none;
    border: 1px solid #c9c9c9;
    padding: 0 15px;
    margin-bottom: 25px;
    margin-top: -1px;
}
</style>
<script>
var Query = '';
$(function()
{//Переключатель
    $('.toggle').click(function()
    {
        var id = '#'+ $(this).attr('id') +'_results';
        
        $('.toggle').css({borderBottom: '1px solid #c9c9c9'});
        
        $(this)
            .css({borderBottom: '1px solid #ffffff'})
            .addClass('active');
        
        if($(this).attr('id') == 'yandex')
        {
            $(this).css({backgroundImage: 'url(\'_images/bg_yandex.png\')'});
            $('#google')
                .css({backgroundImage: 'url(\'_images/bg_google_grey.png\')'})
                .removeClass('active');
        }
        else if($(this).attr('id') == 'google')
        {
            $(this).css({backgroundImage: 'url(\'_images/bg_google.png\')'});
            $('#yandex')
                .css({backgroundImage: 'url(\'_images/bg_yandex_grey.png\')'})
                .removeClass('active');
        }
        
        $('.results')
            .fadeOut(250, function()
            {
                $(id).fadeIn();
            });
            
    })
    .hover(
        function(){ $(this).css({backgroundImage: 'url(\'_images/bg_'+ $(this).attr('id') +'.png\')'}); },
        function(){ if(!$(this).hasClass('active')){ $(this).css({backgroundImage: 'url(\'_images/bg_'+ $(this).attr('id') +'_grey.png\')'}); } }
    );
    
//Поиск
    $('#cse-search-box').submit(function()
    {
        Query = $.trim($('#maxsearch-input').val());
        
        if(Query == '')
        {
            $('#maxsearch-input').val('');
            $('#maxsearch-input').attr({placeholder: 'Что будем искать?'});
            return false;
        }
        
        if(parseInt($('#searchbar').css('top')) != 15)
        {//Устанавливаю строку поиска по центру
            var searchresultsarea = parseInt($('#searchresultsarea').css('height'));
            var searchbar = parseInt($('#searchbar').css('height'));
        
            var top = (searchresultsarea - searchbar) / 2;
            $('#searchbar').css({position: 'relative',top: top});
            
            $('#searchresultsarea').attr({valign: 'top'});
        }
        
        var page = 1;
        
        $('#maxsearch-input').attr({placeholder: ''});
        
        getSearchResults(Query, page, 'all');
        
        return false;
    });
    
    $('div.yandex_nav a').live('click', function()
    {
        var page = parseInt($(this).attr('href'));
        
        $('#maxsearch-input').val(Query);
        getSearchResults(Query, page, getActiveTab());
        return false;
    });
    
    function getSearchResults(query, page, what)
    {
        //alert(what);
        //alert(query);
        $.ajax({
            url: 'http://<?php echo $_SERVER['SERVER_NAME']; ?>/search_result.php',
            //type: 'post',
            dataType: 'json',
            contentType: 'text/html',
            data: {
                'query': query,
                'page': page,
                'type': 'ajax',
                what: what
            },
            beforeSend: function()
            {
                $('#'+ getActiveTab()).animate({opacity: '0.3'});
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                //alert(url);
                alert(errorThrown +' asd '+ textStatus);
            },
            success: function(data, textStatus)
            {
                if(data.error)
                {
                    alert(data.content);
                    return false;
                }
                $('#'+ getActiveTab()).animate({opacity: '1'});
                $('#searchbar').animate({top: 15}, 'normal', 'swing', function()
                {
                    //$('.results').fadeOut();
                    
                    $('#toggle_buttons').fadeIn();
                    
                    if(data.yandexResults != '')
                        $('#yandex_results').html(data.yandexResults);
                    
                    if(data.googleResults != '')
                        $('#google_results').html(data.googleResults);
                    
                    $('#'+ getActiveTab()).fadeIn();
                    
                    $('#searchbar').attr({valign: 'top', align: 'left'});
                });
            }
        });
    }
    
    function getActiveTab()
    {
        var activeTab = $('.results')
            .filter(function(indexInJQueryObject)
            {
                var ob = $('.results')[indexInJQueryObject];
                
                if($(ob).css('display') == 'none')
                    return false;
                
                return true;
            });
        
        if(activeTab.length)
        {
            activeTab = $(activeTab).attr('id');
        }
        else
        {
            activeTab = 'yandex_results';
        }
        
        return activeTab;
    }
});
</script>
<form action="http://okred.ru" id="cse-search-box">
<table class="maxsearch" cellpadding="0" cellspacing="0" id="searchbar">
<tbody>
	<tr>
	<td class="maxsearch-holder-logo-td">
        <div class="maxsearch-holder-logo">
            <a href="/" class="logo"></a>
        </div>
	</td>
	<td class="maxsearch-holder-td">
        <div class="maxsearch-holder">
        <!--label for="maxsearch-input" id="maxsearch-label">Для чего бобру мощный хвост</label-->
	    <input id="maxsearch-input" class="b-form-input__input" maxlength="400" autocomplete="off" name="q" tabindex="1" autofocus type="text" value="">
		<input type="hidden" name="cx" value="partner-pub-0451632480937239:owp8ewffezs" />
		<input type="hidden" name="cof" value="FORID:10" />
		<input type="hidden" name="ie" value="utf-8" />
        </div>
    </td>
    <td class="maxsearch-holder-ok-td">
        <div class="maxsearch-holder-ok">
            <input class="maxsearch-ok" type="submit" name="submit" value="поиск" id="searchbutton">
        </div>
    </td>
	</tr>
    <tr>
        <td colspan="3" align="left">
            <div id="toggle_buttons" style="display:none;margin-left: -4px;">
                <br>
                <div class="toggle active" id="yandex">
                    
                </div>
                <div class="toggle" id="google">
                    
                </div>
            </div>  
        </td>
    </tr>
</tbody>
</table>
</form>
<div id="yandex_results" class="results">
</div>
<div id="google_results" class="results">
</div>