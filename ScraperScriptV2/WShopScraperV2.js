///////////////////////////////////////////////////////////////////////////////
//WShopScraper V2
///////////////////////////////////////////////////////////////////////////////

//require
const WShopItemListing     = require('./WShopItemListing.js');
const WShopDatabaseWrapper = require('./WShopDatabaseWrapper.js');
const WShopDatabaseAccess  = require('./WShopDatabaseAccess.js');
const WShopDefines         = require('./WShopDefines.js');

//Stats
var StatsPageButtonPresses = 0;
var StatsVisitAttempts = 0;


var MAX_VISIT_ATTEMPTS = 20; 

///////////////////////////////////////////////////////////////////////////////
//Functions
///////////////////////////////////////////////////////////////////////////////
function processItemData(browser){

	var prodInfo = browser.html(".product-item-wrapper");
	var prodInfoSPlit = prodInfo.split("product-item-wrapper");

	console.log(`#Data Length:${prodInfo.length}`);
	console.log(`#Products Found:${prodInfoSPlit.length}`);
/*
	for(i=0;i<prodInfoSPlit.length;i++){

		const item1 = new WShopItemListing('Varg', 1);

		console.log('-----------------------------------\n');
		console.log(prodInfoSPlit[i]);
		console.log('-----------------------------------\n');

	}
*/
	console.log("processItemData():END");

	return 0; //not done

}

function keepReadingDataFromPage(browser){

	console.log(`Pressing Button.......${StatsPageButtonPresses}`);

	browser.pressButton("Load more").then(() => {
		console.log('Load more');

		var areWeDone = processItemData(browser);

		if(areWeDone == 0){
			keepReadingDataFromPage(browser);
		}else{
			//browser.dump();
			process.exit();			
		}

	});

	StatsPageButtonPresses++;
}

function scrapePage(browser){

	console.log(`Visit: ${url}..`);

	//Everything
	//console.log(browser.html('body'));
	
	keepReadingDataFromPage(browser);


	console.log(`END scrapePage()`);
	//browser.dump();
	//process.exit();	//need to wait for the button press etc..
}

function contactServer(browser){

	StatsVisitAttempts++;
	console.log(`Visit Site..`);
	browser.visit(url).then(() => {

		scrapePage(browser);

	}).catch(error => {

		var tryAgain = false;

		if(error.name == 'TypeError'){

			console.log(`Type Error occurred visiting ${url}`);
			tryAgain = true;


		}else if(error.name == 'Error'){

			//console.log(`Timeout occurred visiting ${url}`);
			console.log(`Error (possibly Timeout) occurred visiting ${url}`);
			tryAgain = true;

		}else{

			console.log(`error.name:<${error.name }>`);
		    console.error(`Error occurred visiting ${url}`);

		    console.log(error);

		    tryAgain = false;

		    process.exit();	
		}

		//try again ?
		if(tryAgain == true){

			console.log(`Try Again ? (${StatsVisitAttempts})`);
			if(StatsVisitAttempts < MAX_VISIT_ATTEMPTS){
				contactServer(browser);
			}else{

				console.log(`Give Up - to many fails`);

				process.exit();	
			}

		}

		
	});

}

///////////////////////////////////////////////////////////////////////////////
//Main
///////////////////////////////////////////////////////////////////////////////

console.log('-----------------------------------');
console.log('WShop Scraper V2');
console.log('-----------------------------------');

const Browser = require('zombie');
const url = WShopDefines.URL_TOP_LEVEL;
const user_agent = '';//'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/535.20 (KHTML, like Gecko) Chrome/19.0.1036.7 Safari/535.20';


console.log(`URL from File: <${url}>from file`);
//console.log(` ${WShopDatabaseAccess.DB_SERVER} from file`);
//console.log(` ${WShopDatabaseAccess.DB_USER} from file`);
//console.log(` ${WShopDatabaseAccess.DB_USER_PASS} from file`);
//console.log(` ${WShopDatabaseAccess.DB_NAME} from file`);



let browser = new Browser({
	userAgent: user_agent,
	runScripts: true,
	debug: false,
	silent: true,
	waitDuration: '10s' //<https://github.com/assaf/zombie/issues/882> Odd timeout issue
	//waitDuration: 45*1000
});

//This is from an example, standard items
browser.headers = {
	"connection": "keep-alive",
	"user-agent": "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0",
	"accept": "text/html",  
	"accept-language": "en-US",
	"accept-charset": "ISO-8859-1", 
	"content-type": "application/x-www-form-urlencoded"
};

try{
	//Shows me the version (6.1.4)
	browser.dump();
}catch (error) {
	//it will be the URL error as I have not set up the browser yet
    //console.log(error)
}

//Repeat on TypeError as it just sometimes happens......
console.log('browser async spawn');
contactServer(browser);

console.log('~main end');