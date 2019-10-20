<?php

namespace App\Handlers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ads;
use PHPHtmlParser\Dom;

class ExternalHandler
{
	public $externalUrl = 'https://www.polovniautomobili.com/auto-oglasi/pretraga?brand=audi&model=&price_from=40000&price_to=&year_from=&year_to=&door_num=&submit_1=&without_price=1&date_limit=&showOldNew=all&modeltxt=&engine_volume_from=&engine_volume_to=&power_from=&power_to=&mileage_from=&mileage_to=&emission_class=&seat_num=&wheel_side=&registration=&country=&city=&page=&sort=';

    	/**
     	* Grab data and scrape it
     	*
     	*/
   	public function getData()
    	{
	    	$url = $this->externalUrl;
	    	$scrappedData = $this->scrapeData($url);

	    	return $scrappedData;
    	}

   	 /**
     	* Scrape the required data
     	*
     	*/
    	private function scrapeData($url)
    	{
		$elems = [];
		
		$dom = new Dom;

		/**
		 * Load data from the external source
		 */
		$dom->load($url, [
			'removeScripts' => false
		]);

		/**
		 * Load serch results to dom
		 */
		$results = $dom->find('#search-results');

		$dom->loadStr($results, [
			'removeScripts' => false
		]);

		/*$dom->loadStr($results->innerHtml, [
			'removeScripts' => false
		]);*/

		/**
		 * Find all script elements
		 */
		$jsons = $dom->find('script');

		/**
		 * Find all articles elements
		 */
		$articles = $dom->find('article');

		/**
		 * Scrape data from json
		 */

		$i = 0;
		foreach ($jsons as $json)
		{
			$jsonStructure = json_decode($json->innerHtml);
	 		
	 		if((json_last_error() == JSON_ERROR_NONE)){
	 			if(count($jsonStructure) <= 1){

	 				$articleDom = new Dom;
	 				$articleHtml = $articleDom->loadStr($articles[$i]->innerHtml, []);

	 				$id = ($articles[$i]->getAttribute('data-classifiedid') == null) ? 0 : $articles[$i]->getAttribute('data-classifiedid');
	 				$price = ($articleHtml->find('.price', 0) == null) ? 0 :  trim($articleHtml->find('.price', 0)->innerHtml);

	 				$elems[] = [
	 					'id' => $id,
	 					'price' => preg_replace('/\D/', '', $price),
	 					'name' => trim($jsonStructure[0]->name),
	 					'image' => trim($jsonStructure[0]->image),
	 					'year' => trim($jsonStructure[0]->productionDate),
	 					'range' => preg_replace('/\D/', '', $jsonStructure[0]->mileageFromOdometer),
	 				];

	 				$i++;
	 			}
			}
		}

		return $elems;
    	}
}