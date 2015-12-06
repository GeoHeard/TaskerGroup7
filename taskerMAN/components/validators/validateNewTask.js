function validateNewTask() {
    var titleField = document.getElementById("taskTitle");
    var startDateField = document.getElementById("startDate");
    var completionDateField = document.getElementById("completionDate");

    if(titleField.value.length != 0){
        if(titleField.value.length >= 5){
            if(startDateField.value.length != 0){
                if(completionDateField.value.length != 0){
                    return true;
                }else{
                    alert("Please specify the task's estimated completiton date");
                }
            }else{
                alert("Please specify the task's start date")
            }
        }else{
            alert("Please specify a task title of length 5 or greater")
        }
    }else{
        alert("Please specify a task title");
    }
    return false;
}