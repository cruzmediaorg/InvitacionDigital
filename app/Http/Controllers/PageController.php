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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pages/Create', [
            'types' => PagesType::all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, Request $request)
    {
        return Inertia::render('Pages/Public/Show', [
            'page' => $page->load(['blocks.fields', 'blocks.type', 'blocks.blocksTypeDesign', 'theme']),
            'styles' => $page->only([
                'home_h_text_color',
                'home_p_text_color',
                'home_h_font_family',
                'home_p_font_family',
                'home_h1_font_size',
                'home_p_font_size',
                'body_h_text_color',
                'body_p_text_color',
                'body_h_font_family',
                'body_p_font_family',
                'body_h2_font_size',
                'body_p_font_size',
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return Inertia::render('Pages/Edit', [
            'page' => $page->load(['blocks.fields', 'blocks.type', 'blocks.blocksTypeDesign', 'theme']),
            'styles' => $page->only([
                'home_h_text_color',
                'home_p_text_color',
                'home_h_font_family',
                'home_p_font_family',
                'home_h1_font_size',
                'home_p_font_size',
                'body_h_text_color',
                'body_p_text_color',
                'body_h_font_family',
                'body_p_font_family',
                'body_h2_font_size',
                'body_p_font_size',
            ]),
        ]);
    }

    /**
     * Update the theme for the specified resource.
     */
    public function updateTheme(Request $request, Page $page)
    {
        $validated = $request->validate([
            // 'theme_id' => 'nullable|exists:themes,id',
            'home_h_text_color' => 'nullable|string',
            'home_p_text_color' => 'nullable|string',
            'home_h_font_family' => 'nullable|string',
            'home_p_font_family' => 'nullable|string',
            'home_h1_font_size' => 'nullable|integer',
            'home_p_font_size' => 'nullable|integer',
            'body_h_text_color' => 'nullable|string',
            'body_p_text_color' => 'nullable|string',
            'body_h_font_family' => 'nullable|string',
            'body_p_font_family' => 'nullable|string',
            'body_h2_font_size' => 'nullable|integer',
            'body_p_font_size' => 'nullable|integer',
        ]);

        $page->update($validated);

        return back()->with('success', 'Theme updated successfully.');
    }

    public function toggleVisibility(Request $request, Page $page)
    {
        $page->update(['published_at' => $page->published_at ? null : now()]);

        $message = $page->isPublished() ? 'public' : 'private';

        return back()->with('success', 'Your page is now ' . $message);
    }
}
