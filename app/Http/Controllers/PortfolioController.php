<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $availableTags = Portfolio::availableTags();
        $selectedTag = $request->input('tag');

        $request->validate([
            'tag' => ['nullable', Rule::in(array_keys($availableTags))],
        ]);

        $portfolios = Portfolio::query()
            ->when($selectedTag, fn($query) => $query->whereJsonContains('tags', $selectedTag))
            ->get();

        return view('portfolio', compact('portfolios', 'availableTags', 'selectedTag'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portfolio_create', ['availableTags' => Portfolio::availableTags()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'tags' => ['required', 'array', 'min:1'],
            'tags.*' => ['string', Rule::in(array_keys(Portfolio::availableTags()))],
        ]);

        $portfolio = new Portfolio;
        $portfolio->user_id = Auth::id();
        $portfolio->title = $request->input('title');
        $portfolio->description = $request->input('description');
        $portfolio->email = $request->input('email');
        $portfolio->phone = $request->input('phone');
        $portfolio->tags = $request->input('tags');

        if ($request->hasFile('image')) {
            $portfolio->image = $request->file('image')->store('images', 'public');
        }

        $portfolio->save();

        return redirect()->route('portfolio.index')->with('success', 'Portfolio created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        return view('portfolio_show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        return view('portfolio_edit', [
            'portfolio' => $portfolio,
            'availableTags' => Portfolio::availableTags(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'tags' => ['required', 'array', 'min:1'],
            'tags.*' => ['string', Rule::in(array_keys(Portfolio::availableTags()))],
        ]);

        $portfolio = Portfolio::findOrFail($id);
        $portfolio->title = $request->input('title');
        $portfolio->description = $request->input('description');
        $portfolio->email = $request->input('email');
        $portfolio->phone = $request->input('phone');
        $portfolio->tags = $request->input('tags');

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $portfolio->image = $request->file('image')->store('images', 'public');
        }

        $portfolio->save();

        return redirect()->route('portfolio.index')->with('success', 'Portfolio updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $portfolio->delete();

        return redirect()->route('portfolio.index')->with('success', 'Portfolio deleted successfully.');
    }
}
