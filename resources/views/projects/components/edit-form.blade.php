<form wire:submit.prevent="update" method="POST">
    @method('PUT')
    @csrf
    <div>
        <label for="title">Enter Project Title</label><br>
        <input type="text" name="title" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="project title" wire:model="title" required>
    </div>
    @error('title') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    <div>
        <label for="start_date">Select Start Date</label><br>
        <input type="date" name="start_date" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="start_date" required>
    </div>
    @error('start_date') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    <div>
        <label for="due_date">Select Due Date</label><br>
        <input type="date" name="due_date" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="due_date" required>
    </div>
    @error('due_date') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    <div>
        <label for="note">Enter Note</label><br>
        <input type="text" name="note" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="enter note" wire:model="note">
    </div>
    @error('note') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    @if($original_names != '')
        <label>Documents</label><br>
        <div class="flex overflow-x-auto">
        @php
            $original_names = json_decode($original_names);
            $documents = json_decode($project->documents);
        @endphp
        @for ($i = 0; $i < count($original_names); $i++)                                
            @php
                $fileExtension = pathinfo($original_names[$i], PATHINFO_EXTENSION);
            @endphp
            @if ($fileExtension == "pdf")
                <img class="h-6 w-6" src="{{ asset('assets/pdf.png') }}">
            @elseif ($fileExtension == "xls" || $fileExtension == "xlsx")
                <img class="h-6 w-6" src="{{ asset('assets/xls.png') }}">
            @elseif ($fileExtension == "doc" || $fileExtension == "docx")
                <img class="h-6 w-6" src="{{ asset('assets/doc.png') }}">
            @elseif ($fileExtension == "jpg" || $fileExtension == "jpeg")
                <img class="h-6 w-6" src="{{ asset('assets/jpg.png') }}">
            @elseif ($fileExtension == "png")
                <img class="h-6 w-6" src="{{ asset('assets/png.png') }}">
            @elseif ($fileExtension == "ppt" || $fileExtension == "pptx")
                <img class="h-6 w-6" src="{{ asset('assets/ppt.png') }}">
            @elseif ($fileExtension == "txt")
                <img class="h-6 w-6" src="{{ asset('assets/txt.png') }}">
            @else
                <img class="h-6 w-6" src="{{ asset('assets/file.png') }}">
            @endif
            <p class="text-gray-700 text-sm">{{ $original_names[$i] }}</p>
        @endfor
        </div><br>
        <div>
            <button type="button" wire:click="removeDocs" title="remove documents" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">
                Remove
            </button>
        </div>
    @else
        <div>
            <label for="updatedocuments">Upload Documents</label><br>
            <input type="file" name="updatedocuments" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="updatedocuments" multiple required>
        </div>
        @error('updatedocuments') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
        <br>
    @endif<br>
    @if($project->user_ids != null)
        @foreach ($rows as $index => $row)
            <div>
                <strong class="inline-flex">{{ $index+1 }}.</strong>        
            </div>
            <div>
                <label for="user">Assign User</label><br>
                <select name="user" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="user.{{$index}}" disabled>
                    <option value="" selected>Select a product from here</option>
                    @foreach($all_users as $user)
                    <option value="{{$user->id}}">{{$user->fname}} {{$user->fname}} ({{$user->username}})</option>
                    @endforeach
                </select>
            </div>
            @error('{{$user->fname}}.{{$index}}') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
            <br>
        @endforeach
        <br>
    @endif
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update</button>                        
</form>