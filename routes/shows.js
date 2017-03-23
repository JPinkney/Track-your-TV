var tvmaze = require("tvmaze-node");
var Show = require('../models/show');
var User = require('../models/user');
var mongoose = require('mongoose');

/**
 * Get a show with the given name
 *
 * @param {object} req request object
 * @param {object} res response object
 * 
 * @url localhost:3000/api/getShow
 */
exports.getShow = function(req, res){

    let showname = req.query.showname;

    Show.find({"showname": showname}, function(err, show){
        
        if(err){
            throw err;
        }   

        if(show.length != 0){
       
            res.send({"code": 400, "message": "already tracking show"});
       
        }else{
       
            tvmaze.singleShow(showname, "episodes", function(error, response) {
        
                if(error){
                    throw error;
                }

                response = JSON.parse(response);

                var currentDateTime = (new Date(Date.now())).toString();
                var nextAirStamp = response._embedded.episodes.pop().airstamp;
                var nextAirDate = nextAirStamp > currentDateTime ? nextAirStamp : "break";

                var newShow = Show({
                    "id": response.id,
                    "name": response.name,
                    "airTime": response.schedule.time,
                    "airDays": response.schedule.days,
                    "image": response.image.medium,
                    "nextAirDate": nextAirDate
                });

                newShow.save(function(err){
                    if(err){
                        throw err;
                    }

                    res.send({"code": 200, "message": "save complete"});
                });

            });
        }

    });

};

/**
 * Delete a show with the given name
 *
 * @param {object} req request object
 * @param {object} res response object
 * 
 * @url localhost:3000/api/shows
 */
exports.deleteShow = function(req, res){

    let showname = req.query.showname;

    Show.remove({"showname": showname}, function(err, show){
        
        if(err){
            throw err;
        }   

        res.send({"code": 200, "message": "Show deleted"});

    });

};

/**
 * Update the air date of a show with given name
 *
 * @param {object} req request object
 * @param {object} res response object
 * 
 * @url localhost:3000/api/shows/updateShowAirDate
 */
exports.updateShowAirDate = function(req, res){

    let showname = req.query.showname;

    tvmaze.singleShow(showname, "episodes", function(error, response) {

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

            res.send(newShow);

        });

    });

};

/**
 * Get a show with the given name
 *
 * @param {object} req request object
 * @param {object} res response object
 * 
 * @url localhost:3000/api/shows/addShowToUser
 */
exports.addShowToUser = function(req, res){

    let username = req.session.user.username;
    let showname = req.body.showname;

    Show.find({"name": showname}, function(err, show){
        
        if(err){
            throw err;
        }   

        //Its already in the DB so we just need to add the object ID to the user
        if(show.length != 0){

            req.session.user.shows.push(mongoose.mongo.ObjectId(show._id));
            User(req.session.user).update(req.session.user, function(err){
                if(err){
                    throw err;
                }

                res.send({"code": 200, "message": "save complete"});
            });
       
        //Its not in the DB so we need to search tvmaze and add to shows and user
        }else{
       
            tvmaze.singleShow(showname, "episodes", function(error, response) {
        
                if(error){
                    throw error;
                }

                response = JSON.parse(response);

                var currentDateTime = (new Date(Date.now())).toString();
                var nextAirStamp = response._embedded.episodes.pop().airstamp;
                var nextAirDate = nextAirStamp > currentDateTime ? nextAirStamp : "break";

                var newShow = Show({
                    "id": response.id,
                    "name": response.name,
                    "airTime": response.schedule.time,
                    "airDays": response.schedule.days,
                    "image": response.image.medium,
                    "nextAirDate": nextAirDate
                });

                newShow.save(function(err){
                    if(err){
                        throw err;
                    }

                    req.session.user.shows.push(mongoose.mongo.ObjectId(newShow._id));

                    User(req.session.user).update(req.session.user, function(err){
                        if(err){
                            throw err;
                        }

                        res.send({"code": 200, "message": "save complete"});
                    
                    });

                });

            });
        }

    });

};