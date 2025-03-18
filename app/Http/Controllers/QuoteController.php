<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class QuoteController extends Controller
{
    public function fetchFromApi(){
        $client = new Client();
        $Response = $client->get('https://gomezmig03.github.io/MotivationalAPI/en.json');
        $quotes = json_decode($response->getBody(),true);

        foreach($quotes as $quote){
            Quote::updateOrCreate(
                ['text' => $quote['text']],
                ['author' => $quote['author']]
            );
        }
        return redirect()->route('quotes.index')->with('succes','Quotes fetched succesfully');
    }
    public function index(){
        $quotes = Quote::all();
        return view('quotes.index',compact('quotes'));
    }
    public function store(Request $request){
        $request->validate([
            'text' => 'required',
            'author' => 'nullable'
        ]);
        Quote::create($request->all);
        return redirect()->route('quotes.index')->with('success','Quote added!');
    }
    public function update(Request $request, Quote $quote){
        $request->validate([
            'text' => 'required',
            'author' => 'nullable'
        ]);
        $quote->update($request->all());
        return redirect()->route('quotes.index')->with('success','Quote updated!');
    }
    public function destroy(Quote $quotes){
        $quote->delete();
        return redirect()->route('quotes.index')->with('success','Quote deleted!');
    }
}
