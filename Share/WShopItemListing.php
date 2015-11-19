<?php

class WShopItemListing 
{
	//DB columns
	private $entryID;	
	private $valid;

	private $listingItemCode;		//Number in the URL that IDs a product
	private $listingTitle;
	private $listingTimeLeftAtScrapeTIme;
	private $listingCurrentPrice;
	private $listingBuyItNowPrice;
	private $listingPostagePrice;
	private $listingDescription;
	private $listingImageLinks;
	private $listingStoreName;
	private $listingStoreAddress;
	private $listingStockNumber;
	private $listingIsAlreadySold;
	private $listingCategorie;
	private $listingURL;
	private $listingDateTimeStampEpoch;

	
	public function __construct()
	{		
		$this->entryID = "";
		$this->valid = false;
		$this->listingItemCode = "";
		$this->listingTitle = "";
		$this->listingTimeLeftAtScrapeTIme = "";
		$this->listingCurrentPrice = "";
		$this->listingBuyItNowPrice = "";
		$this->listingPostagePrice = "";
		$this->listingDescription = "";
		$this->listingImageLinks = array();
		$this->listingStoreName = "";
		$this->listingStoreAddress = "";
		$this->listingStockNumber = "";
		$this->listingIsAlreadySold = "";
		$this->listingCategorie = "";
		$this->listingURL = "";
		$this->listingDateTimeStampEpoch = 0;
	}

	public function __destruct()
	{

	}

	//Getters
	public function getIfValid()
	{
		return $this->valid;
	}
	public function getEntryID()
	{
		return $this->entryID;
	}
	public function getListingItemCode()
	{
		return $this->listingItemCode;
	}
	public function getListingTitle()
	{
		return $this->listingTitle;
	}
	public function getListingTimeLeftAtScrapeTIme()
	{
		return $this->listingTimeLeftAtScrapeTIme;
	}
	public function getListingCurrentPrice()
	{
		return $this->listingCurrentPrice;
	}
	public function getListingBuyItNowPrice()
	{
		return $this->listingBuyItNowPrice;
	}
	public function getListingPostagePrice()
	{
		return $this->listingPostagePrice;
	}
	public function getListingDescription()
	{
		return $this->listingDescription;
	}
	public function getListingImageLinks()
	{
		return $this->listingImageLinks;
	}
	public function getListingImageLinksAsString()
	{
		$retString = "";

		for($i=0;$i<count($this->listingImageLinks);$i++)
		{
			$retString .= $this->listingImageLinks[$i].",";
		}

		return $retString;
	}
	public function getListingStoreName()
	{
		return $this->listingStoreName;
	}
	public function getListingStoreAddress()
	{
		return $this->listingStoreAddress;
	}
	public function getListingStockNumber()
	{
		return $this->listingStockNumber;
	}
	public function getListingIsAlreadySold()
	{
		return $this->listingIsAlreadySold;
	}
	public function getListingCategorie()
	{
		return $this->listingCategorie;
	}
	public function getListingURL()
	{
		return $this->listingURL;
	}
	public function getListingDateTimeStampEpoch()
	{
		return $this->listingDateTimeStampEpoch;
	}

	//Setters
	public function setIfValid($valid)
	{
		$this->valid = $valid;
	}
	public function setEntryID($entryID)
	{
		$this->entryID = $entryID;
	}
	public function setListingItemCode($itemCode)
	{
		$this->listingItemCode = $itemCode;
	}
	public function setListingTitle($title)
	{
		$this->listingTitle = $title;
	}
	public function setListingTimeLeftAtScrapeTIme($timeLeftAtScrapeTIme)
	{
		$this->listingTimeLeftAtScrapeTIme = $timeLeftAtScrapeTIme;
	}
	public function setListingCurrentPrice($currentPrice)
	{
		$this->listingCurrentPrice = $currentPrice;
	}
	public function setListingBuyItNowPrice($buyItNowPrice)
	{
		$this->listingBuyItNowPrice = $buyItNowPrice;
	}
	public function setListingPostagePrice($postagePrice)
	{
		$this->listingPostagePrice = $postagePrice;
	}
	public function setListingDescription($description)
	{
		$this->listingDescription = $description;
	}
	public function setListingImageLinks($imageLinks)
	{
		$this->listingImageLinks = $imageLinks;
	}
	public function setListingImageLinksString($imageLinksString)
	{
		$this->listingImageLinks = explode(',',$imageLinksString);
	}
	public function setListingStoreName($storeName)
	{
		$this->listingStoreName = $storeName;
	}
	public function setListingStoreAddress($storeAddress)
	{
		$this->listingStoreAddress = $storeAddress;
	}
	public function setListingStockNumber($stockNumber)
	{
		$this->listingStockNumber = $stockNumber;
	}
	public function setListingIsAlreadySold($isAlreadySold)
	{
		$this->listingIsAlreadySold = $isAlreadySold;
	}
	public function setListingCategorie($categorie)
	{
		$this->listingCategorie = $categorie;
	}
	public function setListingURL($URL)
	{
		$this->listingURL = $URL;
	}
	public function setListingDateTimeStampEpoch($epoch)
	{
		$this->listingDateTimeStampEpoch = $epoch;
	}

	//Debug
	public function printListing()
	{
		echo "entryID:".$this->entryID."\n";
		echo "listingItemCode:".$this->listingItemCode."\n";
		echo "listingTitle:".$this->listingTitle."\n";
		echo "listingTimeLeftAtScrapeTIme:".$this->listingTimeLeftAtScrapeTIme."\n";
		echo "listingCurrentPrice:".$this->listingCurrentPrice."\n";
		echo "listingBuyItNowPrice:".$this->listingBuyItNowPrice."\n";
		echo "listingPostagePrice:".$this->listingPostagePrice."\n";
		echo "listingDescription:".$this->listingDescription."\n";

		for($i=0;$i<count($this->listingImageLinks);$i++)
		{
			echo "listingImageLinks[".$i."]:".$this->listingImageLinks[$i]."\n";
		}

		echo "listingStoreName:".$this->listingStoreName."\n";
		echo "listingStoreAddress:".$this->listingStoreAddress."\n";
		echo "listingStockNumber:".$this->listingStockNumber."\n";
		echo "listingIsAlreadySold:".$this->listingIsAlreadySold."\n";
		echo "listingCategorie:".$this->listingCategorie."\n";
		echo "listingURL:".$this->listingURL."\n";
		echo "listingDateTimeStampEpoch:".$this->listingDateTimeStampEpoch."\n";
		echo "getlistingImageLinksAsString():".$this->getListingImageLinksAsString()."\n";

		echo "----------------------------------------------------\n";
	}

}

?>
