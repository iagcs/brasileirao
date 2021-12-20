<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Matches;
use App\Models\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TeamControllerFTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTeamWasListedSuccess()
    {
        $team = Team::factory()->create();

        $response = $this->get('/teams');

        $data = json_decode($response->content(), true)['teams'];

        $this->assertEquals(200, $response->status());
        $this->assertEquals(json_decode($team, true), $data[20]);

    }

    public function testMatchesResults(){

        $response = $this->get('/teams/results',[]);

        $this->assertEquals(200, $response->status());

    }

}
