#!/usr/bin/env node

// Load config params to process.env
require('dotenv').config()

let express    = require('express'),
	app        = express(),
	port       = process.env.APP_PORT || 3000,
	mongoDb    = require('./app/mongoDb'),
	auth       = require('./app/auth')

// Setup CORS to grant access to frontend website
app.use(function(req, res, next) {
	let allowedOrigins = [process.env.APP_FRONTEND_SITE, process.env.APP_ADMIN_SITE],
		origin = req.headers.origin

	if(origin && allowedOrigins.indexOf(origin) > -1) {
	   res.setHeader('Access-Control-Allow-Origin', origin)
	}
	res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization')
	res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')

  if (req.method === 'OPTIONS') {
  	res.sendStatus(200)
  } else {
  	next()
  }
});

// Parse JSON data in requests
app.use(express.json())

// Run middleware
app.all('*', auth.verify)

mongoDb.connect()

// Create and setup routes
let routePath = './app/routes',
	index     = require(routePath + '/index'),
	blogs     = require(routePath + '/blogs'),
	images    = require(routePath + '/images'),
	profiles  = require(routePath + '/profiles'),
    projects  = require(routePath + '/projects'),
    users     = require(routePath + '/users')

app.use('/',         index)
app.use('/blogs',    blogs)
app.use('/images',   images)
app.use('/profiles', profiles)
app.use('/projects', projects)
app.use('/users',    users)

// Start server
app.listen(port)
console.log('Server started on port ' + port)
