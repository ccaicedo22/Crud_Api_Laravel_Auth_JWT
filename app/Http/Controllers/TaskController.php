<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Asegúrate de importar el modelo de Task
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks();

        // Filtrar por estado si se proporciona
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filtrar por prioridad si se proporciona
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // Paginación de los resultados
        $tasks = $query->paginate(10);

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pendiente,en progreso,completada',
            'priority' => 'nullable|in:baja,media,alta',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear una nueva tarea
        $task = auth()->user()->tasks()->create($validator->validated());

        return response()->json($task, 201);
    }

    public function show($id)
    {
        // Obtener una tarea específica del usuario autenticado
        $task = auth()->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pendiente,en progreso,completada',
            'priority' => 'nullable|in:baja,media,alta', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualizar la tarea
        $task = auth()->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        $task->update($validator->validated());

        return response()->json($task);
    }

    public function destroy($id)
    {
        // Eliminar una tarea específica del usuario autenticado
        $task = auth()->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Tarea eliminada exitosamente']);
    }
}

