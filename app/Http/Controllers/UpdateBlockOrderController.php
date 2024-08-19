<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class UpdateBlockOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'blocks' => 'required|array',
            'blocks.*.id' => 'required|exists:blocks,id',
            'blocks.*.order' => 'required|integer',
        ]);

        $blocks = $request->input('blocks');

        foreach ($blocks as $b) {
          $blockToUpdate = Block::find($b['id']);
          $blockToUpdate->update(['order' => $b['order']]);
        }

        return redirect()->back()->with('success', 'Blocks order updated successfully');
    }
}
