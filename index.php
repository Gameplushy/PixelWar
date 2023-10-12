<!DOCTYPE html>
<html>
    <head>
        <title>PixelWar WebSocket testing</title>
        <script>
            var conn = new WebSocket('ws://localhost:8080');
            conn.onopen = function(e) {
                console.log("Connection established!");
            };

            conn.onmessage = function(e) {
                console.log(e.data);
            }

            function hello(){
                conn.send("Hi!");
            }

        </script>
    </head>
    <body>
        <input type="color" id="chosenColor">
        <input type="number" id="x">
        <input type="number" id="y">
        <button onclick="hello()">Send pixel!</button>
        <div>
            <canvas id="res" height="700px" width="1000px"></canvas>
        </div>

    </body>
</html>