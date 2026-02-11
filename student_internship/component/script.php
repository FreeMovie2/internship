
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
<script src="js/adminlte.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const selectButton = document.getElementById("customSelectButton");
        const dropdown = document.getElementById("customDropdown");
        const searchInput = document.getElementById("dropdownSearch");
        const hiddenInput = document.getElementById("selectedTeacherId"); // For storing selected value


        // Toggle dropdown visibility
        selectButton.addEventListener("click", () => {
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });

        // Select an option
        dropdown.addEventListener("click", (e) => {
            if (e.target.classList.contains("dropdown-item")) {
                selectButton.textContent = e.target.textContent;
                selectButton.dataset.value = e.target.dataset.value;
                hiddenInput.value = e.target.dataset.value; // Store selected value in hidden input
                dropdown.style.display = "none";

                // Highlight selected option
                dropdown.querySelectorAll(".dropdown-item").forEach((item) => {
                    item.classList.remove("selected");
                });
                e.target.classList.add("selected");
            }
        });

        // Filter dropdown options
        searchInput.addEventListener("input", () => {
            const filter = searchInput.value.toLowerCase();
            const items = dropdown.querySelectorAll(".dropdown-item");

            items.forEach((item) => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "" : "none";
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!selectButton.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = "none";
            }
        });

        // Clear selection
        clearButton.addEventListener("click", () => {
            selectButton.textContent = "เลือกชื่อครูที่ปรึกษา";
            selectButton.dataset.value = "";
            hiddenInput.value = "";
            dropdown.querySelectorAll(".dropdown-item").forEach((item) => {
                item.classList.remove("selected");
            });
        });

        // Toggle text input based on checkbox
        window.toggleInput = (checkbox, inputId) => {
            const input = document.getElementById(inputId);
            if (checkbox.checked) {
                input.disabled = false; // Enable input if checkbox is checked
            } else {
                input.disabled = true; // Disable input if checkbox is unchecked
                input.value = ""; // Clear the input value
            }
        };
    });



    document.addEventListener("DOMContentLoaded", () => {
        const selectButton2 = document.getElementById("customSelectButton2");
        const dropdown2 = document.getElementById("customDropdown2");
        const searchInput2 = document.getElementById("dropdownSearch2");
        const hiddenInput2 = document.getElementById("selectedTeacherId2"); // For storing selected value
        const clearButton = document.createElement("button"); // Clear button

        // Create Clear Button
        // clearButton.textContent = "ล้างค่า";
        // clearButton.type = "button";
        // clearButton.style.marginLeft = "10px";
        // clearButton.classList.add("btn", "btn-secondary", "btn-sm");
        // selectButton2.parentElement.appendChild(clearButton);

        // Toggle dropdown visibility
        selectButton2.addEventListener("click", () => {
            dropdown2.style.display = dropdown2.style.display === "block" ? "none" : "block";
        });

        // Select an option
        dropdown2.addEventListener("click", (e) => {
            if (e.target.classList.contains("dropdown-item2")) {
                selectButton2.textContent = e.target.textContent;
                selectButton2.dataset.value = e.target.dataset.value;
                hiddenInput2.value = e.target.dataset.value; // Store selected value in hidden input
                dropdown2.style.display = "none";

                // Highlight selected option
                dropdown2.querySelectorAll(".dropdown-item2").forEach((item) => {
                    item.classList.remove("selected");
                });
                e.target.classList.add("selected");
            }
        });

        // Filter dropdown options
        searchInput2.addEventListener("input", () => {
            const filter2 = searchInput2.value.toLowerCase();
            const items2 = dropdown2.querySelectorAll(".dropdown-item2");

            items2.forEach((item) => {
                const text2 = item.textContent.toLowerCase();
                item.style.display = text2.includes(filter2) ? "" : "none";
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!selectButton2.contains(e.target) && !dropdown2.contains(e.target)) {
                dropdown2.style.display = "none";
            }
        });

        // Clear selection
        clearButton.addEventListener("click", () => {
            selectButton2.textContent = "เลือกชื่อครูนิเทศ";
            selectButton2.dataset.value = "";
            hiddenInput2.value = "";
            dropdown2.querySelectorAll(".dropdown-item2").forEach((item) => {
                item.classList.remove("selected");
            });
        });

        // Toggle text input based on checkbox
        window.toggleInput = (checkbox, inputId) => {
            const input2 = document.getElementById(inputId);
            if (checkbox.checked) {
                input2.disabled = false; // Enable input if checkbox is checked
            } else {
                input2.disabled = true; // Disable input if checkbox is unchecked
                input2.value = ""; // Clear the input value
            }
        };
    });



    function copyAddress() {
      // คัดลอกค่าจากฟอร์มที่ 1 ไปยังฟอร์มที่ 2
      const fields = ["s_home1", "s_moo1", "s_soi1", "s_road1", "s_province1", "s_aumpher1", "s_tumbon1"];
      const special_fields = ["province_id", "district_id", "subdistrict_id"];
      fields.forEach((field) => {
        document.getElementById(`form_2_${field}`).value = document.getElementById(`form_1_${field}`).value;
        document.getElementById(`${special_fields}`).value = document.getElementById(`${special_fields}`).value;
      });
    }



    $(document).ready(function () {
        $('#buddhistDate').datepicker({
            format: 'dd/mm/yyyy',         // Display format
            todayHighlight: true,        // Highlight today's date
            autoclose: true,             // Close picker after date selection
            language: 'th',              // Thai localization (supports B.E.)
            calendarWeeks: true,         // Show calendar week numbers
            beforeShowYear: function (year) {
                return {
                    content: (year + 543).toString(), // Add 543 for B.E.
                    tooltip: year.toString() // Tooltip with Gregorian year
                };
            }
        }).datepicker('update', new Date());
    });

    $(document).ready(function () {
    // Helper function to convert dd/mm/yyyy to Date object (for Thai Datepicker)
    function parseThaiDate(dateStr) {
        if (!dateStr) return null;
        var parts = dateStr.split('/');
        if (parts.length === 3) {
            var day = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10) - 1; // เดือนเริ่มจาก 0
            var year = parseInt(parts[2], 10) - 543; // แปลงจาก พ.ศ. -> ค.ศ.
            return new Date(year, month, day);
        }
        return null;
    }

    // Apply datepicker to all fields with the class 'buddhist-date-picker'
$('.buddhist-date-picker').datepicker({
    format: 'dd/mm/yyyy',
    todayHighlight: true,
    autoclose: true,
    language: 'th',
    calendarWeeks: true
}).on('changeDate', function (e) {
    let date = e.date;
    if (date) {
        let d = ("0" + date.getDate()).slice(-2);
        let m = ("0" + (date.getMonth() + 1)).slice(-2);
        let y = date.getFullYear() + 543; // ค.ศ. → พ.ศ.
        $(this).val(d + "/" + m + "/" + y);
    }
});


});

    
    $(document).ready(function() {
        $('#province_id').change(function() {
            var province_id = $('#province_id').val();
            var action = 'get_district';
            if (province_id != '') {
                $.ajax({
                    url: "./process/get_data.php",
                    method: "POST",
                    data: {
                        province_id: province_id,
                        action: action
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('#district_id').html(data);
                        $('#subdistrict_id').html('<option value="">เลือกตำบล</option>');
                        $('#zipcode').val('');
                    }
                });
            } else {
                $('#district_id').html('<option value="">เลือกอำเภอ</option>');
                $('#subdistrict_id').html('<option value="">เลือกตำบล</option>');
                $('#zipcode').val('');
            }
    });
    $('#district_id').change(function() {
        var district_id = $('#district_id').val();
        var action = 'get_subdistrict';
        if (district_id != '') {
            $.ajax({
                url: "./process/get_data.php",
                method: "POST",
                data: {
                    district_id: district_id,
                    action: action
                },
                dataType: "JSON",
                success: function(data) {
                    $('#subdistrict_id').html(data);
                    $('#zipcode').val('');
                }
            });
        } else {
            $('#subdistrict_id').html('<option value="">เลือกตำบล</option>');
            $('#zipcode').val('');
        }
    });
    $('#subdistrict_id').change(function() {
        var subdistrict_id = $('#subdistrict_id').val();
        var action = 'get_zipcode';
        if (subdistrict_id != '') {
            $.ajax({
                url: "./process/get_data.php",
                method: "POST",
                data: {
                    subdistrict_id: subdistrict_id,
                    action: action
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $('#zipcode').val(data);
                }
            });
        } else {
            $('#zipcode').val('');
        }
        });
    });

    $(document).ready(function() {
        $('#province_id2').change(function() {
            var province_id = $('#province_id2').val();
            var action = 'get_district';
            if (province_id != '') {
                $.ajax({
                    url: "./process/get_data.php",
                    method: "POST",
                    data: {
                        province_id: province_id,
                        action: action
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('#district_id2').html(data);
                        $('#subdistrict_id2').html('<option value="">เลือกตำบล</option>');
                        $('#zipcode2').val('');
                    }
                });
            } else {
                $('#district_id2').html('<option value="">เลือกอำเภอ</option>');
                $('#subdistrict_id2').html('<option value="">เลือกตำบล</option>');
                $('#zipcode2').val('');
            }
    });
    $('#district_id2').change(function() {
        var district_id = $('#district_id2').val();
        var action = 'get_subdistrict';
        if (district_id != '') {
            $.ajax({
                url: "./process/get_data.php",
                method: "POST",
                data: {
                    district_id: district_id,
                    action: action
                },
                dataType: "JSON",
                success: function(data) {
                    $('#subdistrict_id2').html(data);
                    $('#zipcode2').val('');
                }
            });
        } else {
            $('#subdistrict_id2').html('<option value="">เลือกตำบล</option>');
            $('#zipcode2').val('');
        }
    });

    $('#subdistrict_id2').change(function() {
        var subdistrict_id = $('#subdistrict_id2').val();
        var action = 'get_zipcode';
        if (subdistrict_id != '') {
            $.ajax({
                url: "./process/get_data.php",
                method: "POST",
                data: {
                    subdistrict_id: subdistrict_id,
                    action: action
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $('#zipcode2').val(data);
                }
            });
        } else {
            $('#zipcode2').val('');
        }
        });
    });

    $.extend(true, $.fn.dataTable.defaults, {
        "language": {
            "sProcessing": "กำลังดำเนินการ...",
            "sLengthMenu": "แสดง _MENU_ แถว",
            "sZeroRecords": "ไม่พบข้อมูล",
            "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
            "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
            "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
            "sInfoPostFix": "",
            "sSearch": "ค้นหา:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "เริ่มต้น",
                "sPrevious": "ก่อนหน้า",
                "sNext": "ถัดไป",
                "sLast": "สุดท้าย"
            }
        }
    });

    // เรียกใช้งาน Datatable function
    $('#myTable').DataTable({
        responsive: true
    });

    const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
    const Default = {
        scrollbarTheme: "os-theme-light",
        scrollbarAutoHide: "leave",
        scrollbarClickScroll: true,
    };
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (
            sidebarWrapper &&
            typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
        ) {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });
</script>



