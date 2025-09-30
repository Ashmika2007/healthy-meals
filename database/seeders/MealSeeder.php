<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;  
use App\Models\Category;
use App\Models\Meal;

class MealSeeder extends Seeder
{
    public function run(): void
    {
        $sets = [
            'Vegan' => [
                'Avocado Salad','Chickpea Buddha Bowl','Quinoa Veggie Bowl','Tofu Stir-Fry',
                'Lentil Curry','Veggie Wrap','Roasted Veggie Pasta','Sweet Potato & Black Bean Bowl',
                'Vegan Caesar Salad','Mushroom Risotto (Vegan)','Grilled Vegetable Skewers','Spinach & Chickpea Stew',
                'Vegan Pad Thai','Falafel Plate','Tomato Basil Penne (Vegan)','Coconut Veggie Korma',
                'Zucchini Noodles Marinara','Kale & Quinoa Salad','Moroccan Couscous','Vegan Burrito Bowl',
            ],
            'Keto' => [
                'Beef & Broccoli','Chicken Alfredo Zoodles','Garlic Butter Salmon','Bacon & Egg Bowl',
                'Keto Chicken Stir-Fry','Cauliflower Fried Rice','Bunless Cheeseburger Bowl','Creamy Tuscan Chicken',
                'Pesto Zoodle Bowl','Keto Meatballs Marinara','Herb Roasted Chicken Thighs','Buffalo Chicken Lettuce Wraps',
                'Shrimp Scampi Zoodles','Keto Cobb Salad','Pulled Pork Bowl','Sausage & Peppers Skillet',
                'Lemon Butter Tilapia','Philly Cheesesteak Bowl','Greek Chicken Salad (Keto)','Keto Chicken Caesar',
            ],
            'Gluten-free' => [
                'Grilled Chicken & Quinoa','Baked Salmon & Veg','Rice Noodle Pad Thai (GF)','Chicken & Brown Rice Bowl',
                'Teriyaki Beef with Rice (GF)','Stuffed Bell Peppers (GF)','Turkey Chili (GF)','Mediterranean Quinoa Bowl (GF)',
                'Potato & Leek Soup (GF)','BBQ Chicken with Corn (GF)','Shrimp Tacos (Corn Tortillas)','Coconut Curry Chicken (GF)',
                'Lemon Herb Chicken & Potatoes','Mexican Rice Bowl (GF)','Greek Lemon Rice Soup (GF)','Butter Chicken with Rice (GF)',
                'Garlic Chicken Stir Fry (GF)','Thai Green Curry with Rice (GF)','Sesame Chicken & Rice (GF)','Honey Garlic Shrimp & Rice (GF)',
            ],
            'High protein' => [
                'Chicken Caesar Salad','Steak & Sweet Potato','Grilled Chicken & Veg','Beef Chili Bowl',
                'Turkey Meatball Marinara','Tuna Poke Bowl','Chicken Fajita Bowl','Salmon Power Bowl',
                'Egg White Veggie Scramble','Greek Chicken Bowls','BBQ Chicken Protein Bowl','Teriyaki Salmon & Rice',
                'Spicy Chicken Quinoa','Chicken Fiesta Salad','Garlic Chicken Stir Fry','Beef Burrito Bowl (HP)',
                'Protein Pasta Bolognese','Lemon Pepper Chicken','Harissa Chicken & Couscous','Tandoori Chicken & Rice',
            ],
        ];

        foreach ($sets as $categoryName => $meals) {
            $category = Category::where('name', $categoryName)->first();
            foreach ($meals as $i => $name) {
                Meal::firstOrCreate(
                    ['name' => $name, 'category_id' => $category->id],
                    [
                        'price' => fake()->randomFloat(2, 8, 18),           // $8–$18
                        'image' => $this->filenameFrom($categoryName, $i),  // e.g. vegan-01.jpg
                    ]
                );
            }
        }
    }

    private function filenameFrom(string $category, int $i): string
    {
        $prefix = Str::slug($category);        // vegan, keto, gluten-free, high-protein
        $num = str_pad($i+1, 2, '0', STR_PAD_LEFT);
        return "{$prefix}-{$num}.jpg";         // put these image files in storage/app/public/meals
    }
}

