<?php

namespace App\Http\Controllers;

use App\Models\BlockField;
use Illuminate\Http\Request;

class ImageBlockFieldController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id' => 'required',
        ]);

        $blockField = BlockField::find($request->id);

        if ($blockField->value) {
            $blockField->clearMediaCollection();
        }

        $blockField->addMedia($request->file('file'))->toMediaCollection();
        $blockField->value = $blockField->getFirstMediaUrl();
        $blockField->save();

        return redirect()->back()->with('success', 'Image uploaded successfully');
    }

    public function destroy(Request $request)
    {
        $blockField = BlockField::find($request->id);
        $blockField->clearMediaCollection();
        $blockField->value = null;
        $blockField->save();
        return redirect()->back()->with('success', 'Image deleted successfully');
    }
}
