<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PublicFormController extends Controller
{
    public function show(): View
    {
        return view('form');
    }

    public function success(): View
    {
        return view('form-success');
    }

    public function submit(Request $request): RedirectResponse
    {
        $rules = [
            'registration_type' => ['required', 'string', 'in:pj,pf'],
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['nullable', 'string', 'max:50'],
            'razao_social' => ['nullable', 'string', 'max:255'],
            'nome_fantasia' => ['nullable', 'string', 'max:255'],
            'cnpj' => ['nullable', 'string', 'max:50'],
            'representante_legal' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'endereco' => ['required', 'string', 'max:1000'],
            'email' => ['required', 'email', 'max:255'],
            'email_testemunha' => ['nullable', 'email', 'max:255'],
            'telefone' => ['nullable', 'string', 'max:30'],
            'nacionalidade' => ['required', 'string', 'max:100'],
            'profissao' => ['required', 'string', 'max:150'],
            'data_nascimento' => ['nullable', 'date'],
            'dados_bancarios' => ['nullable', 'string', 'max:1000'],
            'mensagem' => ['nullable', 'string'],
            'doc_checklist' => ['nullable', 'array'],
            'doc_checklist.*' => ['string', 'max:255'],
            'compliance_policies' => ['nullable', 'array'],
            'compliance_policies.*' => ['string', 'max:255'],
            'investigated_for' => ['nullable', 'string', 'max:255'],
            'investigation_details' => ['nullable', 'string'],
            'law_12846_compliant' => ['nullable', 'boolean'],
            'lgpd_compliant' => ['nullable', 'boolean'],
            'documents' => ['required', 'array', 'min:1'],
            'documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:5120'],
        ];

        if ($request->input('registration_type') === 'pf') {
            $rules['cpf'][0] = 'required';
        }

        if ($request->input('registration_type') === 'pj') {
            $rules['razao_social'][0] = 'required';
            $rules['nome_fantasia'][0] = 'required';
            $rules['cnpj'][0] = 'required';
            $rules['representante_legal'][0] = 'required';
            $rules['website'][0] = 'required';
            $rules['dados_bancarios'][0] = 'required';
        }

        $validated = $request->validate($rules);

        $storedDocs = [];
        foreach ($request->file('documents', []) as $file) {
            $path = $file->store('uploads', 'public');
            $storedDocs[] = [
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ];
        }

        FormSubmission::create([
            'registration_type' => $validated['registration_type'],
            'nome' => $validated['nome'],
            'cpf' => $validated['cpf'],
            'razao_social' => $validated['razao_social'] ?? null,
            'nome_fantasia' => $validated['nome_fantasia'] ?? null,
            'cnpj' => $validated['cnpj'] ?? null,
            'representante_legal' => $validated['representante_legal'] ?? null,
            'website' => $validated['website'] ?? null,
            'endereco' => $validated['endereco'],
            'email' => $validated['email'],
            'email_testemunha' => $validated['email_testemunha'] ?? null,
            'telefone' => $validated['telefone'] ?? null,
            'nacionalidade' => $validated['nacionalidade'],
            'profissao' => $validated['profissao'],
            'data_nascimento' => $validated['data_nascimento'] ?? null,
            'dados_bancarios' => $validated['dados_bancarios'] ?? null,
            'mensagem' => $validated['mensagem'] ?? null,
            'doc_checklist' => $validated['doc_checklist'] ?? [],
            'compliance_policies' => $validated['compliance_policies'] ?? [],
            'investigated_for' => $validated['investigated_for'] ?? null,
            'investigation_details' => $validated['investigation_details'] ?? null,
            'law_12846_compliant' => $validated['law_12846_compliant'] ?? null,
            'lgpd_compliant' => $validated['lgpd_compliant'] ?? null,
            'documents' => $storedDocs,
        ]);

        return redirect()->route('form.success');
    }
}
