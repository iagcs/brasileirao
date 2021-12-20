<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class TeamController extends Controller
{

    protected $team;

    function __construct(Team $team) 
    {
        $this->team = $team;
    }

    public function index()
    {
        $teams = $this->team->all();

        return response()->json([
            'teams' => $teams
        ]);
    }

    public function returnTeamsResults()
    {
        $teamsInfo = $this->team->getInfosByEachTeam();
        
        return response()->json([
            'teams' => $teamsInfo
        ]);
    }

}
