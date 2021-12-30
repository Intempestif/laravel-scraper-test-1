<?php

namespace App\Http\Controllers;

use Goutte\Client;

use App\Exports\BermudaExport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function export(){
        // fonction pour export le CSV

        $bermudas = [
            [
                'name' => 'One',
                'link' => 'test'
            ],
            [
                'name' => 'Two',
                'link' => 'test'
            ],
            [
                'name' => 'Three',
                'link' => 'test'
            ]
        ];

        $client = new Client();
        $url = "https://www.decathlon.fr/browse/c0-homme/nature-bermuda/_/N-1qu1ue2Z19ohcfe";
        $page = $client->request('GET',$url);

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
