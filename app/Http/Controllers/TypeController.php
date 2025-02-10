<?php

namespace App\Http\Controllers;

use App\Exports\TypeExport;
use App\Models\Inventory;
use App\Models\Type;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Type::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        $types = $query->paginate(10);

        return view('pages.admin.type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.type.create');
    }

    /**
     * Menyimpan type baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:types',
            'information' => 'required'
        ]);

        $types = Type::create([
            'name' => $request->name,
            'code' => $request->code,
            'information' => $request->information
        ]);

        return redirect()->route('type.index')->with('success', 'type berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = Type::findOrFail($id);
        return view('pages.admin.type.edit', [
            'type' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:types,code,' . $id,
            'information' => 'required',
        ]);

        $type = Type::findOrFail($id);

        $type->name = $request->name;
        $type->code = $request->code;
        $type->information = $request->information;
        $type->save();

        return redirect()->route('type.index')->with('success', 'Type berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = Type::findOrFail($id);
        $isUsed = Inventory::where('id_type', $id)->exists();
        if ($isUsed) {
            return redirect()->back()->with(['error' => 'Data tidak dapat dihapus karena sedang digunakan di Inventory!']);
        }
        $type->delete();

        return redirect()->route('type.index')->with('success', 'Data berhasil dihapus!');
    }


    public function export(Request $request)
    {
        $typeIds = $request->query('ids');

        if ($typeIds) {
            $typeIdsArray = explode(',', $typeIds);
            $types = Type::whereIn('id', $typeIdsArray)->get(['name', 'code', 'information']);
        } else {
            $types = Type::all(['name', 'code', 'information']);
        }

        return Excel::download(new TypeExport($types), 'Jenis Inventaris.xlsx');
    }
}
