<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table>
                        <th>
                            <td class="w-1/2">Titulo</td>
                            <td class="w-1/2">Texto</td>
                        </th>
                        @foreach($identities as $identity)
                        <tr>
                            <td>{{ $identity->title }}</td>
                            <td>{{ $identity->text }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
