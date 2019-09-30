<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class tehinacalController extends Controller
{
    public function tehnical( Request $request ){

    	$totalanak = $request->input('totalanak');
    	$umur = $request->input('umur');
    	$gajipokok = $request->input('gajipokok');

    	if (in_array($umur, range(1,5))){
			$tunjangan=$gajipokok+(0.05*$gajipokok);
		}
		else if (in_array($umur, range(6,10))){
			$tunjangan=$gajipokok+(0.07*$gajipokok);
		}
		else if (in_array($umur, range(11,15))){
			$tunjangan=$gajipokok+(0.10*$gajipokok);
		}

    	return response()->json($tunjangan);
    }
}
