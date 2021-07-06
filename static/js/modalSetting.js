$(function (){
    $('#createUserButton').on('click', function(){
        const $inputs = $(this).parent().parent().find('input, select');

        const objectToValidate = {};

        for (const input of $inputs.serializeArray())
            if (input.value !== "")
                objectToValidate[input.name] = input.value;

        const constraints = {
            login: {
                presence: true,
                format: {
                    pattern: /^[ a-zA-Z0-9_\-]+$/,
                    message: 'can contain only letters, numbers, - and _ characters'

                },
                length: {
                    minimum: 2,
                    maximum: 50,
                    tooShort: 'needs to be at least %{count} characters or more',
                    tooLong: 'needs be less than %{count} characters'
                }
            },
            password: {
                presence: true,
                format: {
                    pattern: /^[a-zA-Z0-9_\-]+$/,
                    message: 'can contain only letters, numbers, - and _ characters'

                },
                length: {
                    minimum: 8,
                    maximum: 50,
                    tooShort: 'must to be at least %{count} characters or more',
                    tooLong: 'must be less than %{count} characters'
                }
            },
            role: {
                presence: true,
                numericality: true
            },
            first_name: {
                presence: false,
                format: {
                    pattern: /^[a-zA-Z]+$/,
                    message: 'can contain only letters'

                },
                length: {
                    minimum: 2,
                    maximum: 50,
                    tooShort: 'needs to be at least %{count} characters or more',
                    tooLong: 'needs be less than %{count} characters'
                }
            },
            last_name: {
                presence: false,
                format: {
                    pattern: /^[a-zA-Z\-]+$/,
                    message: 'can contain only letters and -'

                },
                length: {
                    minimum: 2,
                    maximum: 50,
                    tooShort: 'needs to be at least %{count} characters or more',
                    tooLong: 'needs be less than %{count} characters'
                }
            },
            gender: {
                presence: false,
                inclusion: {
                    within: ["male", "female"]
                }
            },
            birth_date: {
                presence: false,
                datetime: {
                    dateOnly: true,
                    latest: moment.utc().subtract(10, 'years'),
                    earliest: moment.utc().subtract(130, 'years'),
                    tooEarly: "^People don't live more than 130 years so far",
                    tooLate: "^User must be at least 10 years old"
                }
            }
        };

        validate.extend(validate.validators.datetime, {
            parse: function(value, options) {
              return +moment.utc(value);
            },
            format: function(value, options) {
              var format = options.dateOnly ? "YYYY-MM-DD" : "YYYY-MM-DD hh:mm:ss";
              return moment.utc(value).format(format);
            }
          });

        const result = validate(objectToValidate, constraints);
        
        const $modalBody = $(this).parent().parent().find('.modal-body');
        if (!result){
            // ajax
            bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
            $modalBody.find('.alert').remove();
            $modalBody.find('input, select').val('');
            $modalBody.find('select[name="role"]').val(1);
        } else {
            $modalBody.find('.alert').remove();
            for (const key in result){
                const $message = $(`<div class="alert alert-danger d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>${result[key]}</div></div>`);
                $message.hide();
                $modalBody.prepend($message);
                $message.slideDown(400);
            }
        }
    });

});