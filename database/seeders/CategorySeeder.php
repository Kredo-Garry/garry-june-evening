<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; //represents the categories table

class CategorySeeder extends Seeder
{

    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'       => 'Books',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name'       => 'Sports',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name'       => 'Cryptocurrency',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name'       => 'News',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->category->insert($categories);
    }
}
