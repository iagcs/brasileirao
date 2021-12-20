<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Matches;
use App\Models\Team;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MatchesControllerFTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testMatchWasCreatedSuccess()
    {
        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();

        
        $response = $this->post('/matches',[
            'time_visitante_id' => json_decode($team1, true)['id'],
            'time_casa_id' => json_decode($team2, true)['id'],
            'gols_visitante' => 1,
            'gols_em_casa' => 0,
        ]);

        $this->assertEquals(201, $response->status());

        $this->assertDatabaseHas('partidas', [
            'time_visitante_id' => json_decode($team1, true)['id'],
            'time_casa_id' => json_decode($team2, true)['id'],
        ]);

    }

    public function testMatchWithSameTeamError()
    {
        $team1 = Team::factory()->create();

        $this->withoutExceptionHandling();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("O mesmo time não pode se confrontar.");

        $response = $this->post('/matches',[
            'time_visitante_id' => json_decode($team1, true)['id'],
            'time_casa_id' => json_decode($team1, true)['id'],
            'gols_visitante' => 1,
            'gols_em_casa' => 0,
        ]);

        $this->assertEquals(500, $response->status());

    }

    public function testMatchAlreadyExistsError()
    {
        Matches::factory()->create([
            'time_visitante_id' => 2,
            'time_casa_id' => 12
        ]);

        $this->withoutExceptionHandling();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Esse turno já aconteceu. Tem mais uma partida entre esses times no segundo turno. Troque o time visitante pelo time de casa.");

        $response = $this->post('/matches',[
            'time_visitante_id' => 2,
            'time_casa_id' => 12,
            'gols_visitante' => 1,
            'gols_em_casa' => 0,
        ]);

        $this->assertEquals(500, $response->status());

    }

    public function testdMatchesOccuredError()
    {
        Matches::factory()->create([
            'time_visitante_id' => 2,
            'time_casa_id' => 12
        ]);

        Matches::factory()->create([
            'time_visitante_id' => 12,
            'time_casa_id' => 2
        ]);

        $this->withoutExceptionHandling();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Os dois turnos desses times ja aconteceram.");

        $response = $this->post('/matches',[
            'time_visitante_id' => 12,
            'time_casa_id' => 2,
            'gols_visitante' => 1,
            'gols_em_casa' => 0,
        ]);

        $this->assertEquals(500, $response->status());

    }

    public function testFinshChampionSuccess()
    {
        Matches::factory()->count(38*20)->create();

        $this->withoutExceptionHandling();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Todas rodadas ja aconteceram. O campeonato acabou!");

        $response = $this->post('/matches',[
            'time_visitante_id' => 12,
            'time_casa_id' => 2,
            'gols_visitante' => 1,
            'gols_em_casa' => 0,
        ]);

        $this->assertEquals(500, $response->status());

    }

    public function testTeamsExistsFalse()
    {
        $team = Team::factory()->create();

        $this->withoutExceptionHandling();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Esses times não existem");

        $response = $this->post('/matches',[
            'time_visitante_id' => 99,
            'time_casa_id' => $team['id'],
            'gols_visitante' => 1,
            'gols_em_casa' => 0,
        ]);

        $this->assertEquals(500, $response->status());

    }

    

}
