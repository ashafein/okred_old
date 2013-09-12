<?php
	/*
		В будущем, если заплатят за рефакторинг всего прожекта, то это будет основной динамической формой
		
		Пока что она только для раздела музыки
		
		Перед инклудом объявить константы:
		- SEARCH_FORM_LOGO_TYPE(-пустое значение-, logo-music) - дополнение к классу логотипа
	    - SEARCH_FORM_URL
		- SEARCH_FORM_PLACEHOLDER - по умолчанию 'Для чего бобру мощный хвост'
		- SEARCH_FORM_TYPE(yandex, google, music) - по умолчанию yandex
	*/	

        if(!defined('SEARCH_FORM_LOGO_TYPE'))
        {
        	define('SEARCH_FORM_LOGO_TYPE', '');
        }
		if(!defined('SEARCH_FORM_URL'))
		{
			define('SEARCH_FORM_URL', '/search.php');
		}
		if(!defined('SEARCH_FORM_PLACEHOLDER'))
		{
			define('SEARCH_FORM_PLACEHOLDER', 'Для чего бобру мощный хвост');
		}
		if(!defined('SEARCH_FORM_TYPE'))
		{
			define('SEARCH_FORM_TYPE', 'yandex');
		}
		?>

		<form action="<?php echo SEARCH_FORM_URL ?>" id="cse-search-box">
	<!--
		ВАЖНО:
		Swapps не причастны к этой табличной верстке, скопипастено из старого варианта 
	-->
	<table class="maxsearch" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td class="maxsearch-holder-logo-td">
					<div class="maxsearch-holder-logo">
						<a href="/" class="logo <?php echo SEARCH_FORM_LOGO_TYPE ?>"></a>
					</div>
				</td>
				<td class="maxsearch-holder-td">
					<div class="maxsearch-holder">
						<?php if(SEARCH_FORM_TYPE == 'yandex'):  ?>
						<input id="maxsearch-input" class="b-form-input__input" maxlength="400" autocomplete="off" name="q" tabindex="1" autofocus type="text" value="">
						<input type="hidden" name="cx" value="partner-pub-0451632480937239:owp8ewffezs" />
						<input type="hidden" name="cof" value="FORID:10" />
						<input type="hidden" name="ie" value="utf-8" />
					<?php elseif(SEARCH_FORM_TYPE == 'music'): ?>
					<input type="text" name="text" id="maxsearch-input" class="b-form-input__input" maxlength="100" value="<?php echo(!empty($_REQUEST['text']) ? $_REQUEST['text'] : '')?>" placeholder="<?php echo SEARCH_FORM_PLACEHOLDER?>"/>
				<?php endif; ?>
			</div>
		</td>
		<td class="maxsearch-holder-ok-td">
			<div class="maxsearch-holder-ok">
				<?php if(SEARCH_FORM_TYPE == 'yandex'): ?>
				<a href="" onclick="" class="maxsearch-ok" tabindex="2">поиск</a>
			<?php elseif (SEARCH_FORM_TYPE == 'music'): ?>
			<a href="<?php echo SEARCH_FORM_URL ?>" onclick="loadSearchResults(true)" class="maxsearch-ok" tabindex="2">поиск</a>
		<?php endif;?>
	</div>
</td>
</tr>
</tbody>
</table>
</form>
