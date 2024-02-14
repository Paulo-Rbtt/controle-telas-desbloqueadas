<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6">Devedores do mês</h1>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Colaborador</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Pizzas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Refrig.</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Pizzas Pendentes</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Refrig. Pendentes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($usersEvents as $case)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-bold">{{ $case->emp_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $case->events_qty }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $case->soda_events }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $case->unpaid_events }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $case->unpaid_soda_events }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>