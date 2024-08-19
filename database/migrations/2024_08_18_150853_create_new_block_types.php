<?php

use App\Models\BlocksType;
use App\Models\PagesType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $pageType = PagesType::where('name', 'Wedding Invitation')->first();

       $ourStory = $pageType->blocksType()->updateOrCreate([
            'name' => 'Our Story',
            ],[
            'page_component' => 'Public/Components/OurStory.vue',
            'form_component' => 'Public/Components/OurStoryForm.vue',
            'order' => 2,
        ]);

       $ourStory->blockTypesFields()->createMany([
            [
                'name' => 'Title',
                'key' => 'title',
                'type' => 'text',
                'order' => 1,
                'required' => true,
                'default' => 'Our Story',
            ],
            [
                'name' => 'Description',
                'key' => 'description',
                'type' => 'textarea',
                'order' => 2,
                'required' => true,
                'default' => 'We met in the beautiful place of the world',
            ],
        ]);

       // Location
         $location = $pageType->blocksType()->updateOrCreate([
                'name' => 'Location',
                ],[
                'page_component' => 'Public/Components/Location.vue',
                'form_component' => 'Public/Components/LocationForm.vue',
                'order' => 3,
          ]);

            $location->blockTypesFields()->createMany([
                    [
                        'name' => 'Title',
                        'key' => 'title',
                        'type' => 'text',
                        'order' => 1,
                        'required' => true,
                        'default' => 'Location',
                    ],
                    [
                        'name' => 'Description',
                        'key' => 'description',
                        'type' => 'textarea',
                        'order' => 2,
                        'required' => false,
                        'default' => 'We are located at the beautiful place of the world',
                    ],
                    [
                        'name' => 'Location',
                        'key' => 'location',
                        'type' => 'text',
                        'order' => 3,
                        'required' => false,
                        'default' => 'Madrid, Spain',
                    ],
                    [
                        'name' => 'Map',
                        'key' => 'map',
                        'type' => 'text',
                        'order' => 4,
                        'required' => false,
                        'default' => 'https://maps.app.goo.gl/v1xz1111111111111',
                    ],
                ]);

        // Schedule
        $schedule = $pageType->blocksType()->updateOrCreate([
            'name' => 'Schedule',
            ],[
            'page_component' => 'Public/Components/Schedule.vue',
            'form_component' => 'Public/Components/ScheduleForm.vue',
            'order' => 4,
        ]);

        $schedule->blockTypesFields()->createMany([
            [
                'name' => 'Title',
                'key' => 'title',
                'type' => 'text',
                'order' => 1,
                'required' => true,
                'default' => 'Schedule',
            ],
            [
                'name' => 'Events',
                'key' => 'events',
                'type' => 'array',
                'order' => 2,
                'required' => false,
                'default' => '[{"title": "Ceremony", "time": "10:00", "location": "Madrid, Spain"}, {"title": "Reception", "time": "14:00", "location": "Madrid, Spain"}]',
            ],
        ]);

        // Q & A
        $qna = $pageType->blocksType()->updateOrCreate([
            'name' => 'Q & A',
            ],[
            'page_component' => 'Public/Components/QnA.vue',
            'form_component' => 'Public/Components/QnAForm.vue',
            'order' => 5,
        ]);

        $qna->blockTypesFields()->createMany([
            [
                'name' => 'Title',
                'key' => 'title',
                'type' => 'text',
                'order' => 1,
                'required' => false,
                'default' => 'Q & A',
            ],
            [
                'name' => 'Questions',
                'key' => 'questions',
                'type' => 'array',
                'order' => 2,
                'required' => false,
                'default' => '[{"question": "What is the dress code?", "answer": "We will be dressing up in white dresses"}, {"question": "What is the dress code?", "answer": "We will be dressing up in white dresses"}]',
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $blockType = BlocksType::whereIn('name', ['Our Story', 'Location', 'Schedule', 'Q & A'])->pluck('id');
        \App\Models\BlocksTypePagesType::whereIn('blocks_type_id', $blockType)->forceDelete();
        \App\Models\Block::whereIn('blocks_type_id', $blockType)->forceDelete();
        \App\Models\BlockTypesField::whereIn('blocks_type_id', $blockType)->forceDelete();


        BlocksType::whereIn('name', ['Our Story', 'Location', 'Schedule', 'Q & A'])->forceDelete();

    }
};
