@extends('layouts.app')

@section('container')
    <!-- Page Header -->
    <div class="w-full text-white text-[22px] font-bold p-4 sticky top-0 border-b border-gray-800 bg-zinc-800" style="background-color: #161B22;">
        Home
    </div>

    <!-- Tweet Form -->
    <div class="border-b border-gray-800 w-full">
        <div class="flex items-start space-x-2 px-1">
            <!-- User Avatar -->
            <div class="flex-shrink-0">
                <img class="w-11 h-11 rounded-full object-cover" src="/imgs/testimg.jpg" alt="User Avatar">
            </div>
            <!-- Form -->
            <div class="flex-1 min-w-0">
                <form action="{{ url('/dashboard') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="w-full">
                        <div class="px-1 py-2 rounded-t-lg">
                            <label for="tweet" class="sr-only">What's funny now?</label>
                            <textarea 
                                id="tweet" 
                                name="tweet" 
                                rows="2" 
                                oninput="autoResize(this)" 
                                class="resize-none w-full px-0 text-xl text-gray-900 border-0 bg-transparent focus:ring-0 dark:text-white dark:placeholder-gray-400" 
                                placeholder="What's funny now?" 
                                required
                            ></textarea>
                        </div>
                        <div class="flex items-center justify-between py-2 border-t border-gray-800 dark:border-gray-600">
                            <div class="flex space-x-1">
                                <!-- File Upload Icon -->
                                <input type="file" id="file-input" class="hidden">
                                <label for="file-input" class="cursor-pointer">
                                    <i class="fas fa-upload text-amber-300 text-xl"></i>
                                </label>
                            </div>
                            <div class="flex space-x-1">
                                <!-- Custom Button -->
                                <x-cus-button class="mb-4">
                                    {{ __('Pop') }}
                                </x-cus-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Pops List -->
        @foreach (App\Models\Pops::all()->shuffle() as $pop)
            <div class="flex p-4 border-b border-gray-800">
                <!-- User Avatar -->

                     <img class="mr-2 w-11 h-11 rounded-full object-cover" src="{{ asset('storage/'.App\Models\User::find($pop->user_id)->avatar) }}" alt="User Avatar">
                <div class="w-full">
                    <div class="flex items-center justify-between">
                        <!-- User Info -->
                            <div class="flex">
                                <p class="text-md font-medium text-white truncate dark:text-white">
                                    {{ App\Models\User::find($pop->user_id)->name }}
                                </p>
                                <p class="text-md text-gray-500 truncate dark:text-gray-400">
                                    {{ '@' . App\Models\User::find($pop->user_id)->handle }}
                                </p>
                            </div>

                        <!-- More Options Button -->
                        <button id="dropdownMenuIconHorizontalButton" data-dropdown-toggle="dropdownDotsHorizontal" class="inline-flex items-center p-1 text-sm font-medium text-center text-gray-900 rounded-full hover:bg-gray-600 dark:text-white dark:hover:bg-gray-700 " type="button"> 
                                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                                </button>
                                  <!-- Dropdown menu -->
                                  <div id="dropdownDotsHorizontal" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconHorizontalButton">
                                        @if ($pop->user_id === illuminate\Support\Facades\Auth::user()->id)
                                            <li>
                                                <a href="/profile/destroy{{ $pop->id }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                            </li>
                                        @endif
                                        <li>
                                            {{-- <a href="/profile/destroy{{ $pop->id }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a> --}}
                                            <a href="" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Share</a>
                                        </li>
                                    </ul>
                                  </div>
                    </div>

                    <!-- Tweet Content -->
                    <div class="">
                        <p class="font-light text-white dark:text-white">{{ $pop->tweet }}</p>
                    </div>

                    <div class="mt-4">
                        
                        <!-- Media -->
                        @if ($pop->file)
                        @if (pathinfo($pop->file, PATHINFO_EXTENSION) === 'mp4')
                        <video class="max-h-96 w-full rounded-xl border border-gray-800" controls>
                            <source src="{{ asset('storage/'.$pop->file) }}" type="video/mp4">
                        </video>
                        @else   
                        <img class="max-h-96 w-full rounded-xl border border-gray-800" src="{{ asset('storage/'.$pop->file) }}" alt="Post Media">
                        @endif
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-4 px-1">    
                        <div>
                            @if ($pop->is_fav === 'false')
                                <a href="/dashboard/fav{{ $pop->id }}">
                                    <i class="fa-regular fa-star text-md text-white"></i>
                                </a>
                            @else
                                <a href="/dashboard/des{{ $pop->id }}">
                                    <i class="fa-solid fa-star text-md text-white"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
@endsection

<script>
    function autoResize(textarea) {
        textarea.style.height = 'auto'; // Reset height
        textarea.style.height = (textarea.scrollHeight) + 'px'; // Set new height based on content
    }
</script>
