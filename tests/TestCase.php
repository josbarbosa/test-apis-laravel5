<?php

namespace Tests;

use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param User|null $user
     * @return $this
     */
    protected function signIn(User $user = null): self
    {
        $user = $user ?: create(User::class);
        $this->actingAs($user);

        return $this;
    }

    /**
     * @param Tag $tag
     * @return array
     */
    protected function tagFragment(Tag $tag): array
    {
        return [
            'id'   => $tag->id,
            'name' => $tag->name,
        ];
    }
}
