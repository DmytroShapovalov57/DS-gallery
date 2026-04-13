<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Artwork;
use Illuminate\Database\Seeder;

class ArtworkSeeder extends Seeder
{
    public function run(): void
    {
        $vangogh = Artist::firstOrCreate([
            'name' => 'Vincent van Gogh'
        ]);

        $picasso = Artist::firstOrCreate([
            'name' => 'Pablo Picasso'
        ]);

        $raphael = Artist::firstOrCreate([
            'name' => 'Raphael'
        ]);

        $artworks = [
            [
                'title' => 'Bridges Across the Seine at Asnières',
                'artist_id' => $vangogh->artist_id,
                'genre' => 'Impressionism',
                'year' => 1887,
                'price' => 879,
                'image' => 'images/art/van_gogh/Bridges_across_the_Seine_at_Asnieres.jpg',
                'description' => 'A calm riverside scene depicting bridges and reflections in the Seine, painted during van Gogh\'s Parisian period.',
            ],
            [
                'title' => 'Café Terrace at Night',
                'artist_id' => $vangogh->artist_id,
                'genre' => 'Impressionism',
                'year' => 1888,
                'price' => 950,
                'image' => 'images/art/van_gogh/Cafe_Terrace_at_Night.jpg',
                'description' => 'A nocturnal street scene of a café in Arles, France — one of the first paintings in which van Gogh used a starry sky as a backdrop.',
            ],
            [
                'title' => 'Fishing in the Spring',
                'artist_id' => $vangogh->artist_id,
                'genre' => 'Impressionism',
                'year' => 1887,
                'price' => 880,
                'image' => 'images/art/van_gogh/Fishing_in_the_Spring.jpg',
                'description' => 'A serene view of the Pont de Clichy in Paris, painted with short, vibrant brushstrokes characteristic of van Gogh\'s Parisian phase.',
            ],
            [
                'title' => 'Fritillaries in a Copper Vase',
                'artist_id' => $vangogh->artist_id,
                'genre' => 'Impressionism',
                'year' => 1887,
                'price' => 999,
                'image' => 'images/art/van_gogh/Fritillaries_in_a_Copper_Vase.jpg',
                'description' => 'A striking floral still life showing Van Gogh\'s mastery of colour contrast and rich impasto technique.',
            ],
            [
                'title' => 'Interior of a Restaurant',
                'artist_id' => $vangogh->artist_id,
                'genre' => 'Impressionism',
                'year' => 1887,
                'price' => 870,
                'image' => 'images/art/van_gogh/Interior_of_a_Restaurant.jpg',
                'description' => 'A detailed interior scene painted in Paris, showing van Gogh\'s interest in the social spaces of everyday life.',
            ],
            [
                'title' => 'Irises',
                'artist_id' => $vangogh->artist_id,
                'genre' => 'Impressionism',
                'year' => 1889,
                'price' => 990,
                'image' => 'images/art/van_gogh/Irises.jpg',
                'description' => 'Painted in the garden of the Saint-Paul-de-Mausole asylum, Irises is one of van Gogh\'s most celebrated and vivid floral works.',
            ],
            [
                'title' => 'Landscape with House and Ploughman',
                'artist_id' => $vangogh->artist_id,
                'genre' => 'Impressionism',
                'year' => 1889,
                'price' => 1000,
                'image' => 'images/art/van_gogh/Landscape_with_House_and_Ploughman.jpg',
                'description' => 'A sweeping rural landscape that reflects van Gogh\'s deep connection to nature and agricultural life.',
            ],
            [
                'title' => 'Red Vineyards at Arles',
                'artist_id' => $vangogh->artist_id,
                'genre' => 'Impressionism',
                'year' => 1888,
                'price' => 950,
                'image' => 'images/art/van_gogh/Red_Vineyards_at_Arles.jpg',
                'description' => 'Widely considered the only painting van Gogh sold during his lifetime, depicting workers harvesting grapes at sunset.',
            ],
            [
                'title' => 'Portrait of a Lady with a Unicorn',
                'artist_id' => $raphael->artist_id,
                'genre' => 'Renaissance',
                'year' => 1506,
                'price' => 1400,
                'image' => 'images/art/raphael/portrait-of-a-lady-with-a-unicorn-1506.jpg',
                'description' => 'A refined Renaissance portrait symbolizing purity and elegance through the presence of the unicorn.',
            ],
            [
                'title' => 'Portrait of the Young Pietro Bembo',
                'artist_id' => $raphael->artist_id,
                'genre' => 'Renaissance',
                'year' => 1504,
                'price' => 1350,
                'image' => 'images/art/raphael/portrait-of-the-young-pietro-bembo-1504.jpg',
                'description' => 'A delicate early portrait capturing the intellectual presence of Pietro Bembo during his youth.',
            ],
            [
                'title' => 'St George and the Dragon',
                'artist_id' => $raphael->artist_id,
                'genre' => 'Renaissance',
                'year' => 1505,
                'price' => 1450,
                'image' => 'images/art/raphael/st-george-and-the-dragon.jpg',
                'description' => 'A dynamic composition depicting Saint George defeating the dragon, symbolizing the triumph of good over evil.',
            ],
            [
                'title' => 'Crying Woman',
                'artist_id' => $picasso->artist_id,
                'genre' => 'Cubism',
                'year' => 1937,
                'price' => 1200,
                'image' => 'images/art/picasso/crying-woman-1937-1.jpg',
                'description' => 'A Cubist portrait expressing intense emotional suffering through fragmented form and color.',
            ],
            [
                'title' => 'Interior with Easel',
                'artist_id' => $picasso->artist_id,
                'genre' => 'Cubism',
                'year' => 1926,
                'price' => 1100,
                'image' => 'images/art/picasso/interior-with-easel-1926.jpg',
                'description' => 'A complex interior scene exploring spatial structure and artistic process in Cubist style.',
            ],
            [
                'title' => 'Woman with a Shirt Sitting in a Chair',
                'artist_id' => $picasso->artist_id,
                'genre' => 'Cubism',
                'year' => 1913,
                'price' => 1150,
                'image' => 'images/art/picasso/woman-with-a-shirt-sitting-in-a-chair-1913.jpg',
                'description' => 'An early Cubist portrait emphasizing geometric fragmentation and abstracted human form.',
            ],
        ];

        foreach ($artworks as $artwork) {
            Artwork::create($artwork);
        }
    }
}
