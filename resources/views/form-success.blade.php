@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 pt-16">
    <div class="glass rounded-3xl p-10 text-center space-y-4">
        <div class="mx-auto h-16 w-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-10.707a1 1 0 00-1.414-1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="space-y-2">
            <p class="text-xs uppercase tracking-[0.2em] text-emerald-600">Enviado</p>
            <h1 class="text-3xl font-bold text-slate-900">Recebemos seus dados!</h1>
            <p class="text-slate-600">Sua solicitação foi registrada com sucesso. Nossa equipe irá revisar as informações e retornará em breve.</p>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
            <a href="{{ route('form.show') }}" class="px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-white">Enviar outro formulário</a>
            <a href="{{ route('login') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-slate-800 font-semibold hover:bg-slate-50">Ir para área admin</a>
        </div>
    </div>
</div>
@endsection
