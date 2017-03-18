var express = require('express');
var router = express.Router();
var show = require('../models/show');

/* GET home page. */
router.get('/', function(req, res, next) {

	show.find({}, function(err, shows){
		res.render('members', { title: 'Track Your Tv', user:"undefined", shows: shows});
	});

});

module.exports = router;