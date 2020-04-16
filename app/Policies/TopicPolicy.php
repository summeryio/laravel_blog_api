<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;

class TopicPolicy
{
    public function update(User $user, Topic $topic) {
        return $user->isAuthOf($topic);
    }

    public function destroy(User $user, Topic $topic) {
        return $user->isAuthOf($topic);
    }
}
