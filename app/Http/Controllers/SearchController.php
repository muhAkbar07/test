<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; // Ensure this model exists and is properly set up

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('no_ticket');

        // Replace with your actual search logic
        $results = Ticket::where('no_ticket', 'like', '%' . $query . '%')->get();

        return response()->json($results);
    }
}