<?php

//error_reporting(E_ALL); 

/******************************************************************************
Includes
******************************************************************************/

//this is for my server as its not the same as the dev machine
//Debug
require_once '../Share/WShopDatabaseWrapper.php';
require_once '../Share/WShopItemListing.php';

//Online
//require_once '../../../scriptsLocal/WShopRSS/Share/WShopDatabaseWrapper.php';
//require_once '../../../scriptsLocal/WShopRSS/Share/WShopItemListing.php';

/******************************************************************************
Defines
******************************************************************************/
date_default_timezone_set('Australia/Victoria');

define("BUILD_DATE",date('r',1458736991)); //epoch of last time I updated the file
define("RSS_RECORD_DAYS_BACK",60);	//how far back the feed is generated in days

/******************************************************************************
Support Functions
******************************************************************************/
function generateRSSChannelBlockContent()
{
	$RSSFeed = "";
	$contentDate = date('r');	//From the DB, last scraper run info
	
	$RSSFeed .= "		<title>WShop RSS Feed</title>\n";
	//$RSSFeed .= "		<link>http:// ---- .com</link>";
	$RSSFeed .= "		<description>RSS Feed for Items of Interest from WShop</description>\n";
	$RSSFeed .= "		<language>en-us</language>\n";
	$RSSFeed .= "		<pubDate>".$contentDate."</pubDate>\n"; 
	$RSSFeed .= "		<lastBuildDate>".$contentDate."</lastBuildDate>\n";
	//$RSSFeed .= "		<docs> </docs>\n";
	$RSSFeed .= "		<generator>gedit</generator>\n";
	//$RSSFeed .= "		<managingEditor> </managingEditor>\n";
	//$RSSFeed .= "		<webMaster> </webMaster>\n";

	return $RSSFeed;
}

function generateRSSItemBlockForWShopItemListing($itemListing)
{
	$RSSFeed = "";
	$RSSFeed .= "		<item>\n";
	$RSSFeed .= "			<title>".$itemListing->getListingTitle()."</title>\n";
	$RSSFeed .= "			<link>".$itemListing->getListingURL()."</link>\n";

	$RSSFeed .= "			<description>\n";
	/*
	The CDATA section allows me to have images and mark up for the content
	*/
	//$RSSFeed .= "				<![CDATA[\n";

	//Show images
	$imagesArray = $itemListing->getListingImageLinks();
	for($i=0;$i<count($imagesArray);$i++)
	{
		$RSSFeed .= '					<img src="'.$imagesArray[$i].'" alt="NO DATA" style="width:88px;height:31px;">'."\n";
	}

	$RSSFeed .= "					<p>".$itemListing->getListingDescription()."</p>\n";

	//$RSSFeed .= "				]]>\n";
	$RSSFeed .= "			</description>\n";

	$RSSFeed .= "			<pubDate>".date('r',$itemListing->getListingDateTimeStampEpoch())."</pubDate>\n";
	$RSSFeed .= "			<guid>".$itemListing->getEntryID()."</guid>\n";
	$RSSFeed .= "		</item>\n";

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
echo "<rss version=\"2.0\">\n";

echo "	<channel>\n";		//Start Channel Block

//generate the channel block content for the feed
echo "".generateRSSChannelBlockContent()."";

//Get items for RSS feed from the Database
$itmeListingsForFeed = databaseSelectWShopItemListingsFromTheLastXDays(constant("RSS_RECORD_DAYS_BACK"));

//generate the 'item' blocks for the feed
for($i=0;$i<count($itmeListingsForFeed);$i++)
{
	echo "".generateRSSItemBlockForWShopItemListing($itmeListingsForFeed[$i])."";
}


echo "	</channel>\n";		//End Channel Block
echo "</rss>\n";				//End RSS

?>
