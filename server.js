/**
 * Created by amitavroy on 26/02/17.
 */
var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);
io.on('connection', function (socket) {
  console.log('Client connected');
  var redisClient = redis.createClient();

  redisClient.subscribe('message');
  redisClient.subscribe('usr_image_uploaded');

  redisClient.on("message", function (channel, message) {
    // console.log(channel, message);
    socket.emit(channel, message);
  });

  redisClient.on('disconnect', function () {
    redisClient.quit();
  });

});