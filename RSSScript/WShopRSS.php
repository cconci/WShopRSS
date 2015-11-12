<?php

//error_reporting(E_ALL); 

/******************************************************************************
Includes
******************************************************************************/

require_once '../Share/WShopDatabaseWrapper.php';
require_once '../Share/WShopItemListing.php';

/******************************************************************************
Defines
******************************************************************************/
//define("SCRAPER_ERROR",-1);

define('BUILD_DATE',date('r',1458736991)); //epoch of last time I updated the file

/******************************************************************************
Support Functions
******************************************************************************/
function generateRSSChannelBlockContent()
{
	$RSSfeed = "";
	$contentDate = date('r');	//From the DB, last scraper run info
	
	$RSSfeed .= "		<title>WShop RSS Feed</title>\n";
	//$RSSfeed .= "		<link>http:// ---- .com</link>";
	$RSSfeed .= "		<description>RSS Feed for Items of Interest from WShop</description>\n";
	$RSSfeed .= "		<language>en-us</language>\n";
	$RSSfeed .= "		<pubDate>".$contentDate."</pubDate>\n"; 
	$RSSfeed .= "		<lastBuildDate>".$contentDate."</lastBuildDate>\n";
	//$RSSfeed .= "		<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
	$RSSfeed .= "		<generator>gedit</generator>\n";
	//$RSSfeed .= "		<managingEditor>editor@example.com</managingEditor>\n";
	//$RSSfeed .= "		<webMaster>webmaster@example.com</webMaster>\n";

	return $RSSfeed;
}

function generateRSSItemBlockForWShopItemListing($itemListing)
{
	$RSSfeed = "";
	/*
      <item>
         <title>TEXT</title>
         <link>ITEM URL</link>
         <description> TEXT</description>
         <pubDate>Tue, 03 Jun 2003 09:39:21 GMT</pubDate>
         <guid>ITEM URL</guid>
      </item>
	*/

	return $RSSfeed;
}
/******************************************************************************
Main Script
******************************************************************************/

/*
Structure of an RSS Feed,
<http://www.rssboard.org/rss-specification#ltpubdategtSubelementOfLtitemgt>
*/

//Feed Header
echo "<?xml version=\"1.0\"?>\n";
echo "<rss version=\"2.0\">\n";

echo "	<channel>\n";		//Start Channel Block

//generate the channel block content for the feed
echo "".generateRSSChannelBlockContent()."";

//Get items for RSS feed from the Database

//generate the 'item' blocks for the feed


echo "	</channel>\n";		//End Channel Block
echo "</rss>\n";				//End RSS
?>
