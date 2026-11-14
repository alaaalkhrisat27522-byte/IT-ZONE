<?php

namespace App\Http\Controllers;

use App\Models\GlossaryTerm;
use Illuminate\Http\Request;

class GlossaryController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $terms = GlossaryTerm::when($q, fn ($query) => $query->where(function ($query) use ($q) {
                $query->where('term', 'like', "%{$q}%")
                        ->orWhere('short_definition', 'like', "%{$q}%");
            }))
            ->orderBy('term')
            ->get();

        return view('glossary.index', compact('terms', 'q'));
    }
}
