<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // گرفتن تمام کاربران موجود
        $users = User::all();

        // if ($users->isEmpty()) {
        //     $this->command->info('هیچ کاربری وجود ندارد. ابتدا کاربران را ایجاد کنید.');
        //     return;
        // }

        // ایجاد 30 پست تصادفی
        for ($i = 1; $i <= 30; $i++) {
            $user = $users->isNotEmpty() ? $users->random() : null; // کاربر تصادفی

            $status = match (true) {
                $user?->isAuthor() => $faker->randomElement([
                    PostStatus::Draft,
                    PostStatus::Review,
                ]),
                $user?->isEditor() => $faker->randomElement([
                    PostStatus::Review,
                    PostStatus::Published,
                ]),
                default => PostStatus::Draft,
            };

            Post::create([
                'title' => $faker->sentence(6),
                'content' => $faker->paragraph(4),
                'user_id' => $user ? $user->id : null, // اختصاص به نویسنده تصادفی
                'published' => $status,
            ]);
        }

    }
}
