<!DOCTYPE html>
<html>
<head>
    <title>Tarea de Alta Prioridad</title>
</head>
<body>
    <h1>¡Tarea de Alta Prioridad Asignada!</h1>
    <p>Se te ha asignado una tarea con prioridad alta:</p>
    <ul>
        <li><strong>Título:</strong> {{ $task->title }}</li>
        <li><strong>Descripción:</strong> {{ $task->description }}</li>
        <li><strong>Fecha límite:</strong> {{ $task->due_date }}</li>
    </ul>
</body>
</html>
