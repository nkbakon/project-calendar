<form wire:submit.prevent="update" method="POST">
    @method('PUT')
    @csrf
    <div>
        <label for="title">Enter Title</label><br>
        <input type="text" name="title" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="enter title" wire:model="title" required>
    </div>
    @error('title') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    <div>
        <label for="status">Select Status</label><br>
        <select name="status" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="status" required>
            <option value="" selected>Select a product from here</option>
            <option value="Active">Active</option>
            <option value="Done">Done</option>
        </select>
    </div>
    @error('status') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
    <br>
    @foreach ($rows as $index => $row)
        <div>
            <strong class="inline-flex">{{ $index+1 }}.</strong>        
        </div>
        <div>
            <label for="department">Select Department</label><br>
            <select name="department" class="block w-96 appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" wire:model="department.{{$index}}" disabled>
                <option value="" selected>Select a product from here</option>
                @foreach($all_departments as $department)
                <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
            </select>
        </div>
        @error('department.{{$index}}') <span class="text-red-500 error">{{ $message }}</span><br> @enderror
        <br>
    @endforeach
    <br>    
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update</button> 
</form>