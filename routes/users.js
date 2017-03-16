var User = require('../models/user');
var bcrypt = require("bcrypt-nodejs");

/**
 * Update a user with new given information
 *
 * @param {object} req request object
 * @param {object} res response object
 * 
* @url localhost:3000/api/users
 */
exports.updateUser = function(req, res){

    let user = req.body.username;

    User.findOneAndUpdate({ "username" : user}, req.body, {new: true}, function(err, userReturn){
    
        if (err) throw err;

        res.send(userReturn);
    
    });

};

/**
 * Delete a user with given username
 *
 * @param {object} req request object
 * @param {object} res response object
 * 
 * @url localhost:3000/api/users
 */
exports.deleteUser = function(req, res){

    let user = req.body.username;
    
    User.findOneAndRemove({ "username" : user}, function(err){
    
        if (err) throw err;

        res.send("Success");
    
    });

};

/**
 * Register a user
 *
 * @param {object} req request object
 * @param {object} res response object
 * 
 * @url localhost:3000/api/users
 */
exports.registerUser = function(req, res){

    // Checking if the fields (by name) aren't empty:
    req.assert('username', 'A username is required').notEmpty();
    req.assert('password', 'A password is required').notEmpty();
    req.assert('email', 'A email is required').notEmpty();
    //req.assert('phonenumber', 'A userReturn number is required').notEmpty();

    // Checking username:
    req.checkBody('username', 'Username not formatted properly.').isWord();

    // Checking password:
    req.checkBody('password', 'Password not formatted properly.').isWord();

    // Checking email:
    req.checkBody('email', 'Email not formatted properly.').isWord();

    // Checking phonenumber:
    //req.checkBody('phonenumber', 'Phone number not formatted properly.').isPhoneNumber();

    // Checking for errors and mapping them:
    var errors = req.validationErrors();
    var mappedErrors = req.validationErrors(true);

    if (errors) {
        // If errors exist, send them back to the form:
        var errorMsgs = { 'errors': {} };

        if (mappedErrors.username) {
            errorMsgs.errors.error_username = mappedErrors.username.msg;
        }

        if (mappedErrors.password) {
            errorMsgs.errors.error_password = mappedErrors.password.msg;
        }

        if (mappedErrors.email) {
            errorMsgs.errors.error_email = mappedErrors.email.msg;
        }

        if (mappedErrors.phonenumber) {
            errorMsgs.errors.error_phonenumber = mappedErrors.phonenumber.msg;
        }

        // Note how the placeholders in tapp.html use this JSON:
        res.send(errorMsgs);

    } else {
            
        let username = req.body.username;
        let password = bcrypt.hashSync(req.body.password);
        let email = req.body.email;
        let phonenumber = req.body.phonenumber;

        User.find({ "username" : username }, function(err, userReturn){

            if(userReturn.length > 0){
               
                res.send("Username taken");
            
            }else{

                var newUser = new User({"username": username, "password": password, "email": email, "phonenumber": phonenumber});

                newUser.save(function(err, newUser){
                    if(err){
                        throw err;
                    }

                    res.send(newUser);
                });

            }

        });

    }

};

/**
 * Validate the user to see if they can login
 *
 * @param {object} req request object
 * @param {object} res response object
 * 
 * @url localhost:3000/api/users/validateUser
 */
exports.validateUser = function(req, res){

    let username = req.body.username;
    let password = req.body.password;

    User.find({ "username" : username }, function(err, userReturn){
        
        if(userReturn.length === 0){
            res.send("No user found with that username");
        }else{
            if(bcrypt.compareSync(password, userReturn[0].password)){
                res.send(userReturn);
            }else{
                res.send("Incorrect password");
            }
        }
    
    });

};