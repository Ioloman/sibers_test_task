/**
 * this function is used to validate user create or update actions
 * returns array of errors
 * 
 * @param {jQuery collection} $inputs 
 * @param {boolean} update 
 * @returns object
 */
function customValidate($inputs, update=false){

    // form an object suitable for validation function
    const objectToValidate = {};
    for (const input of $inputs.serializeArray())
        if (input.value !== "")
            objectToValidate[input.name] = input.value;

    // declare the rules
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
            presence: !update,
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
            presence: !update,
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

    // prepare validator for date validation
    validate.extend(validate.validators.datetime, {
        parse: function(value, options) {
            return +moment.utc(value);
        },
        format: function(value, options) {
            var format = options.dateOnly ? "YYYY-MM-DD" : "YYYY-MM-DD hh:mm:ss";
            return moment.utc(value).format(format);
        }
        });

    // use validate() from validate.js which returns a javascript object aka dictionary 
    return validate(objectToValidate, constraints);
}