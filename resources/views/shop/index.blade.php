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
                    @if($myShops->isEmpty())
                        {{ __("You're logged in!") }}
                    @endif

                        <button onclick="document.getElementById('modal').classList.remove('hidden')" class="bg-blue-500 text-white px-4 py-2 rounded">Open Form</button>

                        <!-- Modal -->
                        <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white p-6 rounded-lg shadow-lg modal-enter modal-enter-active">
                                <h2 class="text-xl text-gray-700 font-semibold mb-4">Create a new shop</h2>
                                <form action="#" method="POST">
                                    <!-- Your form fields go here -->
                                    <div class="mb-4">
                                        <label for="example" class="block text-sm font-medium text-gray-700">Shop name</label>
                                        <input type="text" id="example" name="example" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div class="mb-4">
                                        <label for="example" class="block text-sm font-medium text-gray-700">Shop logo</label>
                                        <input type="file" id="example" name="example" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div class="mb-4">
                                        <label for="example" class="block text-sm font-medium text-gray-700">Description</label>
                                        <input type="text" id="example" name="example" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div class="mb-4">
                                        <label for="example" class="block text-sm font-medium text-gray-700">Example Field</label>
                                        <input type="text" id="example" name="example" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div class="mb-4">
                                        <label for="example" class="block text-sm font-medium text-gray-700">Example Field</label>
                                        <input type="text" id="example" name="example" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div class="mb-4">
                                        <label for="example" class="block text-sm font-medium text-gray-700">Example Field</label>
                                        <input type="text" id="example" name="example" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                                    <button type="button" onclick="document.getElementById('modal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Close</button>
                                </form>
                            </div>
                        </div>

                        <script>
                            // Add/remove modal classes for animation
                            const modal = document.getElementById('modal');
                            const handleOpen = () => {
                                modal.classList.remove('hidden');
                                modal.classList.add('modal-enter', 'modal-enter-active');
                            }
                            const handleClose = () => {
                                modal.classList.remove('modal-enter', 'modal-enter-active');
                                modal.classList.add('modal-exit', 'modal-exit-active');
                                setTimeout(() => {
                                    modal.classList.add('hidden');
                                    modal.classList.remove('modal-exit', 'modal-exit-active');
                                }, 300); // Match the transition duration
                            }

                            document.querySelector('[onclick*="Open Form"]').addEventListener('click', handleOpen);
                            document.querySelector('[onclick*="Close"]').addEventListener('click', handleClose);
                        </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
    /* Custom styles for modal animations */
    .modal-enter {
        opacity: 0;
        transform: scale(0.95);
    }
    .modal-enter-active {
        opacity: 1;
        transform: scale(1);
        transition: opacity 300ms, transform 300ms;
    }
    .modal-exit {
        opacity: 1;
        transform: scale(1);
    }
    .modal-exit-active {
        opacity: 0;
        transform: scale(0.95);
        transition: opacity 300ms, transform 300ms;
    }
</style>