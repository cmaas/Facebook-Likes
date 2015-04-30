<?php
require('FacebookUrlStats.class.php');

# create new instance of stats class
$fbStats = new FacebookUrlStats();

$urls_str = file_get_contents('urls.txt');
$urls = explode("\n", $urls_str);
foreach ($urls as $url) {
	$fbStats->addUrl($url);
}

# get all the fb stats
$stats = $fbStats->getStats();

$fbStats->order_by = 'total_count';


# echo the results
if ($stats){
	foreach($stats as $row){
		echo $row->normalized_url . ': ' . $row->{$fbStats->order_by} . "\n";
	}
}