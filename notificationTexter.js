'use strict';

const nodeemailer = require('nodemailer');
var schedule = require('node-schedule');
var tvmaze = require("tvmaze-node");
var mongoose = require('mongoose');
var dial = require('dial')('gmail', 'username', 'pass');
var Show = require('./models/show');

let mailOptions = {
	from: '"Track your TV" <track@gmail.com>'
};

var rule = new schedule.RecurrenceRule();
rule.minute = 60;

var job = schedule.scheduleJob(rule, function(){
	console.log("Collecting people that need to be notified via text");

	var currentDateTime = (new Date(Date.now())).toString();
	var previous_hour = new Date((new Date).getTime() - 3600000);
	Show.find({"nextAirDate": {"$gte": previous_hour, "$lte": currentDateTime, "$ne": "break"}}, function(err, shows){
		
		if(err){
			throw err;
		}

		User.find({"shows": {"$in": shows}, "textnotifications": 1}, function(error, response){
			for(let user in response){
				let currUser = response[user];
				mailOptions.text = getShowsInUser(shows, currUser.shows);
				mailOptions.to = currUser.email;

				dial.text(currUser.carrier, mailOptions, function(resp){
					console.log("Text has been sent to %s", currUser.email);
				});

			}
			
		});

	});

});

function getShowsInUser(shows, user_shows){

	var toEmailStr = '';
	for(var x in shows){
		if(user_shows.indexOf(shows[x].name) !== -1){
			toEmailStr += ('Show: %s is on at: %s ', shows[x].name, shows[x].nextAirDate);
		}
	}

	return toEmailStr;

}










