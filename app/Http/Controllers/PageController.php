<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Page;
use App\Models\PagesType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pages/Create', [
            'types' => PagesType::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Request $request)
    {
        if ($request->has('preview')) {
            $blocks = json_decode($request->input('blocks'), true);
            $styles = json_decode($request->input('styles'), true);
            
            // Apply the preview changes
            $page->blocks = collect($blocks)->map(function ($block) {
                return new Block($block);
            });
            $page->load(['blocks.fields', 'blocks.type', 'blocks.blocksTypeDesign', 'theme']);
            $page->fill($styles);
            
        } else {
            $page->load(['blocks.fields', 'blocks.type', 'blocks.blocksTypeDesign', 'theme']);
        }

        return Inertia::render('Pages/Public/Show', [
            'page' => $page,
            'styles' => $page->only([
                'home_h_text_color', 'home_p_text_color', 'home_h_font_family', 'home_p_font_family',
                'home_h1_font_size', 'home_h2_font_size', 'home_h3_font_size', 'home_p_font_size',
                'body_h_text_color', 'body_p_text_color', 'body_h_font_family', 'body_p_font_family',
                'body_h1_font_size', 'body_h2_font_size', 'body_h3_font_size', 'body_p_font_size',
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return Inertia::render('Pages/Edit', [
            'page' => $page->load(['blocks.fields', 'blocks.type', 'theme']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Update the theme for the specified resource.
     */
    public function updateTheme(Request $request, Page $page)
    {
        $validated = $request->validate([
            'theme_id' => 'nullable|exists:themes,id',
            'home_h_text_color' => 'nullable|string',
            'home_p_text_color' => 'nullable|string',
            'home_h_font_family' => 'nullable|string',
            'home_p_font_family' => 'nullable|string',
            'home_h1_font_size' => 'nullable|integer',
            'home_h2_font_size' => 'nullable|integer',
            'home_h3_font_size' => 'nullable|integer',
            'home_p_font_size' => 'nullable|integer',
            'body_h_text_color' => 'nullable|string',
            'body_p_text_color' => 'nullable|string',
            'body_h_font_family' => 'nullable|string',
            'body_p_font_family' => 'nullable|string',
            'body_h1_font_size' => 'nullable|integer',
            'body_h2_font_size' => 'nullable|integer',
            'body_h3_font_size' => 'nullable|integer',
            'body_p_font_size' => 'nullable|integer',
        ]);

        $page->update($validated);

        return back()->with('success', 'Theme updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}