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
                paintCanvas(JSON.parse(e.data))
            }

            function sendNewPixel(){
                const x = document.getElementById("x").value
                const y = document.getElementById("y").value
                const color = document.getElementById("chosenColor").value
                const res = {
                    "x" : x,
                    "y" : y,
                    "color" : color
                }
                console.log(res)
                conn.send(JSON.stringify(res));
                paintCanvas(res);
            }

            function paintCanvas(pixel){
                const canvas = document.getElementById("res");
                const context = canvas.getContext("2d")
                console.log(pixel.x)
                context.fillStyle = pixel.color || '#000';
                context.fillRect(pixel.x,pixel.y,1,1)
            }
        </script>
    </head>
    <body>
        <input type="color" id="chosenColor">
        <input type="number" id="x">
        <input type="number" id="y">
        <button onclick="sendNewPixel()">Send pixel!</button>

        <div>
            <canvas id="res" height="700px" width="1000px"></canvas>
        </div>

    </body>
</html>