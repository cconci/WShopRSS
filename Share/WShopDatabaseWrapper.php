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

function databaseSelectWShopItemListingsFromTheLastXDays($numberOfDays)
{
	//New connection
	$conn = new mysqli(constant("DB_SERVER"), constant("DB_USER"), constant("DB_USER_PASS"), constant("DB_NAME"));

	//error check
	if ($conn->connect_error) 
	{
		 die("Connection failed: " . $conn->connect_error);
	}

	$stmt = $conn->prepare("SELECT "
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

		." FROM rss_feed WHERE listingDateTimeStampEpoch < ?");

	$result = $stmt->bind_param("i", 
		$cutOffEpoch, 
	);

	if($result == false)
	{
		//error
		echo "SQL ERROR\n";
		return;
	}

	//set real parameters

	$cutOffEpoch 			= time() - ($numberOfDays * (60*60*24));	//epoch seconds


	$stmt->execute();

	//bind variables to prepared statement
	$stmt->bind_result(
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

	// fetch values 
	while ($stmt->fetch()) 
	{
		echo "".$listingItemCode."\n";
		echo "".$listingTitle."\n";
		echo "".$listingTimeLeftAtScrapeTIme."\n";
		echo "".$listingCurrentPrice."\n";
		echo "".$listingBuyItNowPrice."\n";
		echo "".$listingPostagePrice."\n";
		echo "".$listingDescription."\n";
		echo "".$listingImageLinks."\n";
		echo "".$listingStoreName."\n";
		echo "".$listingStoreAddress."\n";
		echo "".$listingStockNumber."\n";
		echo "".$listingIsAlreadySold."\n";
		echo "".$listingCategorie."\n";
		echo "".$listingDateTimeStampEpoch."\n";
		echo "".$listingURL."\n";

		//add to Listing Item array

	}

	//clean up
	$stmt->close();
	$conn->close();

	//return out itemListings

}

/******************************************************************************
Debug
******************************************************************************/

//databaseInsertScraperRunResults(5,155);

?>
