(function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('TaskForm');
      console.log(forms.length);
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          } 
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
$('#EditSkill').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var SkillName = $(e.relatedTarget).data('skill-name');
    var id= $(e.relatedTarget).data('skill-id');

    document.getElementById("edit-skill-name").value = SkillName;
    document.getElementById("edit-skill-id").value = id;
  });

  $('#EditTeam').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var TeamName = $(e.relatedTarget).data('team-name');
    var id= $(e.relatedTarget).data('team-id');
    var Description = $(e.relatedTarget).data('description');

    document.getElementById("edit-team-name").value = TeamName;
    document.getElementById("edit-team-id").value = id;
    document.getElementById("edit-description").value = Description;
  });

  $('#EditProject').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var nume = $(e.relatedTarget).data('project-name');
    var id= $(e.relatedTarget).data('project-id');
    var Description = $(e.relatedTarget).data('description');

    document.getElementById("edit-project-name").value = nume;
    document.getElementById("edit-project-id").value = id;
    document.getElementById("edit-project-description").value = Description;
    console.log(Description);
  });

  $('#EditUser').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var SkillName = $(e.relatedTarget).data('skill-name');
    var id= $(e.relatedTarget).data('skill-id');
    var SkillLevel=$(e.relatedTarget).data('skill-level');
    var WorkHours=$(e.relatedTarget).data('work-hours');
    var Role=$(e.relatedTarget).data('role');
    var FirstName=$(e.relatedTarget).data('first-name');
    var LastName=$(e.relatedTarget).data('last-name');

    document.getElementById("edit-first-name").value = FirstName;
    document.getElementById("edit-last-name").value = LastName;
    document.getElementById("edit-skill-name").value = SkillName;
    document.getElementById("edit-user-id").value = id;
    document.getElementById("edit-skill-level").value = SkillLevel;
    document.getElementById("edit-work-hours").value = WorkHours;
    document.getElementById("edit-role").value = Role;
    
  });

  $('#DeleteSkill').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var skillId = $(e.relatedTarget).data('skill-id');
    var skillName = $(e.relatedTarget).data('skill-name');
    document.getElementById('skill-name').innerHTML = "Are you sure you want to delete skill <i>" + skillName + "</i>?";
    document.getElementById("SkillIdInput").value = parseInt(skillId);
  });

  $('#DeleteTeam').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var id = $(e.relatedTarget).data('team-id');
    var TeamName = $(e.relatedTarget).data('team-name');
    document.getElementById('team-name').innerHTML = "Are you sure you want to delete this team <i>" + TeamName + "</i>?";
    document.getElementById("TeamIdInput").value = parseInt(id);
  });

  $('#DeleteProject').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var id = $(e.relatedTarget).data('project-id');
    var ProjectName = $(e.relatedTarget).data('project-name');
    document.getElementById('project-name').innerHTML = "Are you sure you want to delete this project ?";
    document.getElementById("ProjectIdInput").value = parseInt(id);
  });

  $('#DeleteUser').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var userId = $(e.relatedTarget).data('user-id');
    var userName = $(e.relatedTarget).data('user-name');
    document.getElementById('user-name').innerHTML = "Are you sure you want to delete user <i>" + userName + "</i>?";
    document.getElementById("UserIdInput").value = parseInt(userId);
  });

  $('#AddUserSkill').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    //console.log("Add user skill");
    var UserId = $(e.relatedTarget).data('user-id');
    //console.log(UserId);
    document.getElementById("AddUserIdInput").value = parseInt(UserId);
  });

  //paginare
  //pt skill
$(document).ready(function () {
  let t = document.getElementsByClassName('.skill_item').length;
  $('.skills_management').rpmPagination({
     limit: 10,
      total: t,
      domElement: '.skill_item'
  });
//pt user
   let t1 = document.getElementsByClassName('.user_item').length;
  $('.user_management').rpmPagination({
     limit: 10,
      total: t1,
      domElement: '.user_item'
  });
//pt team
  let t2 = document.getElementsByClassName('.team_item').length;
  $('.team_management').rpmPagination({
     limit: 10,
      total: t2,
      domElement: '.team_item'
  });
//pt project
  let t3 = document.getElementsByClassName('.project_item').length;
  $('.project_management').rpmPagination({
     limit: 10,
      total: t3,
      domElement: '.project_item'
  });

    let TabId = window.localStorage.getItem("Taskboard-tab");
    console.log("TabId:"+ TabId);

  if(TabId == 2){
    console.log("elm");
    document.getElementById("user").classList.remove("active");
    document.getElementById("skill").classList.add("active");
    document.getElementsByClassName("tab-pane container")[0].classList.remove("active");
    document.getElementsByClassName("tab-pane container")[1].classList.remove("fade");
    document.getElementsByClassName("tab-pane container")[0].classList.add("fade");
    document.getElementsByClassName("tab-pane container")[1].classList.add("active");
  }else 
    if(TabId == 3 ){
    console.log("elm");
    document.getElementById("user").classList.remove("active");
    document.getElementById("team").classList.add("active");
    document.getElementsByClassName("tab-pane container")[0].classList.remove("active");
    document.getElementsByClassName("tab-pane container")[2].classList.remove("fade");
    document.getElementsByClassName("tab-pane container")[0].classList.add("fade");
    document.getElementsByClassName("tab-pane container")[2].classList.add("active");
    }
    else
    if(TabId == 4 ){
      console.log("elm");
      document.getElementById("user").classList.remove("active");
      document.getElementById("project").classList.add("active");
      document.getElementsByClassName("tab-pane container")[0].classList.remove("active");
      document.getElementsByClassName("tab-pane container")[3].classList.remove("fade");
      document.getElementsByClassName("tab-pane container")[0].classList.add("fade");
      document.getElementsByClassName("tab-pane container")[3].classList.add("active");
      }

});

//salvare in local storage
function tabselected(TabId){
  window.localStorage.setItem("Taskboard-tab",TabId);
}


