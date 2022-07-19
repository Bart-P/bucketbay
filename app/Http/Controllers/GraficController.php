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
        // TODO add size and type info to DB and save it
        // alternative is to take this date from the file itself? Which is better and why?
        $fileName = request()->file('file')->store('public/grafics');
        if ($fileName && auth()->user()->id) {
            $form_fields = request()->validate([
                'name' => ['required', Rule::unique('grafics', 'name')],
            ]);

            $form_fields['user_id'] = auth()->user()->id;
            $fileNameArray = explode('/', $fileName);
            $fileName = array_pop($fileNameArray);
            $form_fields['file'] = $fileName;

            Grafic::create($form_fields);

            return redirect('/grafics')->with('success_msg', 'Datei wurde hochgeladen');
        };
    }
}
