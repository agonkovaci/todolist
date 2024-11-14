<?php
namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->all();  // Get the data, no need to validate here since validation is in the service

        try {
            $this->taskService->createTask($validated);
            return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $task = $this->taskService->getTaskById($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->all();  // Get the data, no need to validate here since validation is in the service

        try {
            $this->taskService->updateTask($id, $validated);
            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->taskService->deleteTask($id);
            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function filter(Request $request)
    {
        $status = $request->get('status');
        $priority = $request->get('priority');
        $tasks = $this->taskService->filterTasks($status, $priority);
        return view('tasks.index', compact('tasks'));
    }
}
