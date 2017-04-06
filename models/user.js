var mongoose = require('mongoose');

// Doc for Mongoose Schemas: http://mongoosejs.com/docs/guide
var Schema = mongoose.Schema;

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
        emailnotifications:{
            type: Boolean
        },
        textnotifications:{
            type: Boolean
        },
        shows: {
            type: [String]
        }
    }
);

// Doc for Mongoose Connections: http://mongoosejs.com/docs/connections
mongoose.connect('mongodb://localhost/userdb');

module.exports = mongoose.model('user', userSchema);