<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = \App\Models\Portfolio::all();
        return view('portfolio', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portfolio_create');
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
        ]);

        $portfolio = new \App\Models\Portfolio();
        $portfolio->user_id = Auth::id();
        $portfolio->title = $request->input('title');
        $portfolio->description = $request->input('description');
        $portfolio->email = $request->input('email');
        $portfolio->phone = $request->input('phone');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $portfolio->image = basename($imagePath);
        }

        $portfolio->save();

        return redirect()->route('portfolio.index')->with('success', 'Portfolio created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $portfolio = \App\Models\Portfolio::findOrFail($id);
        return view('portfolio_show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
