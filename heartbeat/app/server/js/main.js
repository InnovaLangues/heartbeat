"use strict";

var config = require('../config.json');

var express = require('express');
var connect = require('connect');
var cookie = require('cookie');
var session = require('express-session');
var cookieParser = require('cookie-parser');
var sessionStore = new session.MemoryStore();    
var mongoWatch = require('mongo-watch');

var app = express();    

app.use(cookieParser());
app.use(session({store: sessionStore, secret: "secret", key: 'express.sid'}));

var sio = require('socket.io').listen(app.listen(config.websocket.port));   

sio.set('authorization', function (data, accept) {
    // check if there's a cookie header
    if (data.headers.cookie) {
        // if there is, parse the cookie
        var rawCookies = cookie.parse(data.headers.cookie);

        data.sessionID = cookieParser.signedCookie(rawCookies['express.sid'],'secret');

		console.log(data.sessionID);

        // it checks if the session id is unsigned successfully
        if (data.sessionID == rawCookies['express.sid']) {
            accept('cookie is invalid', false);
        }
    } else {
       // if there isn't, turn down the connection with a message
       // and leave the function.
       return accept('No cookie transmitted.', false);
    }
    // accept the incoming connection
    accept(null, true);
});    

sio.sockets.on('connection', function (socket) {

    console.log('A socket with sessionID ' + socket.request.sessionID + ' connected!');  

	var watcher = new mongoWatch({parser: 'pretty'});
	watcher.watch('heartbeat.ServerData', function(event) {
		socket.volatile.emit('notification', event.o);
		console.log('Something changed : ');

	});

    socket.on('disconnect', function() {
    	console.log('Disconnected')
    });
});


