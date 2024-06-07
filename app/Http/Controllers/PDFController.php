<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use PDF;

class PDFController extends Controller
{
    public function downloadpdf() {;
    
        $data = [
            'date' => date('m/d/Y'),
        ];

        $pdf = PDF::loadView('userPDF', $data);
        return $pdf->download('laporan.pdf');
    }
}