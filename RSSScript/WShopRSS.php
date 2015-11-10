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

/******************************************************************************
Support Functions
******************************************************************************/
function generateRSSChannelBlockContent()
{
	$RSSfeed = "";
	
	$RSSfeed .= "		<title>WShop RSS Feed</title>\n";
	$RSSfeed .= "		<link>http:// ---- .com</link>";
	$RSSfeed .= "		<description>RSS Feed for Items of Interest from WShop</description>\n";
	$RSSfeed .= "		<language>en-us</language>\n";

	$RSSfeed .= "		<pubDate>".date('r')."</pubDate>\n";
	//   <lastBuildDate>Tue, 10 Jun 2003 09:41:01 GMT</lastBuildDate>
	//   <docs>http://blogs.law.harvard.edu/tech/rss</docs>
	//   <generator>Weblog Editor 2.0</generator>
	//   <managingEditor>editor@example.com</managingEditor>
	//   <webMaster>webmaster@example.com</webMaster>
	*/

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
