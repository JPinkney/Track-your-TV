'use strict';

const nodeemailer = require('nodemailer');
var schedule = require('node-schedule');
var tvmaze = require("tvmaze-node");
var mongoose = require('mongoose');
var Show = require('./models/show');

let transport = nodemailer.createTranport({
	service: 'gmail',
	auth: {
		user: 'gmail.user@gmail.com',
		pass: 'yourpass'
	}
});

let mailOptions = {
	from: '"Track your TV" <track@gmail.com>',
	to: 'names',
	subject: 'hello',
	text: 'hello world', //Plain text body
	html: '<p>Hello</p>' //HTML body	
};

transporter.sendMail(mailOptions, (error, info) => {
	
	if(error){
		return console.log(error);
	}

	console.log("Message %s sent: %s", info.messageId, info.response);

});

var rule = new schedule.RecurrenceRule();
rule.minute = 60;

var job = schedule.scheduleJob(rule, function(){
	console.log("Collecting shows that need to be updated");

	var currentDateTime = (new Date(Date.now())).toString();
	Show.find({"nextAirDate": {"$lt": currentDateTime}}, function(err, shows){
		
		if(err){
			throw err;
		}

		for(let show in shows){
			var currShow = shows[show];

			tvmaze.singleShow(currShow.name, "episodes", function(error, response) {

		        if(error){
		            throw error;
		        }

		        response = JSON.parse(response);

		        var currentDateTime = (new Date(Date.now())).toString();
		        var nextAirStamp = response._embedded.episodes.pop().airstamp;
		        var nextAirDate = nextAirStamp > currentDateTime ? nextAirStamp : "break";

		        Show.findOneAndUpdate({"name": showname}, {$set: {"nextAirDate": nextAirDate}}, function(err, newShow){
		            
		            if(err){
		                throw err;
		            }

		           	console.log("Show: " + currShow.name + " has been updated. The new air date is: " + nextAirDate);

		        });

   			});
		}

	});

});