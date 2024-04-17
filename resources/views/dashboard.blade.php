<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        @if ($users->count() > 1)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
                    <p class="mt-2 text-sm text-gray-700">A list of all the users including their first name, last name, email (ssn's are stored but not shown here ) .</p>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0 cursor-pointer hover:shadow-lg" onclick="sortTable(0)">First Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 cursor-pointer hover:shadow-lg" onclick="sortTable(1)">Last Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 cursor-pointer hover:shadow-lg" onclick="sortTable(2)">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 cursor-pointer hover:shadow-lg" onclick="sortTable(3)">Active</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Toggle Active</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)

                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                    {{ $user->firstname }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->lastname }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->enabled ? "Active" : "Inactive" }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <form id="toggle-user-form-{{ $user->id }}" action="{{ route('user-toggle', $user->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <a href="javascript:void(0)" onclick="confirmToggle('{{ $user->enabled ? 'Deactivate': 'Activate'  }}', '{{ ucfirst($user->firstname) }}', {{ $user->id }})"  class="text-indigo-600 hover:text-indigo-900">{{ $user->enabled ? 'Deactivate': 'Activate' }}<span class="sr-only"></span></a>
                                    </form>

                                </td>
                                <td class="hidden">{{ $user->firstname }}</td>
                            </tr>
                            @endforeach
                            <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="flex items-center flex-grow justify-center text-center ">
            <p class="text-2xl md:text-3xl lg:text-4xl text-white font-semibold py-4">
                Oops... No users found.
            </p>
        </div>
        @endif
    </div>


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <script>
        function confirmToggle(toggleType, name, userID) {
            if (confirm('Are you sure you want to ' + toggleType + ' ' + name + '?')) {
                document.getElementById('toggle-user-form-'+userID).submit();
            }
        }

        var last_sorted_index = -1;
        var reversed = 1;

        function sortTable(colIndex) {
            const table = document.querySelector('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            // determine what to do with this sort
            if (last_sorted_index === colIndex && reversed === -1) { // if clicked 3 times, reset
                reversed = 1;
                last_sorted_index = -1
                // get table last column index of first row
                colIndex = rows[0].querySelectorAll('td').length - 1;
            } else if (last_sorted_index === colIndex) {  // if clicked twice, desc
                reversed = -1;
            } else {
                last_sorted_index = colIndex;  // if clicked once, asc
                reversed = 1;
            }

            // sort the rows
            const sortedRows = rows.sort((a, b) => {
                const aColText = a.querySelector(`td:nth-child(${colIndex + 1})`).textContent.trim();
                const bColText = b.querySelector(`td:nth-child(${colIndex + 1})`).textContent.trim();

                return (aColText > bColText ? -1 : 1) * reversed ;
            });

            // append back to table to prevent losing events and other DOM element associations
            tbody.innerHTML = '';
            tbody.append(...sortedRows);
        }

    </script>

</x-app-layout>
