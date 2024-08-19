<?php

namespace Database\Seeders;

use App\Models\BlocksType;
use App\Models\BlocksTypePagesType;
use App\Models\PagesType;
use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $pageTypes = [
            ['name' => 'Wedding Invitation', 'event_type' => 'Wedding'],
            ['name' => 'Baby Shower Invitation', 'event_type' => 'Baby Shower'],
            ['name' => 'Wedding List', 'event_type' => 'Wedding'],
            ['name' => 'Baby Shower List', 'event_type' => 'Baby Shower'],
            ['name' => 'Gender Reveal Invitation', 'event_type' => 'Gender Reveal'],
            ['name' => 'Birthday Invitation', 'event_type' => 'Birthday'],
        ];

        foreach ($pageTypes as $pageType) {
            PagesType::updateOrCreate([
                'name' => $pageType['name']
            ]
            );
        }

        // Blocks type
       $blockType = BlocksType::updateOrCreate([
            'name' => 'Home',
            ],[
            'page_component' => 'Pages/Public/Components/Home.vue',
            'form_component' => 'Pages/Form/Components/DefaultForm.vue',
            'order' => 1,
        ]);

        $fields = [
        ['name' => 'Partner 1 Name', 'key' => 'partner_1_name', 'type' => 'Text', 'rules' => 'required', 'placeholder' => 'Partner 1'],
        ['name' => 'and', 'key' => 'and', 'type' => 'Text', 'rules' => 'required', 'placeholder' => '&'],
        ['name' => 'Partner 2 Name', 'key' => 'partner_2_name', 'type' => 'Text', 'rules' => 'required', 'placeholder' => 'Partner 2'],
        ['name' => 'Date', 'key'=> 'date', 'type' => 'Date', 'rules' => 'required', 'placeholder' => 'Date'],
        ['name' => 'Welcome message', 'key'=> 'welcome_message', 'type' => 'Text', 'rules' => 'nullable', 'placeholder' => 'Welcome to our wedding website!'],
    ];

        $order = 1;
        foreach ($fields as $field) {
            $blockType->blockTypesFields()->create([
                'name' => $field['name'],
                'key' => $field['key'],
                'type' => $field['type'],
                'required' => $field['rules'] === 'required',
                'nullable' => $field['rules'] === 'nullable',
                'order' => $order++,
                'default' => $field['placeholder'],
            ]);
        }

        // Themes
        Theme::updateOrCreate([
            'name' => 'Default',
        ], [
            'path' => 'default',
        ]);

        // BlocksType / PageType
        BlocksTypePagesType::updateOrCreate([
            'blocks_type_id' => 1,
            'pages_type_id' => 1,
        ]);

        // Onboarding Forms
        $pageType = PagesType::where('name', 'Wedding Invitation')->first();
        $pageType->pageOnboardingForms()->createMany([
            ['name' => 'Partners', 'component' => 'Forms/Wedding/Partners.vue', 'order' => 1],
            ['name' => 'Wedding Date', 'component' => 'Forms/Wedding/BigDay.vue', 'order' => 2],
            ['name' => 'Select Design', 'component' => 'Forms/Wedding/SelectDesign.vue', 'order' => 3],
        ]);
    }
}
