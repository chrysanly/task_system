<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;

class Table extends Component
{
    public $search;
    public $taskId;
    public function render()
    {
        $tasks = Task::when($this->search !== '', function($q){
            $q->where('description', 'like','%'.$this->search.'%');
        })->where('user_id', auth()->id())->orderBy("created_at", "desc")->paginate(10);
        return view('livewire.tasks.table', compact("tasks"));
    }
    
    public function selectId(int $id)
    {
        $this->taskId = $id;
    }
    public function destroy()
    {
        Task::destroy($this->taskId);
        $this->dispatchBrowserEvent("close-modal");
        session()->flash("success","Task Deleted");
    }
    public function completed(Task $task)
    {
        $task->update([
            'is_completed' => $task->is_completed === 0 ? 1: 0,
        ]);
        session()->flash("success", "Task marked as completed");
    }
}
