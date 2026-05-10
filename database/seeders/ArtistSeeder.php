<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;

class ArtistSeeder extends Seeder
{
    public function run(): void
    {
        $artists = [
            [
                'name' => 'Vincent van Gogh',
                'year_born' => 1853,
                'year_death' => 1890,
                'bio' => 'A Dutch Post-Impressionist painter who is among the most famous and influential figures in the history of Western art. In just over a decade, he created about 2,100 artworks, including around 860 oil paintings, most of them in the last two years of his life. His work marked a dramatic shift toward emotional expression and individuality, developing a highly distinctive style characterized by bold, vibrant colors and impulsive, expressive brushwork that contributed to the foundations of modern art. Despite his profound posthumous success, he struggled with severe mental illness and poverty throughout his life, famously selling only one painting before his untimely death.',
                'img_path' => 'images/home/Van_Gogh.jpg'
            ],
            [
                'name' => 'Pablo Picasso',
                'year_born' => 1881,
                'year_death' => 1973,
                'bio' => 'A Spanish painter, sculptor, printmaker, ceramicist, and stage designer who spent most of his adult life in France. As one of the most prolific and influential artists of the 20th century, he is best known for co-founding the Cubist movement, the invention of constructed sculpture, and the co-invention of collage. His artistic career is often divided into distinct periods, including the Blue Period, the Rose Period, and the development of Surrealism. His massive output includes masterpieces like "Guernica," a powerful political statement against the horrors of war, and "Les Demoiselles d\'Avignon," which fundamentally changed the direction of European painting by breaking traditional perspectives.',
                'img_path' => 'images/home/Picasso.jpg',
            ],
            [
                'name' => 'Raphael',
                'year_born' => 1483,
                'year_death' => 1520,
                'bio' => 'An Italian painter and architect of the High Renaissance, celebrated for the perfection and grace of his compositions. Together with Michelangelo and Leonardo da Vinci, he forms the traditional trinity of great masters of that period. His work is admired for its visual achievement of the Neoplatonic ideal of human grandeur and its clarity of form and ease of composition. Despite his death at the young age of 37, he left a vast body of work, including the famous frescoes in the Vatican Stanze. His masterpiece, "The School of Athens," remains a definitive symbol of the intellectual spirit of the Renaissance, capturing the harmony between classical philosophy and artistic mastery.',
                'img_path' => 'images/home/Raphael.jpg',
            ],
        ];

        foreach ($artists as $artist) {
            Artist::updateOrCreate(
                ['name' => $artist['name']],
                [
                    'year_born' => $artist['year_born'],
                    'year_death' => $artist['year_death'],
                    'bio' => $artist['bio'],
                    'img_path' => $artist['img_path']
                ]
            );
        }
    }
}
