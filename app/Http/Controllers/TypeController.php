<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeStoreRequest;
use App\Http\Requests\TypeUpdateRequest;
use App\Services\TypeService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TypeController extends Controller
{
    protected $typeService;

    public function __construct(TypeService $typeService)
    {
        $this->typeService = $typeService;
    }

    public function index(Request $request)
    {
        $types = $this->typeService->getAllTypes($request->search);
        return view('pages.admin.type.index', compact('types'));
    }

    public function create()
    {
        return view('pages.admin.type.create');
    }

    public function store(TypeStoreRequest $request)
    {
        $this->typeService->createType($request->validated());
        return redirect()->route('type.index')->with('success', 'Type berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $type = $this->typeService->getTypeById($id);
        return view('pages.admin.type.edit', compact('type'));
    }

    public function update(TypeUpdateRequest $request, string $id)
    {
        $this->typeService->updateType($id, $request->validated());
        return redirect()->route('type.index')->with('success', 'Type berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        if (!$this->typeService->deleteType($id)) {
            return redirect()->back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan di Inventory!');
        }
        return redirect()->route('type.index')->with('success', 'Data berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $file = $this->typeService->exportTypes($request->query('ids'));
        return Excel::download($file, 'Jenis Inventaris.xlsx');
    }
}