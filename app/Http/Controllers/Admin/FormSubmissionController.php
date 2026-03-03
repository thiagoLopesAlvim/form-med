<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FormSubmissionsExport;
use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;

class FormSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $query = FormSubmission::query()->latest();

        if ($request->filled('email')) {
            $query->where('email', 'like', '%'.$request->string('email')->trim().'%');
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->date('to'));
        }

        $submissions = $query->paginate(20)->withQueryString();

        return view('admin.submissions.index', [
            'submissions' => $submissions,
            'filters' => $request->only(['email', 'from', 'to']),
        ]);
    }

    public function show(FormSubmission $submission): View
    {
        return view('admin.submissions.show', compact('submission'));
    }

    public function destroy(FormSubmission $submission): RedirectResponse
    {
        if (is_array($submission->documents)) {
            foreach ($submission->documents as $doc) {
                if (!empty($doc['path']) && Storage::disk('public')->exists($doc['path'])) {
                    Storage::disk('public')->delete($doc['path']);
                }
            }
        }

        $submission->delete();

        return redirect()->route('admin.submissions.index')->with('status', 'Registro excluído com sucesso.');
    }

    public function download(FormSubmission $submission)
    {
        $documents = is_array($submission->documents) ? $submission->documents : [];
        $index = request()->integer('doc', 0);
        $doc = $documents[$index] ?? null;

        if (!$doc || empty($doc['path']) || !Storage::disk('public')->exists($doc['path'])) {
            abort(404);
        }

        $downloadName = $doc['original_name'] ?? basename($doc['path']);

        return Storage::disk('public')->download($doc['path'], $downloadName);
    }

    public function export(Request $request)
    {
        $format = $request->string('format')->lower()->value() === 'xlsx' ? Excel::XLSX : Excel::CSV;
        $fileName = 'form_submissions.'.($format === Excel::XLSX ? 'xlsx' : 'csv');

        $filters = $request->only(['email', 'from', 'to']);

        return ExcelFacade::download(new FormSubmissionsExport($filters), $fileName, $format);
    }
}
