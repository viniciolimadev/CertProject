<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;


class CertificateController extends Controller
{

    public function index()
    {
        $certificates = Certificate::all();

        return view('certificates.index', compact('certificates'));
    }
    public function create()
    {
        return view('certificates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'file' => 'required|mimes:pdf|max:2048',
            'description_certificate' => 'nullable|string'
        ]);

        $path = $request->file('file')->store('certificates', 'public');

        $certificate = Certificate::create([
            'title' => $request->title,
            'file_path' => $path,
            'description_certificate' => $request->description_certificate
        ]);

        return redirect()->route('certificates.index')->with('success', 'Certificado salvo com sucesso!');

    }

    public function show(Certificate $certificate)
    {
        return $certificate;
    }

    public function download(Certificate $certificate)
    {
        return response()->download(storage_path("app/public/{$certificate->file_path}"));
    }
}
