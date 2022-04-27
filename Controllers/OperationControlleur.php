<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OperationControlleur extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comptes = Compte::all();
        $jsonData = ['status' => 'SUCCESS', 'comptes' => []];
        foreach ($comptes as $compte){

            $jsonData ['comptes'][] = [
                'id' => $compte->id,
                'date_creation' => $compte->date_creation,
                'solde' => $compte->solde,
                'client' => $compte->client
            ];
        }
        return response()->json($jsonData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function creerCompte(Request $request)
    {
        $error = Validator::make($request->all(), [
            'solde'     =>  'required|numeric|min:0',
            'client'     =>  'required|numeric|min:1'
        ]);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }else{
            Compte::create($request->all());
            return response()->json(['success' => 'Compte cree avec success .']);
        }
    }

    public function updatecompte(Request $request, $id)
    {
        $compte = Compte::find($id);
        if ($compte){
            $compte->update(['client'=>$request->client]);
            return response()->json(['status' => 'SUCCESS', 'message' => 'Compte modifie avec success']);
        }else{
            return response()->json(['status' => 'ERREUR', 'compte' => 'Compte inexistant']);
        }
    }

    public function deletecompte($id)
    {
        $compte = Compte::find($id);
        if ($compte){
            $compte->delete();
            return response()->json(['status' => 'SUCCESS', 'message' => 'Compte supprime avec success']);
        }else{
            return response()->json(['status' => 'ERREUR', 'compte' => 'Compte inexistant']);
        }
    }

    public function versement(Request $request)
    {
        $error = Validator::make($request->all(), [
            'montant'     =>  'required|numeric|min:1',
            'id_compte'     =>  'required|numeric|min:1'
        ]);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }else{
            $data_operation=[
                'type_operation'=>'VERSEMENT',
                'montant'=>$request->montant,
                'id_compte'=>$request->id_compte,
            ];
            Operation::create($data_operation);

            $compte = Compte::findOrfail($request->id_compte);
            $compte->update(['solde'=>$compte->solde+$request->montant]);

            return response()->json(['statut' => 'SUCCESS','message'=>'Versement effectue avec success .']);
        }
    }

    public function retrait(Request $request)
    {
        $error = Validator::make($request->all(), [
            'montant'     =>  'required|numeric|min:1',
            'id_compte'     =>  'required|numeric|min:1'
        ]);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }else{
            $compte = Compte::find($request->id_compte);
            if ($request->montant<=$compte->solde){
                $data_operation=[
                    'type_operation'=>'RETRAIT',
                    'montant'=>$request->montant,
                    'id_compte'=>$request->id_compte,
                ];
                Operation::create($data_operation);

                $compte->update(['solde'=>$compte->solde-$request->montant]);

                return response()->json(['statut' => 'SUCCESS','message'=>'Retrait effectue avec success .']);
            }else{
                return response()->json(['statut' => 'ERREUR','message'=>'Montant saisi ne doit pas etre superieur au solde. Solde actuel '.$compte->solde]);
            }
        }
    }

    public function virement(Request $request){
        $compte_debiter = Compte::find($request->compte_debiter);
        if ($request->montant<=$compte_debiter->solde){
            //Compte a debiter
            $data_debit=[
                'type_operation'=>'VIREMENT VERS LE COMPTE '.$request->compte_crediter,
                'montant'=>$request->montant,
                'id_compte'=>$request->compte_debiter,
            ];
            Operation::create($data_debit);
            $compte_debiter->update(['solde'=>$compte_debiter->solde-$request->montant]);

            //Compte a crediter
            $compte_crediter = Compte::find($request->compte_crediter);
            $data_credit=[
                'type_operation'=>'VIREMENT DU COMPTE '.$request->compte_debiter,
                'montant'=>$request->montant,
                'id_compte'=>$request->compte_crediter,
            ];
            Operation::create($data_credit);
            $compte_crediter->update(['solde'=>$compte_crediter->solde+$request->montant]);

            return response()->json(['statut' => 'SUCCESS','message'=>'Virement effectue avec success .']);
        }else{
            return response()->json(['statut' => 'ERREUR','message'=>'Montant de virement ne doit pas etre superieur au solde du compte a debiter. Solde actuel '.$compte_debiter->solde]);
        }
    }

    public function recherchercpte($id)
    {
        $compte = Compte::find($id);
        if ($compte){
            return response()->json(['status' => 'SUCCESS', 'compte' => $compte]);
        }else{
            return response()->json(['status' => 'ERREUR', 'compte' => 'Compte inexistant']);
        }
    }

    public function annulerversement($id)
    {
        $versement = Operation::find($id);
        if ($versement){
            $compte = Compte::find($versement->id_compte);
            $compte->update(['solde'=>$compte->solde-$versement->montant]);
            $versement->delete();
            return response()->json(['status' => 'SUCCESS', 'message' => 'Versement annule avec success']);
        }else{
            return response()->json(['status' => 'ERREUR', 'message' => 'Operation inexistante']);
        }
    }

    public function annulerretrait($id)
    {
        $retrait = Operation::find($id);
        if ($retrait){
            $compte = Compte::find($retrait->id_compte);
            $compte->update(['solde'=>$compte->solde+$retrait->montant]);
            $retrait->delete();
            return response()->json(['status' => 'SUCCESS', 'message' => 'Retrait annule avec success']);
        }else{
            return response()->json(['status' => 'ERREUR', 'message' => 'Operation inexistante']);
        }
    }

    public function operationcompte($id)
    {
        $operations = DB::table('operations')->where('id_compte',$id)->get();
        $jsonData = ['status' => 'SUCCESS', 'Operations' => []];
        foreach ($operations as $operation){

            $jsonData ['Operations'][] = [
                'id' => $operation->id,
                'date_operation' => $operation->date_operation,
                'type_operation' => $operation->type_operation,
                'montant' => $operation->montant
            ];
        }
        return response()->json($jsonData);

    }
}
