<?php

namespace App\Http\Controllers;

use Goutte\Client;

use App\Http\Controllers\DbController; 

use App\Exports\BermudaExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ScraperController extends Controller
{
    private $results =  array();

    public function scraping($url){
            
        $client = new Client();
        $page = $client->request('GET',$url);

        return $page;
    
    }

    public function scraper1()
    {
        // call the function to connect to the database
        // $db = DbController::connect();

        $title = "scraper1 - decathlon bermuda homme";

        $page = $this->scraping('https://www.decathlon.fr/browse/c0-homme/nature-bermuda/_/N-1qu1ue2Z19ohcfe');

        $page->filter('.dpb-holder')->each(function($item) {
            $this->results[$item->filter('.dpb-product-model-link .vh')->text()] = $item->filter('.dpb-product-model-link')->attr('href');
        });

        $data = $this->results;

        return view('scraper/scraper1',compact('title','data'));
    }

    public function export(){
        // fonction pour export le CSV

        $page = $this->scraping('https://www.decathlon.fr/browse/c0-homme/nature-bermuda/_/N-1qu1ue2Z19ohcfe');

        $page->filter('.dpb-holder')->each(function($item) {
            $this->results[$item->filter('.dpb-product-model-link .vh')->text()] = $item->filter('.dpb-product-model-link')->attr('href');
        });

        $data = $this->results;

        $bermudas = array();
        // dd($bermudas);

        foreach($data as $key => $value){
            // push dans $bermudas un array avec les valeurs de $key et $value
            array_push($bermudas, array('name' => $key, 'link' => 'https://decathlon.fr/'.$value));
        }
          
        return Excel::download(new BermudaExport($bermudas), 'bermudas.xlsx');
    }
}
