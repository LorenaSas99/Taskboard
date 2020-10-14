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
  $('#DeleteUser').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var userId = $(e.relatedTarget).data('user-id');
    var userName = $(e.relatedTarget).data('user-name');
    document.getElementById('user-name').innerHTML = "Are you sure you want to delete user <i>" + userName + "</i>?";
    document.getElementById("UserIdInput").value = parseInt(userId);
  });
  $('#AddUserSkill').on('shown.bs.modal', function (e) {
    //get data-id attribute of the clicked element
    var UserId = $(e.relatedTarget).data('user-id');
    document.getElementById("UserIdInput").value = parseInt(UserId);
  });

