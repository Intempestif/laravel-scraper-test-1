<?php

namespace App\Http\Controllers;

use Goutte\Client;

use Illuminate\Http\Request;

class ScraperController extends Controller
{
    private $results =  array();

    public function scraper1()
    {
        $title = "scraper1 - decathlon bermuda homme";

        $client = new Client();
        $url = "https://www.decathlon.fr/browse/c0-homme/nature-bermuda/_/N-1qu1ue2Z19ohcfe";
        $page = $client->request('GET',$url);
        
        // print_r($page);

        $page->filter('.dpb-holder')->each(function($item) {
            $this->results[$item->filter('.dpb-product-model-link .vh')->text()] = $item->filter('.dpb-product-model-link')->attr('href');
        });

        $data = $this->results;

        return view('scraper/scraper1',compact('title','data'));
    }
}
