<?php

$url = $d->unescapedUrl;
$title = $d->title;
$passages = $d->content;

?>
<div class="result_row">
<a href="<?php echo $url; ?>" class="mainlink" target="_blank">
    <?php echo $title; ?>
</a>
<div>
    <?php echo $passages; ?><br>
</div>
<a href="<?php echo $url; ?>" class="final_link" target="_blank"><?php echo htmlspecialchars(substr($url, 0, 100)); if(strlen($url) > 100) echo '...'; ?></a>
</div>