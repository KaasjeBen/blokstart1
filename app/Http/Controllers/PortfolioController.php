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
            ->when($selectedTag, fn ($query) => $query->whereJsonContains('tags', $selectedTag))
            ->orderByDesc('created_at')
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
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'max:2048'],
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

        $imagePaths = $this->storeUploadedImages($request);

        if ($imagePaths !== []) {
            $portfolio->image = $imagePaths[0];
            $portfolio->images = $imagePaths;
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
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'max:2048'],
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

        $imagePaths = $this->storeUploadedImages($request);

        if ($imagePaths !== []) {
            foreach ($portfolio->imagePaths() as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            $portfolio->image = $imagePaths[0];
            $portfolio->images = $imagePaths;
        }

        $portfolio->save();

        return redirect()->route('portfolio.index')->with('success', 'Portfolio updated successfully.');
    }

    /**
     * @return array<int, string>
     */
    private function storeUploadedImages(Request $request): array
    {
        $files = $request->file('images', []);

        if ($request->hasFile('image')) {
            array_unshift($files, $request->file('image'));
        }

        return array_map(
            fn ($file): string => $file->store('images', 'public'),
            $files,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $request->validate([
            'title_confirmation' => [
                'required',
                'string',
                Rule::in([$portfolio->title]),
            ],
        ], [
            'title_confirmation.in' => 'The project name does not match.',
        ]);

        foreach ($portfolio->imagePaths() as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        $portfolio->delete();

        return redirect()->route('portfolio.index')->with('success', 'Portfolio deleted successfully.');
    }
}
