var tvmaze = require("tvmaze-node");
var Show = require('../models/show');

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
                    "image": response.image.original,
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