<?php

class WShopItemListing 
{
	//DB columns
	private $entryID;	

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

	
	public function __construct()
	{
		$this->entryID = "";
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
	}

	public function __destruct()
	{

	}

	//Getters

	//Setters
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

}

?>
