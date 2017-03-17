var express = require('express');
var router = express.Router();
var FrontPage = require('../models/frontpage');

/* GET home page. */
router.get('/', function(req, res, next) {

	FrontPage.find({}, function(err, app){
  		res.render('index', { title: 'Track Your Tv', frontpage: app });
	});

});

module.exports = router;