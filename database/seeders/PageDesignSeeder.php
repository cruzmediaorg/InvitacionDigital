<?php

namespace Database\Seeders;

use App\Models\PageDesign;
use App\Models\PageType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageDesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // const designs = ref([
        //     { id: 1, name: 'Create Your Own', image: 'https://www.fixdate.io/public/images/modelo_01_es.webp', colors: ['#f3e8d2', '#e6ccb2', '#ddb892', '#b08968'] },
        //     { id: 2, name: 'Classic', image: 'https://www.fixdate.io/public/images/modelo_36_es.webp', colors: ['#ffffff', '#000000', '#ff0000', '#800000'] },
        //     { id: 3, name: 'Opal', image: 'https://www.fixdate.io/public/images/modelo_21_es.webp', colors: ['#b0e0e6'] },
        //   ]);

        $designs = [
            [
                'name' => 'Create Your Own',
                'page_type' => 'Wedding Invitation',
            ], [
                'name' => 'Classic',
                'page_type' => 'Wedding Invitation',
            ], [
                'name' => 'Opal',
                'page_type' => 'Wedding Invitation',
            ]
        ];

        foreach ($designs as $design) {
            PageDesign::updateOrCreate([
                'name' => $design['name'],
                'page_type_id' => PageType::where('name', $design['page_type'])->first()->id,
            ]);
        }


    }
}
