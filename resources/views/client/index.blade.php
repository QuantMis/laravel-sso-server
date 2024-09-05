<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clients Oauth') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-row justify-between">
                        <div class="text-xl font-bold">{{ __('Daftar Client') }}</div>
                        <a href="{{ route('client.create') }}" class="bg-emerald-500 py-2 px-3 rounded-lg font-bold text-white">Add Client</a>
                    </div>
                    <div class="py-5">
                        <table class="table client-table">
                            <thead>
                                <tr>
                                    <th>ClientID</th>
                                    <th>Nama</th>
                                    <th>Redirect</th>
                                    <th>Secret</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('.client-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('client.list') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'redirect',
                        name: 'redirect'
                    },
                    {
                        data: 'secret',
                        name: 'secret'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
    <script>
        function deleteClient(clientId, userId) {
            if (confirm('Are you sure you want to delete this client?')) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/client/destroy/' + clientId + '/' + userId,
                    type: 'DELETE',
                    data: {
                        _token: csrfToken,
                    },
                    success: function(result) {
                        alert('Client deleted successfully.');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Error deleting client.');
                    }
                });
            }
        }
    </script>

</x-app-layout>