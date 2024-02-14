<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ocorrências') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Colaborador</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Com Refrigerante?</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pago</th>
                                @if(Auth::user() && Auth::user()->role == "admin")
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $count = 1 @endphp
                            @foreach($events as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $event->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $event->employee['name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($event->soda == true)
                                    <span class="text-green-500 font-semibold">Sim</span>
                                    @else
                                    <span class="text-red-500 font-semibold">Não</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ asset('imagens/' . $event->imagem) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Ver Imagem</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($event->paid == true)
                                    <span class="text-green-500 font-semibold">Sim</span>
                                    @else
                                    <span class="text-red-500 font-semibold">Não</span>
                                    @endif
                                </td>
                                @if(Auth::user() && Auth::user()->role == "admin")
                                <td class="px-6 py-4 whitespace-nowrap flex gap-7">
                                    <button class="alterar-status" data-event-id="{{ $event->id }}"><i class="material-icons text-indigo-600">currency_exchange</i></button>
                                    <button class="excluir-evento" data-event-id="{{ $event->id }}"><i class="material-icons text-red-500">delete</i></button>
                                </td>
                                @endif
                            </tr>
                            @php $count++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('.alterar-status').on('click', function() {
            var eventId = $(this).data('event-id');
            var confirmacao = confirm("Tem certeza que deseja alterar o status do pagamento?");
            if (confirmacao) {
                $.ajax({
                    type: 'PUT',
                    url: '/events/' + eventId + '/change-status',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("Erro ao alterar o status de pagamento: " + error);
                    }
                });
            }
        });

        $('.excluir-evento').on('click', function() {
            var eventId = $(this).data('event-id');
            var confirmacao = confirm("Tem certeza que deseja excluir este evento?");
            if (confirmacao) {
                $.ajax({
                    type: 'DELETE',
                    url: '/events/' + eventId,
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        alert("Evento excluído com sucesso!");
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("Erro ao excluir o evento: " + error);
                    }
                });
            }
        });
    });
</script>
