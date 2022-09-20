<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Ticket::all();
        if($data->count()>0){
            return $data->toJson();
        }else{
            return response()->json([
                'statut' => 404,
                'message' => 'Pas de ticket',
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Ticket::create($request->all())){
            return response()->json([
                'statut' => 200,
                'message' => "Votre ticket avec l'imatriculation ". $request->Imatriculation." à bien été créer ",
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return $ticket->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Verification si la data respect le schema de la DB (6 car max)
        $stringLength = Str::length($request->Imatriculation);
        if($stringLength> 7 ){
            return response()->json([
                'statut' => 404,
                'message' => "L'imatriculation ne doit pas dépasser 7 caractères",
            ]);
        }
        if($ticket->update($request->all())){
            return response()->json([
                'statut' => 200,
                'message' => "Votre ticket à bien été modifié en : " . $request->Imatriculation,
            ]);
        }else{
            return response()->json([
                'statut' => 404,
                'message' => "Un probleme est survenu veuillez réessayer",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */

    public function destroy(Ticket $ticket)
    {
        if($ticket->delete()){
            return response()->json([
                'statut' => 200,
                'message' => "Le ticket avec l'imatriculation [".$ticket->Imatriculation."] à bien été supprimé"
            ]);
        }else{
            return response()->json([
                'statut' => 404,
                'message' => "Ce ticket n'existe pas"
            ]);
        }
    }
}
