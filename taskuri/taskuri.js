(function() {
    'use strict';
    window.addEventListener('load', function() {
      var progressItems = document.getElementsByClassName('progress-bar');
      this.console.log("progressItems: " + progressItems.length);
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('TaskForm needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          const Http = new XMLHttpRequest();
          const url='http://localhost/taskboard/header/users.php';
          Http.open("POST", url);
          Http.send();
          var skillLevelEnough = false;
          Http.onreadystatechange = (e) => {
            if(Http.readyState === 4 && Http.status === 200) {
              console.log(Http.responseText);
              var users = JSON.parse(Http.responseText); //luam din bd
              //iteram pe users din bd
              for (var user of users) {
                var uiUser = document.getElementById("add_task_user");
                //ma opresc la user selectat pe interf
                if (uiUser.value === (user.first_name + " " + user.last_name)) {
                  var skill = document.getElementById("add_task_skill").value;
                  var skill_level = document.getElementById("add_task_skill_level").value;
                  var found = false;

                  for(var user_skill of user.skill){
                    if(user_skill.toLowerCase().includes(skill.toLowerCase())){
                      found = true;
                      break;
                    }
                  }
                  if(!found){
                    document.getElementById("add_task_error").innerHTML = "The user selected does not have the selected task skill(user skills:" + user.skill + ") <br> ";
                    skillLevelEnough = false;
                  }else{
                    console.log(skill_level.localeCompare(user.level));
                    if(skill_level.localeCompare(user.level) === 1){
                      document.getElementById("add_task_error").innerHTML = "Task skill level greather than user skill level(" + user.level + " )<br>";
                      skillLevelEnough= false;
                    
                    }
                  }
                  
                }
              }
            }
          }

          if (form.checkValidity() === false || skillLevelEnough === true) {
            console.log("form not valid");
            event.preventDefault();
            event.stopPropagation();
            var inputs = document.getElementsByClassName('form-control');
            console.log(inputs);
            for( var i = 0 ; i < inputs.length; i++ ){
              var input = inputs[i];
              input.classList.remove('is-invalid')
              input.classList.remove('is-valid')

              if (input.checkValidity() === false) {
                  input.classList.add('is-invalid')
              }
              else {
                  input.classList.add('is-valid')
              }
            }

          } else {
            window.top.location.replace('http://localhost/taskboard/');
          }
          //form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  $('#EditTask').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var taskId = $(e.relatedTarget).data('task-id');
    console.log(taskId);
    var taskName = $(e.relatedTarget).data('task-name');
    var skill = $(e.relatedTarget).data('skill');
    var level = $(e.relatedTarget).data('level');
    var duration = $(e.relatedTarget).data('duration');
    var firstName = $(e.relatedTarget).data('first-name');
    var lastName = $(e.relatedTarget).data('last-name');
    var status = $(e.relatedTarget).data('status');

    document.getElementById("edit-task-id").value = parseInt(taskId);
    document.getElementById("edit-task-name").value = taskName;
    document.getElementById("edit-skill").value = skill;
    document.getElementById("edit-level").value = level;
    document.getElementById("edit-duration").value = duration;
    document.getElementById("edit-assigned-to").value = firstName + ' ' + lastName;
    document.getElementById("edit-status").value = status;
  });
  $('#DeleteTask').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var taskId = $(e.relatedTarget).data('task-id');
    var taskName = $(e.relatedTarget).data('task-name');
    document.getElementById('task-name').innerHTML = "Are you sure you want to delete task <i>" + taskName + "</i>?";
    document.getElementById("TaskIdInput").value = parseInt(taskId);
  });

var runningTasks = [];
var simulated = true;

function start(taskid) {
  var schedule = 0;
  if (simulated) {
    // 1 minute elapses in 0.5 seconds
    schedule = 500;
  } else {
    // Real time
    schedule = 60 * 1000; // 60 seconds
  }
  for (var task of runningTasks) {
    if (task.id === taskid) {
      // If task found, just resume
      if (!task.running) {
        task.running = true;
        task.update(task.time, taskid);
        $("#progress-" + taskid).addClass("progress-bar-striped");
        $("#progress-" + taskid).addClass("progress-bar-animated");
        return;
      }
    }
  }
  var taskObject = {id: taskid, time: 0, duration: 0, running: true, update: function(updateTime, id) {
    var duration = parseInt(document.getElementById('duration-' + id).innerHTML);
    var durationMinutes = duration * 60;
    for (var task of runningTasks) {
      if (task.id === id && task.running) {
        document.getElementById("start-" + id).disabled = true;
        document.getElementById("stop-" + id).disabled = false;
        task.time = updateTime;
        task.duration = durationMinutes;
        var displayTime = Math.round(task.time / task.duration * 100);
        if (displayTime <= 50) {
          $("#progress-" + task.id).addClass("bg-danger");
        } else if (displayTime <= 80) {
          $("#progress-" + task.id).removeClass("bg-danger");
          $("#progress-" + task.id).addClass("bg-warning");
        } else if (displayTime <= 90) {
          $("#progress-" + task.id).removeClass("bg-warning");
          $("#progress-" + task.id).addClass("bg-info");
        }
        if (displayTime >= 100) {
          $("#progress-" + task.id).removeClass("bg-info");
          $("#progress-" + task.id).addClass("bg-success");
          $("#progress-" + task.id).css("width", 100 + "%").text(100 + " %");
          $("#progress-" + task.id).removeClass("progress-bar-striped");
          $("#progress-" + task.id).removeClass("progress-bar-animated");
          for( var i = 0; i < runningTasks.length; i++) {
            if ( runningTasks[i].id === id) {
              runningTasks.splice(i, 1);
              break;
            }
          }
          // Automatically put task on done
          var taskStatus = document.getElementById('task-status-' + id);
          taskStatus.innerHTML = "Done";
          var durationElem = document.getElementById('duration-' + id);
          durationElem.innerHTML = "0h";
          document.getElementById("start-" + id).disabled = true;
          document.getElementById("stop-" + id).disabled = true;
          $("#start-" + id).removeClass("btn-secondary");
          $("#stop-" + id).removeClass("btn-secondary");
          $("#start-" + id).addClass("btn-light");
          $("#stop-" + id).addClass("btn-light");
          $("#task-status-" + task.id).removeClass("badge-warning");
          $("#task-status-" + task.id).removeClass("badge-danger");
          $("#task-status-" + task.id).addClass("badge-success");
          // And now in the database
          const Http = new XMLHttpRequest();
          const url='http://localhost/taskboard/taskuri/finish_task.php?id=' + id;
          Http.open("GET", url);
          Http.send();
          Http.onreadystatechange = (e) => {
            if(Http.readyState === 4 && Http.status === 200) {
              console.log('Task ' + id + " done");
            }
          }
        } else {
          setTimeout(function() {
            task.update(task.time + 1, id);
            $("#progress-" + id).css("width", displayTime + "%").text(displayTime + " %");
          }, 500);
        }
        break;
      }
    }
  }};
  $("#progress-" + taskid).addClass("progress-bar-striped");
  $("#progress-" + taskid).addClass("progress-bar-animated");
  runningTasks.push(taskObject);
  taskObject.update(0, taskid);
}

function stop(id) {
  for (var task of runningTasks) {
    if (task.id === id) {
      // Stop the task
      console.log('task ' + id + " stopped");
      task.running = false;
      console.log(task.time);
      break;
    }
  }
  $("#progress-" + id).removeClass("progress-bar-striped");
  $("#progress-" + id).removeClass("progress-bar-animated");
  document.getElementById("start-" + id).disabled = false;
  document.getElementById("stop-" + id).disabled = true;
}

//paginare
$(document).ready(function () {
  let t = document.getElementsByClassName('.task_item').length;
  $('.example').rpmPagination({
     limit: 10,
      total: t,
      domElement: '.task_item'
  });
//filtrare
$("#filter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


  
