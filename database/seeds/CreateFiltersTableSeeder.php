<?php

use App\Ads;
use App\AdsImages;
use App\Filter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateFiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Filter::truncate();
        Ads::truncate();
        AdsImages::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('ads_filter')->delete();

////CATEGORY KIDS////

        $category = \App\Category::where('categoryName', 'Kids')->first();
        $subCategories = [
            'Baby\'s Bedroom',
            'Baby\'s Home',
            'Baby\'s Clothes',
            'Little Girls Closet',
            'Little Boys Closet',
            'Buggies and Car seats',
            'Toys'
        ];

        $filters = [
            'Baby\'s Bedroom' => [
                'Type' => [
                    'Furniture' => [
                        'beds and cribs', 'changing tables'
                    ],
                    'Bedding' => [
                        'mattress', 'blankets and pillows', 'sheets'
                    ],
                    'Baby nests',
                    'Nourishing pillows',
                    'Sleeping accessories',
                    'Room decoration',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Benetton','Zara Kids','Noppies','Clasens','Petit Bateau','Nik&Nik','Tommy Hilfiger','Calvin Klein',
                    'Kenzo Kids','Nike','Adidas','Levis','Burberry','Gucci','BAM BAM', 'Other'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmire', 'other'
                ]

            ],
            'Baby\'s Home' => [
                'Type' => [
                    'Baby monitors',
                    'Bath accessories',
                    'Baby swings',
                    'Highchairs',
                    'Play rugs',
                    'Bouncers',
                    'Music mobile',
                    'Tableware',
                    'Electric appliances',
                    'Baby care',
                    'Toys',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Benetton','Zara Kids','Noppies','Clasens','Petit Bateau','Nik&Nik','Tommy Hilfiger','Calvin Klein',
                    'Kenzo Kids','Nike','Adidas','Levis','Burberry','Gucci','BAM BAM', 'Other'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmire', 'other'
                ]

            ],
            'Baby\'s Clothes' => [
                'Type' => [
                    'Girls',
                    'Boys',
                    'Hats',
                    'Shoes and socks',
                    'Accessories',
                    'Other',
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Benetton','Zara Kids','Noppies','Clasens','Petit Bateau','Nik&Nik','Tommy Hilfiger','Calvin Klein',
                    'Kenzo Kids','Nike','Adidas','Levis','Burberry','Gucci','BAM BAM', 'Other'
                ],
                'Size' => [
                    50,56,62,68,74,80,86,92,98,
                ],
                'Shoe size' => [
                    12,13,14,15,16,17,18,19,20
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'organic cotton', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmire', 'other'
                ]

            ],
            'Little Girls Closet' => [
                'Type' => [
                    'hoodies and sweaters' => [
                        'sweaters', 'vests', 'hoodies', 'zip up sweaters', 'other'
                    ],
                    'Skirts' => [
                        'mini', 'middle', 'maxi'
                    ],
                    'Coats and jackets' => [
                        'coats', 'jackets', 'raincoats', 'blazers', 'other'
                    ],
                    'Dresses' => [
                        'mini', 'middle', 'maxi'
                    ],
                    'Tshirts, tops and blouses' => [
                        'tops', 'tshirts', 'long sleeves', 'polo', 'other'
                    ],
                    'Pants',
                    'Leggings and shorts',
                    'Bags' => [
                        'handbags', 'backpaks', 'other'
                    ],
                    'Shoes' => [
                        'baby', 'boots', 'sneakers', 'sandals', 'ballerinas', 'shoes', 'slippers', 'other'
                    ],
                    'Beauty accessories' => [
                        'jewelry', 'hair accessories', 'hats and caps', 'shawls and gloves', 'belts', 'other'
                    ],
                    'Swimwear' => [
                        'one piece', 'two piece'
                    ],
                    'Sleepwear',
                    'Sports',
                    'Themed costumes' => [
                        'costumes', 'accessories'
                    ],
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Benetton','Zara Kids','Noppies','Clasens','Petit Bateau','Nik&Nik','Tommy Hilfiger','Calvin Klein',
                    'Kenzo Kids','Nike','Adidas','Levis','Burberry','Gucci','BAM BAM', 'Other'
                ],
                'Size' => [
                    '104cm/3-4years', '110cm/4-5years', '116cm/6years', '128cm/8years', '134cm/9years', '140cm/10years',
                    '152cm/11-12years', '164cm/13-14years'
                ],
                'Shoe size' => [
                    20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmire', 'other'
                ]

            ],
            'Little Boys Closet' => [
                'Type' => [
                    'Coats, jackets' => [
                        'coats', 'jackets', 'raincoats', 'blazers', 'other'
                    ],
                    'hoodies and sweaters' => [
                        'sweaters', 'vests', 'hoodies', 'zip up sweaters', 'other'
                    ],
                    'Tshirts, tops and blouses' => [
                        'tshirts', 'long sleeves', 'polo', 'other'
                    ],
                    'Pants',
                    'Shorts',
                    'Suits' => [
                        'blazer', 'shirt', 'pants', 'set'
                    ],
                    'Swimwear',
                    'Sleepwear',
                    'Sports',
                    'Bags and backpacks',
                    'Shoes' => [
                        'formal shoes', 'boots', 'sneakers', 'sandals', 'slippers', 'other'
                    ],
                    'Themed costumes and accessories',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Benetton','Zara Kids','Noppies','Clasens','Petit Bateau','Nik&Nik','Tommy Hilfiger','Calvin Klein',
                    'Kenzo Kids','Nike','Adidas','Levis','Burberry','Gucci','BAM BAM', 'Other stories', 'Other'
                ],
                'Clothing Size' => [
                    '104cm/3-4years', '110cm/4-5years', '116cm/6years', '128cm/8years', '134cm/9years', '140cm/10years',
                    '152cm/11-12years', '164cm/13-14years'
                ],
                'Shoe size' => [
                    20, 21, 22, 23, 24, 25, 26, 27, 28,
                    29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmire', 'other'
                ]

            ],
            'Buggies and Car seats' => [
                'Type' => [
                    'Car Seats' => [
                        'group 0-13kg', 'group9-18kg', 'group9-36kg', 'transport backwards', 'car seat accessories'
                    ],
                    'Buggies',
                    'Baby Carriers',
                    'Twin Cars',
                    'Baby Strollers',
                    'Travel Accessories'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ]
            ],
            'Toys' => [
                'Type' => [
                    'Games' => [
                        'puzzles', 'game consoles and video games', 'board games', 'other'
                    ],
                    'Water fun' => [
                        'bath toys', 'beach toys', 'other'
                    ],
                    'Toys',
                    'Books'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ]
            ]
        ];

        $images[$category->id] = [
            '/mooimarkt/img/p-gallery-img-4.jpg',
            '/mooimarkt/img/p-gallery-img-1.jpg',
            '/mooimarkt/img/p-gallery-img-3.jpg',
            '/mooimarkt/img/p-gallery-img-2.jpg',
        ];

        foreach ($subCategories as $item) {
            $subCategory = \App\SubCategory::where('subCategoryName', $item)->where('categoryId', $category->id)->first();
            if ($subCategory == null) {
                $subCategory = \App\SubCategory::create([
                    'subCategoryName' => $item,
                    'categoryId' => $category->id,
                    'sort' => 0,
                    'shrid' => null,
                    'filtername' => null,
                    'lang_id' => null
                ]);
            }

            if (isset($filters[$item])) {
                foreach ($filters[$item] as $keyFilter => $filter) {
                    switch ($keyFilter) {
                        case 'Type':
                            $template = 'type';
                            break;
                        case 'Brand':
                            $template = 'brand';
                            break;
                        case 'Color':
                            $template = 'color';
                            break;
                        case 'Material':
                            $template = 'material';
                            break;
                        case ('Size'):
                            $template = 'size';
                            break;
                        case ('Shoe size'):
                            $template = 'size';
                            break;
                        default:
                            $template = 'standard';
                            break;
                    }
                    $newFilter = Filter::create([
                        'name' => $keyFilter,
                        'sub_category_id' => $subCategory->id,
                        'parent_id' => null,
                        'template' => $template,
                    ]);

                    foreach ($filter as $keySubFilter => $subFilter) {
                        $newSubFilter = Filter::create([
                            'name' => is_array($subFilter) ? $keySubFilter : $subFilter,
                            'sub_category_id' => null,
                            'parent_id' => $newFilter->id,
                            'template' => 'standard',
                        ]);
                        if(is_array($subFilter)) {
                            foreach ($subFilter as $subSubFilter) {
                                Filter::create([
                                    'name' => $subSubFilter,
                                    'sub_category_id' => null,
                                    'parent_id' => $newSubFilter->id,
                                    'template' => 'standard',
                                ]);
                            }
                        }
                    }
                }
            }

            factory(Ads::class, 10)->create([
                'subCategoryId' => $subCategory->id
            ])->each(function($ads) use ($category, $subCategory, $images) {
                $adsFilters = $subCategory->adsFilters;

                foreach ($adsFilters as $adsFilter) {
                    $ads->filters()->attach($adsFilter->children()->get()->random()->id);
                }

                $shuffleKeys = array_keys($images[$category->id]);
                shuffle($shuffleKeys);
                foreach($shuffleKeys as $key) {
                    $imgList[$key] = $images[$category->id][$key];
                }

                foreach (($imgList ?? []) as $image) {
                    $ads->images()->create([
                        'imagePath' => $image,
                        'cover' => 1
                    ]);
                }
            });
        }

