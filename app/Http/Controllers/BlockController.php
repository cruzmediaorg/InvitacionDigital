<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\BlockTypesField;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlockController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page, Block $block)
    {
        return Inertia::render($block->type->form_component, [
            'page' => $page->load(['blocks.fields', 'blocks.type', 'theme']),
            'block' => $block->load('fields', 'type.blockTypesFields'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Page $page, Block $block, Request $request)
    {
       $request->validate([
           'fields' => 'array',
       ]);

        foreach ($request->fields as $field) {

           $blockType = BlockTypesField::findOrFail($field['block_types_field_id']);

              if ($blockType->required && empty($field['value'])) {
                  return redirect()->back()->with('error', 'The ' . $blockType->name . ' field is required.');
              }

            $block->fields()->updateOrCreate([
                'block_types_field_id' => $blockType->id,
                'block_id' => $block->id,
                ],
                ['value' => $field['value']]
            );
        }

        return redirect()->back()->with('success', 'Block updated.');
    }

    public function updateSettings(Request $request, Page $page, Block $block)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'is_visible' => 'required|boolean',
        ]);

        $block->update($validated);

        return redirect()->back()->with('success', 'Block settings updated successfully.');
    }
}