<?php

//error_reporting(E_ALL); 

/*
Feed Validates here as of 08/04/2016
<https://validator.w3.org/feed/>
<http://www.feedvalidator.org/>

*/

/******************************************************************************
Settings
******************************************************************************/
//Send a raw HTTP header - required to validate feed
header('Content-Type: text/xml');

/******************************************************************************
Includes
******************************************************************************/

require_once '../Share//WShopItemListing.php';
require_once '../Share/WShopDatabaseWrapper.php';

/*
Note: I was seeing a strange char at the start of the RSS feed for each file that
was included, the cause was the encoding of the file, it needs to be 'UTF-8' with no BOM
the BOM was waht was causing the extra byte

- I used Notepas++ to fix the issue (the files were orignaly made with gedit)

*/

/******************************************************************************
Defines
******************************************************************************/
date_default_timezone_set('Australia/Victoria');

define("BUILD_DATE",date('r',1458736991)); //epoch of last time I updated the file
define("RSS_RECORD_DAYS_BACK",3);	//how far back the feed is generated in days

/******************************************************************************
Support Functions
******************************************************************************/
function generateRSSChannelBlockContent()
{
	$RSSFeed = "";
	$contentDate = date('r');	//From the DB, last scraper run info

	$pageLink = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";	

	$RSSFeed .= "      <title>WShop RSS Feed</title>\n";
	$RSSFeed .= "      <link>".$pageLink."</link>";
	$RSSFeed .= "      <description>RSS Feed for Items of Interest from WShop</description>\n";
	$RSSFeed .= "      <language>en-us</language>\n";
	$RSSFeed .= "      <pubDate>".$contentDate."</pubDate>\n"; 
	$RSSFeed .= "      <lastBuildDate>".$contentDate."</lastBuildDate>\n";
	//$RSSFeed .= "      <docs> </docs>\n";
	$RSSFeed .= "      <generator>gedit and Notepad++</generator>\n";
	//$RSSFeed .= "      <managingEditor> </managingEditor>\n";
	//$RSSFeed .= "      <webMaster> </webMaster>\n";
	$RSSFeed .= "      <atom:link href=\"".$pageLink."\" rel=\"self\" type=\"application/rss+xml\"/>";
	return $RSSFeed;
}

function generateRSSItemBlockForWShopItemListing($itemListing)
{
	$RSSFeed = "";
	$RSSFeed .= "   <item>\n";
	$RSSFeed .= "      <title>".htmlspecialchars($itemListing->getListingTitle())."</title>\n";
	$RSSFeed .= "      <link>".$itemListing->getListingURL()."</link>\n";

	$RSSFeed .= "      <description>\n";
	/*
	The CDATA section allows me to have images and mark up for the content
	*/
	$RSSFeed .= "         <![CDATA[\n";

	//Show images
	$imagesArray = $itemListing->getListingImageLinks();
	for($i=0;$i<count($imagesArray);$i++)
	{
		if(strlen($imagesArray[$i]) > 0)
		{
			$RSSFeed .= '            <img src="'.$imagesArray[$i].'" alt="NO DATA" style="width:88px;height:31px;">'."\n";
		}
	}
	//Price info
	$RSSFeed .= "            <p>".$itemListing->getListingCurrentPrice()
					."(".$itemListing->getListingBuyItNowPrice().")"
					."+".$itemListing->getListingPostagePrice().""."</p>\n";		

	$RSSFeed .= "            <p>".$itemListing->getListingDescription()."</p>\n";

	$RSSFeed .= "         ]]>\n";
	$RSSFeed .= "      </description>\n";

	$RSSFeed .= "      <pubDate>".date('r',$itemListing->getListingDateTimeStampEpoch())."</pubDate>\n";
	$RSSFeed .= "      <guid>".$itemListing->getListingURL()."</guid>\n";
	$RSSFeed .= "   </item>\n";

	return $RSSFeed;
}
/******************************************************************************
Main Script
******************************************************************************/

/*
Structure of an RSS Feed,
<http://www.rssboard.org/rss-specification#ltpubdategtSubelementOfLtitemgt>
*/

//Feed Header
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";

echo "   <channel>\n";		//Start Channel Block
//generate the channel block content for the feed
echo "".generateRSSChannelBlockContent()."";

//Get items for RSS feed from the Database
$itmeListingsForFeed = databaseSelectWShopItemListingsFromTheLastXDays(constant("RSS_RECORD_DAYS_BACK"));

//generate the 'item' blocks for the feed
for($i=0;$i<count($itmeListingsForFeed);$i++)
{
	echo "".generateRSSItemBlockForWShopItemListing($itmeListingsForFeed[$i])."";
}


echo "   </channel>\n";		//End Channel Block
echo "</rss>\n";				//End RSS

//Update Access Stats

$serverClinetIp = "Not Set";
$serverFwd = "Not Set";
$serverQueryStr = "Not Set";
$serverRemote = "Not Set";
$serverUserAgent = "Not Set";


if(isset($_SERVER['HTTP_CLIENT_IP']))
{
	$serverClinetIp = $_SERVER['HTTP_CLIENT_IP'];
}
if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
{
	$serverFwd = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
if(isset($_SERVER['REMOTE_ADDR']))
{
	$serverQueryStr = $_SERVER['REMOTE_ADDR'];
}
if(isset($_SERVER['QUERY_STRING']))
{
	$serverRemote = $_SERVER['QUERY_STRING'];
}
if(isset($_SERVER['HTTP_USER_AGENT']))
{
	$serverUserAgent = $_SERVER['HTTP_USER_AGENT'];
}

$sizeOfServedData = 0;

//dump of request str
ob_start();
var_dump($_GET);
$getVarDump = ob_get_clean();

databaseInsertRssAceesInfo($serverClinetIp,$serverFwd,$serverQueryStr,$serverRemote,$serverUserAgent,$sizeOfServedData,$getVarDump);


?>
