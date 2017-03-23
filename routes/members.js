var express = require('express');
var router = express.Router();
var User = require('../models/user');

/* GET home page. */
router.get('/', function(req, res, next) {

	console.log(req.session);

	User.find({username: req.session.user.username}, function(err, shows){
		res.render('members', { title: 'Track Your Tv', user:req.session.user, shows: shows});
	});

});

module.exports = router;