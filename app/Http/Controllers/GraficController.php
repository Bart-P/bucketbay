<?php

namespace App\Http\Controllers;

use App\Models\Grafic;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class GraficController extends Controller
{
    public function index()
    {
        return view('grafics.index');
    }

    public function store()
    {
        $fileName = request()->file('file')->store('public/grafics');
        if ($fileName && auth()->user()->id) {
            $form_fields = request()->validate([
                'name' => ['required', Rule::unique('grafics', 'name')],
            ]);

            $fileSizeInBytes = request()->file('file')->getSize();
            $fileSizeInMb = round($fileSizeInBytes/1000000, 2, PHP_ROUND_HALF_UP);

            $form_fields['user_id'] = auth()->user()->id;
            $fileNameArray = explode('/', $fileName);
            $fileName = array_pop($fileNameArray);
            $form_fields['file'] = $fileName;
            $form_fields['type'] = request()->file('file')->getMimeType();
            $form_fields['size_in_mb'] = $fileSizeInMb;

            Grafic::create($form_fields);

            return redirect('/grafics')->with('success_msg', 'Datei wurde hochgeladen');
        };
        return redirect('/grafics')->with('failed_msg', 'Datei wurde konnte nicht Hochgeladen werden!');
    }

    public function destroy($selectedImageId)
    {
        $fileName = Grafic::where('id', $selectedImageId)->value('file');
        if (File::delete('storage/grafics/' . $fileName)) {
            Grafic::destroy($selectedImageId);
            return redirect('/grafics')->with('success_msg', 'Die datei wurde gelöscht!');
        };
        return redirect('/grafics')->with('failed_msg', 'Datei konnte nicht gelöscht werden!');
    }

    public function update(Grafic $grafic)
    {
        $grafic_fields = request()->validate([
            'name' => 'required',
        ]);

        $grafic->updateTimestamps();
        if ($grafic->update($grafic_fields)) {
            return redirect('/grafics')->with('success_msg', 'Grafic geändert!');
        }

        return redirect('/grafics')->with('failed_msg', 'Grafic konte nicht geändert werden!');
    }
}
