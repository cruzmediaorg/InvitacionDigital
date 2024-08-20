<?php

namespace App\Http\Controllers;

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
    public function show(Page $page)
    {
        return Inertia::render('Pages/Public/Show', [
            'page' => $page->load(['blocks.fields', 'blocks.type', 'blocks.blocksTypeDesign', 'theme']),
            'styles' => $page->getEffectiveStyles(),
            'theme' => $page->theme->path, // Add this line to pass the theme path
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return Inertia::render('Pages/Edit', [
            'page' => $page->load(['blocks.fields', 'blocks.type']),
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
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}