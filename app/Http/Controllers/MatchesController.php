<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchResultRequest;
use App\Models\Matches;
use Exception;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    private $matches;

    function __construct(Matches $matches) 
    {
        $this->matches = $matches;
    }

    public function store(MatchResultRequest $request)
    {
        if($message = $this->matches->verifyConfrontationBetweenTeams($request->input('time_casa_id'),$request->input('time_visitante_id'))){
            throw new Exception($message);
        }   
         
        $createdMatch = $this->matches->create([
            'time_visitante_id' => $request->input('time_visitante_id'),
            'time_casa_id' => $request->input('time_casa_id'),
            'gols_visitante' => $request->input('gols_visitante'),
            'gols_em_casa' => $request->input('gols_em_casa'),
        ]);

        return response()->json($createdMatch, 201);
    }


}