////CATEGORY ART & BOOKS////

       /* $category = \App\Category::where('categoryName', 'ART & BOOKS')->first();
        $subCategories = [
            'Art',
            'Books'
        ];

        $filters = [
            'Art' => [
                'Type' => [
                    'Interior' => [
                        'decoration/statues', 'vases', 'mirrors', 'candle holders', 'other'
                    ],
                    'Tekstile articles' => [
                        'carpets', 'curtains', 'tablecloths', 'blankets', 'other'
                    ]
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ]
            ],
            'Books' => [
                'Type' => [
                    'Literature' => [
                        'biography', 'crime', 'romance', 'poetry', 'novel', 'sciencefriction', 'historical', 'other'
                    ]
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ]
            ]
        ];*/

        $category = \App\Category::where('categoryName', 'Home')->first();
        $subCategories = [
            'Interior',
            'Textiles',
            'Books'
        ];

        $filters = [
            'Interior' => [
                'Type' => [
                    'decoration/statues', 'vases', 'mirrors', 'candle holders', 'other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ]
            ],
            'Textiles' => [
                'Type' => [
                    'carpets', 'curtains', 'tablecloths', 'blankets', 'other'
                ],
            ],
            'Books' => [
                'Type' => [
                    'Literature' => [
                        'biography', 'crime', 'romance', 'poetry', 'novel', 'sciencefriction', 'historical', 'other'
                    ],
                    'Encyclopedias',
                    'Travelling',
                    'Cooking',
                    'Interior and fashion',
                    'Study',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ]
            ]
        ];

        $images[$category->id] = [
            '/mooimarkt/img/p-art&books-1.jpg',
            '/mooimarkt/img/p-art&books-2.jpg',
            '/mooimarkt/img/p-art&books-3.jpg'
        ];

        foreach ($subCategories as $item) {
            $subCategory = \App\SubCategory::where('subCategoryName', $item)->where('categoryId', $category->id)->first();
            if ($subCategory == null) {
                $subCategory = \App\SubCategory::create([
                    'subCategoryName' => $item,
                    'categoryId' => $category->id,
                    'sort' => 0,
                    'shrid' => null,
                    'filtername' => null,
                    'lang_id' => null
                ]);
            }

            if (isset($filters[$item])) {
                foreach ($filters[$item] as $keyFilter => $filter) {
                    switch ($keyFilter) {
                        case 'Type':
                            $template = 'type';
                            break;
                        case 'Brand':
                            $template = 'brand';
                            break;
                        case 'Color':
                            $template = 'color';
                            break;
                        case 'Material':
                            $template = 'material';
                            break;
                        case ('Size'):
                            $template = 'size';
                            break;
                        default:
                            $template = 'standard';
                            break;
                    }
                    $newFilter = Filter::create([
                        'name' => $keyFilter,
                        'sub_category_id' => $subCategory->id,
                        'parent_id' => null,
                        'template' => $template,
                    ]);

                    foreach ($filter as $keySubFilter => $subFilter) {
                        $newSubFilter = Filter::create([
                            'name' => is_array($subFilter) ? $keySubFilter : $subFilter,
                            'sub_category_id' => null,
                            'parent_id' => $newFilter->id,
                            'template' => 'standard',
                        ]);
                        if(is_array($subFilter)) {
                            foreach ($subFilter as $subSubFilter) {
                                Filter::create([
                                    'name' => $subSubFilter,
                                    'sub_category_id' => null,
                                    'parent_id' => $newSubFilter->id,
                                    'template' => 'standard',
                                ]);
                            }
                        }
                    }
                }
            }

            factory(Ads::class, 10)->create([
                'subCategoryId' => $subCategory->id
            ])->each(function($ads) use ($category, $subCategory, $images) {
                $adsFilters = $subCategory->adsFilters;

                foreach ($adsFilters as $adsFilter) {
                    $ads->filters()->attach($adsFilter->children()->get()->random()->id);
                }

                $shuffleKeys = array_keys($images[$category->id]);
                shuffle($shuffleKeys);
                foreach($shuffleKeys as $key) {
                    $imgList[$key] = $images[$category->id][$key];
                }

                foreach (($imgList ?? []) as $image) {
                    $ads->images()->create([
                        'imagePath' => $image,
                        'cover' => 1
                    ]);
                }
            });
        }


////CATEGORY Ladies////

        $category = \App\Category::where('categoryName', 'Woman')->first();
        $subCategories = [
            'Clothing',
            'Bags',
            'Shoes',
            'Accessories',
            'Ladies Beauty'
        ];

        $filters = [
            'Clothing' => [
                'Type' => [
                    'Coats, Vests' => [
                        'long coats', 'short coats', 'vests'
                    ],
                    'Jacets' => [
                        'leather jackets', 'denim jackets', 'lightweight jackets', 'other'
                    ],
                    'Blazers/costume' => [
                        'blazers', 'costume set'
                    ],
                    'Hoodies/jumpers' => [
                        'hoodies', 'sweaters', 'kimonos',  'cardigans'
                    ],
                    'Tops and T-shirts' => [
                        'Tshirts', 'short tops', 'turtlenecks', 'tank tops', 'bodies', 'tunics'
                    ],
                    'Blouses' => [
                        'long sleeve', 'short sleeve', 'formal'
                    ],
                    'Dresses' => [
                        'mini', 'formal', 'casual', 'maxi', 'strapless', 'other'
                    ],
                    'Pants' => [
                        'cropped pants', 'straight pants', 'wide pants', 'leggings', 'jeans', 'shorts', 'other type'
                    ],
                    'Skirts' => [
                        'mini', 'midi', 'maxi', 'other'
                    ],
                    'Lingerie and night' => [
                        'bras', 'panties', 'lingerie sets', 'corsets', 'shape underwear', 'nightwear', 'other'
                    ],
                    'Bikinis' => [
                        'one piece', 'two peace '
                    ],
                    'Sports wear' => [
                        'outwear tracksuits tops', 't-shirts', 'Pants and shorts', 'Dresses and skirts', 'Sports bras', 'Hoodies and sweatshirts', 'Accessories'
                    ],
                    'Maternity clothes' => [
                        'maternity tops', 'maternity dresses', 'maternity pants', 'maternity hoodies', 'maternity skirts', 'maternity outdoor jackets', 'maternity underwear'
                    ],
                    'Costumes and special outfits',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Nike', 'Adidas', 'Vans', 'Zara', 'Topshop', 'Calvin Klein', 'Tommy Hilfiger', 'Ralph Lauren', 'Guess', 'Michael Kors',
                    'Scotch and Soda', 'Lacoste', 'Victoria Secret', 'Gucci', 'Louis Vutton', 'Ted Baker', 'Hugo Boss', 'Kenzo', 'BALR', 'Other stories', 'Other'
                ],
                'Size' => [
                    'XS/34/6', 'S/36/8', 'M/38/10', 'L/40/12', 'XL/42/14', 'XXL/44/16', 'XXXL/46/18', 'One size',
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmere', 'other'
                ]
            ],
            'Bags' => [
                'Type' => [
                    'Handbags',
                    'Purses',
                    'Clutches',
                    'Shoulder bags and Cross body',
                    'Backpacks',
                    'Luggage, suitcases',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Nike', 'Adidas', 'Vans', 'Zara', 'Topshop', 'Calvin Klein', 'Tommy Hilfiger', 'Ralph Lauren', 'Guess', 'Michael Kors',
                    'Scotch and Soda', 'Lacoste', 'Victoria Secret', 'Gucci', 'Louis Vutton', 'Ted Baker', 'Hugo Boss', 'Kenzo', 'BALR', 'Other stories', 'Other'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmere', 'other'
                ]
            ],
            'Shoes' => [
                'Type' => [
                    'High heels',
                    'Ballerinas',
                    'Low shoes',
                    'Long boots',
                    'Rain boots',
                    'Ankle boots',
                    'Sneakers',
                    'Sandals',
                    'Platforms',
                    'Flip-flops and slippers',
                    'Sport shoes',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Nike', 'Adidas', 'Vans', 'Zara', 'Topshop', 'Calvin Klein', 'Tommy Hilfiger', 'Ralph Lauren', 'Guess', 'Michael Kors',
                    'Scotch and Soda', 'Lacoste', 'Victoria Secret', 'Gucci', 'Louis Vutton', 'Ted Baker', 'Hugo Boss', 'Kenzo', 'BALR', 'Other stories', 'Other'
                ],
                'Size' => [
                    35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmire', 'other'
                ]

            ],
            'Accessories' => [
                'Type' => [
                    'Watches',
                    'Wallets',
                    'Sunglasses',
                    'Belts',
                    'Jewellery' => [
                        'necklaces', 'earrings', 'rings', 'bracelets', 'brooches', 'other jewelry'
                    ],
                    'Hair accessories',
                    'Hats' => [
                        'caps', 'lady hats', 'winter hats', 'berets', 'beach hats'
                    ],
                    'Scarves, shawls and gloves',
                    'Tights and socks',
                    'Phone cases ',
                    'Other accessories'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Nike', 'Adidas', 'Vans', 'Zara', 'Topshop', 'Calvin Klein', 'Tommy Hilfiger', 'Ralph Lauren', 'Guess', 'Michael Kors',
                    'Scotch and Soda', 'Lacoste', 'Victoria Secret', 'Gucci', 'Louis Vutton', 'Ted Baker', 'Hugo Boss', 'Kenzo', 'BALR', 'Other stories', 'Other'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ]
            ],
            'Ladies Beauty' => [
                'Type' => [
                    'Make up',
                    'Beauty tools' => [
                        'hair styling tools', 'makeup tools', 'body tools'
                    ],
                    'Face, body and hair care',
                    'Parfume',
                    'Extensions, fake hair',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Nike', 'Adidas', 'Vans', 'Zara', 'Topshop', 'Calvin Klein', 'Tommy Hilfiger', 'Ralph Lauren', 'Guess', 'Michael Kors',
                    'Scotch and Soda', 'Lacoste', 'Victoria Secret', 'Gucci', 'Louis Vutton', 'Ted Baker', 'Hugo Boss', 'Kenzo', 'BALR', 'Other stories', 'Other'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ]
            ]
        ];

        $images[$category->id] = [
            '/mooimarkt/img/p-womens-1.jpg',
            '/mooimarkt/img/p-womens-2.jpg',
            '/mooimarkt/img/p-womens-3.jpg',
            '/mooimarkt/img/p-womens-4.jpg'
        ];

        foreach ($subCategories as $item) {
            $subCategory = \App\SubCategory::where('subCategoryName', $item)->where('categoryId', $category->id)->first();
            if ($subCategory == null) {
                $subCategory = \App\SubCategory::create([
                    'subCategoryName' => $item,
                    'categoryId' => $category->id,
                    'sort' => 0,
                    'shrid' => null,
                    'filtername' => null,
                    'lang_id' => null
                ]);
            }

            if (isset($filters[$item])) {
                foreach ($filters[$item] as $keyFilter => $filter) {
                    switch ($keyFilter) {
                        case 'Type':
                            $template = 'type';
                            break;
                        case 'Brand':
                            $template = 'brand';
                            break;
                        case 'Color':
                            $template = 'color';
                            break;
                        case 'Material':
                            $template = 'material';
                            break;
                        case ('Size'):
                            $template = 'size';
                            break;
                        default:
                            $template = 'standard';
                            break;
                    }
                    $newFilter = Filter::create([
                        'name' => $keyFilter,
                        'sub_category_id' => $subCategory->id,
                        'parent_id' => null,
                        'template' => $template,
                    ]);

                    foreach ($filter as $keySubFilter => $subFilter) {
                        $newSubFilter = Filter::create([
                            'name' => is_array($subFilter) ? $keySubFilter : $subFilter,
                            'sub_category_id' => null,
                            'parent_id' => $newFilter->id,
                            'template' => 'standard',
                        ]);
                        if(is_array($subFilter)) {
                            foreach ($subFilter as $subSubFilter) {
                                Filter::create([
                                    'name' => $subSubFilter,
                                    'sub_category_id' => null,
                                    'parent_id' => $newSubFilter->id,
                                    'template' => 'standard',
                                ]);
                            }
                        }
                    }
                }
            }

            factory(Ads::class, 10)->create([
                'subCategoryId' => $subCategory->id
            ])->each(function($ads) use ($category, $subCategory, $images) {
                $adsFilters = $subCategory->adsFilters;

                foreach ($adsFilters as $adsFilter) {
                    $ads->filters()->attach($adsFilter->children()->get()->random()->id);
                }

                $shuffleKeys = array_keys($images[$category->id]);
                shuffle($shuffleKeys);
                foreach($shuffleKeys as $key) {
                    $imgList[$key] = $images[$category->id][$key];
                }

                foreach (($imgList ?? []) as $image) {
                    $ads->images()->create([
                        'imagePath' => $image,
                        'cover' => 1
                    ]);
                }
            });
        }

////CATEGORY Men////

        $category = \App\Category::where('categoryName', 'Men')->first();
        $subCategories = [
            'Clothing',
            'Shoes',
            'Accessories'
        ];

        $filters = [
            'Clothing' => [
                'Type' => [
                    'Coats and jacket' => [
                        'parkas', 'coats', 'rain coats', 'leather jackets', 'lightwear jackets', 'denim jackets', 'bomer jackets', 'trench coats', 'other'
                    ],
                    'Suits and blazer' => [
                        'suit set', 'blazers', 'suit pants', 'other'
                    ],
                    'Shirts',
                    'Pants and shorts',
                    'Jumpers/ jacket' => [
                        'jumpers and hoodies', 'turtleneck sweaters', 'V neck sweaters', 'cardigans', 'vests', 'jackets', 'other'
                    ],
                    'T-shirts' => [
                        'Long sleeve t-shirts', 'polo'
                    ],
                    'Sports wear' => [
                        'Outwear', 'Tracksuits', 'Pants and shorts', 'pullovers and sweaters',  't-shirts', 'Accessories', 'other'
                    ],
                    'Underwear and swimwear',
                    'Costumes and special outfits',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Nike', 'Adidas', 'Vans', 'Zara', 'Topshop', 'Calvin Klein', 'Tommy Hilfiger', 'Ralph Lauren', 'Guess', 'Michael Kors',
                    'Scotch and Soda', 'Lacoste', 'Gucci', 'Louis Vutton', 'Ted Baker', 'Hugo Boss', 'Kenzo', 'BALR', 'Other stories', 'Other'
                ],
                'Size' => [
                    'XS/34/6', 'S/36/8', 'M/38/10', 'L/40/12', 'XL/42/14', 'XXL/4416', 'XXXL/46/18', 'One size',
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmere', 'other'
                ]
            ],
            'Shoes' => [
                'Type' => [
                    'Boots' => [
                        'ankle boots', 'cowboy boots', 'knee high boots'
                    ],
                    'Formal shoes',
                    'Free time shoes/ sneakers',
                    'Sandals',
                    'Flip flops and slippers',
                    'Sport shoes',
                    'Other'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Nike', 'Adidas', 'Vans', 'Zara', 'Topshop', 'Calvin Klein', 'Tommy Hilfiger', 'Ralph Lauren', 'Guess', 'Michael Kors',
                    'Scotch and Soda', 'Lacoste', 'Gucci', 'Louis Vutton', 'Ted Baker', 'Hugo Boss', 'Kenzo', 'BALR', 'Other stories', 'Other'
                ],
                'Size' => [
                    36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'velvet', 'suede', 'fur', 'cashmire', 'other'
                ]

            ],
            'Accessories' => [
                'Type' => [
                    'Watches and jewellery' => [
                        'watches', 'necklaces', 'rings', 'bracelets', 'other'
                    ],
                    'Bags and wallets' => [
                        'wallets-luggage', 'backpacks', 'bags', 'bum bags', 'other'
                    ],
                    'Hats, scarves and gloves' => [
                        'winter hats', 'caps', 'hats', 'other'
                    ]
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ],
                'Brand' => [
                    'Nike', 'Adidas', 'Vans', 'Zara', 'Topshop', 'Calvin Klein', 'Tommy Hilfiger', 'Ralph Lauren', 'Guess', 'Michael Kors',
                    'Scotch and Soda', 'Lacoste', 'Gucci', 'Louis Vutton', 'Ted Baker', 'Hugo Boss', 'Kenzo', 'BALR', 'Other stories', 'Other'
                ],
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Material' => [
                    'jeans', 'leather', 'silk', 'cotton', 'linnen', 'velvet', 'suede', 'fur', 'cashmire', 'other'
                ]
            ]
        ];

        $images[$category->id] = [
            '/mooimarkt/img/p-mens-1.jpg',
            '/mooimarkt/img/p-mens-2.jpg',
            '/mooimarkt/img/p-mens-3.jpg',
            '/mooimarkt/img/p-mens-4.jpg',
            '/mooimarkt/img/p-mens-5.jpg'
        ];

        foreach ($subCategories as $item) {
            $subCategory = \App\SubCategory::where('subCategoryName', $item)->where('categoryId', $category->id)->first();
            if ($subCategory == null) {
                $subCategory = \App\SubCategory::create([
                    'subCategoryName' => $item,
                    'categoryId' => $category->id,
                    'sort' => 0,
                    'shrid' => null,
                    'filtername' => null,
                    'lang_id' => null
                ]);
            }

            if (isset($filters[$item])) {
                foreach ($filters[$item] as $keyFilter => $filter) {
                    switch ($keyFilter) {
                        case 'Type':
                            $template = 'type';
                            break;
                        case 'Brand':
                            $template = 'brand';
                            break;
                        case 'Color':
                            $template = 'color';
                            break;
                        case 'Material':
                            $template = 'material';
                            break;
                        case ('Size'):
                            $template = 'size';
                            break;
                        default:
                            $template = 'standard';
                            break;
                    }
                    $newFilter = Filter::create([
                        'name' => $keyFilter,
                        'sub_category_id' => $subCategory->id,
                        'parent_id' => null,
                        'template' => $template,
                    ]);

                    foreach ($filter as $keySubFilter => $subFilter) {
                        $newSubFilter = Filter::create([
                            'name' => is_array($subFilter) ? $keySubFilter : $subFilter,
                            'sub_category_id' => null,
                            'parent_id' => $newFilter->id,
                            'template' => 'standard',
                        ]);
                        if(is_array($subFilter)) {
                            foreach ($subFilter as $subSubFilter) {
                                Filter::create([
                                    'name' => $subSubFilter,
                                    'sub_category_id' => null,
                                    'parent_id' => $newSubFilter->id,
                                    'template' => 'standard',
                                ]);
                            }
                        }
                    }
                }
            }

            factory(Ads::class, 10)->create([
                'subCategoryId' => $subCategory->id
            ])->each(function($ads) use ($category, $subCategory, $images) {
                $adsFilters = $subCategory->adsFilters;

                foreach ($adsFilters as $adsFilter) {
                    $ads->filters()->attach($adsFilter->children()->get()->random()->id);
                }

                $shuffleKeys = array_keys($images[$category->id]);
                shuffle($shuffleKeys);
                foreach($shuffleKeys as $key) {
                    $imgList[$key] = $images[$category->id][$key];
                }

                foreach (($imgList ?? []) as $image) {
                    $ads->images()->create([
                        'imagePath' => $image,
                        'cover' => 1
                    ]);
                }
            });
        }


