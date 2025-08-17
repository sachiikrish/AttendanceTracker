<?php
require "includes/database_connect.php";
session_start();
if (isset($_SESSION['user_id'])) {
    header("location: dashboard.php");
    exit; // Always add exit after header redirects
}
if (isset($_SESSION['admin_id'])) {
    header("location: admin.php");
    exit; // Always add exit after header redirects
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php
    include "includes/head_links.php";
    ?>
    <link rel="stylesheet" href="css/home.css" />
    <title>Attendance Tracker</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- jQuery (must be loaded before toastr.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


</head>

<body>
    <?php
    include "includes/header.php";
    ?>

    <div id="bg" class="bg-[url('../img/bg.avif')] bg-cover bg-center fixed-bg">
        <div id="box" class="h-screen flex items-center justify-center">
            <span class="overline text-4xl text-white font-bold mb-10">Effortless Attendance Management at Your
                Fingertips</span>
            <div id="login_buttons" class="flex justify-center">
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <i class="fa fa-user-circle"></i> Login as User
                </button>
                <button data-modal-target="admin-modal" data-modal-toggle="admin-modal" type="button"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <i class="fa fa-lock"></i> Admin Login
                </button>
            </div>
        </div>
    </div>

    <?php include "includes/modals.php"; ?>

    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div
                class="relative bg-white/95 rounded-2xl shadow-xl dark:bg-gray-900/95 border border-gray-100 dark:border-gray-800">
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200/70 rounded-t-2xl dark:border-gray-700/70">
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                        Welcome Back!
                    </h3>
                    <button type="button"
                        class="text-gray-600 bg-transparent hover:bg-gray-100/70 hover:text-gray-900 rounded-full text-lg p-2 flex justify-center items-center transition-all duration-300 dark:hover:bg-gray-700/70 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-8">
                    <form id="login_form" class="space-y-6" action="includes/login.php" method="post">
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Your
                                Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200"
                                placeholder="name@example.com" required />
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Your
                                Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="password-input bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200"
                                    required />
                                <svg class="toggle-password absolute right-3 top-3 cursor-pointer w-5 h-5 text-gray-600 dark:text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z
                                    M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.478 0 8.268 2.943 9.542 7
                                    c-1.274 4.057-5.064 7-9.542 7
                                    c-4.478 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a href="#"
                                class="text-sm text-amber-600 hover:text-amber-700 hover:underline dark:text-amber-500 dark:hover:text-amber-600 transition-colors duration-200">Forgot
                                password?</a>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-bold rounded-lg text-lg px-6 py-3.5 text-center dark:bg-amber-400 dark:hover:bg-amber-500 dark:focus:ring-amber-800 transition transform hover:scale-105 duration-300 ease-in-out shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 2a5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2V7a5 5 0 00-5-5zm-3 7v2h6V9a3 3 0 00-6 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Log In
                        </button>

                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 text-center mt-6">
                            Not registered? <a href="#"
                                class="font-bold text-amber-600 hover:text-amber-700 hover:underline dark:text-amber-500 dark:hover:text-amber-600 transition-colors duration-200">Create
                                account</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="admin-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div
                class="relative bg-white/95 rounded-2xl shadow-xl dark:bg-gray-900/95 border border-gray-100 dark:border-gray-800">
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200/70 rounded-t-2xl dark:border-gray-700/70">
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                        Admin Login
                    </h3>
                    <button type="button"
                        class="text-gray-600 bg-transparent hover:bg-gray-100/70 hover:text-gray-900 rounded-full text-lg p-2 flex justify-center items-center transition-all duration-300 dark:hover:bg-gray-700/70 dark:hover:text-white"
                        data-modal-hide="admin-modal">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-8">
                    <form id="admin_form" class="space-y-6" action="includes/admin_login.php" method="post">
                        <div>
                            <label for="admin_email"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Admin
                                Email</label>
                            <input type="email" name="admin_email" id="admin_email"
                                class="bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200"
                                placeholder="admin@example.com" required />
                        </div>
                        <div>
                            <label for="admin_password"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Admin
                                Password</label>
                            <div class="relative">
                                <input type="password" name="admin_password" id="admin_password" placeholder="••••••••"
                                    class="password-input bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200"
                                    required />
                                <svg class="toggle-password absolute right-3 top-3 cursor-pointer w-5 h-5 text-gray-600 dark:text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z
                                    M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.478 0 8.268 2.943 9.542 7
                                    c-1.274 4.057-5.064 7-9.542 7
                                    c-4.478 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-bold rounded-lg text-lg px-6 py-3.5 text-center dark:bg-amber-400 dark:hover:bg-amber-500 dark:focus:ring-amber-800 transition transform hover:scale-105 duration-300 ease-in-out shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 2a5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2V7a5 5 0 00-5-5zm-3 7v2h6V9a3 3 0 00-6 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Admin Log In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="signup-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div
                class="relative bg-white/95 rounded-2xl shadow-xl dark:bg-gray-900/95 border border-gray-100 dark:border-gray-800">
                <div
                    class="flex items-center justify-between p-6 border-b border-gray-200/70 rounded-t-2xl dark:border-gray-700/70">
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                        Join Our Community
                    </h3>
                    <button type="button"
                        class="text-gray-600 bg-transparent hover:bg-gray-100/70 hover:text-gray-900 rounded-full text-lg p-2 flex justify-center items-center transition-all duration-300 dark:hover:bg-gray-700/70 dark:hover:text-white"
                        data-modal-hide="signup-modal">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-8">
                    <form id="signup_form" class="space-y-6" action="includes/signup.php" method="post">
                        <div>
                            <label for="name"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Your
                                Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200"
                                placeholder="John Doe" required />
                        </div>
                        <div>
                            <label for="email"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Your
                                Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200"
                                placeholder="name@example.com" required />
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Your
                                Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="password-input bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200"
                                    required />
                                <svg class="toggle-password absolute right-3 top-3 cursor-pointer w-5 h-5 text-gray-600 dark:text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z
                                    M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.478 0 8.268 2.943 9.542 7
                                    c-1.274 4.057-5.064 7-9.542 7
                                    c-4.478 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label for="confirm-password"
                                class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-200">Confirm
                                Password</label>
                            <div class="relative">
                                <input type="password" name="confirm-password" id="confirm-password" placeholder="••••••••"
                                    class="password-input bg-white/70 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800/70 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white/90 placeholder:text-gray-500/80 transition-all duration-200"
                                    required />
                                <svg class="toggle-password absolute right-3 top-3 cursor-pointer w-5 h-5 text-gray-600 dark:text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z
                                    M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.478 0 8.268 2.943 9.542 7
                                    c-1.274 4.057-5.064 7-9.542 7
                                    c-4.478 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-bold rounded-lg text-lg px-6 py-3.5 text-center dark:bg-amber-400 dark:hover:bg-amber-500 dark:focus:ring-amber-800 transition transform hover:scale-105 duration-300 ease-in-out shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Sign Up Now
                        </button>

                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 text-center mt-6">
                            Already a member? <a href="#"
                                class="font-bold text-amber-600 hover:text-amber-700 hover:underline dark:text-amber-500 dark:hover:text-amber-600 transition-colors duration-200">Log
                                in</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll(".toggle-password").forEach((icon) => {
            icon.addEventListener("click", () => {
                const input = icon.previousElementSibling; // Gets the input field right before the icon

                if (input.type === "password") {
                    input.type = "text";
                    // Update the SVG icon to show "eye-slash" (password visible)
                    icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3l18 18M9.88 9.88A3 3 0 0012 15
                    a3 3 0 002.12-.88m2.681-2.681
                    A8.969 8.969 0 0121.542 12
                    c-1.274 4.057-5.064 7-9.542 7
                    a8.963 8.963 0 01-6.34-2.659
                    M6.623 6.623A8.963 8.963 0 013.458 12" />
            `;
                } else {
                    input.type = "password";
                    // Update the SVG icon to show "eye" (password hidden)
                    icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z
                  M2.458 12C3.732 7.943 7.523 5 12 5
                  c4.478 0 8.268 2.943 9.542 7
                  c-1.274 4.057-5.064 7-9.542 7
                  c-4.478 0-8.268-2.943-9.542-7z"
                  />
            `;
                }
            });
        });
    </script>
    <?php include "includes/script.php"; ?>

    <script>
        $('#login_form').submit(function (e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                url: 'includes/login.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || "Login successful!");
                        setTimeout(() => {
                            window.location.href = "dashboard.php";
                        }, 1200);
                    } else {
                        toastr.error(response.message || "Login failed. Please try again.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log("Server response:", xhr.responseText);
                    toastr.error("An error occurred: " + error);
                }
            });
        });
    </script>


    <script>
        $('#signup_form').submit(function (e) {
            e.preventDefault();

            const password = $('#signup-password').val();
            const confirmPassword = $('#confirm-password').val();

            if (password !== confirmPassword) {
                toastr.error("Passwords do not match. Please try again.");
                return;
            }

            const formData = $(this).serialize();

            $.ajax({
                url: 'includes/signup.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || "Signup successful!");
                        setTimeout(() => {
                            window.location.href = "index.php";
                        }, 1500);
                    } else {
                        toastr.error(response.message || "Signup failed. Please try again.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log("Server response:", xhr.responseText);
                    toastr.error("An error occurred: " + error);
                }
            });
        });

    </script>

</body>

</html>
