<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>2</title>
</head>

<body>
<?php 
class studio404_weather{
	public $url; 
	public $city; 
	public $celsius; 
	public function lunch($url, $tempPath, $classArray){
		$this->url = $url;
		$this->tempPath = $tempPath;
		$this->classArray = $classArray;
		$getHtml = $this->getHtmlDom(); 
		$parseHtml = $this->parseHtml($getHtml);
		return $parseHtml;
	}
	public function getHtmlDom(){
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $this->url);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17");
		curl_setopt($curl, CURLOPT_REFERER, $this->url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($curl, CURLOPT_AUTOREFERER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$html = curl_exec($curl);
		
		echo curl_error($curl);
		curl_close($curl);
		$file = $this->tempPath.$this->urlToMd5($this->url).'.html';
		file_put_contents($file, $html);
		return $file;
	}
	public function urlToMd5($url){
		$out = md5($url);
		return $out;
	}
	public function parseHtml($file){
		$out = array();
		$html = file_get_contents($file); 
		$internalErrors = libxml_use_internal_errors(true);
		$domdocument = new DOMDocument();
		$domdocument->loadHTML($html);
		libxml_use_internal_errors($internalErrors);
		$DOMXPath = new DOMXPath($domdocument);
		$contains = $this->contains($DOMXPath);
		foreach ($this->classArray as $key => $value) {
			$out[$key] = $contains[$key]->item(0)->nodeValue;
		}
		return $out;
	}
	public function contains($DOMXPath){
		$out = array();
		foreach ($this->classArray as $key => $value) {
			$out[$key] = $DOMXPath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $value ')]");
		}
		return $out;
	}
	public static function celToFahren($celsius){
		$fahren = ((int)$celsius * 9/5) + 32;
		return $fahren;
	}
}
?>
</body>
</html>
