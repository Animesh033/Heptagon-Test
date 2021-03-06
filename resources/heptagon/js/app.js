
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
'use strict';
window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
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


$(function() {
    var uiController = (function() {
        var DOMstrings = {
            addEmpBtn: '.add-employee',
            empFormDiv: '.employeeFormDiv',
            empAddForm: '#employeeForm',
            submitAddEmpForm: '#submitAddEmpForm',
            msgDiv: '.response-message',
            deleteEmp: '.delete-emp',
            deleteEmpForm: '.delete-emp-form',
        };
        return {
            getDomStrings: function() {
                return DOMstrings;
            }
        };

    })();

    var controller = (function(uiCtrl) {
        var DOM = uiCtrl.getDomStrings();
        var setupEventListeners = function () {
            var el = document.querySelector(DOM.submitAddEmpForm);
            if(el){
                el.addEventListener('click', submitAddEmpForm);
            }
            document.addEventListener('keypress', function(event) {
                if (event.keyCode === 13 || event.which === 13) {
                    submitAddEmpForm(event);
                }
            });
            var el2 =  document.querySelector(DOM.deleteEmp);
            if(el2){
                el2.addEventListener('click', deleteEmployee);
            }
        };

        var deleteEmployee = function (e) {
            e.preventDefault();
            var action = $(DOM.deleteEmpForm).attr('action');
            $.ajax({
                type: "DELETE",
                url: action,
                success: function (data) {
                    console.log(data.success)
                    var classDiv = '';
                    var msg = '';
                    if (data.success) {
                        $(DOM.submitAddEmpForm).html('Deleted');
                        $(DOM.deleteEmpForm).trigger("reset");
                        classDiv = 'alert-success';
                        msg = data.success;
                    } else {
                        classDiv = 'alert-danger';
                        msg = data.error;
                    }
                    $(DOM.msgDiv).html('<div class="alert ' + classDiv + ' alert-dismissible fade show" role="alert"><p>' + msg + '</p> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');

                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        };

        var submitAddEmpForm = function(e) {
            e.preventDefault();
            $(this).html('Semding...');
            var action = $(DOM.empAddForm).attr('action');
            $.ajax({
                data: $(DOM.empAddForm).serialize(),
                url: action,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    console.log(data.success)
                    var classDiv = '';
                    var msg = '';
                    if(data.success){
                        $(DOM.submitAddEmpForm).html('Updated');
                        $(DOM.empAddForm).trigger("reset");
                            classDiv = 'alert-success';
                            msg = data.success;
                    }else{
                        classDiv = 'alert-danger';
                        msg = data.error;
                    }
                    $(DOM.msgDiv).html('<div class="alert '+classDiv+' alert-dismissible fade show" role="alert"><p>'+msg+'</p> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>');

                    $(DOM.submitAddEmpForm).html('Save');
                },
                error: function (data) {
                    console.log(data);
                    $(DOM.submitAddEmpForm).html('Save Changes');
                    $(DOM.empFormDiv).show();
                }
            });
        };

        return {
            init: function() {
                console.log('Application has started.');
                setupEventListeners();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
        };
        })(uiController);
        controller.init();
    });
