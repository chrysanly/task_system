<div>
    <div class="mb-3 mt-2">
        <input wire:model='search' type="text" class="form-control" aria-describedby="helpId" placeholder="Search" />
        <small id="helpId" class="form-text text-muted">Search by Description</small>
    </div>

    @if (session()->has('success'))
        <p class="alert alert-success"><b>Success:</b> {{ session('success') }} </p>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->description }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', ['task' => $item->id]) }}" class="btn btn-primary">EDIT</a>
                        <a wire:click.prevent='selectId({{ $item->id }})' data-bs-toggle="modal"
                            data-bs-target="#exampleModal" class="btn btn-danger">Delete</a>
                        @if ($item->is_completed === 0)
                            <a wire:click.prevent='completed({{ $item->id }})' class="btn btn-secondary">
                                Complete
                            </a>
                        @endif

                    </td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
    {{ $tasks->links() }}

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this task?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button wire:click.prevent='destroy' type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
