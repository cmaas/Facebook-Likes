<?php
/*
free php class by peder fjällström, 20100905
www.earthpeople.se / peder@earthpeople.se
this is so free that it doesn't even have a license


# create new instance of like class
$FbLikes = new FbLikes();

# add all the urls you want to measure
$FbLikes->addUrl('http://earthpeople.se/labs/2010/05/setting-up-a-wp-dev-environment-on-a-live-site/');
$FbLikes->addUrl('http://earthpeople.se/labs/2009/11/hello-world/');
$FbLikes->addUrl('http://debaser.se/');

# set the sort order, either 'likes' or 'untouched'
$FbLikes->order_by = 'likes';

# get all the fb like data
$likes = $FbLikes->getLikes();

# echo the results
if($likes){
	foreach($likes as $row){
		echo $row->normalized_url . ': ' . $row->like_count . " facebook likes <br/>\n";
	}
}

*/

class FacebookURLStats {

	function __construct() {
		$this->format = 'json';
		$this->api_baseurl = 'http://api.facebook.com/restserver.php?method=links.getStats&urls=';
		$this->order_by = 'total_count';
		$this->urls = array();
		$this->poststring = '';
		$this->result = '';
		$this->formatted_result = '';
	}

	public function addUrl($url = ''){
		$this->urls[] = urlencode($url);
	}

	public function getStats(){
		$this->poststring = implode(',', $this->urls);
		$this->result = $this->curlRequest();
		return $this->formatResult($this->result);
	}
	
	private function formatResult($json){
		$jsonObj = @json_decode($json);
		if ($this->order_by && count($jsonObj) > 0 && property_exists($jsonObj[0], $this->order_by)){
			uasort($jsonObj, function($a, $b) {
				if( $a->{$this->order_by} == $b->{$this->order_by} ) return 0 ; 
				return ($a->{$this->order_by} > $b->{$this->order_by} ) ? -1 : 1; 
  			});
		}
		return $jsonObj;
	}

	private function curlRequest(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $this->api_baseurl.$this->poststring.'&format='.$this->format);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	
}