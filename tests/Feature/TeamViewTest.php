<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamViewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function team_list_should_contain_articles_count()
    {
        $teams = factory('Fedn\Models\Team', 5)->create();

        $teams->each(function($team){
            factory('Fedn\Models\Article', random_int(3, 10))->create(['team_id' => $team->id]);
        });

        $this->get('/api/v1/teams/list?page=1&size=10')
            ->assertSee('articles_count');
    }
}
