var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {

	FrontPage.find({}, function(err, app){
  		res.render('index', { title: 'Track Your Tv'});
	});

});

module.exports = router;