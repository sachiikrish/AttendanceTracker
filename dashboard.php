<?php
require "includes/database_connect.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <?php
    include "includes/head_links.php";
    ?>
    <title>Dashbaord</title>
</head>

<body class="bg-gray-300">
    <?php
    include "includes/header.php";
    ?>
    <div class="content pt-[12rem] h-100 bg-[url('../img/bg2.jpg')] bg-cover bg-centre fixed-bg">
        <h1 class="font-bold text-gray-600 text-center">Welcome, <?= $_SESSION['name'] ?>!</h1>

        <?php
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM subjects where user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Something went wrong!!";
            return;
        }
        $row_count = mysqli_num_rows($result);
        if ($row_count == 0) {
            ?>
            <div class="button-container">
                <button type="button" data-modal-target="subjects-modal" data-modal-toggle="subjects-modal"
                    class=" transition ease-in-out delay-150 bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 border text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Set
                    up your subjects</button>
            </div>
            <?php
        } else {
            ?>
            <div id="content" class="flex mt-10">
                <?php
                $sql_2 = "SELECT * FROM classes where user_id = '$user_id'";
                $result_2 = mysqli_query($conn, $sql_2);
                $count = mysqli_num_rows($result_2);
                if ($count == 5) {
                    ?>
                    <div id="chart" class="mt-10 w-1/2">
                        <?php
                        include "chart.php";
                        ?>
                    </div>
                    <div class="w-1/2">
                        <div class="button-container">
                            <button type="button" data-modal-target="attendance_form-modal"
                                data-modal-toggle="attendance_form-modal"
                                class=" transition ease-in-out delay-150 bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 border text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Mark
                                your attendance</button>
                            <a href="attendance.php"><button type="button"
                                    class=" transition ease-in-out delay-150 bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 border text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">See
                                    your attendance</button></a>
                        </div>
                        <div id="calendar_button" class="flex justify-center mt-10">
                            <a href="calendar.php"
                                class=" transition ease-in-out delay-150 bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 border text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><button
                                    type="button">Calendar</button></a>
                        </div>
                    </div>
                </div>
                <?php
                } else {
                    ?>
                <div class="w-full">
                    <div class="button-container">
                        <button type="button" data-modal-target="attendance_form-modal"
                            data-modal-toggle="attendance_form-modal"
                            class=" transition ease-in-out delay-150 bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 border text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Mark
                            your attendance</button>
                        <a href="attendance.php"><button type="button"
                                class=" transition ease-in-out delay-150 bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 border text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">See
                                your attendance</button></a>
                    </div>
                    <div id="calendar_button" class="flex justify-center mt-10">
                        <a href="calendar.php"
                            class=" transition ease-in-out delay-150 bg-blue-500 hover:-translate-y-1 hover:scale-110 hover:bg-indigo-500 duration-300 border text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><button
                                type="button">Calendar</button></a>
                    </div>
                </div>
            </div>

            <?php
                }
        }
        ?>

    </div>
    <?php
    $sql_2 = "SELECT * from subjects where user_id = '$user_id'";
    $result_2 = mysqli_query($conn, $sql_2);
    if (!$result_2) {
        echo json_encode(array("success" => false, "message" => "Something went wrong!"));
        exit;
    }
    $subjects = mysqli_fetch_all($result_2, MYSQLI_ASSOC);
    mysqli_close($conn);
    ?>
    <!-- Marking attendance form modal -->
    <div id="attendance_form-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div
                class="relative bg-white/95 rounded-2xl shadow-xl dark:bg-gray-900/95 border border-gray-100 dark:border-gray-800">
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200/70 rounded-t-2xl dark:border-gray-700/70">
                    <h3
                        class="text-3xl font-extrabold text-gray-900 dark:text-white leading-tight flex items-center gap-3">
                        <svg class="w-8 h-8 text-amber-500" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Mark Attendance
                    </h3>
                    <button type="button"
                        class="text-gray-600 bg-transparent hover:bg-gray-100/70 hover:text-gray-900 rounded-full text-lg p-2 flex justify-center items-center transition-all duration-300 dark:hover:bg-gray-700/70 dark:hover:text-white"
                        data-modal-hide="attendance_form-modal">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-8">
                    <form class="space-y-6" action="includes/mark_attendance.php" method="post">
                        <div>
                            <label for="subject_name_select"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Subject</label>
                            <select id="subject_name_select" name="subject_id"
                                class="bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-gray-700/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 transition-all duration-200"
                                required>
                                <option selected disabled>Choose a subject</option>
                                <?php
                                // Ensure $subjects is defined before this loop
                                // It should be passed from your PHP logic
                                if (isset($subjects) && is_array($subjects)) {
                                    foreach ($subjects as $subject) {
                                        ?>
                                        <option value="<?= $subject['id'] ?>"><?= $subject['subject_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="date"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Date</label>
                            <input type="date" name="date" id="date"
                                class="bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-gray-700/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 transition-all duration-200"
                                required />
                        </div>
                        <div>
                            <label for="status"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Your
                                Status</label>
                            <select id="status" name="status"
                                class="bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-gray-700/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 transition-all duration-200"
                                required>
                                <option selected disabled>Select Status</option>
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="no class">No class</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-bold rounded-lg text-lg px-6 py-3.5 text-center dark:bg-amber-400 dark:hover:bg-amber-500 dark:focus:ring-amber-800 transition transform hover:scale-105 duration-300 ease-in-out shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6.267 15.408a13.935 13.935 0 011.042-2.827c.18-.535.28-.636.368-1.258l.102-.635a1.867 1.867 0 011.048-1.048l.635-.102c.622-.088.723-.188 1.258-.368a13.936 13.936 0 012.827-1.042c.535-.18.636-.28 1.258-.368l.635-.102a1.867 1.867 0 011.048-1.048l.102-.635c.088-.622.188-.723.368-1.258a13.936 13.936 0 011.042-2.827c.18-.535.28-.636.368-1.258l.102-.635a1.867 1.867 0 011.048-1.048l.635-.102c.622-.088.723-.188 1.258-.368a13.936 13.936 0 012.827-1.042z"
                                    clip-rule="evenodd"></path>
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z" />
                            </svg>
                            Mark Attendance
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

  <!-- Subject setting form -->
    <div id="subjects-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div
                class="relative bg-white/95 rounded-2xl shadow-xl dark:bg-gray-900/95 border border-gray-100 dark:border-gray-800">
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200/70 rounded-t-2xl dark:border-gray-700/70">
                    <h3
                        class="text-3xl font-extrabold text-gray-900 dark:text-white leading-tight flex items-center gap-3">
                        <svg class="w-8 h-8 text-amber-500" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.414L14.586 5A2 2 0 0115 5.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 10a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1-3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Manage Subjects
                    </h3>
                    <button type="button"
                        class="text-gray-600 bg-transparent hover:bg-gray-100/70 hover:text-gray-900 rounded-full text-lg p-2 flex justify-center items-center transition-all duration-300 dark:hover:bg-gray-700/70 dark:hover:text-white"
                        data-modal-hide="subjects-modal">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-8 pb-4">
                    <form id="subject_form" class="space-y-6" action="includes/setting_subjects.php" method="post">
                        <div id="subject-fields-container"
                            class="space-y-4 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                        </div>

                        <button type="button" id="add-subject-btn"
                            class="w-full border border-amber-500 text-amber-600 hover:bg-amber-50 focus:ring-4 focus:outline-none focus:ring-amber-200 font-semibold rounded-lg text-md px-5 py-2.5 text-center dark:border-amber-400 dark:text-amber-400 dark:hover:bg-gray-800 transition transform hover:scale-105 duration-300 ease-in-out flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Subject
                        </button>

                        <button type="submit"
                            class="w-full text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-bold rounded-lg text-lg px-6 py-3.5 text-center dark:bg-amber-400 dark:hover:bg-amber-500 dark:focus:ring-amber-800 transition transform hover:scale-105 duration-300 ease-in-out shadow-lg hover:shadow-xl mt-6">
                            Save Subjects
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const subjectContainer = document.getElementById('subject-fields-container');
                const addSubjectBtn = document.getElementById('add-subject-btn');
                let subjectCount = 0; // Start count for unique names/IDs

                // Function to create a new subject field group
                function createSubjectField(subjectName = '', numberOfClasses = '') {
                    subjectCount++;
                    const div = document.createElement('div');
                    div.classList.add('flex', 'flex-col', 'gap-2', 'p-4', 'border', 'border-gray-200', 'rounded-lg', 'bg-white/60', 'dark:bg-gray-800/60', 'relative', 'shadow-sm');

                    div.innerHTML = `
                    <button type="button" class="remove-subject-btn absolute top-2 right-2 text-gray-400 hover:text-red-600 transition-colors duration-200" title="Remove subject">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span class="sr-only">Remove subject</span>
                    </button>
                    <div>
                        <label for="subject_name_${subjectCount}" class="block mb-1 text-sm font-medium text-gray-800 dark:text-gray-200">Subject Name</label>
                        <input type="text" name="subjects[${subjectCount}][name]" id="subject_name_${subjectCount}" placeholder="e.g. Physics" value="${subjectName}" class="bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-gray-700/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200" required />
                    </div>
                    <div>
                        <label for="classes_${subjectCount}" class="block mb-1 text-sm font-medium text-gray-800 dark:text-gray-200">Number of Classes</label>
                        <input type="number" name="subjects[${subjectCount}][classes]" id="classes_${subjectCount}" placeholder="e.g. 60" value="${numberOfClasses}" class="bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-gray-700/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200" min="1" required />
                    </div>
                `;
                    subjectContainer.appendChild(div);


                    // Add event listener for the new remove button
                    div.querySelector('.remove-subject-btn').addEventListener('click', function () {
                        div.remove();
                    });
                }
              
                // Add event listener for the new remove button
                div.querySelector('.remove-subject-btn').addEventListener('click', function() {
                    div.remove();
                    updateFormValidation();

                });
            }
            // Make sure there's at least one subject field at all times
            function updateFormValidation() {
                // If there are no fields, add one automatically
                if (subjectContainer.children.length === 0) {
                    createSubjectField();
                    alert("At least one subject is required.");
                }
            }

            // Add initial subject field if none exists
            if (subjectContainer.children.length === 0) {
                createSubjectField(); // Start with one field
            }
           
            // Event listener for "Add New Subject" button
            addSubjectBtn.addEventListener('click', function() {
                createSubjectField();
                // Scroll to the bottom of the container to show the new field
                subjectContainer.scrollTop = subjectContainer.scrollHeight;
            });

            // Form submission validation
            document.getElementById('subject_form').addEventListener('submit', function(e) {
                if (subjectContainer.children.length === 0) {
                    e.preventDefault();
                    alert("Please add at least one subject before saving.");
                    createSubjectField();
                }
            });
        });
    </script>
    <style>
        /* Custom scrollbar for the subject container */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* gray-300 */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; /* gray-400 */
        }
        /* Dark mode scrollbar */
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #1f2937; /* gray-800 */
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563; /* gray-600 */
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6b7280; /* gray-500 */
        }
    </style>
</div>

    <?php
    include "includes/script.php";
    ?>

</body>
    
</html>
