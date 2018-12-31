///////////////////////////////////////////////////////////////////////////////
// Item Listing - port from PHP version
///////////////////////////////////////////////////////////////////////////////

class WShopItemListing {
	constructor(entryID, valid) {
		this.entryID = entryID;
		this.valid = valid;

		this.listingItemCode = "";
		this.listingTitle = "";
		this.listingTimeLeftAtScrapeTIme = "";
		this.listingCurrentPrice = "";
		this.listingBuyItNowPrice = "";
		this.listingPostagePrice = "";
		this.listingDescription = "";
		this.listingImageLinks = []; //array
		this.listingStoreName = "";
		this.listingStoreAddress = "";
		this.listingStockNumber = "";
		this.listingIsAlreadySold = "";
		this.listingCategorie = "";
		this.listingURL = "";
		this.listingDateTimeStampEpoch = 0;
	}


//	eg() {
//		return `${this.name} says hello.`;
//	}

	//Getters
	getIfValid(){
		return this.valid;
	}

	getEntryID(){
		return this.entryID;
	}
	getListingItemCode(){
		return this.listingItemCode;
	}
	getListingTitle(){
		return this.listingTitle;
	}
	getListingTimeLeftAtScrapeTIme(){
		return this.listingTimeLeftAtScrapeTIme;
	}
	getListingCurrentPrice(){
		return this.listingCurrentPrice;
	}
	getListingBuyItNowPrice(){
		return this.listingBuyItNowPrice;
	}
	getListingPostagePrice(){
		return this.listingPostagePrice;
	}
	getListingDescription(){
		return this.listingDescription;
	}
	getListingImageLinks(){
		return this.listingImageLinks;
	}
	getListingImageLinksAsString(){
		var retString = "";
		var i;

		for(i=0;i<this.listingImageLinks.length;i++)
		{
			retString += this.listingImageLinks[i]+",";
		}

		return retString;
	}
	getListingStoreName(){
		return this.listingStoreName;
	}
	getListingStoreAddress(){
		return this.listingStoreAddress;
	}
	getListingStockNumber(){
		return this.listingStockNumber;
	}
	getListingIsAlreadySold(){
		return this.listingIsAlreadySold;
	}
	getListingCategorie(){
		return this.listingCategorie;
	}
	getListingURL(){
		return this.listingURL;
	}
	getListingDateTimeStampEpoch(){
		return this.listingDateTimeStampEpoch;
	}

	//Setters
	setIfValid(valid){
		this.valid = valid;
	}
	setEntryID(entryID){
		this.entryID = entryID;
	}
	setListingItemCode(itemCode){
		this.listingItemCode = itemCode;
	}
	setListingTitle($title){
		this.listingTitle = title;
	}
	setListingTimeLeftAtScrapeTIme($timeLeftAtScrapeTIme){
		this.listingTimeLeftAtScrapeTIme = timeLeftAtScrapeTIme;
	}
	setListingCurrentPrice(currentPrice){
		this.listingCurrentPrice = currentPrice;
	}
	setListingBuyItNowPrice(buyItNowPrice){
		this.listingBuyItNowPrice = buyItNowPrice;
	}
	setListingPostagePrice(postagePrice){
		this.listingPostagePrice = postagePrice;
	}
	setListingDescription(description){
		this.listingDescription = description;
	}
	setListingImageLinks(imageLinks){
		this.listingImageLinks = imageLinks;
	}
	//setListingImageLinksString(imageLinksString){
	//	this.listingImageLinks = explode(',',$imageLinksString);
	//}
	setListingStoreName(storeName){
		this.listingStoreName = storeName;
	}
	setListingStoreAddress(storeAddress){
		this.listingStoreAddress = storeAddress;
	}
	setListingStockNumber(stockNumber){
		this.listingStockNumber = stockNumber;
	}
	setListingIsAlreadySold(isAlreadySold){
		this.listingIsAlreadySold = isAlreadySold;
	}
	setListingCategorie(categorie){
		this.listingCategorie = categorie;
	}
	setListingURL(URL){
		this.listingURL = URL;
	}
	setListingDateTimeStampEpoch(epoch){
		this.listingDateTimeStampEpoch = epoch;
	}

	//Debug
	printListingCli(){
		var i;
		
		console.log(`entryID: ${this.entryID}`);
		console.log(`listingItemCode: ${this.listingItemCode}`);
		console.log(`listingTitle:${this.listingTitle}`);
		console.log(`listingTimeLeftAtScrapeTIme:${this.listingTimeLeftAtScrapeTIme}`);
		console.log(`listingCurrentPrice:${this.listingCurrentPrice}`);
		console.log(`listingBuyItNowPrice:${this.listingBuyItNowPrice}`);
		console.log(`listingPostagePrice:${this.listingPostagePrice}`);
		console.log(`listingDescription:${this.listingDescription}`);

		for(i=0;i<$this.listingImageLinks.length;i++)
		{
			console.log(`listingImageLinks[".${i}."]:${this.listingImageLinks[$i]}`);
		}

		console.log(`listingStoreName:${this.listingStoreName}`);
		console.log(`listingStoreAddress:${this.listingStoreAddress}`);
		console.log(`listingStockNumber:${this.listingStockNumber}`);
		console.log(`listingIsAlreadySold:${this.listingIsAlreadySold}`);
		console.log(`listingCategorie:${this.listingCategorie}`);
		console.log(`listingURL:${this.listingURL}`);
		console.log(`listingDateTimeStampEpoch:${this.listingDateTimeStampEpoch}`);
		//console.log(`getlistingImageLinksAsString():${this.getListingImageLinksAsString()}`);

		console.log(`----------------------------------------------------`);
	}

}

///////////////////////////////////////////////////////////////////////////////
//Exports
///////////////////////////////////////////////////////////////////////////////

module.exports = WShopItemListing;

