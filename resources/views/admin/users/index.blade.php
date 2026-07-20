<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Users</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded-lg text-sm">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">{{ $errors->first() }}</div>
        @endif

        <div class="bg-white shadow rounded-xl overflow-hidden border border-gray-100">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b bg-gray-50 text-gray-600 uppercase text-xs tracking-wide">
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                            <td class="p-4 font-medium text-gray-700">{{ $user->name }}</td>
                            <td class="p-4 text-gray-500">{{ $user->email }}</td>
                            <td class="p-4">
                                <span @class([
                                    'px-2.5 py-1 rounded-full text-xs font-medium',
                                    'bg-indigo-100 text-indigo-700' => $user->role == 'admin',
                                    'bg-gray-100 text-gray-600' => $user->role == 'user',
                                ])>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-3 flex-wrap">
                                    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="border-gray-300 rounded-lg text-sm py-1.5">
                                            <option value="user" @selected($user->role == 'user')>User</option>
                                            <option value="admin" @selected($user->role == 'admin')>Admin</option>
                                        </select>
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Update</button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm" onclick="return confirm('Delete this user?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>