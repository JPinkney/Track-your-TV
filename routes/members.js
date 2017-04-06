var express = require('express');
var router = express.Router();
var User = require('../models/user');
var Show = require('../models/show');
var mongoose = require('mongoose');

/* GET home page. */
router.get('/', function(req, res, next) {

	if(req.session.user.shows.length === 0){
	
		res.render('members', { title: 'Track Your Tv', user: req.session.user, shows: []});
	
	}else{

		Show.find({'id': {$in: req.session.user.shows}}, function(err, shows){

			res.render('members', { title: 'Track Your Tv', user: req.session.user, shows: shows});
		
		});

	}
	
});

module.exports = router;