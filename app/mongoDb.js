let mongoose = require('mongoose'),
	mongoDbUrl = 'mongodb://' + process.env.MONGO_DB_HOST + ':' + process.env.MONGO_DB_PORT,
	options = {
		user: process.env.MONGO_DB_USERNAME,
		pass: process.env.MONGO_DB_PASSWORD,
		dbName: process.env.MONGO_DB_NAME,
		useNewUrlParser: true
	};

exports.connect = function() {
    var url = `${mongoDbUrl}?authSource=` + process.env.MONGO_DB_NAME;
	mongoose.connect(url, options);

	mongoose.connection.on('connected', function() {
	    console.log(`Mongoose default connection is open to ${mongoDbUrl}`);
	});

    mongoose.connection.on('error', function(err) {
        console.log(`Mongoose default connection has occured ${err} error`);
    });

    mongoose.connection.on('disconnected', function() {
        console.log(`Mongoose default connection is disconnected`);
    });

    process.on('SIGINT', function() {
        mongoose.connection.close(function() {
            console.log(`Mongoose default connection is disconnected due to application termination`);
            process.exit(0);
        });
    });
};
