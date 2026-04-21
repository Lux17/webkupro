<?php

namespace App\Http\Controllers;

use App\Models\Hasil;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Session;

class HasilController extends Controller
{
    public function index(Request $request, $id)
    {
        $keyword = $request->id;
        $hasil_diagnosis = Hasil::where('id_hasil', 'like', "%".$keyword."%")->paginate();
        return view('laporan_hasil', ['hasil_diagnosis' => $hasil_diagnosis]);
    }


}
