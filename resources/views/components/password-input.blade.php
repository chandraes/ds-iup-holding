@props(['id', 'name'])

<input :type="$props['show_password'] ? 'text' : 'password'" id="{{ $id }}" class="block mt-1 w-full pr-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="{{ $name }}" required autofocus autocomplete="new-password" x-data="{ show_password: false }" x-bind:type="show_password ? 'text' : 'password'" />
<button type="button" @click="show_password = !show_password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
    <i :class="show_password ? 'fas fa-eye-slash' : 'fas fa-eye'" class="h-5 w-5 text-gray-500"></i>
</button>
