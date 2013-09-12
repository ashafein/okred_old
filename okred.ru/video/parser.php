<?php

function XMLtoArray($file){
	$XmlArray = array();
	$TempArray = array();
    $Xml = new DomDocument();
    $Xml->load(URLforYOU());
	foreach($Xml->documentElement->childNodes as $feed){
		if ($feed->nodeName == "entry") {
        foreach($feed->childNodes as $entry) {
            if ($entry->nodeName == "id") {
				$temp = explode('/', $entry->textContent);
				$TempArray['id'] = $temp[count($temp)-1];
            }
			if ($entry->nodeName == "published") {
				$TempArray['published'] = $entry->textContent;
			}
			if ($entry->nodeName == "updated") {
				$TempArray['updated'] = $entry->textContent;
			}
			if ($entry->nodeName == "title") {
				$TempArray['title'] = $entry->textContent;
			}
			if ($entry->nodeName =="author") {
			foreach($entry->childNodes as $author){
				if ($author->nodeName =="name") {
					$TempArray['author'] = $author->textContent;
				}
			}
			}
			if ($entry->nodeName =="media:group") {
			foreach($entry->childNodes as $media){
				if($media->nodeName == "media:thumbnail"){
				foreach($media->attributes as $attr){
					if($attr->nodeName == "url"){
						$TempArray['img'][] = $attr->textContent;
					}
				}
				}
			}
			}
        }
		$XmlArray[] = $TempArray;
		$TempArray = array();
    	}
	}
    
    return $XmlArray;
}

function ProcessNode($Node)
{
    $Array = array();
    foreach($Node->childNodes as $ChildNode)
    {
        if ($ChildNode->nodeType != XML_ELEMENT_NODE) continue;
        $Array[$ChildNode->localName] = ($ChildNode->childNodes->length) ? ProcessNode($ChildNode) : $Node->nodeValue;
    }
    return $Array;
}

function URLforYOU(){
	if(!empty($_GET["srt"])){
		$param = $_GET["srt"];
		$url = "http://gdata.youtube.com/feeds/api/standardfeeds/".$param;
	}elseif(!empty($_GET["ctg"])){
		$param = $_GET["ctg"];
		$url = "http://gdata.youtube.com/feeds/api/videos/-/%7Bhttp%3A%2F%2Fgdata.youtube.com%2Fschemas%2F2007%2Fcategories.cat%7D".$param;
	}elseif(!empty($_GET["search"])){
		$param = urlencode($_GET["search"]);
		$url="http://gdata.youtube.com/feeds/api/videos/-/%7Bhttp%3A%2F%2Fgdata.youtube.com%2Fschemas%2F2007%2Fkeywords.cat%7D".$param;
	}else{
		$url = "http://gdata.youtube.com/feeds/api/videos";
	}
	return $url;
}

function VideoArray(){
	$url = URLforYOU();
	$data = file_get_contents($url);
	return XMLtoArray($data);
}

function PreviewGen($XmlArray){
foreach($XmlArray as $PreviewArray){ ?>
	<a class="maxexpand-a" href="#maxzoom-video" onclick="$('#video').attr('src', 'http://www.youtube.com/embed/<?php echo $PreviewArray['id']; ?>');">
	<img style="width:240px; cursor:pointer" src="<?php echo $PreviewArray['img'][0]; ?>" />
	</a>
<?php }
}

function SmallPreviewGen($XmlArray){
foreach($XmlArray as $PreviewArray){ ?>
	<a onclick="$('#video').attr('src', 'http://www.youtube.com/embed/<?php echo $PreviewArray['id']; ?>');">
	<img style="width:120px; cursor:pointer" src="<?php echo $PreviewArray['img'][2]; ?>" />
	</a>
<?php }
}

?>