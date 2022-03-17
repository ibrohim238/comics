<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Manga;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class MangaChapterSeeder extends Seeder
{
    /**
     * @throws FileCannotBeAdded
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function run()
    {
        $mangas = Manga::factory()
            ->count(10)
            ->create();

        $faker = Factory::create();

        foreach ($mangas as $manga) {
            /* @var Manga $manga*/
            $imageUrl = $faker->imageUrl(640,480, null, false);
            $manga->addMediaFromUrl($imageUrl)->toMediaCollection();
        }

        foreach ($mangas as $manga) {

            $chapters = Chapter::factory()->count(5)->create();
            $manga->chapters()->saveMany($chapters);
            foreach ($chapters as $chapter) {
                $imagUrl = $faker->imageUrl(640,480, null, false);
                $chapter->addMediaFromUrl($imagUrl)->toMediaCollection();
            }
        }
    }
}
