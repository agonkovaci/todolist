<?php
namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaskService
{
    // Create a task
    /**
     * @throws ValidationException
     */
    public function createTask($data)
    {
        $this->validateTask($data);  // Perform validation

        $data['user_id'] = Auth::id();  // Ensure the task is linked to the authenticated user
        return Task::create($data);
    }

    // Update a task

    /**
     * @throws ValidationException
     */
    public function updateTask($taskId, $data)
    {
        $this->validateTask($data);  // Perform validation

        $task = Task::findOrFail($taskId);
        if ($task->user_id !== Auth::id()) {
            throw new \RuntimeException("Unauthorized action");
        }
        $task->update($data);
        return $task;
    }

    // Delete a task
    public function deleteTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        if ($task->user_id !== Auth::id()) {
            throw new \RuntimeException("Unauthorized action");
        }
        $task->delete();
        return true;
    }

    // Get all tasks for the authenticated user
    public function getAllTasks()
    {
        return Task::where('user_id', Auth::id())->get();
    }

    // Get a task by ID for the authenticated user
    public function getTaskById($taskId)
    {
        return Task::where('user_id', Auth::id())->findOrFail($taskId);
    }

    // Filter tasks by status and/or priority
    public function filterTasks($status = null, $priority = null)
    {
        $query = Task::where('user_id', Auth::id());

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($priority !== null) {
            $query->where('priority', $priority);
        }

        return $query->get();
    }

    // Helper method to validate task data

    /**
     * @throws ValidationException
     */
    private function validateTask($data): void
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'nullable|in:1,2,3',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}

