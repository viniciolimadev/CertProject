<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formações Acadêmicas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-700">Formações Acadêmicas</h1>
                        <a href="{{ route('educations.create') }}" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Nova Formação
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 rounded relative bg-green-100 border border-green-400 text-green-700" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @forelse ($educations as $education)
                        <div class="bg-gray-50 shadow-md rounded-lg p-4 sm:p-6 mb-6">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-start">
                                <div class="mb-4 sm:mb-0">
                                    <h5 class="text-lg font-bold text-gray-800">{{ $education->degree }} - <span class="font-medium">{{ $education->institution }}</span></h5>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ $education->start_date ? \Carbon\Carbon::parse($education->start_date)->format('d/m/Y') : 'Início indefinido' }}
                                        —
                                        {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('d/m/Y') : 'Conclusão prevista/Atual' }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <form method="POST" action="{{ route('educations.destroy', $education) }}" onsubmit="return confirm('Tem certeza que deseja deletar esta formação?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Deletar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600">Sem formações cadastradas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
