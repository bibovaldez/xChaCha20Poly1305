{{-- file upload component --}}
<div class="file-upload">





    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

        {{-- ENCRYPTION --}}
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="{{ route('encrypt') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- fiel upload --}}
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium leading-5 text-gray-700">Encryption</label>
                    <input type="file" name="file" id="file" size="60"
                        class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150"
                        required>
                </div>
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ __('Upload') }}
                    </button>
                </div>
            </form>
        </div>
        {{-- DECYRPTION --}}
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="{{ route('decrypt') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- fiel upload --}}
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium leading-5 text-gray-700">Decryption</label>
                    <input type="file" name="file" id="file" size="60"
                        class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150"
                        required>
                </div>
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ __('Upload') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
