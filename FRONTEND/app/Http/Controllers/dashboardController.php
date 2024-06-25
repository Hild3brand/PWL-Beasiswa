<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\decoder;

class dashboardController extends Controller
{
    public function index(){
        $api_token = Session::get('api_token');
        $decoder = new Decoder(); // Instantiate the Decoder class
        $data = $decoder->decode($api_token); // Call the decode method
        // Access data properties
        $nrp = $data->nrp;
        $nama = $data->nama;
        $email = $data->email;
        $status = $data->status;
        $role_id = $data->role_id;
        $program_studi_id = $data->program_studi_id;

        return view('dashboard.index', [
            'nrp' => $nrp,
            'nama' => $nama,
            'email' => $email,
            'status' => $status,
            'role_id' => $role_id,
            'program_studi_id' => $program_studi_id,
        ]);
    }
}