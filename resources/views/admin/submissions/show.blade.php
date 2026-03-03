@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 pt-10 space-y-6">
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <p class="text-xs uppercase tracking-[0.2em] text-blue-600">Admin</p>
            <h1 class="text-3xl font-bold text-slate-900">Detalhes da submissão</h1>
        </div>
        <div class="flex items-center space-x-3">
            @if(is_array($submission->documents) && count($submission->documents))
                <a href="{{ route('admin.submissions.download', $submission) }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold border border-blue-600 hover:bg-blue-700">Baixar primeiro arquivo</a>
            @endif
            <form method="POST" action="{{ route('admin.submissions.destroy', $submission) }}" onsubmit="return confirm('Remover essa submissão?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-lg border border-red-300 text-red-700 text-sm font-semibold hover:bg-red-50">Excluir</button>
            </form>
            <a href="{{ route('admin.submissions.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-50">Voltar</a>
        </div>
    </div>

    @if(is_array($submission->documents) && count($submission->documents))
        <div class="glass rounded-2xl p-5 border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-blue-600">Arquivos enviados</p>
                    <p class="text-sm text-slate-600">{{ count($submission->documents) }} arquivo(s) disponível(is) para download</p>
                </div>
            </div>
            <ul class="divide-y divide-slate-200 text-sm text-slate-800">
                @foreach ($submission->documents as $index => $doc)
                    <li class="py-2 flex items-center justify-between">
                        <span>{{ $doc['original_name'] ?? ('Documento '.($index + 1)) }}</span>
                        <a href="{{ route('admin.submissions.download', [$submission, 'doc' => $index]) }}" class="text-blue-700 hover:text-blue-800 font-semibold">Baixar</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glass rounded-2xl p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-slate-900">
        <div>
            <p class="text-sm text-slate-500">Tipo de cadastro</p>
            <p class="text-lg font-semibold">{{ $submission->registration_type === 'pj' ? 'Pessoa Jurídica' : 'Pessoa Física' }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Nome</p>
            <p class="text-lg font-semibold">{{ $submission->nome }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">CPF</p>
            <p class="text-lg font-semibold">{{ $submission->cpf }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Razão social</p>
            <p class="text-lg font-semibold">{{ $submission->razao_social }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Nome fantasia</p>
            <p class="text-lg font-semibold">{{ $submission->nome_fantasia }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">CNPJ</p>
            <p class="text-lg font-semibold">{{ $submission->cnpj }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Representante legal</p>
            <p class="text-lg font-semibold">{{ $submission->representante_legal }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Website</p>
            <p class="text-lg font-semibold">{{ $submission->website }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">E-mail</p>
            <p class="text-lg font-semibold">{{ $submission->email }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">E-mail testemunha</p>
            <p class="text-lg font-semibold">{{ $submission->email_testemunha }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Telefone</p>
            <p class="text-lg font-semibold">{{ $submission->telefone }}</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-sm text-slate-500">Endereço</p>
            <p class="text-lg font-semibold">{{ $submission->endereco }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Nacionalidade</p>
            <p class="text-lg font-semibold">{{ $submission->nacionalidade }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Profissão</p>
            <p class="text-lg font-semibold">{{ $submission->profissao }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Data de nascimento</p>
            <p class="text-lg font-semibold">{{ $submission->data_nascimento?->format('d/m/Y') }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Dados bancários</p>
            <p class="text-lg font-semibold">{{ $submission->dados_bancarios }}</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-sm text-slate-500">Mensagem</p>
            <p class="text-base text-slate-800 whitespace-pre-line">{{ $submission->mensagem }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Enviado em</p>
            <p class="text-lg font-semibold">{{ $submission->created_at?->format('d/m/Y H:i') }}</p>
        </div>
        <div class="md:col-span-2 space-y-2">
            <p class="text-sm text-slate-500">Documentos</p>
            @if(is_array($submission->documents) && count($submission->documents))
                <p class="text-sm text-slate-700">Consulte a lista acima para baixar.</p>
            @else
                <p class="text-slate-500 text-sm">Nenhum documento enviado.</p>
            @endif
        </div>

        <div class="md:col-span-2">
            <p class="text-sm text-slate-500">Checklist enviado</p>
            @if(is_array($submission->doc_checklist) && count($submission->doc_checklist))
                <ul class="list-disc list-inside text-sm text-slate-800 space-y-1">
                    @foreach ($submission->doc_checklist as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-slate-500 text-sm">Nenhum item marcado.</p>
            @endif
        </div>

        <div class="md:col-span-2">
            <p class="text-sm text-slate-500">Políticas de compliance</p>
            @if(is_array($submission->compliance_policies) && count($submission->compliance_policies))
                <ul class="list-disc list-inside text-sm text-slate-800 space-y-1">
                    @foreach ($submission->compliance_policies as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-slate-500 text-sm">Não informado.</p>
            @endif
        </div>

        <div>
            <p class="text-sm text-slate-500">Investigado por</p>
            <p class="text-lg font-semibold">{{ $submission->investigated_for }}</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-sm text-slate-500">Detalhes investigação</p>
            <p class="text-base text-slate-800 whitespace-pre-line">{{ $submission->investigation_details }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">Lei 12.846/2013</p>
            <p class="text-lg font-semibold">{{ $submission->law_12846_compliant === null ? '' : ($submission->law_12846_compliant ? 'Sim' : 'Não') }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500">LGPD</p>
            <p class="text-lg font-semibold">{{ $submission->lgpd_compliant === null ? '' : ($submission->lgpd_compliant ? 'Sim' : 'Não') }}</p>
        </div>
    </div>
</div>
@endsection
