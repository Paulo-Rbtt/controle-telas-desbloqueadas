<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Ocorrência') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col justify-center items-center h-full py-10">
                        @csrf
                        <div class="mb-4 w-1/2">
                            <label for="image" class="block text-sm font-medium text-gray-700">Imagem:</label>
                            <input type="file" id="image" name="image" accept="image/jpeg, image/jpg, image/png" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-full" required>
                        </div>
                        <div class="mb-4 w-1/2">
                            <label for="employee" class="block text-sm font-medium text-gray-700">Colaborador:</label>
                            <select id="employee" name="employee" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md h-full" required>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <button type="submit" class="w-1/2 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cadastrar Ocorrência</button> -->
                        <x-primary-button>
                            {{ __('Cadastrar Ocorrência') }}
                        </x-primary-button>

                        <input type="hidden" name="authUser" value="{{ Auth::user()->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>