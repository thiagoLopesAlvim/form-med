@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 pt-10">
    <div class="flex items-center justify-between mb-8">
        <div class="space-y-1">
            <p class="text-xs uppercase tracking-[0.2em] text-blue-600">Admin</p>
            <h1 class="text-3xl font-bold text-slate-900">Submissões</h1>
            <p class="text-slate-600">Filtre por e-mail e intervalo de datas.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="flex items-center space-x-3">
            @csrf
            <button type="submit" class="text-sm text-slate-700 hover:text-slate-900 px-3 py-1 rounded-full border border-slate-200">Sair</button>
        </form>
    </div>

    <form method="GET" action="{{ route('admin.submissions.index') }}" class="glass rounded-2xl p-5 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-800">E-mail</label>
            <input type="email" name="email" value="{{ request('email') }}" class="mt-1 block w-full rounded-lg border border-slate-200 bg-white text-slate-900 placeholder-slate-400 focus:border-blue-400 focus:ring-blue-400" placeholder="email@dominio.com">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-800">Data de</label>
            <input type="date" name="from" value="{{ request('from') }}" class="mt-1 block w-full rounded-lg border border-slate-200 bg-white text-slate-900 focus:border-blue-400 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-800">Data até</label>
            <input type="date" name="to" value="{{ request('to') }}" class="mt-1 block w-full rounded-lg border border-slate-200 bg-white text-slate-900 focus:border-blue-400 focus:ring-blue-400">
        </div>
        <div class="flex items-end space-x-3">
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700">Filtrar</button>
            <a href="{{ route('admin.submissions.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">Limpar</a>
        </div>
    </form>

    <div class="flex items-center justify-between mb-3 text-sm text-slate-700">
            <p>{{ $submissions->total() }} resultados</p>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.submissions.export', array_merge(request()->only(['email','from','to']), ['format' => 'csv'])) }}" class="px-3 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">Exportar CSV</a>
            <a href="{{ route('admin.submissions.export', array_merge(request()->only(['email','from','to']), ['format' => 'xlsx'])) }}" class="px-3 py-2 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">Exportar XLSX</a>
        </div>
    </div>

    <div class="glass rounded-2xl overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Nome / Razão social</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">E-mail</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Tipo</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Data</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($submissions as $submission)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 text-sm text-slate-900">{{ $submission->registration_type === 'pj' ? ($submission->razao_social ?? $submission->nome) : $submission->nome }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $submission->email }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ $submission->registration_type === 'pj' ? 'Pessoa Jurídica' : 'Pessoa Física' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600">{{ $submission->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-sm text-right space-x-3">
                            <a href="{{ route('admin.submissions.show', $submission) }}" class="text-blue-600 hover:text-blue-700">Ver</a>
                            <a href="{{ route('admin.submissions.download', $submission) }}" class="text-slate-700 hover:text-slate-900">Download</a>
                            <form method="POST" action="{{ route('admin.submissions.destroy', $submission) }}" class="inline" onsubmit="return confirm('Remover essa submissão?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">Nenhuma submissão encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-slate-800">{{ $submissions->withQueryString()->links() }}</div>
</div>
@endsection
