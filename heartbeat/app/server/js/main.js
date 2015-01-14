"use strict";

var config = require('../config.json');

var express = require('express');
var connect = require('connect');
var cookie = require('cookie');
var session = require('express-session');
var cookieParser = require('cookie-parser');
var sessionStore = new session.MemoryStore();    

var app = express();    

//Use morgan instead
//app.use(express.logger('dev'));
app.use(cookieParser());
app.use(session({store: sessionStore, secret: "secret", key: 'express.sid'}));

//web page
app.use(express.static('public'));    

app.get('/', function(req, res) {
  var body = '';
  if (req.session.views) {
    ++req.session.views;
  } else {
    req.session.views = 1;
    body += '<p>First time visiting? view this page in several browsers :)</p>';
  }
  res.send(body + '<p>viewed <strong>' + req.session.views + '</strong> times.</p>');
});    

var sio = require('socket.io').listen(app.listen(3000));   

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

    //Replace with mongowatch
    
    console.log('A socket with sessionID ' + socket.request.sessionID + ' connected!');
    // it sets data every 5 seconds
    var handle = setInterval(function() {
        sessionStore.get(socket.request.sessionID, function (err, data) {
            if (err || !data) {
                console.log('no session data yet');
            } else {
                socket.emit('views', data);
            }
        });
    }, 5000);    

    socket.on('disconnect', function() {
        clearInterval(handle);
    });
});


