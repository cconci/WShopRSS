<?php

/******************************************************************************
Includes
******************************************************************************/
require_once '../Share/WShopDatabaseAccess.php';
require_once '../Share/WShopItemListing.php';

/******************************************************************************
Defines
******************************************************************************/

/******************************************************************************
Functions
******************************************************************************/
function databaseInsertScraperRunResults($runTimeMSparam,$numberOfNewEntrysFoundparam)
{
	//New connection
	$conn = new mysqli(constant("DB_SERVER"), constant("DB_USER"), constant("DB_USER_PASS"), constant("DB_NAME"));

	//error check
	if ($conn->connect_error) 
	{
		 die("Connection failed: " . $conn->connect_error);
	}

	//prepare
	$stmt = $conn->prepare("INSERT INTO scraper_run_results (dateTimeStampEpoch, runTimeMS, numberOfNewEntrysFound) VALUES (?, ?, ?)");

	/*
		options,
			i - integer
			d - double
			s - string
			b - BLOB
	*/
	//Bind, the all are int so we use 'i'
	$stmt->bind_param("iii", 
		$dateTimeStampEpoch, 
		$runTimeMS, 
		$numberOfNewEntrysFound
	);

	//set real parameters
	$dateTimeStampEpoch 			= time();	//epoch seconds
	$runTimeMS 						= $runTimeMSparam;
	$numberOfNewEntrysFound 	= $numberOfNewEntrysFoundparam;

	$stmt->execute();
	
	//clean up
	$stmt->close();
	$conn->close();
}

/*
Takes an 'wShopItemListing' onject as a param and adds it to the database
*/
function databaseInsertWShopItemListing($itemListing)
{
	//New connection
	$conn = new mysqli(constant("DB_SERVER"), constant("DB_USER"), constant("DB_USER_PASS"), constant("DB_NAME"));

	//error check
	if ($conn->connect_error) 
	{
		 die("Connection failed: " . $conn->connect_error);
	}

	//prepare
	$stmt = $conn->prepare("INSERT INTO rss_feed ("
		."listingItemCode,"
		."listingTitle,"
		."listingTimeLeftAtScrapeTIme,"
		."listingCurrentPrice,"
		."listingBuyItNowPrice,"
		."listingPostagePrice,"
		."listingDescription,"
		."listingImageLinks,"
		."listingStoreName,"
		."listingStoreAddress,"
		."listingStockNumber,"
		."listingIsAlreadySold,"
		."listingCategorie,"
		."listingDateTimeStampEpoch,"

		."listingURL"
		.")" 
		."VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
	);

	/*
		options,
			i - integer
			d - double
			s - string
			b - BLOB
	*/
	//Bind, the all are int so we use 'i'
	$result = $stmt->bind_param("sssssssssssssis",
		$listingItemCode,
		$listingTitle,
		$listingTimeLeftAtScrapeTIme,
		$listingCurrentPrice,
		$listingBuyItNowPrice,
		$listingPostagePrice,
		$listingDescription,
		$listingImageLinks,
		$listingStoreName,
		$listingStoreAddress,
		$listingStockNumber,
		$listingIsAlreadySold,
		$listingCategorie,
		$listingDateTimeStampEpoch,
		$listingURL
	);

	if($result == false)
	{
		//error
		echo "SQL ERROR\n";
		return;
	}

	//set real parameters
	$listingItemCode 					= $itemListing->getListingItemCode();
	$listingTitle						= $itemListing->getListingTitle();
	$listingTimeLeftAtScrapeTIme	= $itemListing->getListingTimeLeftAtScrapeTIme();
	$listingCurrentPrice				= $itemListing->getListingCurrentPrice();
	$listingBuyItNowPrice			= $itemListing->getListingBuyItNowPrice();
	$listingPostagePrice				= $itemListing->getListingPostagePrice();
	$listingDescription				= $itemListing->getListingDescription();
	$listingImageLinks				= $itemListing->getListingImageLinksAsString();
	$listingStoreName					= $itemListing->getListingStoreName();
	$listingStoreAddress				= $itemListing->getListingStoreAddress();
	$listingStockNumber				= $itemListing->getListingStockNumber();
	$listingIsAlreadySold			= $itemListing->getListingIsAlreadySold();
	$listingCategorie					= $itemListing->getListingCategorie();
	$listingDateTimeStampEpoch		= $itemListing->getListingDateTimeStampEpoch();
	$listingURL							= $itemListing->getListingURL();

	$stmt->execute();
	
	//clean up
	$stmt->close();
	$conn->close();
}
/*
Takes an 'wShopItemListing' onject as a param and uses the details to update the database
*/
function databaseUpdateScraperRunInfo($itemListing)
{
	//New connection
	$conn = new mysqli(constant("DB_SERVER"), constant("DB_USER"), constant("DB_USER_PASS"), constant("DB_NAME"));

	//error check
	if ($conn->connect_error) 
	{
		 die("Connection failed: " . $conn->connect_error);
	}

	//prepare
	//there is only one row in this table so we cam skip the where
	$stmt = $conn->prepare("UPDATE scraper_info SET lastScrapedStockNumber=?, lastScrapeTimeStampEpoch=?, lastScrapedItemCode=?");

	$result = $stmt->bind_param("sis", 
		$lastScrapedStockNumber, 
		$lastScrapeTimeStampEpoch, 
		$lastScrapedItemCode
	);

	if($result == false)
	{
		//error
		echo "SQL ERROR\n";
		return;
	}

	//set real parameters
	$lastScrapedStockNumber 			= $itemListing->getListingStockNumber();
	$lastScrapeTimeStampEpoch 			= time();	//epoch seconds
	$lastScrapedItemCode 				= $itemListing->getListingItemCode();

	$stmt->execute();
	
	//clean up
	$stmt->close();
	$conn->close();
}

/******************************************************************************
Debug
******************************************************************************/

//databaseInsertScraperRunResults(5,155);

?>