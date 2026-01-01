<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Task Management Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .summary h3 {
            margin-top: 0;
            color: #333;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        .summary-item {
            text-align: center;
            padding: 10px;
            background-color: white;
            border-radius: 3px;
        }
        .summary-item strong {
            display: block;
            font-size: 24px;
            color: #333;
        }
        .summary-item span {
            color: #666;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-completed {
            color: #28a745;
            font-weight: bold;
        }
        .status-in-progress {
            color: #ffc107;
            font-weight: bold;
        }
        .status-pending {
            color: #dc3545;
            font-weight: bold;
        }
        .priority-high {
            color: #dc3545;
            font-weight: bold;
        }
        .priority-medium {
            color: #ffc107;
            font-weight: bold;
        }
        .priority-normal {
            color: #28a745;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Task Management Report</h1>
        <p>Generated on: {{ date('F d, Y h:i A') }}</p>
        <p>Period: {{ date('M d, Y', strtotime($dateFrom)) }} to {{ date('M d, Y', strtotime($dateTo)) }}</p>
    </div>

    <div class="summary">
        <h3>Summary Statistics</h3>
        <p style="color: #666; margin-bottom: 15px;">Overview of task metrics for the selected period showing total tasks, completion status, and progress indicators.</p>
        <div class="summary-grid">
            <div class="summary-item">
                <strong>{{ $totalTasks }}</strong>
                <span>Total Tasks</span>
            </div>
            <div class="summary-item">
                <strong>{{ $completedTasks }}</strong>
                <span>Completed</span>
            </div>
            <div class="summary-item">
                <strong>{{ $completionPercentage }}%</strong>
                <span>Completion Rate</span>
            </div>
            <div class="summary-item">
                <strong>{{ $inProgressTasks }}</strong>
                <span>In Progress</span>
            </div>
            <div class="summary-item">
                <strong>{{ $pendingTasks }}</strong>
                <span>Pending</span>
            </div>
        </div>
    </div>

    <div style="margin-top: 30px; margin-bottom: 15px;">
        <h3 style="color: #333; border-bottom: 2px solid #333; padding-bottom: 5px;">Detailed Task List</h3>
        <p style="color: #666; margin-top: 5px;">Complete list of all tasks with their current status, priority level, assigned team members, and creation dates.</p>
        <p style="color: #999; font-size: 11px; margin-top: 5px; margin-bottom: 0;">
            <strong>Column Descriptions:</strong> ID - Unique task identifier | Title - Task name and description | Status - Current task state (Pending, In Progress, Completed) | 
            Priority - Task urgency level (High, Medium, Normal) | Creator - User who created the task | Assignee - User assigned to complete the task | 
            Team - Team the assignee belongs to | Created At - Task creation date
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Creator</th>
                <th>Assignee</th>
                <th>Team</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ Str::limit($task->title, 40) }}</td>
                <td>
                    <span class="status-{{ strtolower(str_replace('_', '-', $task->status)) }}">
                        {{ $task->status }}
                    </span>
                </td>
                <td>
                    <span class="priority-{{ strtolower($task->priority) }}">
                        {{ $task->priority }}
                    </span>
                </td>
                <td>{{ $task->creator ? $task->creator->name : 'N/A' }}</td>
                <td>{{ $task->assignee ? $task->assignee->name : 'Unassigned' }}</td>
                <td>{{ $task->assignee && $task->assignee->team ? $task->assignee->team->name : 'N/A' }}</td>
                <td>{{ $task->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">No tasks found for the selected period.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the system.</p>
    </div>
</body>
</html>