////Bikes////

        $category = \App\Category::where('categoryName', 'Bikes')->first();
        $subCategories = [
            'Woman',
            'Men',
            'Kids',
        ];

        $filters = [
            'Woman' => [
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ]
            ],
            'Men' => [
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ]
            ],
            'Kids' => [
                'Color' => [
                    'white', 'beige', 'light blue', 'yellow', 'rose', 'pink', 'purple', 'turquoise', 'red', 'green', 'haki',
                    'mustard', 'blue', 'green', 'orange', 'silver', 'gold', 'brown', 'grey', 'black', 'colorful'
                ],
                'Condition' => [
                    'Brand new', 'Used, Great Condition', 'Possible imperfections'
                ]
            ],
        ];

        $images[$category->id] = [
            '/mooimarkt/img/p-art&books-1.jpg',
            '/mooimarkt/img/p-art&books-2.jpg',
            '/mooimarkt/img/p-art&books-3.jpg'
        ];

        foreach ($subCategories as $item) {
            $subCategory = \App\SubCategory::where('subCategoryName', $item)->where('categoryId', $category->id)->first();
            if ($subCategory == null) {
                $subCategory = \App\SubCategory::create([
                    'subCategoryName' => $item,
                    'categoryId' => $category->id,
                    'sort' => 0,
                    'shrid' => null,
                    'filtername' => null,
                    'lang_id' => null
                ]);
            }

            if (isset($filters[$item])) {
                foreach ($filters[$item] as $keyFilter => $filter) {
                    switch ($keyFilter) {
                        case 'Type':
                            $template = 'type';
                            break;
                        case 'Brand':
                            $template = 'brand';
                            break;
                        case 'Color':
                            $template = 'color';
                            break;
                        case 'Material':
                            $template = 'material';
                            break;
                        default:
                            $template = 'standard';
                            break;
                    }
                    $newFilter = Filter::create([
                        'name' => $keyFilter,
                        'sub_category_id' => $subCategory->id,
                        'parent_id' => null,
                        'template' => $template,
                    ]);

                    foreach ($filter as $keySubFilter => $subFilter) {
                        $newSubFilter = Filter::create([
                            'name' => is_array($subFilter) ? $keySubFilter : $subFilter,
                            'sub_category_id' => null,
                            'parent_id' => $newFilter->id,
                            'template' => 'standard',
                        ]);
                        if(is_array($subFilter)) {
                            foreach ($subFilter as $subSubFilter) {
                                Filter::create([
                                    'name' => $subSubFilter,
                                    'sub_category_id' => null,
                                    'parent_id' => $newSubFilter->id,
                                    'template' => 'standard',
                                ]);
                            }
                        }
                    }
                }
            }

            factory(Ads::class, 10)->create([
                'subCategoryId' => $subCategory->id
            ])->each(function($ads) use ($category, $subCategory, $images) {
                $adsFilters = $subCategory->adsFilters;

                foreach ($adsFilters as $adsFilter) {
                    $ads->filters()->attach($adsFilter->children()->get()->random()->id);
                }

                $shuffleKeys = array_keys($images[$category->id]);
                shuffle($shuffleKeys);
                foreach($shuffleKeys as $key) {
                    $imgList[$key] = $images[$category->id][$key];
                }

                foreach (($imgList ?? []) as $image) {
                    $ads->images()->create([
                        'imagePath' => $image,
                        'cover' => 1
                    ]);
                }
            });
        }

    }
}
