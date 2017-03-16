var express = require('express');
var path = require('path');
var favicon = require('serve-favicon');
var logger = require('morgan');
var cookieParser = require('cookie-parser');
var bodyParser = require('body-parser');
var expressValidator = require('express-validator');

var index = require('./routes/index');
var users = require('./routes/users');
var shows = require('./routes/shows');
var login = require('./routes/login');
var signup = require('./routes/signup');
//var db_funcs = require('./routes/database_routes');

var app = express();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

// uncomment after placing your favicon in /public
//app.use(favicon(path.join(__dirname, 'public', 'favicon.ico')));
app.use(logger('dev'));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(expressValidator({
    customValidators: {

        isPhoneNumber: function(value) {
            return value.search("^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$") !== -1;
        },
        isWord: function(value) {
            return value.search(".+") !== -1;
        }

    }
}));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', index);
app.use('/signup', signup);
app.use('/login', login);
app.route('/api/users').post(users.registerUser).put(users.updateUser).delete(users.deleteUser);
app.route('/api/users/validateUser').post(users.validateUser);
app.route('/api/shows').get(shows.getShow).delete(shows.deleteShow);
app.route('/api/shows/updateShowAirDate').put(shows.updateShowAirDate);

// catch 404 and forward to error handler
app.use(function(req, res, next) {
  var err = new Error('Not Found');
  err.status = 404;
  next(err);
});

// error handler
app.use(function(err, req, res, next) {
  // set locals, only providing error in development
  res.locals.message = err.message;
  res.locals.error = req.app.get('env') === 'development' ? err : {};

  // render the error page
  res.status(err.status || 500);
  res.render('error');
});

module.exports = app;
