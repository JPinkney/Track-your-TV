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
 * @url localhost:3000/api/shows/addShowToUser
 */
exports.addShowToUser = function(req, res){

    let username = req.session.user.username;
    let showname = req.body.showname;

    Show.find({"name": showname}, function(err, show){
        
        if(err){
            throw err;
        }   

        //Check if they are already tracking
        User.find({"shows": {"$in": show[0].id}}, function(err, result){
            
            console.log(result);

            if(result.length === 0){
                
                //Its already in the DB so we just need to add the object ID to the user
                if(show.length !== 0){

                    req.session.user.shows.push(show[0].id);

                    User(req.session.user).update(req.session.user, function(err){
                        if(err){
                            throw err;
                        }

                        res.send({"shows": req.session.user.shows});
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

                            req.session.user.shows.push(newShow.id);

                            User(req.session.user).update(req.session.user, function(err){
                                if(err){
                                    throw err;
                                }

                                res.send({"shows": req.session.user.shows});
                            
                            });

                        });

                    });
                }

            }else{

                res.send({"code": 200, "message": "Show is already being tracked"});

            }
        });

        

    });

};