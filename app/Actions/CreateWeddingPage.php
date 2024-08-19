<?php

namespace App\Actions;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Page;
use App\Models\PageType;
use Illuminate\Support\Str;

class CreateWeddingPage
{
    /**
     * Create a new class instance.
     */
    public static function handle($userId, $data, $pageType)
    {

        $partners = $data['partners'];
        $content = [];
        $content['partner_1_name'] = $partners[0]['firstName'] . ' ' . $partners[0]['lastName'];
        $content['partner_2_name'] = $partners[1]['firstName'] . ' ' . $partners[1]['lastName'];
        if($data['weddingDate'] == null){
            $content['date'] = 'TBD';
        } else {
            $content['date'] = $data['weddingDate'];
        }

        $page =  Page::create([
            'title' => $partners[0]['firstName'] . ' & ' . $partners[1]['firstName'] . ' Wedding',
            'pages_type_id' => $pageType->id,
            'user_id' => $userId,
            'theme_id' => $data['selectedDesign'],
        ]);

        foreach($pageType->blocksType as $blockType){
            $block = $page->blocks()->create([
                'blocks_type_id' => $blockType->id,
                'title' => $blockType->name,
                'order' => $blockType->order,
            ]);

            // Create fields for the block
            foreach($blockType->blockTypesFields as $field){
                if(array_key_exists($field->key, $content)){
                    $block->fields()->create([
                        'block_types_field_id' => $field->id,
                        'value' => $content[$field->key],
                        'order' => $field->order,
                    ]);
                } else {
                    $block->fields()->create([
                        'block_types_field_id' => $field->id,
                        'value' => $field->default,
                        'order' => $field->order,
                    ]);
                }
            }
        }

        return $page;
    }
}
