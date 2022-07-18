<?php

namespace App\Http\Controllers;

use App\Models\Grafic;
use Illuminate\Validation\Rule;

class GraficController extends Controller
{
    public function grafics()
    {
        return view('grafics.index');
    }

    public function store()
    {
        // TODO symlink folder to public
        // TODO create the preview for grafics
        $fileName = request()->file('file')->store('grafics');
        if ($fileName && auth()->user()->id) {
            $form_fields = request()->validate([
                'name' => ['required', Rule::unique('grafics', 'name')],
            ]);

            $form_fields['user_id'] = auth()->user()->id;
            $form_fields['file'] = $fileName;

            Grafic::create($form_fields);

            return redirect('/grafics')->with('success_msg', 'Datei wurde hochgeladen');
        };
    }
}
