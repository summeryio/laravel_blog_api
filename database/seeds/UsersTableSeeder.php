<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(Faker\Generator::class);
        $avatars = [
            'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];

        $users = factory(User::class)
            ->times(5)
            ->make()
            ->each(function ($user, $index) use ($faker, $avatars) {
                $phoneNum = '1828963' . str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
                $user->phone = $phoneNum;
                $user->avatar = $faker->randomElement($avatars);
            });
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($user_array);

        $user = User::find(1);
        $user->name = 'summer';
        $user->phone = '18289639280';
        $user->avatar = 'http://blogapi.test/uploads/images/avatars202004/15/1_1586917273_Z3KY8NfZGG.jpg';
        $user->introduction = '夏天的介绍信息';
        $user->save();
    }
}
