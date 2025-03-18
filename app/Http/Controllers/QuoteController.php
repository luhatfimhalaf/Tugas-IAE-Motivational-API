<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class QuoteController extends Controller
{
    // Tampilan dashboard (root)
    public function index()
    {
        $quotes = Quote::paginate(10); // Quotes yang sudah ditambahkan
        return view('quotes.index', compact('quotes'));
    }

    // Form cari author dan pilih quote
    public function create()
    {
        $recommendations = [];
        return view('quotes.create', compact('recommendations'));
    }

    // Search author dan tampilkan rekomendasi
    public function searchAuthor(Request $request)
    {
        $keyword = $request->input('author');
        $allQuotes = Cache::remember('api_quotes', 60, function () {
            $client = new Client();
            $response = $client->get('https://gomezmig03.github.io/MotivationalAPI/en.json'); // Data JSON lokal
            $data = json_decode($response->getBody(), true);
            return is_array($data) ? $data : [];
        });

        // Filter quotes berdasarkan author
        $recommendations = array_filter($allQuotes, function ($quote) use ($keyword) {
            return stripos($quote['author'] ?? '', $keyword) !== false;
        });

        return view('quotes.create', compact('recommendations'));
    }

    // Simpan quote (dari rekomendasi atau custom)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'phrase' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'religion' => 'nullable|boolean',
        ]);
        // Pastikan phrase tidak kosong
        if (empty($validatedData['phrase'])) {
            return redirect()->back()->with('error', 'Quote cannot be empty.');
        }

        Quote::create($validatedData);
        return redirect()->route('quotes.index')->with('success', 'Quote added to dashboard!');
    }

    // Update quote di dashboard
    public function update(Request $request, Quote $quote)
    {
        $validatedData = $request->validate([
            'phrase' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'religion' => 'nullable|boolean',
        ]);
        $quote->update($validatedData);
        return redirect()->route('quotes.index')->with('success', 'Quote updated!');
    }

    // Hapus quote dari dashboard
    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('quotes.index')->with('success', 'Quote deleted!');
    }

    // Search quotes di dashboard
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $quotes = Quote::where('phrase', 'like', "%{$keyword}%")
                      ->orWhere('author', 'like', "%{$keyword}%")
                      ->paginate(10);
        return view('quotes.index', compact('quotes'))->with('success', 'Search results for: ' . $keyword);
    }
}
