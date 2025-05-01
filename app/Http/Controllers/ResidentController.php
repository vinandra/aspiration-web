<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::with('user')->paginate(1);
        return view('pages.resident.index', [
            'residents' => $residents,
        ]);
    }

    public function create()
    {
        return view('pages.resident.create');
    }

    public function store(Request $request)
    {   
        $validatedData = $request->validate([
            'nik' => ['required', 'min:16', 'max:16'],
            'name' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'birth_date' => ['required', 'string'],
            'birth_place' => ['required', 'max:100'],
            'address' => ['required', 'max:700'],
            'religion' => ['required', Rule::in(['islam', 'kristen_protestan', 'kristen_katholik', 'hindu', 'buddha', 'konghucu'])],
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'occupation' => ['required', 'max:100'],
            'phone' => ['required', 'max:15'],
            'status' => ['required', Rule::in(['active', 'moved', 'deceased'])],
        ]);

        Resident::create($validatedData);

        return redirect('/resident')->with('success', 'berhasil menambah data');
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);

        return view('pages.resident.edit', [
            'resident' => $resident,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'min:16', 'max:16'],
            'name' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'birth_date' => ['required', 'string'],
            'birth_place' => ['required', 'max:100'],
            'address' => ['required', 'max:700'],
            'religion' => ['required', Rule::in(['islam', 'kristen_protestan', 'kristen_katholik', 'hindu', 'buddha', 'konghucu'])],
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'occupation' => ['required', 'max:100'],
            'phone' => ['required', 'max:15'],
            'status' => ['required', Rule::in(['active', 'moved', 'deceased'])],
        ]);

        Resident::findOrfail($id)->update($validatedData);

        return redirect('/resident')->with('success', 'berhasil mengubah data');
    }

    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();



        return redirect('/resident')->with('success', 'berhasil menghapus data');
    }
}
