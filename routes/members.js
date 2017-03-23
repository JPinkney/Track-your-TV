var express = require('express');
var router = express.Router();
var User = require('../models/user');
var Show = require('../models/show');

/* GET home page. */
router.get('/', function(req, res, next) {

	console.log(req.session.user.shows);

	Show.find(req.session.user.shows, function(err, newShows){
		res.render('members', { title: 'Track Your Tv', user: req.session.user, shows: newShows});
	});

});

module.exports = router;