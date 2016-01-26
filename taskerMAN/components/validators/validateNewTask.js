function validateNewTask() {
    var titleField = document.getElementById("taskTitle");
    var startDateField = document.getElementById("startDate");
    var completionDateField = document.getElementById("completionDate");

    if (titleField.value.length != 0) {
        if (titleField.value.length >= 5) {
            // ^[a-zA-Z0-9_]*$
            if (/^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(titleField.value)) {
                if (titleField.value.length <= 64) {
                    if (startDateField.value.length != 0) {
                        if (completionDateField.value.length != 0) {
                            return true;
                        } else {
                            alert("Please specify the task's estimated completiton date");
                        }
                    } else {
                        alert("Please specify the task's start date");
                    }
                } else {
                    alert("Please specify a task title shorter than 65 characters");
                }
            } else {
                alert("Please specify a task title without any symbols");
            }
        } else {
            alert("Please specify a task title longer than 5 characters")
        }
    } else {
        alert("Please specify a task title");
    }
    return false;
}