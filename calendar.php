<?php
session_start();
require "includes/database_connect.php";
if (!isset($_SESSION['user_id'])) {
    header("location: home.php");
    exit(); // Always exit after a header redirect
}
$user_id = $_SESSION['user_id'];

// We still need the subjects for the dropdown
$sql = "SELECT * FROM subjects WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$subjects = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Calendar</title>
    <?php include "includes/head_links.php"; ?>
    <link rel="stylesheet" href="css/calendar.css">
</head>
<body class="bg-slate-100 font-sans">

    <div class="flex h-screen">
        <aside class="w-80 bg-white p-6 shadow-lg flex flex-col">
            <h1 class="text-2xl font-bold text-gray-800 mb-8">Attendance Tracker</h1>
            
            <div class="mb-6">
                <label for="subjectSelect" class="block mb-2 text-sm font-semibold text-gray-700">Subject</label>
                <select id="subjectSelect" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                    <option value="">Select a subject</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= htmlspecialchars($subject['id']) ?>"><?= htmlspecialchars($subject['subject_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex-grow"></div>

            <div>
                <h3 class="font-semibold text-gray-700 mb-3">Legend</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center"><span class="h-4 w-4 rounded-full bg-green-500 mr-3"></span> Present</li>
                    <li class="flex items-center"><span class="h-4 w-4 rounded-full bg-red-500 mr-3"></span> Absent</li>
                    <li class="flex items-center"><span class="h-4 w-4 rounded-full bg-yellow-400 mr-3"></span> Late / Half-day</li>
                    <li class="flex items-center"><span class="h-4 w-4 rounded-full bg-gray-400 mr-3"></span> Holiday / No Class</li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8 overflow-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 id="currentMonthYear" class="text-3xl font-bold text-gray-800"></h2>
                <div class="flex items-center space-x-2">
                    <button id="prevMonth" class="p-2 rounded-full hover:bg-gray-200 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button id="todayBtn" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">Today</button>
                    <button id="nextMonth" class="p-2 rounded-full hover:bg-gray-200 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <div id="calendar" class="grid grid-cols-7 gap-1">
                </div>
        </main>
    </div>

    <div id="attendanceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden transition-opacity duration-300">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300">
            <h3 class="text-lg font-bold mb-4" id="modalDate"></h3>
            <div class="space-y-3">
                <button data-status="present" class="modal-option-btn w-full text-left p-3 rounded-md bg-green-100 text-green-800 hover:bg-green-200">Mark as Present</button>
                <button data-status="absent" class="modal-option-btn w-full text-left p-3 rounded-md bg-red-100 text-red-800 hover:bg-red-200">Mark as Absent</button>
                <button data-status="late" class="modal-option-btn w-full text-left p-3 rounded-md bg-yellow-100 text-yellow-800 hover:bg-yellow-200">Mark as Late / Half-day</button>
                <button data-status="holiday" class="modal-option-btn w-full text-left p-3 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300">Mark as Holiday</button>
            </div>
            <button id="closeModal" class="mt-6 w-full py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">Close</button>
        </div>
    </div>
    
    <script src="js/calendar.js"></script>
</body>
</html>