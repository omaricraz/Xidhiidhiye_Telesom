<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Team Performance Report</title>
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
        .productivity-score {
            font-weight: bold;
            font-size: 14px;
        }
        .completion-rate-high {
            color: #28a745;
            font-weight: bold;
        }
        .completion-rate-medium {
            color: #ffc107;
            font-weight: bold;
        }
        .completion-rate-low {
            color: #dc3545;
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
        <h1>Team Performance Report</h1>
        <p>Generated on: {{ date('F d, Y h:i A') }}</p>
        <p>Period: {{ date('M d, Y', strtotime($dateFrom)) }} to {{ date('M d, Y', strtotime($dateTo)) }}</p>
    </div>

    <div style="margin-bottom: 20px; padding: 15px; background-color: #f5f5f5; border-radius: 5px;">
        <h3 style="margin-top: 0; color: #333;">Report Overview</h3>
        <p style="color: #666; margin-bottom: 0;">This report analyzes team performance metrics including task completion rates, learning goal achievements, and overall productivity scores. The Productivity Score is calculated based on task completion rates and learning goal completion.</p>
    </div>

    <div style="margin-top: 20px; margin-bottom: 15px;">
        <h3 style="color: #333; border-bottom: 2px solid #333; padding-bottom: 5px;">Team Performance Metrics</h3>
        <p style="color: #666; margin-top: 5px;">Comprehensive performance data for each team including member count, task metrics, learning progress, and calculated productivity scores. Teams are sorted by productivity score (highest first).</p>
        <p style="color: #999; font-size: 11px; margin-top: 5px; margin-bottom: 0;">
            <strong>Column Descriptions:</strong> Team Name - Name of the team | Team Lead - Name of the team leader | Members - Number of team members | 
            Total Tasks - Total tasks assigned to team members in the period | Completed Tasks - Number of tasks completed | Completion Rate - Percentage of tasks completed | 
            Total Goals - Number of learning goals assigned to the team | Completed Goals - Number of learning goals completed by team members | 
            Questions Asked - Number of questions posted by team members | Productivity Score - Calculated score (0-100) based on task completion and learning goal progress
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Team Name</th>
                <th>Team Lead</th>
                <th>Members</th>
                <th>Total Tasks</th>
                <th>Completed Tasks</th>
                <th>Completion Rate (%)</th>
                <th>Total Goals</th>
                <th>Completed Goals</th>
                <th>Questions Asked</th>
                <th>Productivity Score</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teamPerformanceData as $team)
            <tr>
                <td><strong>{{ $team['team']->name }}</strong></td>
                <td>{{ $team['team']->lead ? $team['team']->lead->name : 'N/A' }}</td>
                <td>{{ $team['member_count'] }}</td>
                <td>{{ $team['total_tasks'] }}</td>
                <td>{{ $team['completed_tasks'] }}</td>
                <td class="completion-rate-{{ $team['completion_rate'] >= 80 ? 'high' : ($team['completion_rate'] >= 50 ? 'medium' : 'low') }}">
                    {{ $team['completion_rate'] }}%
                </td>
                <td>{{ $team['total_goals'] }}</td>
                <td>{{ $team['completed_goals'] }}</td>
                <td>{{ $team['questions_asked'] }}</td>
                <td class="productivity-score">{{ number_format($team['productivity_score'], 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 20px;">No team performance data found for the selected period.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the system.</p>
    </div>
</body>
</html>
