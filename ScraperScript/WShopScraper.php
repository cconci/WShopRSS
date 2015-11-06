<?php

//error_reporting(E_ALL); 

/******************************************************************************
Includes
******************************************************************************/

require 'WShopDefines.php';
require 'WShopDatabaseWrapper.php';

/******************************************************************************
Defines
******************************************************************************/
define("SCRAPER_ERROR",-1);

/******************************************************************************
Support Functions
******************************************************************************/

function getCurrentItemCodeFromWebPage()
{

	//Download the page with all the items
	$pageData = file_get_contents(constant("URL_CATEGORY_PAGE"));

	//extract what we need from the page, first break is '<div class="auctionList">'
	$pageDataBreak1 = explode('<div class="auctionList">',$pageData);

	if(count($pageDataBreak1) >= 2)
	{
		//second break is between '<a href=' and 'title='
		$pageDataBreak2 = explode('<a href=',$pageDataBreak1[1]);

		if(count($pageDataBreak2) >= 2)
		{
			$pageDataBreak3 = explode('title=',$pageDataBreak2[1]);

			if(count($pageDataBreak3) >= 2)
			{
				/*
				we will have somthing like this,
				"/item/2348465/------" 
				Note:the dashes at the end are a text description that we do not need
				*/
				$shortLinkToCurrentItem = $pageDataBreak3[0];

				//Strip the /item/ with another explode
				$shortLinkBreak1 = explode('/item/',$shortLinkToCurrentItem);

				if(count($shortLinkBreak1) >= 2)
				{

					//get whats before '/'
					$shortLinkBreak2 = explode('/',$shortLinkBreak1[1]);

					if(count($shortLinkBreak2) >= 2)
					{				

						$currentItemCodeFromWebPage = $shortLinkBreak2[0];

						//ensure treatment as a number
						$currentItemCodeFromWebPageNum = (int)$currentItemCodeFromWebPage;

						return $currentItemCodeFromWebPageNum;
						
					}
				}
			}
		}
	}

	/*
	Page scrape failed - web page most likely modified, we need to update :)
	*/
	return constant("SCRAPER_ERROR");
}

function getItemInfoFromWebPage($itemCode)
{

	/*
	An Item URL is of the form URl/item/[itemCode]/
	*/

	$url = "".constant("URL_TOP_LEVEL")."/item/".$itemCode."/";

	echo "getItemInfoFromWebPage(): URL=".$url."\n";

	//$pageData = file_get_contents($url);

	//parse the pageData
}

/******************************************************************************
Main Script
******************************************************************************/

//get last scanned item data(code) and last scanned item stock number from DB

$currentDatabaseItemCode = 2348677; //write the DB stuff

$currentWebPageItemCode = getCurrentItemCodeFromWebPage();

echo "Web Page current item code:".$currentWebPageItemCode."\n";

if($currentWebPageItemCode != constant("SCRAPER_ERROR"))
{

	while($currentDatabaseItemCode < $currentWebPageItemCode)
	{
		//change our item code
		$currentDatabaseItemCode++;

		//extract needed info from the page
		$itemDetails = getItemInfoFromWebPage($currentDatabaseItemCode);

		//check if it is an item we want to know about

		//add its info to the database

		//add a delay timer if needed, to make the requests staggered, eg not predictable


	}
}
else
{
	//Page scrape failed
}

//update stats table for run info

?>

