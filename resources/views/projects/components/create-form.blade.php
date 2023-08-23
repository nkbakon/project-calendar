<form wire:submit.prevent="store" method="POST">
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
    @foreach ($rows as $index => $row)
        <div>
            <strong class="inline-flex">{{ $index+1 }}.</strong>
            @if($index != 0)
            <button type="button" title="remove" wire:click="removeRow({{$index}})" class="inline-flex px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-solid fa-xmark"></i></button>
            @endif
        </div><br>
        <div>
            <label for="users">Assign User</label><br>
            <select name="users" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="users.{{$index}}" required>
                <option value="" disabled selected>Select a user from here</option>
                @foreach($all_users as $user)
                <option value="{{$user->id}}">{{$user->fname}} {{$user->lname}} ({{$user->username}})</option>
                @endforeach
            </select>
        </div>
        @error("users.{$index}") <span class="text-red-500 error">{{ $message }}</span><br> @enderror
        <br>
    @endforeach
    <div>
        &nbsp;<button type="button" wire:click="addRow" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">
            Assign Another User
        </button>
    </div><br>
    <div>
        &nbsp;<button wire:target="store" wire:loading.attr="disabled" type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25">Save</button>
    </div>
</form>