document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const currentMonthYearEl = document.getElementById('currentMonthYear');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const todayBtn = document.getElementById('todayBtn');
    const subjectSelect = document.getElementById('subjectSelect');
    const modal = document.getElementById('attendanceModal');
    const closeModalBtn = document.getElementById('closeModal');
    const modalDateEl = document.getElementById('modalDate');

    let currentDate = new Date();
    let selectedDate = null;

    const renderCalendar = async () => {
        calendarEl.style.opacity = '0.5'; // For smooth transition
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const subjectId = subjectSelect.value;

        // Display current month and year
        currentMonthYearEl.textContent = new Intl.DateTimeFormat('en-US', { month: 'long', year: 'numeric' }).format(currentDate);

        // Fetch attendance data for the current view
        const attendanceData = subjectId ? await fetchAttendanceData(subjectId, year, month + 1) : {};

        // Clear previous calendar
        calendarEl.innerHTML = '';

        // Add day of the week headers
        const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        daysOfWeek.forEach(day => {
            const dayEl = document.createElement('div');
            dayEl.className = 'text-center font-semibold text-gray-600 text-sm py-2';
            dayEl.textContent = day;
            calendarEl.appendChild(dayEl);
        });

        // Calculate calendar grid days
        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        // Add empty cells for days before the 1st
        for (let i = 0; i < firstDayOfMonth; i++) {
            calendarEl.appendChild(document.createElement('div'));
        }
        
        // Add date cells
        for (let day = 1; day <= daysInMonth; day++) {
            const dayEl = document.createElement('div');
            const date = new Date(year, month, day);
            const dateString = date.toISOString().split('T')[0]; // YYYY-MM-DD
            
            dayEl.className = 'calendar-day relative p-2 h-28 border border-gray-200 bg-white rounded-md cursor-pointer';
            dayEl.dataset.date = dateString;

            // Date number
            const numberEl = document.createElement('span');
            numberEl.className = 'text-sm font-semibold text-gray-700';
            numberEl.textContent = day;
            dayEl.appendChild(numberEl);

            // Highlight Today
            if (dateString === new Date().toISOString().split('T')[0]) {
                numberEl.classList.add('bg-blue-500', 'text-white', 'rounded-full', 'w-6', 'h-6', 'flex', 'items-center', 'justify-center');
            }

            // Add attendance status dot if data exists
            if (attendanceData[dateString]) {
                const statusDot = document.createElement('div');
                const status = attendanceData[dateString];
                statusDot.className = 'absolute bottom-2 right-2 h-3 w-3 rounded-full';
                if (status === 'present') statusDot.classList.add('bg-green-500');
                else if (status === 'absent') statusDot.classList.add('bg-red-500');
                else if (status === 'late') statusDot.classList.add('bg-yellow-400');
                else if (status === 'holiday') statusDot.classList.add('bg-gray-400');
                dayEl.appendChild(statusDot);
            }

            calendarEl.appendChild(dayEl);
        }
        calendarEl.style.opacity = '1';
    };

    // --- Mock/API Functions ---

    // Fetches attendance data from the server
    async function fetchAttendanceData(subjectId, year, month) {
        try {
            // In a real app, you would have a PHP endpoint for this
            // const response = await fetch(`api/get_attendance.php?subject_id=${subjectId}&year=${year}&month=${month}`);
            // const data = await response.json();
            // return data;

            // For demonstration, we'll use MOCK data. Replace this with a real fetch call.
            console.log(`Fetching data for Subject: ${subjectId}, Year: ${year}, Month: ${month}`);
            const mockData = {
                '2024-08-01': 'present',
                '2024-08-02': 'present',
                '2024-08-05': 'absent',
                '2024-08-07': 'present',
                '2024-08-08': 'late',
                '2024-08-15': 'holiday',
            };
            // This filters mock data for the current month and year to simulate a real API call
            const currentMonthData = {};
            const datePrefix = `${year}-${String(month).padStart(2, '0')}`;
            for (const date in mockData) {
                if (date.startsWith(datePrefix)) {
                    currentMonthData[date] = mockData[date];
                }
            }
            return currentMonthData;

        } catch (error) {
            console.error('Error fetching attendance data:', error);
            return {};
        }
    }
    
    // Saves attendance data to the server
    async function saveAttendanceData(subjectId, date, status) {
        // In a real app, you would post this data to a PHP endpoint
        // await fetch('api/save_attendance.php', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify({ subject_id: subjectId, date, status })
        // });
        console.log(`Saving... Subject: ${subjectId}, Date: ${date}, Status: ${status}`);
        
        // After saving, re-render the calendar to show the update
        renderCalendar();
    }

    // --- Event Listeners ---

    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    todayBtn.addEventListener('click', () => {
        currentDate = new Date();
        renderCalendar();
    });
    
    subjectSelect.addEventListener('change', renderCalendar);
    
    // Event listener for clicking on a date cell (uses event delegation)
    calendarEl.addEventListener('click', (e) => {
        const dayEl = e.target.closest('.calendar-day');
        if (dayEl && subjectSelect.value) {
            selectedDate = dayEl.dataset.date;
            modalDateEl.textContent = new Date(selectedDate + 'T00:00:00').toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            modal.classList.remove('hidden');
        } else if (!subjectSelect.value) {
            alert('Please select a subject first.');
        }
    });
    
    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Event listener for modal status buttons
    modal.addEventListener('click', (e) => {
        if (e.target.matches('.modal-option-btn')) {
            const status = e.target.dataset.status;
            saveAttendanceData(subjectSelect.value, selectedDate, status);
            modal.classList.add('hidden');
        }
    });

    // Initial render
    renderCalendar();
});