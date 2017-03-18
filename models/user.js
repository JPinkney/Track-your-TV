var mongoose = require('mongoose');

// Doc for Mongoose Schemas: http://mongoosejs.com/docs/guide
var Schema = mongoose.Schema;

var show = new Schema(
    {
        id: {
            type: String, required: true
        },
        name: {
            type: String, requried: true
        },
        airTime: {
            type: String, required: true
        },
        airDays: {
            type: [String], required: true
        },
        image: {
            type: String, required: true
        },
        nextAirDate: {
            type: String
        }
    }
);

/**
 * Note that the database was loaded with data from a JSON file into a
 * collection called gillers.
 */
var userSchema = new Schema(
    {
        username: {
            type: String, required: true, unique: true
        },
        password: {
            type: String, requried: true
        },
        email: {
            type: String, required: true
        },
    	phonennumber: {
    	    type: String
    	},
        shows: {
            type: [show]
        }
    }
);

// Doc for Mongoose Connections: http://mongoosejs.com/docs/connections
mongoose.connect('mongodb://localhost/userdb');

module.exports = mongoose.model('user', userSchema);