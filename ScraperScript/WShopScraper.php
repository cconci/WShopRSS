<?php

//error_reporting(E_ALL); 

/******************************************************************************
Includes
******************************************************************************/

require 'WShopDefines.php';
require 'WShopDatabaseWrapper.php';

require '../share/WShopItemListing.php';

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

	if($pageData === FALSE)
	{
		return constant("SCRAPER_ERROR");
	}

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

						if($currentItemCodeFromWebPageNum > 0)
						{
							//Valid Number
							return $currentItemCodeFromWebPageNum;
						}
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

	$itemListing = new WShopItemListing();

	$url = "".constant("URL_TOP_LEVEL")."/item/".$itemCode."/";

	echo "getItemInfoFromWebPage(): URL=".$url."\n";

	$pageData = file_get_contents($url);
	if($pageData === FALSE)
	{
		return constant("SCRAPER_ERROR");
	}

	//parse the pageData

	//store in our object
	$itemListing->setListingItemCode($itemCode);

	//Get Title
	$titleBreak1 = explode('<h1 itemprop="name" data-editable="true">',$pageData);
	$titleBreak2 = explode('</h1>',$titleBreak1[1]);
	$itemListing->setListingTitle($titleBreak2[0]);

	//Get Images
	$imageBreak1 = explode('<div class="column auctionImages">',$pageData);
	$imageBreak2 = explode('<div class="previewImages">',$imageBreak1[1]);
	$imageBraak3 = explode('<a href="',$imageBreak2[1]);
	
	$imagesArray = array();	

	//i=1, skip the first as it is not what we need
	for($i=1;$i<count($imageBraak3);$i++)
	{
		//strip the part of the lunk we do NOT need
		$imagesArray[$i-1] =  explode('"',$imageBraak3[$i])[0];
	}

	$itemListing->setListingImageLinks($imagesArray);

	//Description
	$descripBreak1 = explode('<div itemprop="description">',$pageData);
	$descripBreak2 = explode('<div id="postage">',$descripBreak1[1]);

	$itemListing->setListingDescription($descripBreak2[0]);

	//Contact
	$contactBreak1 = explode('<div class="contactDetails">',$pageData);
	$contactBreak2 = explode('</div>',$contactBreak1[1]);
	
	$itemListing->setListingStoreAddress($contactBreak2[0]);

	//Store Name
	$nameBreak1 = explode('<div class="column auctionStore">',$pageData);
	$nameBreak2 = explode('<h4>',$nameBreak1[1]);
	$nameBreak3 = explode('</h4>',$nameBreak2[1]);
	
	$itemListing->setListingStoreName($nameBreak3[0]);

	//Time Left
	$timeLeftBreak1 = explode('<p class="auctionTimeLeft" >',$pageData);
	if(count($timeLeftBreak1) > 1)
	{

		echo "::".count($timeLeftBreak1)."\n";
		$timeLeftBreak2 = explode('>',$timeLeftBreak1[1]);
		$timeLeftBreak3 = explode('<',$timeLeftBreak2[1]);

		$itemListing->setListingTimeLeftAtScrapeTIme($timeLeftBreak3[0]);
	}

	//Current Bid
	$currentBidBreak1 = explode('<p class="currentBid">',$pageData);
	if(count($currentBidBreak1) > 1)
	{
		$currentBidBreak2 = explode('>',$currentBidBreak1[1]);
		$currentBidBreak3 = explode('<',$currentBidBreak2[1]);

		$itemListing->setListingCurrentPrice($currentBidBreak3[0]);
	}
	//Postage
	$postageBreak1 = explode('<p class="postage ui-helper-clearfix">',$pageData);
	$postageBreak2 = explode('>',$postageBreak1[1]);
	$postageBreak3 = explode('>',$postageBreak2[1]);

	$itemListing->setListingPostagePrice($postageBreak3[0]);

	//Buy It Now Price
	$buyItNowBreak1 = explode('<form class="addToBasket" method="post">',$pageData);
	$buyItNowBreak2 = explode('<span class="price" itemprop="price">',$buyItNowBreak1[1]);
	$buyItNowBreak3 = explode('</span>',$buyItNowBreak2[1]);

	$itemListing->setListingBuyItNowPrice($buyItNowBreak3[0]);

	//Stock Number
	$stockNumBreak1 = explode('<span class="stockNumber">',$pageData);
	$stockNumBreak2 = explode('</span>',$stockNumBreak1[1]);

	$itemListing->setListingStockNumber($stockNumBreak2[0]);

	//Check if sold
	$soldBreak1 = explode('<div class="soldOverlay"></div>',$pageData);

	if(count($soldBreak1) > 1)
	{
		//Item is marked as sold
		$itemListing->setListingIsAlreadySold(true);
	}

	//Categorie
	$catBreak1 = explode('<div class="breadcrumbs">',$pageData);
	$catBreak2 = explode('<a href="/./items/',$catBreak1[1]);
	$catBreak3 = explode('/',$catBreak2[1]);

	$itemListing->setListingCategorie($catBreak3[0]);
	

	return $itemListing;
}

/******************************************************************************
Main Script
******************************************************************************/

//get last scanned item data(code) and last scanned item stock number from DB

$currentDatabaseItemCode = 2350958; //write the DB stuff

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

		if($itemDetails != constant("SCRAPER_ERROR"))
		{
			//check if it is an item we want to know about

			//add its info to the database

			//add a delay timer if needed, to make the requests staggered, eg not predictable
		}
	}
}
else
{
	//Page scrape failed
}

//update stats table for run info

?>
