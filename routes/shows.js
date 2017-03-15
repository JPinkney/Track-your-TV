var tvmaze = require("tvmaze-node");
var Show = require('../models/show');

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
                //console.log(response);
                console.log("break");
                console.log(response.schedule.days);

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